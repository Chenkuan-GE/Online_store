<!DOCTYPE html>
<html lang="en">
<head>
    <title>Homepage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2 class="text-center">Homepage</h2>
    <hr>
    
    <?php echo form_open('Homepage/details')?>
        Search for Details: 
        <input type = "text" name = "foods" class ='product'></input>
        <button type ='submit' name = 'submit' class='search_btn'><span>Search!</span></button>
    </form>
    <hr>
    <?php echo form_open('Homepage/index3', array('method'=>'get'))?>

    <div class="row">
        <div class="col-4 form-inline">
            <label for="department_name">Product(Category) Name:&nbsp;</label>
            <input size='5' id="department_name" type="text" class="form-control" name="keyword" value="<?php if(isset($keyword)) echo $keyword//write your own code here ?>">
        </div>



        <div class="col-4 form-inline">
            <div class="form-group">
                <label for="number_sort">Price Sorted in:&nbsp;</label>
                <select name="sort_by" id="number_sort" class="form-control" >
                    <option <?php if($sort_by=="asc"){ ?>selected="selected"<?php } //write your own code here ?> value="asc">Ascending</option>
                    <option <?php if($sort_by=="desc"){ ?>selected="selected"<?php } //write your own code here ?>  value="desc">Descending</option>
                </select>
            </div>
        </div>

        <div class="col-2">
            <button type="submit"  class="btn btn-primary" >Search</button>

        </div>

        <div class="col-2 form-inline">
            <label for="records_number"># Records:&nbsp;<?php if(isset($records)) echo sizeof($records)?></label>
        </div>


    </div>
    </form>

    <hr>

    <table class="table table-striped text-center">
        <thead>
        <tr>
            <th>Product Image</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>number</th>
            <th>Price</th>
            <th>Add to Cart</th>
            <th>Purchase</th>
        </tr>
        </thead>
        <tbody>
        
        <?php if(isset($records))
        {
            foreach($records as $row){?>              
                <tr> 
                    <?php if($row->filename == NULL): ?>
                        <td>No picture yet</td>
                    <?php endif; ?>
                    <?php if($row->filename != NULL): ?>
                        <?php $file = $row->filename;?>
                        <td><img src="../uploads/<?php echo $row->filename; ?>" width="150" height="120"></td>
                    <?php endif; ?>
                    <td><?php echo $row->category?></td>
                    <td><?php echo $row->name?></td>
                    <td><?php echo $row->number?></td>
                    <td><?php echo $row->price?></td>
                    <td><button type="button" id="details" name="details" class="btn btn-success details" data-productname="<?php echo $row->name; ?>" data-price="<?php echo $row->price; ?>" data-productid="<?php echo $row->productid; ?>" >Add to Cart</button></td>
                    <td><a href="<?php echo base_url('product/purchase/'.$row->productid); ?>"><button type="button" id="purchase" name="purchase" class="btn btn-success purchase" data-productname="<?php echo $row->name; ?>" data-price="<?php echo $row->price; ?>" data-productid="<?php echo $row->productid; ?>" >Purchase</button></a></td>
                </tr>
            <?php
            }
        }?>
        <?php if(!isset($records))
        {
            $productset = $this->Products_model->test_for_all();
            foreach($productset as $row){?>              
            <tr> 
                <?php if($row->filename == NULL): ?>
                    <td>No picture yet</td>
                <?php endif; ?>
                <?php if($row->filename != NULL): ?>
                    <?php $file = $row->filename;?>
                    <td><img src="../uploads/<?php echo $row->filename; ?>" width="150" height="120"></td>
                <?php endif; ?>
                <td><?php echo $row->category?></td>
                <td><?php echo $row->name?></td>
                <td><?php echo $row->number?></td>
                <td><?php echo $row->price?></td>

                <td><button type="button" id="details" name="details" class="btn btn-success details" data-productname="<?php echo $row->name; ?>" data-price="<?php echo $row->price; ?>" data-productid="<?php echo $row->productid; ?>" >Add to Cart</button></td>
                <td><a href="<?php echo base_url('product/purchase/'.$row->productid); ?>"><button type="button" id="purchase" name="purchase" class="btn btn-success purchase" data-productname="<?php echo $row->name; ?>" data-price="<?php echo $row->price; ?>" data-productid="<?php echo $row->productid; ?>" >Purchase</button></a></td>
            </tr>
        <?php
            }
        }?>
        </tbody>
    </table>
    <h6> The total number of products in whole store is <?php if(isset($count))echo $count;#->employee_count;?>.</h6>
</div>

</body>

</html>

<script>
$(document).ready(function(){
    $('.details').click(function(){
            var productid = $(this).data("productid");
            var name = $(this).data("productname");
            var price = $(this).data("price");
            alert("Product Added into Cart, you can check it in your cart");
            $.ajax({
                url:"<?php echo base_url(); ?>Homepage/add_cart",
                method:"POST",
                data:{productid:productid, name:name, price:price},

                success:function(data)
                {
                    //alert("Product Added into Cart, you can check it in your cart");
                }
            });
            
    });



});




</script>