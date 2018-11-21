<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Util;

use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingInterface;

interface ChannelPricingCatalogPromotionCalculatorInterface
{
    public function provide(ChannelPricingInterface $channelPricing): ?int;
}