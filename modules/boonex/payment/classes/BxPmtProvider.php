<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import("BxDolMistake");

class BxPmtProvider extends BxDolMistake
{
    var $_oDb;
    var $_oConfig;

    var $_iId;
    var $_sName;
    var $_sCaption;
    var $_sPrefix;
    var $_aOptions;
    var $_bRedirectOnResult;

    /**
     * Constructor
     */
    function BxPmtProvider($oDb, $oConfig, $aConfig)
    {
        parent::BxDolMistake();

        $this->_oDb = $oDb;
        $this->_oConfig = $oConfig;

        $this->_iId = (int)$aConfig['id'];
        $this->_sName = $aConfig['name'];
        $this->_sCaption = $aConfig['caption'];
        $this->_sPrefix = $aConfig['option_prefix'];
        $this->_aOptions = !empty($aConfig['options']) ? $aConfig['options'] : array();
        $this->_bRedirectOnResult = false;
    }
    /**
     * Is used on success only.
     */
    function needRedirect(){}
    function initializeCheckout($aInfo) {}
    function finalizeCheckout(&$aData) {}

    protected function getOptionsByPending($iPendingId)
    {
        $aPending = $this->_oDb->getPending(array(
            'type' => 'id',
            'id' => (int)$iPendingId
        ));
        return $this->_oDb->getOptions((int)$aPending['seller_id'], $this->_iId);
    }
    protected function getOption($sName)
    {
        return isset($this->_aOptions[$this->_sPrefix . $sName]) ? $this->_aOptions[$this->_sPrefix . $sName]['value'] : "";
    }
}
