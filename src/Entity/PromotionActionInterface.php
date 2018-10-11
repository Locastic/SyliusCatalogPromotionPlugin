<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

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
    public function getConfiguration(): array;

    /**
     * @param array $configuration
     */
    public function setConfiguration(array $configuration): void;

    /**
     * @return CatalogPromotionInterface
     */
    public function getPromotion(): ?CatalogPromotionInterface;

    /**
     * @param CatalogPromotionInterface|null $type
     */
    public function setPromotion(?CatalogPromotionInterface $type): void;
}