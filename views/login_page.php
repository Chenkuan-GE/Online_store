<?php
defined('BASEPATH') OR exit ('No direct script access allowed');
?><!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="utf-8">
	<title>Welcome to my website</title>
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
	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

    .login_form {
		background-color: #fff;
		margin: auto;
        text-align: center;
        padding: 100px;
		font: 13px/16px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
    }

    h1 {
        color: #444;
		background-color: transparent;
		border-bottom: 0px solid #D0D0D0;
        padding:30px;
		font-size: 25px;
		font-weight: bold;
		margin: 0;
        text-shadow: 5px 5px 5px grey;
    }

    .login_button {
        background-color: rgb(99,137,207);
        margin: 10px 0 10px 0;
        border: none;
        color: white;
        padding: 4px 22px;
        text-align: center;
        text-decoration: none;
        display:inline-block;
        font-size:13px;
        box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 15px 30px 0 rgba(0,0,0,0.19);
    }

    .login_button span 
    {
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: 0.5s;
    }

    .login_button span:after{
        content: '>>';
        position: absolute;
        opacity: 0;
        top: 0;
        right: -20px;
        transition: 0.5s;
    }

    .login_button:hover span{
        padding-right:25px;
    }

    .login_button:hover span:after{
        opacity:1;
        right:0;
    }


    </style>
</head>
<body>
<div id ='loginform' class = 'login_form'>
    <h1> Welcome to my Website!</h1>
    <div id = 'login_information'>
        <?php echo form_open('Welcome/signin')?>
        <p class = 'label'>Username:</p>
        <input type = "text" name = "username" class ='personal_infor' value='<?php echo get_cookie('username');?>' id = 'login_infor'/><br>
        <p class = 'label'>Password:</p>
        <input type ='password' name = 'password' class ='personal_infor' value='<?php echo get_cookie('password');?>' id = 'login_infor'/><br /><br>
        <p id="captImg"><?php echo $captchaImg; ?></p>
        <p>Can't read the image? click <a href="javascript:void(0);" class="refreshCaptcha" >here</a> to refresh</p>
        Enter the Captcha: <input type="text" name="captcha" value="" /><br>
        
    </div>
    <div id ='Loginbtn'>
        <button type ='submit' name = 'submit' class='login_button'><span>Login</span></button>
        <button type ='reset' class = 'login_button'><span>Reset</span></button><br>
        <label><input name = 'remember' type='checkbox' value='1'/>remember me?(auto login)</label><br>
        <a href="<?php echo site_url('Forget/index') ?>"> Forget password?</a>
    </div>
    <div id = 'register'>
        <h5>Register Now if you don't have your account</h5>
        <a href="<?php echo site_url('Register') ?>"> Register</a>
    </div>
    </form>
</div>

</body>
</html>

