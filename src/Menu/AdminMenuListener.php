<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event)
    {
        $marketingMenu = $event->getMenu()->getChild('marketing');

        $marketingMenu
            ->addChild('catalog_promotions', ['route' => 'app_admin_catalog_promotion_index'])
            ->setLabel('locastic_sylius_catalog_promotion_plugin.ui.admin.catalog');
    }
}

