<?php

class Chat_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}

	function add_chat_message($chat_id,$user_id,$chat_message_content)
	{
		$query_str = "INSERT INTO chat_messages (chat_id, user_id, chat_message_content) VALUES (?, ?, ?)";

		$this->db->query($query_str, array($chat_id, $user_id, $chat_message_content));
	}

	function add_chat_friend($chat_id,$user_id,$friend_id,$chat_message_content)
	{
		$query_str = "INSERT INTO friendchat (chat_id, from_id, to_id, messages) VALUES (?, ?, ?, ?)";

			$this->db->query($query_str, array($chat_id, $user_id, $friend_id, $chat_message_content));
	}

	function get_chat_messages($chat_id)
	{
		$query_str = "SELECT cm.user_id, 
					cm.chat_message_content,
					DATE_FORMAT(cm.create_date, '%D of %M %Y at %H:%i:%s') AS chat_message_timestamp,
					u.username
					FROM chat_messages cm
					JOIN users u ON cm.user_id = u.userid
					WHERE cm.chat_id = ?
					ORDER BY cm.create_date DESC";

		$result = $this->db->query($query_str, $chat_id);

		return $result;
	}

	function get_chat_friend($chat_id)
	{
		$query_str = "SELECT cm.from_id, 
					cm.messages,
					DATE_FORMAT(cm.create_time, '%D of %M %Y at %H:%i:%s') AS chat_message_timestamp,
					u.username
					FROM friendchat cm
					JOIN users u ON cm.from_id = u.userid
					WHERE cm.chat_id = ?
					ORDER BY cm.create_time DESC";

		$result = $this->db->query($query_str, $chat_id);

		return $result;
	}

}

?>