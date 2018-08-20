<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

trait CatalogPromotionGroupAwareTrait
{
    /** @var CatalogPromotionGroup */
    protected $catalogPromotionGroup;

    public function getCatalogPromotionGroup(): ?CatalogPromotionGroup
    {
        return $this->catalogPromotionGroup;
    }

    public function setCatalogPromotionGroup(?CatalogPromotionGroup $catalogPromotionGroup): void
    {
        $this->catalogPromotionGroup = $catalogPromotionGroup;
    }
}
