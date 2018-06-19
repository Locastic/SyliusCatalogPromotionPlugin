<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Form\Type;

use Sonata\CoreBundle\Form\Type\CollectionType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CatalogPromotionGroupCollectionType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('groups', CollectionType::class, [
            'entry_type' => CatalogPromotionGroupType::class,
            'entry_options' => [
                'label' => false
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }


    public function getBlockPrefix()
    {
        return 'locastic_catalog_promotion_group_collection';
    }
}
