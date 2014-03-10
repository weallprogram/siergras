<?php

class ControllerNewsletterNewsletter extends Controller {

	function printExtender($arr) {
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}

	private function validate() {
		if (!$this -> user -> hasPermission('modify', 'newsletter/newsletter')) {
			$this -> error['warning'] = $this -> language -> get('error_permission');
		}

		if (!$this -> request -> post['subject']) {
			$this -> error['subject'] = $this -> language -> get('error_subject');
		}

		if (!$this -> request -> post['message']) {
			$this -> error['message'] = $this -> language -> get('error_message');
		}

		if (!$this -> error) {
			return true;
		} else {
			return false;
		}
	}

	public function send() {
		ini_set("memory_limit", "-1");
		set_time_limit(0);
		
		if (($this -> request -> server['REQUEST_METHOD'] == 'POST')) {

			$this -> load -> language('newsletter/newsletter');
			$this -> load -> model('newsletter/newsletter');

			$post = $this -> request -> post;

			// Fix the unscribe and subscribe links:
			$msg = $post['message'];
			
			$msg = $this -> fixLinks($msg);

			$to = $this -> model_newsletter_newsletter -> getTo($post['to']);
			$from = $this -> model_newsletter_newsletter -> getFromEmail($post['store_id']);
			$maxSend = $this -> model_newsletter_newsletter -> getMaxSend($post['to']);
			$from = $from['value'];
			$maxSend = $maxSend['COUNT(oc_newsletter_old_system.email)'];
			$subject = $post['subject'];
			
			$this -> model_newsletter_newsletter -> insertLetter($from, $subject, $msg, $maxSend, $to);
			$this -> session -> data['success'] = $this -> language -> get('text_success_send');
			$this -> redirect($this -> url -> link('newsletter/newsletter', 'token=' . $this -> session -> data['token'], 'SSL'));
		}
	}
	
	private function fixLinks($msg){
		$msg = str_replace("ne/subscribe", "newsletter/subscribe", $msg);
		$msg = str_replace("ne/unsubscribe", "newsletter/unsubscribe", $msg);
		
		$msg = str_replace("cache/", "", $msg);
		$msg = str_replace("-140x140", "", $msg);
		
		return $msg;
	}

