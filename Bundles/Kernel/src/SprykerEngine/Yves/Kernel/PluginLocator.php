<?php

namespace SprykerEngine\Yves\Kernel;

use SprykerEngine\Shared\Kernel\AbstractLocator;
use SprykerEngine\Shared\Kernel\LocatorLocatorInterface;

/**
 * Class YvesLocator
 * @package SprykerEngine\Yves\Kernel
 */
class PluginLocator extends AbstractLocator
{

    const SUFFIX = 'Plugin';

    /**
     * @var string
     */
    protected $factoryClassNamePattern = '\\{{namespace}}\\Yves\\Kernel\\Factory';

    /**
     * @param string                 $bundle
     * @param LocatorLocatorInterface $locator
     * @param null|string            $className
     *
     * @return object
     * @throws \SprykerEngine\Shared\Kernel\Locator\LocatorException
     */
    public function locate($bundle, LocatorLocatorInterface $locator, $className = null)
    {
        $factory = $this->getFactory($bundle);

        return $factory->create(ucfirst($className) . self::SUFFIX, $factory, $locator);
    }
}