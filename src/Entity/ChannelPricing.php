<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Sylius\Component\Core\Model\ChannelPricing as BaseChannelPricing;

class ChannelPricing extends BaseChannelPricing implements ChannelPricingInterface
{
    /**
     * @var CatalogPromotionInterface
     */
    private $appliedCatalogPromotion;

    /**
     * @var int
     */
    private $catalogPromotionPrice = 0;

    public function applyCatalogPromotionAction(CatalogPromotionInterface $catalogPromotion, int $promoDiscount): void
    {
        if ($this->hasAppliedCatalogPromotion()) {
            //Check if appliance has to be repeated if job tries to apply same catalog promo
            if (!$this->hasHigherPriorityThenPreviouslyApplied($catalogPromotion)) {
                return;
            }

            $this->detachCatalogPromotionAction();
            if (!$this->hasAppliedCatalogPromotion()) {
                return;
            }
        }

        $catalogPrice = $this->providePositiveDiscountedPriceOrZero($promoDiscount);

        $this->setCatalogPromotionPrice($catalogPrice);
        $this->appliedCatalogPromotion = $catalogPromotion;

        return;
    }

    public function detachCatalogPromotionAction(): void
    {
        if (is_null($this->appliedCatalogPromotion)) {
            return;
        }

        $this->setCatalogPromotionPrice(0);
        $this->appliedCatalogPromotion = null;

        return;
    }

    public function getCatalogPromotionPrice(): int
    {
        return $this->catalogPromotionPrice;
    }

    public function setCatalogPromotionPrice(int $catalogPromoPrice): void
    {
        $this->catalogPromotionPrice = $catalogPromoPrice;
    }

    public function getPromotionDiscount()
    {
        return $this->getPrice() - $this->getCatalogPromotionPrice();
    }

    public function getAppliedCatalogPromotion(): CatalogPromotionInterface
    {
        return $this->appliedCatalogPromotion;
    }

    public function hasAppliedCatalogPromotion(): bool
    {
        return (!is_null($this->appliedCatalogPromotion) || ($this->catalogPromotionPrice !== 0));
    }

    private function providePositiveDiscountedPriceOrZero($promoDiscount)
    {
        return ($this->getPrice() - $promoDiscount >= 0) ? $this->getPrice() - $promoDiscount : 0;

    }

    private function hasHigherPriorityThenPreviouslyApplied(CatalogPromotionInterface $catalogPromotion)
    {
        return ($catalogPromotion->getPriority() < $this->appliedCatalogPromotion->getPriority());
    }
}