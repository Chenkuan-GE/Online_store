<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends CI_Controller {



    public function index(){
	        $data['title'] = "Homepage-show all visitors";

	        $this->load->view('templates/header_test');
	        $this->load->view('homepage',$data);
	        $this->load->view('templates/footer');
    	
    }




    public function fetch_product(){
    	$this->load->model("Home_model");
    	$fetch_data = $this->Home_model->make_datatables();
    	$data = array();
    	foreach($fetch_data as $row)
    	{
    		$sub_array = array();
            if($row->filename != '')
            {
                $sub_array[] = '<img src="'.base_url().'uploads/'.$row->filename.'"class="img-thumnail" width="150" height="120" />';
            }
            else
            {
                $sub_array[] = "No picture uploaded";
            }
    		
    		$sub_array[] = $row->name;
    		$sub_array[] = $row->price;
    		$sub_array[] = $row->number;
    		$sub_array[] = $row->category;
    		$sub_array[] = $row->city;
            $sub_array[] = '<a href="like"><button type="button" class="btn btn-warning btn-xs">Like it</button></a>';
    		$data[] = $sub_array;
    	}

    	$output = array(
    		"draw" 				=> intval($_POST["draw"]),
    		"recordsTotal" 		=> $this->Home_model->get_all_data(),
    		"recordsFiltered" 	=> $this->Home_model->get_filtered_data(),
    		"data" 				=> $data
    	);
    	echo json_encode($output);
	}
	

	public function like(){
        $this->load->view('templates/header_test');
        $this->load->view('like_without');
		$this->load->view('templates/footer');
		
		echo "<script>alert('You have subscribe this product! :)')</script>";
    
    }

    public function like_it(){
        $id = $this->input->post("id");
        $dataset = $this->Products_model->ranking_check($id);
        foreach ($dataset as $row) {
            $ranking = $row->ranking;
            $ranking += 1;
        }
        $this->Products_model->ranking_add($id,$ranking);
    }

    public function index2(){

        $this->load->view('templates/header_test');
        $this->load->view('homepage2');
        $this->load->view('templates/footer');

    }

    public function index3(){

        $data = array("count"=>null, "keyword"=>null, "sort_by"=>null, "records"=>null);
        
        $keyword = $this->input->get('keyword');
        $sort_by = $this->input->get('sort_by');
        
        $data['count'] = $this->Home_model->employee_count();
    
        if(isset($keyword) && isset($sort_by)){
            $data['keyword'] = $keyword;
            $data['sort_by'] = $sort_by;
            $data['records'] = $this->Home_model->department_search($keyword,  $sort_by);
        }
        $this->load->view('templates/header_test');
        $this->load->view('homepage2',$data);
        $this->load->view('templates/footer');

    }

    public function fetch_data(){
        $minimum_price = $this->input->post('minimum_price');
        $maximum_price = $this->input->post('maximum_price');
        $minimum_rank = $this->input->post('minimum_rank');
        $maximum_rank = $this->input->post('maximum_rank');
        $category = $this->input->post('category');
        $city = $this->input->post('city');
        $this->load->library('pagination');
        $config = array();
        $config['base_url'] = '#';
        $config['total_rows'] = $this->Home_model->count_all($minimum_price, $maximum_price, $maximum_rank, $minimum_rank, $category, $city);
        $config['per_page'] = 8;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pegination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='active'><a href='#'>";
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['num_links'] = 3;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $start = ($page - 1)*$config['per_page'];
        $output = array(
            'pagination_link'   =>  $this->pagination->create_links(),
            'product_list'      =>  $this->Home_model->fetch_data($config["per_page"],$start,$minimum_price, $maximum_price, $maximum_rank, $minimum_rank, $category, $city)
        );
        echo json_encode($output);
    }

    public function details(){
        $name = $this->input->post("foods");

        $data['name'] = $name;
        if($this->Products_model->check($name))
        {
            $this->load->view('templates/header_test');
            $this->load->view('details/details', $data);
            $this->load->view('templates/footer');
        }
        else
        {
            $this->load->view('templates/header_test');
            $this->load->view('homepage2');
            $this->load->view('templates/footer');
            echo "<script>alert('No such product exist...')</script>";
        }
        

    }


    public function add_cart(){
        $this->load->library("cart");
        $id = $this->input->post("productid");
        $name = $this->input->post("name");
        $qty = 1;
        $price = $this->input->post("price");

        $data = array(
            "id"            => $id,
            "name"          => $name,
            "qty"        => 1,
            "price"         => $price,
        );
        $this->cart->insert($data);

        

        $this->Shopping_cart_model->insert($name,$price,$qty,$id,$this->session->userdata('username'));
    }

}