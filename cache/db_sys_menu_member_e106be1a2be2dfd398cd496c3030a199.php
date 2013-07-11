<?php $mixedData=array (
  'top_extra' => 
  array (
    2 => 
    array (
      'ID' => '2',
      'Caption' => '_Mail',
      'Name' => 'Mail',
      'Icon' => 'envelope',
      'Link' => 'mail.php?mode=inbox',
      'Script' => '',
      'Eval' => '',
      'PopupMenu' => 'bx_import( \'BxTemplMailBox\' );
// return list of messages ;
return BxTemplMailBox::get_member_menu_messages_list({ID});',
      'Order' => '0',
      'Active' => '1',
      'Movable' => '3',
      'Clonable' => '1',
      'Editable' => '0',
      'Deletable' => '0',
      'Target' => '',
      'Position' => 'top_extra',
      'Type' => 'link',
      'Parent' => '0',
      'Bubble' => 'bx_import( \'BxTemplMailBox\' );
// return list of new messages ;
$aRetEval= BxTemplMailBox::get_member_menu_bubble_new_messages({ID}, {iOldCount});',
      'Description' => '_Mail',
      'linked_items' => 
      array (
      ),
    ),
    3 => 
    array (
      'ID' => '3',
      'Caption' => '_Friends',
      'Name' => 'Friends',
      'Icon' => 'user',
      'Link' => 'viewFriends.php?iUser={ID}',
      'Script' => '',
      'Eval' => '',
      'PopupMenu' => 'bx_import( \'BxDolFriendsPageView\' );
return BxDolFriendsPageView::get_member_menu_friends_list({ID});',
      'Order' => '1',
      'Active' => '1',
      'Movable' => '3',
      'Clonable' => '1',
      'Editable' => '0',
      'Deletable' => '0',
      'Target' => '',
      'Position' => 'top_extra',
      'Type' => 'link',
      'Parent' => '0',
      'Bubble' => 'bx_import( \'BxDolFriendsPageView\' );
$aRetEval = BxDolFriendsPageView::get_member_menu_bubble_friend_requests( {ID}, {iOldCount});',
      'Description' => '_Friends',
      'linked_items' => 
      array (
      ),
    ),
    10 => 
    array (
      'ID' => '10',
      'Caption' => '_Admin Panel',
      'Name' => 'Admin Panel',
      'Icon' => 'wrench',
      'Link' => '{evalResult}',
      'Script' => '',
      'Eval' => 'return isAdmin() ? $GLOBALS[\'site\'][\'url_admin\'] : \'\';',
      'PopupMenu' => '',
      'Order' => '2',
      'Active' => '1',
      'Movable' => '3',
      'Clonable' => '1',
      'Editable' => '1',
      'Deletable' => '1',
      'Target' => '',
      'Position' => 'top_extra',
      'Type' => 'link',
      'Parent' => '0',
      'Bubble' => '',
      'Description' => '_Go admin panel',
      'linked_items' => 
      array (
      ),
    ),
  ),
  'top' => 
  array (
    6 => 
    array (
      'ID' => '6',
      'Caption' => '{evalResult}',
      'Name' => 'MemberBlock',
      'Icon' => '',
      'Link' => '{ProfileLink}',
      'Script' => '',
      'Eval' => 'return \'<b>\' . getNickName({ID}) . \'</b>\';',
      'PopupMenu' => 'bx_import(\'BxDolUserStatusView\');
$oStatusView = new BxDolUserStatusView();
return $oStatusView->getMemberMenuStatuses();',
      'Order' => '1',
      'Active' => '1',
      'Movable' => '3',
      'Clonable' => '1',
      'Editable' => '0',
      'Deletable' => '0',
      'Target' => '',
      'Position' => 'top',
      'Type' => 'link',
      'Parent' => '0',
      'Bubble' => '',
      'Description' => '_Presence',
      'linked_items' => 
      array (
      ),
    ),
    4 => 
    array (
      'ID' => '4',
      'Caption' => '_Settings',
      'Name' => 'Settings',
      'Icon' => 'cog',
      'Link' => 'pedit.php?ID={ID}',
      'Script' => '',
      'Eval' => '',
      'PopupMenu' => '',
      'Order' => '2',
      'Active' => '1',
      'Movable' => '3',
      'Clonable' => '1',
      'Editable' => '0',
      'Deletable' => '0',
      'Target' => '',
      'Position' => 'top',
      'Type' => 'link',
      'Parent' => '0',
      'Bubble' => '',
      'Description' => '_Edit_profile_and_settings',
      'linked_items' => 
      array (
      ),
    ),
    12 => 
    array (
      'ID' => '12',
      'Caption' => '',
      'Name' => 'bx_blogs',
      'Icon' => '',
      'Link' => '',
      'Script' => '',
      'Eval' => 'return BxDolService::call(\'blogs\', \'get_member_menu_item_add_content\');',
      'PopupMenu' => '',
      'Order' => '2',
      'Active' => '1',
      'Movable' => '3',
      'Clonable' => '1',
      'Editable' => '1',
      'Deletable' => '1',
      'Target' => '',
      'Position' => 'top',
      'Type' => 'linked_item',
      'Parent' => '8',
      'Bubble' => '',
      'Description' => '',
      'linked_items' => 
      array (
      ),
    ),
    7 => 
    array (
      'ID' => '7',
      'Caption' => '_Status Message',
      'Name' => 'Status Message',
      'Icon' => 'edit',
      'Link' => 'javascript:void(0);',
      'Script' => '',
      'Eval' => '',
      'PopupMenu' => 'bx_import( \'BxDolUserStatusView\' );
$oStatusView = new BxDolUserStatusView();
return $oStatusView -> getStatusField({ID});',
      'Order' => '3',
      'Active' => '1',
      'Movable' => '3',
      'Clonable' => '1',
      'Editable' => '1',
      'Deletable' => '1',
      'Target' => '',
      'Position' => 'top',
      'Type' => 'link',
      'Parent' => '0',
      'Bubble' => '',
      'Description' => '_Status Message',
      'linked_items' => 
      array (
      ),
    ),
    13 => 
    array (
      'ID' => '13',
      'Caption' => '',
      'Name' => 'bx_events',
      'Icon' => '',
      'Link' => '',
      'Script' => '',
      'Eval' => 'return BxDolService::call(\'events\', \'get_member_menu_item_add_content\');',
      'PopupMenu' => '',
      'Order' => '3',
      'Active' => '1',
      'Movable' => '3',
      'Clonable' => '1',
      'Editable' => '1',
      'Deletable' => '1',
      'Target' => '',
      'Position' => 'top',
      'Type' => 'linked_item',
      'Parent' => '8',
      'Bubble' => '',
      'Description' => '',
      'linked_items' => 
      array (
      ),
    ),
    8 => 
    array (
      'ID' => '8',
      'Caption' => '_sys_add_content',
      'Name' => 'AddContent',
      'Icon' => 'plus',
      'Link' => 'javascript:void(0);',
      'Script' => '',
      'Eval' => '',
      'PopupMenu' => 'return \'\';',
      'Order' => '4',
      'Active' => '1',
      'Movable' => '3',
      'Clonable' => '0',
      'Editable' => '0',
      'Deletable' => '0',
      'Target' => '',
      'Position' => 'top',
      'Type' => 'link',
      'Parent' => '0',
      'Bubble' => '$isSkipItem = $aReplaced[$sPosition][$iKey][\'linked_items\'] ? false : true;
$aRetEval = false;',
      'Description' => '_sys_add_content',
      'linked_items' => 
      array (
        0 => 
        array (
          'code' => 'return BxDolService::call(\'blogs\', \'get_member_menu_item_add_content\');',
        ),
        1 => 
        array (
          'code' => 'return BxDolService::call(\'events\', \'get_member_menu_item_add_content\');',
        ),
        2 => 
        array (
          'code' => '$oMemberMenu = bx_instance(\'BxDolMemberMenu\'); $a = array(\'item_img_src\' => \'comments\', \'item_link\' => BX_DOL_URL_ROOT . \'forum/#action=goto&new_topic=0\', \'item_title\' => _t(\'_bx_forum_forum_topic\')); return $oMemberMenu->getGetExtraMenuLink($a);',
        ),
        3 => 
        array (
          'code' => 'return BxDolService::call(\'groups\', \'get_member_menu_item_add_content\');',
        ),
        4 => 
        array (
          'code' => 'return BxDolService::call(\'photos\', \'get_member_menu_item_add_content\');',
        ),
      ),
    ),
    16 => 
    array (
      'ID' => '16',
      'Caption' => '',
      'Name' => 'bx_groups',
      'Icon' => '',
      'Link' => '',
      'Script' => '',
      'Eval' => 'return BxDolService::call(\'groups\', \'get_member_menu_item_add_content\');',
      'PopupMenu' => '',
      'Order' => '6',
      'Active' => '1',
      'Movable' => '3',
      'Clonable' => '1',
      'Editable' => '1',
      'Deletable' => '1',
      'Target' => '',
      'Position' => 'top',
      'Type' => 'linked_item',
      'Parent' => '8',
      'Bubble' => '',
      'Description' => '',
      'linked_items' => 
      array (
      ),
    ),
    18 => 
    array (
      'ID' => '18',
      'Caption' => '',
      'Name' => 'bx_photos',
      'Icon' => '',
      'Link' => '',
      'Script' => '',
      'Eval' => 'return BxDolService::call(\'photos\', \'get_member_menu_item_add_content\');',
      'PopupMenu' => '',
      'Order' => '7',
      'Active' => '1',
      'Movable' => '3',
      'Clonable' => '1',
      'Editable' => '1',
      'Deletable' => '1',
      'Target' => '',
      'Position' => 'top',
      'Type' => 'linked_item',
      'Parent' => '8',
      'Bubble' => '',
      'Description' => '',
      'linked_items' => 
      array (
      ),
    ),
    25 => 
    array (
      'ID' => '25',
      'Caption' => '',
      'Name' => 'bx_forum',
      'Icon' => '',
      'Link' => '',
      'Script' => '',
      'Eval' => '$oMemberMenu = bx_instance(\'BxDolMemberMenu\'); $a = array(\'item_img_src\' => \'comments\', \'item_link\' => BX_DOL_URL_ROOT . \'forum/#action=goto&new_topic=0\', \'item_title\' => _t(\'_bx_forum_forum_topic\')); return $oMemberMenu->getGetExtraMenuLink($a);',
      'PopupMenu' => '',
      'Order' => '8',
      'Active' => '1',
      'Movable' => '3',
      'Clonable' => '1',
      'Editable' => '1',
      'Deletable' => '1',
      'Target' => '',
      'Position' => 'top',
      'Type' => 'linked_item',
      'Parent' => '8',
      'Bubble' => '',
      'Description' => '',
      'linked_items' => 
      array (
      ),
    ),
  ),
); ?>