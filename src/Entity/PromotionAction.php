<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class PromotionAction implements PromotionActionInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var array
     */
    private $configuration;

    /**
     * @var Collection|CatalogPromotionGroupInterface[]
     */
    private $catalogPromotionGroups;

    public function __construct()
    {
        $this->catalogPromotionGroups = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getConfiguration(): ?array
    {
        return $this->configuration;
    }

    public function setConfiguration(array $configuration): void
    {
        $this->configuration = $configuration;
    }

    public function getCatalogPromotionGroups(): Collection
    {
        return $this->catalogPromotionGroups;
    }

    public function hasCatalogPromotionGroup(CatalogPromotionGroupInterface $promotionGroup): bool
    {
        return $this->catalogPromotionGroups->contains($promotionGroup);
    }

    public function addCatalogPromotionGroup(CatalogPromotionGroupInterface $promotionGroup): void
    {
        if (!$this->hasCatalogPromotionGroup($promotionGroup)) {
            $this->catalogPromotionGroups->add($promotionGroup);
//            $promotionGroup->setAction($this);
        }
    }

    public function removeCatalogPromotionGroup(CatalogPromotionGroupInterface $promotionGroup): void
    {
        if ($this->hasCatalogPromotionGroup($promotionGroup)) {
            $this->catalogPromotionGroups->removeElement($promotionGroup);
            $promotionGroup->setAction(null);
        }
    }
}