<?php $mixedData=array (
  0 => 
  array (
    'id' => '1',
    'name' => 'cmd',
    'time' => '0 0 * * *',
    'class' => 'BxDolCronCmd',
    'file' => 'inc/classes/BxDolCronCmd.php',
    'eval' => '',
  ),
  1 => 
  array (
    'id' => '2',
    'name' => 'notifies',
    'time' => '*/10 * * * *',
    'class' => 'BxDolCronNotifies',
    'file' => 'inc/classes/BxDolCronNotifies.php',
    'eval' => '',
  ),
  2 => 
  array (
    'id' => '3',
    'name' => 'video_comments',
    'time' => '* * * * *',
    'class' => 'BxDolCronVideoComments',
    'file' => 'flash/modules/video_comments/inc/classes/BxDolCronVideoComments.php',
    'eval' => '',
  ),
  3 => 
  array (
    'id' => '4',
    'name' => 'sitemap',
    'time' => '0 2 * * *',
    'class' => '',
    'file' => '',
    'eval' => 'bx_import(\'BxDolSiteMaps\');
BxDolSiteMaps::generateAllSiteMaps();',
  ),
  4 => 
  array (
    'id' => '7',
    'name' => 'BxShoutBox',
    'time' => '*/5 * * * *',
    'class' => 'BxShoutBoxCron',
    'file' => 'modules/boonex/shoutbox/classes/BxShoutBoxCron.php',
    'eval' => '',
  ),
); ?>