<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajaxsearch extends CI_Controller {

    public function index(){
        $this->load->view('templates/header_test');
        $this->load->view('ajaxsearch');
        $this->load->view('templates/footer');
    }

    public function fetch(){
        $output = '';
        $query = '';
        if($this->input->post('query')){
            $query = $this->input->post('query');
        }
        $data = $this->Products_model->fetch_data($query);
        $output .= '
            <div class = "table-responsive">
                <table class ="table table-bordered table-striped">
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone number</th>
                    <th>SMS</th>
                    <th>Address</th>
                    <th>Citizenship</th>
                </tr>
        ';
        if($data->num_rows() > 0){
            foreach($data->result() as $row){
                $output .= '
                        <tr>
                            <td>'.$row->username.'</td>
                            <td>'.$row->email.'</td>
                            <td>'.$row->phone.'</td>
                            <td>'.$row->sms.'</td>
                            <td>'.$row->address.'</td>
                            <td>'.$row->citizenship.'</td>
                        </tr>
                ';
            }
            //echo json_encode ($data->result());
        }else{
            $output .= '<tr>
                            <td colspan="5">No Data Found</td>
                        </tr>';
        }
        $output .= '</table>';
        echo $output;
    }
}