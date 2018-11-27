<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Processor;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionGroupInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogAwareChannelPricingInterface;
use Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Applicator\CatalogPromotionApplicatorInterface;
use Locastic\SyliusCatalogPromotionPlugin\Provider\CatalogPromotionProvider;
use Locastic\SyliusCatalogPromotionPlugin\Provider\ChannelPricingProvider;
use Locastic\SyliusCatalogPromotionPlugin\Repository\CatalogPromotionRepository;
use Locastic\SyliusCatalogPromotionPlugin\Repository\ChannelPricingRepository;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;

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

    /** @var ArrayCollection */
    private $deactivatedChannelPricings;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    public function __construct(
        ChannelPricingProvider $channelPricingProvider,
        CatalogPromotionRepository $promotionRepository,
        CatalogPromotionProvider $catalogPromotionProvider,
        CatalogPromotionApplicatorInterface $promotionApplicator,
        EntityManagerInterface $channelPricingManager,
        ChannelPricingRepository $channelPricingRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->promotionRepository = $promotionRepository;
        $this->channelPricingProvider = $channelPricingProvider;
        $this->catalogPromotionProvider = $catalogPromotionProvider;
        $this->promotionApplicator = $promotionApplicator;
        $this->channelPricingManager = $channelPricingManager;
        $this->channelPricingRepository = $channelPricingRepository;
        $this->productRepository = $productRepository;
        $this->activatedChannelPricings = new ArrayCollection();
        $this->deactivatedChannelPricings = new ArrayCollection();
    }

    public function deactivateCatalogPromotions(ChannelInterface $channel): Collection
    {
        $promotedChannelPricings = $this->channelPricingRepository->findAllWithAppliedCatalogPromotionsByChannel($channel);

        /** @var ChannelPricingInterface|CatalogAwareChannelPricingInterface $channelPricing */
        foreach ($promotedChannelPricings as $channelPricing) {
            $catalogPrice = $channelPricing->getPrice();
            $previouslyAppliedCatalog = $channelPricing->getAppliedCatalogPromotion();

            $channelPricing->detachCatalogPromotionAction();
            $this->channelPricingManager->persist($channelPricing);

            $this->deactivatedChannelPricings->add([
                $channelPricing,
                $catalogPrice,
                $previouslyAppliedCatalog
            ]);
        }
        $this->channelPricingManager->flush();

        return $this->deactivatedChannelPricings;
    }

    public function activateCatalogPromotions(ChannelInterface $channel): Collection
    {
        $activationTriggeredCatalogPromotions = $this->promotionRepository->findActiveCatalogPromotionsByChannel($channel);

        /** @var CatalogPromotionInterface $activationTriggeredCatalogPromotion */
        foreach ($activationTriggeredCatalogPromotions as $activationTriggeredCatalogPromotion) {
            $this->promoteCatalogGroups($activationTriggeredCatalogPromotion, $channel);
        }
        $this->channelPricingManager->flush();

        return $this->activatedChannelPricings;
    }

    private function promoteCatalogGroups(CatalogPromotionInterface $catalogPromotion, ChannelInterface $channel)
    {
        /** @var CatalogPromotionGroupInterface $promotionGroup */
        foreach ($catalogPromotion->getPromotionGroups() as $promotionGroup) {
            $catalogPromoGroupProducts = $this->productRepository->findBy([
                'appliedCatalogPromotionGroup' => $promotionGroup->getId()
            ]);

            if (null === $catalogPromoGroupProducts) {
                continue;
            }

            /** @var ProductInterface $product */
            foreach ($catalogPromoGroupProducts as $product) {
                $this->promoteCatalogGroupProducts($product->getVariants(), $promotionGroup, $channel);
            }
        }
    }

    private function promoteCatalogGroupProducts(Collection $promotedProductVariants, CatalogPromotionGroupInterface $promotionGroup, ChannelInterface $channel)
    {
        /** @var ProductVariantInterface $productVariant */
        foreach ($promotedProductVariants as $productVariant) {
            /** @var ChannelPricingInterface $channelPricing */
            $channelPricing = $this->channelPricingProvider->provideForProductVariant($channel, $productVariant);

            $this->promotionApplicator->apply($channelPricing, $promotionGroup);
            $this->activatedChannelPricings->add($channelPricing);
            $this->channelPricingManager->persist($channelPricing);
        }
    }
}
