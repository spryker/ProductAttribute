<?php

/**
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerEngine\Shared\Lumberjack\Model\Collector;

use SprykerEngine\Shared\Kernel\Store;

class EnvironmentDataCollector extends AbstractDataCollector
{

    const TYPE = 'environment';

    const FIELD_APP = 'app';

    const FIELD_APP_ENV = 'app_env';

    const FIELD_DATE_TIME = 'date_time';

    const FIELD_APP_STORE = 'app_store';

    const FIELD_APP_LANGUAGE = 'app_language';

    const FIELD_APP_LOCALE = 'app_locale';

    const FIELD_APP_CURRENCY = 'app_currency';

    /**
     * @return array
     */
    public function getData()
    {
        return [
            self::FIELD_APP => APPLICATION,
            self::FIELD_APP_ENV => APPLICATION_ENV,
            self::FIELD_DATE_TIME => gmdate('Y-m-d H:i:s'),
            self::FIELD_APP_STORE => Store::getInstance()->getStoreName(),
            self::FIELD_APP_LANGUAGE => Store::getInstance()->getCurrentLanguage(),
            self::FIELD_APP_LOCALE => Store::getInstance()->getCurrentLocale(),
            self::FIELD_APP_CURRENCY => Store::getInstance()->getCurrencyIsoCode(),
        ];
    }

}
