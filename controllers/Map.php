<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Map extends CI_Controller {

	function index(){
		$this->load->view('templates/header_test');
		$this->load->view('map');
		$this->load->view('templates/footer');
	}
}