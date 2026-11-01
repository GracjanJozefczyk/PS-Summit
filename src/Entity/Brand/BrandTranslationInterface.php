<?php

declare(strict_types=1);

namespace App\Entity\Brand;

use Sylius\Resource\Model\ResourceInterface;
use Sylius\Resource\Model\TranslationInterface;

interface BrandTranslationInterface extends ResourceInterface, TranslationInterface
{
    public function getDescription(): ?string;

    public function setDescription(?string $description): void;
}
