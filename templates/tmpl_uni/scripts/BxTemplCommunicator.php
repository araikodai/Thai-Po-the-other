<?php

    /**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

    require_once( BX_DIRECTORY_PATH_ROOT . 'templates/base/scripts/BxBaseCommunicator.php');

    class BxTemplCommunicator extends BxBaseCommunicator
    {
         function BxTemplCommunicator($aCommunicatorSettings)
         {
            parent::BxBaseCommunicator($aCommunicatorSettings);
         }
    }
