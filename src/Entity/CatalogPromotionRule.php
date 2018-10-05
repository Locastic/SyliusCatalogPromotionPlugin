<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

class CatalogPromotionRule
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
     * @var CatalogPromotion|null
     */
    private $promotion;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param null|string $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    /**
     * @param array $configuration
     */
    public function setConfiguration(array $configuration): void
    {
        $this->configuration = $configuration;
    }

    /**
     * @return CatalogPromotion|null
     */
    public function getPromotion(): ?CatalogPromotion
    {
        return $this->promotion;
    }

    /**
     * @param CatalogPromotion|null $promotion
     */
    public function setPromotion(?CatalogPromotion $promotion): void
    {
        $this->promotion = $promotion;
    }
}