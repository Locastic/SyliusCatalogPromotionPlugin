<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;

interface PromotionActionInterface extends ResourceInterface
{
    public function getType(): ?string;

    public function setType(?string $type): void;

    public function getConfiguration(): ?array;

    public function setConfiguration(array $configuration): void;

    public function getCatalogPromotionGroups(): Collection;

    public function hasCatalogPromotionGroup(CatalogPromotionGroupInterface $promotionGroup): bool;

    public function addCatalogPromotionGroup(CatalogPromotionGroupInterface $promotionGroup): void;

    public function removeCatalogPromotionGroup(CatalogPromotionGroupInterface $promotionGroup): void;

}