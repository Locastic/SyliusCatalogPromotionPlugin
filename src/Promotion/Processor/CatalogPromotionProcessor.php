<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Processor;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotion;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ProductVariantInterface;
use Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Applicator\CatalogPromotionApplicatorInterface;
use Locastic\SyliusCatalogPromotionPlugin\Promotion\Checker\Eligibility\CatalogPromotionEligibilityCheckerInterface;
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

    /** @var CatalogPromotionEligibilityCheckerInterface */
    private $catalogPromotionEligibilityChecker;

    /** @var CatalogPromotionProvider */
    private $catalogPromotionProvider;

    /** @var CatalogPromotionApplicatorInterface */
    private $promotionApplicator;

    /**
     * @var EntityManagerInterface
     */
    private $channelPricingManager;

    /**
     * @var ChannelPricingRepository
     */
    private $channelPricingRepository;

    public function __construct(
        ChannelPricingProvider $channelPricingProvider,
        CatalogPromotionRepository $promotionRepository,
        CatalogPromotionEligibilityCheckerInterface $catalogPromotionEligibilityChecker,
        CatalogPromotionProvider $catalogPromotionProvider,
        CatalogPromotionApplicatorInterface $promotionApplicator,
        EntityManagerInterface $channelPricingManager,
        ChannelPricingRepository $channelPricingRepository
    ) {
        $this->promotionRepository = $promotionRepository;
        $this->channelPricingProvider = $channelPricingProvider;
        $this->catalogPromotionEligibilityChecker = $catalogPromotionEligibilityChecker;
        $this->catalogPromotionProvider = $catalogPromotionProvider;
        $this->promotionApplicator = $promotionApplicator;
        $this->channelPricingManager = $channelPricingManager;
        $this->channelPricingRepository = $channelPricingRepository;
    }

    public function process(ChannelInterface $channel)
    {
        $promotedChannelPricings = $this->channelPricingRepository->findAllWithAppliedCatalogPromotionsByChannel($channel);
        $this->deactivateCatalogPromotions($promotedChannelPricings);

        $activeCatalogPromotions = $this->promotionRepository->findActiveCatalogPromotionsByChannel($channel);
        $this->activateCatalogPromotions($channel, $activeCatalogPromotions);
    }

    public function deactivateCatalogPromotions(array $promotedChannelPricings)
    {

        /** @var ChannelPricingInterface $channelPricing */
        foreach ($promotedChannelPricings as $channelPricing) {
            $channelPricing->detachCatalogPromotionAction();
            $this->channelPricingManager->persist($channelPricing);
        }

        $this->channelPricingManager->flush();
    }

    public function activateCatalogPromotions(ChannelInterface $channel, array $activeCatalogPromotions)
    {

        /** @var CatalogPromotion $activeCatalogPromotion */
        foreach ($activeCatalogPromotions as $activeCatalogPromotion) {

            /** @var Collection $catalogPromotionProducts */
            $catalogPromotionProducts = $this->catalogPromotionProvider->getCatalogProducts($activeCatalogPromotion);

            $catalogPromotionProducts->map(function (ProductVariantInterface $productVariant) use ($activeCatalogPromotion, $channel) {
                /** @var ChannelPricingInterface $channelPricing */
                $channelPricing = $this->channelPricingProvider->provideForProductVariant($channel, $productVariant);
                $this->promotionApplicator->apply($channelPricing, $activeCatalogPromotion);

                $this->channelPricingManager->persist($channelPricing);
            });
        }

        $this->channelPricingManager->flush();
    }
}