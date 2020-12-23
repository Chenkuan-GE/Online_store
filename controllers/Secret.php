<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Secret extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('encryption');
	}

	public function index(){
		$this->load->view('templates/header_test');
		$this->load->view('secret/question');
    	$this->load->view('templates/footer');
	}

	public function answer()
	{
		$this->load->view('templates/header_test');
		$this->load->view('secret/answer');
    	$this->load->view('templates/footer');
	}

	public function setques()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('code','Question','required');
		$ques = $this->input->post('code');

		if($this->form_validation->run())
		{
			$this->Products_model->setques($ques);
			$array =array(
					'success'  =>  '
					<div class="alert alert-success">The question has been set input your secret answer :)<br><a href="answer">Set Answer</a></div>'	
				);

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


	public function setans(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('code','Answer','required');
		$ans = $this->input->post('code');
		if($this->form_validation->run())
		{
			$this->Products_model->setans($ans);
			$array =array(
				'success'  =>  '<div class="alert alert-success">Successfully! The secret question has set well :)<br><a href="../User_profile/index">Back to Profile</a></div><br>'	
			);

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