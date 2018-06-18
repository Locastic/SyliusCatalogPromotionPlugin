<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\Timestampable;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

class CatalogPromotion implements ResourceInterface, CodeAwareInterface, TranslatableInterface
{
    use Timestampable, TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }

    /** @var mixed */
    private $id;

    /** @var string */
    private $code;

    /** @var int */
    private $priority = 0;

    /** @var \DateTime */
    private $startsAt;

    /** @var \DateTime */
    private $endsAt;

    /**
     * @var ChannelPricingInterface[]
     */
    private $channels;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->channels = new ArrayCollection();
        $this->initializeTranslationsCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getName(): ?string
    {
        return $this->getTranslation()->getName();
    }

    public function getStartsAt(): ?\DateTime
    {
        return $this->startsAt;
    }

    public function getEndsAt(): ?\DateTime
    {
        return $this->endsAt;
    }

    public function getChannels(): ?ArrayCollection
    {
        return $this->channels;
    }

    public function addChannel(ChannelInterface $channel): void
    {
        if (!$this->hasChannel($channel)) {
            $this->channels->add($channel);
        }
    }

    public function removeChannel(ChannelInterface $channel): void
    {
        if ($this->hasChannel($channel)) {
            $this->channels->removeElement($channel);
        }
    }

    public function hasChannel(ChannelInterface $channel)
    {
        return $this->channels->contains($channel);
    }

    public function getDescription(): ?string
    {
        return $this->getTranslation()->getDescription();
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function setName(string $name): void
    {
        $this->getTranslation()->setName($name);
    }

    public function setDescription(string $description): void
    {
        $this->getTranslation()->setDescription($description);
    }

    public function setStartsAt(?\DateTime $startsAt): void
    {
        $this->startsAt = $startsAt;
    }

    public function setEndsAt(?\DateTime $endsAt): void
    {
        $this->endsAt = $endsAt;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return TranslationInterface|CatalogPromotionTranslation
     */
    protected function createTranslation(): TranslationInterface
    {
        return new CatalogPromotionTranslation();
    }
}

