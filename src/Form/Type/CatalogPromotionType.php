<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Form\Type;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class CatalogPromotionType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('translations', ResourceTranslationsType::class, [
                'entry_type' => CatalogPromotionTranslationType::class,
            ])
            ->add('startsAt', DateTimeType::class, [
                'label' => 'sylius.form.promotion.starts_at',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => false,
            ])
            ->add('endsAt', DateTimeType::class, [
                'label' => 'sylius.form.promotion.ends_at',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => false,
            ])
            ->add('priority', IntegerType::class, [
                'required' => false,
                'label' => 'locastic_catalog_promotion.form.catalog_promotion.position',
            ])
            ->add('channels', ChannelChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'label' => 'sylius.form.promotion.channels',
            ])
//            ->add('promotionGroups', CatalogPromotionGroupCollectionType::class, [
//                'entry_type' => CatalogPromotionType::class,
//                'label' => 'sylius.form.promotion.rules',
//            ])
            ->addEventSubscriber(new AddCodeFormSubscriber())
        ;
    }

    public function getBlockPrefix()
    {
        return 'locastic_catalog_promotion';
    }
}
