<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

//require_once( BX_DIRECTORY_PATH_MODULES . 'boonex/videos/classes/BxVideosModule.php' );
bx_import('BxDolFilesUploader');
bx_import('BxDolCategories');
bx_import('BxDolAlbums');
bx_import('BxDolModule');

global $sIncPath;
global $sModulesPath;
global $sFilesPath;
global $sFilesUrl;
global $oDb;
require_once($sIncPath . 'db.inc.php');

$sModule = "video";
$sModulePath = $sModulesPath . $sModule . '/inc/';

global $sModulesUrl;
require_once($sModulesPath . $sModule . '/inc/header.inc.php');
require_once($sModulesPath . $sModule . '/inc/constants.inc.php');
require_once($sModulesPath . $sModule . '/inc/functions.inc.php');
require_once($sModulesPath . $sModule . '/inc/customFunctions.inc.php');

class BxVideosUploader extends BxDolFilesUploader
{
    // variables

    // constructor
    function BxVideosUploader()
    {
        parent::BxDolFilesUploader('Video');

        $this->oModule = BxDolModule::getInstance('BxVideosModule');
        $this->sWorkingFile = BX_DOL_URL_ROOT . $this->oModule->_oConfig->getBaseUri() . 'albums/my/add_objects';
        $this->sMultiUploaderParams['accept_file'] = $this->sWorkingFile;
        $this->sMultiUploaderParams['form_caption'] = _t('_bx_videos_add_objects');
        $this->sMultiUploaderParams['accept_format'] = $this->oModule->_oConfig->getAvailableFlashExts();
        $this->sMultiUploaderParams['accept_format_desc'] = 'Video Files';

                $iMaxByAdmin = 1024*1024*(int)getParam($this->oModule->_oConfig->getMainPrefix() . '_max_file_size');
                if ($iMaxByAdmin > 0 && $iMaxByAdmin < $this->iMaxFilesize)
                    $this->iMaxFilesize = $iMaxByAdmin;

                $this->sMultiUploaderParams['file_size_limit'] = $this->iMaxFilesize;
    }

    /*
    * Service - generate video upload main form
    *
    * params
    * $sPredefCategory - TODO remove
    * $aExtras - TODO predefined album and category should appear here with names: predef_album and predef_category
    */
    function serviceGenVideoUploadForm($aExtras = array())
    {
        return $this->GenMainAddVideoForm($aExtras);
    }

    function GenMainAddVideoForm($aExtras = array())
    {
        $aUploaders = array_keys($this->oModule->_oConfig->getUploaderList());
        return $this->_GenMainAddCommonForm($aExtras, $aUploaders);
    }

    function getEmbedFormFile()
    {
        return $this->_getEmbedFormFile();
    }

    function getRecordFormFile()
    {
        $sCustomRecorderObject = getApplicationContent('video', 'recorder', array('user' => $this->_getAuthorId(), 'password' => $this->_getAuthorPassword(), 'extra' => ''), true);
        return $this->_getRecordFormFile($sCustomRecorderObject);
    }

    function getUploadFormFile()
    {
        return $this->_getUploadFormFile();
    }

    function GenSendFileInfoForm($iFileID, $aDefaultValues = array())
    {
        $sVideoUrl = "";
        if(isset($aDefaultValues['image']))
            $sVideoUrl = $aDefaultValues['image'];
        else if(!empty($iFileID)) {
            $aVideoInfo = BxDolService::call('videos', 'get_video_array', array($iFileID), 'Search');
            $sVideoUrl = $aVideoInfo['file'];
        }

        $sVideoUrl .= (false === strpos($sVideoUrl, '?') ? '?' : '&') . '_t=' . time();

        $sProtoEl = '<img src="' . $sVideoUrl . '" />';

        $aPossibleImage = array();
        $aPossibleImage['preview_image'] = array(
            'type' => 'custom',
            'content' => $sProtoEl,
            'caption' => _t('_bx_videos_preview'),
        );

        $aPossibleDuration = array();
        $aPossibleDuration['duration'] = array(
            'type' => 'hidden',
            'name' => 'duration',
            'value' => isset($aDefaultValues['duration']) ? $aDefaultValues['duration'] : "0"
        );

        return $this->_GenSendFileInfoForm($iFileID, $aDefaultValues, $aPossibleImage, $aPossibleDuration);
    }

    function serviceCancelFileInfo()
    {
        $iFileID = (int)$_GET['file_id'];
        if ($iFileID) {
            if ($this->oModule->serviceRemoveObject($iFileID)) {
                deleteVideo($iFileID);
                return 1;
            }
        }
        return 0;
    }

