<?php


namespace SearchAggregator\Event\Listener;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use SearchAggregator\SearchResultItem;

interface ProviderListenerInterface
{

    /**
     * Running before request and return request object
     *
     * @param Request $request
     * @return Request
     */
    public function beforeRequest(Request $request): Request;

    /**
     * Running after response and return response object.
     *
     * @param Response $response
     * @return Response
     */
    public function afterResponse(Response $response): Response;

    /**
     * Running after SearchResultItem created.
     *
     * @param SearchResultItem $searchResultItem
     * @return SearchResultItem
     */
    public function searchResultItemCallback(SearchResultItem $searchResultItem): SearchResultItem;

    /**
     * Running after search result created.
     *
     * @param array $searchResult
     * @return array
     */
    public function searchResultCallback(array $searchResult): array;
}
