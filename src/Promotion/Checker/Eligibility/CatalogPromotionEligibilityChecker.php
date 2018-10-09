<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Checker\Eligibility;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ProductVariantInterface;

class CatalogPromotionEligibilityChecker implements CatalogPromotionEligibilityCheckerInterface
{
    /**
     * {@inheritdoc}
     */
    public function isEligible(CatalogPromotionInterface $catalogPromotion, ProductVariantInterface $productVariant): bool
    {

    }
}