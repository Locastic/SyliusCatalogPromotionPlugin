<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class CatalogPromotionGroupRepository extends EntityRepository implements CatalogPromotionGroupRepositoryInterface
{
    public function findByCatalogPromotion(CatalogPromotionInterface $catalogPromotion)
    {
        return $this->createQueryBuilder('cpg')
            ->addSelect('products')
            ->innerJoin('cpg.products', 'products')
            ->addSelect('catalog')
            ->innerJoin('cpg.catalog', 'catalog', 'WITH', 'catalog.id = :catalog_id')
            ->setParameter('catalog_id', $catalogPromotion)
            ->getQuery()
            ->getResult();
    }

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
