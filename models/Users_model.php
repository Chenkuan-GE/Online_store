<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Users_model extends CI_Model{

        public function test(){
            $query = $this->db->query("SELECT * FROM users");
            return $query->result();
        }

		
		// register information
		public function insert($username,$password,$email,$dob){

			//SQL query
			$data = array(
				'username' => $username,
				'password' => $password,
				'email' => $email,
				'DOB' => $dob
			);
			$this->db->insert('users', $data);
		}


		// update more personal information
		public function update($phone,$sms,$address,$citizenship,$username){

			//SQL query
			$data = array(
				'phone' => $phone,
				'sms' => $sms,
				'address' => $address,
				'citizenship' => $citizenship
			);
			$this->db->where('username',$username);
			$this->db->update('users', $data);
		}

		// user vad
		public function check($username,$password){
			$this->db->where('username',$username);
			$this->db->where('password',$password);
			$result = $this->db->get('users');

			if($result->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkemail($email){
			$this->db->where('email',$email);
			$result = $this->db->get('users');

			if($result->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function active($username){
			$this->db->where('username',$username);
			$query = $this->db->get('users');
			$status = $query->result();
			foreach ($status as $row) {
				$active = $row->activition;
			}
			$active = 1;
			$data = array(
				'activition' => $active
			);
			$this->db->where('username',$username);
			$this->db->update('users', $data);

		}

		public function check_active($username){
			$this->db->where('username',$username);
			$query = $this->db->get('users');
			$status = $query->result();
			foreach ($status as $row) {
				$active = $row->activition;
			}
			if($active == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
			

		}

		public function get_id($username)
		{
			$this->db->where('username',$username);
			$query = $this->db->get('users');
			$data = $query->result();
			foreach ($data as $row) {
				# code...
				$id = $row->userid;
			}
			return $id;
		}


		public function check_email($username){
			$this->db->where('username',$username);
			$query = $this->db->get('users');
			$status = $query->result();
			foreach ($status as $row) {
				$email = $row->email;
			}
			return $email;
		}

		public function newpwd($email,$newpwd)
		{
			$data = array(
				'password' => $newpwd
			);
			$this->db->where('email',$email);
			$this->db->update('users', $data);
		}
		



	} 

	?>