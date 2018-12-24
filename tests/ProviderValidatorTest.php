<?php


namespace SearchAggregator\Tests;

use SearchAggregator\Provider\Provider;
use SearchAggregator\Provider\ProviderValidator;

class ProviderValidatorTest extends BaseTest
{

    /**
     * @var ProviderValidator
     */
    private $providerValidator;

    /**
     * @var array
     */
    private $providerData;

    public function setUp()
    {
        $this->providerValidator = new ProviderValidator();
        $this->providerData =
            [
                'enabled' => true,
                'host' => 'http://www.google.com',
                'searchPath' => '?q=%s',
                'selectors' => [
                    'row_selector' => 'row.selector',
                    'title_selector' => 'title.selector',
                    'link_selector' => 'link.selector'
                ]
            ];
    }


    /**
     * @expectedException SearchAggregator\Exception\MissingConfigurationException
     * @expectedExceptionMessage enabled : This value should not be null.
     */
    public function testValidationEnabled()
    {
        unset($this->providerData['enabled']);
        $result = $this->providerValidator->validate(new Provider($this->providerData));
        var_dump($result);
    }

    /**
     * @expectedException SearchAggregator\Exception\MissingConfigurationException
     * @expectedExceptionMessage host : This value should not be null.
     */
    public function testValidationHost()
    {
        unset($this->providerData['host']);
        $result = $this->providerValidator->validate(new Provider($this->providerData));
        var_dump($result);
    }

    /**
     * @expectedException SearchAggregator\Exception\MissingConfigurationException
     * @expectedExceptionMessage searchPath : This value should not be null.
     */
    public function testValidationSearchPath()
    {
        unset($this->providerData['searchPath']);
        $result = $this->providerValidator->validate(new Provider($this->providerData));
        var_dump($result);
    }
}
