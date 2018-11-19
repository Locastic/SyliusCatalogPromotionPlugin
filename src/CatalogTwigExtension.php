<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin;

use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingInterface;

class CatalogTwigExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_Function('discountPercentage', [$this, 'calculateDiscountPercentage'])
        ];
    }

    public function calculateDiscountPercentage(ChannelPricingInterface $channelPricing): string
    {
        $discountPrice = $channelPricing->getPrice();
        $originalPrice = $channelPricing->getOriginalPrice();

        return ceil(100 * (1 - ($discountPrice / $originalPrice))) . '%';
    }
}