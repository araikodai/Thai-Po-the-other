<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

require_once(BX_DIRECTORY_PATH_CLASSES . "BxDolInstaller.php");

class BxProfileCustomizeInstaller extends BxDolInstaller
{
    function BxProfileCustomizeInstaller($aConfig)
    {
        parent::BxDolInstaller($aConfig);
    }

    function install($aParams)
    {
        $aResult = parent::install($aParams);
        return $aResult;
    }

    function uninstall($aParams)
    {
        return parent::uninstall($aParams);
    }
}
