<?php


namespace SearchAggregator\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use SearchAggregator\Provider\Provider;
use SearchAggregator\Requester;

/**
 * Class RequesterTest
 * @package SearchAggregator\Tests
 */
class RequesterTest extends BaseTest
{
    /** @var Requester */
    private $requester;

    /** @var Provider */
    private $testProvider;

    public function setUp()
    {
        $clientMock = $this->getMockBuilder(Client::class)->setMethods(['request'])->getMock();
        $clientMock->method('request')->will($this->returnValue(new Response()));

        $this->requester = new Requester($clientMock);
        $this->testProvider = new Provider(['host' => 'http://www.google.com', 'searchPath' => '?q=%s']);
    }

    public function testGetResponse()
    {
        $testResponse = $this->invokeRestrictedMethodAndProperties(
            $this->requester,
            'getResponse',
            [$this->testProvider, 'test']
        );
        $this->assertTrue($testResponse->getStatusCode() == 200);
        $this->assertInstanceOf(ResponseInterface::class, $testResponse);
    }

    public function testGetResult()
    {
        $testResponse = $this->requester->getResult($this->testProvider, 'test');
        $this->assertTrue($testResponse->getStatusCode() == 200);
        $this->assertInstanceOf(ResponseInterface::class, $testResponse);
    }

    public function testBuildQueryUrl()
    {
        $expectedUrl = 'http://www.google.com/search?&q=pointer+brand+protection';
        $builtQueryUrl = $this->invokeRestrictedMethodAndProperties(
            $this->requester,
            'buildQueryUrl',
            ['http://www.google.com', '/search?&q=%s', 'pointer brand protection']
        );

        $this->assertTrue($expectedUrl == $builtQueryUrl);
    }
}
