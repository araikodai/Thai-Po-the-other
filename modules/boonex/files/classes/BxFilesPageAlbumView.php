<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

require_once(BX_DIRECTORY_PATH_CLASSES . 'BxDolPageView.php');

class BxFilesPageAlbumView extends BxDolPageView
{
    var $aInfo;
    var $iProfileId;

    var $oTemplate;
    var $oConfig;
    var $oDb;
    var $oModule;

    var $sBrowseCode;

    function BxFilesPageAlbumView($oModule, $aInfo, $sBrowseCode = '')
    {
        parent::BxDolPageView('bx_files_album_view');
        $this->aInfo = $aInfo;
        $this->iProfileId = $oModule->_iProfileId;

        $this->oModule = $oModule;
        $this->oConfig = $oModule->_oConfig;
        $this->oDb = $oModule->_oDb;
        $this->oTemplate = $oModule->_oTemplate;

        $this->sBrowseCode = $sBrowseCode;

        $GLOBALS['oTopMenu']->setCustomSubHeader($aInfo['Caption']);
    }

    function getBlockCode_Objects($iBlockId)
    {
        if(!empty($this->sBrowseCode))
            return $this->sBrowseCode;

        $sClassName = $this->oConfig->getClassPrefix() . 'Search';
        bx_import('Search', $this->oModule->_aModule);
        $oSearch = new $sClassName('album');
        $aParams = array('album' => $this->aInfo['Uri'], 'owner' => getUsername($this->aInfo['Owner']));
        $aCustom = array(
            'enable_center' => true,
            'per_page' => $this->oConfig->getGlParam('number_top'),
            'sorting' => 'album_order'
        );
        $aHtml = $oSearch->getBrowseBlock($aParams, $aCustom);
        $iCount = $oSearch->aCurrent['paginate']['totalNum'];
        $sPaginate = '';
        if ($iCount > $oSearch->aCurrent['paginate']['perPage']) {
            $sLink = $this->oConfig->getBaseUri() . 'browse/album/' . $aParams['album'] . '/owner/' . $aParams['owner'];
            $oPaginate = new BxDolPaginate(array(
                'page_url' => $sLink . '&page={page}&per_page={per_page}',
                'count' => $iCount,
                'per_page' => $oSearch->aCurrent['paginate']['perPage'],
                'page' => $oSearch->aCurrent['paginate']['page'],
                'per_page_changer' => true,
                'page_reloader' => true,
                'on_change_per_page' => 'document.location=\'' . BX_DOL_URL_ROOT . $sLink . '&page=1&per_page=\' + this.value;'
            ));
            $sPaginate = $oPaginate->getPaginate();
        }

        if(empty($aHtml['code']))
            $aHtml['code'] = MsgBox(_t('_Empty'));

        return DesignBoxContent(_t('_' . $this->oConfig->getMainPrefix() . '_browse_by_album', $this->aInfo['Caption']), $aHtml['code'], 1, '', $sPaginate);
    }

    function getBlockCode_Author()
    {
        $aOwner = array('medProfId' => $this->aInfo['Owner'], 'NickName' => getNickName($this->aInfo['Owner']));
        return $this->oTemplate->getFileAuthor($aOwner);
    }

    function getBlockCode_Comments()
    {
        bx_import('BxTemplCmtsView');
        $this->oTemplate->addCss('cmts.css');
        $oCmtsView = new BxTemplCmtsView($this->oConfig->getMainPrefix() . '_albums', $this->aInfo['ID']);
        if (!$oCmtsView->isEnabled()) return '';
        return $oCmtsView->getCommentsFirst();
    }
}
