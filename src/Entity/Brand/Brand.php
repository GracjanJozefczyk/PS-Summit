<?php

declare(strict_types=1);

namespace App\Entity\Brand;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sylius\Resource\Model\TimestampableTrait;
use Sylius\Resource\Model\ToggleableTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'app_brand')]
#[UniqueEntity(fields: ['code'], groups: ['sylius'])]
class Brand implements BrandInterface
{
    use TimestampableTrait;
    use ToggleableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'code', type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank(groups: ['sylius'])]
    #[Assert\Length(max: 255, groups: ['sylius'])]
    #[Assert\Regex(pattern: '/^[\w-]*$/', groups: ['sylius'])]
    private ?string $code = null;

    #[ORM\Column(name: 'name', type: 'string', length: 255)]
    #[Assert\NotBlank(groups: ['sylius'])]
    #[Assert\Length(max: 255, groups: ['sylius'])]
    private ?string $name = null;

    /** @var \DateTimeInterface|null */
    #[ORM\Column(name: 'created_at', type: 'datetime')]
    #[Gedmo\Timestampable(on: 'create')]
    protected $createdAt;

    /** @var \DateTimeInterface|null */
    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: true)]
    #[Gedmo\Timestampable(on: 'update')]
    protected $updatedAt;

    /** @var bool */
    #[ORM\Column(name: 'enabled', type: 'boolean')]
    protected $enabled = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function __toString(): string
    {
        return (string) $this->name;
    }
}
