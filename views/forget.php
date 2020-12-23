<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min1.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap.min.css">
    <script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"> </script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"> </script>
</head>

<style>

</style>

<body>

	<div class="container">
		<br />
		<h3 align="center">Forget Password?---Step1</h3><br />
		<div class="row">
			<div class="col-md-4">

			</div>
			<div class="col-md-4">
				
				<form method="post" id="contact_form">
					<div class="form-group">
						<p>Enter your email:</p>
						<input type="text" name="code" id="code" class="form-control" placeholder="Email Address" />
						<span id="code_error" class="text-danger"></span>
					</div>
					<div class="form-group">
						<input type="submit" name="verify" id="verify" class="btn btn-info" />
					</div>
				</form>
				<span id="success_message"></span>
				
			</div><br /><br /><br />
			<div class="col-md-6">
				<a href="<?php echo base_url(); ?>Welcome/index"><button> Return to Login </button></a>
			</div>

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
			url:"<?php echo base_url(); ?>Forget/email",
			method:"POST",
			data:$(this).serialize(),
			dataType:"json",
			beforeSend:function(){
				$('#verify').attr('disabled','disabled');
			},
			success:function(data)
			{
				if(data.error)
				{
					if(data.code_error != '')
					{
						$('#code_error').html(data.code_error);
					}
					else
					{
						$('#code_error').html('');
					}
				}
				if(data.fail)
				{
					$('#success_message').html(data.fail);
					$('#code_error').html('');
					$('#contact_form')[0].reset();

				}
				if(data.success)
				{
					$('#success_message').html(data.success);
					$('#code_error').html('');
					$('#contact_form')[0].reset();
				}
				$('#verify').attr('disabled',false);
			}
		})
	});	


});

</script>