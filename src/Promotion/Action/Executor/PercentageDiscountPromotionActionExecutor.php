<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Executor;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingInterface;

class PercentageDiscountPromotionActionExecutor implements ActionExecutorInterface
{
    public function execute(ChannelPricingInterface $channelPricing, array $configuration, CatalogPromotionInterface $catalogPromotion): void
    {
        $promoAmount = $this->calculatePromotionAmount($channelPricing->getPrice(), $configuration['percentage']);
        if (!$channelPricing->applyCatalogPromotionAction($catalogPromotion, $promoAmount)) {
            //ispisi mozda
            return;
        };
    }

    private function calculatePromotionAmount(int $channelPrice, float $promoPercentage): int
    {
        return (int) round($channelPrice * $promoPercentage);
    }
}