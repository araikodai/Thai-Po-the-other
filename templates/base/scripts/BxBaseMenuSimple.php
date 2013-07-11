<?php

    /**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

    bx_import('BxDolMenuSimple');

    /**
     * @see BxDolMenuBottom;
     */
    class BxBaseMenuSimple extends BxDolMenuSimple
    {
        /**
         * Class constructor;
         */
        function BxBaseMenuSimple()
        {
            parent::BxDolMenuSimple();
        }

        /*
         * Generate navigation menu source
         */
        function getCode()
        {
            if(empty($this->aItems))
                $this->load();

            if(isset($GLOBALS['bx_profiler']))
                $GLOBALS['bx_profiler']->beginMenu(ucfirst($this->sName) . ' Menu');

            $sResult = $this->getItems();

            if(isset($GLOBALS['bx_profiler']))
                $GLOBALS['bx_profiler']->endMenu(ucfirst($this->sName) . ' Menu');

            return $sResult;
        }

        function getItems()
        {
            $aTmplVars = array();
            foreach($this->aItems as $aItem) {
                if(!$this->checkToShow($aItem))
                    continue;

                list( $aItem['Link'] ) = explode( '|', $aItem['Link'] );

                $aItem['Caption'] = $this->replaceMetas($aItem['Caption']);
                $aItem['Link'] = $this->replaceMetas($aItem['Link']);
                $aItem['Script'] = $this->replaceMetas($aItem['Script']);

                $aTmplVars[] = array(
                    'caption' => _t($aItem['Caption']),
                    'link' => $aItem['Script'] ? 'javascript:void(0)' : $this->oPermalinks->permalink($aItem['Link']),
                    'script' => $aItem['Script'] ? 'onclick="' . $aItem['Script'] . '"' : null,
                    'target' => $aItem['Target'] ? 'target="_blank"' : null
                );
            }

            return $GLOBALS['oSysTemplate']->parseHtmlByName('extra_' . $this->sName . '_menu.html', array('bx_repeat:items' => $aTmplVars));
        }
    }
