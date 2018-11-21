<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Util;

use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingInterface;

class ChannelPricingPercentageDiscountCalculator implements ChannelPricingCatalogPromotionCalculatorInterface
{
    public function provide(ChannelPricingInterface $channelPricing): ?int
    {
        if (!$channelPricing->getAppliedCatalogPromotion()) {
            return 0;
        }

        $discountQuote = 1 - ($channelPricing->getPrice() / $channelPricing->getOriginalPrice());

        return (int) ($discountQuote * 100);
    }
}