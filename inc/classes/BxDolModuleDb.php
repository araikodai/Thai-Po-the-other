<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

require_once('BxDolDb.php');
require_once('BxDolConfig.php');

class BxDolModuleDb extends BxDolDb
{
    var $_sPrefix;
    /*
     * Constructor.
     */
    function BxDolModuleDb($oConfig = null)
    {
        parent::BxDolDb();

        if(is_a($oConfig,'BxDolConfig'))
            $this->_sPrefix = $oConfig->getDbPrefix();
    }
    function getPrefix()
    {
        return $this->_sPrefix;
    }
    function getModuleById($iId)
    {
        $sSql = "SELECT `id`, `title`, `vendor`, `version`, `update_url`, `path`, `uri`, `class_prefix`, `db_prefix`, `dependencies`, `date` FROM `sys_modules` WHERE `id`='" . $iId . "' LIMIT 1";
        return $this->fromMemory('sys_modules_' . $iId, 'getRow', $sSql);
    }
    function getModuleByUri($sUri)
    {
        $sSql = "SELECT `id`, `title`, `vendor`, `version`, `update_url`, `path`, `uri`, `class_prefix`, `db_prefix`, `dependencies`, `date` FROM `sys_modules` WHERE `uri`='" . $sUri . "' LIMIT 1";
        return $this->fromMemory('sys_modules_' . $sUri, 'getRow', $sSql);
    }
    function isModule($sUri)
    {
        $sSql = "SELECT `id` FROM `sys_modules` WHERE `uri`='" . $sUri . "' LIMIT 1";
        return (int)$this->getOne($sSql) > 0;
    }
    function isModuleParamsUsed($sUri, $sPath, $sPrefixDb, $sPrefixClass)
    {
        $sSql = "SELECT `id` FROM `sys_modules` WHERE `uri`='" . $sUri . "' || `path`='" . $sPath . "' || `db_prefix`='" . $sPrefixDb . "' || `class_prefix`='" . $sPrefixClass . "' LIMIT 1";
        return (int)$this->getOne($sSql) > 0;
    }
    function getModules()
    {
        $sSql = "SELECT `id`, `title`, `vendor`, `version`, `update_url`, `path`, `uri`, `class_prefix`, `db_prefix`, `dependencies`, `date` FROM `sys_modules` ORDER BY `title`";
        return $this->fromMemory('sys_modules', 'getAll', $sSql);
    }
    function getDependent($sUri)
    {
        $sSql = "SELECT `id`, `title` FROM `sys_modules` WHERE `dependencies` LIKE '%" . $sUri . "%'";
        return $this->getAll($sSql);
    }
}
