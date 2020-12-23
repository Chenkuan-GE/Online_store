<?php

class Papers extends CI_Controller {
    public function read($year = 2018)
    {
        if ( ! file_exists(APPPATH.'views/papers/'.$year.'.php')) {
            show_404();
        }
        $data['year'] = $year;
        $this->load->view('templates/header', $data);
        $this->load->view('papers/'.$year, $data);
        $this->load->view('templates/footer', $data); 
    }
}