<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin;

use Doctrine\Common\Collections\Collection;
use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingInterface;
use Locastic\SyliusCatalogPromotionPlugin\Provider\CatalogPromotionProvider;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CatalogTwigExtension extends AbstractExtension
{
    /**
     * @var CatalogPromotionProvider
     */
    private $catalogPromotionProvider;

    public function __construct(CatalogPromotionProvider $catalogPromotionProvider)
    {
        $this->catalogPromotionProvider = $catalogPromotionProvider;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getProductsFromCatalog', [$this, 'getProductsFromCatalog']),
        ];
    }

    public function getProductsFromCatalog(CatalogPromotionInterface $catalogPromotion): Collection
    {
        return $this->catalogPromotionProvider->getProducts($catalogPromotion);
    }
}