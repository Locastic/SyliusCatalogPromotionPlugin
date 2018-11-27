<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductInterface;
use Webmozart\Assert\Assert;

class CatalogPromotionGroup implements CatalogPromotionGroupInterface
{
    /** @var mixed */
    private $id;

    /** @var string */
    private $name;

    /** @var ProductInterface[]|ArrayCollection[] */
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

    public function addProduct(ProductInterface $product): void
    {
        if (!$this->hasProduct($product)) {
            $this->products->add($product);

            $product->setAppliedCatalogPromotionGroup($this);
        }
    }

    public function removeProduct(ProductInterface $product): void
    {
        if ($this->hasProduct($product)) {
            $this->products->removeElement($product);
        }
    }

    public function hasProduct(ProductInterface $product)
    {
        return $this->products->contains($product);
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
