<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Products_model extends CI_Model{
        // get all data in products
		function __construct() { 
	        $this->proTable   = 'products'; 
	        $this->ordTable = 'orders'; 
    	} 
     
	    /* 
	     * Fetch products data from the database 
	     * @param id returns a single record if specified, otherwise all records 
	     */ 
	    public function getRows($id = ''){ 
	        $this->db->select('*'); 
	        $this->db->from($this->proTable); 
	        $this->db->where('status', '1'); 
	        if($id){ 
	            $this->db->where('productid', $id); 
	            $query  = $this->db->get(); 
	            $result = ($query->num_rows() > 0)?$query->row_array():array(); 
	        }else{ 
	            $this->db->order_by('name', 'asc'); 
	            $query  = $this->db->get(); 
	            $result = ($query->num_rows() > 0)?$query->result_array():array(); 
	        } 
	         
	        // return fetched data 
	        return !empty($result)?$result:false; 
	    } 
	     
	    /* 
	     * Fetch order data from the database 
	     * @param id returns a single record 
	     */ 
	    public function getOrder($id){ 
	        $this->db->select('r.*, p.name as product_name, p.price as product_price, p.currency as product_price_currency'); 
	        $this->db->from($this->ordTable.' as r'); 
	        $this->db->join($this->proTable.' as p', 'p.productid = r.product_id', 'left'); 
	        $this->db->where('r.id', $id); 
	        $query  = $this->db->get(); 
	        return ($query->num_rows() > 0)?$query->row_array():false; 
	    } 
	     
	    /* 
	     * Insert transaction data in the database 
	     * @param data array 
	     */ 
	    public function insertOrder($data){ 
	        $insert = $this->db->insert($this->ordTable,$data); 
	        return $insert?$this->db->insert_id():false; 
	    } 

        public function test_for_all(){
            $query = $this->db->query('SELECT * FROM products');
            return $query->result();
        }


		
        // input data
		public function insert($name,$price,$number,$category,$city,$username){

			//SQL query
			$data = array(
				'name' => $name,
				'price' => $price,
				'number' => $number,
				'category' => $category,
				'city' => $city,
                'username' => $username
			);
			$this->db->insert('products', $data);
		}
		
		// input filename of img
		public function insert_img($name,$filename){
			
			//SQL query
			$data = array(
				'filename' => $filename
			);
			$this->db->where('name',$name);
			$this->db->update('products', $data);
        }
        

        // checking for products of everyuser
        public function serach_own($username){
            $this->db->where('username',$username);
            $query = $this->db->get('products');
            return $query->result();
        }


		// user vad
		public function check_pro($username){
			$this->db->where('username',$username);
			$result = $this->db->get('products');

			if($result->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function check($name){
			$this->db->where('name',$name);
			$result = $this->db->get('products');

			if($result->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}


		// Live serach for products (manager)
		public function fetch_data($query){
			$this->db->select('*');
			$this->db->from('users');

			if($query != ''){
				$this->db->like('username',$query);
				$this->db->or_like('email',$query);
				$this->db->or_like('phone',$query);
				$this->db->or_like('sms',$query);
				$this->db->or_like('address',$query);
				$this->db->or_like('citizenship',$query);
				
			}
			$this->db->order_by('userid','ASC');
			return $this->db->get();
		}


		public function show_data($username){
			$this->db->where('username',$username);
			$query = $this->db->get('products');

				$this->db->like('name');
				$this->db->or_like('price');
				$this->db->or_like('number');
				$this->db->or_like('city');
				$this->db->or_like('ranking');
				$this->db->or_like('filename');
				
			$this->db->order_by('productid','ASC');
			return $query;
		}


		public function select($username){
			$this->db->where('username',$username);
			$query = $this->db->get('products');

			return $query->result();
		}


		// update more personal information
		public function update($name,$price,$number,$category,$city){

			//SQL query
			$data = array(
				'price' => $price,
				'number' => $number,
				'category' => $category,
				'city' => $city
			);
			$this->db->where('name',$name);
			$this->db->update('products', $data);
		}

		public function delete($name)
		{
			$this->db->delete('products', array('name' => $name));
		}


		public function ranking_check($id)
		{
			$this->db->where('productid',$id);
			$query = $this->db->get('products');
			return $query->result();

		}

		public function ranking_add($id,$ranking)
		{
			$data = array(
				'ranking' => $ranking
 			);
			$this->db->where('productid',$id);
			$this->db->update('products', $data);		
		}



		public function comment($name,$message){
			$data = array(
				'comment' => $message,
			);
			$this->db->where('name',$name);
			$this->db->update('products', $data);
		}

		public function getid($id)
		{
			$this->db->where('productid',$id);
			$query = $this->db->get('products');
			return $query->result();
		}



		public function setques($question){
			$data = array(
				'username' => $this->session->userdata('username')
			);
			$this->db->insert('secret',$data);
			$this->db->where('username',$this->session->userdata("username"));
			$data1 = array(
				'question' => $question,
			);
			$this->db->update('secret',$data1);

		}

		public function setans($answer){
			$this->db->where('username',$this->session->userdata("username"));
			$this->load->library('encryption');
			
			$answer = $this->encryption->encrypt($answer);
			$data1 = array(
				'answer' => $answer,
			);
			$this->db->update('secret',$data1);

		}

	} 

	?>