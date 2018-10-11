<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Applicator;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;

interface CatalogPromotionApplicatorInterface
{
    /**
     * @param ChannelPricingInterface $channelPricing
     * @param CatalogPromotionInterface $catalogPromotion
     */
    public function apply(ChannelPricingInterface $channelPricing, CatalogPromotionInterface $catalogPromotion): void;

    /**
     * @param ChannelPricingInterface $channelPricing
     * @param CatalogPromotionInterface $catalogPromotion
     */
    public function revert(ChannelPricingInterface $channelPricing, CatalogPromotionInterface $catalogPromotion): void;
}