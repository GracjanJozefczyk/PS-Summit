<?php

declare(strict_types=1);

namespace App\Form\Type\Brand;

use Sylius\Bundle\CoreBundle\Form\Type\ImageType;

final class BrandImageType extends ImageType
{
    public function getBlockPrefix(): string
    {
        return 'app_brand_image';
    }
}
