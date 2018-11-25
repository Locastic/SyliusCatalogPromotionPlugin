<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\Product as BaseProduct;
use Sylius\Component\Core\Model\ProductVariantInterface;

class Product extends BaseProduct implements ProductInterface
{
    use CatalogPromotionGroupAwareTrait;

    public function getAppliedCatalogPromotion(): ?CatalogPromotionInterface
    {
        return (null !== $this->getAppliedCatalogPromotionGroup()) ? $this->getAppliedCatalogPromotionGroup()->getCatalog() : null;
    }

    public function getPromotionDiscounts(ChannelInterface $channel)
    {
        $promotionDiscounts = [];

        $promotionDiscounts = $this->getVariants()->map(function (ProductVariantInterface $productVariant) use ($channel, $promotionDiscounts) {
            /** @var ChannelPricingInterface $channelPricing */
            $channelPricing = $productVariant->getChannelPricingForChannel($channel);

            return $channelPricing->getDiscount();
        });

        return $promotionDiscounts;
    }
}