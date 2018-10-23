<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Provider;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionGroupInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ProductVariantInterface;
use Locastic\SyliusCatalogPromotionPlugin\Repository\CatalogPromotionRepository;

class CatalogPromotionProvider
{
    /**
     * @var CatalogPromotionRepository
     */
    private $catalogPromotionRepository;

    public function __construct(CatalogPromotionRepository $catalogPromotionRepository)
    {
        $this->catalogPromotionRepository = $catalogPromotionRepository;
    }

    public function getCatalogProducts(CatalogPromotionInterface $catalogPromotion): Collection
    {
        $catalogProducts = new ArrayCollection();

        /** @var CatalogPromotionGroupInterface $catalogPromotionGroup */
        foreach ($catalogPromotion->getPromotionGroups() as $catalogPromotionGroup) {
            $this->getPromotionGroupProducts($catalogPromotionGroup, $catalogProducts);
        }

        return $catalogProducts;
    }

    private function getPromotionGroupProducts( CatalogPromotionGroupInterface $catalogPromotionGroup, Collection $catalogProducts)
    {
        /** @var ProductVariantInterface $product */
        foreach ($catalogPromotionGroup->getProducts() as $product) {
            $catalogProducts->add($product);
        }
    }
}