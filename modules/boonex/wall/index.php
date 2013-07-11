<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('Module', $aModule);
bx_import('BxTemplProfileView');
bx_import('BxTemplConfig');

class BxWallPage extends BxTemplProfileView
{
    var $_sOwner;
    var $_oWall;

    function BxWallPage($sOwner, &$oWall)
    {
        $this->_sOwner = $sOwner;
        $this->_oWall = &$oWall;

        $this->oProfileGen = new BxBaseProfileGenerator(getId($sOwner, 0));
        $this->aConfSite = $GLOBALS['site'];
        $this->aConfDir  = $GLOBALS['dir'];
        parent::BxDolPageView('wall');
    }
    function getBlockCode_Post()
    {
        if(!empty($this->_sOwner))
            return $this->_oWall->servicePostBlock($this->_sOwner, 'username');
        else if(isLogged())
            return $this->_oWall->servicePostBlock(getLoggedId());
        else
            return MsgBox(_t('_wall_msg_no_results'));
    }
    function getBlockCode_View()
    {
        if(!empty($this->_sOwner))
            return $this->_oWall->serviceViewBlock($this->_sOwner, -1, -1, '', '', 'username');
        else if(isLogged())
            return $this->_oWall->serviceViewBlock(getLoggedId());
        else
            return MsgBox(_t('_wall_msg_no_results'));
    }
    function getCode()
    {
        if(!empty($this->_sOwner)) {
            $aOwner = $this->_oWall->_oDb->getUser($this->_sOwner, 'username');
            if((int)$aOwner['id'] == 0)
                return MsgBox(_t('_wall_msg_page_not_found'));
        }

        return parent::getCode();
    }
}

global $_page;
global $_page_cont;

$iIndex = 1;
$_page['name_index'] = $iIndex;
$_page['css_name'] = 'cmts.css';
$_page['js_name'] = 'BxDolCmts.js';
$_page['header'] = _t('_wall_page_caption');

$oSubscription = new BxDolSubscription();
$oWall = new BxWallModule($aModule);
$sOwnerUsername = isset($aRequest[0]) ? process_db_input($aRequest[0], BX_TAGS_STRIP) : '';
$oWallPage = new BxWallPage($sOwnerUsername, $oWall);
$_page_cont[$iIndex]['page_main_code'] = $oSubscription->getData() . $oWallPage->getCode();

$oWall->_oTemplate->setPageTitle((!empty($sOwnerUsername) ? _t('_wall_page_caption', ucfirst($sOwnerUsername)) : _t('_wall_page_caption_my')) );
PageCode($oWall->_oTemplate);
