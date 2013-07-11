<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('Module', $aModule);
bx_import('BxDolPageView');

class BxPmtDetailsPage extends BxDolPageView
{
    var $_oPayments;

    function BxPmtDetailsPage(&$oPayments)
    {
        parent::BxDolPageView('bx_pmt_details');

        $this->_oPayments = &$oPayments;

        $GLOBALS['oTopMenu']->setCurrentProfileID($this->_oPayments->_iUserId);
    }
    function getBlockCode_Details()
    {
        return $this->_oPayments->getDetailsForm();
    }
}

global $_page;
global $_page_cont;
global $logged;

$iIndex = 4;
$_page['name_index']	= $iIndex;
$_page['css_name']		= array();

check_logged();

$oPayments = new BxPmtModule($aModule);
$oDetailsPage = new BxPmtDetailsPage($oPayments);
$_page_cont[$iIndex]['page_main_code'] = $oDetailsPage->getCode();

$oPayments->_oTemplate->setPageTitle(_t('_payment_pcaption_details'));
PageCode($oPayments->_oTemplate);
