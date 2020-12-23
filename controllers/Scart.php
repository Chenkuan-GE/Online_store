<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scart extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->library('cart');
	}

	function index()
	{
		$this->load->model("Shopping_cart_model");
		$data["products"] = $this->Shopping_cart_model->fetch_all();
		$this->load->view('templates/header_test');
		$this->load->view("shopping_cart",$data);
		$this->load->view('templates/footer');
	}
	

	public function add(){
		$data = array(
	        'id'      => 'sku_123ABC',
	        'qty'     => 1,
	        'price'   => 39.95,
	        'name'    => 'T-Shirt',
	        'options' => array('Size' => 'L', 'Color' => 'Red')
		);

		var_dump($this->cart->insert($data));
	}


	public function session(){
		var_dump($this->session);
	}


	public function get()
	{
		var_dump($this->cart->get_item('0256a32c98ce49afbe2a4eb8c96c5884'));
	}


	public function update()
	{
		$data = array(
        'rowid' => '0256a32c98ce49afbe2a4eb8c96c5884',
        'qty'   => 3
		);

		$this->cart->update($data);	
	}


	public function remove()
	{
		$data = array(
        'rowid' => '0256a32c98ce49afbe2a4eb8c96c5884',
        'qty'   => 3
		);

		$this->cart->remove('0256a32c98ce49afbe2a4eb8c96c5884');	
	}

	

}