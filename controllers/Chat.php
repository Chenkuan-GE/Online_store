<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('Chat_model');

	}

	function index()
	{

		$this->view_data['chat_id'] = 1;
		$this->view_data['user_id'] = $this->session->userdata('user_id');


		$this->load->view('templates/header_test');
		$this->load->view('view_chat',$this->view_data);
		$this->load->view('templates/footer');
	}

	function friend($id)
	{
		$this->view_data['user_id'] = $this->session->userdata('user_id');
		$this->view_data['toid'] = $id;

		$this->load->view('templates/header_test');
		$this->load->view('friendchat',$this->view_data);
		$this->load->view('templates/footer');
	}
	

	function ajax_add_chat_message()
	{

		// chat_id userid chat_message_content\

		$chat_id = $this->input->post('chat_id');
		$user_id = $this->input->post('user_id');
		$chat_message_content = $this->input->post('chat_message_content', TRUE);

		$this->Chat_model->add_chat_message($chat_id,$user_id,$chat_message_content);

		echo $this->_get_chat_messages($chat_id);

	}

	function friend_add_chat_message()
	{
		$user_id = $this->input->post('user_id');

		echo "<script>alert('wofule')</script>";
		$friend_id = $this->input->post('friend_id');
		$chat_message_content = $this->input->post('chat_message_content', TRUE);
		if ($user_id < $friend_id) {
			$chat_id = "$user_id x $friend_id";
		}
		else
		{
			$chat_id = "$friend_id x $user_id";
		}

		$this->Chat_model->add_chat_friend($chat_id,$user_id,$friend_id,$chat_message_content);

		echo $this->_get_chat_friend($chat_id);
	}


	function ajax_get_chat_messages()
	{
		$chat_id = $this->input->post('chat_id');

		echo $this->_get_chat_messages($chat_id);
	}

	function _get_chat_messages($chat_id)
	{
		$chat_messages = $this->Chat_model->get_chat_messages($chat_id);

		if($chat_messages->num_rows() > 0 )
		{
			$chat_messages_html = '<ul>';

			foreach ($chat_messages->result() as $chat_message) {
				# code...

				$li_class = ($this->session->userdata('user_id') == $chat_message->user_id) ? 'class="by_current_user"' : '';

				$chat_messages_html .= '<li '.$li_class.'>'. '<span class="chat_message_header">'. $chat_message->chat_message_timestamp .' by '.$chat_message->username .'</span><p class="message_content">'. $chat_message->chat_message_content .'</p></li>';
			}

			$chat_messages_html .= '</ul>';

			$result = array('status' => 'ok', 'content' => $chat_messages_html);

			return json_encode($result);
			exit();
		}
		else
		{
			$result = array('status' => 'ok', 'content' => '');

			return json_encode($result);
			exit();
		}
	}

	function ajax_get_chat_friend()
	{
		$user_id = $this->input->post('user_id');
		$friend_id = $this->input->post('friend_id');
		if ($user_id < $friend_id) {
			$chat_id = "$user_id x $friend_id";
		}
		else
		{
			$chat_id = "$friend_id x $user_id";
		}
		echo $this->_get_chat_friend($chat_id);
	}

	function _get_chat_friend($chat_id)
	{
		$chat_messages = $this->Chat_model->get_chat_friend($chat_id);

		if($chat_messages->num_rows() > 0 )
		{
			$chat_messages_html = '<ul>';

			foreach ($chat_messages->result() as $chat_message) {
				# code...

				$li_class = ($this->session->userdata('user_id') == $chat_message->from_id) ? 'class="by_current_user"' : '';

				$chat_messages_html .= '<li '.$li_class.'>'. '<span class="chat_message_header">'. $chat_message->chat_message_timestamp .' by '.$chat_message->username .'</span><p class="message_content">'. $chat_message->messages .'</p></li>';
			}

			$chat_messages_html .= '</ul>';

			$result = array('status' => 'ok', 'content' => $chat_messages_html);

			return json_encode($result);
			exit();
		}
		else
		{
			$result = array('status' => 'ok', 'content' => '');

			return json_encode($result);
			exit();
		}
	}

}