    function servicePerformMultiVideoUpload()
    {
        $this->_iOwnerId = (int)$_POST['oid'];

        if ($_FILES) {
            if ($_FILES['Filedata']['error'] || $_FILES['Filedata']['size'] > $this->iMaxFilesize)
                return;
            $sResult .= $this->_shareVideo($_FILES['Filedata']['tmp_name'], true, '', $_FILES['Filedata']['name']);
            return ($sResult!='') ? $this->GenJquieryInjection() . $sResult : '';
        }
    }

    function servicePerformVideoUpload($sFilePath, $aInfo, $isMoveUploadedFile = false)
    {
        global $sModule;
        global $sFilesPath;

        if (!$this->oModule->_iProfileId)
            $this->oModule->_iProfileId = $this->_iOwnerId;
        if (!$this->_iOwnerId || !$this->oModule->isAllowedAdd())
            return false;

        $sFilePath = process_db_input($sFilePath, BX_TAGS_STRIP, BX_SLASHES_NO_ACTION);
        $iOwnerID = $this->_getAuthorId();
        $iOwnerID = ($this->_iOwnerId > 0) ? $this->_iOwnerId : $iOwnerID;
        $iPointPos = strrpos($sFilePath, '.');
        $sExt = substr($sFilePath, $iPointPos + 1);
        if (!$this->oModule->_oConfig->checkAllowedExts(strtolower($sExt)))
            return false;

        $GLOBALS['sModule'] = "video";
        include($GLOBALS['sModulesPath'] . $sModule . '/inc/header.inc.php');
        if (!($iId = uploadVideo($sFilePath, $iOwnerID, $isMoveUploadedFile, ''))) {
            return false;
        }

        if ($aInfo) {
            foreach (array('title', 'categories', 'tags', 'desc') as $sKey)
                $aInfo[$sKey] = isset($aInfo[$sKey]) ? $aInfo[$sKey] : '';
            $this->initVideoFile($iId, $aInfo['title'], $aInfo['categories'], $aInfo['tags'], $aInfo['desc']);

            $sAlbum = mb_strlen($_POST['extra_param_album']) > 0 ? $_POST['extra_param_album'] : getParam('sys_album_default_name');
            $sAlbum = isset($aInfo['album']) ? $aInfo['album'] : $sAlbum;
            $this->addObjectToAlbum($this->oModule->oAlbums, $sAlbum, $iId, false);
            $this->oModule->isAllowedAdd(true, true);
        }
        return $iId;
    }

    function serviceAcceptFile()
    {
        $sResult = '';
        if ($_FILES) {
            for ($i=0; $i<count($_FILES['file']['tmp_name']); $i++) {
                if ($_FILES['file']['error'][$i]) {
                    if ($_FILES['file']['error'][$i] == UPLOAD_ERR_INI_SIZE)
                        $sResult .= $this->getVideoAddError(_t('_bx_videos_size_error', _t_format_size($this->iMaxFilesize)));

                    continue;
                }
                $sResult .= $this->_shareVideo($_FILES['file']['tmp_name'][$i], true, '', $_FILES['file']['name'][$i]);
            }
        } else
            $sResult = $this->getVideoAddError(_t('_bx_videos_size_error', _t_format_size($this->iMaxFilesize)));

        return $sResult != '' ? $this->GenJquieryInjection() . $sResult : '';
    }

    function serviceAcceptRecordFile()
    {
        $sResult = $this->_recordVideo();
        return ($sResult!='') ? $this->GenJquieryInjection() . $sResult : '';
    }

    function serviceAcceptEmbedFile()
    {
        $sErrorReturn = '<script type="text/javascript">parent.' . $this->_sJsPostObject . '.showErrorMsg("video_embed_failed_message");parent.' . $this->_sJsPostObject . '.resetEmbed();</script>';
        $sVideoId = substr(trim($_POST['embed']), -11);
        if(empty($sVideoId)) return $sErrorReturn;

        $sVideoData = $this->embedReadUrl(str_replace("#video#", $sVideoId, YOUTUBE_VIDEO_RSS));
        $sVideoData = $this->embedGetTagContents($sVideoData, "entry");
        if(empty($sVideoData)) return $sErrorReturn;

        $sTitle = $this->embedGetTagContents($sVideoData, "media:title");
        $sDesc = $this->embedGetTagContents($sVideoData, "media:description");
        $sTags = $this->embedGetTagContents($sVideoData, "media:keywords");
        $sImage = $this->embedGetTagAttributes($sVideoData, "media:thumbnail", "url");
        $iDuration = $this->embedGetTagAttributes($sVideoData, "yt:duration", "seconds");
        if(empty($sTitle)) return $sErrorReturn;

        $sResult = $this->_embedVideo($sVideoId, $sTitle, $sDesc, $sTags, $sImage, $iDuration);
        return ($sResult!='') ? $this->GenJquieryInjection() . $sResult : '';
    }

