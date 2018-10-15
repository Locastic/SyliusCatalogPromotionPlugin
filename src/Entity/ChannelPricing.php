<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $catalogPromotionAmount = 0;

    public function applyCatalogPromotionAction(CatalogPromotionInterface $catalogPromotion, int $promoAmount): bool
    {
        if (null === $this->appliedCatalogPromotion) {
            $this->addCatalogPromotionAmount($promoAmount);
            $this->appliedCatalogPromotion = $catalogPromotion;
        }


        if ($this->appliedCatalogPromotion->getPriority() < $catalogPromotion->getPriority()) {
            $this->detachCatalogPromotionAction($promoAmount);
            $this->appliedCatalogPromotion = null;
        }


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