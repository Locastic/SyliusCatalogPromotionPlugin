<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Processor;

use Doctrine\Common\Collections\Collection;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotion;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ProductVariantInterface;
use Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Applicator\CatalogPromotionApplicatorInterface;
use Locastic\SyliusCatalogPromotionPlugin\Promotion\Checker\Eligibility\CatalogPromotionEligibilityCheckerInterface;
use Locastic\SyliusCatalogPromotionPlugin\Provider\CatalogPromotionProvider;
use Locastic\SyliusCatalogPromotionPlugin\Provider\ChannelPricingProvider;
use Locastic\SyliusCatalogPromotionPlugin\Repository\CatalogPromotionRepository;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;

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

    public function __construct(
        ChannelPricingProvider $channelPricingProvider,
        CatalogPromotionRepository $promotionRepository,
        CatalogPromotionEligibilityCheckerInterface $catalogPromotionEligibilityChecker,
        CatalogPromotionProvider $catalogPromotionProvider,
        CatalogPromotionApplicatorInterface $promotionApplicator
    ) {
        $this->promotionRepository = $promotionRepository;
        $this->channelPricingProvider = $channelPricingProvider;
        $this->catalogPromotionEligibilityChecker = $catalogPromotionEligibilityChecker;
        $this->catalogPromotionProvider = $catalogPromotionProvider;
        $this->promotionApplicator = $promotionApplicator;
    }

    public function process(/*ProductVariantInterface $productVariant,*/ ChannelInterface $channel)
    {
        $activeCatalogPromotions = $this->promotionRepository->findActiveCatalogPromotionsByChannel($channel);

        /** @var CatalogPromotion $activeCatalogPromotion */
        foreach ($activeCatalogPromotions as $activeCatalogPromotion) {

            /** @var Collection $catalogPromotionProducts */
            $catalogPromotionProducts = $this->catalogPromotionProvider->getCatalogProducts($activeCatalogPromotion);

            $catalogPromotionProducts->map(function (ProductVariantInterface $productVariant) use ($activeCatalogPromotion, $channel) {
                /** @var ChannelPricingInterface $channelPricing */
                $channelPricing = $this->channelPricingProvider->provideForProductVariant($channel, $productVariant);
                $this->promotionApplicator->apply($channelPricing, $activeCatalogPromotion);
//                if ($this->catalogPromotionEligibilityChecker->isEligible($activeCatalogPromotion, $productVariant)) {
//                    dump('ide apply na ovog');
//                }

            });

        }
dump($activeCatalogPromotions);


//        $productPricing = $this->channelPricingProvider->provideForProductVariant($channel, $productVariant);

//        foreach ($this->promotionRepository->findActiveCatalogPromotionsByChannel($channel) as $catalogPromotion) {
//            dump($catalogPromotion);
//        }
    }

    private function applyPromo(CatalogPromotion $catalogPromotion, Collection $catalogPromotionProducts)
    {

    }
}