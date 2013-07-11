<div class="contacts_container">
	<?php if(is_array($a['bx_repeat:members'])) for($i=0; $i<count($a['bx_repeat:members']); $i++){ ?>
        <div class="sys-mailbox-contact bx-def-margin-sec-top">
            <div class="sys-mbc-author">
                <?=$a['bx_repeat:members'][$i]['member_icon'];?>
            </div>
            <div class="sys-mbc-info">
                <div class="sys-mbc-author-info">
                    <a href="<?=$a['bx_repeat:members'][$i]['member_location'];?>"><?=$a['bx_repeat:members'][$i]['member_nick_name'];?></a> <br />
                </div>
                <div class="sys-mbc-actions">
                    <button class="bx-btn bx-btn-small" onclick="window.open('http://www.thaipo.org/<?=$a['bx_repeat:members'][$i]['current_page'];?>?mode=compose&recipient_id=<?=$a['bx_repeat:members'][$i]['member_id'];?>','_self');">
                        Compose
                    </button>
                </div>
            </div>
        </div>
	<?php } else if(is_string($a['bx_repeat:members'])) echo $a['bx_repeat:members']; ?>
</div>