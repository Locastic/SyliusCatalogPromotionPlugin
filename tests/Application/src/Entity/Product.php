<?php

declare(strict_types=1);

namespace Tests\Acme\SyliusExamplePlugin\Application\src\Entity;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionGroupAwareTrait;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

class Product
{
    use CatalogPromotionGroupAwareTrait;

    public function getAppliedCatalogPromotion(): ?CatalogPromotionInterface
    {
        return (null !== $this->getAppliedCatalogPromotionGroup()) ? $this->getAppliedCatalogPromotionGroup()->getCatalog() : null;
    }

    public function getPromotionDiscounts(ChannelInterface $channel)
    {
        $promotionDiscounts = $this->getVariants()->map(function (ProductVariantInterface $productVariant) use ($channel) {
            /** @var ChannelPricingInterface $channelPricing */
            $channelPricing = $productVariant->getChannelPricingForChannel($channel);

            return $channelPricing->getDiscount();
        });

        return $promotionDiscounts;
    }
}