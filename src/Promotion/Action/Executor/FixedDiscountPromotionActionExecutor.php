<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Executor;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionGroupInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingInterface;
use Locastic\SyliusCatalogPromotionPlugin\Util\ChannelPricingCatalogPromotionCalculatorInterface;

class FixedDiscountPromotionActionExecutor implements ActionExecutorInterface
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
        $channelCode = $configuration[$channelPricing->getChannelCode()] ?? null;
        if (null === $channelCode) {
            return;
        }
        $promoAmount = $channelCode['amount'];

        $channelPricing->applyCatalogPromotionAction($promotionGroup->getCatalog(), $promoAmount);
        $channelPricing->setDiscount(
            $this->promotionCalculator->provide($channelPricing)
        );
    }
}
