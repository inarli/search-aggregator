<?php


namespace SearchAggregator\Tests;

use GuzzleHttp\Psr7\Response;
use SearchAggregator\Parser;
use SearchAggregator\Provider\Provider;
use SearchAggregator\Provider\ProviderRepository;

/**
 * Class ParserTest
 * @package SearchAggregator\Tests
 */
class ParserTest extends BaseTest
{
    /** @var Parser */
    private $parser;

    /** @var Provider */
    private $testProvider;

    public function setUp()
    {
        $providerRepository = new ProviderRepository();
        $this->parser = new Parser();
        $this->testProvider = $providerRepository->getProviders()['google'];
    }

    public function testUrlIsValid()
    {
        $validUrl = $this->invokeRestrictedMethodAndProperties(
            $this->parser,
            'urlIsValid',
            ['link' => 'https://pointerbrandprotection.com/']
        );

        $notValidUrl = $this->invokeRestrictedMethodAndProperties(
            $this->parser,
            'urlIsValid',
            ['link' => 'Not A Valid Url']
        );
        $this->assertTrue($validUrl);
        $this->assertFalse($notValidUrl);
    }

    public function testParseResults()
    {
        $body = file_get_contents(__DIR__. '/data/google_sample_test.html');
        $sample_response = new Response(200, [], $body);
        $result = $this->parser->parseResults($sample_response, $this->testProvider, 'google');
        $this->assertTrue(sizeof($result) == 6);
        $this->assertArrayHasKey('https://pointerbrandprotection.com/', $result);
        $this->assertTrue($result['https://pointerbrandprotection.com/']->getTitle() == 'Pointer Brand Protection: Online Brand Protection With An Impact');

        foreach ($result as $item) {
            $this->assertObjectHasAttribute('title', $item);
        }
    }
}
