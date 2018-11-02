<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Executor;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionGroupInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingInterface;

class FixedDiscountPromotionActionExecutor implements ActionExecutorInterface
{
    public function execute(ChannelPricingInterface $channelPricing, array $configuration, CatalogPromotionGroupInterface $promotionGroup): void
    {
        $channelCode = $configuration[$channelPricing->getChannelCode()] ?? null;
        if (null === $channelCode) {
            return;
        }
        $promoAmount = $channelCode['amount'];

        $channelPricing->applyCatalogPromotionAction($promotionGroup->getCatalog(), $promoAmount);
    }
}