<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Checker\Eligibility;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionRule;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ProductVariantInterface;
use Locastic\SyliusCatalogPromotionPlugin\Promotion\Checker\Rule\RuleCheckerInterface;
use Locastic\SyliusCatalogPromotionPlugin\Provider\CatalogPromotionProvider;
use Sylius\Component\Registry\ServiceRegistryInterface;

class CatalogPromotionEligibilityChecker implements CatalogPromotionEligibilityCheckerInterface
{
    /**
     * @var CatalogPromotionProvider
     */
    private $catalogPromotionProvider;
    
    /**
     * @var ServiceRegistryInterface
     */
    private $ruleRegistry;

    public function __construct(
        CatalogPromotionProvider $catalogPromotionProvider,
        ServiceRegistryInterface $ruleRegistry
    ) {
        $this->catalogPromotionProvider = $catalogPromotionProvider;
        $this->ruleRegistry = $ruleRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function isEligible(CatalogPromotionInterface $catalogPromotion, ProductVariantInterface $productVariant): bool
    {
        foreach ($catalogPromotion->getRules() as $rule) {
            if (!$this->isEligibleToRule($productVariant, $rule)) {
                return false;
            }
        }

        return true;
    }

    private function isEligibleToRule(ProductVariantInterface $productVariant, CatalogPromotionRule $rule)
    {
        /** @var RuleCheckerInterface $ruleChecker */
        $ruleChecker = $this->ruleRegistry->get($rule->getType());

        return $ruleChecker->isEligible($productVariant, $rule);
    }

}