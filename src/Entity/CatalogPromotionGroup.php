<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Core\Model\ProductVariantInterface;

class CatalogPromotionGroup implements CatalogPromotionGroupInterface
{
    /** @var mixed */
    private $id;

    /** @var string */
    private $name;

    /** @var ProductVariantInterface[]|ArrayCollection[] */
    private $products;

    /** @var CatalogPromotionInterface */
    private $catalog;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getCatalog(): CatalogPromotionInterface
    {
        return $this->catalog;
    }

    public function setCatalog(?CatalogPromotionInterface $catalog): void
    {
        $this->catalog = $catalog;
    }
}
