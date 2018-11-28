<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class CatalogPromotionGroupRepository extends EntityRepository implements CatalogPromotionGroupRepositoryInterface
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
