<html>
<head>
	<title>Shopping Cart</title>
	
  	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/3bootstrap.min.css">
	<script src="<?php echo base_url(); ?>assets/js/jquery-3.1.0.min.js"> </script>
</head>
<style>


</style>


<body>
	<div class="container">
		<br/><br />

		<div class="col-lg-6 col-md-6">
			<div class="table-responsive">
				<h3 align="center">Recommended products</h3><br />

				<?php foreach($products as $row): ?>
				
				<div class="col-md-4" style="padding:16px; background-color:#f1f1f1; border:1px solid #ccc; margin-bottom:16px; height:300px; width: 400px" align="center">
					<img src="../uploads/<?php echo $row->filename; ?>" class="img-thumbnail" style="height:120px; width:150px"/><br />
					<h4><?php echo $row->name; ?></h4>
					<h4 class="text-danger">Price: $<?php echo $row->price; ?></h4>
					<input type="text" name="quantity" class="quantity" id="<?php echo $row->productid; ?>" style="width:150px; margin: 0 0 10px 0"/>
					<button type="button" id="add_cart" name="add_cart" class="btn btn-success add_cart" data-productname="<?php echo $row->name; ?>" data-price="<?php echo $row->price; ?>" data-productid="<?php echo $row->productid; ?>" >Add to Cart</button>

				</div>

					
				<?php endforeach; ?>


			</div>
		</div>
		<div class="col-lg-6 col-md-6">
			<div id="cart_details">
				<h3 align="center">Cart is Empty</h3>
			</div>
		</div>


	</div>

</body>
</html>

<script>
	$(document).ready(function(){


		$('.add_cart').click(function(){
			var productid = $(this).data("productid");
			var name = $(this).data("productname");
			var price = $(this).data("price");
			var quantity = $('#' + productid).val();
			if(quantity != '' && quantity > 0)
			{
				$.ajax({
					url:"<?php echo base_url(); ?>Shoppingcart/add",
					method:"POST",
					data:{productid:productid, name:name, price:price, quantity:quantity},
					success:function(data)
					{
						alert("Product Added into Cart");
						$('#cart_details').html(data);
						$('#' + productid).val('');
					}
				});
			}
			else
			{
				alert("Please Enter quantity");
			}
		});

		$('#cart_details').load("<?php echo base_url(); ?>shoppingcart/load");

		$(document).on('click','.remove_inventory',function(){
			var row_id = $(this).attr("id");
			var id = $(this).data("rowid");
			if(confirm("Are you sure to remove?"))
			{
				$.ajax({
					url:"<?php echo base_url(); ?>shoppingcart/remove",
					method:"POST",
					data:{row_id:row_id, id:id},
					success:function(data)
					{
						alert("Product removed from Cart");
						$('#cart_details').html(data);
					}
				});
			}
			else
			{
				return false;
			}
		});


		$(document).on('click','#clear_cart',function(){
			if(confirm("Are you sure to clear cart?"))
			{
				$.ajax({
					url:"<?php echo base_url(); ?>shoppingcart/clear",
					success:function(data)
					{
						alert("Your cart has been clear..");
						$('#cart_details').html(data);
					}
				});
			}
			else
			{
				return false;
			}
		});
	});

</script>