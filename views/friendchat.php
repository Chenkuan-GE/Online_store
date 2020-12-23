<!DOCTYPE html>
<html>
<head>
	<title>CHAT APPLICATION</title>

	<script type="text/javascript">
		var base_url = "<?php echo base_url();?>";
		var user_id = "<?php echo $user_id; ?>";
		var friend_id = "<?php echo $toid; ?>";

		


	</script>

	<style type="text/css">
		div#chat_viewport
		{
			font-family: Verdana, Arial, sans-serif;
			padding: 5px;
			border-top:2px dashed #585858;
			min-height: 300px;
			color: black;
			max-height: 500px;
			overflow: auto;
			margin-bottom: 10px;
			width: 750px;
		}

		div#chat_viewport ul
		{
			list-style-type: none;
			padding-left: 10px;
		}

		div#chat_viewport ul li
		{
			margin-top: 10px;
			width: 85%;
		}

		div#menu
		{
			left: 60%;
			top:12%;
			position: absolute;
		}

		span.chat_message_header
		{
			font-size: 0.7em;
			font-family: "MS Trebuchet", Arial, sans-serif;
			color: #547980;
		}

		p.message_content
		{
			margin-top: 0px;
			margin-bottom: 5px;
			padding-left: 10px;
			margin-right: 0px;
		}

		input#chat_message
		{
			margin-top: 5px;
			border: 1px solid #585858;
			width: 45%;
			font-size: 1.2em;
			margin-right: 10px;
		}

		input#submit_message
		{
			margin-top: 5px;
			font-size: 2em;
			padding: 5px 10px;
			vertical-align: top;
		}

		div#chat_input
		{
			margin-bottom: 10px;
		}

		div#chat_viewport ul li.by_current_user span.chat_message_header 
		{
			color: #e9561b;
		}

	</style>

</head>
<body>
	<h2>Friend Live chatting</h2>
	<h4>Hi <?php echo $this->session->userdata('username');?></h4>
	<div id="chat_viewport">

	</div>

	<div id="chat_input">
		
		<input type="text" name="chat_message" id="chat_message" value="" tabindex="1" />
		<?php echo anchor('Chat/#','Send', array('title' => 'Send this chat message', 'id' => 'submit_message'));?>
		<div class="clearer"></div>

	</div>
	<div id="menu">


	</div>



</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){

		setInterval(function() { get_chat_messages(); }, 2500);

		$("input#chat_message").keypress(function(e){
			if(e.which == 13)
			{
				$("a#submit_message").click();
				return false;
			}

		});


		$("a#submit_message").click(function(){
			var chat_message_content = $("input#chat_message").val();
			if(chat_message_content == "")
			{
				return false;
			}

			$.post(base_url + "Chat/friend_add_chat_message", { chat_message_content:chat_message_content, user_id:user_id, friend_id:friend_id }, function(data)
			{

				if(data.status == 'ok')
				{

					$("div#chat_viewport").html(data.content);

				}
				else
				{
					//error

				}

			},"json");

			$("input#chat_message").val("");

			return false;

		});


		function get_chat_messages()
		{
			$.post(base_url + "Chat/ajax_get_chat_friend", {user_id:user_id, friend_id:friend_id}, function(data){

				if(data.status == 'ok')
				{
					//var current_content = $("div#chat_viewport").html();

					$("div#chat_viewport").html(data.content);

				}
				else
				{
					//error

				}

			}, "json");
		}

		get_chat_messages();


	});
</script>