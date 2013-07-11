<?php $mixedData=array (
  'page_0' => 
  array (
    'injection_header' => 
    array (
      0 => 
      array (
        'page_index' => '0',
        'name' => 'flash_integration',
        'key' => 'injection_header',
        'type' => 'php',
        'data' => 'return getRayIntegrationJS(true);',
        'replace' => '0',
      ),
      1 => 
      array (
        'page_index' => '0',
        'name' => 'messenger_invitation',
        'key' => 'injection_header',
        'type' => 'php',
        'data' => 'return BxDolService::call(\'messenger\', \'get_invitation\');',
        'replace' => '0',
      ),
      2 => 
      array (
        'page_index' => '0',
        'name' => 'bx_simple_messenger_core_init',
        'key' => 'injection_header',
        'type' => 'php',
        'data' => 'return BxDolService::call(\'simple_messenger\', \'get_messenger_core\');',
        'replace' => '0',
      ),
    ),
    'injection_logo_before' => 
    array (
      0 => 
      array (
        'page_index' => '0',
        'name' => 'site_search',
        'key' => 'injection_logo_before',
        'type' => 'php',
        'data' => 'return $GLOBALS[\'oFunctions\']->genSiteSearch();',
        'replace' => '0',
      ),
    ),
    'injection_logo_after' => 
    array (
      0 => 
      array (
        'page_index' => '0',
        'name' => 'site_service_menu',
        'key' => 'injection_logo_after',
        'type' => 'php',
        'data' => 'return $GLOBALS[\'oFunctions\']->genSiteServiceMenu();',
        'replace' => '0',
      ),
    ),
    'banner_bottom' => 
    array (
      0 => 
      array (
        'page_index' => '0',
        'name' => 'banner_bottom',
        'key' => 'banner_bottom',
        'type' => 'php',
        'data' => 'return banner_put_nv(4);',
        'replace' => '0',
      ),
    ),
    'banner_right' => 
    array (
      0 => 
      array (
        'page_index' => '0',
        'name' => 'banner_right',
        'key' => 'banner_right',
        'type' => 'php',
        'data' => 'return banner_put_nv(3);',
        'replace' => '0',
      ),
    ),
    'banner_top' => 
    array (
      0 => 
      array (
        'page_index' => '0',
        'name' => 'banner_top',
        'key' => 'banner_top',
        'type' => 'php',
        'data' => 'return banner_put_nv(1);',
        'replace' => '0',
      ),
    ),
    'banner_left' => 
    array (
      0 => 
      array (
        'page_index' => '0',
        'name' => 'banner_left',
        'key' => 'banner_left',
        'type' => 'php',
        'data' => 'return banner_put_nv(2);',
        'replace' => '0',
      ),
    ),
  ),
); ?>