<?php $mixedData=array (
  'Profile' => 
  array (
    0 => 
    array (
      'Caption' => '_Simle Messenger',
      'Icon' => '',
      'Url' => '',
      'Script' => '',
      'Eval' => 'return BxDolService::call(\'simple_messenger\', \'get_messenger_field\', array({ID}));',
      'bDisplayInSubMenuHeader' => '0',
    ),
    1 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'edit',
      'Url' => 'pedit.php?ID={ID}',
      'Script' => '',
      'Eval' => 'if ({ID} != {member_id}) return;
return _t(\'{cpt_edit}\');',
      'bDisplayInSubMenuHeader' => '0',
    ),
    2 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'envelope',
      'Url' => 'mail.php?mode=compose&recipient_id={ID}',
      'Script' => '',
      'Eval' => 'if ({ID} == {member_id}) return;
return _t(\'{cpt_send_letter}\');',
      'bDisplayInSubMenuHeader' => '0',
    ),
    3 => 
    array (
      'Caption' => '{cpt_fave}',
      'Icon' => 'asterisk',
      'Url' => '',
      'Script' => '{evalResult}',
      'Eval' => 'return $GLOBALS[\'oTopMenu\']->getScriptFaveAdd({ID}, {member_id});',
      'bDisplayInSubMenuHeader' => '0',
    ),
    4 => 
    array (
      'Caption' => '{cpt_remove_fave}',
      'Icon' => 'asterisk',
      'Url' => '',
      'Script' => '{evalResult}',
      'Eval' => 'return $GLOBALS[\'oTopMenu\']->getScriptFaveCancel({ID}, {member_id});',
      'bDisplayInSubMenuHeader' => '0',
    ),
    5 => 
    array (
      'Caption' => '{cpt_befriend}',
      'Icon' => 'plus',
      'Url' => '',
      'Script' => '{evalResult}',
      'Eval' => 'return $GLOBALS[\'oTopMenu\']->getScriptFriendAdd({ID}, {member_id});',
      'bDisplayInSubMenuHeader' => '0',
    ),
    6 => 
    array (
      'Caption' => '{cpt_remove_friend}',
      'Icon' => 'minus',
      'Url' => '',
      'Script' => '{evalResult}',
      'Eval' => 'return $GLOBALS[\'oTopMenu\']->getScriptFriendCancel({ID}, {member_id}, false);',
      'bDisplayInSubMenuHeader' => '0',
    ),
    7 => 
    array (
      'Caption' => '{cpt_greet}',
      'Icon' => 'hand-right',
      'Url' => '',
      'Script' => '{evalResult}',
      'Eval' => 'if ({ID} == {member_id}) return;

return "$.post(\'greet.php\', { sendto: \'{ID}\' }, function(sData){ $(\'#ajaxy_popup_result_div_{ID}\').html(sData) } );return false;";
',
      'bDisplayInSubMenuHeader' => '0',
    ),
    8 => 
    array (
      'Caption' => '{cpt_get_mail}',
      'Icon' => 'envelope-alt',
      'Url' => '',
      'Script' => '{evalResult}',
      'Eval' => 'if ({ID} == {member_id}) return;

$bAnonymousMode  = \'{anonym_mode}\';

if ( !$bAnonymousMode ) {
    return "$.post(\'freemail.php\', { ID: \'{ID}\' }, function(sData){ $(\'#ajaxy_popup_result_div_{ID}\').html(sData) } );return false;";
}
',
      'bDisplayInSubMenuHeader' => '0',
    ),
    9 => 
    array (
      'Caption' => '{cpt_share}',
      'Icon' => 'share',
      'Url' => '',
      'Script' => 'return launchTellFriendProfile({ID});',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    10 => 
    array (
      'Caption' => '{cpt_report}',
      'Icon' => 'exclamation-sign',
      'Url' => '',
      'Script' => '{evalResult}',
      'Eval' => 'if ({ID} == {member_id}) return;

return  "$.post(\'list_pop.php?action=spam\', { ID: \'{ID}\' }, function(sData){ $(\'#ajaxy_popup_result_div_{ID}\').html(sData) } );return false;";
',
      'bDisplayInSubMenuHeader' => '0',
    ),
    11 => 
    array (
      'Caption' => '{cpt_block}',
      'Icon' => 'ban-circle',
      'Url' => '',
      'Script' => '{evalResult}',
      'Eval' => 'if ( {ID} == {member_id} || isBlocked({member_id}, {ID}) ) return;

return  "$.post(\'list_pop.php?action=block\', { ID: \'{ID}\' }, function(sData){ $(\'#ajaxy_popup_result_div_{ID}\').html(sData) } );return false;";
',
      'bDisplayInSubMenuHeader' => '0',
    ),
    12 => 
    array (
      'Caption' => '{cpt_unblock}',
      'Icon' => 'ban-circle',
      'Url' => '',
      'Script' => '{evalResult}',
      'Eval' => 'if ({ID} == {member_id} || !isBlocked({member_id}, {ID}) ) return;

return "$.post(\'list_pop.php?action=unblock\', { ID: \'{ID}\' }, function(sData){ $(\'#ajaxy_popup_result_div_{ID}\').html(sData) } );return false;";
',
      'bDisplayInSubMenuHeader' => '0',
    ),
    13 => 
    array (
      'Caption' => '{sbs_profile_title}',
      'Icon' => 'paper-clip',
      'Url' => '',
      'Script' => '{sbs_profile_script}',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    14 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'comments-alt',
      'Url' => '',
      'Script' => 'window.open( \'modules/boonex/messenger/popup.php?rspId={ID}\' , \'Messenger\', \'width=550,height=500,toolbar=0,directories=0,menubar=0,status=0,location=0,scrollbars=0,resizable=1\', 0);',
      'Eval' => 'return BxDolService::call(\'messenger\', \'get_action_link\', array({member_id}, {ID}));',
      'bDisplayInSubMenuHeader' => '0',
    ),
    15 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'magic',
      'Url' => '',
      'Script' => '$(\'#profile_customize_page\').fadeIn(\'slow\', function() {dbTopMenuLoad(\'profile_customizer\');});',
      'Eval' => 'if (defined(\'BX_PROFILE_PAGE\') && {ID} == {member_id} && getParam(\'bx_profile_customize_enable\') == \'on\') return _t( \'_Customize\' ); else return null;',
      'bDisplayInSubMenuHeader' => '0',
    ),
  ),
  'ProfileTitle' => 
  array (
    0 => 
    array (
      'Caption' => '{cpt_am_friend_add}',
      'Icon' => 'plus',
      'Url' => '',
      'Script' => '{evalResult}',
      'Eval' => 'return $GLOBALS[\'oTopMenu\']->getScriptFriendAdd({ID}, {member_id}, false);',
      'bDisplayInSubMenuHeader' => '1',
    ),
    1 => 
    array (
      'Caption' => '{cpt_am_friend_accept}',
      'Icon' => 'plus',
      'Url' => '',
      'Script' => '{evalResult}',
      'Eval' => 'return $GLOBALS[\'oTopMenu\']->getScriptFriendAccept({ID}, {member_id}, false);',
      'bDisplayInSubMenuHeader' => '1',
    ),
    2 => 
    array (
      'Caption' => '{cpt_am_friend_cancel}',
      'Icon' => 'minus',
      'Url' => '',
      'Script' => '{evalResult}',
      'Eval' => 'return $GLOBALS[\'oTopMenu\']->getScriptFriendCancel({ID}, {member_id}, false);',
      'bDisplayInSubMenuHeader' => '1',
    ),
    3 => 
    array (
      'Caption' => '{cpt_am_profile_message}',
      'Icon' => 'envelope',
      'Url' => '{evalResult}',
      'Script' => '',
      'Eval' => 'return $GLOBALS[\'oTopMenu\']->getUrlProfileMessage({ID});',
      'bDisplayInSubMenuHeader' => '1',
    ),
    4 => 
    array (
      'Caption' => '{cpt_am_profile_account_page}',
      'Icon' => 'dashboard',
      'Url' => '{evalResult}',
      'Script' => '',
      'Eval' => 'return $GLOBALS[\'oTopMenu\']->getUrlAccountPage({ID});',
      'bDisplayInSubMenuHeader' => '1',
    ),
  ),
  'AccountTitle' => 
  array (
    0 => 
    array (
      'Caption' => '{cpt_am_account_profile_page}',
      'Icon' => 'user',
      'Url' => '{evalResult}',
      'Script' => '',
      'Eval' => 'return $GLOBALS[\'oTopMenu\']->getUrlProfilePage({ID});',
      'bDisplayInSubMenuHeader' => '1',
    ),
  ),
  'bx_blogs' => 
  array (
    0 => 
    array (
      'Caption' => '_Add Post',
      'Icon' => 'plus',
      'Url' => '{evalResult}',
      'Script' => '',
      'Eval' => 'if ({only_menu} == 1)
    return (getParam(\'permalinks_blogs\') == \'on\') ? \'blogs/my_page/add/\' : \'modules/boonex/blogs/blogs.php?action=my_page&mode=add\';
else
    return null;',
      'bDisplayInSubMenuHeader' => '1',
    ),
    1 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'book',
      'Url' => '{blog_owner_link}',
      'Script' => '',
      'Eval' => 'if ({only_menu} == 1)
return _t(\'_bx_blog_My_blog\');
else
return null;',
      'bDisplayInSubMenuHeader' => '1',
    ),
    2 => 
    array (
      'Caption' => '_bx_blog_Blogs_Home',
      'Icon' => 'book',
      'Url' => '{evalResult}',
      'Script' => '',
      'Eval' => 'if ({only_menu} == 1)
    return (getParam(\'permalinks_blogs\') == \'on\') ? \'blogs/home/\' : \'modules/boonex/blogs/blogs.php?action=home\';
else
    return null;',
      'bDisplayInSubMenuHeader' => '0',
    ),
    3 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'star-empty',
      'Url' => '{post_entry_url}&do=cfs&id={post_id}',
      'Script' => '',
      'Eval' => '$iPostFeature = (int)\'{post_featured}\';
if (({visitor_id}=={owner_id} && {owner_id}>0) || {admin_mode} == true) {
return ($iPostFeature==1) ? _t(\'_De-Feature it\') : _t(\'_Feature it\');
}
else
return null;',
      'bDisplayInSubMenuHeader' => '0',
    ),
    4 => 
    array (
      'Caption' => '_Edit',
      'Icon' => 'edit',
      'Url' => '{evalResult}',
      'Script' => '',
      'Eval' => 'if (({visitor_id}=={owner_id} && {owner_id}>0) || {admin_mode} == true || {edit_allowed}) {
    return (getParam(\'permalinks_blogs\') == \'on\') ? \'blogs/my_page/edit/{post_id}\' : \'modules/boonex/blogs/blogs.php?action=edit_post&EditPostID={post_id}\';
}
else
    return null;',
      'bDisplayInSubMenuHeader' => '0',
    ),
    5 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'remove',
      'Url' => '',
      'Script' => 'iDelPostID = {post_id}; sWorkUrl = \'{work_url}\'; if (confirm(\'{sure_label}\')) { window.open (sWorkUrl+\'?action=delete_post&DeletePostID=\'+iDelPostID,\'_self\'); }',
      'Eval' => '$oModule = BxDolModule::getInstance(\'BxBlogsModule\');
 if (({visitor_id}=={owner_id} && {owner_id}>0) || {admin_mode} == true || $oModule->isAllowedPostDelete({owner_id})) {
return _t(\'_Delete\');
}
else
return null;',
      'bDisplayInSubMenuHeader' => '0',
    ),
    6 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'ok-circle',
      'Url' => '{post_inside_entry_url}&sa={sSAAction}',
      'Script' => '',
      'Eval' => '$sButAct = \'{sSACaption}\';
if ({admin_mode} == true || {allow_approve}) {
return $sButAct;
}
else
return null;',
      'bDisplayInSubMenuHeader' => '0',
    ),
    7 => 
    array (
      'Caption' => '{sbs_blogs_title}',
      'Icon' => 'paper-clip',
      'Url' => '',
      'Script' => '{sbs_blogs_script}',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    8 => 
    array (
      'Caption' => '{TitleShare}',
      'Icon' => 'share',
      'Url' => '',
      'Script' => 'showPopupAnyHtml(\'{base_url}blogs.php?action=share_post&post_id={post_id}\');',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    9 => 
    array (
      'Caption' => '_bx_blog_Back_to_Blog',
      'Icon' => 'book',
      'Url' => '{evalResult}',
      'Script' => '',
      'Eval' => 'return \'{blog_owner_link}\';
',
      'bDisplayInSubMenuHeader' => '0',
    ),
  ),
  'bx_groups_title' => 
  array (
    0 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'plus',
      'Url' => '{BaseUri}browse/my&bx_groups_filter=add_group',
      'Script' => '',
      'Eval' => 'return ($GLOBALS[\'logged\'][\'member\'] && BxDolModule::getInstance(\'BxGroupsModule\')->isAllowedAdd()) || $GLOBALS[\'logged\'][\'admin\'] ? _t(\'_bx_groups_action_add_group\') : \'\';',
      'bDisplayInSubMenuHeader' => '0',
    ),
    1 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'group',
      'Url' => '{BaseUri}browse/my',
      'Script' => '',
      'Eval' => 'return $GLOBALS[\'logged\'][\'member\'] || $GLOBALS[\'logged\'][\'admin\'] ? _t(\'_bx_groups_action_my_groups\') : \'\';',
      'bDisplayInSubMenuHeader' => '0',
    ),
  ),
  'bx_groups' => 
  array (
    0 => 
    array (
      'Caption' => '{TitleEdit}',
      'Icon' => 'edit',
      'Url' => '{evalResult}',
      'Script' => '',
      'Eval' => '$oConfig = $GLOBALS[\'oBxGroupsModule\']->_oConfig; return  BX_DOL_URL_ROOT . $oConfig->getBaseUri() . \'edit/{ID}\';',
      'bDisplayInSubMenuHeader' => '0',
    ),
    1 => 
    array (
      'Caption' => '{TitleDelete}',
      'Icon' => 'remove',
      'Url' => '',
      'Script' => 'getHtmlData( \'ajaxy_popup_result_div_{ID}\', \'{evalResult}\', false, \'post\', true); return false;',
      'Eval' => '$oConfig = $GLOBALS[\'oBxGroupsModule\']->_oConfig; return  BX_DOL_URL_ROOT . $oConfig->getBaseUri() . \'delete/{ID}\';',
      'bDisplayInSubMenuHeader' => '0',
    ),
    2 => 
    array (
      'Caption' => '{TitleShare}',
      'Icon' => 'share',
      'Url' => '',
      'Script' => 'showPopupAnyHtml (\'{BaseUri}share_popup/{ID}\');',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    3 => 
    array (
      'Caption' => '{TitleBroadcast}',
      'Icon' => 'envelope',
      'Url' => '{BaseUri}broadcast/{ID}',
      'Script' => '',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    4 => 
    array (
      'Caption' => '{TitleJoin}',
      'Icon' => '{IconJoin}',
      'Url' => '',
      'Script' => 'getHtmlData( \'ajaxy_popup_result_div_{ID}\', \'{evalResult}\', false, \'post\');return false;',
      'Eval' => '$oConfig = $GLOBALS[\'oBxGroupsModule\']->_oConfig; return BX_DOL_URL_ROOT . $oConfig->getBaseUri() . \'join/{ID}/{iViewer}\';',
      'bDisplayInSubMenuHeader' => '0',
    ),
    5 => 
    array (
      'Caption' => '{TitleInvite}',
      'Icon' => 'plus-sign',
      'Url' => '{evalResult}',
      'Script' => '',
      'Eval' => '$oConfig = $GLOBALS[\'oBxGroupsModule\']->_oConfig; return BX_DOL_URL_ROOT . $oConfig->getBaseUri() . \'invite/{ID}\';',
      'bDisplayInSubMenuHeader' => '0',
    ),
    6 => 
    array (
      'Caption' => '{AddToFeatured}',
      'Icon' => 'star-empty',
      'Url' => '',
      'Script' => 'getHtmlData( \'ajaxy_popup_result_div_{ID}\', \'{evalResult}\', false, \'post\');return false;',
      'Eval' => '$oConfig = $GLOBALS[\'oBxGroupsModule\']->_oConfig; return BX_DOL_URL_ROOT . $oConfig->getBaseUri() . \'mark_featured/{ID}\';',
      'bDisplayInSubMenuHeader' => '0',
    ),
    7 => 
    array (
      'Caption' => '{TitleManageFans}',
      'Icon' => 'group',
      'Url' => '',
      'Script' => 'showPopupAnyHtml (\'{BaseUri}manage_fans_popup/{ID}\');',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    8 => 
    array (
      'Caption' => '{TitleUploadPhotos}',
      'Icon' => 'picture',
      'Url' => '{BaseUri}upload_photos/{URI}',
      'Script' => '',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    9 => 
    array (
      'Caption' => '{TitleUploadVideos}',
      'Icon' => 'film',
      'Url' => '{BaseUri}upload_videos/{URI}',
      'Script' => '',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    10 => 
    array (
      'Caption' => '{TitleUploadSounds}',
      'Icon' => 'music',
      'Url' => '{BaseUri}upload_sounds/{URI}',
      'Script' => '',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    11 => 
    array (
      'Caption' => '{TitleUploadFiles}',
      'Icon' => 'save',
      'Url' => '{BaseUri}upload_files/{URI}',
      'Script' => '',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    12 => 
    array (
      'Caption' => '{TitleSubscribe}',
      'Icon' => 'paper-clip',
      'Url' => '',
      'Script' => '{ScriptSubscribe}',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
  ),
  'bx_events_title' => 
  array (
    0 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'plus',
      'Url' => '{BaseUri}browse/my&bx_events_filter=add_event',
      'Script' => '',
      'Eval' => 'return ($GLOBALS[\'logged\'][\'member\'] && BxDolModule::getInstance(\'BxEventsModule\')->isAllowedAdd()) || $GLOBALS[\'logged\'][\'admin\'] ? _t(\'_bx_events_action_create_event\') : \'\';',
      'bDisplayInSubMenuHeader' => '0',
    ),
    1 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'calendar',
      'Url' => '{BaseUri}browse/my',
      'Script' => '',
      'Eval' => 'return $GLOBALS[\'logged\'][\'member\'] || $GLOBALS[\'logged\'][\'admin\'] ? _t(\'_bx_events_action_my_events\') : \'\';',
      'bDisplayInSubMenuHeader' => '0',
    ),
  ),
  'bx_events' => 
  array (
    0 => 
    array (
      'Caption' => '{TitleEdit}',
      'Icon' => 'edit',
      'Url' => '{evalResult}',
      'Script' => '',
      'Eval' => '$oConfig = $GLOBALS[\'oBxEventsModule\']->_oConfig; return  BX_DOL_URL_ROOT . $oConfig->getBaseUri() . \'edit/{ID}\';',
      'bDisplayInSubMenuHeader' => '0',
    ),
    1 => 
    array (
      'Caption' => '{TitleDelete}',
      'Icon' => 'remove',
      'Url' => '',
      'Script' => 'getHtmlData( \'ajaxy_popup_result_div_{ID}\', \'{evalResult}\', false, \'post\', true); return false;',
      'Eval' => '$oConfig = $GLOBALS[\'oBxEventsModule\']->_oConfig; return  BX_DOL_URL_ROOT . $oConfig->getBaseUri() . \'delete/{ID}\';',
      'bDisplayInSubMenuHeader' => '0',
    ),
    2 => 
    array (
      'Caption' => '{TitleJoin}',
      'Icon' => '{IconJoin}',
      'Url' => '',
      'Script' => 'getHtmlData( \'ajaxy_popup_result_div_{ID}\', \'{evalResult}\', false, \'post\');return false;',
      'Eval' => '$oConfig = $GLOBALS[\'oBxEventsModule\']->_oConfig; return BX_DOL_URL_ROOT . $oConfig->getBaseUri() . \'join/{ID}/{iViewer}\';',
      'bDisplayInSubMenuHeader' => '0',
    ),
    3 => 
    array (
      'Caption' => '{TitleInvite}',
      'Icon' => 'plus-sign',
      'Url' => '{evalResult}',
      'Script' => '',
      'Eval' => '$oConfig = $GLOBALS[\'oBxEventsModule\']->_oConfig; return BX_DOL_URL_ROOT . $oConfig->getBaseUri() . \'invite/{ID}\';',
      'bDisplayInSubMenuHeader' => '0',
    ),
    4 => 
    array (
      'Caption' => '{TitleShare}',
      'Icon' => 'share',
      'Url' => '',
      'Script' => 'showPopupAnyHtml (\'{BaseUri}share_popup/{ID}\');',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    5 => 
    array (
      'Caption' => '{TitleBroadcast}',
      'Icon' => 'envelope',
      'Url' => '{BaseUri}broadcast/{ID}',
      'Script' => '',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    6 => 
    array (
      'Caption' => '{AddToFeatured}',
      'Icon' => 'star-empty',
      'Url' => '',
      'Script' => 'getHtmlData( \'ajaxy_popup_result_div_{ID}\', \'{evalResult}\', false, \'post\');return false;',
      'Eval' => '$oConfig = $GLOBALS[\'oBxEventsModule\']->_oConfig; return BX_DOL_URL_ROOT . $oConfig->getBaseUri() . \'mark_featured/{ID}\';',
      'bDisplayInSubMenuHeader' => '0',
    ),
    7 => 
    array (
      'Caption' => '{TitleManageFans}',
      'Icon' => 'group',
      'Url' => '',
      'Script' => 'showPopupAnyHtml (\'{BaseUri}manage_fans_popup/{ID}\');',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    8 => 
    array (
      'Caption' => '{TitleSubscribe}',
      'Icon' => 'paper-clip',
      'Url' => '',
      'Script' => '{ScriptSubscribe}',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    9 => 
    array (
      'Caption' => '{TitleUploadPhotos}',
      'Icon' => 'picture',
      'Url' => '{BaseUri}upload_photos/{URI}',
      'Script' => '',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    10 => 
    array (
      'Caption' => '{TitleUploadVideos}',
      'Icon' => 'film',
      'Url' => '{BaseUri}upload_videos/{URI}',
      'Script' => '',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    11 => 
    array (
      'Caption' => '{TitleUploadSounds}',
      'Icon' => 'music',
      'Url' => '{BaseUri}upload_sounds/{URI}',
      'Script' => '',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    12 => 
    array (
      'Caption' => '{TitleUploadFiles}',
      'Icon' => 'save',
      'Url' => '{BaseUri}upload_files/{URI}',
      'Script' => '',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
  ),
  'bx_photos' => 
  array (
    0 => 
    array (
      'Caption' => '_bx_photos_action_view_original',
      'Icon' => 'download-alt',
      'Url' => '',
      'Script' => 'window.open(\'{moduleUrl}get_image/original/{fileKey}.{fileExt}\')',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    1 => 
    array (
      'Caption' => '{shareCpt}',
      'Icon' => 'share',
      'Url' => '',
      'Script' => 'showPopupAnyHtml(\'{moduleUrl}share/{fileUri}\')',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    2 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'exclamation-sign',
      'Url' => '',
      'Script' => 'showPopupAnyHtml(\'{moduleUrl}report/{fileUri}\')',
      'Eval' => 'if ({iViewer}!=0)
return _t(\'_bx_photos_action_report\');
else
return null;',
      'bDisplayInSubMenuHeader' => '0',
    ),
    3 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'asterisk',
      'Url' => '',
      'Script' => 'getHtmlData(\'ajaxy_popup_result_div_{ID}\', \'{moduleUrl}favorite/{ID}\', false, \'post\'); return false;',
      'Eval' => 'if ({iViewer}==0)
return false;
$sMessage = \'{favorited}\'==\'\' ? \'fave\':\'unfave\';
return _t(\'_bx_photos_action_\' . $sMessage); ',
      'bDisplayInSubMenuHeader' => '0',
    ),
    4 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'edit',
      'Url' => '',
      'Script' => 'oBxDolFiles.edit({ID})',
      'Eval' => '$sTitle = _t(\'_Edit\');
if ({Owner} == {iViewer})
return $sTitle;
$mixedCheck = BxDolService::call(\'photos\', \'check_action\', array(\'edit\',\'{ID}\'));
if ($mixedCheck !== false)
return $sTitle;
else
 return null;',
      'bDisplayInSubMenuHeader' => '0',
    ),
    5 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'remove',
      'Url' => '',
      'Script' => 'getHtmlData(\'ajaxy_popup_result_div_{ID}\', \'{moduleUrl}delete/{ID}/{AlbumUri}/{OwnerName}\', false, \'post\', true); return false;',
      'Eval' => '$sTitle = _t(\'_Delete\');
if ({Owner} == {iViewer})
return $sTitle;
$mixedCheck = BxDolService::call(\'photos\', \'check_delete\', array({ID}));
if ($mixedCheck !== false)
return $sTitle;
else
return null;',
      'bDisplayInSubMenuHeader' => '0',
    ),
    6 => 
    array (
      'Caption' => '{featuredCpt}',
      'Icon' => 'star-empty',
      'Url' => '',
      'Script' => 'getHtmlData(\'ajaxy_popup_result_div_{ID}\', \'{moduleUrl}feature/{ID}/{featured}\', false, \'post\'); return false;',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    7 => 
    array (
      'Caption' => '{sbs_bx_photos_title}',
      'Icon' => 'paper-clip',
      'Url' => '',
      'Script' => '{sbs_bx_photos_script}',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
  ),
  'bx_photos_title' => 
  array (
    0 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'plus',
      'Url' => '',
      'Script' => 'showPopupAnyHtml(\'{BaseUri}upload\');',
      'Eval' => 'return (getLoggedId() && BxDolModule::getInstance(\'BxPhotosModule\')->isAllowedAdd()) ? _t(\'_sys_upload\') : \'\';',
      'bDisplayInSubMenuHeader' => '0',
    ),
    1 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'picture',
      'Url' => '{BaseUri}albums/my/main/',
      'Script' => '',
      'Eval' => 'return $GLOBALS[\'logged\'][\'member\'] || $GLOBALS[\'logged\'][\'admin\'] ? _t(\'_bx_photos_albums_my\') : \'\';',
      'bDisplayInSubMenuHeader' => '0',
    ),
  ),
  'Mailbox' => 
  array (
    0 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'plus',
      'Url' => '{BaseUri}mail.php?mode=compose',
      'Script' => '',
      'Eval' => 'return $GLOBALS[\'logged\'][\'member\'] || $GLOBALS[\'logged\'][\'admin\'] ? _t(\'_sys_am_mailbox_compose\') : \'\';',
      'bDisplayInSubMenuHeader' => '1',
    ),
  ),
  'bx_blogs_m' => 
  array (
    0 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'rss',
      'Url' => '{site_url}rss_factory.php?action=blogs&pid={owner_id}',
      'Script' => '',
      'Eval' => 'return _t(\'_bx_blog_RSS\');',
      'bDisplayInSubMenuHeader' => '0',
    ),
    1 => 
    array (
      'Caption' => '_bx_blog_Back_to_Blog',
      'Icon' => 'book',
      'Url' => '{blog_owner_link}',
      'Script' => '',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    2 => 
    array (
      'Caption' => '_Add Post',
      'Icon' => 'plus',
      'Url' => '{evalResult}',
      'Script' => '',
      'Eval' => 'if (({visitor_id}=={owner_id} && {owner_id}>0) || {admin_mode}==true)
return (getParam(\'permalinks_blogs\') == \'on\') ? \'blogs/my_page/add/\' : \'modules/boonex/blogs/blogs.php?action=my_page&mode=add\';
else
return null;',
      'bDisplayInSubMenuHeader' => '1',
    ),
    3 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'edit',
      'Url' => '',
      'Script' => 'PushEditAtBlogOverview(\'{blog_id}\', \'{blog_description_js}\', \'{owner_id}\');',
      'Eval' => 'if (({visitor_id}=={owner_id} && {owner_id}>0) || {admin_mode}==true)
return _t(\'_bx_blog_Edit_blog\');
else
return null;',
      'bDisplayInSubMenuHeader' => '1',
    ),
    4 => 
    array (
      'Caption' => '{evalResult}',
      'Icon' => 'remove',
      'Url' => '',
      'Script' => 'if (confirm(\'{sure_label}\')) window.open (\'{work_url}?action=delete_blog&DeleteBlogID={blog_id}\',\'_self\');',
      'Eval' => 'if (({visitor_id}=={owner_id} && {owner_id}>0) || {admin_mode}==true)
return _t(\'_bx_blog_Delete_blog\');
else
return null;',
      'bDisplayInSubMenuHeader' => '0',
    ),
  ),
  'bx_feedback' => 
  array (
    0 => 
    array (
      'Caption' => '{sbs_feedback_title}',
      'Icon' => 'paper-clip',
      'Url' => '',
      'Script' => '{sbs_feedback_script}',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
    1 => 
    array (
      'Caption' => '{del_feedback_title}',
      'Icon' => 'remove',
      'Url' => '',
      'Script' => '{del_feedback_script}',
      'Eval' => '',
      'bDisplayInSubMenuHeader' => '0',
    ),
  ),
); ?>