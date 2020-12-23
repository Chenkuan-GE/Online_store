<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Test</title>
</head>
<body>

	<form class="form" action="<?php echo base_url(); ?>Test/process" method="post">
		<input type="text" name="message" value="">
		<button type="submit" name="button">Submit</button>
	</form>

	<script src="https://js.pusher.com/6.0/pusher.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
	<script type="text/javascript">
		
		$('.form').submit(function(e){

			e.preventDefault();

			$.ajax({

				url: $(this).attr('action'),
				type: 'post',
				data: new FormData($(this)[0]),
				contentType: false,
				processData: false,
				success: function(data)
				{
					alert(data);
				}
			});

		});

		// Enable pusher logging - don't include this in production
	    Pusher.logToConsole = true;

	    var pusher = new Pusher('b640573266f71143cb9f', {
	      cluster: 'ap1'
	    });

	    var channel = pusher.subscribe('ci_pusher');
	    channel.bind('my-event', function(data) {
	      alert(JSON.stringify(data));
		});


	</script>

</body>
</html>