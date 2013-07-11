<?php $mixedData=array (
  'top_extra' => 
  array (
    0 => 
    array (
      'menu_caption' => NULL,
      'menu_link' => 'javascript:void(0)',
      'extended_action' => NULL,
      'target' => NULL,
      'menu_image' => '<i class="sys-icon envelope" alt="" ></i>',
      'bubble_box' => '<div class="bubble" id="bubble_Mail" style="display:none">
    <span class="bubble_count">0</span>
</div>    
',
      'indent' => 'menu_item_bottom',
      'item_link_indent' => 'bottom_indent',
      'menu_id' => '2',
      'bx_if:menu_desc' => 
      array (
        'condition' => '_Mail',
        'content' => 
        array (
          'menu_id' => '2',
          'desc_window' => '<table class="description bx-def-padding-sec bx-def-round-corners bx-def-shadow">
    <tr><td>Mail</td></tr>
</table>
',
          'desc_indent' => 'description_bottom',
        ),
      ),
      'bx_if:sub_menu' => 
      array (
        'condition' => 'bx_import( \'BxTemplMailBox\' );
// return list of messages ;
return BxTemplMailBox::get_member_menu_messages_list({ID});',
        'content' => 
        array (
          'menu_id' => '2',
          'bx_if:reduce_element_top' => 
          array (
            'condition' => true,
            'content' => 
            array (
              'menu_id' => '2',
              'item_link' => 'mail.php?mode=inbox',
              'extended_action' => '',
              'cover' => 'top_cover',
              'item_name' => 'Mail',
              'bx_if:part_image' => 
              array (
                'condition' => 'envelope',
                'content' => 
                array (
                  'item_img' => '<i class="sys-icon envelope" alt="Mail" ></i>',
                ),
              ),
            ),
          ),
          'bx_if:reduce_element_bottom' => 
          array (
            'condition' => false,
            'content' => 
            array (
              'menu_id' => '2',
              'item_link' => 'mail.php?mode=inbox',
              'extended_action' => '',
              'cover' => 'bottom_cover',
              'item_name' => 'Mail',
              'bx_if:part_image' => 
              array (
                'condition' => 'envelope',
                'content' => 
                array (
                  'item_img' => '<i class="sys-icon envelope" alt="Mail" ></i>',
                ),
              ),
            ),
          ),
        ),
      ),
    ),
    1 => 
    array (
      'menu_caption' => NULL,
      'menu_link' => 'javascript:void(0)',
      'extended_action' => NULL,
      'target' => NULL,
      'menu_image' => '<i class="sys-icon user" alt="" ></i>',
      'bubble_box' => '<div class="bubble" id="bubble_Friends" style="display:none">
    <span class="bubble_count">0</span>
</div>    
',
      'indent' => 'menu_item_bottom',
      'item_link_indent' => 'bottom_indent',
      'menu_id' => '3',
      'bx_if:menu_desc' => 
      array (
        'condition' => '_Friends',
        'content' => 
        array (
          'menu_id' => '3',
          'desc_window' => '<table class="description bx-def-padding-sec bx-def-round-corners bx-def-shadow">
    <tr><td>Friends</td></tr>
</table>
',
          'desc_indent' => 'description_bottom',
        ),
      ),
      'bx_if:sub_menu' => 
      array (
        'condition' => 'bx_import( \'BxDolFriendsPageView\' );
return BxDolFriendsPageView::get_member_menu_friends_list({ID});',
        'content' => 
        array (
          'menu_id' => '3',
          'bx_if:reduce_element_top' => 
          array (
            'condition' => true,
            'content' => 
            array (
              'menu_id' => '3',
              'item_link' => 'viewFriends.php?iUser=2',
              'extended_action' => '',
              'cover' => 'top_cover',
              'item_name' => 'Friends',
              'bx_if:part_image' => 
              array (
                'condition' => 'user',
                'content' => 
                array (
                  'item_img' => '<i class="sys-icon user" alt="Friends" ></i>',
                ),
              ),
            ),
          ),
          'bx_if:reduce_element_bottom' => 
          array (
            'condition' => false,
            'content' => 
            array (
              'menu_id' => '3',
              'item_link' => 'viewFriends.php?iUser=2',
              'extended_action' => '',
              'cover' => 'bottom_cover',
              'item_name' => 'Friends',
              'bx_if:part_image' => 
              array (
                'condition' => 'user',
                'content' => 
                array (
                  'item_img' => '<i class="sys-icon user" alt="Friends" ></i>',
                ),
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'top' => 
  array (
    0 => 
    array (
      'menu_caption' => '<b>test</b>',
      'menu_link' => 'javascript:void(0)',
      'extended_action' => NULL,
      'target' => NULL,
      'menu_image' => '<i class="sys-icon sign-blank sys-status-online" alt=""  id="current_members_status_img" ></i>',
      'bubble_box' => NULL,
      'indent' => 'menu_item_bottom',
      'item_link_indent' => 'bottom_indent',
      'menu_id' => '6',
      'bx_if:menu_desc' => 
      array (
        'condition' => '_Presence',
        'content' => 
        array (
          'menu_id' => '6',
          'desc_window' => '<table class="description bx-def-padding-sec bx-def-round-corners bx-def-shadow">
    <tr><td>Presence</td></tr>
</table>
',
          'desc_indent' => 'description_bottom',
        ),
      ),
      'bx_if:sub_menu' => 
      array (
        'condition' => 'bx_import(\'BxDolUserStatusView\');
$oStatusView = new BxDolUserStatusView();
return $oStatusView->getMemberMenuStatuses();',
        'content' => 
        array (
          'menu_id' => '6',
          'bx_if:reduce_element_top' => 
          array (
            'condition' => true,
            'content' => 
            array (
              'menu_id' => '6',
              'item_link' => 'http://www.thaipo.org/test',
              'extended_action' => '',
              'cover' => 'top_cover',
              'item_name' => '<b>test</b>',
              'bx_if:part_image' => 
              array (
                'condition' => NULL,
                'content' => 
                array (
                  'item_img' => '',
                ),
              ),
            ),
          ),
          'bx_if:reduce_element_bottom' => 
          array (
            'condition' => false,
            'content' => 
            array (
              'menu_id' => '6',
              'item_link' => 'http://www.thaipo.org/test',
              'extended_action' => '',
              'cover' => 'bottom_cover',
              'item_name' => '<b>test</b>',
              'bx_if:part_image' => 
              array (
                'condition' => NULL,
                'content' => 
                array (
                  'item_img' => '',
                ),
              ),
            ),
          ),
        ),
      ),
    ),
    1 => 
    array (
      'menu_caption' => NULL,
      'menu_link' => 'pedit.php?ID=2',
      'extended_action' => NULL,
      'target' => NULL,
      'menu_image' => '<i class="sys-icon cog" alt="" ></i>',
      'bubble_box' => NULL,
      'indent' => 'menu_item_bottom',
      'item_link_indent' => 'bottom_indent',
      'menu_id' => '4',
      'bx_if:menu_desc' => 
      array (
        'condition' => '_Edit_profile_and_settings',
        'content' => 
        array (
          'menu_id' => '4',
          'desc_window' => '<table class="description bx-def-padding-sec bx-def-round-corners bx-def-shadow">
    <tr><td>Edit profile info and settings</td></tr>
</table>
',
          'desc_indent' => 'description_bottom',
        ),
      ),
      'bx_if:sub_menu' => 
      array (
        'condition' => '',
        'content' => 
        array (
          'menu_id' => '4',
          'bx_if:reduce_element_top' => 
          array (
            'condition' => true,
            'content' => 
            array (
              'menu_id' => '4',
              'item_link' => 'pedit.php?ID=2',
              'extended_action' => '',
              'cover' => 'top_cover',
              'item_name' => 'Settings',
              'bx_if:part_image' => 
              array (
                'condition' => 'cog',
                'content' => 
                array (
                  'item_img' => '<i class="sys-icon cog" alt="Settings" ></i>',
                ),
              ),
            ),
          ),
          'bx_if:reduce_element_bottom' => 
          array (
            'condition' => false,
            'content' => 
            array (
              'menu_id' => '4',
              'item_link' => 'pedit.php?ID=2',
              'extended_action' => '',
              'cover' => 'bottom_cover',
              'item_name' => 'Settings',
              'bx_if:part_image' => 
              array (
                'condition' => 'cog',
                'content' => 
                array (
                  'item_img' => '<i class="sys-icon cog" alt="Settings" ></i>',
                ),
              ),
            ),
          ),
        ),
      ),
    ),
    2 => 
    array (
      'menu_caption' => NULL,
      'menu_link' => 'javascript:void(0)',
      'extended_action' => NULL,
      'target' => NULL,
      'menu_image' => '<i class="sys-icon edit" alt="" ></i>',
      'bubble_box' => NULL,
      'indent' => 'menu_item_bottom',
      'item_link_indent' => 'bottom_indent',
      'menu_id' => '7',
      'bx_if:menu_desc' => 
      array (
        'condition' => '_Status Message',
        'content' => 
        array (
          'menu_id' => '7',
          'desc_window' => '<table class="description bx-def-padding-sec bx-def-round-corners bx-def-shadow">
    <tr><td>Status Message</td></tr>
</table>
',
          'desc_indent' => 'description_bottom',
        ),
      ),
      'bx_if:sub_menu' => 
      array (
        'condition' => 'bx_import( \'BxDolUserStatusView\' );
$oStatusView = new BxDolUserStatusView();
return $oStatusView -> getStatusField({ID});',
        'content' => 
        array (
          'menu_id' => '7',
          'bx_if:reduce_element_top' => 
          array (
            'condition' => true,
            'content' => 
            array (
              'menu_id' => '7',
              'item_link' => 'javascript:void(0);',
              'extended_action' => '',
              'cover' => 'top_cover',
              'item_name' => 'Status Message',
              'bx_if:part_image' => 
              array (
                'condition' => 'edit',
                'content' => 
                array (
                  'item_img' => '<i class="sys-icon edit" alt="Status Message" ></i>',
                ),
              ),
            ),
          ),
          'bx_if:reduce_element_bottom' => 
          array (
            'condition' => false,
            'content' => 
            array (
              'menu_id' => '7',
              'item_link' => 'javascript:void(0);',
              'extended_action' => '',
              'cover' => 'bottom_cover',
              'item_name' => 'Status Message',
              'bx_if:part_image' => 
              array (
                'condition' => 'edit',
                'content' => 
                array (
                  'item_img' => '<i class="sys-icon edit" alt="Status Message" ></i>',
                ),
              ),
            ),
          ),
        ),
      ),
    ),
    3 => 
    array (
      'menu_caption' => NULL,
      'menu_link' => 'javascript:void(0)',
      'extended_action' => NULL,
      'target' => NULL,
      'menu_image' => '<i class="sys-icon plus" alt="" ></i>',
      'bubble_box' => '<div class="bubble" id="bubble_AddContent" style="display:none">
    <span class="bubble_count"></span>
</div>    
',
      'indent' => 'menu_item_bottom',
      'item_link_indent' => 'bottom_indent',
      'menu_id' => '8',
      'bx_if:menu_desc' => 
      array (
        'condition' => '_sys_add_content',
        'content' => 
        array (
          'menu_id' => '8',
          'desc_window' => '<table class="description bx-def-padding-sec bx-def-round-corners bx-def-shadow">
    <tr><td>Add New ...</td></tr>
</table>
',
          'desc_indent' => 'description_bottom',
        ),
      ),
      'bx_if:sub_menu' => 
      array (
        'condition' => 'return \'\';',
        'content' => 
        array (
          'menu_id' => '8',
          'bx_if:reduce_element_top' => 
          array (
            'condition' => true,
            'content' => 
            array (
              'menu_id' => '8',
              'item_link' => 'javascript:void(0);',
              'extended_action' => '',
              'cover' => 'top_cover',
              'item_name' => 'Add New ...',
              'bx_if:part_image' => 
              array (
                'condition' => 'plus',
                'content' => 
                array (
                  'item_img' => '<i class="sys-icon plus" alt="Add New ..." ></i>',
                ),
              ),
            ),
          ),
          'bx_if:reduce_element_bottom' => 
          array (
            'condition' => false,
            'content' => 
            array (
              'menu_id' => '8',
              'item_link' => 'javascript:void(0);',
              'extended_action' => '',
              'cover' => 'bottom_cover',
              'item_name' => 'Add New ...',
              'bx_if:part_image' => 
              array (
                'condition' => 'plus',
                'content' => 
                array (
                  'item_img' => '<i class="sys-icon plus" alt="Add New ..." ></i>',
                ),
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'bubbles' => '"Mail" : {count:\'0\'}, 
"Friends" : {count:\'0\'}, 
"AddContent" : {count:\'\'}, 
',
); ?>