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
</style>
<body>

<div class = 'profile'>
        <h2> Welcome to your online shopping center :) </h2><br>
        <h4> Seems you haven't logged in yet</h4><br /><br />
        <h4> try login and choose your favourite product</h4><br /><br />
        <a href="<?php echo base_url(); ?>Welcome/index">
            <button class = 'button login_b'>Login</button> 
        </a><br><br>
        <h4>if you didn't have your own account? Register one now!</h4><br /><br />
        <a href="<?php echo base_url(); ?>Register/index">
            <button class = 'button login_b'>Register</button> 
        </a>
</div>