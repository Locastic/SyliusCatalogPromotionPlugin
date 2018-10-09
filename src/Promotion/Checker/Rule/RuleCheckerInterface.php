<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Checker\Rule;

use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Promotion\Model\PromotionRule;

interface RuleCheckerInterface
{
    /**
     * @param ProductVariantInterface $productVariant
     * @param array $configuration
     *
     * @return bool
     */
    public function isEligible(ProductVariantInterface $productVariant, PromotionRule $rule);
}