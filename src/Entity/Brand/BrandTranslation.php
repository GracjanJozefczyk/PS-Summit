<?php

declare(strict_types=1);

namespace App\Entity\Brand;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Resource\Model\AbstractTranslation;

#[ORM\Entity]
#[ORM\Table(name: 'app_brand_translation')]
class BrandTranslation extends AbstractTranslation implements BrandTranslationInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected ?int $id = null;

    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    protected ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
