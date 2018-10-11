<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

class CatalogPromotion implements CatalogPromotionInterface, CodeAwareInterface, TranslatableInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }

    /** @var mixed */
    private $id;

    /** @var string */
    private $code;

    /** @var int */
    private $position = 0;

    /** @var \DateTime */
    private $startsAt;

    /** @var \DateTime */
    private $endsAt;

    /** @var ArrayCollection|ChannelInterface[] */
    private $channels;

    /** @var ArrayCollection|CatalogPromotionGroupInterface[] */
    private $promotionGroups;

    /** @var ArrayCollection|CatalogPromotionRule[]  */
    private $rules;

    /** @var ArrayCollection|PromotionActionInterface[] */
    private $actions;


    public function __construct()
    {
        $this->initializeTranslationsCollection();
        $this->channels = new ArrayCollection();
        $this->promotionGroups = new ArrayCollection();
        $this->rules = new ArrayCollection();
        $this->actions = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setPriority(?int $position): void
    {
        $this->position = $position;
    }

    public function getPriority(): ?int
    {
        return $this->position;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setName(string $name): void
    {
        $this->getTranslation()->setName($name);
    }

    public function getName(): ?string
    {
        return $this->getTranslation()->getName();
    }

    public function setDescription(string $description): void
    {
        $this->getTranslation()->setDescription($description);
    }

    public function getDescription(): ?string
    {
        return $this->getTranslation()->getDescription();
    }

    public function setStartsAt(?\DateTime $startsAt): void
    {
        $this->startsAt = $startsAt;
    }

    public function getStartsAt(): ?\DateTime
    {
        return $this->startsAt;
    }

    public function setEndsAt(?\DateTime $endsAt): void
    {
        $this->endsAt = $endsAt;
    }

    public function getEndsAt(): ?\DateTime
    {
        return $this->endsAt;
    }

    public function getChannels(): ?Collection
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

    public function getPromotionGroups(): ?Collection
    {
        return $this->promotionGroups;
    }

    public function addPromotionGroup(CatalogPromotionGroupInterface $promotionGroup): void
    {
        if (!$this->hasPromotionGroup($promotionGroup)) {
            $this->promotionGroups->add($promotionGroup);
        }
    }

    public function removePromotionGroup(CatalogPromotionGroupInterface $promotionGroup): void
    {
        if ($this->hasPromotionGroup($promotionGroup)) {
            $this->promotionGroups->removeElement($promotionGroup);
        }
    }

    public function hasPromotionGroup(CatalogPromotionGroupInterface $promotionGroup)
    {
        return $this->promotionGroups->contains($promotionGroup);
    }

    public function addRule(CatalogPromotionRule $rule): void
    {
        $rule->setPromotion($this);
        $this->rules->add($rule);
    }

    public function removeRule(CatalogPromotionRule $rule): void
    {
        $rule->setPromotion(null);
        $this->rules->removeElement($rule);
    }

    public function getRules(): ?Collection
    {
        return $this->rules;
    }

    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function hasActions(): bool
    {
       return !$this->actions->isEmpty();
    }

    public function hasAction(PromotionActionInterface $promotionAction): bool
    {
        return $this->actions->contains($promotionAction);
    }

    public function addAction(PromotionActionInterface $promotionAction): void
    {
        if (!$this->hasAction($promotionAction)) {
            $this->actions->add($promotionAction);
            $promotionAction->setPromotion($this);
        }
    }

    public function removeAction(PromotionActionInterface $promotionAction): void
    {
        if ($this->hasAction($promotionAction)) {
            $this->actions->removeElement($promotionAction);
            $promotionAction->setPromotion(null);
        }
    }

    /**
     * @return TranslationInterface|CatalogPromotionTranslation
     */
    protected function createTranslation(): TranslationInterface
    {
        return new CatalogPromotionTranslation();
    }
}
