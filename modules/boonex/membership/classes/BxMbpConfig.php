<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolConfig');

class BxMbpConfig extends BxDolConfig
{
    var $_oDb;
    var $_sCurrencySign;
    var $_sCurrencyCode;
    var $_sIconsFolder;

    /**
     * Constructor
     */
    function BxMbpConfig($aModule)
    {
        parent::BxDolConfig($aModule);

        $this->_oDb = null;
        $this->_sIconsFolder = 'media/images/membership/';
    }
    function init(&$oDb)
    {
        $this->_oDb = &$oDb;

        $this->_sCurrencySign = $this->_oDb->getParam('pmt_default_currency_sign');
        $this->_sCurrencyCode = $this->_oDb->getParam('pmt_default_currency_code');
    }

    function getCurrencySign()
    {
        return $this->_sCurrencySign;
    }
    function getCurrencyCode()
    {
        return $this->_sCurrencyCode;
    }
    function getIconsUrl()
    {
        return BX_DOL_URL_ROOT . $this->_sIconsFolder;
    }
    function getIconsPath()
    {
        return BX_DIRECTORY_PATH_ROOT . $this->_sIconsFolder;
    }
}
