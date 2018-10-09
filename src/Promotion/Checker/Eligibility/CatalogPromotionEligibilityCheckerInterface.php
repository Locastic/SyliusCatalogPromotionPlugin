<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Checker\Eligibility;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ProductVariantInterface;

interface CatalogPromotionEligibilityCheckerInterface
{
    /**
     * @param CatalogPromotionInterface $catalogPromotion
     * @param ProductVariantInterface $productVariant
     *
     * @return bool
     */
    public function isEligible(CatalogPromotionInterface $catalogPromotion, ProductVariantInterface $productVariant): bool;
}