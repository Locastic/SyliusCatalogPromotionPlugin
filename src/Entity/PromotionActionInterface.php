<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;

interface PromotionActionInterface extends ResourceInterface
{
    /**
     * @return string|null
     */
    public function getType(): ?string;

    /**
     * @param null|string $type
     */
    public function setType(?string $type): void;

    /**
     * @return array
     */
    public function getConfiguration(): ?array;

    /**
     * @param array $configuration
     */
    public function setConfiguration(array $configuration): void;

    public function getCatalogPromotionGroups(): Collection;

    public function hasCatalogPromotionGroup(CatalogPromotionGroupInterface $promotionGroup): bool;

    public function addCatalogPromotionGroup(CatalogPromotionGroupInterface $promotionGroup): void;

    public function removeCatalogPromotionGroup(CatalogPromotionGroupInterface $promotionGroup): void;

}