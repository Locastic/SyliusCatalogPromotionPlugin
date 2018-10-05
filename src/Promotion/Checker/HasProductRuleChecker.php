<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Checker;

use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Promotion\Model\PromotionRule;

class HasProductRuleChecker implements RuleCheckerInterface
{
    public function isEligible(ProductVariantInterface $productVariant, PromotionRule $rule)
    {
        return in_array($productVariant->getProduct()->getCode(), $rule->getConfiguration()['product_codes'], true);
    }
}