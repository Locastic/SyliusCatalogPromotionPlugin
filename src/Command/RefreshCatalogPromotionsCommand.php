<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RefreshCatalogPromotionsCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('locastic:catalog:refresh-promotions')
            ->setDescription('Refreshes catalog application statuses')
            ->setHelp('Refreshes application status for all catalog promotions based on current date and time, which promote or demote certain product prices.');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        dump('dija');
    }
}