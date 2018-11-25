<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Sylius\Component\Core\Model\Product as BaseProduct;

class Product extends BaseProduct implements ProductInterface
{
    /** @var CatalogPromotionGroupInterface */
    private $appliedCatalogPromotionGroup;

    public function getAppliedCatalogPromotionGroup(): ?CatalogPromotionGroupInterface
    {
        return $this->appliedCatalogPromotionGroup;
    }

    public function setAppliedCatalogPromotionGroup(?CatalogPromotionGroupInterface $catalogPromotionGroup): void
    {
        $this->appliedCatalogPromotionGroup = $catalogPromotionGroup;

        $this->getVariants()->map(function (ProductVariantInterface $productVariant) use ($catalogPromotionGroup) {
            $productVariant->setCatalogPromotionGroup($catalogPromotionGroup);
        });
    }

    public function getAppliedCatalogPromotion(): ?CatalogPromotionInterface
    {
        return (null !== $this->getAppliedCatalogPromotionGroup()) ? $this->getAppliedCatalogPromotionGroup()->getCatalog() : null;
    }
}