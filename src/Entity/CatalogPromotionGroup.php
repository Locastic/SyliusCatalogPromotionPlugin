<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

class CatalogPromotionGroup implements ResourceInterface
{
    /** @var mixed */
    private $id;

    /** @var string */
    private $type;

    /** @var ProductVariantInterface[]|ArrayCollection[] */
    private $products;

    /** @var CatalogPromotion */
    private $catalog;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getCatalog(): CatalogPromotion
    {
        return $this->catalog;
    }

    public function setCatalog(?CatalogPromotion $catalog): void
    {
        $this->catalog = $catalog;
    }
}
