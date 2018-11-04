<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin;

use Locastic\SyliusCatalogPromotionPlugin\DependencyInjection\Compiler\RegisterCatalogPromotionActionsPass;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SyliusCatalogPromotionPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new RegisterCatalogPromotionActionsPass());
    }
}