    function serviceAcceptFileInfo()
    {
            global $sModule;
            $iAuthorId = $this->_getAuthorId();
        $sJSVideoId = (int)$_POST['file_id'];
        switch($_POST['type']) {
            case 'embed':
                $iVideoID = (int)embedVideo($iAuthorId, $_POST['video'], $_POST['duration']);
                                $bUpdateCounter = getSettingValue($sModule, "autoApprove") == TRUE_VAL ? true : false;
                                $this->addObjectToAlbum($this->oModule->oAlbums, $_POST['extra_param_album'], $iVideoID, $bUpdateCounter);
                break;
            case 'record':
                $iVideoID = (int)recordVideo($iAuthorId);
                $this->addObjectToAlbum($this->oModule->oAlbums, $_POST['extra_param_album'], $iVideoID, false);
                break;
            case 'upload':
            default:
                $iVideoID = $sJSVideoId;
                break;
        }

        if ($iVideoID && $iAuthorId) {
            $sTitle = $_POST['title'];
            $sTags = $_POST['tags'];
            $sDescription = $_POST['description'];

            $aCategories = array();
            foreach ($_POST['Categories'] as $sKey => $sVal) {
                if ($sVal != '') {
                    $aCategories[] = $sVal;
                }
            }
            $sCategories = implode(CATEGORIES_DIVIDER, $aCategories);

            if ($this->initVideoFile($iVideoID, $sTitle, $sCategories, $sTags, $sDescription)) {
            	$aExtra = $this->_getExtraParams($_POST);
            	$aExtra = $this->_updateExtraParams($aExtra, $iVideoID, $iAuthorId);

                //--- BxVideos -> Upload unit for Alerts Engine ---//
                require_once(BX_DIRECTORY_PATH_CLASSES . 'BxDolAlerts.php');
                $oZ = new BxDolAlerts('bx_videos', 'add', $iVideoID, $iAuthorId, $aExtra);
                $oZ->alert();
                //--- BxVideos -> Upload unit for Alerts Engine ---//

                return '<script type="text/javascript">parent.' . $this->_sJsPostObject . '.onSuccessSendingFileInfo("' . $sJSVideoId . '");</script>';
            }
        }
        return '<script type="text/javascript">parent.' . $this->_sJsPostObject . '.showErrorMsg("video_failed_message");</script>';
    }

    function _embedVideo($sVideoId, $sTitle, $sDesc, $sTags, $sImage, $iDuration)
    {
        $sAuthorCheck = $this->checkAuthorBeforeAdd();
        if(empty($sAuthorCheck)) {
            $sEmbedThumbUrl = getEmbedThumbnail($this->_getAuthorId(), $sImage);
            if($sEmbedThumbUrl) {
                $this->oModule->isAllowedAdd(true);
                $aDefault = array('video' => $sVideoId, 'title' => $sTitle, 'description' => $sDesc, 'tags' => $sTags, 'duration' => $iDuration, 'image' => $sEmbedThumbUrl, 'type' => "embed");
                return $this->GenSendFileInfoForm(1, $aDefault);
            } else
                return $this->getVideoAddError();
        } else
            return $sAuthorCheck;
    }

    function _recordVideo()
    {
        $sAuthorCheck = $this->checkAuthorBeforeAdd();
        if(empty($sAuthorCheck)) {
            $sRecordThumbUrl = getRecordThumbnail($this->_getAuthorId());
            if($sRecordThumbUrl) {
                $this->oModule->isAllowedAdd(true);
                $aDefault = array('image' => $sRecordThumbUrl, 'type' => "record");
                return $this->GenSendFileInfoForm(1, $aDefault);
            } else
                return $this->getVideoAddError();
        } else
            return $sAuthorCheck;
    }

