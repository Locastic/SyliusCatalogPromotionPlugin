<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CatalogPromotionTranslationType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
        ;
    }

    public function getBlockPrefix()
    {
        return 'locastic_catalog_promotion_translation';
    }
}
