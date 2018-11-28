<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

interface CatalogPromotionAwareInterface
{
    public function getCatalogPromotionGroup(): ?CatalogPromotionGroupInterface;

    public function setCatalogPromotionGroup(?CatalogPromotionGroupInterface $catalogPromotionGroup): void;

    public function getCatalogPromotion(): ?CatalogPromotionInterface;
}