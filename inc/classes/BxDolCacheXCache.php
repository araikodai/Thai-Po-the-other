<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolCache');

class BxDolCacheXCache extends BxDolCache
{
    var $iTTL = 3600;

    /**
     * constructor
     */
    function BxDolCacheXCache()
    {
        parent::BxDolCache();
    }

    /**
     * Get data from shared memory cache
     *
     * @param  string $sKey - file name
     * @param  int    $iTTL - time to live
     * @return the    data is got from cache.
     */
    function getData($sKey, $iTTL = false)
    {
        if (!xcache_isset($sKey))
            return null;

        return xcache_get($sKey);
    }
    /**
     * Save data in shared memory cache
     *
     * @param  string  $sKey      - file name
     * @param  mixed   $mixedData - the data to be cached in the file
     * @param  int     $iTTL      - time to live
     * @return boolean result of operation.
     */
    function setData($sKey, $mixedData, $iTTL = false)
    {
        $bResult = xcache_set($sKey, $mixedData, false === $iTTL ? $this->iTTL : $iTTL);
        return $bResult;
    }

    /**
     * Delete cache from shared memory
     *
     * @param  string $sKey - file name
     * @return result of the operation
     */
    function delData($sKey)
    {
        if (!xcache_isset($sKey))
            return true;

        return xcache_unset($sKey);
    }

    /**
     * Check if xcache functions are available
     * @return boolean
     */
    function isAvailable()
    {
        return function_exists('xcache_set');
    }

    /**
     * Check if xcache extension is loaded
     * @return boolean
     */
    function isInstalled()
    {
        return extension_loaded('xcache');
    }

    /**
     * remove all data from cache by key prefix
     * @return true on success
     */
    function removeAllByPrefix ($s)
    {
        return xcache_unset_by_prefix ($s);
    }

    /**
     * get size of cached data by name prefix
     */
    function getSizeByPrefix ($s)
    {
        // not implemented for current cache
        return false;
    }
}
