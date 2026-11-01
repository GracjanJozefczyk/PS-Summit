<?php

declare(strict_types=1);

namespace App\Form\Type\Brand;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

final class BrandTranslationType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder->add('description', TextareaType::class, [
            'required' => false,
            'label' => 'sylius.form.product.description',
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'app_brand_translation';
    }
}
