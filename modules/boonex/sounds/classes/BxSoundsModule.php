<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolFilesModule');
define('PROFILE_SOUND_CATEGORY', 'Profile sounds');

class BxSoundsModule extends BxDolFilesModule
{
    function BxSoundsModule (&$aModule)
    {
        parent::BxDolFilesModule($aModule);

        // add more sections for administration
        $this->aSectionsAdmin['processing'] = array('exclude_btns' => 'all');
        $this->aSectionsAdmin['failed'] = array(
            'exclude_btns' => array('activate', 'deactivate', 'featured', 'unfeatured')
        );
    }

    function processUpload($oUploader, $sAction)
    {
        $sCode = '';
        switch($sAction) {
            case 'accept_upload':
                $sCode = $oUploader->serviceAcceptFile();
                break;
            case 'accept_record':
                $sCode = $oUploader->serviceAcceptRecordFile();
                break;
            case 'cancel_file':
                $sCode = $oUploader->serviceCancelFileInfo();
                break;
            case 'accept_file_info':
                $sCode = $oUploader->serviceAcceptFileInfo();
                break;
            case 'accept_multi_files':
                $sCode = $oUploader->servicePerformMultiMusicUpload();
                break;
        }
        echo $sCode;
    }

    function serviceGetProfileCat ()
    {
        return PROFILE_SOUND_CATEGORY;
    }

    function serviceGetMemberMenuItem ()
    {
        return parent::serviceGetMemberMenuItem ('music');
    }
    function serviceGetMemberMenuItemAddContent ()
    {
        return parent::serviceGetMemberMenuItemAddContent ('music');
    }

    function getEmbedCode ($iFileId)
    {
        return $this->_oTemplate->getEmbedCode($iFileId);
    }

	function isAllowedShare(&$aDataEntry)
    {
    	if($aDataEntry['AllowAlbumView'] != BX_DOL_PG_ALL)
    		return false;

        return true;
    }
}
