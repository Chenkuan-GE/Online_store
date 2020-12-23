<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
		$this->load->helper('captcha');
    }

    public function index(){
    	if($this->input->post('submit'))
    	{
    		$inputCaptcha = $this->input->post('captcha');
    		$sessCaptcha = $this->session->userdata('captchaCode');
    		if($inputCaptcha == $sessCaptcha)
    		{
    			echo 'Captcha code matched';
    		}
    		else
    		{
    			echo 'Failed';
    		}
	    }
		$config = array(
	        'img_path'      => './captcha_images/',
	        'img_url'       => base_url().'captcha_images',
	        'font_path'     => 'system/fonts/texb.ttf',
	        'img_width'     => '160',
	        'img_height'    => 50,
	        'word_length'   => 8,
	        'font_size'     => 18,
		);
		$captcha = create_captcha($config);

		$this->session->unset_userdata('captchaCode');
		$this->session->set_userdata('captchaCode',$captcha['word']);

		$data['captchaImg'] = $captcha['image'];
		$this->load->view('templates/header_test');
		$this->load->view('captcha',$data);
		$this->load->view('templates/footer');

    	
    }

    public function refresh()
    {
    	$config = array(
	        'img_path'      => './captcha_images/',
	        'img_url'       => base_url().'captcha_images',
	        'font_path'     => 'system/fonts/texb.ttf',
	        'img_width'     => '160',
	        'img_height'    => 50,
	        'word_length'   => 8,
	        'font_size'     => 18,
		);
		$captcha = create_captcha($config);

		$this->session->unset_userdata('captchaCode');
		$this->session->set_userdata('captchaCode',$captcha['word']);

		echo $captcha['image'];

    }





}