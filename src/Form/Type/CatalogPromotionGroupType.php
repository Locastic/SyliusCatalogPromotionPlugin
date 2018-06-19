<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Form\Type;

use Sylius\Bundle\PromotionBundle\Form\Type\AbstractConfigurablePromotionElementType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class CatalogPromotionGroupType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Fixed Amount',
                    'Percentage based'
                ],
            ])
        ;
    }

    public function getBlockPrefix()
    {
        return 'locastic_catalog_promotion_group';
    }
}
