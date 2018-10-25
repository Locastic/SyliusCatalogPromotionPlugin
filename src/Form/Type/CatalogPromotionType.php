<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Form\Type;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
                'label' => 'locastic_catalog_promotion.form.catalog_promotion.starts_at',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => true,
            ])
            ->add('endsAt', DateTimeType::class, [
                'label' => 'locastic_catalog_promotion.form.catalog_promotion.ends_at',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => true,
            ])
            ->add('priority', IntegerType::class, [
                'required' => true,
                'label' => 'locastic_catalog_promotion.form.catalog_promotion.position',
            ])
            ->add('channels', ChannelChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'label' => 'sylius.form.promotion.channels',
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => CatalogBannerImageType::class,
                'allow_add' => false,
                'allow_delete' => false,
                'by_reference' => false,
                'label' => 'locastic.form.catalog_banner_images'
            ])
            ->addEventSubscriber(new AddCodeFormSubscriber())
        ;
    }

    public function getBlockPrefix()
    {
        return 'locastic_catalog_promotion';
    }
}
