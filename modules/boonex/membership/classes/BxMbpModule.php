<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolModule');

/**
 * Membership module by BoonEx
 *
 * This module is needed to integrate the default Membership/ACL engine with Payment module.
 *
 *
 * Profile's Wall:
 * no spy events
 *
 *
 *
 * Spy:
 * no spy events
 *
 *
 *
 * Memberships/ACL:
 * Doesn't depend on user's membership.
 *
 *
 *
 * Service methods:
 *
 * Get the content of the link for Dashboard item in member menu.
 * @see BxMbpModule::serviceGetMemberMenuLink
 * BxDolService::call('membership', 'get_member_menu_link', array($iMemberId));
 * @note is needed for internal usage.
 *
 * Get single item. Is used in Shopping Cart to get one product by specified id.
 * @see BxMbpModule::serviceGetCartItem
 * BxDolService::call('membership', 'get_cart_item', array($iClientId, $iItemId));
 * @note is needed for internal usage.
 *
 * Get items. Is used in Orders Administration to get all products of the requested seller(vendor).
 * @see BxMbpModule::serviceGetItems
 * BxDolService::call('membership', 'get_items', array($iVendorId));
 * @note is needed for internal usage.
 *
 * Register purchased membership level.
 * @see BxMbpModule::serviceRegisterCartItem
 * BxDolService::call('membership', 'register_cart_item', array($iClientId, $iSellerId, $iItemId, $iItemCount, $sOrderId));
 * @note is needed for internal usage.
 *
 * Unregister the membership level purchased earlier.
 * @see BxMbpModule::serviceUnregisterCartItem
 * BxDolService::call('membership', 'unregister_cart_item', array($iClientId, $iSellerId, $iItemId, $iItemCount, $sOrderId));
 * @note the service does nothing because membership level cannot be canceled manually. It should expire by itself.
 *
 *
 * Alerts:
 * no alerts available
 *
 */
class BxMbpModule extends BxDolModule
{
    /**
     * Constructor
     */
    function BxMbpModule($aModule)
    {
        parent::BxDolModule($aModule);

        $this->_oConfig->init($this->_oDb);
    }
    function getCurrentLevelBlock()
    {
        $aUserLevel = getMemberMembershipInfo($this->getUserId());
        return $this->_oTemplate->displayCurrentLevel($aUserLevel);
    }
    function getAvailableLevelsBlock()
    {
        if(!$this->isLogged())
            return MsgBox(_t('_membership_err_required_login'));

        $aMembership = $this->_oDb->getMembershipsBy(array('type' => 'price_all'));
        if(empty($aMembership))
            return MsgBox(_t('_membership_txt_empty'));

        return $this->_oTemplate->displayAvailableLevels($aMembership);
    }

    function serviceGetUpgradeUrl()
    {
        return BX_DOL_URL_ROOT . $this->_oConfig->getBaseUri() . 'index/';
    }

    function serviceGetMemberMenuLink($iMemberId)
    {
        $sTitle = _t('_membership_mmenu_item_membership');

        $aLinkInfo = array(
            'item_img_src' => 'star',
            'item_img_alt' => $sTitle,
            'item_link' => BX_DOL_URL_ROOT . $this->_oConfig->getBaseUri() . 'index',
            'item_onclick' => '',
            'item_title' => $sTitle,
            'extra_info' => 0,
        );

        $oMemberMenu = bx_instance('BxDolMemberMenu');
        return $oMemberMenu->getGetExtraMenuLink($aLinkInfo);
    }

    /*--- Integration with Payment module ---*/
    /**
     * Is used in Orders Administration to get all products of the requested seller(vendor).
     *
     * @param  integer $iVendorId seller ID.
     * @return array   of products.
     */
    function serviceGetItems($iVendorId)
    {
        $aItems = $this->_oDb->getMembershipsBy(array('type' => 'price_all'));

        $aResult = array();
        foreach($aItems as $aItem)
            $aResult[] = array(
                'id' => $aItem['price_id'],
                'vendor_id' => 0,
                'title' => $aItem['mem_name'] . ' ' . _t('_membership_txt_on_N_days', $aItem['price_days']),
                'description' => $aItem['mem_description'],
                'url' => BX_DOL_URL_ROOT . $this->_oConfig->getBaseUri() . 'index',
                'price' => $aItem['price_amount']
            );
        return $aResult;
    }
    /**
     * Is used in Shopping Cart to get one product by specified id.
     *
     * @param  integer $iClientId client's ID.
     * @param  integer $iItemId   product's ID.
     * @return array   with product description.
     */
    function serviceGetCartItem($iClientId, $iItemId)
    {
        return $this->_getCartItem($iClientId, $iItemId);
    }
    /**
     * Register purchased product.
     *
     * @param  integer $iClientId  client's ID.
     * @param  integer $iSellerId  seller's ID.
     * @param  integer $iItemId    product's ID.
     * @param  integer $iItemCount product count purchased at the same time.
     * @param  string  $sOrderId   internal order ID generated for the payment.
     * @return array   with product description.
     */
    function serviceRegisterCartItem($iClientId, $iSellerId, $iItemId, $iItemCount, $sOrderId)
    {
        $bResult = true;
        for($i=0; $i<$iItemCount; $i++)
            $bResult &= buyMembership($iClientId, $iItemId, $sOrderId);

        return $bResult ? $this->_getCartItem($iClientId, $iItemId) : false;
    }
    /**
     * Unregister the product purchased earlier.
     *
     * @param integer $iClientId  client's ID.
     * @param integer $iSellerId  seller's ID.
     * @param integer $iItemId    product's ID.
     * @param integer $iItemCount product count.
     * @param string  $sOrderId   internal order ID.
     */
    function serviceUnregisterCartItem($iClientId, $iSellerId, $iItemId, $iItemCount, $sOrderId) {}


    function _getCartItem($iClientId, $iItemId)
    {
        $aItem = $this->_oDb->getMembershipsBy(array('type' => 'price_id', 'id' => $iItemId));

        if(empty($aItem) || !is_array($aItem))
           return array();

        return array(
           'id' => $iItemId,
           'title' => $aItem['mem_name'] . ' ' . _t('_membership_txt_on_N_days', $aItem['price_days']),
           'description' => $aItem['mem_description'],
           'url' => BX_DOL_URL_ROOT . $this->_oConfig->getBaseUri() . 'index',
           'price' => $aItem['price_amount']
        );
    }
}
