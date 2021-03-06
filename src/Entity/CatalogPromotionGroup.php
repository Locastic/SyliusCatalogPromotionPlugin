<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Webmozart\Assert\Assert;

class CatalogPromotionGroup implements CatalogPromotionGroupInterface
{
    /** @var mixed */
    protected $id;

    /** @var string */
    protected $name;

    /** @var ProductInterface[]|ArrayCollection[] */
    protected $products;

    /** @var CatalogPromotionInterface */
    protected $catalog;

    /** @var PromotionActionInterface */
    protected $action;

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

    public function addProduct(ProductInterface $product): void
    {
        if (!$this->hasProduct($product)) {
            $this->products->add($product);

            $product->setCatalogPromotionGroup($this);
        }
    }

    public function removeProduct(ProductInterface $product): void
    {
        if ($this->hasProduct($product)) {
            $this->products->removeElement($product);

            $product->setCatalogPromotionGroup(null);
        }
    }

    public function hasProduct(ProductInterface $product)
    {
        return $this->products->contains($product);
    }

    //hack za formu - todo solve
    public function getActions(): ?array
    {
        return [$this->getAction()];
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
