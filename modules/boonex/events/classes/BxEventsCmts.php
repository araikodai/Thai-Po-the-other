<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxTemplCmtsView');

class BxEventsCmts extends BxTemplCmtsView
{
    /**
     * Constructor
     */
    function BxEventsCmts($sSystem, $iId)
    {
        parent::BxTemplCmtsView($sSystem, $iId);
    }

    function getMain()
    {
        $aPathInfo = pathinfo(__FILE__);
        require_once ($aPathInfo['dirname'] . '/BxEventsSearchResult.php');
        return BxEventsSearchResult::getMain();
    }

    function isPostReplyAllowed ()
    {
        if (!parent::isPostReplyAllowed())
            return false;
        $oMain = $this->getMain();
        $aEvent = $oMain->_oDb->getEntryByIdAndOwner($this->getId (), 0, true);
        return $oMain->isAllowedComments($aEvent);
    }

    function isEditAllowedAll ()
    {
        $oMain = $this->getMain();
        $aEvent = $oMain->_oDb->getEntryByIdAndOwner($this->getId (), 0, true);
        if ($oMain->isAllowedCreatorCommentsDeleteAndEdit ($aEvent))
            return true;
        return parent::isEditAllowedAll ();
    }

    function isRemoveAllowedAll ()
    {
        $oMain = $this->getMain();
        $aEvent = $oMain->_oDb->getEntryByIdAndOwner($this->getId (), 0, true);
        if ($oMain->isAllowedCreatorCommentsDeleteAndEdit ($aEvent))
            return true;
        return parent::isRemoveAllowedAll ();
    }
}
