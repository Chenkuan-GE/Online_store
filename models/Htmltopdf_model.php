<?php
class Htmltopdf_model extends CI_Model
{

	function fetch()
	{
		$this->db->order_by('productid','DESC');
		return $this->db->get('products');
	}

	function fetch_single_details($id)
	{
		$this->db->where('productid',$id);
		$data = $this->db->get('products');
		$output = '<table width="100%" cellspacing="5" cellpadding="5">';
		foreach($data->result() as $row)
		{
			$output .= '
			<tr>
				<td width="25%"><img src="'.base_url().'uploads/'.$row->filename.'" /></td>
				<td width="75%">
					<p><b>Name : </b>'.$row->name.'</p>
					<p><b>address : </b>'.$row->city.'</p>
					<p><b>Category : </b>'.$row->category.'</p>
				</td>
			</tr>
			';
		}
		$output .= '
		<tr>
			<td colspan="2" align="center"><a href="'.base_url().'HtmltoPDF" class="btn btn-primary">BACK</a></td>
		</tr>
		';
		$output .= '</table>';
		return $output;
	}

	function get_single_details($id)
	{
		$this->db->where('productid',$id);
		$data = $this->db->get('products');
		$this->db->where('product_id',$id);
		$order = $this->db->get('orders');
		
		$output = '<table width="100%" cellspacing="5" cellpadding="5" align="center">';

		foreach($order->result() as $row)
		{
			$output .= '

			<tr>
				<td><h3>Payment Information</h3><td>
				<td>
					<p><b>Reference Number : </b>'.$row->id.'</p>
					<p><b>Transaction ID : </b>'.$row->txn_id.'</p>
					<p><b>Paid Amount : </b>'.$row->paid_amount.''.$row->paid_amount_currency.'</p>
					<p><b>Payment Status : </b>'.$row->payment_status.'</p>
				</td>
				
			</tr>
			';
		}

		foreach($order->result() as $row)
		{
			$output .= '

			<tr>
				<td><h3>Buyer Information</h3><td>
				<td>
					<p><b>Buyer Name : </b>'.$row->buyer_name.'</p>
					<p><b>Buyer Email : </b>'.$row->buyer_email.'</p>
				</td>		
			</tr>
			';
		}

		foreach($data->result() as $row)
		{
			$output .= '

			<tr>
				<td><h3>Product Information</h3><td>
				<td>
					<p><b>Product Name : </b>'.$row->name.'</p>
					<p><b>Product address : </b>'.$row->city.'</p>
					<p><b>Product Category : </b>'.$row->category.'</p>
					<p><b>Product Hotting : </b>'.$row->ranking.'</p>
				</td>
			</tr>
			';
		}
		$output .= '
		<tr>
			<td colspan="2" align="center"><a href="'.base_url().'Homepage/index3" class="btn btn-primary">BACK TO HOMEPAGE</a></td>
		</tr>
		';
		$output .= '</table>';
		return $output;
	}

}