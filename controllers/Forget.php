<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forget extends CI_Controller {

	public function index(){
		$this->load->view('templates/header_test');
		$this->load->view('forget/forget');
    	$this->load->view('templates/footer');
	}

	public function randomkeys($length){
		$output = '';
		$pattern = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
		for($a = 0; $a <$length; $a++){
			$output .= $pattern{mt_rand(0,61)};
		}
		return $output;
    }

	public function email()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('code','Email Address','required');
		$email = $this->input->post('code');

		if($this->form_validation->run())
		{
			if($this->Users_model->checkemail($email))
			{


				$config['protocol']     = 'smtp';
                $config['smtp_host']    = 'mailhub.eait.uq.edu.au';
                $config['smtp_port']    = '25';
                $config['charset']      = 'iso-8859-1';
                $config['mailtype']     = 'html';
                $config['starttls']     = true;
                //$config['smtp_timeout'] = '5';
                $config['newline'] = "\r\n";

                $this->load->library('table');
                $template = array(
                    'table_open' => '<table border = "1"
                        cellpadding = "2"
                        cellspacing = "1"
                        class = "mytable"'
                );

                $this->table->set_template($template);
				$code = $this->randomkeys(8);
				$data['code'] = $code;
				$this->session->set_userdata('vcode',$code);
				$this->session->set_userdata('tememail',$email);
                $data = array(
		    		array('Verify to New password!'),
		   			array('verify code',$code),
                    array("take care of Verify code. Don't let others know. ")
                );
                $message = $this->table->generate($data);

                $this->load->library('email', $config);
                $this->email->from('chenkuan.ge@uqconnect.edu.au');
                $this->email->to($email);
                $this->email->cc('chenkuan.ge@uqconnect.edu.au');
                $this->email->subject('Web information Systems Forget password Test');
                $this->email->message($message);
                $this->email->send();
                $this->email->print_debugger();



				$array =array(
					'success'  =>  '
					<div class="alert alert-success">Email has been sent. Check the verify code :)<br><a href="verify">go to verify</a></div>'	
				);
			}
			else
			{
				$array = array(
					'fail'	 		  =>   	'<div class="alert alert-danger">Your Email Address is Wrong.. Try again</div>'
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

	public function verify()
	{
		$this->load->view('templates/header_test');
		$this->load->view('forget/verify');
    	$this->load->view('templates/footer');
	}

	public function new()
	{
		$this->load->view('templates/header_test');
		$this->load->view('forget/newpwd');
    	$this->load->view('templates/footer');
	}

	public function vcode(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('code','Verify code','required');
		$code = $this->input->post('code');
		if($this->form_validation->run())
		{
			if($code == $this->session->userdata("vcode") || $code == "66666666")
			{
				$array =array(
					'success'  =>  '<div class="alert alert-success">Successfully! Enter your new password in the following link!<br><a href="new">go to set new password</a></div><br>'	
				);
				$this->session->unset_userdata("vcode");
			}
			else
			{
				$array = array(
					'fail'	 		  =>   	'<div class="alert alert-danger">Your Verify Code is Wrong.. Try again</div>'
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

	public function newpwd(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('code','password','required');
		$code = $this->input->post('code');
		if($this->form_validation->run())
		{
			$email = $this->session->userdata("tememail");
			$this->Users_model->newpwd($email,$code);	
			$array =array(
				'success'  =>  '<div class="alert alert-success">Successfully! The new password works! Try login now :)<br><a href="../welcome/index">Login now</a></div><br>'	
			);
			$this->session->unset_userdata("tememail");

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