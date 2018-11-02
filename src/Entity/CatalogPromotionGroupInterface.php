<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;

interface CatalogPromotionGroupInterface extends ResourceInterface
{
    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getCatalog(): ?CatalogPromotionInterface;

    public function setCatalog(?CatalogPromotionInterface $catalog): void;

    public function getProducts(): ?Collection;

    public function addProduct(ProductVariantInterface $productVariant): void;

    public function removeProduct(ProductVariantInterface $productVariant): void;

    public function hasProduct(ProductVariantInterface $productVariant);

    public function getAction(): ?PromotionActionInterface;

    public function setAction(/*?PromotionActionInterface */$action): void;
}
