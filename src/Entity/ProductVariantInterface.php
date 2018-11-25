<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Sylius\Component\Core\Model\ProductVariantInterface as BaseProductVariantInterface;

interface ProductVariantInterface extends BaseProductVariantInterface
{
    /**
     * @return CatalogPromotionGroup|null
     */
    public function getCatalogPromotionGroup(): ?CatalogPromotionGroupInterface;

    /**
     * @param CatalogPromotionGroup|null $catalogPromotionGroup
     */
    public function setCatalogPromotionGroup(?CatalogPromotionGroupInterface $catalogPromotionGroup): void;
}
