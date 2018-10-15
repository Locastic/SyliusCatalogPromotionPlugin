<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Executor;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingInterface;

class PercentageDiscountPromotionActionExecutor implements ActionExecutorInterface
{
    public function execute(ChannelPricingInterface $channelPricing, array $configuration, CatalogPromotionInterface $catalogPromotion): void
    {
        // TODO: Implement execute() method.
    }
}