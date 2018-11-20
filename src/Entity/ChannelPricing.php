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
     * @var int | null
     */
    private $discountPercentage;

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
        $this->setOriginalPrice(0);
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
        return (!is_null($this->appliedCatalogPromotion));
    }

    private function providePositiveDiscountedPriceOrZero($promoDiscount)
    {
        return ($this->getPrice() - $promoDiscount >= 0) ? ($this->getPrice() - $promoDiscount) : 0;
    }

    private function hasHigherPriorityThenPreviouslyApplied(CatalogPromotionInterface $catalogPromotion): bool
    {
        return ($catalogPromotion->getPriority() > $this->appliedCatalogPromotion->getPriority());
    }

    public function getDiscountPercentage(): ?int
    {
        return $this->discountPercentage;
    }

    public function setDiscountPercentage(?int $discountPercentage): void
    {
        $this->discountPercentage = $discountPercentage;
    }
}
