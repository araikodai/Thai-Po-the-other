<div class="left_section">
	<?=$a['select_all'];?> : <input type="checkbox" onclick="javascript: if ( typeof oMailBoxArchive != 'undefined' ) { (this.checked) ? oMailBoxArchive.selectCheckBoxes(true, 'contacts_container') : oMailBoxArchive.selectCheckBoxes(false, 'contacts_container') }"/>
	&nbsp;
	<select onchange="javascript: if ( typeof oMailBoxArchive != 'undefined' ) { oMailBoxArchive.selectFunction(this.value); } ">
		<option></option>
		<option value="delete"><?=$a['delete_messages'];?></option>
		<option value="spam"><?=$a['spam_messages'];?></option>
	</select>
</div>
<div class="clear_both"></div>