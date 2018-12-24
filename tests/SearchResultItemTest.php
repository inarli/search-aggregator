<?php


namespace SearchAggregator\Tests;

use SearchAggregator\SearchResultItem;

/**
 * Class SearchResultItemTest
 * @package SearchAggregator\Tests
 */
class SearchResultItemTest extends BaseTest
{
    public function testSearchResultItem()
    {
        $title = 'Pointer Brand Protection: Online Brand Protection With An Impact';
        $url = 'https://pointerbrandprotection.com/';
        $searchResultItem = new SearchResultItem();
        $searchResultItem->setTitle($title)->setUrl($url);
        $searchResultItem->addSource('google')->addSource('yandex');

        $this->assertTrue($searchResultItem->getTitle() == $title);
        $this->assertTrue($searchResultItem->getUrl() == $url);
        $this->assertIsArray($searchResultItem->getSource());
        $this->assertTrue(in_array('google', $searchResultItem->getSource()));
        $this->assertTrue(in_array('yandex', $searchResultItem->getSource()));
    }
}
