<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Applicator;

use Sylius\Component\Core\Model\ChannelPricingInterface;

class ChannelPricingPromotionApplicator implements ChannelPricingPromotionApplicatorInterface
{
    public function apply(ChannelPricingInterface $channelPricing, int $promotionAmount): void
    {

    }
}