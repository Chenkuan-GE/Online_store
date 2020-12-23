<?php
class Shopping_cart_model extends CI_Model{

	function fetch_all(){
		$query = $this->db->get("products");
		return $query->result();
	}

	public function insert($name,$price,$qty,$id,$username){

		//SQL query
		$data = array(
			'name' => $name,
			'price' => $price,
			'qty' => $qty,
			'username' => $username,
			'id' => $id,
		);
		$this->db->insert('scart', $data);
	}

	public function remove($id)
	{

		$username = $this->session->userdata("username");
		$this->db->where('username',$username);
		$this->db->delete('scart', array('id' => $id));
	}

	public function destroy()
	{
		$username = $this->session->userdata("username");
		$this->db->delete('scart', array('username' => $username));
	}

}