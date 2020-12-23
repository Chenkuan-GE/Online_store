<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function index(){
        $this->load->view('templates/header_test');
        $this->load->view('login/register');
        $this->load->view('templates/footer');
    }


    private function password_strength($string){
        $h = 0;
        $size = strlen($string);
        foreach(count_chars($string,1) as $v){
            $p = $v/$size;
            $h -= $p * log($p)/log(2);
        }

        $strength = ($h/4)*100;
        if($strength > 100){
            $strength = 100;
        }

        return $strength;

    }
	
    public function randomkeys($length){
	$output = '';
	$pattern = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
	for($a = 0; $a <$length; $a++){
		$output .= $pattern{mt_rand(0,61)};
	}
	return $output;
    }


    public function regis(){
        $this->load->database();
		$username = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $dob = $this->input->post('DOB');

        $check_status = 1;

        if($username != NULL && $password != NULL && $email != NULL && $dob != NULL){
            // check the password strength
            if(strlen($password) >= 25){
                echo "<script>alert('The length of password should not over 24')</script>";
                $this->load->view('templates/header_test');
                $this->load->view('login/register');
                $this->load->view('templates/footer');
                $check_status = 0;
            }

            // The username and email should be unique
            if($check_status == 1){
                $data['database'] = $this->Users_model->test();
                foreach($data['database'] as $res)
                {
                    if($res->username == $username){
                        $check_status = 0;
                        echo "<script>alert('The Username has been registered, try others :)')</script>";
                        $this->load->view('templates/header_test');
                        $this->load->view('login/register');
                        $this->load->view('templates/footer');
                    }
                    if($res->email == $email && $check_status == 1){
                        $check_status = 0;
                        echo "<script>alert('The Email has been registered, try others :)')</script>";
                        $this->load->view('templates/header_test');
                        $this->load->view('login/register');
                        $this->load->view('templates/footer');
                    }
                }

            }


            //check the email format
            if($check_status == 1){
                if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)){
                    echo "<script>alert('The Email address is not valid')</script>";
                    $check_status = 0;
                    $this->load->view('templates/header_test');
                    $this->load->view('login/register');
                    $this->load->view('templates/footer');
                }
            }

            if($check_status == 1){

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
		$this->session->set_userdata("code",$code);
		$this->session->set_userdata("temname",$username);
                $data = array(
		    array('New user information table'),
                    array('Username',$username),
                    array('Email',$email),
		    array('DOB',$dob),
		    array('verify(active) the email',$code),
                    array('Congradulations! you have registered successfully!')
                );
                $message = $this->table->generate($data);

                $this->load->library('email', $config);
                $this->email->from('chenkuan.ge@uqconnect.edu.au');
                $this->email->to($email);
                $this->email->cc('chenkuan.ge@uqconnect.edu.au');
                $this->email->subject('Web information Systems Email Test');
                $this->email->message($message);
                $this->email->send();
                $this->email->print_debugger();
                echo "<script>alert('The register success Email sent and try active it now~')</script>";
            }
            


            // if everything of registion all good
            if($check_status == 1){
                $this->Users_model->insert($username,$password,$email,$dob);
                $ps_valid = $this->password_strength($password);

                


                if($ps_valid >= 90 && $ps_valid <= 100){
                    $password_protect = 'very strong';
                }
                if($ps_valid >=70 && $ps_valid < 90)
                {
                    $password_protect = 'strong';
                }
                if($ps_valid >=40 && $ps_valid < 70)
                {
                    $password_protect = 'medimum';
                }
                if($ps_valid < 40)
                {
                    $password_protect = 'weak';
                }
                echo "<script>alert('Your password strength is $password_protect')</script>";
		$data['code'] = $this->session->userdata("code");
                $this->load->view('templates/header_test');
                $this->load->view('login/verify',$data);
                $this->load->view('templates/footer');
                echo "<script>alert('Congradulations! you have registered successful :)')</script>";

            }
            
        }
        else{
            echo "<script>alert('You missed some key information. regiter again please.')</script>";
            $this->load->view('templates/header_test');
            $this->load->view('login/register');
            $this->load->view('templates/footer');
        }
    }



}