<script type="text/javascript">
	/**
	 * @description : constructor;
	 */

	function MailBoxArchive()
	{
		// call the parent constructor ;
		this.constructor();
		this.sErrorMessage	 = '<?=$a['select_messages'];?>';
		this.sSurecaption	 = '<?=$a['are_you_sure'];?>';

		this.sResponceBlock	 = 'mail_archives_box';
		this.sPageParameters = '?ajax_mode=true&contacts_mode=' + sContacts_mode; 
		this.sPageReceiver	 = '<?=$a['current_page'];?>' + this.sPageParameters ;

		// redefinition `deleteMessages` from the base function; 

		/**
		 * @description : function will move all selected messages into trash ;
		 * @param		: sContainer (string) - contain name of section where jquery will find it ;
		 * @param		: sCallbackFunction (string) - callback function that will return answer from server side;
		 * @return		: Html presentation data ;
		 */

		this.deleteMessages = function(sContainer, sCallbackFunction )
		{
			var sMessagesId = '';
			var iValue		= '';
			var _this = this;
			var bRelocate = false;

			var oCheckBoxes = $("." + sContainer + " input:checkbox:checked").each(function(){
				iValue = $(this).attr('value').replace(/[a-z]{1,}/i, '');
				if ( iValue ) 
				{
					sMessagesId += iValue + ',';
					if (  iValue == iMessageId )
						bRelocate = true;
				}	
			});

			if ( sMessagesId )
			{
				if ( confirm(this.sSurecaption) )
				{
					var sPageUrl = this.sPageReceiver + '&messages=' + sMessagesId 
													  + '&callback_function=' + sCallbackFunction
													  + '&messageID=' + iMessageId;
													  + this.ExtendedParameters;

					$('#'+this.sResponceBlock).load(sPageUrl, {'action' : 'delete'}, function(){
						if (bRelocate) {
							_this.relocateInbox();	
						}
					});
				}
			}
			else
				alert(this.sErrorMessage);
		}

		/**
		 * @description : function will get paginated page ;
		 * @param		: iPage (integer) number of needed page ;
		 * @return		: Html presentation data;
		 */

		this.getPaginatePage  = function(iPage)
		{
			var _this = this;
			sPageUrl = '<?=$a['current_page'];?>?ajax_mode=true&action=archives_paginate&contacts_mode=' 
								+ sContacts_mode + '&contacts_page=' + iPage + '&messageID=' + iMessageId;

			getHtmlData( this.sResponceBlock, sPageUrl,  function(){
			} );
		}
	}

	// create the object;
	MailBoxArchive.prototype = MailBox.prototype;

	// add some function to the object ;

	/**
	 * @description : function will relocate current page ;
	 */

	MailBoxArchive.prototype.relocateInbox = function()
	{
		window.location.href = '<?=$a['current_page'];?>';
	}

	/**
	 * @description : function will select function name form received data;
	 */

	MailBoxArchive.prototype.selectFunction = function( sValue )
	{
		switch(sValue)
		{
			case 'delete' :
				this.deleteMessages('contacts_container', 'genArchiveMessages');
			break;
			case 'spam' :
				this.spamMessages('contacts_container');
			break;
		}
	}
</script>
<div class="top_settings_block">
    <div class="tsb_cnt_out bx-def-btc-margin-out">
        <div class="tsb_cnt_in bx-def-btc-padding-in">
            <?=$a['top_controls'];?>
        </div>
    </div>
</div>
<div id="mail_archives_box">
	<?=$a['messages_rows'];?>
</div>