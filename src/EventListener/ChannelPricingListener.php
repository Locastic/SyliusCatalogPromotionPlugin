<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManager;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricing;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingInterface;
use Locastic\SyliusCatalogPromotionPlugin\Util\DiscountResolver;

class ChannelPricingListener
{
    public function postLoadHandler(ChannelPricingInterface $channnelPricing, LifecycleEventArgs $eventArgs)
    {
        /** @var ChannelPricingInterface $entity */
        $entity = $eventArgs->getObject();

        if (!$entity instanceof ChannelPricing) {
            return;
        }

        $discountPercentage = DiscountResolver::getPromotionPercentage($channnelPricing);

        /** @var EntityManager $entityManager */
        $entityManager = $eventArgs->getObjectManager();
        $entity->setDiscountPercentage($discountPercentage);

        $entityManager->persist($entity);
    }
}