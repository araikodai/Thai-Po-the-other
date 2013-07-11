<?php $mixedData=array (
  'mma' => 
  array (
    'Type' => 'mma',
    'SQL' => 'SELECT COUNT(*) FROM `sys_messages` WHERE `Recipient`=\'__member_id__\' AND NOT FIND_IN_SET(\'Recipient\', `sys_messages`.`Trash`)',
  ),
  'mmn' => 
  array (
    'Type' => 'mmn',
    'SQL' => 'SELECT COUNT(*) FROM `sys_messages` WHERE `Recipient`=\'__member_id__\' AND `New`=\'1\' AND NOT FIND_IN_SET(\'Recipient\', `sys_messages`.`Trash`)',
  ),
  'mfl' => 
  array (
    'Type' => 'mfl',
    'SQL' => 'SELECT COUNT(*) FROM `sys_fave_list` WHERE `ID` = \'__member_id__\' ',
  ),
  'mfr' => 
  array (
    'Type' => 'mfr',
    'SQL' => 'SELECT COUNT(*) FROM `sys_friend_list` as f LEFT JOIN `Profiles` as p ON p.`ID` = f.`ID` WHERE f.`Profile` = __member_id__ AND f.`Check` = \'0\' AND p.`Status`=\'Active\'',
  ),
  'mfa' => 
  array (
    'Type' => 'mfa',
    'SQL' => 'SELECT COUNT(*) FROM `sys_friend_list` WHERE ( `ID`=\'__member_id__\' OR `Profile`=\'__member_id__\' ) AND `Check`=\'1\'',
  ),
  'mgc' => 
  array (
    'Type' => 'mgc',
    'SQL' => 'SELECT COUNT(*) FROM `sys_greetings` WHERE `ID` = \'__member_id__\' AND New = \'1\'',
  ),
  'mbc' => 
  array (
    'Type' => 'mbc',
    'SQL' => 'SELECT COUNT(*) FROM `sys_block_list` WHERE `ID` = \'__member_id__\'',
  ),
  'mgmc' => 
  array (
    'Type' => 'mgmc',
    'SQL' => 'SELECT COUNT(*) FROM `sys_greetings` WHERE `Profile` = \'__member_id__\' AND New = \'1\'',
  ),
  'mbpc' => 
  array (
    'Type' => 'mbpc',
    'SQL' => 'SELECT COUNT(*) FROM `bx_blogs_cmts` INNER JOIN `bx_blogs_posts` ON `bx_blogs_posts`.`PostID` = `cmt_object_id` WHERE `bx_blogs_posts`.`OwnerId` = \'__member_id__\'',
  ),
  'mbp' => 
  array (
    'Type' => 'mbp',
    'SQL' => 'SELECT COUNT(*) FROM `bx_blogs_posts` WHERE `bx_blogs_posts`.`OwnerId` = \'__member_id__\'',
  ),
  'bx_events' => 
  array (
    'Type' => 'bx_events',
    'SQL' => 'SELECT COUNT(*) FROM `bx_events_main` WHERE `ResponsibleID` = \'__member_id__\' AND `Status`=\'approved\'',
  ),
  'bx_eventsp' => 
  array (
    'Type' => 'bx_eventsp',
    'SQL' => 'SELECT COUNT(*) FROM `bx_events_main` WHERE `ResponsibleID` = \'__member_id__\' AND `Status`!=\'approved\'',
  ),
  'mop' => 
  array (
    'Type' => 'mop',
    'SQL' => 'SELECT COUNT(*) FROM `bx_forum_post` WHERE `user` = \'__member_nick__\'',
  ),
  'mot' => 
  array (
    'Type' => 'mot',
    'SQL' => 'SELECT COUNT(*) FROM `bx_forum_topic` WHERE `first_post_user` = \'__member_nick__\'',
  ),
  'bx_groups' => 
  array (
    'Type' => 'bx_groups',
    'SQL' => 'SELECT COUNT(*) FROM `bx_groups_main` WHERE `author_id` = \'__member_id__\' AND `status`=\'approved\'',
  ),
  'bx_groupsp' => 
  array (
    'Type' => 'bx_groupsp',
    'SQL' => 'SELECT COUNT(*) FROM `bx_groups_main` WHERE `author_id` = \'__member_id__\' AND `Status`!=\'approved\'',
  ),
  'phs' => 
  array (
    'Type' => 'phs',
    'SQL' => 'SELECT COUNT(*) FROM `bx_photos_main` WHERE `Owner` = \'__member_id__\' AND `Status` = \'approved\'',
  ),
); ?>