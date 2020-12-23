<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_profile extends CI_Controller {

    public function index(){
        $this->load->view('templates/header_test');
        $this->load->view('user_pro');
        $this->load->view('templates/footer');
        //$this->output->enable_profiler(TRUE);
        
    }



    // upload information of products
    public function upload_pro(){
        $this->load->view('templates/header_test');
        $this->load->view('upload/upload_product');
        $this->load->view('templates/footer');
    }

    // update more personal information
    public function update(){
        $this->load->view('templates/header_test');
        $this->load->view('upload/update_info');
        $this->load->view('templates/footer');
    }

    // edit products
    public function edit(){
        $this->load->view('templates/header_test');
        $this->load->view('upload/edit');
        $this->load->view('templates/footer');
    }


    public function showdata(){
        $output = '';
        $data = $this->Products_model->show_data($this->session->userdata('username'));

        $output .= '
            <div class = "table-responsive">
                <table class ="table table-bordered table-striped">
                <tr>
                    <th width="7%">ID</th>
                    <th width="14%">Product Name</th>
                    <th width="14%">price</th>
                    <th width="14%">Product number</th>
                    <th width="14%">Product category</th>
                    <th width="14%">City</th>
                    <th width="14%">Ranking</th>
                    <th width="14%">Filename</th>
                </tr>
        ';
        if($data->num_rows() > 0){
            foreach($data->result() as $row){
                $output .= '
                        <tr>
                            <td>'.$row->productid.'</td>
                            <td>'.$row->name.'</td>
                            <td>'.$row->price.'</td>
                            <td>'.$row->number.'</td>
                            <td>'.$row->city.'</td>
                            <td>'.$row->category.'</td>
                            <td>'.$row->ranking.'</td>
                            <td><img src="../uploads/'.$row->filename.'" width="150" height="100"></td>
                        </tr>
                ';
            }
            //echo json_encode ($data->result());
        }else{
            $output .= '<tr>
                            <td colspan="5">No Products</td>
                        </tr>';
        }
        $output .= '</table>';
        echo $output;
    }





    public function sell(){
        $this->load->database();
		$name = $this->input->post('name');
        $price = $this->input->post('price');
        $number = $this->input->post('number');
        $category = $this->input->post('category');
        $city = $this->input->post('city');

        if($id_vad = $this->Products_model->check($name)){
            $this->load->view('templates/header_test');
            $this->load->view('upload/upload_product');
            $this->load->view('templates/footer');
            echo "<script>alert('the name of product has been used')</script>";
        }
        else{
            $this->Products_model->insert($name,$price,$number,$category,$city,$this->session->userdata('username'));
            $this->load->view('templates/header_test');
            $this->load->view('user_pro');
            $this->load->view('templates/footer');
            echo "<script>alert('Congradulations! you have uploaded your product successful :)')</script>";
        }

        
    }


    public function update_info(){
        $phone = $this->input->post('phone');
        $sms = $this->input->post('sms');
        $address = $this->input->post('address');
        $citizenship = $this->input->post('citizenship');

        $this->Users_model->update($phone,$sms,$address,$citizenship,$this->session->userdata('username'));
        echo "<script>alert('Congradulations! you have updated information successful :)')</script>";
        $this->load->view('templates/header_test');
        $this->load->view('user_pro');
        $this->load->view('templates/footer');
    }


    public function map(){
        $this->load->view('templates/header_test');
        $this->load->view('map');
        $this->load->view('templates/footer');

    }



}