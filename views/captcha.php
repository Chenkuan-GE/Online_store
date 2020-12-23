<!DOCTYPE html>
<html lang="en">
<head>
	<title>Captcha</title>
	<meta charset="utf-8">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
	$(document).ready(function(){
		$('.refreshCaptcha').on('click',function(){
			$.get('<?php echo base_url().'captcha/refresh'; ?>', function(data){
				$('#captImg').html(data);
			});
		});
	});
	</script>

</head>
<body>

	<div class="container">
		<h4>Submit code</h4>
		<p id="captImg"><?php echo $captchaImg; ?></p>
		<p>Can't read the image? click <a href="javascript:void(0);" class="refreshCaptcha" >here</a> to refresh</p>
		<form method="post">
			Enter the code:
			<input type="text" name="captcha" value="" />
			<input type="submit" name="submit" value="SUBMIT" />
		</form>

	</div>

</body>
</html>
