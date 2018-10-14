<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ChannelPricing as BaseChannelPricing;

class ChannelPricing extends BaseChannelPricing implements ChannelPricingInterface
{
    /**
     * @var Collection
     */
    private $appliedCatalogPromotions;

    /**
     * @var int
     */
    private $catalogPromotionAmount = 0;

    public function __construct()
    {
        $this->appliedCatalogPromotions = new ArrayCollection();
    }

    public function applyCatalogPromotionAction(CatalogPromotionInterface $catalogPromotion, int $promoAmount): bool
    {
        if (!$this->appliedCatalogPromotions->contains($catalogPromotion)) {
            $this->addCatalogPromotionAmount($promoAmount);
            return true;
        }

        return false;
    }

    public function detachCatalogPromotionAction(CatalogPromotionInterface $catalogPromotion, int $promoAmount): bool
    {
        if ($this->appliedCatalogPromotions->contains($catalogPromotion)) {
            $this->addCatalogPromotionAmount($promoAmount);
            return true;
        }

        return false;
    }

    public function getCatalogPromotionAmount(): int
    {
        return $this->catalogPromotionAmount;
    }

    public function addCatalogPromotionAmount(int $catalogPromoAmount): bool
    {
        $this->catalogPromotionAmount += $catalogPromoAmount;
    }

    public function getPromotionSubjectTotal()
    {
        return $this->getPrice() - $this->getCatalogPromotionAmount();
    }
}