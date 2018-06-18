<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Sylius\Component\Resource\Model\AbstractTranslation;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

class CatalogPromotionTranslation extends AbstractTranslation implements ResourceInterface
{
    use TimestampableTrait;

    /** @var mixed */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    public function getId()
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}

