<?php

declare(strict_types=1);

namespace Tests\Acme\SyliusExamplePlugin\Application\src\Entity;

use Locastic\SyliusCatalogPromotionPlugin\Entity\ProductInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogProductTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;

class Product extends BaseProduct implements ProductInterface
{
    use CatalogProductTrait;
}