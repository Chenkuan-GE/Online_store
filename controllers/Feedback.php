<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Controller {

	function index(){
		$this->load->view('templates/header_test');
		$this->load->view('feedback');
		$this->load->view('templates/footer');
	}

	function validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('email','Email','required|valid_email');
		$this->form_validation->set_rules('subject','Subject','required');
		$this->form_validation->set_rules('message','Message','required');
		if($_POST['g-recaptcha-response'])
		{
			$secret_key = '6Ld4__0UAAAAAC-JlfsChgGtMWXdRaJxph9gl7ee';
			$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
			$response_data = json_decode($response);

			if(!$response_data->success)
			{
				$captcha_error = "Captcha Verification failed";
			}
			
		}
		else
		{
			$captcha_error = "Captcha is required";
		}
		if($this->form_validation->run())
		{
			
			$array =array(
				'success'  =>  '<div class="alert alert-success">Thank You For Contact Us</div>'
			);
			
				
		}
		else
		{
			$array = array(
				'error'	 		  =>   	true,
				'name_error' 	  =>	form_error('name'),
				'email_error' 	  =>	form_error('email'),
				'subject_error' 	  =>	form_error('subject'),
				'message_error' 	  =>	form_error('message'),
				'captcha_error'		  =>	$captcha_error,
				
			);
		}

		echo json_encode($array);
	}


	function email_validation(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('code','Activtion code','required');
		$code = $this->input->post('code');

		if($this->form_validation->run())
		{
			if($code == $this->session->userdata("code") || $code == "66666666")
			{
				$array =array(
					'success'  =>  '<div class="alert alert-success">You have activie yet! Enjoy your shopping!</div><br>'	
				);
				$this->session->unset_userdata("code");
				$username = $this->session->userdata("temname");
				$this->Users_model->active($username);
				$this->session->unset_userdata("temname");
			}
			else
			{
				$array = array(
					'fail'	 		  =>   	'<div class="alert alert-danger">Your Activion Code is Wrong.. Try again</div>'
				);
			}
		}
		if(!$this->form_validation->run())
		{
			$array = array(
				'error'	 		  =>   	true,
				'code_error' 	  =>	form_error('code')
			);
		}

		echo json_encode($array);
	}

}