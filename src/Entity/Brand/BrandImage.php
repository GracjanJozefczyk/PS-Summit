<?php

declare(strict_types=1);

namespace App\Entity\Brand;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Bundle\CoreBundle\Validator\Constraints\AllowedImageMimeTypes;
use Sylius\Component\Core\Model\Image;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'app_brand_image')]
class BrandImage extends Image implements BrandImageInterface
{
    /** @var \SplFileInfo|null */
    #[Assert\Image(
        maxSize: '10M',
        groups: ['sylius'],
    )]
    #[AllowedImageMimeTypes(groups: ['sylius'])]
    protected $file;

    /** @var BrandInterface|null */
    #[ORM\ManyToOne(targetEntity: Brand::class, inversedBy: 'images')]
    #[ORM\JoinColumn(name: 'owner_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    protected $owner;
}
