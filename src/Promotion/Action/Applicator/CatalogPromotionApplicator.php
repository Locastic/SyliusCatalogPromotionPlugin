<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Applicator;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

class CatalogPromotionApplicator implements CatalogPromotionApplicatorInterface
{
    /**
     * @var ServiceRegistryInterface
     */
    private $registry;

    public function __construct(ServiceRegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    public function apply(ChannelPricingInterface $channelPricing, CatalogPromotionInterface $catalogPromotion): void
    {
        foreach ($catalogPromotion-)
    }

    public function revert(ChannelPricingInterface $channelPricing, CatalogPromotionInterface $catalogPromotion): void
    {
        // TODO: Implement revert() method.
    }
}