<script type="text/javascript">
	/**
	 * @description : object constructor;
	 */

	function MailBoxViewMessage()
	{
		// call the parent constructor ;
		this.constructor();

		// define variables ;
		this.sSurecaption	 = '<?=$a['are_you_sure'];?>';
		this.sPageReceiver	 = '<?=$a['current_page'];?>?ajax_mode=true';
		this.sCurrentPage	 = '<?=$a['current_page'];?>';
		this.sPageMode		 = '<?=$a['page_mode'];?>';
		this.iMessageId		 = '<?=$a['message_id'];?>';

		// redefinition `deleteMessages` from the base function ;

		/**
		 * @description : function will move selected message into trash ;
		 * @param		: iMessageID (integer) - message ID ;
		 */

		this.deleteMessages = function( iMessageID )
		{
			if ( iMessageID )
			{
				if ( confirm(this.sSurecaption) )
				{
					var _this = this;
					var sPageUrl = this.sPageReceiver + '&messages=' + iMessageID;

					$.post(sPageUrl, {'action' : 'delete'}, function(){
							_this.relocateInbox();	
					});
				}
			}
		}

		// redefinition `restoreMessages` from the base function ;

		/**
		 * @description : function will restore selected message from the trash ;
		 * @param		: iMessageID (integer) - message ID ;
		 */

		this.restoreMessages = function( iMessageID )
		{
			if ( iMessageID )
			{
				var _this = this;
				var sPageUrl = this.sPageReceiver + '&messages=' + iMessageID;

				$.post(sPageUrl, { 'action' : 'restore'}, function(){
					_this.relocatePage(_this.sCurrentPage + '?mode=' + _this.sPageMode);		
				});
			}
		}
	}

	// inheritance ;
	MailBoxViewMessage.prototype = MailBox.prototype;

	// add some function to the object ;

	/**
	 * @description : function will relocate current page ;
	 * @param		: sPageUrl (string) needed page URL (is the optional parameter);
	 */

	MailBoxViewMessage.prototype.relocatePage = function( sPageUrl )
	{
		if (typeof sPageUrl != 'undefined' )
			window.location.href = sPageUrl;
		else
			window.location.href = this.sCurrentPage;
	}

	/**
	 * @description : function will set status 'read' or 'unread' for selected message ;
	 * @param		: sStatus (string) - status of messages ;	 
	 * @param		: iMessageID (integer) - message ID ;
	 */

	MailBoxViewMessage.prototype.markMessages = function( sStatus, iMessageID )
	{
		var _this = this;
		if ( sStatus && iMessageID )
		{
			var sPageUrl = this.sPageReceiver + '&messages=' + iMessageID + '&status=' + sStatus;
			$.post(sPageUrl, { 'action' : 'mark' } , function(){
				_this.relocatePage(_this.sCurrentPage);		
			});
		}
	}

	/**
	 * @description : function will generate window with reply's forms;
	 * @param		: iMessageID (integer) - message ID ;
	 * @param		: iRecipientId (integer) - recipient's ID ;
	 * @return		: Html presentation data;
	 */

	MailBoxViewMessage.prototype.replyMessage = function( iMessageID, iRecipientId )
	{
        var el = $('.' + htmlSelectors[5]);
        if ( !el.text() ) {
            // get remote data;
            var sPageUrl = this.sPageReceiver + '&action=reply_message&messageID=' 
										  + iMessageID + '&recipient_id=' + iRecipientId;

            el.css({'display':'block', 'height':'250px'});

            //bx_loading(htmlSelectors[5], true);

    		getHtmlData(htmlSelectors[5], sPageUrl, function(){
                el.css('height', 'auto');
                tinyMCE.execCommand('mceAddControl', false, htmlSelectors[0]);
    		});
        }
        else {
            el.css('display', 'block');
        }

		
	}

	// create the object;
	var oMailBoxViewMessage = new MailBoxViewMessage();

	// set active the reply button ;
	$(document).ready(function () {
		var el = $('#' + htmlSelectors[6]);
		if (el.length)
		{
			el.attr('disabled', '');
		}
	});
</script>
<div class="top_settings_block">
    <div class="tsb_cnt_out bx-def-btc-margin-out">
        <div class="tsb_cnt_in bx-def-btc-padding-in">
            <?=$a['top_controls'];?>
        </div>
    </div>
</div>
<div class="bx-def-bc-padding">
    <div class="view_message_container">
        <table cellpadding="0" cellspacing="0" border="0" id="owner_information">
            <tr>
                <td valign="top" class="thumb_section">
                    <?=$a['member_thumbnail'];?>
                </td>
                <td valign="top" class="member_info">
                    <div>
                        <a href="<?=$a['member_location'];?>"><?=$a['member_nick_name'];?></a>
                    </div>
                    <div>
                        <i class="sys-icon time"></i>
                        <?=$a['date_create'];?>
                    </div>
                    <div class="subject bx-def-font-h2">
                        <?=$a['message_subject'];?>
                    </div>	
                </td>
                <td valign="top" class="action_list"><?=$a['member_actions_list'];?><div class="clear_both"></div></td>
            </tr>
        </table>
        <div class="message_container bx-def-font-large">
            <?=$a['message_text'];?>
            <div class="clear_both"></div>
        </div>
        <div class="message_actions">
            <?=$a['message_actions'];?>
        </div>
        <div id="reply_window" class="reply_window bx-def-padding"></div>
    </div>
</div>
