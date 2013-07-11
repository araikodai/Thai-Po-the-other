<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxTemplCmtsView');

class BxAdsCmts extends BxTemplCmtsView
{
    /**
     * Constructor
     */
    function BxAdsCmts($sSystem, $iId)
    {
        parent::BxTemplCmtsView($sSystem, $iId);
    }

    function isPostReplyAllowed()
    {
        if (!parent::isPostReplyAllowed())
            return false;
        $oMain = BxDolModule::getInstance('BxAdsModule');
        $aAdPost = $oMain->_oDb->getAdInfo($this->getId());
        return $oMain->isAllowedComments($aAdPost);
    }
}
