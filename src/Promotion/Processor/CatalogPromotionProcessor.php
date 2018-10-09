<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Processor;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotion;
use Locastic\SyliusCatalogPromotionPlugin\Promotion\Checker\Eligibility\CatalogPromotionEligibilityCheckerInterface;
use Locastic\SyliusCatalogPromotionPlugin\Provider\ChannelPricingProvider;
use Locastic\SyliusCatalogPromotionPlugin\Repository\CatalogPromotionRepository;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class CatalogPromotionProcessor
{
    /** @var CatalogPromotionRepository  */
    private $promotionRepository;

    /** @var ChannelPricingProvider  */
    private $channelPricingProvider;

    /** @var CatalogPromotionEligibilityCheckerInterface */
    private $catalogPromotionEligibilityChecker;

    public function __construct(
        ChannelPricingProvider $channelPricingProvider,
        CatalogPromotionRepository $promotionRepository,
        CatalogPromotionEligibilityCheckerInterface $catalogPromotionEligibilityChecker
    ) {
        $this->promotionRepository = $promotionRepository;
        $this->channelPricingProvider = $channelPricingProvider;
        $this->catalogPromotionEligibilityChecker = $catalogPromotionEligibilityChecker;
    }

    public function process(/*ProductVariantInterface $productVariant,*/ ChannelInterface $channel)
    {
        $activeCatalogPromotions = $this->promotionRepository->findActiveCatalogPromotionsByChannel($channel);

        /** @var CatalogPromotion $activeCatalogPromotion */
        foreach ($activeCatalogPromotions as $activeCatalogPromotion) {
            if ($this->catalogPromotionEligibilityChecker->isEligible($activeCatalogPromotion))

        }
dump($activeCatalogPromotions);




//        $productPricing = $this->channelPricingProvider->provideForProductVariant($channel, $productVariant);

//        foreach ($this->promotionRepository->findActiveCatalogPromotionsByChannel($channel) as $catalogPromotion) {
//            dump($catalogPromotion);
//        }
    }
}