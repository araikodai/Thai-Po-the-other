<?php

/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolDb');

/**
 * @see BxDolSocialSharing
 */
class BxDolSocialSharingQuery extends BxDolDb
{

    function __construct()
    {
        parent::__construct();
    }

    function getActiveButtons ()
    {
        return $this->fromCache('sys_objects_social_sharing', 'getAll', 'SELECT * FROM `sys_objects_social_sharing` WHERE `active` = 1 ORDER BY `order` ASC');
    }

}
