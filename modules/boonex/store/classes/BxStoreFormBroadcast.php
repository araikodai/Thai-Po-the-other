<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

bx_import('BxDolTwigFormBroadcast');

class BxStoreFormBroadcast extends BxDolTwigFormBroadcast
{
    function BxStoreFormBroadcast ()
    {
        parent::BxDolTwigFormBroadcast (_t('_bx_store_form_caption_broadcast_title'), _t('_bx_store_form_err_broadcast_title'), _t('_bx_store_form_caption_broadcast_message'), _t('_bx_store_form_err_broadcast_message'));
    }
}
