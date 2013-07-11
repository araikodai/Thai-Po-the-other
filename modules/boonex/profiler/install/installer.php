<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import("BxDolInstaller");

class BxProfilerInstaller extends BxDolInstaller
{
    function BxProfilerInstaller($aConfig)
    {
        parent::BxDolInstaller($aConfig);
    }

    function install($aParams)
    {
        $aResult = parent::install($aParams);

        $this->updateEmailTemplatesExceptions ();
        $this->updateProfileFieldsHtml ();
        $this->updateSystemExceptions ();

        return $aResult;
    }

}
