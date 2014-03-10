<?php  
class ControllerModuleGuestbook extends Controller {
	protected function index($setting) {

		$this->language->load('module/guestbook');
		$this->load->model('catalog/guestbook');
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_reply'] = $this->language->get('text_reply');
		$this->data['text_no_entries'] = $this->language->get('text_no_entries');
		$this->data['text_write'] = $this->language->get('text_write');
		$this->data['text_read'] = $this->language->get('text_read');


		$this->data['write'] = $this->url->link('information/guestbook');
		$this->data['read'] = $this->url->link('information/guestbook/read');
		
		$this->data['show_reply'] = $this->config->get('show_reply');
		
		if ($this->config->get('number_char') > 0) {
		$number_char = $this->config->get('number_char'); 
		} else {
		$number_char = 100; 
		}
		
		$this->data['reviews'] = array();
		
		if ($this->config->get('number_items') > 0) {
		$number_items = $this->config->get('number_items');	
		} else {
		$number_items = 1; 
		}
		
		$results = $this->model_catalog_guestbook->getReviews(0, $number_items);

				
		foreach ($results as $result) {
      	
		$string = strip_tags($result['text']); 
 
if (strlen($string) > $number_char) { 
 
    // truncate string 
    $stringCut = substr($string, 0, $number_char); 
 
    // make sure it ends in a word so assassinate doesn't become ass... 
    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';  
} 
        	$this->data['reviews'][] = array(
        		'name'     => $result['name'],
				'text'       => $string,
				'reply'       => strip_tags($result['entry_reply']),
        		'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
        	);
      	}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/guestbook.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/guestbook.tpl';
		} else {
			$this->template = 'default/template/module/guestbook.tpl';
		}

		$this->render();
	}

  	private function validate() {
    	if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
      		$this->error['warning'] = $this->language->get('error_login');
    	}
	
    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}  	
  	}
}
?>