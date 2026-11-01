<?php

declare(strict_types=1);

namespace App\Entity\Brand;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Resource\Model\TimestampableTrait;
use Sylius\Resource\Model\ToggleableTrait;
use Sylius\Resource\Model\TranslatableTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'app_brand')]
#[UniqueEntity(fields: ['code'], groups: ['sylius'])]
class Brand implements BrandInterface
{
    use TimestampableTrait;
    use ToggleableTrait;
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
        getTranslation as private doGetTranslation;
    }

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

    /** @var Collection<array-key, ImageInterface> */
    #[ORM\OneToMany(targetEntity: BrandImage::class, mappedBy: 'owner', cascade: ['all'], orphanRemoval: true)]
    #[ORM\OrderBy(['id' => 'ASC'])]
    #[Assert\Valid]
    protected Collection $images;

    /** @var Collection<array-key, ChannelInterface> */
    #[ORM\ManyToMany(targetEntity: ChannelInterface::class)]
    #[ORM\JoinTable(name: 'app_brand_channels')]
    #[ORM\JoinColumn(name: 'brand_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'channel_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    #[ORM\OrderBy(['id' => 'ASC'])]
    protected Collection $channels;

    public function __construct()
    {
        $this->initializeTranslationsCollection();
        $this->images = new ArrayCollection();
        $this->channels = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->getTranslation()->getDescription();
    }

    public function setDescription(?string $description): void
    {
        $this->getTranslation()->setDescription($description);
    }

    public function getImages(): Collection
    {
        return $this->images;
    }

    public function getImagesByType(string $type): Collection
    {
        return $this->images->filter(fn (ImageInterface $image): bool => $type === $image->getType());
    }

    public function hasImages(): bool
    {
        return !$this->images->isEmpty();
    }

    public function hasImage(ImageInterface $image): bool
    {
        return $this->images->contains($image);
    }

    public function addImage(ImageInterface $image): void
    {
        $image->setOwner($this);
        $this->images->add($image);
    }

    public function removeImage(ImageInterface $image): void
    {
        if ($this->hasImage($image)) {
            $image->setOwner(null);
            $this->images->removeElement($image);
        }
    }

    public function getChannels(): Collection
    {
        return $this->channels;
    }

    public function hasChannel(ChannelInterface $channel): bool
    {
        return $this->channels->contains($channel);
    }

    public function addChannel(ChannelInterface $channel): void
    {
        if (!$this->hasChannel($channel)) {
            $this->channels->add($channel);
        }
    }

    public function removeChannel(ChannelInterface $channel): void
    {
        $this->channels->removeElement($channel);
    }

    public function getTranslation(?string $locale = null): BrandTranslationInterface
    {
        /** @var BrandTranslationInterface $translation */
        $translation = $this->doGetTranslation($locale);

        return $translation;
    }

    protected function createTranslation(): BrandTranslationInterface
    {
        return new BrandTranslation();
    }
}
