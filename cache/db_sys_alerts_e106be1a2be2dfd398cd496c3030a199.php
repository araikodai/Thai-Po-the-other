<?php $mixedData=array (
  'alerts' => 
  array (
    'system' => 
    array (
      'begin' => 
      array (
        0 => '1',
      ),
      'design_included' => 
      array (
        0 => '28',
      ),
    ),
    'profile' => 
    array (
      'before_join' => 
      array (
        0 => '2',
      ),
      'join' => 
      array (
        0 => '2',
        1 => '3',
        2 => '4',
      ),
      'before_login' => 
      array (
        0 => '2',
      ),
      'login' => 
      array (
        0 => '2',
      ),
      'logout' => 
      array (
        0 => '2',
      ),
      'edit' => 
      array (
        0 => '2',
        1 => '3',
        2 => '4',
        3 => '39',
        4 => '41',
      ),
      'delete' => 
      array (
        0 => '3',
        1 => '4',
        2 => '8',
        3 => '9',
        4 => '10',
        5 => '16',
        6 => '29',
        7 => '30',
        8 => '32',
        9 => '39',
        10 => '41',
      ),
      'change_status' => 
      array (
        0 => '4',
      ),
      'commentRemoved' => 
      array (
        0 => '5',
      ),
      'edit_status_message' => 
      array (
        0 => '39',
      ),
      'commentPost' => 
      array (
        0 => '39',
      ),
    ),
    'bx_photos' => 
    array (
      'delete' => 
      array (
        0 => '11',
        1 => '17',
      ),
      'add' => 
      array (
        0 => '39',
      ),
      'commentPost' => 
      array (
        0 => '39',
      ),
    ),
    'bx_videos' => 
    array (
      'delete' => 
      array (
        0 => '11',
        1 => '17',
        2 => '21',
      ),
      'display_player' => 
      array (
        0 => '19',
      ),
      'convert' => 
      array (
        0 => '20',
      ),
    ),
    'bx_sounds' => 
    array (
      'delete' => 
      array (
        0 => '11',
        1 => '17',
        2 => '24',
      ),
      'display_player' => 
      array (
        0 => '22',
      ),
      'convert' => 
      array (
        0 => '23',
      ),
    ),
    'bx_files' => 
    array (
      'delete' => 
      array (
        0 => '11',
        1 => '17',
      ),
    ),
    'module' => 
    array (
      'install' => 
      array (
        0 => '12',
        1 => '18',
      ),
    ),
    'bx_video_comments' => 
    array (
      'embed' => 
      array (
        0 => '25',
      ),
      'convert' => 
      array (
        0 => '26',
      ),
      'delete' => 
      array (
        0 => '27',
      ),
    ),
    'friend' => 
    array (
      'accept' => 
      array (
        0 => '39',
      ),
    ),
    'bx_avatar' => 
    array (
      'add' => 
      array (
        0 => '39',
      ),
      'change' => 
      array (
        0 => '39',
      ),
    ),
    'bx_blogs' => 
    array (
      'create' => 
      array (
        0 => '39',
      ),
      'commentPost' => 
      array (
        0 => '39',
      ),
    ),
    'bx_events' => 
    array (
      'add' => 
      array (
        0 => '39',
      ),
      'commentPost' => 
      array (
        0 => '39',
      ),
    ),
    'bx_groups' => 
    array (
      'add' => 
      array (
        0 => '39',
      ),
      'commentPost' => 
      array (
        0 => '39',
      ),
    ),
  ),
  'handlers' => 
  array (
    1 => 
    array (
      'class' => 'BxDolAlertsResponseSystem',
      'file' => 'inc/classes/BxDolAlertsResponseSystem.php',
      'eval' => '',
    ),
    2 => 
    array (
      'class' => 'BxDolAlertsResponseProfile',
      'file' => 'inc/classes/BxDolAlertsResponseProfile.php',
      'eval' => '',
    ),
    3 => 
    array (
      'class' => 'BxDolUpdateMembersCache',
      'file' => 'inc/classes/BxDolUpdateMembersCache.php',
      'eval' => '',
    ),
    4 => 
    array (
      'class' => 'BxDolAlertsResponceMatch',
      'file' => 'inc/classes/BxDolAlertsResponceMatch.php',
      'eval' => '',
    ),
    5 => 
    array (
      'class' => 'BxDolVideoDeleteResponse',
      'file' => 'flash/modules/video_comments/inc/classes/BxDolVideoDeleteResponse.php',
      'eval' => '',
    ),
    8 => 
    array (
      'class' => 'BxAvaProfileDeleteResponse',
      'file' => 'modules/boonex/avatar/classes/BxAvaProfileDeleteResponse.php',
      'eval' => '',
    ),
    9 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'blogs\', \'response_profile_delete\', array($this));',
    ),
    10 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'events\', \'response_profile_delete\', array($this));',
    ),
    11 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'events\', \'response_media_delete\', array($this));',
    ),
    12 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'if (\'wmap\' == $this->aExtras[\'uri\'] && $this->aExtras[\'res\'][\'result\']) BxDolService::call(\'events\', \'map_install\');',
    ),
    16 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'groups\', \'response_profile_delete\', array($this));',
    ),
    17 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'groups\', \'response_media_delete\', array($this));',
    ),
    18 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'if (\'wmap\' == $this->aExtras[\'uri\'] && $this->aExtras[\'res\'][\'result\']) BxDolService::call(\'groups\', \'map_install\');',
    ),
    19 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'h5av\', \'response_video_player\', array($this));',
    ),
    20 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'h5av\', \'response_video_convert\', array($this));',
    ),
    21 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'h5av\', \'response_video_delete\', array($this));',
    ),
    22 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'h5av\', \'response_audio_player\', array($this));',
    ),
    23 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'h5av\', \'response_audio_convert\', array($this));',
    ),
    24 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'h5av\', \'response_audio_delete\', array($this));',
    ),
    25 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'h5av\', \'response_cmts_player\', array($this));',
    ),
    26 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'h5av\', \'response_cmts_convert\', array($this));',
    ),
    27 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'h5av\', \'response_cmts_delete\', array($this));',
    ),
    28 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'pageac\', \'responce_protect_URL\', array($_SERVER[\'REQUEST_URI\']));',
    ),
    29 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'payment\', \'response\', array($this));',
    ),
    30 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'photos\', \'response_profile_delete\', array($this));',
    ),
    32 => 
    array (
      'class' => 'BxSimpleMessengerResponse',
      'file' => 'modules/boonex/simple_messenger/classes/BxSimpleMessengerResponse.php',
      'eval' => '',
    ),
    39 => 
    array (
      'class' => '',
      'file' => '',
      'eval' => 'BxDolService::call(\'wall\', \'response\', array($this));',
    ),
    41 => 
    array (
      'class' => 'BxForumProfileResponse',
      'file' => 'modules/boonex/forum/profile_response.php',
      'eval' => '',
    ),
  ),
); ?>