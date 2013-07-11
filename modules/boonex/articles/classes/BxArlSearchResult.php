<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolTextSearchResult');

class BxArlSearchResult extends BxDolTextSearchResult
{
    function BxArlSearchResult($oModule = null)
    {
        $oModule = !empty($oModule) ? $oModule : BxDolModule::getInstance('BxArlModule');

        parent::BxDolTextSearchResult($oModule);
    }
}
