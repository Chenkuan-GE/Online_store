<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">

<style>

.profile {
    background-color: #fff;
    margin: auto;
    text-align: center;
    padding: 100px;
    font: 13px/16px normal Helvetica, Arial, sans-serif;
    color: #4F5155;
}

.loginprofile {
    background-color: #fff;
    margin: auto;
    text-align: left;
    padding: 30px;
    font: 13px/16px normal Helvetica, Arial, sans-serif;
    color: #4F5155;
}

.h2 {
    white-space: nowrap; 
    width: 200px; 
    border: 1px solid #000000;
    overflow: hidden;
    text-overflow: ellipsis; 
}

.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 10px 50px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    cursor: pointer;
}

.login_b {
    background-color: white; 
    color: black; 
    border: 2px solid #008CBA;
}

.login_b:hover {
    background-color: #008CBA;
    color: white;
}

table,th,td {
    border:1px solid black;
    text-align:center;
    width: 550px;
    height: 30px;
}

td {
    padding:5px;
}

th {
    background-color: green;
    border-color: black;
    color: white;
}

p {
    font-family:'Times New Roman';
    font-style: italic;
    font-size:20px;

}

.info {
    left: 10%;
    font-family:'Arial';
    font-style: oblique;
    font-size: 20px;
}

</style>
<body>
    <!-- check the login status(if you are visitor) -->
    <?php if(!$this->session->userdata('logged_in')): ?>
    
    <div class = 'profile'>
        <h2> Welcome to your personal profile :) </h2><br>
        <h4> Seems you haven't logged in yet</h4><br /><br />
        <a href="<?php echo base_url(); ?>Welcome/index">
            <button class = 'button login_b'>Login</button> 
        </a><br><br>
        <h4>if you didn't have your own account? Register one now!</h4><br /><br />
        <a href="<?php echo base_url(); ?>Register/index">
            <button class = 'button login_b'>Register</button> 
        </a>
    </div>
    <?php endif; ?>


<div class = 'loginprofile'>  
    <!-- check the login status(you have logged in) -->
    <?php if($this->session->userdata('logged_in')): ?>
        <div id ='googleMap' align="right " style="left:60%; position:absolute; display: none; width:600px;height:450px;">

        </div>
        <div class = 'info' align="left">    
        <?php 
            echo 'Username: '.$this->session->userdata('username');
            echo '<br><br>';   
            $data['database'] = $this->Users_model->test();
            foreach($data['database'] as $res)
            {
                if($res->username == $this->session->userdata('username')){
                    $email = $res->email;
                    $dob = $res->DOB;
                    $phone = $res->phone;
                    $sms = $res->sms;
                    $address = $res->address;
                    $citizenship = $res->citizenship;
                    $activition = $res->activition;
                    echo 'Email: '.$email.'<br>';
                    echo '<br>';
                    echo 'Date of birth: '.$dob.'<br>';
                    echo '<br>';
                    echo 'phone number: '.$phone.'<br>';
                    echo '<br>';
                    echo 'SMS: '.$sms.'<br>';
                    echo '<br>';
                    echo 'Address: '.$address.'<br>';
                    echo '<br>';
                    echo 'Citizenship: '.$citizenship.'<br><br>';
                    if($activition == 1){
                        echo 'Activition Status: Actived! <br>';
                    }
                    else
                    {
                        echo 'Activition Status: '?> <a href="<?php echo base_url(); ?>Email/send_email"><button class="button">Active now</button></a> <?php
                    }

                }
            }
        ?>
        </div><br><br><br>
        <a href="<?php echo base_url(); ?>User_profile/update"> 
            <button class ='update_info'>update information</button>
        </a><br /><br>
        
            
            <button type="button" class ='update_info' onclick="show()">check map</button>
        
        <br>
        <br>
        

        <div class = 'list'>
        <p>The product you sell on the website:</p>
        <?php
            $productset = $this->Products_model->serach_own($this->session->userdata('username'));
        ?>

        <table>
            <tr>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Product Number</th>
                <th>Product Category</th>
                <th>City of resource</th>
                <th>Image</th>
            </tr>
            <?php foreach($productset as $res): ?>
            <tr>
                <td><?php echo $res->name; ?></td>
                <td><?php echo $res->price; ?></td>
                <td><?php echo $res->number; ?></td>
                <td><?php echo $res->category; ?></td>
                <td><?php echo $res->city; ?></td>
                <?php if($res->filename == NULL): ?>
                    <td><a href='<?php echo base_url(); ?>Upload_file/img'> <button class = 'filename'>upload img</button></a></td>
                <?php endif; ?>
                <?php if($res->filename != NULL): ?>
                    <?php $file = $res->filename;?>
                    <td><img src="../uploads/<?php echo $res->filename; ?>" width="150" height="100"></td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
        
        
        <br><br>

        <div class = 'sell'>
            <a href="<?php echo base_url(); ?>User_profile/upload_pro"><button class = 'button'>Add products</button></a>
            <a href="<?php echo base_url(); ?>User_profile/edit"><button class = 'button'>Show products</button></a><hr>
            <a href="<?php echo base_url(); ?>zip/download"><button class = 'button'>download pictures</button></a><hr>
        </div><br>
        <div class="buttons" align="left">
            <h6>update or delete products</h6>
            <a href="<?php echo base_url(); ?>Update/update_products"><button class="button" id="update">Update</button></a>
            <a href="<?php echo base_url(); ?>Update/delete_products"><button class="button" id="delete">Delete</button></a>
        </div>
        <br><br>
        <!--
        <div class="responsive">
            <div class="img">
                <img src="../uploads/<?php echo $file; ?>" alt="图片文本描述" width="300" height="200">
            </div>
        </div>
        -->
        <p>if you choose 'remember me' and wanna clear your details</p>
        <a href="<?php echo base_url(); ?>Welcome/clear"> 
            <button class = 'button login_b'>Clear login details</button>  
        </a>
        <br><br>
        <a href="<?php echo base_url(); ?>Secret/index"> 
            <button class = 'button login_b'>Set personal secret question</button>  
        </a>
        <br><br>
        <a href="<?php echo base_url(); ?>Welcome/logout"> 
            <button class = 'button login_b'>Logout</button>  
        </a>


    <?php endif; ?>
</div>

</body>
</html>

<script
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBS-NGoGe1KrzyghFvzs-syhYiNdERGi34&sensor=false">
</script>

<script>
function initialize()
{
var mapProp = {
  center:new google.maps.LatLng(-27.4693948,153.0236),
  zoom:5,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };
var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
}

google.maps.event.addDomListener(window, 'load', initialize);


function show(){
    $("#googleMap").css("display","block");
}
</script>