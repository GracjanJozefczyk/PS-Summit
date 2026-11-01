<?php

declare(strict_types=1);

namespace App\Entity\Brand;

use Sylius\Component\Channel\Model\ChannelsAwareInterface;
use Sylius\Component\Core\Model\ImagesAwareInterface;
use Sylius\Resource\Model\CodeAwareInterface;
use Sylius\Resource\Model\ResourceInterface;
use Sylius\Resource\Model\TimestampableInterface;
use Sylius\Resource\Model\ToggleableInterface;
use Sylius\Resource\Model\TranslatableInterface;

interface BrandInterface extends
    ResourceInterface,
    CodeAwareInterface,
    TimestampableInterface,
    ToggleableInterface,
    ChannelsAwareInterface,
    ImagesAwareInterface,
    TranslatableInterface
{
    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    public function getTranslation(?string $locale = null): BrandTranslationInterface;
}
