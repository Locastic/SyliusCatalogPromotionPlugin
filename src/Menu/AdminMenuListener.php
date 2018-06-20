<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event)
    {
        $event->getMenu()
            ->getChild('marketing')
                ->addChild('catalog_promotions', [
                    'route' => 'locastic_sylius_catalog_promotion_plugin_admin_catalog_promotion_index'
                ])
                ->setLabel('locastic_sylius_catalog_promotion_plugin.ui.admin.catalog');
    }
}
