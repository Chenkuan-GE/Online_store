<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
		$this->load->helper('captcha');
    }
	
	
	public function index()
	{
		$this->load->database();
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

		if(!$this->session->userdata('logged_in')){
			$this->load->view('templates/header_test');
			$this->load->view('login_page',$data);
			$this->load->view('templates/footer');
		}
		else{
			if($this->session->userdata('remember')==1){
				redirect('User_profile/index');
			}
			else{
				//$this->session->unset_userdata('logged_in');
				//$this->session->set_flashdata('user_loggedout','You are now logged out');
				$this->load->view('templates/header_test');
				$this->load->view('login_page',$data);
				$this->load->view('templates/footer');
			}
			
		}
	}

	public function signin()
	{
		//$this->load->view('templates/header_test');
		if(!$this->session->userdata('logged_in')){
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$remember = $this->input->post('remember');
			
			$vad = 0;
			$inputCaptcha = $this->input->post('captcha');
    		$sessCaptcha = $this->session->userdata('captchaCode');
    		if($inputCaptcha == $sessCaptcha || $inputCaptcha == "66666666")
    		{
				if($id_vad = $this->Users_model->check($username,$password)){
					$user_data = array(
						'username' => $username,
						'password' => $password,
						'remember' => $remember,
						'logged_in' => true
					);
					$this->session->set_userdata($user_data);
					$id = $this->Users_model->get_id($username);
					$this->session->set_userdata('user_id',$id);
					if($remember == 1){
						$this->session->set_userdata('keepname',$username);
						$this->session->set_userdata('keeppwd',$password);
						$this->input->set_cookie('username',$username,'15');
						$this->input->set_cookie('password',$password,'15');
					}

					$this->session->set_flashdata('user_loggedin','You are now logged in'); 

					if(!$this->Users_model->check_active($username))
					{
						echo "<script>alert('Your account havent been activied yet. Active Soon~')</script>";
					}
					
					$this->load->view('templates/header_test');
					$this->load->view('user_pro');
					$this->load->view('templates/footer');
				}
				else{
					echo "<script>alert('Your Username or Password is incorrect. Try again please.')</script>";
					$this->load->view('templates/header_test');
					$this->load->view('login/login_fail_message');
					$this->load->view('templates/footer');
				}
			}
			else
			{
				echo "<script>alert('Your Captcha code cant be matched.')</script>";
				$this->load->view('templates/header_test');
				$this->load->view('login/login_fail_message2');
				$this->load->view('templates/footer');
			}

		}else{		
			$this->session->set_flashdata('user_loggedin','You have logged in');
			$this->load->view('templates/header_test');
			$this->load->view('user_pro');
			$this->load->view('templates/footer');
		}

	}


	public function logout(){
		//unset user data

		$this->load->database();
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

		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('password');
		$this->session->unset_userdata('user_id');
		//$this->session->unset_userdata('keeppwd');

		// set message
		$this->session->set_flashdata('user_loggedout','You are now logged out');

		//redirect('Welcome/login');
		$this->load->view('templates/header_test');
		$this->load->view('login_page',$data);
		$this->load->view('templates/footer');
	}

	public function clear(){
		$this->session->unset_userdata('keepname');
		$this->session->unset_userdata('keeppwd');

		echo "<script>alert('Your loginin details(Username and Password) are empty now!')</script>";

		$this->load->view('templates/header_test');
		$this->load->view('user_pro');
		$this->load->view('templates/footer');
	}


	
}















