<?php

    /**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

    bx_import('BxDolModuleTemplate');

    class BxShoutBoxTemplate extends BxDolModuleTemplate
    {
        /**
         * Class constructor
         */
        function BxShoutBoxTemplate( &$oConfig, &$oDb )
        {
            parent::BxDolModuleTemplate($oConfig, $oDb);
        }

        /**
         * Admin page start
         *
         * @return void
         */
        function pageCodeAdminStart()
        {
            ob_start();
        }

        /**
         * Get admin block
         *
         * @param $sContent text
         * @param $sTitle string
         * @param $aMenu array
         * @return text
         */
        function adminBlock ($sContent, $sTitle, $aMenu = array())
        {
            return DesignBoxAdmin($sTitle, $sContent, $aMenu);
        }

        /**
         * Get admin page
         *
         * @param $sTitle string
         * @return text
         */
        function pageCodeAdmin ($sTitle)
        {
            global $_page;
            global $_page_cont;

            $_page['name_index'] = 9;

            $_page['header'] = $sTitle ? $sTitle : $GLOBALS['site']['title'];
            $_page['header_text'] = $sTitle;

            $_page_cont[$_page['name_index']]['page_main_code'] = ob_get_clean();

            PageCodeAdmin();
        }

        /**
         * Get processed message
         *
         * @param $aMessages array
         * @param $bDeleteAllowed boolean
         * @param $bBlockAllowed boolean
         * @return text
         */
        function getProcessedMessages($aMessages = array(), $bDeleteAllowed = false, $bBlockAllowed = false)
        {
            global $oFunctions;

            if(!$aMessages) {
                return;
            }

            $sOutputCode = '';
            $aLanguageKeys  = array(
                'by'        => _t('_bx_shoutbox_by'),
                'visitor'   => _t('_Visitor'),
                'delete'	=> _t('_bx_shoutbox_delete_message'),
                'sure'		=> _t('_Are you sure?'),
                'block'		=> _t('_bx_shoutbox_block_ip'),
            );

            foreach($aMessages as $iKey => $aItems) {
                 $sMemberIcon  = '';
                 $aProfileInfo = $aItems['OwnerID'] > 0
                     ? getProfileInfo($aItems['OwnerID'])
                    : array();

                // define some profile's data;
                if($aProfileInfo) {
                    $sNickName   = getNickName($aProfileInfo['ID']);
                    $sLink       = getProfileLink($aItems['OwnerID']);
                    $sMemberIcon = $oFunctions -> getMemberIcon($aItems['OwnerID']);
                } else {
                    $sLink      = 'javascript:void(0)';
                    $sNickName  = $aLanguageKeys['visitor'];
                }

                $aKeys = array
                (
                    'owner_icon'    => $sMemberIcon,
                    'message'       => $aItems['Message'],
                    'by'            => $aLanguageKeys['by'],
                    'owner_nick'    => $sNickName,
                    'date'          => getLocaleDate( strtotime($aItems['Date']), BX_DOL_LOCALE_DATE),
                    'owner_link'    => $sLink,

                    'bx_if:delete_allowed' => array (
                        'condition' =>  $bDeleteAllowed,
                        'content'   => array (
                            'delete_cpt' => bx_html_attribute($aLanguageKeys['delete']),
                            'sure_cpt' => bx_js_string($aLanguageKeys['sure']),
                            'message_id' => $aItems['ID'],
                        ),
                    ),
                    'bx_if:block_allowed' => array (
                        'condition' =>  $bBlockAllowed,
                        'content'   => array (
                            'block_cpt' => bx_html_attribute($aLanguageKeys['block']),
                            'sure_cpt' => bx_js_string($aLanguageKeys['sure']),
                            'message_id' => $aItems['ID'],
                        ),
                    ),
                );

                $sTemplateName = $aProfileInfo
                    ? 'message.html'
                    : 'visitor_message.html';

                $sOutputCode .=  $this -> parseHtmlByName($sTemplateName, $aKeys);
            }

            return $sOutputCode;
        }

        /**
         * Get shoutbox window
         *
         * @param $sModulePath string
         * @param $iLastMessageId integer
         * @param $sMessagesList string
         * @return text
         */
        function getShoutboxWindow($sModulePath, $iLastMessageId = 0, $sMessagesList = '')
        {
            $this -> addJS('shoutbox.js');
            $this -> addCss('shoutbox.css');

           $aForm = array (
                'params'=> array('remove_form' => true),

                'inputs' => array (
                    'messages'   => array(
                        'type'    => 'custom',
                        'content' => '<div class="shoutbox_wrapper">' . $sMessagesList . '</div>',
                        'colspan' => true,
                    ),

                    'message'   => array(
                        'type'      => 'text',
                        'name'      => 'message',
                        'colspan'   => true,
                        'attrs' => array(
                            'onkeypress' => "if(typeof oShoutBox != 'undefined') return oShoutBox.sendMessage(event, this);",
                            'id'      => 'shoutbox_msg_field',
                        ),
                    ),
                ),
            );

            $aKeys = array(
                'message_empty_message' => _t('_bx_shoutbox_enter_message'),
                'module_path' => $sModulePath,
                'update_time' => $this -> _oConfig -> iUpdateTime,
                'last_message_id' => $iLastMessageId,
                'wait_cpt' => _t('_bx_shoutbox_wait'),
            );

            $sOutputCode = $this -> parseHtmlByName('shoutbox_init.html', $aKeys);

            $oForm       = new BxTemplFormView($aForm);
            return $this->parseHtmlByName('default_margin.html', array(
                'content' => $oForm -> getCode() . $sOutputCode
            ));
        }
    }
