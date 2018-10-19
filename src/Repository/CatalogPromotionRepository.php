<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ChannelInterface;

class CatalogPromotionRepository extends EntityRepository
{
    public function findActiveCatalogPromotionsByChannel(ChannelInterface $channel)
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->andWhere(
                $qb->expr()->andX(
                    $qb->expr()->orX(
                        $qb->expr()->isNull('p.startsAt'),
                        $qb->expr()->lt('p.startsAt', ':date')
                    ),
                    $qb->expr()->orX(
                        $qb->expr()->isNull('p.endsAt'),
                        $qb->expr()->gt('p.endsAt', ':date')
                    ),
                    $qb->expr()->isMemberOf(':channel', 'p.channels')
                )
            )
            ->setParameter('date', new \DateTime())
            ->setParameter('channel', $channel)
        ;

        return $qb->getQuery()->getResult();
    }
}