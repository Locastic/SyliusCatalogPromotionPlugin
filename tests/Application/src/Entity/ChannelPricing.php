<?php

declare(strict_types=1);

namespace Tests\Acme\SyliusExamplePlugin\Application\src\Entity;

use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingAwareInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingTrait;
use Sylius\Component\Core\Model\ChannelPricing as BaseChannelPricing;

class ChannelPricing extends BaseChannelPricing implements ChannelPricingAwareInterface
{
    use ChannelPricingTrait;
}