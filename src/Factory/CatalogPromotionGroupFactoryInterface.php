<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Factory;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionGroupInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

interface CatalogPromotionGroupFactoryInterface extends FactoryInterface
{
    public function createForCatalogPromotion(CatalogPromotionInterface $catalogPromotionGroup): CatalogPromotionGroupInterface;
}
