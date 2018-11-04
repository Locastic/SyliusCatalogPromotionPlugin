<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Webmozart\Assert\Assert;

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

    /** @var PromotionActionInterface */
    private $action;

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

    public function getProducts(): ?Collection
    {
        return $this->products;
    }

    public function addProduct(ProductVariantInterface $productVariant): void
    {
        if (!$this->hasProduct($productVariant)) {
            $this->products->add($productVariant);

            $productVariant->setCatalogPromotionGroup($this);
        }
    }

    public function removeProduct(ProductVariantInterface $productVariant): void
    {
        if ($this->hasProduct($productVariant)) {
            $this->products->removeElement($productVariant);
        }
    }

    public function hasProduct(ProductVariantInterface $productVariant)
    {
        return $this->products->contains($productVariant);
    }
    //hack za formu - todo solve
    public function getActions(): ?array
    {
        return array($this->getAction());
    }

    public function getAction(): ?PromotionActionInterface
    {
        return $this->action;
    }

    public function setAction($action): void
    {
        Assert::notNull($action);

        $this->action = $action;
        $this->action->addCatalogPromotionGroup($this);
    }
    //hack za formu - todo Uredi!! => parametar prima array prebaci u ono sta sam ostavia u interfejsu
    public function setActions($actions): void
    {
        /** @var PromotionActionInterface $action */
        $action = $this->getActionFromMultipleEntry(new ArrayCollection($actions));
        $this->setAction($action);
    }

    private function getActionFromMultipleEntry(Collection $actions)
    {
        return $actions->first();
    }
}
