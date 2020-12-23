<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
		$this->load->view('testpush');
	}


	public function process(){
		require __DIR__ . '/vendor/autoload.php';

		$options = array(
	    'cluster' => 'ap1',
	    'useTLS' => true
		);
		$pusher = new Pusher\Pusher(
		'b640573266f71143cb9f',
		'db4e2d67652315c4d4e5',
		'1009873',
		$options
		);

		$data['message'] = $_POST['message'];
		$pusher->trigger('ci_pusher', 'my-event', $data);
	}

}