<script type="text/javascript">
	function MailBoxComposeMessage()
	{
		// call the parent constructor ;
		this.constructor();

		this.sCurrentPage		= '<?=$a['current_page'];?>';
		this.sPageReceiver 		= this.sCurrentPage + '?ajax_mode=true'; 
		this.sErrorMessage 		= '<?=$a['error_message'];?>';
	}

	// inheritance ;
	MailBoxComposeMessage.prototype = MailBox.prototype;

	// add some function to the object ;

	/**
	 * @description : function will close the reply window ;
	 */

	MailBoxComposeMessage.prototype.cancelCompose = function()
	{
		window.location.href = this.sCurrentPage + '?mode=inbox';
	}

	MailBoxComposeMessage.prototype.AutoComplete = function()
	{
		var sPageUrl = this.sPageReceiver ;

		// get nicknames list ;
		$("#" + htmlSelectors[8]).autocomplete(sPageUrl + '&action=auto_complete', {
			width: 260,
			selectFirst: false
		});	

		// get member thumbnail ;
        $("#" + htmlSelectors[8]).result(function(event, data, formatted) {
			getHtmlData(htmlSelectors[9],  sPageUrl + '&action=get_thumbnail&recipient_id=' + encodeURIComponent(data));
		});
	}

	// create the object;
	var oMailBoxComposeMessage = new MailBoxComposeMessage();
	
	$(document).ready(function () {
		oMailBoxComposeMessage.AutoComplete();
	});
</script>
<div id="compose_message_block">
    <div class="view_message_container">
    	<table cellpadding="0" cellspacing="0" border="0" id="owner_information">
    		<tr>
    			<td valign="top" class="thumb_section">
    				<div id="thumbnail_area">
    					<?=$a['member_thumbnail'];?>
    				</div>
    			</td>
    			<td valign="top" class="member_info">
    				<div class="subject">
    					<table cellpadding="1">
    						<tr>
    							<td>
    								<?=$a['message_to'];?>
    							</td>
    							<td>
    								<input type="text" id="message_recipient" value="<?=$a['recipient_name'];?>" class="ac_input" />
    							</td>
    						</tr>
    							<td>
    								<?=$a['subject'];?> :
    							</td>
    							<td>		
    								<input type="text" id="compose_subject"/>
    							</td>
    						</tr>
    					</table>
    				</div>	
    			</td>
    		</tr>
    	</table>
    	<div class="message_container">
    		<textarea id="compose_message" class="story_edit_area"></textarea>
    	</div>
    	<div class="message_actions message_actions_compose">
            <div class="message_actions_cnt bx-def-padding-sec">
        		<div class="messages_options">
        			<label><input type="checkbox" id="to_mail"/><?=$a['send_copy_to'];?></label>
        			<br />
        			<label><input type="checkbox" id="to_my_mail"/><?=$a['send_copy_my'];?></label>
        			<br />
        			<label><input type="checkbox" id="notify_mail"/><?=$a['notify'];?></label>
        		</div>
                <?=$a['compose_actions_buttons'];?>
            </div>
        </div>
    </div>
</div>
