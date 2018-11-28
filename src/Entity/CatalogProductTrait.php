<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

trait CatalogProductTrait
{
    /** @var CatalogPromotionGroupInterface */
    private $catalogPromotionGroup;

    public function getCatalogPromotionGroup(): ?CatalogPromotionGroupInterface
    {
        return $this->catalogPromotionGroup;
    }

    public function setCatalogPromotionGroup(?CatalogPromotionGroupInterface $catalogPromotionGroup): void
    {
        $this->catalogPromotionGroup = $catalogPromotionGroup;
    }

    public function getCatalogPromotion(): ?CatalogPromotionInterface
    {
        return (null !== $this->getCatalogPromotionGroup()) ? $this->getCatalogPromotionGroup()->getCatalog() : null;
    }

    public function getPromotionDiscounts(ChannelInterface $channel)
    {
        return $this->getVariants()->map(function (ProductVariantInterface $productVariant) use ($channel) {
            /** @var ChannelPricingInterface $channelPricing */
            $channelPricing = $productVariant->getChannelPricingForChannel($channel);

            return $channelPricing->getDiscount();
        });
    }
}
