<?php


namespace SearchAggregator;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use SearchAggregator\Provider\ProviderRepository;

/**
 * Class Search
 * @package SearchAggregator
 */
final class Search
{
    /**
     * @var Requester
     */
    private $requester;

    /**
     * @var Aggregator
     */
    private $aggregator;

    /** @var ProviderRepository */
    private $providerRepository;

    /** @var Parser */
    private $parser;

    /**
     * Search constructor.
     * @param Requester|null $requester
     * @param Aggregator|null $aggregator
     * @param ProviderRepository|null $providerRepository
     * @param Parser|null $parser
     */
    public function __construct(
        Requester $requester = null,
        Aggregator $aggregator = null,
        ProviderRepository $providerRepository = null,
        Parser $parser = null
    ) {
        $this->requester = ($requester) ? $requester : new Requester(
            new Client(['cookies' => true, 'timeout' => 15.0])
        );
        $this->aggregator = ($aggregator) ? $aggregator : new Aggregator();
        $this->providerRepository = ($providerRepository) ? $providerRepository : new ProviderRepository();
        $this->parser = ($parser) ? $parser : new Parser();
    }

    /**
     * @return Requester
     */
    public function getRequester(): Requester
    {
        return $this->requester;
    }

    /**
     * @param Requester $requester
     */
    public function setRequester(Requester $requester): void
    {
        $this->requester = $requester;
    }

    /**
     * @return Aggregator
     */
    public function getAggregator(): Aggregator
    {
        return $this->aggregator;
    }

    /**
     * @param Aggregator $aggregator
     */
    public function setAggregator(Aggregator $aggregator): void
    {
        $this->aggregator = $aggregator;
    }

    /**
     * @return ProviderRepository
     */
    public function getProviderRepository(): ProviderRepository
    {
        return $this->providerRepository;
    }

    /**
     * @param ProviderRepository $providerRepository
     */
    public function setProviderRepository(ProviderRepository $providerRepository): void
    {
        $this->providerRepository = $providerRepository;
    }

    /**
     * @return Parser
     */
    public function getParser(): Parser
    {
        return $this->parser;
    }

    /**
     * @param Parser $parser
     */
    public function setParser(Parser $parser): void
    {
        $this->parser = $parser;
    }

    /**
     * Search keyword on enabled providers.
     *
     * @param $keyword
     * @return array
     * @throws Exception\SearchAggregatorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function search($keyword): array
    {
        $searchResults = $this->getSearchResultsFromProviders($keyword);
        return $this->aggregator->aggregateResults($searchResults);
    }

    /**
     * Get search results from providers.
     *
     * @param $keyword
     * @return array
     * @throws Exception\SearchAggregatorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getSearchResultsFromProviders($keyword)
    {
        $providers = $this->providerRepository->getProviders();
        $resultsByProviders = [];
        foreach ($providers as $providerKey => $provider) {
            $response = $this->requester->getResult($provider, $keyword);
            if ($response instanceof ResponseInterface) {
                $resultsByProviders[$providerKey] = $this->parser->parseResults($response, $provider, $providerKey);
            }
        }
        return $resultsByProviders;
    }
}
