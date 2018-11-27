<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

interface ChannelPricingAwareInterface
{
    public function applyCatalogPromotionAction(CatalogPromotionInterface $catalogPromotion, int $promoAmount): void;

    public function detachCatalogPromotionAction(): void;

    public function getAppliedCatalogPromotion(): ?CatalogPromotionInterface;

    public function setDiscount(?int $discount): void;

    public function getDiscount(): ?int;
}
