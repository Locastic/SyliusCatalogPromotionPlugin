<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Processor;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotion;
use Locastic\SyliusCatalogPromotionPlugin\Provider\ChannelPricingProvider;
use Locastic\SyliusCatalogPromotionPlugin\Repository\CatalogPromotionRepository;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class CatalogPromotionProcessor
{
    /**
     * @var CatalogPromotionRepository
     */
    private $promotionRepository;

    /**
     * @var ChannelPricingProvider
     */
    private $channelPricingProvider;

    public function __construct(
        ChannelPricingProvider $channelPricingProvider,
        CatalogPromotionRepository $promotionRepository
    ) {
        $this->promotionRepository = $promotionRepository;
        $this->channelPricingProvider = $channelPricingProvider;
    }

    public function process(/*ProductVariantInterface $productVariant,*/ ChannelInterface $channel)
    {
        $activeCatalogPromotions = $this->promotionRepository->findActiveCatalogPromotionsByChannel($channel);

        /** @var CatalogPromotion $activeCatalogPromotion */
        foreach ($activeCatalogPromotions as $activeCatalogPromotion) {
            if ($activeCatalogPromotion->)

        }
dump($activeCatalogPromotions);




//        $productPricing = $this->channelPricingProvider->provideForProductVariant($channel, $productVariant);

//        foreach ($this->promotionRepository->findActiveCatalogPromotionsByChannel($channel) as $catalogPromotion) {
//            dump($catalogPromotion);
//        }
    }
}