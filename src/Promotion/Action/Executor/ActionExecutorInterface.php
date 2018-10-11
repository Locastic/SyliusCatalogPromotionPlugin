<?php

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Executor;

use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Promotion\Model\PromotionActionInterface;

interface ActionExecutorInterface
{
    public function execute(ChannelPricingInterface $channelPricing, PromotionActionInterface $action): void;
}