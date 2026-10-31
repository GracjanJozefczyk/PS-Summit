<?php

declare(strict_types=1);

namespace App\Form\Extension;

use Sylius\Bundle\ProductBundle\Form\Type\ProductVariantType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductVariantTypeExtension extends AbstractTypeExtension
{
    public function __construct(private readonly string $brandClass)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('brand', EntityType::class, [
            'class' => $this->brandClass,
            'choice_label' => 'name',
            'required' => false,
            'placeholder' => 'app.form.product_variant.no_brand',
            'label' => 'app.form.product_variant.brand',
        ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [ProductVariantType::class];
    }
}
