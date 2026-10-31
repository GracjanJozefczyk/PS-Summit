<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Brand\BrandInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface as BaseProductRepositoryInterface;

interface ProductRepositoryInterface extends BaseProductRepositoryInterface
{
    public function createShopListByBrandQueryBuilder(
        ChannelInterface $channel,
        BrandInterface $brand,
        string $locale,
        array $sorting = [],
    ): QueryBuilder;
}
