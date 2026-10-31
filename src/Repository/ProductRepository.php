<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Brand\BrandInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository as BaseProductRepository;
use Sylius\Component\Core\Model\ChannelInterface;

final class ProductRepository extends BaseProductRepository implements ProductRepositoryInterface
{
    public function createShopListByBrandQueryBuilder(
        ChannelInterface $channel,
        BrandInterface $brand,
        string $locale,
        array $sorting = [],
    ): QueryBuilder {
        $brandSubQuery = $this->createQueryBuilder('brandProduct')
            ->select('brandProduct.id')
            ->innerJoin('brandProduct.variants', 'brandVariant')
            ->andWhere('brandVariant.brand = :brand')
            ->andWhere('brandVariant.enabled = :enabled')
        ;

        $queryBuilder = $this->createQueryBuilder('o')
            ->addSelect('translation')
            ->innerJoin('o.translations', 'translation', 'WITH', 'translation.locale = :locale')
            ->andWhere($this->getEntityManager()->getExpressionBuilder()->in('o.id', $brandSubQuery->getDQL()))
            ->andWhere(':channel MEMBER OF o.channels')
            ->andWhere('o.enabled = :enabled')
            ->setParameter('brand', $brand)
            ->setParameter('locale', $locale)
            ->setParameter('channel', $channel)
            ->setParameter('enabled', true)
        ;

        if (isset($sorting['price'])) {
            $subQuery = $this->createQueryBuilder('m')
                ->select('min(v.position)')
                ->innerJoin('m.variants', 'v')
                ->andWhere('m.id = :product_id')
                ->andWhere('v.enabled = :enabled')
            ;

            $queryBuilder
                ->addSelect('variant')
                ->addSelect('channelPricing')
                ->innerJoin('o.variants', 'variant')
                ->innerJoin('variant.channelPricings', 'channelPricing')
                ->andWhere('channelPricing.channelCode = :channelCode')
                ->andWhere(
                    $queryBuilder->expr()->in(
                        'variant.position',
                        str_replace(':product_id', 'o.id', $subQuery->getDQL()),
                    ),
                )
                ->setParameter('channelCode', $channel->getCode())
            ;
        }

        return $queryBuilder;
    }
}
