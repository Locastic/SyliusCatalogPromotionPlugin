<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class CatalogPromotionGroupRepository extends EntityRepository
{
    /**
     * @param $catalogPromotionId
     * @return QueryBuilder
     */
    public function createQueryBuilderByCatalogPromotionId($catalogPromotionId): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.catalog = :catalogPromotionId')
            ->setParameter('catalogPromotionId', $catalogPromotionId);
    }
}
