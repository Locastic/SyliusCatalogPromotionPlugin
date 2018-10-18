<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Executor;

use Locastic\SyliusCatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingInterface;
use Locastic\SyliusCatalogPromotionPlugin\Promotion\Action\Applicator\ChannelPricingPromotionApplicatorInterface;
use Sylius\Component\Promotion\Model\PromotionActionInterface;

class FixedDiscountPromotionActionExecutor implements ActionExecutorInterface
{
//    /**
//     * @var ChannelPricingPromotionApplicatorInterface
//     */
//    private $promotionApplicator;
//
//    public function __construct(ChannelPricingPromotionApplicatorInterface $promotionApplicator)
//    {
//        $this->promotionApplicator = $promotionApplicator;
//    }

    public function execute(ChannelPricingInterface $channelPricing, array $configuration /*, PromotionActionInterface $action*/, CatalogPromotionInterface $catalogPromotion): void
    {
//dd($configuration);
//$promoAmount ---- calculator?
        if (null === $this->appliedCatalogPromotion) {
            $channelPricing->applyCatalogPromotionAction($catalogPromotion, $promoAmount);
            //poruka dodano
        }


        if ($this->appliedCatalogPromotion->getPriority() < $catalogPromotion->getPriority()) {
            $this->detachAndApplyNewCatalogPromotionAction($catalogPromotion, $promoAmount);
            //poruka maknut stari dodan novi
        }

        //poruka postoji vec primjenjena katalog promocija na ovom proizvodu
        //$channelPricing->getProductVariant();
    }
}