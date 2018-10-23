<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Applicator;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingInterface;

interface CatalogPromotionApplicatorInterface
{
    /**
     * @param ChannelPricingInterface $channelPricing
     * @param CatalogPromotionInterface $catalogPromotion
     */
    public function apply(ChannelPricingInterface $channelPricing, CatalogPromotionInterface $catalogPromotion): void;
}