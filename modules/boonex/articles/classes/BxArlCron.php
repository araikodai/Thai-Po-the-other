<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolTextCron');

class BxArlCron extends BxDolTextCron
{
    function BxArlCron()
    {
        parent::BxDolTextCron();

        $this->_oModule = BxDolModule::getInstance('BxArlModule');
    }
}
