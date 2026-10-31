<?php

declare(strict_types=1);

namespace App\Entity\Brand;

use Sylius\Resource\Model\CodeAwareInterface;
use Sylius\Resource\Model\ResourceInterface;
use Sylius\Resource\Model\TimestampableInterface;
use Sylius\Resource\Model\ToggleableInterface;

interface BrandInterface extends ResourceInterface, CodeAwareInterface, TimestampableInterface, ToggleableInterface
{
    public function getName(): ?string;

    public function setName(?string $name): void;
}
