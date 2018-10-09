<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Command;

use Locastic\SyliusCatalogPromotionPlugin\Promotion\Processor\CatalogPromotionProcessor;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RefreshCatalogPromotionsCommand extends Command
{
    /**
     * @var CatalogPromotionProcessor
     */
    private $catalogPromotionProcessor;

    /**
     * @var ChannelContextInterface
     */
    private $channelContext;

    public function __construct(CatalogPromotionProcessor $catalogPromotionProcessor, ChannelContextInterface $channelContext)
    {
        $this->catalogPromotionProcessor = $catalogPromotionProcessor;
        $this->channelContext = $channelContext;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('locastic:catalog:refresh-promotions')
            ->setDescription('Refreshes catalog application statuses')
            ->setHelp('Refreshes application status for all catalog promotions based on current date and time, which promote or demote certain product prices.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $channel = $this->channelContext->getChannel();

        $this->catalogPromotionProcessor->process($channel);
    }
}