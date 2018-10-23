<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Processor;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ProductVariantInterface;
use Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Applicator\CatalogPromotionApplicatorInterface;
use Locastic\SyliusCatalogPromotionPlugin\Provider\CatalogPromotionProvider;
use Locastic\SyliusCatalogPromotionPlugin\Provider\ChannelPricingProvider;
use Locastic\SyliusCatalogPromotionPlugin\Repository\CatalogPromotionRepository;
use Locastic\SyliusCatalogPromotionPlugin\Repository\ChannelPricingRepository;
use Sylius\Component\Core\Model\ChannelInterface;

final class CatalogPromotionProcessor
{
    /** @var CatalogPromotionRepository */
    private $promotionRepository;

    /** @var ChannelPricingProvider */
    private $channelPricingProvider;

    /** @var CatalogPromotionProvider */
    private $catalogPromotionProvider;

    /** @var CatalogPromotionApplicatorInterface */
    private $promotionApplicator;

    /** @var EntityManagerInterface */
    private $channelPricingManager;

    /** @var ChannelPricingRepository */
    private $channelPricingRepository;

    /** @var ArrayCollection */
    private $activatedChannelPricings;

    public function __construct(
        ChannelPricingProvider $channelPricingProvider,
        CatalogPromotionRepository $promotionRepository,
        CatalogPromotionProvider $catalogPromotionProvider,
        CatalogPromotionApplicatorInterface $promotionApplicator,
        EntityManagerInterface $channelPricingManager,
        ChannelPricingRepository $channelPricingRepository
    ) {
        $this->promotionRepository = $promotionRepository;
        $this->channelPricingProvider = $channelPricingProvider;
        $this->catalogPromotionProvider = $catalogPromotionProvider;
        $this->promotionApplicator = $promotionApplicator;
        $this->channelPricingManager = $channelPricingManager;
        $this->channelPricingRepository = $channelPricingRepository;
        $this->activatedChannelPricings = new ArrayCollection();
    }

    public function deactivateCatalogPromotions(ChannelInterface $channel)
    {
        $promotedChannelPricings = $this->channelPricingRepository->findAllWithAppliedCatalogPromotionsByChannel($channel);

        /** @var ChannelPricingInterface $channelPricing */
        foreach ($promotedChannelPricings as $channelPricing) {
            $channelPricing->detachCatalogPromotionAction();
            $this->channelPricingManager->persist($channelPricing);
        }

        $this->channelPricingManager->flush();
    }

    public function activateCatalogPromotions(ChannelInterface $channel)
    {
        $activationTriggeredCatalogPromotions = $this->promotionRepository->findActiveCatalogPromotionsByChannel($channel);

        /** @var CatalogPromotionInterface $activationTriggeredCatalogPromotion */
        foreach ($activationTriggeredCatalogPromotions as $activationTriggeredCatalogPromotion) {
            /** @var Collection $catalogPromotionProducts */
            $catalogPromotionProducts = $this->catalogPromotionProvider->getCatalogProducts($activationTriggeredCatalogPromotion);

            $this->promoteCatalogProducts($catalogPromotionProducts, $activationTriggeredCatalogPromotion, $channel);
        }

        $this->channelPricingManager->flush();

        return $this->activatedChannelPricings;
    }

    private function promoteCatalogProducts(Collection $catalogPromotionProducts, CatalogPromotionInterface $activationTriggeredCatalogPromotion, ChannelInterface $channel)
    {
        /** @var ProductVariantInterface $product */
        foreach ($catalogPromotionProducts as $productVariant) {
            /** @var ChannelPricingInterface $channelPricing */
            $channelPricing = $this->channelPricingProvider->provideForProductVariant($channel, $productVariant);

            $this->promotionApplicator->apply($channelPricing, $activationTriggeredCatalogPromotion);
            $this->activatedChannelPricings->add($channelPricing);
            $this->channelPricingManager->persist($channelPricing);
        }
    }
}