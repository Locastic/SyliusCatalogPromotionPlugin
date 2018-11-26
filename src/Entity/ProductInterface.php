<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Sylius\Component\Core\Model\ProductInterface as BaseProductInterface;

interface ProductInterface extends BaseProductInterface
{
    public function getAppliedCatalogPromotionGroup(): ?CatalogPromotionGroupInterface;

    public function setAppliedCatalogPromotionGroup(?CatalogPromotionGroupInterface $catalogPromotionGroup): void;

    public function getAppliedCatalogPromotion(): ?CatalogPromotionInterface;
}