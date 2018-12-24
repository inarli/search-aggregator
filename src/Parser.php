<?php


namespace SearchAggregator;

use Psr\Http\Message\ResponseInterface;
use SearchAggregator\Event\Dispatcher;
use SearchAggregator\Event\Event;
use Symfony\Component\DomCrawler\Crawler;
use SearchAggregator\Provider\Provider;

/**
 * Class Parser
 * @package SearchAggregator
 */
class Parser
{
    /**
     * Crawling response body and returns an array, it contains search results like key => url, value => title
     *
     * @param ResponseInterface $res
     * @param Provider $provider
     * @param string $key
     * @return array
     */
    public function parseResults(ResponseInterface $res, Provider $provider, string $key): array
    {
        $searchResults = [];
        $htmlOutput = $res->getBody()->getContents();
        $crawler = new Crawler($htmlOutput, $provider->getHost());
        $crawler->filter($provider->getSelectors()['row_selector'])->each(
            function (Crawler $node) use ($provider, &$searchResults, $key) {
                try {
                    //Title and link selection for each row.
                    $selectors = $provider->getSelectors();
                    $title = $node->filter($selectors['title_selector'])->text();
                    $link = $node->filter($selectors['link_selector'])->first()->link()->getUri();
                    $searchResultItem = new SearchResultItem();
                    $searchResultItem->setTitle($title)->setUrl($link);
                    /** @var SearchResultItem $searchResultItem */
                    $searchResultItem = Dispatcher::dispatchEvent(
                        $provider,
                        Event::SEARCH_RESULT_ITEM_CALLBACK,
                        $searchResultItem
                    );

                    if ($this->urlIsValid($searchResultItem->getUrl())) {
                        $searchResults[$searchResultItem->getUrl()] = $searchResultItem;
                    }
                } catch (\Exception $exception) {

                    //Crawl errors handled and logged. The flow is not blocked.
                    //@todo: log message
                }
            }
        );
        return $searchResults;
    }

    /**
     * Checking that url is valid or not valid.
     *
     * @param string $link
     * @return bool
     */
    private function urlIsValid(string $link): bool
    {
        return filter_var($link, FILTER_VALIDATE_URL);
    }
}
