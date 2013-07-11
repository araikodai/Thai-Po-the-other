<?php

    /**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

    require_once(BX_DIRECTORY_PATH_CLASSES . 'BxDolConfig.php');

    class BxShoutBoxConfig extends BxDolConfig
    {
        // contain Db table's name ;
        var $sTablePrefix;
        var $iLifeTime;

        var $iUpdateTime;
        var $iAllowedMessagesCount;
        var $bProcessSmiles;
        var $aSmiles;

        /**
         * Class constructor;
         */
        function BxShoutBoxConfig($aModule)
        {
            parent::BxDolConfig($aModule);

            // define the tables prefix ;
            $this -> sTablePrefix 			= $this -> getDbPrefix();
            $this -> iLifeTime 				= (int) getParam('shoutbox_clean_oldest'); //in seconds

            $this -> iUpdateTime            = (int) getParam('shoutbox_update_time'); //(in milliseconds)
            $this -> iAllowedMessagesCount  = (int) getParam('shoutbox_allowed_messages');

            $this -> bProcessSmiles         = 'on' == getParam('shoutbox_process_smiles')
                ? true
                : false;

            $this -> iBlockExpirationSec   = (int) getParam('shoutbox_block_sec'); //in seconds

            //list of processed smiles
            $this -> aSmiles = array(
                ':arrow:'  => 'icon_arrow.gif',
                ':D'       => 'icon_biggrin.gif',
                ':-D'      => 'icon_biggrin.gif',
                ':grin:'   => 'icon_biggrin.gif',
                ':?'       => 'icon_confused.gif',
                ':-?'      => 'icon_confused.gif',
                '???:'     => 'icon_confused.gif',
                '8)'       => 'icon_cool.gif',
                '8-)'      => 'icon_cool.gif',
                ':cool:'   => 'icon_cool.gif',
                ':cry:'    => 'icon_cry.gif',
                ':shock:'  => 'icon_eek.gif',
                ':evil:'   => 'icon_evil.gif',
                ':!:'      => 'icon_exclaim.gif',
                ':idea:'   => 'icon_idea.gif',
                ':lol:'    => 'icon_lol.gif',
                ':x'       => 'icon_mad.gif',
                ':-x'      => 'icon_mad.gif',
                ':mad:'    => 'icon_mad.gif',
                ':mrgreen' => 'icon_mrgreen.gif',
                ':|'       => 'icon_neutral.gif',
                ':-|'      => 'icon_neutral.gif',
                ':neutral' => 'icon_neutral.gif',
                ':?:'      => 'icon_question.gif',
                ':P'       => 'icon_razz.gif',
                ':-P'      => 'icon_razz.gif',
                ':razz:'   => 'icon_razz.gif',
                ':oops:'   => 'icon_redface.gif',
                ':roll:'   => 'icon_rolleyes.gif',
                ':('       => 'icon_sad.gif',
                ':-('      => 'icon_sad.gif',
                ':sad:'    => 'icon_sad.gif',
                ':)'       => 'icon_smile.gif',
                ':-)'      => 'icon_smile.gif',
                ':smile:'  => 'icon_smile.gif',
                ':o'       => 'icon_surprised.gif',
                ':-o'      => 'icon_surprised.gif',
                ':eek:'    => 'icon_surprised.gif',
                ':twisted' => 'icon_twisted.gif',
                ':wink:'   => 'icon_wink.gif',
                ';)'       => 'icon_wink.gif',
                ';-)'      => 'icon_wink.gif',
            );
        }
    }
