<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

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
     * @var CatalogPromotionInterface
     */
    private $promotion;

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

    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    public function setConfiguration(array $configuration): void
    {
        $this->configuration = $configuration;
    }

    public function getPromotion(): ?CatalogPromotionInterface
    {
        return $this->promotion;
    }

    public function setPromotion(?CatalogPromotionInterface $promotion): void
    {
        $this->promotion = $promotion;
    }


}