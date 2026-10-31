<?php

declare(strict_types=1);

namespace App\Entity\Brand;

interface BrandAwareInterface
{
    public function getBrand(): ?BrandInterface;

    public function setBrand(?BrandInterface $brand): void;
}
