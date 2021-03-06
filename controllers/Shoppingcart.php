<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shoppingcart extends CI_Controller {

	function index()
	{
		$this->load->model("Shopping_cart_model");
		$data["products"] = $this->Shopping_cart_model->fetch_all();
		$this->load->view('templates/header_test');
		$this->load->view("shopping_cart",$data);
		$this->load->view('templates/footer');
	}

	public function add()
	{
		$this->load->library("cart");
		$id = $this->input->post("productid");
        $name = $this->input->post("name");
        $qty = $this->input->post("quantity");
        $price = $this->input->post("price");
		$data = array(
			"id"            => $id,
            "name"          => $name,
            "qty"        => $qty,
            "price"         => $price,
		);

		$this->cart->insert($data);
		$this->Shopping_cart_model->insert($name,$price,$qty,$id,$this->session->userdata('username'));
		echo $this->view();
	}

	function load(){
		echo $this->view();
	}


	function remove(){
		$this->load->library("cart");
		$row_id = $_POST["row_id"];
		$rowid = $this->input->post("id");
		$data = array(
			'rowid' => $rowid,
			'qty' 	=> 0
		);
		$this->cart->update($data);
		$this->Shopping_cart_model->remove($row_id);
		echo $this->view();
	}


	public function clear()
	{
		$this->load->library("cart");
		$this->cart->destroy();
		
		$this->Shopping_cart_model->destroy();
		echo $this->view();
	}

	public function view(){
		$this->load->library("cart");
		$output = '';
		$output .= '
			<h3>Shopping Cart</h3><br />
		    <div class="table-responsive">
		        <div align="right">
		        	<button type="button" id="clear_cart" class="btn btn-warning">Clear Cart</button>
		        </div>
		        <br />
		        <table class="table table-bordered">
		            <tr>
		                    <th width="40%">Name</th>
		                    <th width="15%">Quantity</th>
		                    <th width="15%">Price</th>
		                    <th width="15%">Total</th>
		                    <th width="15%">Action</th>
		            </tr>
		';
		$count = 0;
		foreach($this->cart->contents() as $items)
		{
			$count++;
			$output .= '
			<tr>
				<td>'.$items["name"].'</td>
				<td>'.$items["qty"].'</td>
				<td>'.$items["price"].'</td>
				<td>'.$items["subtotal"].'</td>
				<td><button type="button" id="'.$items["id"].'" data-rowid="'.$items["rowid"].'" name="remove" class="btn btn-danger btn-xs remove_inventory">Remove</button></td>
			</tr>
			';
		}
		$output .= '
			<tr>
				<td colspan="4" align="right">Total</td>
				<td>'.$this->cart->total().'</td>
			</tr>
		</table>
		</div>
		';

		if($count == 0)
		{
			$output = '<h3 align="center">Cart is Empty</h3>';
		}
		return $output;
	}

}