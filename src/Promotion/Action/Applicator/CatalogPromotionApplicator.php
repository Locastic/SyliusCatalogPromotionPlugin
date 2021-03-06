<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Applicator;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionGroupInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingInterface;
use Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Executor\ActionExecutorInterface;
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

    public function apply(ChannelPricingInterface $channelPricing, CatalogPromotionGroupInterface $promotionGroup): void
    {
        $action = $promotionGroup->getAction();

        if (null !== $action) {
            $this->getActionExecutor($action->getType())->execute($channelPricing, $action->getConfiguration(), $promotionGroup);
        }
    }

    public function getActionExecutor(string $actionType): ActionExecutorInterface
    {
        return $this->registry->get($actionType);
    }
}
