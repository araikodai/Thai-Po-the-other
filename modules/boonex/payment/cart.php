<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('Module', $aModule);
bx_import('BxDolPageView');

class BxPmtCartPage extends BxDolPageView
{
    var $_oPayments;

    function BxPmtCartPage(&$oPayments)
    {
        parent::BxDolPageView('bx_pmt_cart');

        $this->_oPayments = &$oPayments;

        $GLOBALS['oTopMenu']->setCurrentProfileID($this->_oPayments->_iUserId);
    }
    function getBlockCode_Featured()
    {
        return $this->_oPayments->getCartContent(BX_PMT_ADMINISTRATOR_ID);
    }
    function getBlockCode_Common()
    {
        return $this->_oPayments->getCartContent(BX_PMT_EMPTY_ID);
    }
}

global $_page;
global $_page_cont;
global $logged;

$iIndex = 1;
$_page['name_index']	= $iIndex;
$_page['css_name']		= array();

check_logged();

$oPayments = new BxPmtModule($aModule);
$oCartPage = new BxPmtCartPage($oPayments);
$_page_cont[$iIndex]['page_main_code'] = $oCartPage->getCode();

$oPayments->_oTemplate->addJsTranslation(array(
    '_payment_err_nothing_selected'
));
$oPayments->_oTemplate->setPageTitle(_t('_payment_pcaption_view_cart'));
PageCode($oPayments->_oTemplate);
