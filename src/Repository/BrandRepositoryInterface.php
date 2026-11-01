<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Brand\BrandInterface;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;

interface BrandRepositoryInterface extends RepositoryInterface
{
    public function findEnabledByChannel(ChannelInterface $channel): array;

    public function findOneEnabledByChannelAndCode(ChannelInterface $channel, string $code): ?BrandInterface;
}
