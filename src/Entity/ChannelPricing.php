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

    public function applyCatalogPromotionAction(CatalogPromotionInterface $catalogPromotion, int $promoDiscount): bool
    {
        if ($this->hasAppliedCatalogPromotion()) {
            //Check if appliance has to be repeated if job tries to apply same catalog promo
            if (($catalogPromotion->getPriority() < $this->appliedCatalogPromotion->getPriority())) {
                return false;
            }

            if (!$this->detachCatalogPromotionAction()) {
                return false;
            }
        }

        $catalogPrice = $this->providePositiveDiscountedPriceOrZero($promoDiscount);

        $this->setCatalogPromotionPrice($catalogPrice);
        $this->appliedCatalogPromotion = $catalogPromotion;

        return true;
    }

    public function detachCatalogPromotionAction(): bool
    {
        if (is_null($this->appliedCatalogPromotion)) {
            return false;
        }

        $this->setCatalogPromotionPrice(0);
        $this->appliedCatalogPromotion = null;

        return true;
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

    public function hasAppliedCatalogPromotion()
    {
        return (!is_null($this->appliedCatalogPromotion) || ($this->catalogPromotionPrice !== 0));
    }

    private function providePositiveDiscountedPriceOrZero($promoDiscount)
    {
        return ($this->getPrice() - $promoDiscount >= 0) ? $this->getPrice() - $promoDiscount : 0;

    }
}