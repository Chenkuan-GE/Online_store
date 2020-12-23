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
</style>
</head>
<body>
<div class = 'container box'>
    <h3 align='left'><?php echo $title; ?></h3>
    <div class="table-responsive">
        <br />
        <table id="product_data" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="20%">Image</th>
                    <th style="width:300px">Product</th>
                    <th width="16%">Price</th>
                    <th width="16%">Number</th>
                    <th width="16%">Category</th>
                    <th width="16%">City</th>
                    <th width="16%">Action</th>
                </tr>
            </thead>

        </table>
    </div>	
</div>

<br><br>



</body>
</html>



<script>
$(document).ready(function(){
    var dataTable = $('#product_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"<?php echo base_url().'homepage/fetch_product'; ?>",
            type:"POST"
        },
        "columnDefs":[
            {
                "target": [0,3,4],
                "orderable":false,
            }
        ]
    });
});


</script>