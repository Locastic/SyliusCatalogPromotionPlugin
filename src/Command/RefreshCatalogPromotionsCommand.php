<?php

declare(strict_types=1);

namespace Locastic\SyliusCatalogPromotionPlugin\Command;

use Doctrine\Common\Collections\Collection;
use Locastic\SyliusCatalogPromotionPlugin\Entity\ChannelPricingInterface;
use Locastic\SyliusCatalogPromotionPlugin\Promotion\Processor\CatalogPromotionProcessor;
use Sylius\Bundle\MoneyBundle\Templating\Helper\FormatMoneyHelper;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Currency\Context\CurrencyContextInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
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

    /**
     * @var FormatMoneyHelper
     */
    private $moneyHelper;

    /**
     * @var CurrencyContextInterface
     */
    private $currencyContext;

    /**
     * @var LocaleContextInterface
     */
    private $localeContext;

    public function __construct(
        CatalogPromotionProcessor $catalogPromotionProcessor,
        ChannelContextInterface $channelContext,
        FormatMoneyHelper $moneyHelper,
        LocaleContextInterface $localeContext,
        CurrencyContextInterface $currencyContext
    ) {
        $this->catalogPromotionProcessor = $catalogPromotionProcessor;
        $this->channelContext = $channelContext;
        $this->moneyHelper = $moneyHelper;
        $this->currencyContext = $currencyContext;
        $this->localeContext = $localeContext;

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
        $output->writeln([
           '<comment>Catalog promotion executor</comment>',
           '<comment>==========================</comment>',
           ''
        ]);

        /** @var ChannelInterface $channel */
        $channel = $this->channelContext->getChannel();

        $output->writeln('All your catalog promotions are about to be deactivated');

        /** @var Collection $deactivatedProducts */
        $deactivatedProducts = $this->catalogPromotionProcessor->deactivateCatalogPromotions($channel);

        $this->renderCatalogReport($output, $deactivatedProducts, 'deactivation');

        $output->writeln('Starting activation of your reserved catalog promotions.');

        /** @var Collection $activatedProducts */
        $activatedProducts = $this->catalogPromotionProcessor->activateCatalogPromotions($channel);

        $this->renderCatalogReport($output, $activatedProducts, 'activation');
    }

    private function renderCatalogReport(OutputInterface $output, Collection $subjects, string $commandType)
    {
        $commandArguments = $this->resolveCommandLineArguments($commandType);

        if ($subjects->isEmpty()) {
            $output->writeln(['<question>'.$commandArguments['catalogEmptyMessage'].'</question>', '']);

            return;
        }

        $localeCode = $this->localeContext->getLocaleCode();
        $currencyCode = $this->currencyContext->getCurrencyCode();

        $table = new Table($output);
        $table->setHeaders($commandArguments['tableHeaders']);

        foreach ($subjects as $subject) {
            call_user_func_array(
                [$this, $commandArguments['method']],
                [$table, $subject, $currencyCode, $localeCode]
            );
        }

        $table->render();

        $output->writeln([
            '<info>'.$commandArguments['successMessage'].'</info>',
            ''
        ]);
    }

    private function renderActivationTableRow(Table $table, ChannelPricingInterface $channelPricing, string $currencyCode, string $localeCode)
    {
        $table
            ->addRow([
                $channelPricing->getProductVariant()->getName(),
                $this->moneyHelper->formatAmount($channelPricing->getOriginalPrice(), $currencyCode, $localeCode),
                $this->moneyHelper->formatAmount($channelPricing->getPrice(), $currencyCode, $localeCode),
                $channelPricing->getAppliedCatalogPromotion()->getName()
            ]);
    }

    private function renderDeactivationTableRow(Table $table, array $deactivationSubject, string $currencyCode, string $localeCode)
    {
        list($channelPricing, $catalogPrice, $previouslyAppliedCatalog) = $deactivationSubject;

        $table
            ->addRow([
                $channelPricing->getProductVariant()->getName(),
                $this->moneyHelper->formatAmount($catalogPrice, $currencyCode, $localeCode),
                $this->moneyHelper->formatAmount($channelPricing->getPrice(), $currencyCode, $localeCode),
                $previouslyAppliedCatalog->getName()
            ]);
    }

    private function resolveCommandLineArguments(string $commandType): array
    {
        if (0 === strcmp('deactivation', $commandType)) {
            return [
                'catalogEmptyMessage'   => 'There are no active catalog promotions at the moment.',
                'tableHeaders'          => ['Product', 'Catalog price', 'Decativated price', 'Previously applied catalog promotion'],
                'successMessage'        => 'Succesfully deactivated catalog promotions from the upper table.',
                'method'                => 'renderDeactivationTableRow',
            ];
        }

        return [
            'catalogEmptyMessage'   => 'There are no active catalog promotions at the moment.',
            'tableHeaders'          => ['Product', 'Original price', 'New catalog price', 'Previously applied catalog promotion'],
            'successMessage'        => 'Succesfully activated catalog promotions from the upper table.',
            'method'                => 'renderActivationTableRow',
        ];
    }
}
