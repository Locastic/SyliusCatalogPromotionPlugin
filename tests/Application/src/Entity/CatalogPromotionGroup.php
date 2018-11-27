<?php

declare(strict_types=1);

namespace Tests\Acme\SyliusExamplePlugin\Application\src\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotion;

class CatalogPromotionGroup extends CatalogPromotion
{
    /** @var Product[]|ArrayCollection */
    private $products;
}