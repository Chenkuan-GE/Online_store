
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min1.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap.min.css">
    <script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"> </script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"> </script>

<style>
   
    .box {
        width:100%;
        background-color: #fff;
        position: absolute;
    }

    .table-responsive
    {
        width:100%;
    }

    .list{
        top:15%;
        position: absolute;
    }

    .search{
        left: 65%;
        top:9%;
        position: absolute;
    }

    table {
    border:1px solid black;
    text-align:center;
    width: 90%;
    height: 200px;
    }

    td {
        border:1px solid black;
        padding:5px;
    }

    th {
        border:1px solid black;
        text-align:center;
        border-color: black;
        color: black;
    }

</style>
</head>
<body>
    <div class = 'search' align="right">
        <?php echo form_open('Homepage/details')?>
        Search for Details: 
        <input type = "text" name = "foods" class ='product'></input>
        <button type ='submit' name = 'submit' class='search_btn'><span>Search!</span></button>
    </div>
    <div class = 'list' align="center">
        <?php
            $productset = $this->Products_model->test_for_all();
        ?>

        <table>
            <tr>
                <th width="15%">Image</th>
                <th width="10%">Product Name</th>
                <th width="10%">Product Price</th>
                <th width="10%">Product Number</th>
                <th width="10%">Product Category</th>
                <th width="10%">City of resource</th>
                <th width="10%">Hotting</th>
                <th width="10%">Details</th>  
            </tr>
            <?php foreach($productset as $res): ?>
            <tr>
                <?php if($res->filename == NULL): ?>
                    <td>No picture yet</td>
                <?php endif; ?>
                <?php if($res->filename != NULL): ?>
                    <?php $file = $res->filename;?>
                    <td><img src="../uploads/<?php echo $res->filename; ?>" width="150" height="120"></td>
                <?php endif; ?>
                <td><?php echo $res->name; ?></td>
                <td><?php echo "$".$res->price; ?></td>
                <td><?php echo $res->number; ?></td>
                <td><?php echo $res->category; ?></td>
                <td><?php echo $res->city; ?></td>
                <td><?php echo $res->ranking; ?></td>
                <td><button type="button" id="details" name="details" class="btn btn-success details" data-productname="<?php echo $res->name; ?>" data-number="<?php echo $res->number; ?>" data-category="<?php echo $res->category; ?>" data-city="<?php echo $res->city; ?>" data-ranking="<?php echo $res->ranking; ?>" data-price="<?php echo $res->price; ?>" data-productid="<?php echo $res->productid; ?>" >Add to Cart</button></td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>


</body>
</html>



<script>
$(document).ready(function(){
    $('.details').click(function(){
            var productid = $(this).data("productid");
            var name = $(this).data("productname");
            var price = $(this).data("price");
            $.ajax({
                url:"<?php echo base_url(); ?>Homepage/add_cart",
                method:"POST",
                data:{productid:productid, name:name, price:price},
                success:function(data)
                {
                    alert("Product Added into Cart, you can check it in your cart")
                }
            });
            
    });



});




</script>