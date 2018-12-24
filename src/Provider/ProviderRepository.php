<?php


namespace SearchAggregator\Provider;

use Symfony\Component\Yaml\Yaml;

/**
 * Class ProviderRepository
 * @package SearchAggregator\Provider
 */
class ProviderRepository
{
    /**
     * @var string
     */
    private $providerConfigurationFile = __DIR__ . '/../../config/providers.yaml';

    public function __construct(string $providerConfigurationFile = null)
    {
        $this->providerConfigurationFile = ($providerConfigurationFile) ?
            $providerConfigurationFile : $this->providerConfigurationFile;
    }

    /**
     * @return string
     */
    public function getProviderConfigurationFile(): string
    {
        return $this->providerConfigurationFile;
    }

    /**
     * Getting provider data as an array. It consists of Provider objects.
     *
     * @return array
     * @throws \SearchAggregator\Exception\MissingConfigurationException
     * @throws \SearchAggregator\Exception\SearchAggregatorException
     */
    public function getProviders(): array
    {
        $providerParameters = Yaml::parseFile($this->providerConfigurationFile);
        $providers = [];
        foreach ($providerParameters as $providerKey => $providerConfig) {
            if ($providerConfig['enabled']) {
                $provider = new Provider($providerConfig);
                $providerValidator = new ProviderValidator();
                $providerValidator->validate($provider);
                $providers[$providerKey] = $provider;
            }
        }
        return $providers;
    }
}
