<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manipulation_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
        $this->load->helper(array('form', 'url'));
    }

    public function index(){
        $this->load->view('templates/header_test');
        $this->load->view('manipulation_view');
        $this->load->view('templates/footer');
    }

    public function value(){
        if($this->input->post('submit')){
            $config = array(
                'upload_path' => 'uploads/',
                'upload_url' => base_url()."uploads/",
                'allowed_types' => 'gif|jpg|png|jpeg|pdf'
            );

            $this->load->library('upload',$config);
            if($this->upload->do_upload()){
                $image_data = $this->upload->data();

            }

            switch($this->input->post('mode')){
                case 'watermark':
                    $data = $this->water_marking($image_data);
                    $this->load->view('templates/header_test');
                    $this->load->view('manipulation_view',$data);
                    $this->load->view('templates/footer');
                    break;
                
            }


        }
    }


    public function water_marking($image_data){
        $img = substr($image_data['full_path'],25);
        $config['image_library'] = 'gd2';
        $config['source_image'] = $image_data['full_path'];
        $config['wm_text'] = $this->load->post('text');
        $config['wm_type'] = 'text';
        $config['wm_font_size'] = '50';
        $config['wm_font_color'] = '#707A7C';
        $config['wm_hor_aligment'] = 'center';
        $config['new_image'] = './uploads/watermark_'.$img;

        $this->image_lib->initialize($config);
        $src = $config['new_image'];
        $data['watermark_image'] = substr($str,2);
        $data['watermark_image'] = base_url().$data['watermark_image'];
        $this->image_lib->watermark();
        return $data;


    }

}