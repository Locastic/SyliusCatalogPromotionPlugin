<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

trait ProductTrait
{
    /** @var CatalogPromotionGroupInterface */
    private $appliedCatalogPromotionGroup;

    public function getAppliedCatalogPromotionGroup(): ?CatalogPromotionGroupInterface
    {
        return $this->appliedCatalogPromotionGroup;
    }

    public function setAppliedCatalogPromotionGroup(?CatalogPromotionGroupInterface $catalogPromotionGroup): void
    {
        $this->appliedCatalogPromotionGroup = $catalogPromotionGroup;
    }

    public function getAppliedCatalogPromotion(): ?CatalogPromotionInterface
    {
        return (null !== $this->getAppliedCatalogPromotionGroup()) ? $this->getAppliedCatalogPromotionGroup()->getCatalog() : null;
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
