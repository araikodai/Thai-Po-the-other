<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxTemplCmtsView');

class BxBlogsCmts extends BxTemplCmtsView
{
    /**
     * Constructor
     */
    function BxBlogsCmts($sSystem, $iId)
    {
        parent::BxTemplCmtsView($sSystem, $iId);
    }

    function getMain()
    {
        $aPathInfo = pathinfo(__FILE__);
        require_once ($aPathInfo['dirname'] . '/BxBlogsSearchUnit.php');
        return BxBlogsSearchUnit::getBlogsMain();
    }

    function isPostReplyAllowed()
    {
        if (!parent::isPostReplyAllowed())
            return false;
        $oMain = $this->getMain();
        $aBlogPost = $oMain->_oDb->getPostInfo($this->getId(), 0, true);
        return $oMain->isAllowedComments($aBlogPost);
    }

    function isEditAllowedAll()
    {
        $oMain = $this->getMain();
        $aBlogPost = $oMain->_oDb->getPostInfo($this->getId(), 0, true);
        if ($oMain->isAllowedCreatorCommentsDeleteAndEdit($aBlogPost))
            return true;
        return parent::isEditAllowedAll();
    }

    function isRemoveAllowedAll()
    {
        $oMain = $this->getMain();
        $aBlogPost = $oMain->_oDb->getPostInfo($this->getId(), 0, true);
        if ($oMain->isAllowedCreatorCommentsDeleteAndEdit($aBlogPost))
            return true;
        return parent::isRemoveAllowedAll();
    }
}
