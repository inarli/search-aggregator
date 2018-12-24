<?php


namespace SearchAggregator\Tests\Provider;

use SearchAggregator\Provider\Provider;
use SearchAggregator\Tests\BaseTest;

class ProviderTest extends BaseTest
{
    /**
     * @var Provider
     */
    private $provider;

    private $providerParams = [
        'enabled' => true,
        'host' => 'http://www.google.com',
        'searchPath' => '?q=%s',
        'selectors' => [
            'row_selector' => 'row.selector',
            'title_selector' => 'title.selector',
            'link_selector' => 'link.selector'
        ]
    ];

    public function setUp()
    {
        $this->provider = new Provider($this->providerParams);
    }

    public function testGettersAndSetters()
    {
        $this->assertTrue($this->provider->isEnabled() == $this->providerParams['enabled']);
        $this->assertTrue($this->provider->getSearchPath() == $this->providerParams['searchPath']);
        $this->assertTrue($this->provider->getHost() == $this->providerParams['host']);
        $this->assertArrayHasKey('row_selector', $this->provider->getSelectors());
        $this->assertArrayHasKey('title_selector', $this->provider->getSelectors());
        $this->assertArrayHasKey('link_selector', $this->provider->getSelectors());
    }
}
