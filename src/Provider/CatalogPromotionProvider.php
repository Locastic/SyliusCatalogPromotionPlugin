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

    /**
     * @var Collection
     */
    private $catalogProducts;

    public function __construct(CatalogPromotionRepository $catalogPromotionRepository)
    {
        $this->catalogPromotionRepository = $catalogPromotionRepository;
        $this->catalogProducts = new ArrayCollection();
    }

    public function getCatalogProducts(CatalogPromotionInterface $catalogPromotion): Collection
    {
        $this->catalogProducts->clear();

        /** @var CatalogPromotionGroupInterface $catalogPromotionGroup */
        foreach ($catalogPromotion->getPromotionGroups() as $catalogPromotionGroup) {
            $this->getPromotionGroupProducts($catalogPromotionGroup);
        }

        return $this->catalogProducts;
    }

    private function getPromotionGroupProducts( CatalogPromotionGroupInterface $catalogPromotionGroup)
    {
        /** @var ProductVariantInterface $product */
        foreach ($catalogPromotionGroup->getProducts() as $product) {
            $this->catalogProducts->add($product);
        }
    }
}