<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolConfig');

class BxPmtConfig extends BxDolConfig
{
    var $_oDb;

    var $_iSiteId;
    var $_iAdminId;
    var $_sAdminUsername;
    var $_sJsObjectCart;
    var $_sJsObjectOrders;
    var $_sCurrencySign;
    var $_sCurrencyCode;
    var $_sReturnUrl;
    var $_sDataReturnUrl;
    var $_sDateFormatOrders;
    var $_iOrdersPerPage;
    var $_iHistoryPerPage;

    /**
     * Constructor
     */
    function BxPmtConfig($aModule)
    {
        parent::BxDolConfig($aModule);

        $this->_iAdminId = BX_PMT_ADMINISTRATOR_ID;
        $this->_sAdminUsername = BX_PMT_ADMINISTRATOR_USERNAME;

        $this->_sJsObjectCart = 'oPmtCart';
        $this->_sJsObjectOrders = 'oPmtOrders';

        $this->_sReturnUrl = BX_DOL_URL_ROOT . $this->getBaseUri() . 'cart/';
        $this->_sDataReturnUrl = BX_DOL_URL_ROOT . $this->getBaseUri() . 'act_finalize_checkout/';

        $this->_iOrdersPerPage = 10;
        $this->_iHistoryPerPage = 10;

        $this->_sDateFormatOrders = getLocaleFormat(BX_DOL_LOCALE_DATE_SHORT, BX_DOL_LOCALE_DB);
    }
    function init(&$oDb)
    {
        $this->_oDb = &$oDb;

        $this->_iSiteId = (int)$this->_oDb->getParam('pmt_site_admin');
        $this->_sCurrencySign = $this->_oDb->getParam('pmt_default_currency_sign');
        $this->_sCurrencyCode = $this->_oDb->getParam('pmt_default_currency_code');
    }
    function getAdminId()
    {
        return $this->_iAdminId;
    }
    function getAdminUsername()
    {
        return $this->_sAdminUsername;
    }
    function getSiteId()
    {
        if(empty($this->_iSiteId))
            return $this->_oDb->getFirstAdminId();

        return $this->_iSiteId;
    }
    function getJsObject($sClass)
    {
        $sResult = "";

        switch($sClass) {
            case 'cart':
                $sResult = $this->_sJsObjectCart;
                break;
            case 'orders':
            case 'history':
                $sResult = $this->_sJsObjectOrders;
                break;
        }

        return $sResult;
    }
    function getCurrencySign()
    {
        return $this->_sCurrencySign;
    }
    function getCurrencyCode()
    {
        return $this->_sCurrencyCode;
    }
    function getReturnUrl()
    {
        return $this->_sReturnUrl;
    }
    function getDataReturnUrl()
    {
        return $this->_sDataReturnUrl;
    }
    function getDateFormat($sType)
    {
        $sResult = "";

        switch($sType) {
            case 'orders':
                $sResult = $this->_sDateFormatOrders;
                break;
        }

        return $sResult;
    }
    function getPerPage($sType)
    {
        $iResult = 0;

        switch($sType) {
            case 'orders':
                $iResult = $this->_iOrdersPerPage;
                break;
            case 'history':
                $iResult = $this->_iHistoryPerPage;
                break;
        }

        return $iResult;
    }
}
