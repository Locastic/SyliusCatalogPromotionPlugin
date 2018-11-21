<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Executor;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionGroupInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingInterface;
use Locastic\SyliusCatalogPromotionPlugin\Util\ChannelPricingCatalogPromotionCalculatorInterface;

class PercentageDiscountPromotionActionExecutor implements ActionExecutorInterface
{
    /**
     * @var ChannelPricingCatalogPromotionCalculatorInterface
     */
    private $promotionCalculator;

    public function __construct(ChannelPricingCatalogPromotionCalculatorInterface $promotionCalculator)
    {
        $this->promotionCalculator = $promotionCalculator;
    }

    public function execute(ChannelPricingInterface $channelPricing, array $configuration, CatalogPromotionGroupInterface $promotionGroup): void
    {
        $promoAmount = $this->calculatePromotionAmount($channelPricing->getPrice(), $configuration['percentage']);
        $channelPricing->applyCatalogPromotionAction($promotionGroup->getCatalog(), $promoAmount);
        $channelPricing->setDiscount(
            $this->promotionCalculator->provide($channelPricing)
        );
    }

    private function calculatePromotionAmount(int $channelPrice, float $promoPercentage): int
    {
        return (int) round($channelPrice * $promoPercentage);
    }
}
