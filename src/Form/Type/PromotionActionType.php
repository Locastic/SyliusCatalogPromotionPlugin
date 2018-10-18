<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Form\Type;

use Locastic\SyliusCatalogPromotionPlugin\Entity\PromotionActionInterface;
use Sylius\Bundle\PromotionBundle\Form\Type\AbstractConfigurablePromotionElementType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

final class PromotionActionType extends AbstractConfigurablePromotionElementType
{
    public function buildForm(FormBuilderInterface $builder, array $options = []): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('type', PromotionActionChoiceType::class, [
                'label' => 'locastic.form.catalog_promotion_action.type',
                'attr' => [
                    'data-form-collection' =>'update',
                ],
            ])
        ;
    }

    public function getBlockPrefix()
    {
        return 'locastic_sylius_catalog_promotion_plugin_action';
    }
}