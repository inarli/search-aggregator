<?php


namespace SearchAggregator\Tests\Event\Listener;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use SearchAggregator\Event\Listener\Google;
use SearchAggregator\SearchResultItem;
use SearchAggregator\Tests\BaseTest;

class GoogleTest extends BaseTest
{
    /**
     * @var Google
     */
    private $googleListener;

    public function setUp()
    {
        $this->googleListener = new Google();
    }

    public function testBeforeRequest()
    {
        $url = 'http://www.google.com';
        $method = 'PATCH';
        $req = $this->googleListener->beforeRequest(new Request($method, $url));
        $this->assertTrue($req->getMethod() == $method);
        $this->assertTrue($req->getUri() == $url);
    }

    public function testAfterResponse()
    {
        $res = new Response(301);
        $res = $this->googleListener->afterResponse($res);
        $this->assertTrue($res->getStatusCode() == 301);
    }

    public function testSearchResultItemCallback()
    {
        $tinyUrl = 'http://www.google.com/url?q=https://pointerbrandprotection.com/&sa=U&ved=0ahUKEwjytdDG_LbfAhUBCiwKHRMMAaMQFggXMAA&usg=AOvVaw18BMbkMtSF5l_CZigCddal';
        $cleanUrl = 'https://pointerbrandprotection.com/';
        $searchResultItem = new SearchResultItem();
        $searchResultItem->setTitle('test')->setUrl($tinyUrl);
        $searchResultItem = $this->googleListener->searchResultItemCallback($searchResultItem);

        $this->assertTrue($searchResultItem->getUrl() == $cleanUrl);
    }

    public function testSearchResultCallback()
    {
        $data = ['mustafa' => 'pointer brand protetion'];
        $modified = $this->googleListener->searchResultCallback($data);
        $this->assertTrue($data['mustafa'] == $modified['mustafa']);
    }
}
