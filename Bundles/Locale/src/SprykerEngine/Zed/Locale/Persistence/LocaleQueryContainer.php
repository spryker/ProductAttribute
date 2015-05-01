<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerEngine\Zed\Locale\Persistence;

use SprykerEngine\Zed\Kernel\Persistence\AbstractQueryContainer;
use SprykerEngine\Zed\Locale\Persistence\Propel\SpyLocaleQuery;

class LocaleQueryContainer extends AbstractQueryContainer implements LocaleQueryContainerInterface
{
    /**
     * @param string $localeName
     *
     * @return SpyLocaleQuery
     */
    public function queryLocaleByName($localeName)
    {
        $query = SpyLocaleQuery::create();
        $query
            ->filterByLocaleName($localeName)
        ;

        return $query;
    }

    /**
     * @return SpyLocaleQuery
     */
    public function queryLocales()
    {
        $query = SpyLocaleQuery::create();

        return $query;
    }
}