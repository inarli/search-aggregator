<?php


namespace SearchAggregator\Provider;

use SearchAggregator\Event\Listener\ProviderListenerInterface;
use SearchAggregator\Exception\InvalidConfigurationParameterException;

/**
 * Class Provider
 * @package SearchAggregator\Provider
 */
final class Provider
{
    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $searchPath;

    /**
     * @var array
     */
    private $selectors;


    /**
     * @var ProviderListenerInterface
     */
    private $listener;

    /**
     * Provider constructor.
     *
     * @param array $providerConfig
     */
    public function __construct(array $providerConfig)
    {
        $this->setProviderConfig($providerConfig);
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getSearchPath(): string
    {
        return $this->searchPath;
    }

    /**
     * @return array
     */
    public function getSelectors(): array
    {
        return $this->selectors;
    }


    /**
     * @return ProviderListenerInterface
     */
    public function getListener(): ?ProviderListenerInterface
    {
        return $this->listener;
    }


    /**
     * Setting provider config parameters from an array.
     *
     * @param array $providerConfig
     */
    private function setProviderConfig(array $providerConfig)
    {
        $this->enabled = $providerConfig['enabled'];
        $this->host = $providerConfig['host'];
        $this->searchPath = $providerConfig['searchPath'];
        $this->selectors = $providerConfig['selectors'];

        if (array_key_exists('listener', $providerConfig) && class_exists($providerConfig['listener'])) {
            $this->listener = new $providerConfig['listener']();
        }
    }
}
