<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Sylius\Component\Core\Model\ProductVariantInterface as BaseProductVariantInterface;

interface ProductVariantInterface extends BaseProductVariantInterface
{
    /**
     * @return CatalogPromotionGroup|null
     */
    public function getCatalogPromotionGroup(): ?CatalogPromotionGroup;

    /**
     * @param CatalogPromotionGroup|null $catalogPromotionGroup
     */
    public function setCatalogPromotionGroup(?CatalogPromotionGroup $catalogPromotionGroup): void;
}