<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_file extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        $this->load->view('templates/header_test');
        $this->load->view('upload/upload_form', array('error' => ' '));
        $this->load->view('templates/footer');
    }
    public function do_upload() {
        $config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = 1000;
		$config['max_width'] = 1024;
		$config['max_height'] = 768;
        $this->load->library('upload', $config);
        
		if ( ! $this->upload->do_upload('userfile')) {
            $this->load->view('templates/header_test');
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('upload/upload_form', $error);
            $this->load->view('templates/footer');
        } else {
            $data = array('upload_data' => $this->upload->data());
            $this->load->view('templates/header_test');
            $this->load->view('upload/upload_success', $data);
            $this->load->view('templates/footer');
        }
    }

    public function img(){
        $this->load->view('templates/header_test');
        $this->load->view('upload/upload_img');
        $this->load->view('templates/footer');
    }

    public function upload_img() {
        $config['upload_path'] = './uploads';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = 1000;
		$config['max_width'] = 1024;
		$config['max_height'] = 768;
        $this->load->library('upload', $config);
        
        
        $name = $this->input->post('name');
		if ( ! $this->upload->do_upload('userfile')) {
            $this->load->view('templates/header_test');
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('upload/upload_form', $error);
            $this->load->view('templates/footer');
        } else {
            $data = array('upload_data' => $this->upload->data());
            $i = 0;
            foreach($data['upload_data'] as $item => $value){   
                $i += 1;
                if($i == 1){
                    $filename = $value;
                    
                break;
                }
            }
            $data['filename'] = $filename;
            
            $this->Products_model->insert_img($name,$filename);
            echo "<script>alert('Congradulations! you have put img successful :)')</script>";
            $this->load->view('templates/header_test');
            $this->load->view('user_pro');
            $this->load->view('templates/footer');
        }
    }
    
    
}