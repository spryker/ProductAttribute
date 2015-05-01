<?php

namespace SprykerEngine\Shared\Kernel;

use SprykerFeature\Shared\Library\Config;
use SprykerFeature\Shared\System\SystemConfig;

/**
 * This class represents a store!
 * @see https://project-a.atlassian.net/wiki/display/YUZ/Store+concept
 */
class Store
{

    /**
     * @var Store
     */
    protected static $instance;

    /**
     * Name of the store = name of the area
     * @link  https://project-a.atlassian.net/wiki/display/SYSOP/Port+numbering
     *
     * @var string
     */
    protected $storeName;

    /**
     * List of all storeNames
     * @var array
     */
    protected $allStoreNames;

    /**
     * List of locales
     * @var array
     */
    protected $locales;

    /**
     * List of countries
     * @var array
     */
    protected $countries;

    /**
     * Examples: DE, PL
     * @var string
     */
    protected $currentCountry;

    /**
     * Examples: de_DE, pl_PL
     * @var string
     */
    protected $currentLocale;

    /**
     * Examples: EUR, PLN
     * @link http://en.wikipedia.org/wiki/ISO_4217
     * @var string
     */
    protected $currencyIsoCode;

    /**
     * @var array
     */
    protected $contexts;

    /**
     * @var string
     */
    protected static $defaultStore;

    /**
     * @return Store
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return string
     */
    public static function getDefaultStore()
    {
        if (is_null(self::$defaultStore)) {
            self::$defaultStore = require APPLICATION_ROOT_DIR . '/config/Shared/default_store.php';
        }

        return self::$defaultStore;
    }

    protected function __construct()
    {
        $currentStoreName = APPLICATION_STORE;
        $this->initializeSetup($currentStoreName);
        $this->publish();
    }

    protected function publish()
    {
        header('X-Locale: ' . $this->getCurrentLocale());
        header('X-Store: ' . $this->getStoreName());
        header('X-Env: ' . APPLICATION_ENV);

        $newRelicApi = \SprykerFeature_Shared_Library_NewRelic_Api::getInstance();
        $newRelicApi->addCustomParameter('locale', $this->getCurrentLocale());
        $newRelicApi->addCustomParameter('store', $this->getStoreName());
    }

    /**
     * @param $currentStoreName
     *
     * @return array
     * @throws \Exception
     */
    protected function getStoreSetup($currentStoreName)
    {
        $stores = require APPLICATION_ROOT_DIR . '/config/Shared/stores.php';

        if (false === array_key_exists($currentStoreName, $stores)) {
            throw new \Exception('Missing setup for store: ' . $currentStoreName);
        }

        return $stores;
    }

    /**
     * @param $currentStoreName
     *
     * @throws \Exception
     */
    public function initializeSetup($currentStoreName)
    {
        $stores = $this->getStoreSetup($currentStoreName);
        $storeArray = $stores[$currentStoreName];

        $vars = get_object_vars($this);
        foreach ($storeArray as $k => $v) {
            if (array_key_exists($k, $vars)) {
                $this->$k = $v;
            } else {
                // bc
                if ('frontends' === $k) {
                    continue;
                }
                throw new \Exception('Unknown setup-key: ' . $k);
            }
        }

        $this->storeName = $currentStoreName;
        $this->allStoreNames = array_keys($stores);
        $this->setCurrentLocale(current($this->locales));
        $this->setCurrentCountry(current($this->countries));

        foreach ($vars as $k => $v) {
            if (empty($this->$k)) {
                throw new \Exception('Missing setup-key: ' . $k);
            }
        }
    }

    /**
     * @return string
     */
    public function getCurrentLocale()
    {
        return $this->currentLocale;
    }

    /**
     * @param $locale string The locale, e.g. 'DE_de'
     * @return string The language, e.g. 'de'
     */
    protected function getLanguageFromLocale($locale)
    {
        return substr($locale, 0, strpos($locale, '_'));
    }

    /**
     * @return string
     */
    public function getCurrentLanguage()
    {
        return $this->getLanguageFromLocale($this->currentLocale);
    }

    /**
     * @return array
     */
    public function getAllowedStores()
    {
        return $this->allStoreNames;
    }

    /**
     * @return array
     */
    public function getInactiveStores()
    {
        $inActiveStores = array();
        foreach ($this->getAllowedStores() as $store) {
            if ($this->storeName !== $store) {
                $inActiveStores[] = $store;
            }
        }

        return $inActiveStores;
    }

    /**
     * @return string
     */
    public function getCurrencyIsoCode()
    {
        return $this->currencyIsoCode;
    }

    /**
     * @return array
     */
    public function getLocales()
    {
        return $this->locales;
    }

    /**
     * @return string
     */
    public function getStoreName()
    {
        return $this->storeName;
    }

    /**
     * @param $storeName
     * @return $this
     */
    public function setStoreName($storeName)
    {
        $this->storeName = $storeName;

        return $this;
    }

    /**
     * @param $currentLocale
     */
    public function setCurrentLocale($currentLocale)
    {
        $this->currentLocale = $currentLocale;
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        return Config::get(SystemConfig::PROJECT_TIMEZONE);
    }

    /**
     * @return array
     */
    public function getContexts()
    {
        return $this->contexts;
    }

    /**
     * @return array
     */
    public function getCountries()
    {
        return $this->countries;
    }

    /**
     * @param $currentCountry
     */
    public function setCurrentCountry($currentCountry)
    {
        $this->currentCountry = $currentCountry;
    }

    /**
     * @return string
     */
    public function getCurrentCountry()
    {
        return $this->currentCountry;
    }

    /**
     * @return string
     */
    public function getStorePrefix()
    {
        $prefix = (\SprykerFeature_Shared_Library_Environment::isNotProduction()) ? 'DEV' : ''; // DEV = Testing
        $prefix .= $this->getStoreName();

        return $prefix;
    }
}