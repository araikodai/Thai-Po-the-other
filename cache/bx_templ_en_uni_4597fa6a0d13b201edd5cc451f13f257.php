<div class="wall-oi-item <?=$a['mod_prefix'];?>-wall-oi-item" id="wall-event-<?=$a['post_id'];?>">
    <div class="wall-oi-item-cnt <?=$a['mod_prefix'];?>-wall-oi-item-cnt bx-def-round-corners bx-def-shadow">
    	<div class="wall-oii-image-wrp <?=$a['mod_prefix'];?>-wall-oii-image-wrp bx-def-padding-sec-topbottom">
            <div class="wall-oii-image <?=$a['mod_prefix'];?>-wall-oii-image bx-def-margin-sec-top-auto">
                <a href="<?=$a['item_page'];?>"><img class="wall-oii-image <?=$a['mod_prefix'];?>-wall-oii-image bx-def-round-corners bx-def-shadow" src="<?=$a['item_icon'];?>" title="<?=$a['item_title'];?>" width="<?=$a['item_width'];?>" height="<?=$a['item_height'];?>" /></a>
            </div>
        </div>
        <div class="wall-oii-info <?=$a['mod_prefix'];?>-wall-oii-info bx-def-padding-sec">
        	<div class="wall-oii-title <?=$a['mod_prefix'];?>-wall-oii-title bx-def-font-large">
        		<a href="<?=$a['item_page'];?>"><?=$a['item_title'];?></a>
			</div>
			<div class="wall-oii-description <?=$a['mod_prefix'];?>-wall-oii-description bx-def-font-small bx-def-font-grayed"><?=$a['item_description'];?></div>

			<div class="wall-oii-author <?=$a['mod_prefix'];?>-wall-oii-author bx-def-margin-sec-top">
				<?=$this->parseSystemKey('post_owner_icon', $mixedKeyWrapperHtml);?>
				<div class="wall-oii-author-cnt <?=$a['mod_prefix'];?>-wall-oii-author-cnt">
					<div class="wall-oii-author-name <?=$a['mod_prefix'];?>-wall-oii-author-name">
						<a href="<?=$a['user_link'];?>"><?=$a['user_name'];?></a>
					</div>
					<div class="wall-oii-posted <?=$a['mod_prefix'];?>-wall-oii-posted bx-def-font-small bx-def-font-grayed"><?=$a['post_ago'];?></div>
				</div>
			</div>
			<div class="wall-oii-comments <?=$a['mod_prefix'];?>-wall-oii-comments bx-def-margin-sec-top bx-def-border bx-def-round-corners">
				<i class="sys-icon comment-alt"></i>
				<a href="<?=$a['item_comments_link'];?>"><?=$a['item_comments'];?></a>
			</div>
        </div>
    </div>
    <div class="wall-oi-item-circle <?=$a['mod_prefix'];?>-wall-oi-item-circle bx-def-shadow">
		<i class="sys-icon <?=$a['mod_icon'];?>"></i>
	</div>
</div>