<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolFilesModule');
define('PROFILE_VIDEO_CATEGORY', 'Profile videos');

class BxVideosModule extends BxDolFilesModule
{
    function BxVideosModule (&$aModule)
    {
        parent::BxDolFilesModule($aModule);

        // add more sections for administration
        $this->aSectionsAdmin['processing'] = array('exclude_btns' => 'all');
        $this->aSectionsAdmin['failed'] = array(
            'exclude_btns' => array('activate', 'deactivate', 'featured', 'unfeatured')
        );
    }

    function getMultiUpload($oUploader)
    {
        return $oUploader->servicePerformMultiVideoUpload();
    }

    function serviceGetProfileCat ()
    {
        return PROFILE_VIDEO_CATEGORY;
    }

    function serviceGetMemberMenuItem ()
    {
        return parent::serviceGetMemberMenuItem ('film');
    }

    function serviceGetMemberMenuItemAddContent ()
    {
        return parent::serviceGetMemberMenuItemAddContent ('film');
    }

    function getEmbedCode ($iFileId, $aExtra = array())
    {
        return $this->_oTemplate->getEmbedCode($iFileId, $aExtra);
    }

	function isAllowedShare(&$aDataEntry)
    {
    	if($aDataEntry['AllowAlbumView'] != BX_DOL_PG_ALL)
    		return false;

        return true;
    }
}
