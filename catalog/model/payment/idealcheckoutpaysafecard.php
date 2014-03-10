<?php 
class ModelPaymentIdealcheckoutpaysafecard extends Model {
  	public function getMethod($address, $total) {
		$this->load->language('payment/idealcheckoutpaysafecard');
		
		if($total >= 1) 
		{
			$status = true;
		} 
		else 
		{
			$status = false;
		}
		
		$method_data = array();
			
		if($status) {
		// if($status && (!isset($address['country_id']) || (strcasecmp($address['country_id'], '150') === 0))) {
			$method_data = array( 
				'code'       => 'idealcheckoutpaysafecard',
				'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('idealcheckoutpaysafecard_sort_order')
			);
		}
		
    	return $method_data;
  	}
}
?>