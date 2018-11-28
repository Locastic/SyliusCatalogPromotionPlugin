<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface CatalogPromotionGroupRepositoryInterface extends RepositoryInterface
{
    public function findByCatalogPromotion(CatalogPromotionInterface $catalogPromotion);

    public function createQueryBuilderByCatalogPromotionId($catalogPromotionId): QueryBuilder;
}