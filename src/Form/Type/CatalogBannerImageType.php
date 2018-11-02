<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Form\Type;

use Sylius\Bundle\CoreBundle\Form\Type\ImageType;

class CatalogBannerImageType extends ImageType
{
    public function getBlockPrefix(): string
    {
        return 'locastic_catalog_promotion_catalog_banner_image';
    }
}
