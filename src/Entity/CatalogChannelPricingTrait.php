<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

trait CatalogChannelPricingTrait
{
    /**
     * @var CatalogPromotionInterface
     */
    private $appliedCatalogPromotion;

    /**
     * @var int|null
     */
    private $discount;

    public function applyCatalogPromotionAction(CatalogPromotionInterface $catalogPromotion, int $promoDiscount): void
    {
        if ($this->hasAppliedCatalogPromotion()) {
            //Check if appliance has to be repeated if job tries to apply same catalog promo
            if (!$this->hasHigherPriorityThenPreviouslyApplied($catalogPromotion)) {
                return;
            }

            $this->detachCatalogPromotionAction();

            if ($this->hasAppliedCatalogPromotion()) {
                throw new \RuntimeException('Removing of applied catalog promotion failed.');
            }

            return;
        }

        $catalogPrice = $this->providePositiveDiscountedPriceOrZero($promoDiscount);

        $this->setOriginalPrice($this->price);
        $this->setPrice($catalogPrice);

        $this->appliedCatalogPromotion = $catalogPromotion;
    }

    public function detachCatalogPromotionAction(): void
    {
        if (!$this->hasAppliedCatalogPromotion()) {
            return;
        }

        $this->setPrice($this->originalPrice);
        $this->setOriginalPrice(null);
        $this->setDiscount(null);

        $this->appliedCatalogPromotion = null;
    }

    public function getOriginalPrice(): ?int
    {
        if ($this->hasAppliedCatalogPromotion()) {
            return $this->originalPrice;
        }

        return $this->price;
    }

    public function getPromotionDiscount(): ?int
    {
        if ($this->hasAppliedCatalogPromotion()) {
            return abs($this->getPrice() - $this->getOriginalPrice());
        }

        return 0;
    }

    public function getAppliedCatalogPromotion(): ?CatalogPromotionInterface
    {
        return $this->appliedCatalogPromotion;
    }

    public function hasAppliedCatalogPromotion(): bool
    {
        return (null !== $this->appliedCatalogPromotion);
    }

    private function providePositiveDiscountedPriceOrZero($promoDiscount)
    {
        return ($this->getPrice() - $promoDiscount >= 0) ? ($this->getPrice() - $promoDiscount) : 0;
    }

    private function hasHigherPriorityThenPreviouslyApplied(CatalogPromotionInterface $catalogPromotion): bool
    {
        return ($catalogPromotion->getPriority() > $this->appliedCatalogPromotion->getPriority());
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(?int $discount): void
    {
        $this->discount = $discount;
    }
}