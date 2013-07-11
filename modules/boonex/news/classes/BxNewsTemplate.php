<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolTextTemplate');

class BxNewsTemplate extends BxDolTextTemplate
{
    function BxNewsTemplate(&$oConfig, &$oDb)
    {
        parent::BxDolTextTemplate($oConfig, $oDb);

        $this->sCssPrefix = 'news';
    }
}
