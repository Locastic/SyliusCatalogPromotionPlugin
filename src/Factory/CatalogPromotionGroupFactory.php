<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Factory;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionGroup;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionGroupInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

class CatalogPromotionGroupFactory implements CatalogPromotionGroupFactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return CatalogPromotionGroup|object
     */
    public function createNew(): CatalogPromotionGroup
    {
        return $this->factory->createNew();
    }

    public function createForCatalogPromotion(CatalogPromotionInterface $catalogPromotionGroup): CatalogPromotionGroupInterface
    {
        /** @var CatalogPromotionGroup $group */
        $group = $this->factory->createNew();
        $group->setCatalog($catalogPromotionGroup);

        return $group;
    }
}
