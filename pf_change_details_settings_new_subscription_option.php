<?php
	if(file_exists($ext_info['path'].'/lang/'.$forum_user['language'].'.php'))
		include($ext_info['path'].'/lang/'.$forum_user['language'].'.php');
	else
		include($ext_info['path'].'/lang/English.php');
?>
<div class="mf-item">
	<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page['fld_count'] ?>" name="form[pun_subscribe_to_board]" value="1"<?php if ($user['pun_subscribe_to_board'] == '1') echo ' checked="checked"' ?> /></span>
	<label for="fld<?php echo $forum_page['fld_count'] ?>"><?php echo $lang_pun_subscribe_to_board['Subscribe to board'] ?></label>
</div>