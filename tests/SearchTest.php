<?php


namespace SearchAggregator\Tests;

use GuzzleHttp\Client;
use SearchAggregator\Aggregator;
use SearchAggregator\Parser;
use SearchAggregator\Provider\ProviderRepository;
use SearchAggregator\Requester;
use SearchAggregator\Search;

class SearchTest extends BaseTest
{
    /**
     * @var Search
     */
    private $search;

    public function setUp()
    {
        $this->search = new Search();
    }

    public function testSetterAndGetters()
    {
        $this->search->setProviderRepository(new ProviderRepository('sample'));
        $this->search->setAggregator(new Aggregator());
        $this->search->setParser(new Parser());
        $this->search->setRequester(new Requester(new Client(['cookies' => false, 'timeout' => 100.0])));

        $this->assertTrue($this->search->getProviderRepository()->getProviderConfigurationFile() == 'sample');
        $this->assertTrue($this->search->getAggregator() instanceof Aggregator);
        $this->assertTrue($this->search->getParser() instanceof Parser);
        $this->assertTrue($this->search->getRequester()->getClient()->getConfig('timeout') == 100);
    }
}
