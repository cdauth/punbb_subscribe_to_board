<?php
	if(!$forum_user['is_guest'])
	{
		$query = array(
			"UPDATE" => "users",
			"SET" => "subscribe_to_board_pending=0",
			"WHERE" => "id = ".$forum_user["id"]
		);
		$forum_db->query_build($query);
	}
