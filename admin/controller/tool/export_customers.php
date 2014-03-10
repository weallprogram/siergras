<?php

class ControllerToolExportCustomers extends Controller {

	public function index() {
		$this->load->language('tool/export_customers');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/customer');

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['button_export'] = $this->language->get('text_export');
		$this->data['export'] = $this->url->link('tool/export_customers/export', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/export_customers', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->template = 'tool/export_customers.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	public function export() {

		$this->response->addheader('Pragma: public');
		$this->response->addheader('Expires: 0');
		$this->response->addheader('Content-Description: File Transfer');
		$this->response->addheader('Content-Type: application/octet-stream');
		$this->response->addheader('Content-Disposition: attachment; filename=customers.csv');
		$this->response->addheader('Content-Transfer-Encoding: binary');

		$this->load->model('tool/export_customers');

		$this->response->setOutput($this->model_tool_export_customers->export());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'tool/export_customers')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

}

?>