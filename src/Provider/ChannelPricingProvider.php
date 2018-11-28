<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Provider;

use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

class ChannelPricingProvider
{
    public function provideForProductVariant(ChannelInterface $channel, ProductVariantInterface $productVariant): ChannelPricingInterface
    {
        return $productVariant->getChannelPricingForChannel($channel);
    }
}
