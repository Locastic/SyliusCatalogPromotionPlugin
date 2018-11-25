<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

trait CatalogPromotionGroupAwareTrait
{
    /** @var CatalogPromotionGroup */
    protected $catalogPromotionGroup;

    public function getCatalogPromotionGroup(): ?CatalogPromotionGroupInterface
    {
        return $this->catalogPromotionGroup;
    }

    public function setCatalogPromotionGroup(?CatalogPromotionGroupInterface $catalogPromotionGroup): void
    {
        $this->catalogPromotionGroup = $catalogPromotionGroup;
    }
}
