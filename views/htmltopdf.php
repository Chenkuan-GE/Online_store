<!DOCTYPE html>
<html lang="en">
<head>
    <title>Homepage</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
	<div class="container box">
		<br />
		<h3 align="center">PDF part</h3>
		<br />
		<?php
		if(isset($buyer_data))
		{
		?>
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<tr>
					<th>Buyer ID</th>
					<th>Buyer Name</th>
					<th>View</th>
					<th>View in PDF</th>
				</tr>
			<?php 
			foreach($buyer_data->result() as $row)
			{
				echo '
				<tr>
					<td>'.$row->productid.'</td>
					<td>'.$row->name.'</td>
					<td><a href="'.base_url().'HtmltoPDF/details/'.$row->productid.'">View</a></td>
					<td><a href="'.base_url().'HtmltoPDF/pdfdetails/'.$row->productid.'">View in PDF</a></td>
				</tr>';
			}
			?>
			</table>
		</div>
		<?php 
		}
		if(isset($user_details))
		{
			echo $user_details;
		}
		?>
	</div>
</body>
</html>