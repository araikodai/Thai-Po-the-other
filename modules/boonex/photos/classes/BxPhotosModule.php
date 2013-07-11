<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolFilesModule');
require_once(BX_DIRECTORY_PATH_PLUGINS . 'Services_JSON.php');
define('PROFILE_PHOTO_CATEGORY', 'Profile photos');

class BxPhotosModule extends BxDolFilesModule
{
    var $iHeaderCacheTime = 0;
    function BxPhotosModule (&$aModule)
    {
        parent::BxDolFilesModule($aModule);
        $this->aSectionsAdmin['pending'] = array(
            'exclude_btns' => array('deactivate', 'featured', 'unfeatured')
        );
        $this->iHeaderCacheTime = (int)$this->_oConfig->getGlParam('header_cache');
    }

    function actionGetCurrentImage ($iPicId)
    {
        $iPicId = (int)$iPicId;
        if ($iPicId > 0) {
            bx_import('Search', $this->_aModule);
            $oMedia = new BxPhotosSearch();
            $aInfo = $oMedia->serviceGetPhotoArray($iPicId, 'file');
            $aInfo['ownerUrl'] = getProfileLink($aInfo['owner']);
            $aInfo['ownerName'] = getNickName($aInfo['owner']);
            $aInfo['date'] = defineTimeInterval($aInfo['date']);
            $oMedia->getRatePart();
            $aInfo['rate'] = $oMedia->oRate->getJustVotingElement(0, 0, $aInfo['rate']);
            $aLinkAddon = $oMedia->getLinkAddByPrams();
            $oPaginate = new BxDolPaginate(array(
                'count' => (int)$_GET['total'],
                'per_page' => 1,
                'page' => (int)$_GET['page'],
                'info' => false,
                'per_page_changer' => false,
                'page_reloader' => false,
                'on_change_page' => 'getCurrentImage({page})',
            ));
            $aInfo['paginate'] = $oPaginate->getPaginate();
            header('Content-Type:text/javascript');
            $oJSON = new Services_JSON();
            echo $oJSON->encode($aInfo);
        }
    }

    function actionGetImage ($sParamValue, $sParamValue1)
    {
        $sParamValue  = clear_xss($sParamValue);
        $sParamValue1 = clear_xss($sParamValue1);
        $iPointPos    = strrpos($sParamValue1, '.');
        $sKey = substr($sParamValue1, 0, $iPointPos);
        $iId = $this->_oDb->getIdByHash($sKey);
        if ($iId > 0) {
            $sExt = substr($sParamValue1, $iPointPos + 1);
            switch ($sExt) {
                case 'png':
                    $sCntType = 'image/x-png';
                    break;
                case 'gif':
                    $sCntType = 'image/gif';
                    break;
                default:
                    $sCntType = 'image/jpeg';
            }
            $sPath = $this->_oConfig->getFilesPath() . $iId . str_replace('{ext}', $sExt, $this->_oConfig->aFilePostfix[$sParamValue]);
            $sAdd = '';
            if ($this->iHeaderCacheTime > 0) {
                $iLastModTime = filemtime($sPath);
                $sAdd = ", max-age={$this->iHeaderCacheTime}, Last-Modified: " . gmdate("D, d M Y H:i:s", $iLastModTime) . " GMT";
            }
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0" . $sAdd);
            header("Content-Type:" . $sCntType);
            header("Content-Length: " . filesize($sPath));
            readfile($sPath);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo _t('_sys_request_page_not_found_cpt');
        }
        exit;
    }

    function getMultiUpload($oUploader)
    {
        return $oUploader->servicePerformMultiPhotoUpload();
    }

    function serviceSetAvatar($iPhotoID, $iAuthorId = 0)
    {
        if (!$iAuthorId)
            $iAuthorId = getLoggedId();
        $aFileInfo = $this->_oDb->getFileInfo(array('fileId' => $iPhotoID));
        $sProfileAlbumUri = uriFilter(str_replace('{nickname}', getUsername($iAuthorId), $this->_oConfig->getGlParam('profile_album_name')));
        if ($sProfileAlbumUri != $aFileInfo['albumUri'])
            return false;
        return $this->_oDb->setAvatar($iPhotoID, $aFileInfo['albumId']);
    }

    function serviceGetProfileCat ()
    {
        return PROFILE_PHOTO_CATEGORY;
    }

    function serviceGetBlockFavorited ($iBlockId)
    {
        if ($this->_iProfileId == 0)
            return;
        bx_import('Search', $this->_aModule);
        $oMedia = new BxPhotosSearch();
        $oMedia->clearFilters(array('activeStatus', 'allow_view', 'album_status', 'albumType', 'ownerStatus'), array('albumsObjects', 'albums'));
        if (isset($oMedia->aAddPartsConfig['favorite']) && !empty($oMedia->aAddPartsConfig['favorite'])) {
            $oMedia->aCurrent['join']['favorite'] = $oMedia->aAddPartsConfig['favorite'];
            $oMedia->aCurrent['restriction']['fav'] = array(
                'value' => $iUserId,
                'field' => $oMedia->aAddPartsConfig['favorite']['userField'],
                'operator' => '=',
                'table' => $oMedia->aAddPartsConfig['favorite']['table']
            );
        }
        $oMedia->aCurrent['paginate']['perPage'] = (int)$this->oConfig->getGlParam('number_top');
        $sCode = $oMedia->displayResultBlock();
        if ($oMedia->aCurrent['paginate']['totalNum'] > 0) {
            $oMedia->aConstants['linksTempl']['favorited'] = 'browse/favorited';
            $sCode = $GLOBALS['oFunctions']->centerContent($sCode, '.sys_file_search_unit');
            $aTopMenu = array();
            $aBottomMenu = $oMedia->getBottomMenu('favorited', 0, '');
            return array($sCode, $aTopMenu, $aBottomMenu, false);
        }
    }

    function serviceGetMemberMenuItem ()
    {
        return parent::serviceGetMemberMenuItem ('picture');
    }

    function serviceGetMemberMenuItemAddContent ()
    {
        return parent::serviceGetMemberMenuItemAddContent ('picture');
    }

	function isAllowedShare(&$aDataEntry)
    {
    	if($aDataEntry['AllowAlbumView'] != BX_DOL_PG_ALL)
    		return false;

        return true;
    }
}
