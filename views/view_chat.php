<!DOCTYPE html>
<html>
<head>
	<title>CHAT APPLICATION</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" ></script>
	<script type="text/javascript" src="<?php echo base_url().'public/';?>chat.js"></script>

	<script type="text/javascript">
		var base_url = "<?php echo base_url();?>";
		var chat_id = "<?php echo $chat_id; ?>";
		var user_id = "<?php echo $user_id; ?>";


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
			left: 80%;
			top:12%;
			position: absolute;
			font-family: Verdana, Arial, sans-serif;
			padding: 5px;
			border-top:2px dashed #585858;
			min-height: 300px;
			color: black;
			max-height: 500px;
			overflow: auto;
			margin-bottom: 10px;
			width: 200px;
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
	<h2>Welcome to Public Live chatting</h2>
	<h4>Hi <?php echo $this->session->userdata('username');?></h4>
	<div id="chat_viewport">

	</div>

	<div id="chat_input">
		
		<input type="text" name="chat_message" id="chat_message" value="" tabindex="1" />
		<?php echo anchor('Chat/#','Send', array('title' => 'Send this chat message', 'id' => 'submit_message'));?>
		<div class="clearer"></div>

	</div>
	<div id="menu">
	<h5>Users Menu:</h5>
	<?php $result = $this->Users_model->test(); foreach($result as $row): ?>
		<?php echo $row->username ?>: 
		<a href="<?php echo base_url('Chat/friend/'.$row->userid); ?>"><button>Chat</button></a><br><br />
	<?php endforeach; ?>
	</div>



</body>
</html>
