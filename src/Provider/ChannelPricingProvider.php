<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Provider;

use Locastic\SyliusCatalogPromotionPlugin\Repository\CatalogPromotionRepository;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Webmozart\Assert\Assert;

class ChannelPricingProvider
{
    /**
     * @var FactoryInterface
     */
    private $channelPricingFactory;
    /**
     * @var CatalogPromotionRepository
     */
    private $catalogPromotionRepository;

    public function __construct(FactoryInterface $channelPricingFactory, CatalogPromotionRepository $catalogPromotionRepository)
    {
        $this->channelPricingFactory = $channelPricingFactory;
        $this->catalogPromotionRepository = $catalogPromotionRepository;
    }

    public function provideForProductVariant(ChannelInterface $channel, ProductVariantInterface $productVariant): ChannelPricingInterface
    {


        Assert::notNull($productVariant->getChannelPricingForChannel($channel), 'Product '.$productVariant->getName().' does not have channel pricing in '.$channel->getName().' channel.' );

        /** @var ChannelPricingInterface $channelPricing */
        $channelPricing = $this->channelPricingFactory->createNew();

        $channelPricing->setChannelCode($channel->getCode());
        $channelPricing->setProductVariant($productVariant);
        $channelPricing->setPrice($productVariant->getChannelPricingForChannel($channel)->getPrice());

        return $channelPricing;
    }
}