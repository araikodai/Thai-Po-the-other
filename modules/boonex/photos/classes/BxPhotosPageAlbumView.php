<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

require_once(BX_DIRECTORY_PATH_CLASSES . 'BxDolPageView.php');

class BxPhotosPageAlbumView extends BxDolPageView
{
    var $aInfo;
    var $iProfileId;

    var $oTemplate;
    var $oConfig;
    var $oDb;
    var $oModule;

    var $sBrowseCode;

    function BxPhotosPageAlbumView($oModule, $aInfo, $sBrowseCode = '')
    {
        parent::BxDolPageView('bx_photos_album_view');
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
        if (empty($this->sBrowseCode)) {
            $sClassName = $this->oConfig->getClassPrefix() . 'Search';
            bx_import('Search', $this->oModule->_aModule);
            $oSearch = new $sClassName('album');
            $aParams = array('album' => $this->aInfo['Uri'], 'owner' => $this->aInfo['Owner']);
            $aCustom = array(
                'enable_center' => false,
                'per_page' => $this->oConfig->getGlParam('number_top'),
            );
            $aHtml = $oSearch->getBrowseBlock($aParams, $aCustom);
            $sPaginate = '';
            if ($oSearch->aCurrent['paginate']['totalNum']) {
                if ($oSearch->aCurrent['paginate']['totalNum'] > $oSearch->aCurrent['paginate']['perPage']) {
                    $sLink = $this->oConfig->getBaseUri() . 'browse/album/' . $this->aInfo['Uri'] . '/owner/' . getUsername($this->aInfo['Owner']);
                    $oPaginate = new BxDolPaginate(array(
                        'page_url' => $sLink . '&page={page}&per_page={per_page}',
                        'count' => $oSearch->aCurrent['paginate']['totalNum'],
                        'per_page' => $oSearch->aCurrent['paginate']['perPage'],
                        'page' => $oSearch->aCurrent['paginate']['page'],
                        'per_page_changer' => true,
                        'page_reloader' => true,
                        'on_change_per_page' => 'document.location=\'' . BX_DOL_URL_ROOT . $sLink . '&page=1&per_page=\' + this.value;'
                    ));
                    $sPaginate = $oPaginate->getPaginate();
                }
            } else
                $aHtml['code'] = MsgBox(_t('_Empty'));
            return DesignBoxContent(_t('_' . $this->oConfig->getMainPrefix() . '_browse_by_album', $this->aInfo['Caption']), $aHtml['code'] . $sPaginate, 1);
        } else
            return $this->sBrowseCode;
    }

    function getBlockCode_Author()
    {
        $aOwner = array('medProfId' => $this->aInfo['Owner'], 'NickName' => getUsername($this->aInfo['Owner']));
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
