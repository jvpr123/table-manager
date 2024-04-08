<?php

namespace Tests;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(now());
    }

    protected function getPrivateProperty(object $class, string $property)
    {
        $reflection = new \ReflectionClass($class);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($class);
    }

    protected function setPrivateProperty(object $class, string $property, mixed $value)
    {
        $reflection = new \ReflectionClass($class);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);
        $property->setValue($class, $value);

        return $property->getValue($class);
    }

    protected function executePrivateMethod(object $class, string $method, array $args)
    {
        $reflection = new \ReflectionClass($class);
        $method = $reflection->getMethod($method);
        $method->setAccessible(true);

        $result = $method->invokeArgs($class, $args);
        $method->setAccessible(false);

        return $result;
    }
}
