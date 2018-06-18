<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\FormBuilderInterface;

class CatalogPromotionType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('translations', ResourceTranslationsType::class, [
                'entry_type' => CatalogPromotionTranslationType::class,
            ])
        ;
    }

    public function getBlockPrefix()
    {
        return 'app_catalog_promotion';
    }
}
