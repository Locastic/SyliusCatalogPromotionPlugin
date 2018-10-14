<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Channel\Model\ChannelInterface;

interface CatalogPromotionInterface extends ResourceInterface
{
    /**
     * @param int|null $position
     */
    public function setPriority(?int $position): void;

    /**
     * @return int|null
     */
    public function getPriority(): ?int;

    /**
     * @param null|string $code
     */
    public function setCode(?string $code): void;

    /**
     * @return null|string
     */
    public function getCode(): ?string;

    /**
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * @return null|string
     */
    public function getName(): ?string;

    /**
     * @param string $description
     */
    public function setDescription(string $description): void;

    /**
     * @return null|string
     */
    public function getDescription(): ?string;

    /**
     * @param \DateTime|null $startsAt
     */
    public function setStartsAt(?\DateTime $startsAt): void;

    /**
     * @return \DateTime|null
     */
    public function getStartsAt(): ?\DateTime;

    /**
     * @param \DateTime|null $endsAt
     */
    public function setEndsAt(?\DateTime $endsAt): void;

    /**
     * @return \DateTime|null
     */
    public function getEndsAt(): ?\DateTime;


    /**
     * @return Collection|null
     */
    public function getChannels(): ?Collection;

    /**
     * @param ChannelInterface $channel
     */
    public function addChannel(ChannelInterface $channel): void;

    /**
     * @param ChannelInterface $channel
     */
    public function removeChannel(ChannelInterface $channel): void;

    /**
     * @param ChannelInterface $channel
     * @return mixed
     */
    public function hasChannel(ChannelInterface $channel);

    /**
     * @return Collection|null
     */
    public function getPromotionGroups(): ?Collection;

    /**
     * @param CatalogPromotionGroupInterface $promotionGroup
     */
    public function addPromotionGroup(CatalogPromotionGroupInterface $promotionGroup): void;

    /**
     * @param CatalogPromotionGroupInterface $promotionGroup
     */
    public function removePromotionGroup(CatalogPromotionGroupInterface $promotionGroup): void;

    /**
     * @param CatalogPromotionGroupInterface $promotionGroup
     * @return mixed
     */
    public function hasPromotionGroup(CatalogPromotionGroupInterface $promotionGroup);

    /**
     * @param CatalogPromotionRule $rule
     */
    public function addRule(CatalogPromotionRule $rule): void;

    /**
     * @param CatalogPromotionRule $rule
     */
    public function removeRule(CatalogPromotionRule $rule): void;

    /**
     * @return Collection|null
     */
    public function getRules(): ?Collection;
}
