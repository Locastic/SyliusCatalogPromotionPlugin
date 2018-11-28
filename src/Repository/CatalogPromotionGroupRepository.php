<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class CatalogPromotionGroupRepository extends EntityRepository implements CatalogPromotionGroupRepositoryInterface
{
    // select * From locastic_catalog_promotion_group inner join sylius_product
    //          on sylius_product.catalog_promotion_group_id = locastic_catalog_promotion_group.id
    // inner join locastic_catalog_promotion
    //           on locastic_catalog_promotion.id = locastic_catalog_promotion_group.catalog_id
    // where locastic_catalog_promotion.id = 1
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
