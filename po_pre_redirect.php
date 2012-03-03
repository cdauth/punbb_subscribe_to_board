<?php
	if(!defined('FORUM_EMAIL_FUNCTIONS_LOADED'))
		require FORUM_ROOT.'include/email.php';

	$query = array(
		"SELECT" => "u.id,u.email,u.language",
		"FROM" => "users AS u",
		"JOINS" => array(
			array(
				"LEFT JOIN" => "groups AS g",
				"ON" => "u.group_id = g.g_id"
			),
			array(
				"LEFT JOIN" => "forum_perms AS fp",
				"ON" => "fp.forum_id = ".$cur_posting["id"]." AND fp.group_id = u.group_id"
			)
		),
		"WHERE" => "u.email != '' AND u.pun_subscribe_to_board = 1 AND u.pun_subscribe_to_board_pending != 1 AND u.id > 1 AND ( fp.read_forum IS NULL OR fp.read_forum = 1 ) AND g.g_read_board != 0"
	);
	$result = $forum_db->query_build($query);
	$user_ids = array();
	while($user_data = $forum_db->fetch_assoc($result))
	{
		if(file_exists($ext_info['path'].'/lang/'.$user_data['language'].'.php'))
			include($ext_info['path'].'/lang/'.$user_data['language'].'.php');
		else
			include($ext_info['path'].'/lang/English.php');

		forum_mail($user_data["email"], $lang_pun_subscribe_to_board["New post(s) notification"], sprintf($lang_pun_subscribe_to_board["e-mail text"], $base_url."/search.php?action=show_new"));
		$user_ids[] = $user_data["id"];
	}
	
	$query_update = array(
		"UPDATE" => "users",
		"SET" => "pun_subscribe_to_board_pending=1",
		"WHERE" => "id IN (".implode(",", $user_ids).")"
	);
	$forum_db->query_build($query_update);