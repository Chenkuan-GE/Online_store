<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cookies extends CI_Controller {
    public function index(){
        
        $data['cookie'] = get_cookie('username');

        $this->load->view('templates/header_test');
        $this->load->view('cookies/cookie_view',$data);
        $this->load->view('templates/footer');
    }


    public function deletecookie(){
        delete_cookie('Adrian');

        $data['title'] = 'Cookie';
        $data['cookie'] = $this->input->cookie('Adrian',true);
        $data['cookiearray'][] = $_COOKIE;
        $this->load->view('templates/header_test');
        $this->load->view('cookies/cookie_view',$data);
        $this->load->view('templates/footer');

    }

}

?>