<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Sylius\Component\Core\Model\ChannelPricingInterface as BaseChannelPricingInterface;

interface ChannelPricingInterface extends BaseChannelPricingInterface
{
    public function applyCatalogPromotionAction(CatalogPromotionInterface $catalogPromotion, int $promoAmount): bool;

    public function detachCatalogPromotionAction(CatalogPromotionInterface $catalogPromotion, int $promoAmount): bool;

    public function getCatalogPromotionAmount(): int;

    public function addCatalogPromotionAmount(int $catalogPromoAmount): bool;

}