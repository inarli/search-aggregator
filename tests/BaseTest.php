<?php


namespace SearchAggregator\Tests;

/**
 * Class BaseTest
 * @package SearchAggregator\Tests
 */
class BaseTest extends \PHPUnit\Framework\TestCase
{
    public function testDump()
    {
        $this->assertTrue(true);
    }
    protected function invokeRestrictedMethodAndProperties($object, $methodName, $args = [], $properties = [])
    {
        $reflectionClass = new \ReflectionClass(get_class($object));
        $method = $reflectionClass->getMethod($methodName);
        $method->setAccessible(true);
        foreach ($properties as $propertyKey => $value) {
            $prop = $reflectionClass->getProperty($propertyKey);
            $prop->setAccessible(true);
            $prop->setValue($object, $value);
        }
        return $method->invokeArgs($object, $args);
    }
}
