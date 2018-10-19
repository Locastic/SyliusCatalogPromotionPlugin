<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Repository;

use Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ChannelInterface;

class ChannelPricingRepository extends EntityRepository
{
    public function findAllWithAppliedCatalogPromotionsByChannel(ChannelInterface $channel)
    {
        $qb = $this->createQueryBuilder('o');
        $qb2 = $this->createQueryBuilder('o2');

        $qb
            ->andWhere(
                $qb->expr()->andX(
                    $qb->expr()->eq('o.channelCode', ':channelCode'),
                    $qb->expr()->gt('o.catalogPromotionPrice', 0),
                    $qb->expr()->in(
                        'o.appliedCatalogPromotion',
                        $qb2->select('cp.id')
                            ->from('Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotion', 'cp')
                            ->getDQL()
                    )
                )
            )
            ->setParameter('channelCode', $channel->getCode())
        ;

        return $qb->getQuery()->getResult();
    }
}