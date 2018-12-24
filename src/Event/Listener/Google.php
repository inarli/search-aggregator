<?php


namespace SearchAggregator\Event\Listener;

use SearchAggregator\Helper\Util;
use SearchAggregator\SearchResultItem;

class Google extends AbstractProviderListener
{

    /**
     * Running after SearchResultItem created.
     *
     * @param SearchResultItem $searchResultItem
     * @return SearchResultItem
     */
    public function searchResultItemCallback(SearchResultItem $searchResultItem): SearchResultItem
    {
        $searchResultItem->setUrl(Util::googleUrlCleaner($searchResultItem->getUrl()));
        return $searchResultItem;
    }
}
