<?php 
class ControllerPaymentIdealcheckoutpaysafecard extends Controller {
	private $error = array(); 

	public function index() {

		$this->load->language('payment/idealcheckoutpaysafecard');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) 
		{
			$this->model_setting_setting->editSetting('idealcheckoutpaysafecard', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}


		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
		
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
		
		if(isset($this->error['warning']))
		{
			$this->data['error_warning'] = $this->error['warning'];
		}
		else
		{
			$this->data['error_warning'] = '';
		}

		$this->data['breadcrumbs'] = array();


   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),      		
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/idealcheckoutpaysafecard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('payment/idealcheckoutpaysafecard', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');	
				
		if(isset($this->request->post['idealcheckoutpaysafecard_status'])) 
		{
			$this->data['idealcheckoutpaysafecard_status'] = $this->request->post['idealcheckoutpaysafecard_status'];
		}
		else 
		{
			$this->data['idealcheckoutpaysafecard_status'] = $this->config->get('idealcheckoutpaysafecard_status');
		}

		if(isset($this->request->post['idealcheckoutpaysafecard_sort_order'])) 
		{
			$this->data['idealcheckoutpaysafecard_sort_order'] = $this->request->post['idealcheckoutpaysafecard_sort_order'];
		}
		else 
		{
			$this->data['idealcheckoutpaysafecard_sort_order'] = $this->config->get('idealcheckoutpaysafecard_sort_order');
		}


		$this->template = 'payment/idealcheckoutpaysafecard.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);

		$this->response->setOutput($this->render());
		//$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	private function validate() {
		if(!$this->user->hasPermission('modify', 'payment/idealcheckoutpaysafecard'))
		{
			$this->error['warning'] = $this->language->get('error_permission');
		}
				
		if(!$this->error)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
}

?>