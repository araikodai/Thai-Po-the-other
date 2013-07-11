<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

require_once(BX_DIRECTORY_PATH_CLASSES . "BxDolInstaller.php");

class BxNewsInstaller extends BxDolInstaller
{
    function BxNewsInstaller($aConfig)
    {
        parent::BxDolInstaller($aConfig);
    }

    function install($aParams)
    {
        $aResult = parent::install($aParams);

        $this->addHtmlFields(array('POST.content', 'REQUEST.content'));
        $this->updateEmailTemplatesExceptions ();

        return $aResult;
    }

    function uninstall($aParams)
    {
        $this->removeHtmlFields();
        $this->updateEmailTemplatesExceptions ();
        return parent::uninstall($aParams);
    }
}
