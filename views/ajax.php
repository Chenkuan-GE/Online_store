

<div class="container">
<?php echo validation_errors(); ?>
<?php echo form_open('AJAX/index'); ?>
<div class="col-md-12 col-md-offset-12 centered">
	<h1 class="text-center">live Search</h1>
        <input type="text" name="search" id="search_text" placeholder="Ajax Search" class="form-control" />
<div class="col-md-12 col-md-offset-6 centered" id="result">
<h3></h3>
<div class="main"> </div>
</div>
<script>
    $(document).ready(function(){
    load_data();
        function load_data(query){
            $.ajax({
            url:"<?php echo base_url(); ?>ajax/fetch",
            method:"POST",
            data:{query:query},
            success:function(response){
                $('#result').html(response);
                if (response == "No Data Found") {
                    $('#result').html(response);
                }else{
                    var obj = JSON.parse(response);
                    if(obj.length>0){
                        var items=[];
                        $.each(obj, function(i,val){
                            items.push($("<h3>").text(val.username));
                            items.push($("<div>").addClass( "main" ).text(val.email));
                    });
                    $('#result').append.apply($('#result'), items);         
                    }else{
                    $('#result').html(response);
                    }; 
                };
            }
        });
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
