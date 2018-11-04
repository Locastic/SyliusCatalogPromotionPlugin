<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Applicator;

use Sylius\Component\Core\Model\ChannelPricingInterface;

interface ChannelPricingPromotionApplicatorInterface
{
    public function apply(ChannelPricingInterface $channelPricing, int $promotionAmount): void;
}
