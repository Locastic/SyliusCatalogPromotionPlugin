<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Executor;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingInterface;
use Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Applicator\ChannelPricingPromotionApplicatorInterface;
use Sylius\Component\Promotion\Model\PromotionActionInterface;

class FixedDiscountPromotionActionExecutor implements ActionExecutorInterface
{
    public function execute(ChannelPricingInterface $channelPricing, array $configuration, CatalogPromotionInterface $catalogPromotion): void
    {
        $channelCode = $configuration[$channelPricing->getChannelCode()] ?? null;

        if (null === $channelCode) {
            return;
        }

        $promoAmount = $channelCode['amount'];

        $channelPricing->applyCatalogPromotionAction($catalogPromotion, $promoAmount);
    }
}