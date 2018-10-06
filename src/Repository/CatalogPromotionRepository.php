<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ChannelInterface;

class CatalogPromotionRepository extends EntityRepository
{
    public function findActiveCatalogPromotionsByChannel(ChannelInterface $channel)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.startsAt IS NULL OR p.startsAt < :date')
            ->andWhere('p.endsAt IS NULL OR p.endsAt > :date')
            ->andWhere(':channel IS MEMBER OF p.channels')
            ->setParameter('date', new \DateTime())
            ->setParameter('channel', $channel)
            ->addOrderBy('p.priority', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}