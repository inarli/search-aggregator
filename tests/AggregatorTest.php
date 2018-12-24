<?php


namespace SearchAggregator\Tests;

use SearchAggregator\Aggregator;
use SearchAggregator\SearchResultItem;

/**
 * Class AggregatorTest
 * @package SearchAggregator\Tests
 */
class AggregatorTest extends BaseTest
{
    /**
     * @var Aggregator
     */
    private $aggregator;

    public function setUp()
    {
        $this->aggregator = new Aggregator();
    }

    public function testAggregateResults()
    {
        $data = [];
        for ($i = 0; $i < 8; $i++) {
            $searchResultItem = new SearchResultItem();
            $searchResultItem->setUrl('http://url' . $i . '.com')->setTitle('Title*' . $i);
            $data[] = $searchResultItem;
        }
        $testData = [
            'google' => [
                $data[0]->getUrl() => $data[0],
                $data[1]->getUrl() => $data[1],
                $data[2]->getUrl() => $data[2],
                $data[7]->getUrl() => $data[7]
            ],
            'yahoo' => [
                $data[0]->getUrl() => $data[0],
                $data[3]->getUrl() => $data[3],
                $data[7]->getUrl() => $data[7]
            ],
            'bing' => [
                $data[1]->getUrl() => $data[1],
                $data[4]->getUrl() => $data[4],
                $data[7]->getUrl() => $data[7]
            ],
            'yandex' => [
                $data[5]->getUrl() => $data[5],
                $data[6]->getUrl() => $data[6],
                $data[7]->getUrl() => $data[7]
            ]
        ];
        $aggregatedTestData = $this->aggregator->aggregateResults($testData);
        $this->assertTrue(sizeof($aggregatedTestData) == 8);
        $this->assertTrue(sizeof(array_diff($aggregatedTestData[3]->getSource(), array_keys($testData))) == 0);
    }
}
