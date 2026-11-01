<?php

declare(strict_types=1);

namespace App\Doctrine\ORM\QueryExtension\Shop\Brand;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Brand\BrandInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ApiBundle\SectionResolver\ShopApiSection;
use Sylius\Bundle\ApiBundle\Serializer\ContextKeys;
use Sylius\Bundle\CoreBundle\SectionResolver\SectionProviderInterface;
use Webmozart\Assert\Assert;

final readonly class ChannelBasedExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    public function __construct(private SectionProviderInterface $sectionProvider)
    {
    }

    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        ?Operation $operation = null,
        array $context = [],
    ): void {
        $this->applyCondition($queryBuilder, $queryNameGenerator, $resourceClass, $context);
    }

    public function applyToItem(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        array $identifiers,
        ?Operation $operation = null,
        array $context = [],
    ): void {
        $this->applyCondition($queryBuilder, $queryNameGenerator, $resourceClass, $context);
    }

    private function applyCondition(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        array $context,
    ): void {
        if (!is_a($resourceClass, BrandInterface::class, true)) {
            return;
        }

        if (!$this->sectionProvider->getSection() instanceof ShopApiSection) {
            return;
        }

        Assert::keyExists($context, ContextKeys::CHANNEL);

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $channelParameterName = $queryNameGenerator->generateParameterName('channel');

        $queryBuilder
            ->andWhere(sprintf(':%s MEMBER OF %s.channels', $channelParameterName, $rootAlias))
            ->setParameter($channelParameterName, $context[ContextKeys::CHANNEL])
        ;
    }
}