    function _shareVideo($sFilePath, $isMoveUploadedFile = true, $sImageFilePath = '', $sRealFilename = '')
    {
        $sAuthorCheck = $this->checkAuthorBeforeAdd();
        if (!$this->_iOwnerId )
            return false;
        if (!$this->oModule->_iProfileId)
            $this->oModule->_iProfileId = $this->_iOwnerId;
        if (empty($sAuthorCheck) && $this->oModule->isAllowedAdd()) {
            $sFilePath = process_db_input($sFilePath, BX_TAGS_STRIP, BX_SLASHES_NO_ACTION);
            $sImageFilePath = mb_strlen($sImageFilePath) > 0 ? process_db_input($sImageFilePath, BX_TAGS_STRIP, BX_SLASHES_NO_ACTION) : '';
            if (!empty($sRealFilename)) {
                $iPointPos = strrpos($sRealFilename, '.');
                $sExt = substr($sRealFilename, $iPointPos + 1);
                if (!$this->oModule->_oConfig->checkAllowedExts(strtolower($sExt)))
                    return $this->getVideoAddError();
                $this->sTempFilename = substr($sRealFilename, 0, $iPointPos);
            }

            $iFileSize = filesize($sFilePath);
            if (!$iFileSize || $iFileSize > $this->iMaxFilesize)
                return $this->getVideoAddError(_t('_' . $this->oModule->_oConfig->getMainPrefix() . '_size_error', _t_format_size($this->iMaxFilesize)));

            $sROwnerID = ($this->_iOwnerId) ? $this->_iOwnerId : $this->_getAuthorId();
            $iMID = uploadVideo($sFilePath, $sROwnerID, $isMoveUploadedFile, $sImageFilePath, process_db_input($sRealFilename, BX_TAGS_STRIP));
            if ($iMID > 0) {
            	$sAlbum = $_POST['extra_param_album'];
				$aAlbumParams = isset($_POST['extra_param_albumPrivacy']) ? array('privacy' => (int)$_POST['extra_param_albumPrivacy']) : array();

                $this->addObjectToAlbum($this->oModule->oAlbums, $sAlbum, $iMID, false, $sROwnerID, $aAlbumParams);
                $this->oModule->isAllowedAdd(true, true);
                $aDefault = array('title' => $this->sTempFilename, 'description' => $this->sTempFilename);
                return $this->GenSendFileInfoForm($iMID, $aDefault);
            } else
                return $this->getVideoAddError();
        } else
            return $sAuthorCheck;
    }

    function getVideoAddError($sMessage = '')
    {
        $sMessage = empty($sMessage) ? _t('_bx_videos_upl_file_err') : $sMessage;
        return '<script type="text/javascript">alert("' . htmlspecialchars(addslashes($sMessage)) . '"); parent.oVideoUpload._loading(false);</script>';
    }

    function initVideoFile($iVideoID, $sTitle, $sCategories, $sTags, $sDesc)
    {
        $sMedUri = uriGenerate($sTitle, $this->oModule->_oDb->sFileTable, $this->oModule->_oDb->aFileFields['medUri']);
        $bRes = $this->oModule->_oDb->updateData($iVideoID, array('Categories'=>$sCategories, 'medTitle'=>$sTitle, 'medTags'=>$sTags, 'medDesc'=>$sDesc, 'medUri'=>$sMedUri));

        $oTag = new BxDolTags();
        $oTag->reparseObjTags('bx_videos', $iVideoID);
        $oCateg = new BxDolCategories();
        $oCateg->reparseObjTags('bx_videos', $iVideoID);

        $bRes = true; //TODO chech why if false
        return $bRes;
    }

    function serviceGenAddVideoPage($aExtras = array())
    {
        $sAddVideoC = _t('_bx_videos_add');
        $sRecVideoC = _t('_bx_videos_record');
        $sEmbVideoC = _t('_bx_videos_embed');
        $sFlashVideoC = _t('_adm_admtools_Flash');

        $sVideoUploadForm = $this->GenMainAddVideoForm($aExtras);

        $sUploadActStyle = $sRecordActStyle = $sEmbedActStyle = $sFlashActStyle = 'notActive';
        switch ($_GET['mode']) {
            case 'record':
                $sRecordActStyle = 'active';
                break;
            case 'embed':
                $sEmbedActStyle = 'active';
                break;
            case 'single':
                $sUploadActStyle = 'active';
                break;
            default:
                $sFlashActStyle = 'active';
                break;
        }

        $sActions = <<<EOF
<div class="dbTopMenu">
    <div class="{$sFlashActStyle}" id="common_edit_blog">
        <span style="vertical-align:middle;"><a href="{$this->sWorkingFile}">{$sFlashVideoC}</a></span>
    </div>
    <div class="{$sUploadActStyle}" id="common_edit_blog">
        <span style="vertical-align:middle;"><a href="{$this->sWorkingFile}&mode=single">{$sAddVideoC}</a></span>
    </div>
    <div class="{$sRecordActStyle}" id="common_edit_blog">
        <span style="vertical-align:middle;"><a href="{$this->sWorkingFile}&mode=record">{$sRecVideoC}</a></span>
    </div>
    <div class="{$sEmbedActStyle}" id="common_edit_blog">
        <span style="vertical-align:middle;"><a href="{$this->sWorkingFile}&mode=embed">{$sEmbVideoC}</a></span>
    </div>
</div>
EOF;

        return DesignBoxContent(_t('_bx_videos_my'), '<div class="dbContentHtml">'.$sVideoUploadForm.'</div>', 1, $sActions);
    }

    function serviceGetUploaderForm($aExtras)
    {
        return $this->GenMainAddVideoForm($aExtras);
    }
}
