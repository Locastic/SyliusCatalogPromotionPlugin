<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PromotionActionChoiceType extends AbstractType
{
    private $actions;

    public function __construct(/*array $actions = []*/)
    {
//        $this->actions = $actions;
        $this->actions = [
            'dis promo static',
            'dis promo perca',
        ];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => array_flip($this->actions),
        ]);
    }


    public function getParent()
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix()
    {
        return 'locastic_sylius_catalog_promotion_plugin_action_choice';
    }
}