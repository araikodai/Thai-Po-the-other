<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

require_once("BxPmtProvider.php");

define('TUCO_MODE_LIVE', 1);
define('TUCO_MODE_TEST', 2);

define('TUCO_PAYMENT_METHOD_CC', 'CC');
define('TUCO_PAYMENT_METHOD_CK', 'CK');
define('TUCO_PAYMENT_METHOD_AL', 'AL');
define('TUCO_PAYMENT_METHOD_PPI', 'PPI');

class BxPmt2Checkout extends BxPmtProvider
{
    var $_sDataReturnUrl;

    /**
     * Constructor
     */
    function BxPmt2Checkout($oDb, $oConfig, $aConfig)
    {
        parent::BxPmtProvider($oDb, $oConfig, $aConfig);
        $this->_bRedirectOnResult = true;

        $this->_sDataReturnUrl = $this->_oConfig->getDataReturnUrl() . $this->_sName . '/';
    }
    function needRedirect()
    {
        return $this->_bRedirectOnResult;
    }
    function initializeCheckout($iPendingId, $aCartInfo, $bRecurring = false, $iRecurringDays = 0)
    {
        $sActionURL = 'https://www.2checkout.com/checkout/purchase';

        $aFormData = array(
            'sid' => $this->getOption('account_id'),
            'total' => sprintf("%.2f", (float)$aCartInfo['items_price']),
            'cart_order_id' => $iPendingId,

            'id_type' => 1,
            'c_prod' => $iPendingId,
            'c_name' => _t('_payment_txt_payment_to') . ' ' . $aCartInfo['vendor_username'],

            'demo' => (int)$this->getOption('mode') == TUCO_MODE_TEST ? 'Y' : '',
            'pay_method' => $this->getOption('payment_method'),
            'x_receipt_link_url' => $this->_sDataReturnUrl . $aCartInfo['vendor_id']
        );

        Redirect($sActionURL, $aFormData, 'post', $this->_sCaption);
        exit();
    }
    function finalizeCheckout(&$aData)
    {
        return $this->_registerCheckout($aData);
    }

    /**
     *
     * @param $aData - data from payment provider.
     * @param $bSubscription - Is not needed. May be used in the future for subscriptions.
     * @param $iPendingId - Is not needed. May be used in the future for subscriptions.
     * @return array with results.
     */
    function _registerCheckout(&$aData, $bSubscription = false, $iPendingId = 0)
    {
        if(empty($this->_aOptions) && isset($aData['cart_order_id']))
            $this->_aOptions = $this->getOptionsByPending($aData['cart_order_id']);

        if(empty($this->_aOptions))
            return array('code' => 2, 'message' => _t('_payment_2co_err_no_vendor_given'));

        $aResult = $this->_validateCheckout($aData);

        if(empty($aResult['pending_id']))
            return $aResult;

        $aPending = $this->_oDb->getPending(array('type' => 'id', 'id' => (int)$aResult['pending_id']));
        if(!empty($aPending['order']) || !empty($aPending['error_code']) || !empty($aPending['error_msg']))
            return array('code' => 6, 'message' => _t('_payment_2co_err_already_processed'));

        $this->_oDb->updatePending((int)$aResult['pending_id'], array(
            'order' => $aData['order_number'],
            'error_code' => $aResult['code'],
            'error_msg' => $aResult['message']
        ));
        return $aResult;
    }
    function _validateCheckout(&$aData)
    {
        if(empty($aData['order_number']) || empty($aData['total']) || empty($aData['key']) || empty($aData['cart_order_id']))
            return array('code' => 3, 'message' => _t('_payment_2co_err_no_data_given'));

        $sOrder = $aData['order_number'];
        $fAmount = (float)$aData['total'];
        $iPendingId = (int)$aData['cart_order_id'];

        if($aData['key'] != $this->_generateKey($sOrder, $fAmount))
            return array('code' => 4, 'message' => _t('_payment_2co_err_wrong_key'), 'pending_id' => $iPendingId);

        $aPending = $this->_oDb->getPending(array('type' => 'id', 'id' => $iPendingId));
        if($fAmount != (float)$aPending['amount'])
            return array('code' => 5, 'message' => _t('_payment_2co_err_wrong_payment'), 'pending_id' => $iPendingId);

        return array('code' => 1, 'message' => _t('_payment_2co_msg_verified'), 'pending_id' => $iPendingId);
    }
    function _generateKey($sOrder, $fAmount)
    {
        $sKey = $this->getOption('secret_word') . $this->getOption('account_id') . $sOrder . sprintf("%.2f", $fAmount);
        return strtoupper(md5($sKey));
    }
}
