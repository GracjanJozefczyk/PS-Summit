<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Brand\BrandInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Channel\Model\ChannelInterface;

final class BrandRepository extends EntityRepository implements BrandRepositoryInterface
{
    public function findEnabledByChannel(ChannelInterface $channel): array
    {
        return $this->createEnabledInChannelQueryBuilder($channel)
            ->orderBy('o.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneEnabledByChannelAndCode(ChannelInterface $channel, string $code): ?BrandInterface
    {
        return $this->createEnabledInChannelQueryBuilder($channel)
            ->andWhere('o.code = :code')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    private function createEnabledInChannelQueryBuilder(ChannelInterface $channel): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.enabled = :enabled')
            ->andWhere(':channel MEMBER OF o.channels')
            ->setParameter('enabled', true)
            ->setParameter('channel', $channel)
            ;
    }
}
