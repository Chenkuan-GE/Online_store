<link href="http://maxcdn.bootstrpcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />

<div class="container">
<br />
<br />
<?php echo validation_errors(); ?>
<?php echo form_open('AJAX/index'); ?>
    <div class="col-md-12 col-md-offset-12 centered">
        <h1 class="text-center">live Search</h1>
        <h4>fix later(manager)</h4>
            <input type="text" name="search" id="search_text" placeholder="Search Users" class="form-control" />
    
    <div id='result'></div>
    </div>
</div>
</body>
</html>


<script>
$(document).ready(function(){
    load_data();
    function load_data(query){
        $.ajax({
            url:"<?php echo base_url(); ?>ajaxsearch/fetch",
            method:"POST",
            data:{query:query},
            success:function(data){
                $('#result').html(data);
            }
        })
    }

    $('#search_text').keyup(function(){
        var search = $(this).val();
        if(search != ''){
            load_data(search);
        }else{
            load_data();
        }
    });

});

</script>



