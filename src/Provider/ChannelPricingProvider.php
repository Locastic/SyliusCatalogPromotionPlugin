<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Provider;

use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

class ChannelPricingProvider
{
    /**
     * @var FactoryInterface
     */
    private $channelPricingFactory;

    public function __construct(FactoryInterface $channelPricingFactory)
    {
        $this->channelPricingFactory = $channelPricingFactory;
    }

    public function getChannelPricingForProductVariant(ChannelInterface $channel, ProductVariantInterface $productVariant): ChannelPricingInterface
    {
        /** @var ChannelPricingInterface $channelPricing */
        $channelPricing = $this->channelPricingFactory->createNew();

        $channelPricing->setChannelCode($channel->getCode());
        $channelPricing->setProductVariant($productVariant);
        $channelPricing->setPrice($productVariant->getChannelPricingForChannel($channel)->getPrice());

        return $channelPricing;
    }
}