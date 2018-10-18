<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\DependencyInjection\Compiler;

use Sylius\Bundle\ResourceBundle\Form\Registry\FormTypeRegistryInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class RegisterCatalogPromotionActionsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$this->hasContainerRegisteredPromoActionRegistries($container)) {
            return;
        }

        /** @var Definition $promotionActionRegistry */
        $promotionActionRegistry = $container->getDefinition('locastic_sylius_catalog_promotion_plugin.registry_promotion_action_executor');
        /** @var Definition $promotionActionFormRegistry */
        $promotionActionFormRegistry = $container->getDefinition('locastic_sylius_catalog_promotion_plugin.form_registry.promotion_action_executor');

        $promotionActionExecutorsTypeToLabelMap = [];
        $taggedServiceActionExecutors = $container->findTaggedServiceIds('locastic.catalog_promotion_action_executor');

        foreach ($taggedServiceActionExecutors as $id => $attributes) {
            if (!isset($attributes[0]['type'], $attributes[0]['label'], $attributes[0]['form_type'])) {
                throw new \InvalidArgumentException('Tagged promotion action `' . $id . '` needs to have `type`, `form_type` and `label` attributes.');
            }

            $promotionActionTypeToLabelMap[$attributes[0]['type']] = $attributes[0]['label'];
            $promotionActionRegistry->addMethodCall('register', [$attributes[0]['type'], new Reference($id)]);
            $promotionActionFormRegistry->addMethodCall('add', [$attributes[0]['type'], 'default', $attributes[0]['form_type']]);
            /*?!??!?!?!!? */
        }

        $container->setParameter('locastic_sylius_catalog_promotion_plugin.promotion_actions', $promotionActionTypeToLabelMap);
    }

    private function hasContainerRegisteredPromoActionRegistries(ContainerBuilder $container)
    {
        return ($container->has('locastic_sylius_catalog_promotion_plugin.registry_promotion_action_executor') &&
                $container->has('locastic_sylius_catalog_promotion_plugin.form_registry.promotion_action_executor')
        );
    }
}