<?php

declare(strict_types=1);

namespace App\Entity\Product;

use App\Entity\Brand\Brand;
use App\Entity\Brand\BrandAwareInterface;
use App\Entity\Brand\BrandInterface;
use Doctrine\ORM\Mapping as ORM;
use Sylius\AdyenPlugin\Entity\CommodityCodeAwareInterface;
use Sylius\AdyenPlugin\Entity\CommodityCodeAwareTrait;
use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;
use Sylius\Component\Product\Model\ProductVariantTranslationInterface;
use Sylius\MolliePlugin\Entity\ProductVariantInterface;
use Sylius\MolliePlugin\Entity\RecurringProductVariantTrait;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_product_variant')]
class ProductVariant extends BaseProductVariant implements ProductVariantInterface, CommodityCodeAwareInterface, BrandAwareInterface
{
    use RecurringProductVariantTrait, CommodityCodeAwareTrait;

    #[ORM\ManyToOne(targetEntity: Brand::class)]
    #[ORM\JoinColumn(name: 'brand_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    protected ?BrandInterface $brand = null;

    public function getBrand(): ?BrandInterface
    {
        return $this->brand;
    }

    public function setBrand(?BrandInterface $brand): void
    {
        $this->brand = $brand;
    }

    protected function createTranslation(): ProductVariantTranslationInterface
    {
        return new ProductVariantTranslation();
    }
}
