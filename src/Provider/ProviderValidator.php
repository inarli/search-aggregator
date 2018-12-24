<?php


namespace SearchAggregator\Provider;

use SearchAggregator\Exception\MissingConfigurationException;
use Symfony\Component\Validator\Validation;

/**
 * Class ProviderValidator
 * @package SearchAggregator\Provider
 */
class ProviderValidator
{
    /**
     * @param Provider $provider
     * @throws MissingConfigurationException
     */
    public function validate(Provider $provider)
    {
        $validator = Validation::createValidatorBuilder()
            ->addYamlMapping(__DIR__ . '/../../config/provider_validation.yaml')
            ->getValidator();
        $errors = $validator->validate($provider);
        foreach ($errors as $error) {
            $errorMessage = sprintf('%s : %s', $error->getPropertyPath(), $error->getMessage());
            throw new MissingConfigurationException($errorMessage);
        }
    }
}
