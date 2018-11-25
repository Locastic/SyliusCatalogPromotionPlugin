<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

trait CatalogPromotionGroupAwareTrait
{
    /** @var CatalogPromotionGroupInterface */
    private $appliedCatalogPromotionGroup;

    public function getAppliedCatalogPromotionGroup(): ?CatalogPromotionGroupInterface
    {
        return $this->appliedCatalogPromotionGroup;
    }

    public function setAppliedCatalogPromotionGroup(?CatalogPromotionGroupInterface $catalogPromotionGroup): void
    {
        $this->appliedCatalogPromotionGroup = $catalogPromotionGroup;
    }
}
