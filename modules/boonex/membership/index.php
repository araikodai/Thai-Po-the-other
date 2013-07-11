<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('Module', $aModule);
bx_import('BxDolPageView');

class BxMbpMyMembershipPage extends BxDolPageView
{
    var $_oMembership;

    function BxMbpMyMembershipPage(&$oMembership)
    {
        parent::BxDolPageView('bx_mbp_my_membership');

        $this->_oMembership = &$oMembership;

        $GLOBALS['oTopMenu']->setCurrentProfileID($oMembership->getUserId());
    }
    function getBlockCode_Current()
    {
        return $this->_oMembership->getCurrentLevelBlock();
    }
    function getBlockCode_Available()
    {
        return $this->_oMembership->getAvailableLevelsBlock();
    }
}

global $_page;
global $_page_cont;

$iIndex = 1;
$_page['name_index'] = $iIndex;
$_page['css_name'] = 'explanation.css';

check_logged();
if(!isLogged())
    login_form(_t( "_LOGIN_OBSOLETE" ), 0, false);

$oMembership = new BxMbpModule($aModule);
$oMyMembershipPage = new BxMbpMyMembershipPage($oMembership);
$_page_cont[$iIndex]['page_main_code'] = $oMyMembershipPage->getCode();

$oMembership->_oTemplate->setPageTitle(_t('_membership_pcaption_membership'));
PageCode($oMembership->_oTemplate);
