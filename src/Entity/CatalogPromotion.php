<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Core\Model\ImagesAwareInterface;
use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

class CatalogPromotion implements CatalogPromotionInterface, CodeAwareInterface, TranslatableInterface, ImagesAwareInterface
{
    use TranslatableTrait {
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

    /** @var ArrayCollection|ChannelInterface[] */
    private $channels;

    /** @var ArrayCollection|CatalogPromotionGroupInterface[] */
    private $promotionGroups;

    /** @var ArrayCollection|ImageInterface[] */
    private $images;

    public function __construct()
    {
        $this->initializeTranslationsCollection();
        $this->channels = new ArrayCollection();
        $this->promotionGroups = new ArrayCollection();

        $this->images = new ArrayCollection();
        $this->addImage(new CatalogBannerImage());
    }

    public function getId()
    {
        return $this->id;
    }

    public function setPriority(?int $priority): void
    {
        $this->priority = $priority;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
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

    protected function createTranslation(): TranslationInterface
    {
        return new CatalogPromotionTranslation();
    }

    public function getImages(): Collection
    {
        return $this->images;
    }

    public function getImagesByType(string $type): Collection
    {
        return $this->images->filter(function (ImageInterface $image) use ($type) {
            return $type === $image->getType();
        });
    }

    public function hasImages(): bool
    {
        return !$this->images->isEmpty();
    }

    public function hasImage(ImageInterface $image): bool
    {
        return $this->images->contains($image);
    }

    public function addImage(ImageInterface $image): void
    {
        if (!$this->hasImage($image)) {
            $image->setOwner($this);
            $this->images->add($image);
        }
    }

    public function removeImage(ImageInterface $image): void
    {
        if ($this->hasImage($image)) {
            $image->setOwner(null);
            $this->images->removeElement($image);
        }
    }
}
