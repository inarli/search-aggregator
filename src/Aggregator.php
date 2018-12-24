<?php


namespace SearchAggregator;

use SearchAggregator\Provider\Provider;

/**
 * Class Aggregator
 * @package SearchAggregator
 */
class Aggregator
{
    /**
     * Aggregate search results by source and url. Return an array. It consists of SearchResultItem objects.
     *
     * @param array $resultsByProvider
     * @return array
     */
    public function aggregateResults(array $resultsByProvider): array
    {
        $aggregatedResults = [];
        foreach ($resultsByProvider as $providerKey => $result) {
            /** @var Provider $provider */
            foreach ($result as $url => $resultItem) {
                /** @var SearchResultItem $resultItem */
                if (isset($aggregatedResults[$url])) {
                    /** @var SearchResultItem $searchResultItem */
                    $searchResultItem = $aggregatedResults[$url];
                    $searchResultItem->addSource($providerKey);
                } else {
                    $resultItem->addSource($providerKey);
                    $aggregatedResults[$url] = $resultItem;
                }
            }
        }
        return array_values($aggregatedResults);
    }
}
