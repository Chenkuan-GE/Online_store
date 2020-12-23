<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
/* 
| ------------------------------------------------------------------- 
|  Stripe API Configuration 
| ------------------------------------------------------------------- 
| 
| You will get the API keys from Developers panel of the Stripe account 
| Login to Stripe account (https://dashboard.stripe.com/) 
| and navigate to the Developers >> API keys page 
| 
|  stripe_api_key            string   Your Stripe API Secret key. 
|  stripe_publishable_key    string   Your Stripe API Publishable key. 
|  stripe_currency           string   Currency code. 
*/ 
$config['stripe_api_key']         = 'sk_test_2ltjeP5cMtB0FVjrA5pqZjVY00DgCMqqEG'; 
$config['stripe_publishable_key'] = 'pk_test_U4l153bQ6JFxSOhmcVzG98Sk00o0YPCVgA'; 
$config['stripe_currency']        = 'aud';