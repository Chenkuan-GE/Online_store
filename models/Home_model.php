<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Home_model extends CI_Model{
		var $table = 'products';
		var $select_column = array("productid","name","price","number","category","city","filename");

		var $order_column = array(null,"name","price","number","category","city",null);

		function make_query(){
			$this->db->select($this->select_column);
			$this->db->from($this->table);
			if(isset($_POST["serach"]["value"]))
			{
				$this->db->like("name",$_POST["serach"]["value"]);
				$this->db->or_like("price",$_POST["serach"]["value"]);
				$this->db->or_like("number",$_POST["serach"]["value"]);
				$this->db->or_like("category",$_POST["serach"]["value"]);
				$this->db->or_like("city",$_POST["serach"]["value"]);
			}
			if(isset($_POST["order"]))
			{
				$this->db->order_by($this->order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
			}
			else{
				$this->db->order_by("productid","DESC");
			}
		}


		function make_datatables(){
			$this->make_query();
			if($_POST["length"] != -1){
				$this->db->limit($_POST["length"],$_POST["start"]);
			}
			$query = $this->db->get();
			return $query->result();
		}

		function get_filtered_data(){
			$this->make_query();
			$query = $this->db->get();
			return $query->num_rows();
		}

		function get_all_data()
		{
			$this->db->select("*");
			$this->db->from($this->table);
			return $this->db->count_all_results();
		}


		function select($name)
		{	
			$this->db->where('name',$name);
			$query = $this->db->get('products');
			return $query->result();
		}



		function fetch_filter_type($type)
		{
			$this->db->distinct();
			$this->db->select($type);
			$this->db->from('products');
			#$this->db->where('product_status','1');
			return $this->db->get();
		}


		function make_querys($minimum_price, $maximum_price, $maximum_rank, $minimum_rank, $category, $city){
			$query = "SELECT * FROM products";

			if(isset($minimum_price, $maximum_price) && !empty($minimum_price) && !empty($maximum_price))
			{
				$query .= "AND price BETWEEN '".$_POST["minimum_price"]."'AND'".$_POST["maximum_price"]."'";
			}

			if(isset($minimum_rank, $maximum_rank) && !empty($minimum_rank) && !empty($maximum_rank))
			{
				$query .= "AND ranking BETWEEN '".$_POST["minimum_rank"]."'AND'".$_POST["maximum_rank"]."'";
			}


			if(isset($category))
			{
				$category_filter = implode("','",$category);
				$query .= "AND category IN('".$category_filter."')";

			}

			if(isset($city))
			{
				$city_filter = implode("','",$city);
				$query .= "AND city IN('".$city_filter."')";

			}

			return $query;

		}


		function count_all($minimum_price, $maximum_price, $maximum_rank, $minimum_rank, $category, $city)
		{
			$query = $this->make_querys($minimum_price, $maximum_price, $maximum_rank, $minimum_rank, $category, $city);
			$data = $this->db->query($query);
			return $data->num_rows();
		}


		function fetch_data($limit, $start, $minimum_price, $maximum_price, $maximum_rank, $minimum_rank, $category, $city)
		{
			$query = $this->make_querys($minimum_price, $maximum_price, $maximum_rank, $minimum_rank, $category, $city);
			$query .= ' LIMIT '.$start.', ' .$limit;

			$data = $this->db->query($query);
			$output = '';
			if($data->num_rows() > 0)
			{
				foreach ($data->result_array() as $row) {
					# code...
					
					$output .= '
					<div class="col-sm-4 col-lg-3 col-md-3">
						<div style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; height:450px;">
							<img src="'.base_url().'../uploads/'. $row['filename'].'" alt="" class="img-responsive">
							<p align="center"><strong><a href="#">'.$row['name'].'</a></strong></p>
							<h4 style="text-align:center;" class="text-danger" >'. $row['price'] .'</h4>
							<p> Category: '.$row['category'].' <br />
								City: '.$row['city'].' <br /></p>
						</div>
					</div>
					';
				}
			}
			else
			{
				$output = '<h3>No Data Found</h3>';
			}
			return $output;
		}



		public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function employee_count(){

        // --------------------------------
        // START WRITING YOUR OWN CODE HERE
        $this->db->select("*");
        $this->db->from("products");
        return $this->db->count_all_results();


        // --------------------------------
        // Uncomment the following line when you finished your Query builder
        //return $query->row();
    }

    public function department_search($keyword, $order){
        // --------------------------------
        // START WRITING YOUR OWN CODE HERE
        $query = $this->db->query("SELECT filename, 
        	name,
        	number,
        	category,
        	productid,
        	price
            FROM products");


        if($keyword != '')
        {
    	
            $query = $this->db->query("SELECT filename, 
        	name,
        	number,
        	category,
        	productid,
        	price 
            FROM products
            WHERE name LIKE '%$keyword%' OR category LIKE '%$keyword%'");
        
            if($order == "asc")
            {
                $query = $this->db->query("SELECT filename, 
	        	name,
	        	number,
	        	category,
	        	productid,
	        	price 
                FROM products
                WHERE name LIKE '%$keyword%' OR category LIKE '%$keyword%' ORDER BY price ASC");
            }
            if($order == "desc")
            {
                $query = $this->db->query("SELECT filename, 
	        	name,
	        	number,
	        	category,
	        	productid,
	        	price 
                FROM products
                WHERE name LIKE '%$keyword%' OR category LIKE '%$keyword%' ORDER BY price DESC");
            } 
        }     
        else
        {
            if($order == "asc")
            {
                $query = $this->db->query("SELECT filename, 
	        	name,
	        	number,
	        	category,
	        	productid,
	        	price 
                FROM products 
                ORDER BY price ASC");
            }
            if($order == "desc")
            {
                $query = $this->db->query("SELECT filename, 
	        	name,
	        	number,
	        	category,
	        	productid,
	        	price 
                FROM products
                ORDER BY price DESC");
            } 


        }

        // --------------------------------
        // Uncomment the following line when you finished your Query builder
        return $query->result();


    	}



	}
