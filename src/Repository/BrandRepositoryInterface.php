<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Brand\BrandInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;

interface BrandRepositoryInterface extends RepositoryInterface
{
    public function findEnabledOrderedByName(): array;

    public function findOneEnabledByCode(string $code): ?BrandInterface;
}
