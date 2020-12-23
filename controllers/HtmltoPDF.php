<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HtmltoPDF extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('htmltopdf_model');
		$this->load->library('pdf');
	}

	public function index()
	{
		$data['buyer_data'] = $this->htmltopdf_model->fetch();
		$this->load->view('htmltopdf',$data);
	}

	public function details()
	{
		if($this->uri->segment(3))
		{
			$userid = $this->uri->segment(3);
			$data['user_details'] = $this->htmltopdf_model->fetch_single_details($userid);
			$this->load->view('htmltopdf',$data);
		}
	}

	public function pdfdetails()
	{
		if($this->uri->segment(3))
		{
			$userid = $this->uri->segment(3);
			$html_content = '<h1 align="center">Receipt PDF</h1>';
			$html_content .= '<h3 class="success">Your Payment has been Successful!</h3>';
			$html_content .= $this->htmltopdf_model->get_single_details($userid);
			$this->pdf->loadHtml($html_content);
			$this->pdf->render();
			$this->pdf->stream("".$userid.".pdf", array("Attachment"=>0));
		}
	}



}