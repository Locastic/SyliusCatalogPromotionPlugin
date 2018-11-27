<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

interface AppliedCatalogPromotionAwareInterface
{
    public function getAppliedCatalogPromotionGroup(): ?CatalogPromotionGroupInterface;

    public function setAppliedCatalogPromotionGroup(?CatalogPromotionGroupInterface $catalogPromotionGroup): void;

    public function getAppliedCatalogPromotion(): ?CatalogPromotionInterface;
}