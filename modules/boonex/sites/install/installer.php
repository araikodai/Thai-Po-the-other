<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

require_once(BX_DIRECTORY_PATH_CLASSES . "BxDolInstaller.php");

class BxSitesInstaller extends BxDolInstaller
{
    function BxSitesInstaller($aConfig)
    {
        parent::BxDolInstaller($aConfig);
    }

    function install($aParams)
    {
        $aResult = parent::install($aParams);

        if($aResult['result'] && BxDolRequest::serviceExists('wall', 'update_handlers'))
            BxDolService::call('wall', 'update_handlers', array($this->_aConfig['home_uri'], true));

        if($aResult['result'] && BxDolRequest::serviceExists('spy', 'update_handlers'))
            BxDolService::call('spy', 'update_handlers', array($this->_aConfig['home_uri'], true));

        $this->addHtmlFields(array ('POST.description', 'REQUEST.description'));
        $this->updateEmailTemplatesExceptions ();

        return $aResult;
    }

    function uninstall($aParams)
    {
        if(BxDolRequest::serviceExists('wall', 'update_handlers'))
            BxDolService::call('wall', 'update_handlers', array($this->_aConfig['home_uri'], false));

        if(BxDolRequest::serviceExists('spy', 'update_handlers'))
            BxDolService::call('spy', 'update_handlers', array($this->_aConfig['home_uri'], false));

        $this->removeHtmlFields();
        $this->updateEmailTemplatesExceptions ();

        return parent::uninstall($aParams);
    }
}
