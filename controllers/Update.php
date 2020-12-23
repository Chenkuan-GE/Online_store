<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends CI_Controller { 


    public function update_products()
    {
        $data['products'] = $this->Products_model->select($this->session->userdata('username'));
        $this->load->view('templates/header_test');
        $this->load->view('upload/update_products',$data);
        $this->load->view('templates/footer');
    }

    public function delete_products()
    {
        $this->load->view('templates/header_test');
        $this->load->view('upload/delete_products');
        $this->load->view('templates/footer');
    }

    public function update_start()
    {
        $name = $this->input->post('name');
        $price = $this->input->post('price');
        $number = $this->input->post('number');
        $category = $this->input->post('category');
        $city = $this->input->post('city');
        $this->Products_model->update($name,$price,$number,$category,$city);
        echo "<script>alert('Congradulations! you have updated information successful :)')</script>";
        $this->load->view('templates/header_test');
        $this->load->view('upload/edit');
        $this->load->view('templates/footer');
    }


    public function delete_start()
    {
        $name = $this->input->post('name');
        $this->Products_model->delete($name);
        echo "<script>alert('Congradulations! you have deleted information successful :)')</script>";
        $this->load->view('templates/header_test');
        $this->load->view('upload/edit');
        $this->load->view('templates/footer');
    }

}