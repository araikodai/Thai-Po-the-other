<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolTextSearchResult');

class BxNewsSearchResult extends BxDolTextSearchResult
{
    function BxNewsSearchResult($oModule = null)
    {
        $oModule = !empty($oModule) ? $oModule : BxDolModule::getInstance('BxNewsModule');

        parent::BxDolTextSearchResult($oModule);
    }
}
