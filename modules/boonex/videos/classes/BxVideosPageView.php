<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

require_once(BX_DIRECTORY_PATH_CLASSES . 'BxDolPageView.php');
require_once('BxVideosSearch.php');

class BxVideosPageView extends BxDolPageView
{
    var $iProfileId;
    var $aFileInfo;

    var $oModule;
    var $oTemplate;
    var $oConfig;
    var $oDb;
    var $oSearch;

    function BxVideosPageView (&$oShared, &$aFileInfo)
    {
        parent::BxDolPageView('bx_videos_view');
        $this->aFileInfo = $aFileInfo;
        $this->iProfileId = &$oShared->_iProfileId;

        $this->oModule = $oShared;
        $this->oTemplate = $oShared->_oTemplate;
        $this->oConfig = $oShared->_oConfig;
        $this->oDb = $oShared->_oDb;
        $this->oSearch = new BxVideosSearch();
        $this->oTemplate->addCss(array('view.css', 'search.css'));
        bx_import ('BxDolViews');
        new BxDolViews('bx_' . $this->oConfig->getUri(), $this->aFileInfo['medID']);
    }

    function getBlockCode_ActionList ()
    {
        $sCode = null;
        bx_import('BxDolSubscription');
        $oSubscription = new BxDolSubscription();
        $aButton = $oSubscription->getButton($this->iProfileId, $this->oConfig->getMainPrefix(), '', (int)$this->aFileInfo['medID']);
        $aReplacement = array(
            'favorited' => $this->aFileInfo['favorited'] == false ? '' : 'favorited',
            'featured' => (int)$this->aFileInfo['Featured'],
            'featuredCpt' => '',
            'moduleUrl' => BX_DOL_URL_ROOT . $this->oConfig->getBaseUri(),
            'fileUri' => $this->aFileInfo['medUri'],
            'iViewer' => $this->iProfileId,
            'ID' => (int)$this->aFileInfo['medID'],
            'Owner' => (int)$this->aFileInfo['medProfId'],
            'OwnerName' => $this->aFileInfo['NickName'],
            'AlbumUri' => $this->aFileInfo['albumUri'],
            'sbs_' . $this->oConfig->getMainPrefix() . '_title' => $aButton['title'],
            'sbs_' . $this->oConfig->getMainPrefix() . '_script' => $aButton['script'],
        	'shareCpt' => $this->oModule->isAllowedShare($this->aFileInfo) ? _t('_Share') : '',
        );
        if (isAdmin($this->iProfileId)) {
            $sMsg = $aReplacement['featured'] > 0 ? 'un' : '';
            $aReplacement['featuredCpt'] = _t('_' . $this->oConfig->getMainPrefix() . '_action_' . $sMsg . 'feature');
        }
        $sActionsList = $GLOBALS['oFunctions']->genObjectsActions($aReplacement, $this->oConfig->getMainPrefix());
        if (!is_null($sActionsList))
            $sCode = $oSubscription->getData() . $sActionsList;
        return $sCode;
    }

    function getBlockCode_FileAuthor()
    {
        return $this->oTemplate->getFileAuthor($this->aFileInfo);
    }

    function getBlockCode_ViewAlbum ()
    {
        $oAlbum = new BxDolAlbums($this->oConfig->getMainPrefix());
        $aAlbum = $oAlbum->getAlbumInfo(array('fileId' => $this->aFileInfo['albumId']));
        return array($this->oSearch->displayAlbumUnit($aAlbum), array(), array(), false);
    }

    function getBlockCode_RelatedFiles ()
    {
        $this->oSearch->clearFilters(array('activeStatus', 'albumType', 'allow_view', 'album_status'), array('albumsObjects', 'albums'));
        $bLike = getParam('useLikeOperator');
        if ($bLike != 'on') {
            $aRel = array($this->aFileInfo['medTitle'], $this->aFileInfo['medDesc'], $this->aFileInfo['medTags'], $this->aFileInfo['Categories']);
            $sKeywords = getRelatedWords($aRel);
            if (!empty($sKeywords)) {
                $this->oSearch->aCurrent['restriction']['keyword'] = array(
                    'value' => $sKeywords,
                    'field' => '',
                    'operator' => 'against'
                );
            }
        } else {
            $sKeywords = $this->aFileInfo['medTitle'].' '.$this->aFileInfo['medTags'];
            $aWords = explode(' ', $sKeywords);
            foreach (array_unique($aWords) as $iKey => $sValue) {
                if (strlen($sValue) > 2) {
                    $this->oSearch->aCurrent['restriction']['keyword'.$iKey] = array(
                        'value' => trim(addslashes($sValue)),
                        'field' => '',
                        'operator' => 'against'
                    );
                }
            }
        }
        $this->oSearch->aCurrent['restriction']['id'] = array(
            'value' => $this->aFileInfo['medID'],
            'field' => $this->oSearch->aCurrent['ident'],
            'operator' => '<>',
            'paramName' => 'fileID'
        );
        $this->oSearch->aCurrent['sorting'] = 'score';
        $iLimit = (int)$this->oConfig->getGlParam('number_related');
        $iLimit = $iLimit == 0 ? 2 : $iLimit;

        $this->oSearch->aCurrent['paginate']['perPage'] = $iLimit;
        $sCode = $this->oSearch->displayResultBlock();
        $aBottomMenu = array();
        $bWrap = true;
        if ($this->oSearch->aCurrent['paginate']['totalNum'] > 0) {
            $sCode = $GLOBALS['oFunctions']->centerContent($sCode, '.sys_file_search_unit');
            $aBottomMenu = $this->oSearch->getBottomMenu('category', 0, $this->aFileInfo['Categories']);
            $bWrap = '';
        }
        return array($sCode, array(), $aBottomMenu, $bWrap);
    }

    function getBlockCode_ViewComments ()
    {
        bx_import('BxTemplCmtsView');
        $this->oTemplate->addCss('cmts.css');
        $oCmtsView = new BxTemplCmtsView('bx_' . $this->oConfig->getUri(), $this->aFileInfo['medID']);
        if (!$oCmtsView->isEnabled()) return '';
            return $oCmtsView->getCommentsFirst ();
    }

    function getBlockCode_ViewFile ()
    {
        $this->aFileInfo['favCount'] = $this->oDb->getFavoritesCount($this->aFileInfo['medID']);
        $sCode = $this->oTemplate->getViewFile($this->aFileInfo);
        return array($sCode, array(), array(), false);
    }

    function getBlockCode_MainFileInfo ()
    {
        return $this->oTemplate->getFileInfoMain($this->aFileInfo);
    }

    function getBlockCode_SocialSharing ()
    {
    	if(!$this->oModule->isAllowedShare($this->aFileInfo))
    		return '';

        $sUrl = BX_DOL_URL_ROOT . $this->oConfig->getBaseUri() . 'view/' . $this->aFileInfo['medUri'];
        $sTitle = $this->aFileInfo['medTitle'];
        bx_import('BxTemplSocialSharing');
        $sCode = BxTemplSocialSharing::getInstance()->getCode($sUrl, $sTitle);
        return array($sCode, array(), array(), false);
    }
}
