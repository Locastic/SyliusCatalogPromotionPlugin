<?php

declare(strict_types=1);

namespace Tests\Acme\SyliusExamplePlugin\Application\src\Entity;

use Locastic\SyliusCatalogPromotionPlugin\Entity\AppliedCatalogPromotionAwareInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ProductTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;

class Product extends BaseProduct implements AppliedCatalogPromotionAwareInterface
{
    use ProductTrait;
}