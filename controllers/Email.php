<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {

    public function randomkeys($length){
	$output = '';
	$pattern = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
	for($a = 0; $a <$length; $a++){
		$output .= $pattern{mt_rand(0,61)};
	}
	return $output;
    }



    public function send_email()
    {

	$username = $this->session->userdata("username");

	$email = $this->Users_model->check_email($username);
        
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
		$this->session->set_userdata('code',$code);
		$this->session->set_userdata("temname",$username);

                $data = array(
		    array('New Email activion!'),
                    array('Username',$username),
                    array('Email',$email),
		    array('verify(active) the email',$code),
                    array('Active it now! and unlock more functions!')
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
                echo "<script>alert('The Active Email has been sent')</script>";
		$this->load->view('templates/header_test');
                $this->load->view('login/verify2',$data);
                $this->load->view('templates/footer');


    }

}