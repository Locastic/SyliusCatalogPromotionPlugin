<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

interface CatalogPromotionGroupInterface extends ResourceInterface
{
    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getCatalog(): ?CatalogPromotionInterface;

    public function setCatalog(?CatalogPromotionInterface $catalog): void;
}
