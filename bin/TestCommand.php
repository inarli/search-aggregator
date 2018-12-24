<?php


namespace SearchAggregator\Console;

use SearchAggregator\Helper\Util;
use SearchAggregator\Provider\ProviderRepository;
use SearchAggregator\Search;
use SearchAggregator\SearchResultItem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TestCommand
 * @package SearchAggregator\Console
 */
class TestCommand extends Command
{
    protected static $defaultName = 'test-tool';

    /**
     * Configure command.
     */
    protected function configure()
    {
        $this->addArgument('keyword', InputArgument::REQUIRED, 'Search keyword');
        $this->addArgument(
            'config',
            InputArgument::OPTIONAL,
            'Path of alternative config file (providers.yaml)'
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \SearchAggregator\Exception\SearchAggregatorException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configFile = $input->getArgument('config');
        $search = new Search();
        if ($configFile) {
            $providerRepository = new ProviderRepository($configFile);
            $search->setProviderRepository($providerRepository);
        }

        $outputRows = array();
        $result = $search->search($input->getArgument('keyword'));
        $table = new Table($output);
        $table->setHeaders(['Url', 'Title', 'Source']);

        foreach ($result as $item) {
            /** @var SearchResultItem $item */
            $url = Util::urlShortener($item->getUrl());
            $responseRow = [
                $url,
                $item->getTitle(),
                implode(', ', $item->getSource())
            ];
            array_push($outputRows, $responseRow);
        }
        $table->setRows($outputRows);
        $table->render();
    }
}
