<?php


namespace SearchAggregator\Event\Listener;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use SearchAggregator\SearchResultItem;

class AbstractProviderListener implements ProviderListenerInterface
{
    /**
     * @param Request $request
     * @return Request
     */
    public function beforeRequest(Request $request): Request
    {
        return $request;
    }

    /**
     * @param Response $response
     * @return Response
     */
    public function afterResponse(Response $response): Response
    {
        return $response;
    }

    /**
     * @param SearchResultItem $searchResultItem
     * @return SearchResultItem
     */
    public function searchResultItemCallback(SearchResultItem $searchResultItem): SearchResultItem
    {
        return $searchResultItem;
    }

    /**
     * @param array $searchResult
     * @return array
     */
    public function searchResultCallback(array $searchResult): array
    {
        return $searchResult;
    }
}
