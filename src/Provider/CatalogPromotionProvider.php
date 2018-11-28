<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Provider;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionGroupInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ProductInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ProductVariantInterface;
use Locastic\SyliusCatalogPromotionPlugin\Repository\CatalogPromotionGroupRepository;
use Locastic\SyliusCatalogPromotionPlugin\Repository\CatalogPromotionGroupRepositoryInterface;
use Locastic\SyliusCatalogPromotionPlugin\Repository\CatalogPromotionRepository;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class CatalogPromotionProvider
{
    /** @var CatalogPromotionGroupRepository */
    private $catalogPromotionGroupRepository;

    public function __construct(
        CatalogPromotionGroupRepositoryInterface $catalogPromotionGroupRepository
    ) {
        $this->catalogPromotionGroupRepository = $catalogPromotionGroupRepository;
    }

    public function getProducts(CatalogPromotionInterface $catalogPromotion): Collection
    {
        /** @var CatalogPromotionGroupInterface[]|Collection $catalogPromoGroup */
        $catalogPromotionGroups = $this->catalogPromotionGroupRepository->findByCatalog([
            'catalog' => $catalogPromotion->getId()
        ]);

        return new ArrayCollection($this->getCatalogProducts($catalogPromotionGroups));
    }

    private function getCatalogProducts(array $catalogPromotionGroups, array $catalogProducts = [[]]): array
    {
        /** @var CatalogPromotionGroupInterface $group */
        foreach ($catalogPromotionGroups as $group) {
            if (null !== $groupProducts = $group->getProducts()) {
                $catalogProducts[] = $groupProducts->toArray();
            }
        }

        return array_merge(...$catalogProducts);
    }
}
