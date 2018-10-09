<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Provider;

use Doctrine\Common\Collections\ArrayCollection;
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

    public function getActiveByChannel(): ArrayCollection
    {

    }
}