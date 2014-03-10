<?php

/**
 * Ultimate Discount extension for Opencart.
 *
 * @author Anthony Lawrence <freelancer@anthonylawrence.me.uk>
 * @version 1.0
 * @copyright © Anthony Lawrence 2011
 * @license Creative Common's ShareAlike License - http://creativecommons.org/licenses/by-sa/3.0/
 */


class ControllerTotalUltimateDiscount extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('total/ultimate_discount');

		$this->document->setTitle = $this->language->get('heading_title');

		$this->load->model('setting/setting');

                // Edit the setting!
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
                        // Set the new version.
                        $this->request->post["ultimate_discount_version"] = $this->language->get('_version');
                        $this->model_setting_setting->editSetting('ultimate_discount', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/total&token=' . $this->session->data['token']);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_store'] = $this->language->get('tab_store');
		$this->data['tab_category'] = $this->language->get('tab_category');
		$this->data['tab_product'] = $this->language->get('tab_product');
		$this->data['tab_multi'] = $this->language->get('tab_multi');
		$this->data['tab_customer'] = $this->language->get('tab_customer');
                
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_none'] = $this->language->get('text_none');

		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_customer'] = $this->language->get('entry_customer');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_amount'] = $this->language->get('entry_amount');
		$this->data['entry_type'] = $this->language->get('entry_type');
		$this->data['entry_rule'] = $this->language->get('entry_rule');
		$this->data['entry_rule_amount'] = $this->language->get('entry_rule_amount');
		$this->data['entry_rules_once'] = $this->language->get('entry_rules_once');
		$this->data['entry_rules_every'] = $this->language->get('entry_rules_every');
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_multi_override'] = $this->language->get('entry_multi_override');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
                
		$this->data['description_store'] = $this->language->get('description_store');
		$this->data['description_category'] = $this->language->get('description_category');
		$this->data['description_multi'] = $this->language->get('description_multi');
		$this->data['description_multi_override'] = $this->language->get('description_multi_override');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_total'),
		'href'      => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
		'href'      => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->document->breadcrumbs[] = array(
       		'text'      => $this->language->get('heading_title'),
       		'href'      => $this->url->link('total/sidewide_discount', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = HTTPS_SERVER . 'index.php?route=total/ultimate_discount&token=' . $this->session->data['token'];

		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/total&token=' . $this->session->data['token'];

                /* General */
		if (isset($this->request->post['ultimate_discount_status'])) {
			$this->data['ultimate_discount_status'] = $this->request->post['ultimate_discount_status'];
		} else {
			$this->data['ultimate_discount_status'] = $this->config->get('ultimate_discount_status');
		}

		if (isset($this->request->post['ultimate_discount_sort_order'])) {
			$this->data['ultimate_discount_sort_order'] = $this->request->post['ultimate_discount_sort_order'];
		} else {
			$this->data['ultimate_discount_sort_order'] = $this->config->get('ultimate_discount_sort_order');
		}

		if (isset($this->request->post['ultimate_discount_multi_override'])) {
			$this->data['ultimate_discount_multi_override'] = $this->request->post['ultimate_discount_multi_override'];
		} else {
			$this->data['ultimate_discount_multi_override'] = $this->config->get('ultimate_discount_multi_override');
		}

                /* Store Discount */
		if (isset($this->request->post['ultimate_discount_store'])) {
			$this->data['ultimate_discount_store'] = $this->request->post['ultimate_discount_store'];
		} else {
			$this->data['ultimate_discount_store'] = $this->config->get('ultimate_discount_store');
		}

                /* Category Discount */
		if (isset($this->request->post['ultimate_discount_category'])) {
			$this->data['ultimate_discount_category'] = $this->request->post['ultimate_discount_category'];
		} else {
			$this->data['ultimate_discount_category'] = $this->config->get('ultimate_discount_category');
		}
                
                /* Multi Discount */
		if (isset($this->request->post['ultimate_discount_multi'])) {
			$this->data['ultimate_discount_multi'] = $this->request->post['ultimate_discount_multi'];
		} else {
			$this->data['ultimate_discount_multi'] = $this->config->get('ultimate_discount_multi');
		}
                
                /** Do we need to fix anything between the different versions?! **/
                if($this->language->get('_version') > $this->config->get('ultimate_discount_version') && $this->config->get("ultimate_discount_version") != ""):
                    // Version 1.1.1
                    if($this->language->get('_version') == "111"){
                        // Apply all "category" discounts to all category groups (id = a).
                        foreach($this->data['ultimate_discount_category'] as $key => $value){
                            $this->data['ultimate_discount_category'][$key]['customer_group_id'] = 'a';
                        }
                        
                        // Apply all "sitewide" discounts to all customer groups (id = a).
                        foreach($this->data['ultimate_discount_store'] as $key => $value){
                            $this->data['ultimate_discount_store'][$key]['customer_group_id'] = 'a';
                        }
                        
                        // Move the customer discount to the global discount.
                        foreach($this->config->get('ultimate_discount_customer') as $key => $value){
                            $this->data['ultimate_discount_store'][] = $value;
                        }
                    }
                    // Version 1.2.1
                    if($this->language->get("_version") == "121"){
                        // We need to create a multibuy override setting.
                        if($this->config->get("ultimate_discount_multi_override") == null || $this->config->get("ultimate_discount_multi_override") == ""){
                            $this->request->post["ultimate_discount_multi_override"] = "0";
                        }
                    }
                    
                endif;
		$this->load->model('localisation/tax_class');
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
                
                $this->load->model('catalog/category');
                $this->data['categories'] = $this->model_catalog_category->getCategories(0);

                $this->load->model('sale/customer_group');
                $this->data['customer_groups'] = array(array("customer_group_id" => 'a', "name" => 'All'));
                $this->data['customer_groups'] = array_merge($this->data["customer_groups"], $this->model_sale_customer_group->getCustomerGroups());
                
		$this->template = 'total/ultimate_discount.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'total/ultimate_discount')) {
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