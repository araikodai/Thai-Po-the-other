<!--[if IE 7]>
<style type="text/css">
    div.extra_top_menu table.fixed_menu ul ul
    {
        margin-bottom:-2px;
    }

    div.extra_top_menu table.fixed_menu  #extra_menu_section ul ul{
        margin-top:1px;
    }
</style>
<![endif]-->
<div id="extra_top_menu" class="extra_top_menu">
    <table class="fixed_menu" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td valign="top">
                    <div id="primary_menu_section" class="popup_html">
                        <ul class="primary">
                        <?php if(is_array($a['bx_repeat:items'])) for($i=0; $i<count($a['bx_repeat:items']); $i++){ ?>
                            <li>
                                <div class="menu_item <?=$a['bx_repeat:items'][$i]['indent'];?>" onmouseover="membermenu.show_description('descr_<?=$a['bx_repeat:items'][$i]['menu_id'];?>')" onmouseout="membermenu.hide_description('descr_<?=$a['bx_repeat:items'][$i]['menu_id'];?>')">
                                    <?=$a['bx_repeat:items'][$i]['bubble_box'];?>
                                    <a href="<?=$a['bx_repeat:items'][$i]['menu_link'];?>" class="<?=$a['bx_repeat:items'][$i]['item_link_indent'];?>" <?=$a['bx_repeat:items'][$i]['extended_action'];?> <?=$a['bx_repeat:items'][$i]['target'];?>>
                                        <?=$a['bx_repeat:items'][$i]['menu_image'];?>
                                        <?=$a['bx_repeat:items'][$i]['menu_caption'];?>
                                    </a>
                                    <?php if($a['bx_repeat:items'][$i]['bx_if:menu_desc']['condition']){ ?>
                                    <div class="description <?=$a['bx_repeat:items'][$i]['bx_if:menu_desc']['content']['desc_indent'];?>" id="descr_<?=$a['bx_repeat:items'][$i]['bx_if:menu_desc']['content']['menu_id'];?>">
                                       <?=$a['bx_repeat:items'][$i]['bx_if:menu_desc']['content']['desc_window'];?>
                                    </div>    
                                    <?php } ?>
                                </div>
                                <div class="devider"></div>
                                <?php if($a['bx_repeat:items'][$i]['bx_if:sub_menu']['condition']){ ?>
                                <ul id="extra_menu_popup_<?=$a['bx_repeat:items'][$i]['bx_if:sub_menu']['content']['menu_id'];?>">
                                    <li><table class="popup" cellpadding="0" cellspacing="0"><tbody><tr><td class="html_data">
                                                        <?php if($a['bx_repeat:items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_top']['condition']){ ?>
                                                        <div class="extra_data <?=$a['bx_repeat:items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_top']['content']['cover'];?>">
                                                            <table cellpadding="0" cellspacing="0">
                                                                <tbody>
                                                                    <tr>
                                                                        <?php if($a['bx_repeat:items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_top']['content']['bx_if:part_image']['condition']){ ?>
                                                                        <td class="part_img"><?=$a['bx_repeat:items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_top']['content']['bx_if:part_image']['content']['item_img'];?></td>
                                                                        <?php } ?>
                                                                        <td class="part_name"><a href="<?=$a['bx_repeat:items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_top']['content']['item_link'];?>" class="item_block"><?=$a['bx_repeat:items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_top']['content']['item_name'];?></a></td>
                                                                        <td class="reduce"><div><i class="sys-icon remove" alt="minimize"  title="minimize" width="14" height="14" border="0" onclick="membermenu.close_popup('extra_menu_popup_<?=$a['bx_repeat:items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_top']['content']['menu_id'];?>')"></i></div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <?php } ?>
                                                        <div class="html_data" id="menu_content_<?=$a['bx_repeat:items'][$i]['bx_if:sub_menu']['content']['menu_id'];?>"></div>
                                                        <?php if($a['bx_repeat:items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_bottom']['condition']){ ?>
                                                        <div class="extra_data <?=$a['bx_repeat:items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_bottom']['content']['cover'];?>"><table cellpadding="0" cellspacing="0">
                                                                <tbody>
                                                                    <tr>
                                                                        <?php if($a['bx_repeat:items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_bottom']['content']['bx_if:part_image']['condition']){ ?>
                                                                        <td class="part_img"><?=$a['bx_repeat:items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_bottom']['content']['bx_if:part_image']['content']['item_img'];?></td>
                                                                        <?php } ?>
                                                                        <td class="part_name"><a href="<?=$a['bx_repeat:items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_bottom']['content']['item_link'];?>" class="item_block"><?=$a['bx_repeat:items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_bottom']['content']['item_name'];?></a></td>
                                                                        <td class="reduce"><div><i class="sys-icon remove" alt="minimize"  title="minimize" width="14" height="14" border="0" onclick="membermenu.close_popup('extra_menu_popup_<?=$a['bx_repeat:items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_bottom']['content']['menu_id'];?>')"></i></div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </li>
                                </ul>
                                <?php } ?>
                            </li>
                        <?php } else if(is_string($a['bx_repeat:items'])) echo $a['bx_repeat:items']; ?>
                        </ul>
                    <div class="clear_both"></div>
                    </div>
                </td>
                <td valign="top">
                    <div id="extra_area"></div>
                    <div class="clear_both"></div>
                </td>
                <td valign="top">
                    <div id="extra_menu_section" class="popup_html">
                        <ul class="primary">
                            <?php if(is_array($a['bx_repeat:extra_items'])) for($i=0; $i<count($a['bx_repeat:extra_items']); $i++){ ?>
                            <li class="extra_item">
                                <div class="devider"></div>
                                <div class="menu_item <?=$a['bx_repeat:extra_items'][$i]['indent'];?>" onmouseover="membermenu.show_description('descr_<?=$a['bx_repeat:extra_items'][$i]['menu_id'];?>')" onmouseout="membermenu.hide_description('descr_<?=$a['bx_repeat:extra_items'][$i]['menu_id'];?>')">
                                    <?=$a['bx_repeat:extra_items'][$i]['bubble_box'];?>
                                    <a  class="extra_item <?=$a['bx_repeat:extra_items'][$i]['item_link_indent'];?>" href="<?=$a['bx_repeat:extra_items'][$i]['menu_link'];?>" <?=$a['bx_repeat:extra_items'][$i]['extended_action'];?> <?=$a['bx_repeat:extra_items'][$i]['target'];?>>
                                        <?=$a['bx_repeat:extra_items'][$i]['menu_image'];?>
                                        <?=$a['bx_repeat:extra_items'][$i]['menu_caption'];?>
                                    </a>
                                    <?php if($a['bx_repeat:extra_items'][$i]['bx_if:menu_desc']['condition']){ ?>
                                    <div class="description <?=$a['bx_repeat:extra_items'][$i]['bx_if:menu_desc']['content']['desc_indent'];?>" id="descr_<?=$a['bx_repeat:extra_items'][$i]['bx_if:menu_desc']['content']['menu_id'];?>">
                                       <?=$a['bx_repeat:extra_items'][$i]['bx_if:menu_desc']['content']['desc_window'];?>
                                    </div>    
                                    <?php } ?>
                                </div>
                                <?php if($a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['condition']){ ?>

                                <ul id="extra_menu_popup_<?=$a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['content']['menu_id'];?>"><li>
                                        <table class="popup" cellpadding="0" cellspacing="0"><tbody><tr><td class="html_data">
                                                        <?php if($a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_top']['condition']){ ?>
                                                        <div class="extra_data <?=$a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_top']['content']['cover'];?>">
                                                            <table cellpadding="0" cellspacing="0"><tbody>
                                                                <tr>
                                                                    <?php if($a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_top']['content']['bx_if:part_image']['condition']){ ?>
                                                                    <td class="part_img"><?=$a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_top']['content']['bx_if:part_image']['content']['item_img'];?></td>
                                                                    <?php } ?>
                                                                    <td class="part_name"><a href="<?=$a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_top']['content']['item_link'];?>" <?=$a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_top']['content']['extended_action'];?> class="item_block"><?=$a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_top']['content']['item_name'];?></a></td>
                                                                    <td class="reduce"><i class="sys-icon remove" alt="minimize"  title="minimize" width="14" height="14" border="0" onclick="membermenu.close_popup('extra_menu_popup_<?=$a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_top']['content']['menu_id'];?>')"></i></td>
                                                                </tr>
                                                            </tbody>
                                                            </table>
                                                        </div>
                                                        <?php } ?>
                                                        <div class="html_data" id="menu_content_<?=$a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['content']['menu_id'];?>"></div>
                                                        <?php if($a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_bottom']['condition']){ ?>
                                                        <div class="extra_data <?=$a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_bottom']['content']['cover'];?>">
                                                            <table cellpadding="0" cellspacing="0"><tbody>
                                                                    <tr>
                                                                        <?php if($a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_bottom']['content']['bx_if:part_image']['condition']){ ?>
                                                                        <td class="part_img"><?=$a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_bottom']['content']['bx_if:part_image']['content']['item_img'];?></td>
                                                                        <?php } ?>
                                                                        <td class="part_name"><a href="<?=$a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_bottom']['content']['item_link'];?>" class="item_block"><?=$a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_bottom']['content']['item_name'];?></a></td>
                                                                        <td class="reduce"><i class="sys-icon remove" alt="minimize"  title="minimize" width="14" height="14" border="0" onclick="membermenu.close_popup('extra_menu_popup_<?=$a['bx_repeat:extra_items'][$i]['bx_if:sub_menu']['content']['bx_if:reduce_element_bottom']['content']['menu_id'];?>')"></i></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </li>
                                </ul>
                                <?php } ?>
                            </li>
                            <?php } else if(is_string($a['bx_repeat:extra_items'])) echo $a['bx_repeat:extra_items']; ?>
                        </ul>
                        <div class="clear_both"></div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script type="text/javascript">

    jQuery.fn.fixedMenuMember = function(options, callback) {

        options = jQuery.extend({
            // possible variants : top, bottom, static ;
            menu_position : 'top'
        }, options);    

        return(this.each(function() {
            jQuery(this).css({
                position: ( options.menu_position == 'static' ) ? 'absolute' : 'fixed',
                zIndex: '990',
                left: '0px'
            });

            if ( options.menu_position == 'top' || options.menu_position == 'static' ) {
                jQuery(this).css({ top: '-2px'});
                jQuery('.sys_main_logo').css({ 'padding-top': '36px'});
            }
            else {
               jQuery(this).css({ bottom: '-2px'});
            }

            // set visible ;
            jQuery(this).css('display', 'block');
            if ( typeof callback == 'function' ) {
                callback();
            }    
        }));
    };

    // ** define some global menu's variables ;

    // define all menu's popup menu ;
    var membermenu = 
    {
        // contain path for page response ;
        page_url            : 'http://www.thaipo.org/<?=$a['page_reciver'];?>',
        data_block_prefix   : 'menu_content_',

        //duration of slide in/ out animation, in milliseconds for submenu
        animateduration         : {over: 200, out: 100},

        notify_window_animateduration  : {over: 1000, out: 1000},

        description_window_animateduration  : {over: 300, out: 300},

        // member menu's width ;
        iMemberMenuWidth        : 0,

        // member menu's wrapper width ;
        iMemberMenuWrapperWidth : 0,

        // current member menu position ;
        sMenuPosition : '',

        // contain all registered bubbles for menu items;
        oBubbles : '',

        // in millisecond;
        iBubblesUpdateTime : <?=$a['bubbles_update_time'];?>, 

        iDestroyNotifiWindowsTime : <?=$a['notify_destroy_time'];?>,

        // contains a descriptor of the created timeout ;
        rBubblesHandler : '',

        rNotifyHandler : '',

        // contain notify block's id;
        sNotifyWindow : 'notification_window',

        sBubbleBubblePrefix : '<?=$a['bubble_prefix'];?>',

        // description window's id (nedded for displayed menu description);
        sDescriptionWindow : 'MemberMenuDesc',

        /**
         * Function will define some nedded menu's settings;
         *
         * @param : sMenuPosition (string) - menu's position;
         * @param : aMenuSections (array)  - menu's sections (that will need to build);
         */
        init:function(sMenuPosition, aMenuSections)
        {
            var i = 0;
            var iSections  =  aMenuSections.length;
            var self = this;

            var $oExtraMenu = $('#extra_top_menu .fixed_menu');

            this.iMemberMenuWidth = $oExtraMenu.width();
            this.iMemberMenuWrapperWidth = $oExtraMenu.width();
            this.sMenuPosition = sMenuPosition;

            this.oBubbles = {
                <?=$a['bubbles_list'];?>
            }

            // build submenus;
            for(i=0; i<iSections; i++)
            {
                // try define width for received sections;
                $('#' + aMenuSections[i]).each(function(){
                    $(this).parent().css( 'width', $(this).width() + 5 );
                    self.buildmenu(aMenuSections[i]);
                });
            }

            this.update_bubbles();
        },
        /**
         * Function will update all registered bubbles;
         *
         */
        update_bubbles:function()
        {
            var self = this;
            var sQueryParam  = '';

            //procces all registered bubbles;
            for (Element in  this.oBubbles)
            {
                sQueryParam = sQueryParam + Element + ':' + this.oBubbles[Element].count + ',';
            }

            // if any of bubbles not defined;
            if ( !sQueryParam ) {
                return;
            }

            var _sRandom = Math.random();

            $.get(this.page_url, { action: "get_bubbles_values", bubbles: sQueryParam, _r : _sRandom  }, function(sData)
            {
                if (sData)
                {
                    var iCount = 0;
                    var sNotifications = '';
                    var bHaveMessages = false;
                    var oResponse;
                    if ('object' == typeof sData)
                        oResponse = sData;
                    else
                        oResponse = eval("(" + sData + ")");
                    for (Element in oResponse)
                    {
                        if ( typeof self.oBubbles[Element] != 'undefined' ) {
                            iCount = parseInt(oResponse[Element].count);

                            self.oBubbles[Element].count   = iCount;

                            // update bubble's block with recived value;
                            var iOldCount = parseInt( $('#' + self.sBubbleBubblePrefix + Element).find('td.bubble_count:first').text() );
                            $('#' + self.sBubbleBubblePrefix + Element).find('td.bubble_count:first').text(oResponse[Element].count);

                            if ( typeof oResponse[Element].onlclick_script != 'undefined' 
                                && oResponse[Element].onlclick_script) {

                                self.oBubbles[Element].onlclick_script = oResponse[Element].onlclick_script;
                            }
                            else {
                                self.oBubbles[Element].onlclick_script = 'undefined';
                            }

                            // process all recived messages (if isset);
                            if ( typeof oResponse[Element].messages != 'undefined' ) {
                                //clearTimeout(self.rNotifyHandler);
                                bHaveMessages = false;

                                for (MessageEl in oResponse[Element].messages)
                                {
                                    // add messages into container;
                                    sNotifications = '<div class="notifi">' + oResponse[Element].messages[MessageEl].message + '<\/div>';
                                    $(sNotifications).prependTo('#' + self.sNotifyWindow).mouseover(function(){$(this).addClass('active')}).mouseout(function(){$(this).removeClass('active')});
                                    bHaveMessages = true;
                                }

                                var _this = self;
                                $('#' + self.sNotifyWindow).find('div.notifi').each(function (i) {
                                    if ( $(this).css('display') != 'block' ){
                                        $(this).fadeIn(_this.notify_window_animateduration.over);
                                    }
                                });

                                if( !self.rNotifyHandler && bHaveMessages ) {
                                    setTimeout(function(){
                                       _this.destroy_notify_windows();
                                    }, self.iDestroyNotifiWindowsTime);
                                }

                            }

                            if (iCount > iOldCount) {
                                self.set_visible_bubble_block(self.sBubbleBubblePrefix + Element);
                            }

                            if (iCount != iOldCount || bHaveMessages) {
                                // refresh the bubble's submenu;
                                var $oCurrentMenu = $('#' + self.sBubbleBubblePrefix + Element);
                                var $oSubMenu = $oCurrentMenu.parents('li:first').find('ul:first');
                                self.load_sub_menu_content($oSubMenu.attr('id'), true);

                                if( $oSubMenu.css('display') != 'none' ) {
                                    $oSubMenu.css('display', 'none');
                                    $oCurrentMenu.parent().removeClass('menu_item_active');
                                }
                            }

                            if (!iCount) {
                                self.set_hidden_bubble_block(self.sBubbleBubblePrefix + Element);
                            }
                        }
                    }

                    var _this = self;
                    self.rBubblesHandler = setTimeout(function(){
                        _this.update_bubbles();
                    },self.iBubblesUpdateTime);
                }
            });
        },
        /**
         * Function will set status as hidden for received bubble box;
         *
         *
         */
        set_hidden_bubble_block:function(sBubbleId)
        {
            var oObject = $('#' + sBubbleId);
            if(typeof oObject != 'undefined') {
                $(oObject).css('display', 'none');
            }
        },
        /**
         * Function will set status as visible for received bubble box;
         *
         *
         */
        set_visible_bubble_block:function(sBubbleId)
        {
            var oObject = $('#' + sBubbleId);
            if(typeof oObject != 'undefined') { 
                if ( $(oObject).css('display') != 'hidden' ) {
                    $(oObject).css('display', 'block');
                }
            }  
        },
        check_exist_notify_window:function(oNotifyWindow)
        {
            var self = this;

            if ( typeof oNotifyWindow.find('div.notifi').attr('class') != 'undefined' ) {
                this.rNotifyHandler = setTimeout(function(){
                   self.destroy_notify_windows();
                }, this.iDestroyNotifiWindowsTime);
            }
            else {
                clearTimeout(this.rNotifyHandler);
                this.rNotifyHandler = '';
            }
        },
        /**
         * Function will destroy all active notify messages;
         *
         */
        destroy_notify_windows:function()
        {
            var self = this;
            var $oNotifyWindow = $('#' + self.sNotifyWindow);
            var $oBuildedNotifyWindow = $oNotifyWindow.find('div.notifi:not(:animated):last');
            var isDefined = false;

            // remove last notify window;
            if ( $oBuildedNotifyWindow && !$oBuildedNotifyWindow.hasClass('active') ) {
                $oBuildedNotifyWindow.fadeOut(this.notify_window_animateduration.out, function(){
                    $(this).remove();
                    isDefined = true;
                    // check notify window existing;
                    self.check_exist_notify_window($oNotifyWindow);
                });
            }
            else {
                // remove next after last;
                $oBuildedNotifyWindow.prev().fadeOut(this.notify_window_animateduration.out, function(){
                    $(this).remove();
                    isDefined = true;
                    // check notify window existing;
                    self.check_exist_notify_window($oNotifyWindow);
                });
            }

            if(!isDefined) {
                self.check_exist_notify_window($oNotifyWindow);
            }
        },
        /**
         * Function will generate menu and sub menu items;
         *
         * @param : menuid (string) - menu's in DOM;
         */
        buildmenu:function( menuid )
        {
            var $mainmenu = $("#"+menuid+">ul");
            var $headers  = $mainmenu.find("ul").parent();
            var self = this;

            $headers.each(function(i)
            {

                var $curobj=$(this);
                var $subul=$(this).find('ul:eq(0)');

                this._dimensions=
                {
                    h:$(this).height()
                }

                this.istopheader=$curobj.parents("ul").length == 1 ? true : false;
               // define the member menu's position ;
                if ( self.sMenuPosition == 'bottom' ) {
                    // set sub menu's bottom possition;
                    $subul.css({bottom:this._dimensions.h + 1});
                }
                else {
                    // set sub menu's top position ;
                    $subul.css({top:this._dimensions.h + 1});
                }

                $curobj.click(
                    function(event)
                    {
                        var event = event || window.event;
                        var t = event.target || event.srcElement;
                        var self = this;

                        if ( $(t).parents('ul:first').hasClass('primary') ) {

                                var $targetul=$(this).children("ul:eq(0)");

                                // hide or show the active bubble;
                                var $buble_el = $targetul.parents('li:first').find('.bubble:first');
                                $buble_el.css('display', 'none');

                                if( $($targetul).css('display') == 'block') {
                                    membermenu.close_popup( $($targetul).attr('id') );
                                    return;
                                }

                                // fill block with content ;
                                membermenu.load_sub_menu_content($targetul.attr('id'), false, function()
                                {
                                    // set element hidden, need for the correct menu width definition;
                                    if ( $targetul.css("visibility") == 'visible' ) {
                                            $targetul.css({display:'block', visibility:'hidden'});
                                    }

                                    // submenu weight ;
                                    var iSubMenuWidth = $(self).find('ul li table:first').width();

                                    var menuleft = 0;
                                    var iParentWidth = $(self).outerWidth();

                                    menuleft = (menuid != 'primary_menu_section') ? -iSubMenuWidth + iParentWidth -2 : 0;

                                    //set element visible, need for the correct menu width definition;
                                    if ( $targetul.css("visibility") == 'hidden' ) {
                                        $targetul.css({display:'none', visibility:'visible'});
                                    }

                                    // set hidden all active sub menus;
                                    $('#extra_top_menu ul ul').each(function (i){
                                        if( this.id != $targetul.attr('id') ) {
                                            membermenu.close_popup(this.id);
                                        }
                                    });

                                    if ($targetul.queue().length <= 1) { 
                                        // set menu item as active state ;
                                        $(self).children().addClass('menu_item_active');

                                        $targetul
                                            .css({left:menuleft+"px"})
                                            .fadeIn( membermenu.animateduration.over);
                                    }

                                    // check onclick script and execute this if isset;
                                    if($buble_el.length != 0) {
                                        var sBubbleId = $buble_el.attr('id').replace(membermenu.sBubbleBubblePrefix, '');
                                        var sCode = membermenu.oBubbles[sBubbleId].onlclick_script;
                                        if(sCode) {
                                            eval(sCode);
                                        }
                                    }
                                });
                        }
                    }
                ) //end click

            }) //end $headers.each()

            $mainmenu.find("ul").css({display:'none', visibility:'visible'})
        },
        /**
         * Function will load submenu for current active menu item;
         *
         * @param : popup_id (string) - popup's Id;
         * @param : forced (boolean)  - if set as true than script will load data from server side;
         * @param : callback (string) - callback function ;
         */
        load_sub_menu_content:function( popup_id, forced, callback )
        {
            if(!popup_id) {
                return;
            }

            var iMenuId = popup_id.replace(/[^0-9]{1,}/, '');
            if( forced || $.trim( $('#' + this.data_block_prefix + iMenuId).html() ).length == 0 )
            {
                var _sRandom = Math.random();
                var sPageUrl = this.page_url + '?action=get_menu_content&menu_id=' + iMenuId + '&_r=' + _sRandom;
                

                $( '#' + this.data_block_prefix + iMenuId).load(sPageUrl, function() {
                    if ( typeof callback != 'undefined' ) {
                        callback();
                    }
                });
            }
            else {
                if ( typeof callback != 'undefined' ) {
                    callback();
                }
            }
        },
        /**
         * Function will close opened the popup window ;
         *
         */
        close_popup:function(popup_id)
        {
            var self = this;
            var $el = $('#' + popup_id);

            $el.fadeOut(this.animateduration.out, function () {
                $el.parent().children().removeClass('menu_item_active');
            });
        },
        /**
         * Function will show menu's description block;
         *
         * @param : description_block (string);
         */
        show_description:function(description_block)
        {
            $('#' + description_block).css('visibility', 'visible');
        },
        /**
         * Function will hide menu's description block;
         *
         * @param : description_block (string);
         */
        hide_description:function(description_block)
        {
            $('#' + description_block).css('visibility', 'hidden');
        }
    }

    $(document).ready(function () {
        var sMenuPosition = '<?=$a['menu_position'];?>';

        // define menu's position ;
        $("#extra_top_menu").fixedMenuMember({menu_position:sMenuPosition}, function(){
            var aMenuSections = new Array();
            aMenuSections[0]  = 'primary_menu_section'; 
            aMenuSections[1]  = 'extra_menu_section'; 

            // build menu ;
            membermenu.init(sMenuPosition, aMenuSections);
        });
    });    
</script>
