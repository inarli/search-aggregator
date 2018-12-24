<?php


namespace SearchAggregator;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use SearchAggregator\Event\Dispatcher;
use SearchAggregator\Event\Event;
use SearchAggregator\Provider\Provider;

/**
 * Class Requester
 * @package SearchAggregator
 */
class Requester
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Get response of HTTP request from provider.
     *
     * @param Provider $provider
     * @param string $keyword
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getResponse(Provider $provider, string $keyword): ResponseInterface
    {
        $url = $this->buildQueryUrl($provider->getHost(), $provider->getSearchPath(), $keyword);
        $request = new Request('GET', $url);
        /** @var Request $request */
        $request = Dispatcher::dispatchEvent($provider, Event::BEFORE_REQUEST_EVENT, $request);
        $response = $this->client->send($request);
        //@todo implement after response method
        return $response;
    }

    /**
     * Return search result response object. When get an error it will returns null
     *
     * @param Provider $provider
     * @param string $keyword
     * @return null|ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getResult(Provider $provider, string $keyword): ?ResponseInterface
    {
        try {
            $res = $this->getResponse($provider, $keyword);
            if ($res->getStatusCode() == 200) {
                return $res;
            }
        } catch (BadResponseException $exception) {
            return null;
            /*
             * If the provider is down or blocked, it returns a different status code than 200;
             * This condition is handled and logged, the flow is not blocking.
             */
            //@todo: log message.
        }
    }

    /**
     * Building a url with query params and keyword
     *
     * @param string $host
     * @param string $searchPath
     * @param string $keyword
     * @return string
     */
    private function buildQueryUrl(string $host, string $searchPath, string $keyword): string
    {
        $query = sprintf($searchPath, urlencode($keyword));
        return $host . $query;
    }
}
