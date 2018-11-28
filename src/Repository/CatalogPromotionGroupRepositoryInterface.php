<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface CatalogPromotionGroupRepositoryInterface extends RepositoryInterface
{
    public function createQueryBuilderByCatalogPromotionId($catalogPromotionId): QueryBuilder;
}