	public function index() {
		ini_set("memory_limit", "-1");
		set_time_limit(0);
		
		$this -> load -> language('sale/contact');
		$this -> load -> language('ne/newsletter');
		$this -> load -> language('newsletter/newsletter');

		$this -> load -> model('catalog/product');
		$this -> load -> model('catalog/category');
		$this -> load -> model('sale/customer');
		$this -> load -> model('sale/customer_group');
		$this -> load -> model('sale/affiliate');
		$this -> load -> model('newsletter/newsletter');

		$this -> document -> setTitle($this -> language -> get('heading_title'));
		$this -> data['heading_title'] = $this -> language -> get('heading_title');

		$this -> data['entry_template'] = $this -> language -> get('entry_template');
		$this -> data['entry_yes'] = $this -> language -> get('entry_yes');
		$this -> data['entry_no'] = $this -> language -> get('entry_no');
		$this -> data['entry_defined'] = $this -> language -> get('entry_defined');
		$this -> data['entry_latest'] = $this -> language -> get('entry_latest');
		$this -> data['entry_popular'] = $this -> language -> get('entry_popular');
		$this -> data['entry_special'] = $this -> language -> get('entry_special');
		$this -> data['entry_product'] = $this -> language -> get('entry_product');
		$this -> data['entry_attachments'] = $this -> language -> get('entry_attachments');
		$this -> data['entry_store'] = $this -> language -> get('entry_store');
		$this -> data['entry_language'] = $this -> language -> get('entry_language');
		$this -> data['entry_to'] = $this -> language -> get('entry_to');
		$this -> data['entry_customer_group'] = $this -> language -> get('entry_customer_group');
		$this -> data['entry_customer'] = $this -> language -> get('entry_customer');
		$this -> data['entry_affiliate'] = $this -> language -> get('entry_affiliate');
		$this -> data['entry_product'] = $this -> language -> get('entry_product');
		$this -> data['entry_subject'] = $this -> language -> get('entry_subject');
		$this -> data['entry_message'] = $this -> language -> get('entry_message');
		$this -> data['entry_marketing'] = $this -> language -> get('entry_marketing');
		$this -> data['entry_defined_categories'] = $this -> language -> get('entry_defined_categories');
		$this -> data['entry_section_name'] = $this -> language -> get('entry_section_name');

		$this -> data['button_add_file'] = $this -> language -> get('button_add_file');
		$this -> data['button_add_defined_section'] = $this -> language -> get('button_add_defined_section');
		$this -> data['button_save'] = $this -> language -> get('button_save');
		$this -> data['button_remove'] = $this -> language -> get('button_remove');
		$this -> data['button_send'] = $this -> language -> get('button_send');
		$this -> data['button_reset'] = $this -> language -> get('button_reset');
		$this -> data['button_back'] = $this -> language -> get('button_back');
		$this -> data['button_update'] = $this -> language -> get('button_update');
		$this -> data['button_preview'] = $this -> language -> get('button_preview');
		$this -> data['button_check'] = $this -> language -> get('button_check');

		$this -> data['text_marketing'] = $this -> language -> get('text_marketing');
		$this -> data['text_marketing_all'] = $this -> language -> get('text_marketing_all');
		$this -> data['text_subscriber_all'] = $this -> language -> get('text_subscriber_all');
		$this -> data['text_all'] = $this -> language -> get('text_all');
		$this -> data['text_clear_warning'] = $this -> language -> get('text_clear_warning');
		$this -> data['text_message_info'] = $this -> language -> get('text_message_info');
		$this -> data['text_default'] = $this -> language -> get('text_default');
		$this -> data['text_newsletter'] = $this -> language -> get('text_newsletter');
		$this -> data['text_customer_all'] = $this -> language -> get('text_customer_all');
		$this -> data['text_customer'] = $this -> language -> get('text_customer');
		$this -> data['text_customer_group'] = $this -> language -> get('text_customer_group');
		$this -> data['text_affiliate_all'] = $this -> language -> get('text_affiliate_all');
		$this -> data['text_affiliate'] = $this -> language -> get('text_affiliate');
		$this -> data['text_product'] = $this -> language -> get('text_product');
		$this -> data['text_loading'] = $this -> language -> get('text_loading');

		$this -> data['defined_products'] = array();

		if (isset($this -> request -> post['defined_product']) && is_array($this -> request -> post['defined_product'])) {
			foreach ($this->request->post['defined_product'] as $product_id) {
				$product_info = $this -> model_catalog_product -> getProduct($product_id);

				if ($product_info) {
					$this -> data['defined_products'][] = array('product_id' => $product_info['product_id'], 'name' => $product_info['name']);
				}
			}
			unset($product_info);
			unset($product_id);
		}

		$this -> data['defined_products_more'] = array();

		if (isset($this -> request -> post['defined_product_more']) && is_array($this -> request -> post['defined_product_more'])) {
			foreach ($this->request->post['defined_product_more'] as $dpm) {
				if (!isset($dpm['products'])) {
					$dpm['products'] = array();
				}
				if (!isset($dpm['text'])) {
					$dpm['text'] = '';
				}
				$defined_products_more = array('text' => $dpm['text'], 'products' => array());
				foreach ($dpm['products'] as $product_id) {
					$product_info = $this -> model_catalog_product -> getProduct($product_id);

					if ($product_info) {
						$defined_products_more['products'][] = array('product_id' => $product_info['product_id'], 'name' => $product_info['name']);
					}
				}
				$this -> data['defined_products_more'][] = $defined_products_more;
			}
			unset($defined_products_more);
			unset($product_info);
			unset($product_id);
		}

		$this -> data['categories'] = $this -> model_catalog_category -> getCategories(0);

		if (isset($this -> request -> get['id']) || isset($this -> request -> post['id'])) {
			$this -> data['id'] = (isset($this -> request -> get['id']) ? $this -> request -> get['id'] : $this -> request -> post['id']);
		} else {
			$this -> data['id'] = false;
		}

		if (isset($this -> request -> post['defined'])) {
			$this -> data['defined'] = $this -> request -> post['defined'];
		} else {
			$this -> data['defined'] = false;
		}

		if (isset($this -> request -> post['defined_categories'])) {
			$this -> data['defined_categories'] = $this -> request -> post['defined_categories'];
		} else {
			$this -> data['defined_categories'] = false;
		}

		if (isset($this -> request -> post['defined_category'])) {
			$this -> data['defined_category'] = $this -> request -> post['defined_category'];
		} else {
			$this -> data['defined_category'] = array();
		}

		if (isset($this -> request -> post['special'])) {
			$this -> data['special'] = $this -> request -> post['special'];
		} else {
			$this -> data['special'] = false;
		}

		if (isset($this -> request -> post['latest'])) {
			$this -> data['latest'] = $this -> request -> post['latest'];
		} else {
			$this -> data['latest'] = false;
		}

		if (isset($this -> request -> post['popular'])) {
			$this -> data['popular'] = $this -> request -> post['popular'];
		} else {
			$this -> data['popular'] = false;
		}

		if (isset($this -> request -> post['attachments'])) {
			$this -> data['attachments'] = $this -> request -> post['attachments'];
		} else {
			$this -> data['attachments'] = false;
		}

		$this -> data['token'] = $this -> session -> data['token'];

		if (isset($this -> error['warning'])) {
			$this -> data['error_warning'] = $this -> error['warning'];
		} else {
			$this -> data['error_warning'] = '';
		}

		if (isset($this -> error['subject'])) {
			$this -> data['error_subject'] = $this -> error['subject'];
		} else {
			$this -> data['error_subject'] = '';
		}

		if (isset($this -> error['message'])) {
			$this -> data['error_message'] = $this -> error['message'];
		} else {
			$this -> data['error_message'] = '';
		}

		if (isset($this -> session -> data['success'])) {
			$this -> data['success'] = $this -> session -> data['success'];

			unset($this -> session -> data['success']);
		} else {
			$this -> data['success'] = '';
		}

		$this -> data['action'] = $this -> url -> link('newsletter/newsletter/send', 'token=' . $this -> session -> data['token'], 'SSL');
		if (isset($this -> session -> data['ne_back'])) {
			$this -> data['back'] = $this -> url -> link('newsletter/draft', 'token=' . $this -> session -> data['token'] . $this -> session -> data['ne_back'], 'SSL');
			unset($this -> session -> data['ne_back']);
			$this -> data['reset'] = false;
		} else {
			$this -> data['reset'] = $this -> url -> link('newsletter/newsletter', 'token=' . $this -> session -> data['token'], 'SSL');
			$this -> data['back'] = false;
		}
		$this -> data['save'] = $this -> url -> link('newsletter/newsletter/save', 'token=' . $this -> session -> data['token'], 'SSL');

		if (isset($this -> request -> post['template_id'])) {
			$this -> data['template_id'] = $this -> request -> post['template_id'];
		} else {
			$this -> data['template_id'] = '';
		}

		$this -> load -> model('ne/template');
		$this -> data['templates'] = $this -> model_ne_template -> getList();

		if (isset($this -> request -> post['store_id'])) {
			$this -> data['store_id'] = $this -> request -> post['store_id'];
		} else {
			$this -> data['store_id'] = '';
		}

		$this -> load -> model('setting/store');
		$this -> data['stores'] = $this -> model_setting_store -> getStores();

		if (isset($this -> request -> post['language_id'])) {
			$this -> data['language_id'] = $this -> request -> post['language_id'];
		} else {
			$this -> data['language_id'] = '';
		}

		$this -> load -> model('localisation/language');
		$this -> data['languages'] = $this -> model_localisation_language -> getLanguages();

		if (isset($this -> request -> post['to'])) {
			$this -> data['to'] = $this -> request -> post['to'];
		} else {
			$this -> data['to'] = '';
		}

		if (isset($this -> request -> post['customer_group_id'])) {
			$this -> data['customer_group_id'] = $this -> request -> post['customer_group_id'];
		} else {
			$this -> data['customer_group_id'] = '';
		}

		$this -> data['customer_groups'] = $this -> model_sale_customer_group -> getCustomerGroups(0);

		$this -> data['customers'] = array();

		if (isset($this -> request -> post['customer']) && is_array($this -> request -> post['customer'])) {
			foreach ($this->request->post['customer'] as $customer_id) {
				$customer_info = $this -> model_sale_customer -> getCustomer($customer_id);

				if ($customer_info) {
					$this -> data['customers'][] = array('customer_id' => $customer_info['customer_id'], 'name' => $customer_info['firstname'] . ' ' . $customer_info['lastname']);
				}
			}
		}

		$this -> data['affiliates'] = array();

		if (isset($this -> request -> post['affiliate']) && is_array($this -> request -> post['affiliate'])) {
			foreach ($this->request->post['affiliate'] as $affiliate_id) {
				$affiliate_info = $this -> model_sale_affiliate -> getAffiliate($affiliate_id);

				if ($affiliate_info) {
					$this -> data['affiliates'][] = array('affiliate_id' => $affiliate_info['affiliate_id'], 'name' => $affiliate_info['firstname'] . ' ' . $affiliate_info['lastname']);
				}
			}
		}

		$this -> load -> model('catalog/product');

		$this -> data['products'] = array();

		if (isset($this -> request -> post['product']) && is_array($this -> request -> post['product'])) {
			foreach ($this->request->post['product'] as $product_id) {
				$product_info = $this -> model_catalog_product -> getProduct($product_id);

				if ($product_info) {
					$this -> data['products'][] = array('product_id' => $product_info['product_id'], 'name' => $product_info['name']);
				}
			}
		}

		$this -> data['list_data'] = $this -> config -> get('ne_marketing_list');

		if (isset($this -> request -> post['subject'])) {
			$this -> data['subject'] = $this -> request -> post['subject'];
		} else {
			$this -> data['subject'] = '';
		}

		if (isset($this -> request -> post['message'])) {
			$this -> data['message'] = $this -> request -> post['message'];
		} else {
			$this -> data['message'] = '';
		}

		$this -> data['breadcrumbs'] = array();
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => false);
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('heading_title'), 'href' => $this -> url -> link('newsletter/newsletter', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => ' :: ');

		$this -> template = 'newsletter/newsletter.tpl';
		$this -> children = array('common/header', 'common/footer');

		$this -> response -> setOutput($this -> render());
	}

}
