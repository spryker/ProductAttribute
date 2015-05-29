<?php

namespace Unit\SprykerFeature\Zed\Application;

use Generated\Zed\Ide\AutoCompletion;
use SprykerEngine\Shared\Config;
use SprykerEngine\Zed\Kernel\Locator;
use SprykerFeature\Zed\Application\ApplicationConfig;

class ApplicationConfigTest extends \PHPUnit_Framework_TestCase
{

    private function getConfig()
    {
        return new ApplicationConfig(Config::getInstance(), $this->getLocator());
    }

    /**
     * @return \SprykerEngine\Shared\Kernel\AbstractLocatorLocator|static|AutoCompletion
     */
    private function getLocator()
    {
        return Locator::getInstance();
    }

    public function testGetMaxMenuLevelCountShouldReturnInteger()
    {
        $this->assertInternalType('integer', $this->getConfig()->getMaxMenuLevelCount());
    }

    public function testGetNavigationSchemaPathPatternShouldReturnArrayWithOneEntry()
    {
        $navigationSchemaPathPatterns = $this->getConfig()->getNavigationSchemaPathPattern();
        $this->assertInternalType('array', $navigationSchemaPathPatterns);
        $this->assertCount(1, $navigationSchemaPathPatterns);
    }

    public function testGetNavigationSchemaFileNamePatternShouldReturnString()
    {
        $this->assertInternalType('string', $this->getConfig()->getNavigationSchemaFileNamePattern());
    }
}
