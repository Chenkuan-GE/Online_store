<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	function __construct() { 
        parent::__construct(); 
         
        // Load Stripe library 
        $this->load->library('stripe_lib'); 
        //$this->load->library('encrypt');
         
    } 

     
    function purchase($id){ 
        $data = array(); 
         
        // Get product data from the database 
        $product = $this->Products_model->getRows($id); 
         
        // If payment form is submitted with token 
        if($this->input->post('stripeToken')){ 
            // Retrieve stripe token and user info from the posted form data 
            $postData = $this->input->post(); 
            $postData['product'] = $product; 
             
            // Make payment 
            $paymentID = $this->payment($postData); 
             
            // If payment successful 
            if($paymentID){ 
                redirect('Product/payment_status/'.$paymentID); 
            }else{ 
                $apiError = !empty($this->stripe_lib->api_error)?' ('.$this->stripe_lib->api_error.')':''; 
                $data['error_msg'] = 'Transaction has been failed!'.$apiError; 
            } 
        } 
         
        // Pass product data to the details view 
        $data['product'] = $product; 
        $this->load->view('templates/header_test');
        $this->load->view('products/details', $data);
        $this->load->view('templates/footer'); 
    } 
     
    function payment($postData){ 
         
        // If post data is not empty 
        if(!empty($postData)){ 
            // Retrieve stripe token and user info from the submitted form data 
            $token  = $postData['stripeToken']; 
            $name = $postData['name']; 
            $email = $postData['email']; 
            //$key = "super-secret-key";
            //$nameen = $this->encrypt->encode($name,$key); 



            $orderID = strtoupper(str_replace('.','',uniqid('',true)));
             
            // Add customer to stripe 
            $customer = $this->stripe_lib->addCustomer($email, $token); 
             
            if($customer){ 
                // Charge a credit or a debit card 
                $charge = $this->stripe_lib->createCharge($customer->id, $postData['product']['name'], $postData['product']['price']); 
                 
                if($charge){ 
                    // Check whether the charge is successful 
                    if($charge['amount_refunded'] == 0 && empty($charge['failure_code']) && $charge['paid'] == 1 && $charge['captured'] == 1){ 
                        // Transaction details  
                        $transactionID = $charge['balance_transaction']; 
                        $paidAmount = $charge['amount']; 
                        $paidAmount = ($paidAmount/100); 
                        $paidCurrency = $charge['currency']; 
                        $payment_status = $charge['status']; 
                         
                        // Insert tansaction data into the database 
                        $orderData = array( 
                            'product_id' => $postData['product']['productid'], 
                            'buyer_name' => $name, 
                            'buyer_email' => $email,
                            'paid_amount' => $paidAmount, 
                            'paid_amount_currency' => $paidCurrency, 
                            'txn_id' => $transactionID, 
                            'payment_status' => $payment_status 
                        ); 
                        $orderID = $this->Products_model->insertOrder($orderData); 
                         
                        // If the order is successful 
                        if($payment_status == 'succeeded'){ 
                            return $orderID; 
                        } 
                    } 
                } 
            } 
        } 
        return false; 
    } 
     
    function payment_status($id){ 
        $data = array(); 
         
        // Get order data from the database 
        $order = $this->Products_model->getOrder($id); 
         
        // Pass order data to the view 
        $data['order'] = $order; 
        $this->load->view('templates/header_test');
        $this->load->view('products/payment-status', $data); 
        $this->load->view('templates/footer');
    } 


	public function comment(){
		$message = $this->input->post('comment');
		$name = $this->input->post('name');
		$data['name'] = $name;
		if($message == '')
		{
			$this->load->view('templates/header_test');
            $this->load->view('details/details',$data);
            $this->load->view('templates/footer');
            echo "<script>alert('Your comment is empty...')</script>";
		}
		else{
			$this->Products_model->comment($name,$message);
			$this->load->view('templates/header_test');
            $this->load->view('details/details',$data);
            $this->load->view('templates/footer');
            echo "<script>alert('Your comment is all good!')</script>";
		}
	}


	public function wcomment(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('code','comment','required');
		$code = $this->input->post('code');
		$name = $this->input->post('name');

		if($this->form_validation->run())
		{
			$array =array(
				'success'  =>  '<div class="alert alert-success">You have add your comments yet! thank you!</div>'	
			);
			$this->Products_model->comment($name,$code);
		
		}
		if(!$this->form_validation->run())
		{
			$array = array(
				'error'	 		  =>   	true,
				'code_error' 	  =>	form_error('code')
			);
		}

		echo json_encode($array);

	}



}