<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxTemplFormView');

class BxPmtDetails
{
    var $_oDb;
    var $_oConfig;
    var $_aForm;

    /*
     * Constructor.
     */
    function BxPmtDetails(&$oDb, &$oConfig)
    {
        $this->_oDb = &$oDb;
        $this->_oConfig = &$oConfig;

        $this->_aForm = array(
            'form_attrs' => array(
                'id' => 'pmt_details',
                'name' => 'pmt_details',
                'action' => BX_DOL_URL_ROOT . $this->_oConfig->getBaseUri() . 'details/',
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            ),
            'params' => array(
                'db' => array(
                    'table' => '',
                    'key' => 'id',
                    'uri' => '',
                    'uri_title' => '',
                    'submit_name' => 'submit'
                ),
            ),
            'inputs' => array (
            )
        );
    }

    function getForm($iUserId)
    {
        $aInputs = $this->_oDb->getForm();
        if(empty($aInputs))
            return '';

        if($iUserId == BX_PMT_ADMINISTRATOR_ID)
            $this->_aForm['form_attrs']['action'] = BX_DOL_URL_ROOT . $this->_oConfig->getBaseUri() . 'admin/';

        $bCollapsed = true;
        $iProviderId = 0;
        $sProviderName = "";
        $aUserValues = $this->_oDb->getFormData($iUserId);
        foreach($aInputs as $aInput) {
            $sReturnDataUrl = $this->_oConfig->getDataReturnUrl() . $sProviderName . '/' . $iUserId;

            if($iProviderId != $aInput['provider_id']) {
                if(!empty($iProviderId))
                    $this->_aForm['inputs']['provider_' . $iProviderId . '_link'] = array(
                        'type' => 'value',
                        'caption' => _t('_payment_details_return_url'),
                        'value' => $sReturnDataUrl,
                    );
                    $this->_aForm['inputs']['provider_' . $iProviderId . '_end'] = array(
                        'type' => 'block_end'
                    );
                $this->_aForm['inputs']['provider_' . $iProviderId . '_begin'] = array(
                    'type' => 'block_header',
                    'caption' => $aInput['provider_caption'],
                    'collapsable' => true,
                    'collapsed' => $bCollapsed
                );

                $iProviderId = $aInput['provider_id'];
                $sProviderName = $aInput['provider_name'];
                $bCollapsed = true;
            }

            $this->_aForm['inputs'][$aInput['name']] = array(
               'type' => $aInput['type'],
                'name' => $aInput['name'],
                'caption' => _t($aInput['caption']),
                'value' => $aUserValues[$aInput['id']]['value'],
                'info' => _t($aInput['description']),
                'checker' => array (
                    'func' => $aInput['check_type'],
                    'params' => $aInput['check_params'],
                    'error' => _t($aInput['check_error']),
                )
            );

            //--- Make some field dependent actions ---//
            switch($aInput['type']) {
                case 'select':
                    if(empty($aInput['extra']))
                       break;

                    $aAddon = array('values' => array());

                    $aPairs = explode(',', $aInput['extra']);
                    foreach($aPairs as $sPair) {
                        $aPair = explode('|', $sPair);
                        $aAddon['values'][] = array('key' => $aPair[0], 'value' => _t($aPair[1]));
                    }
                    break;
                case 'checkbox':
                    $this->_aForm['inputs'][$aInput['name']]['value'] = 'on';
                    $aAddon = array('checked' => $aUserValues[$aInput['id']]['value'] == 'on' ? true : false);
                    break;
            }

            if(!empty($aAddon) && is_array($aAddon))
                $this->_aForm['inputs'][$aInput['name']] = array_merge($this->_aForm['inputs'][$aInput['name']], $aAddon);
        }
        $this->_aForm['inputs']['provider_' . $iProviderId . '_link'] = array(
            'type' => 'value',
            'caption' => _t('_payment_details_return_url'),
            'value' => $sReturnDataUrl,
        );
        $this->_aForm['inputs']['provider_' . $iProviderId . '_end'] = array(
            'type' => 'block_end'
        );
        $this->_aForm['inputs']['submit'] = array(
            'type' => 'submit',
            'name' => 'submit',
            'value' => _t("_payment_details_submit"),
        );

        $oForm = new BxTemplFormView($this->_aForm);
        $oForm->initChecker();

        if($oForm->isSubmittedAndValid()) {
            $aOptions = $this->_oDb->getOptions();
            foreach($aOptions as $aOption)
                $this->_oDb->updateOption($iUserId, $aOption['id'], process_db_input(isset($_POST[$aOption['name']]) ? $_POST[$aOption['name']] : "", BX_TAGS_STRIP));
            header('Location: ' . $oForm->aFormAttrs['action']);
        } else
            return $oForm->getCode();
    }
}
