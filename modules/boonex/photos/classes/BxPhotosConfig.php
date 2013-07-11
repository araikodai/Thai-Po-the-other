<?php
/**
 * Copyright (c) BoonEx Pty Limited - http://www.boonex.com/
 * CC-BY License - http://creativecommons.org/licenses/by/3.0/
 */

require_once(BX_DIRECTORY_PATH_CLASSES . 'BxDolFilesConfig.php');

class BxPhotosConfig extends BxDolFilesConfig
{
    /**
     * Constructor
     */
    function BxPhotosConfig (&$aModule)
    {
        parent::BxDolFilesConfig($aModule);
        $this->aFilePostfix = array(
                'thumb' => '_rt.jpg',
                'browse' => '_t.jpg',
                'icon' => '_ri.jpg',
                'file' => '_m.jpg',
                'original' => '.{ext}'
        );
        $this->aGlParams = array(
                'auto_activation' => 'bx_photos_activation',
                'mode_top_index' => 'bx_photos_mode_index',
                'category_auto_approve' => 'category_auto_activation_bx_photos',
                'number_previous_rated' => 'bx_photos_number_previous_rated',
        );

        if(!defined("FLICKR_PHOTO_RSS"))
            define("FLICKR_PHOTO_RSS", "http://api.flickr.com/services/rest/?method=flickr.photos.getInfo&api_key=#api_key#&photo_id=#photo#");
        if(!defined("FLICKR_PHOTO_URL"))
            define("FLICKR_PHOTO_URL", "http://farm#farm#.static.flickr.com/#server#/#id#_#secret##mode#.#ext#");
    }
}
