<html>
<head>
	<script type="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script type="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<div class="container">
	<br />
	<h3 align="center">Feedback Form</h3><br />
	<div class="row">
		<div class="col-md-4">

		</div>
		<div class="col-md-4">
			<span id="success_message"></span>
			<form method="post" id="contact_form">
				<div class="form-group">
					<input type="text" name="name" id="name" class="form-control" placeholder="Name" />
					<span id="name_error" class="text-danger"></span>
				</div>
				<div class="form-group">
					<input type="text" name="email" id="email" class="form-control" placeholder="Email Address" />
					<span id="email_error" class="text-danger"></span>
				</div>
				<div class="form-group">
					<input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" />
					<span id="subject_error" class="text-danger"></span>
				</div>
				<div class="form-group">
					<textarea name="message" id="message" class="form-control" placeholder="Message" rows="6"></textarea> 
					<span id="message_error" class="text-danger"></span>
				</div>
				<div class="form-group">
					<div class="g-recaptcha" data-sitekey="6Ld4__0UAAAAADZkAXmhOa_WlusWC901NalH7EPW"></div> 
					<span id="captcha_error" class="text-danger"></span>
				</div>
				<div class="form-group">
					<input type="submit" name="contact" id="contact" class="btn btn-info" placeholder="Contact us" >
				</div>
			</form>
		</div>
		<div class="col-md-4">

		</div>
	</div>
</div>
</body>
</html>
<script>

$(document).ready(function(){

	$('#contact_form').on('submit',function(event){
		event.preventDefault();
		$.ajax({
			url:"<?php echo base_url(); ?>feedback/validation",
			method:"POST",
			data:$(this).serialize(),
			dataType:"json",
			beforeSend:function(){
				$('#contact').attr('disabled','disabled');
			},
			success:function(data)
			{
				if(data.error)
				{
					if(data.name_error != '')
					{
						$('#name_error').html(data.name_error);
					}
					else
					{
						$('#name_error').html('');
					}
					if(data.email_error != '')
					{
						$('#email_error').html(data.email_error);
					}
					else
					{
						$('#email_error').html('');
					}
					if(data.subject_error != '')
					{
						$('#subject_error').html(data.subject_error);
					}
					else
					{
						$('#subject_error').html('');
					}
					if(data.message_error != '')
					{
						$('#message_error').html(data.message_error);
					}
					else
					{
						$('#message_error').html('');
					}
					if(data.captcha_error != '')
					{
						$('#captcha_error').html(data.captcha_error);
					}
					else
					{
						$('#captcha_error').html('');
					}
				}
				if(data.success)
				{
					$('#success_message').html(data.success);
					$('#captcha_error').html('');
					$('#name_error').html('');
					$('#email_error').html('');
					$('#subject_error').html('');
					$('#message_error').html('');
					$('#contact_form')[0].reset();
					grecaptcha.reset();
					alert('Form successfully submitted!');
				}
				$('#contact').attr('disabled',false);
			}
		})
	});	

});

</script>
