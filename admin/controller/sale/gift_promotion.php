<?php  
class ControllerSaleGiftPromotion extends Controller {
	private $error = array();
     
  	public function index() {
		$this->load->language('sale/gift_promotion');
    	
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/gift_promotion');
		
		$this->getList();
  	}
  
  	public function insert() {
    	$this->load->language('sale/gift_promotion');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/gift_promotion');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_gift_promotion->addGiftPromotion($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('sale/gift_promotion', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
    
    	$this->getForm();
  	}

  	public function update() {
    	$this->load->language('sale/gift_promotion');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/gift_promotion');
				
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_gift_promotion->editGiftPromotion($this->request->get['gift_promotion_id'], $this->request->post);
      		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('sale/gift_promotion', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    
    	$this->getForm();
  	}

  	public function delete() {
    	$this->load->language('sale/gift_promotion');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/gift_promotion');
		
    	if (isset($this->request->post['selected']) && $this->validateDelete()) { 
			foreach ($this->request->post['selected'] as $gift_promotion_id) {
				$this->model_sale_gift_promotion->deleteGiftPromotion($gift_promotion_id);
			}
      		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('sale/gift_promotion', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getList();
  	}

  	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
				
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/gift_promotion', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('sale/gift_promotion/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/gift_promotion/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$this->data['gift_promotions'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$gift_promotion_total = $this->model_sale_gift_promotion->getTotalGiftPromotion();
	
		$results = $this->model_sale_gift_promotion->getGiftPromotions($data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/gift_promotion/update', 'token=' . $this->session->data['token'] . '&gift_promotion_id=' . $result['gift_promotion_id'] . $url, 'SSL')
			);
			
			
			$result_options = unserialize($result['options']);
									
			$this->data['gift_promotions'][] = array(
				'gift_promotion_id'  => $result['gift_promotion_id'],
				'name'       => $result['name'],
				'date_start' => date($this->language->get('date_format_short'), strtotime($result['date_start'])),
				'date_end'   => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['gift_promotion_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}
									
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_date_start'] = $this->language->get('column_date_start');
		$this->data['column_date_end'] = $this->language->get('column_date_end');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_name'] = HTTPS_SERVER . 'index.php?route=sale/gift_promotion&token=' . $this->session->data['token'] . '&sort=name' . $url;
		$this->data['sort_date_start'] = HTTPS_SERVER . 'index.php?route=sale/gift_promotion&token=' . $this->session->data['token'] . '&sort=date_start' . $url;
		$this->data['sort_date_end'] = HTTPS_SERVER . 'index.php?route=sale/gift_promotion&token=' . $this->session->data['token'] . '&sort=date_end' . $url;
		$this->data['sort_status'] = HTTPS_SERVER . 'index.php?route=sale/gift_promotion&token=' . $this->session->data['token'] . '&sort=status' . $url;
				
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $gift_promotion_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=sale/gift_promotion&token=' . $this->session->data['token'] . $url . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'sale/gift_promotion_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render());
  	}

  	private function getForm() {
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
    	$this->data['text_yes'] = $this->language->get('text_yes');
    	$this->data['text_no'] = $this->language->get('text_no');
    	
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
				
		$this->data['entry_name'] = $this->language->get('entry_name');
    	$this->data['entry_logged'] = $this->language->get('entry_logged');
		
		$this->data['entry_quantity_total'] = $this->language->get('entry_quantity_total');
		$this->data['entry_quantity'] = $this->language->get('entry_quantity');
		$this->data['entry_quantity_gift'] = $this->language->get('entry_quantity_gift');
		
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_product'] = $this->language->get('entry_product');
		$this->data['entry_product_gift'] = $this->language->get('entry_product_gift');
		$this->data['entry_product_product'] = $this->language->get('entry_product_product');
    	$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_day'] = $this->language->get('entry_day');
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
    	$this->data['entry_date_end'] = $this->language->get('entry_date_end');
    	$this->data['entry_uses_total'] = $this->language->get('entry_uses_total');
		$this->data['entry_uses_customer'] = $this->language->get('entry_uses_customer');
		$this->data['entry_status'] = $this->language->get('entry_status');
	
    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_gift_promotion_history'] = $this->language->get('tab_gift_promotion_history');

		$this->data['token'] = $this->session->data['token'];
	
		if (isset($this->request->get['gift_promotion_id'])) {
			$this->data['gift_promotion_id'] = $this->request->get['gift_promotion_id'];
		} else {
			$this->data['gift_promotion_id'] = 0;
		}
				
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
	 	
		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}
		
		if (isset($this->error['name'])) {
			$this->data['error_name_common'] = $this->error['name'];
		} else {
			$this->data['error_name_common'] = '';
		}
				
		if (isset($this->error['quantity_total'])) {
			$this->data['error_quantity_total'] = $this->error['quantity_total'];
		} else {
			$this->data['error_quantity_total'] = '';
		}
		
		if (isset($this->error['quantity'])) {
			$this->data['error_quantity'] = $this->error['quantity'];
		} else {
			$this->data['error_quantity'] = '';
		}
		
		if (isset($this->error['quantity_gift'])) {
			$this->data['error_quantity_gift'] = $this->error['quantity_gift'];
		} else {
			$this->data['error_quantity_gift'] = '';
		}
				
		if (isset($this->error['total'])) {
			$this->data['error_total'] = $this->error['total'];
		} else {
			$this->data['error_total'] = '';
		}
		
		if (isset($this->error['uses_customer'])) {
			$this->data['error_uses_customer'] = $this->error['uses_customer'];
		} else {
			$this->data['error_uses_customer'] = '';
		}
		
		if (isset($this->error['uses_total'])) {
			$this->data['error_uses_total'] = $this->error['uses_total'];
		} else {
			$this->data['error_uses_total'] = '';
		}
				
		if (isset($this->error['store'])) {
			$this->data['error_store'] = $this->error['store'];
		} else {
			$this->data['error_store'] = '';
		}
		
		if (isset($this->error['customer_group'])) {
			$this->data['error_customer_group'] = $this->error['customer_group'];
		} else {
			$this->data['error_customer_group'] = '';
		}
			
		if (isset($this->error['day'])) {
			$this->data['error_day'] = $this->error['day'];
		} else {
			$this->data['error_day'] = '';
		}
		
		if (isset($this->error['date_start'])) {
			$this->data['error_date_start'] = $this->error['date_start'];
		} else {
			$this->data['error_date_start'] = '';
		}	
		
		if (isset($this->error['date_end'])) {
			$this->data['error_date_end'] = $this->error['date_end'];
		} else {
			$this->data['error_date_end'] = '';
		}	

		$url = '';
			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/gift_promotion', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		if (!isset($this->request->get['gift_promotion_id'])) {
			$this->data['action'] = $this->url->link('sale/gift_promotion/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/gift_promotion/update', 'token=' . $this->session->data['token'] . '&gift_promotion_id=' . $this->request->get['gift_promotion_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('sale/gift_promotion', 'token=' . $this->session->data['token'] . $url, 'SSL');
  		
		if (isset($this->request->get['gift_promotion_id']) && (!$this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$gift_promotion_info_row = $this->model_sale_gift_promotion->getGiftPromotion($this->request->get['gift_promotion_id']);
    		$gift_promotion_info_options = unserialize($gift_promotion_info_row['options']);
			unset($gift_promotion_info_row['options']);
			$gift_promotion_info = array_merge($gift_promotion_info_row, $gift_promotion_info_options);
		}
				
		
		if (isset($this->request->post['name'])) {
      		$this->data['name'] = $this->request->post['name'];
    	} elseif (!empty($gift_promotion_info)) {
			$this->data['name'] = $gift_promotion_info['name'];
		} else {
      		$this->data['name'] = '';
    	}
		
    	if (isset($this->request->post['logged'])) {
      		$this->data['logged'] = $this->request->post['logged'];
    	} elseif (!empty($gift_promotion_info)) {
			$this->data['logged'] = $gift_promotion_info['logged'];
		} else {
      		$this->data['logged'] = '';
    	}
		
		if (isset($this->request->post['quantity'])) {
      		$this->data['quantity'] = $this->request->post['quantity'];
    	} elseif (!empty($gift_promotion_info)) {
			$this->data['quantity'] = $gift_promotion_info['quantity'];
		} else {
      		$this->data['quantity'] = '1';
    	}
				
		if (isset($this->request->post['quantity_gift'])) {
      		$this->data['quantity_gift'] = $this->request->post['quantity_gift'];
    	} elseif (!empty($gift_promotion_info)) {
			$this->data['quantity_gift'] = $gift_promotion_info['quantity_gift'];
		} else {
      		$this->data['quantity_gift'] = '1';
    	}
				
		if (isset($this->request->post['quantity_total'])) {
      		$this->data['quantity_total'] = $this->request->post['quantity_total'];
    	} elseif (!empty($gift_promotion_info)) {
			$this->data['quantity_total'] = $gift_promotion_info['quantity_total'];
		} else {
      		$this->data['quantity_total'] = '0';
    	}
		
    	if (isset($this->request->post['total'])) {
      		$this->data['total'] = $this->request->post['total'];
    	} elseif (!empty($gift_promotion_info)) {
			$this->data['total'] = $gift_promotion_info['total'];
		} else {
      		$this->data['total'] = '0';
    	}
				
		if (isset($this->request->get['gift_promotion_id'])) {		
			$match_category_ids = $this->model_sale_gift_promotion->getGiftPromotionProductsCategory($this->request->get['gift_promotion_id']);
			$this->data['match_category_ids'] = $match_category_ids;
			
			$match_category_gift_ids = $this->model_sale_gift_promotion->getGiftPromotionProductsCategoryGift($this->request->get['gift_promotion_id']);
			$this->data['match_category_gift_ids'] = $match_category_gift_ids;
			
			$match_manufacturer_ids = $this->model_sale_gift_promotion->getGiftPromotionProductsManufacturer($this->request->get['gift_promotion_id']);
			$this->data['match_manufacturer_ids'] = $match_manufacturer_ids;
			
			$match_manufacturer_gift_ids = $this->model_sale_gift_promotion->getGiftPromotionProductsManufacturerGift($this->request->get['gift_promotion_id']);
			$this->data['match_manufacturer_gift_ids'] = $match_manufacturer_gift_ids;
		}
		
		if (isset($this->request->post['product'])) {
			$products = $this->request->post['product'];
		} elseif (isset($this->request->get['gift_promotion_id'])) {		
			if(isset($gift_promotion_info['product'])) {
				$products = $gift_promotion_info['product'];
			} else {
			$products = array();
			}
		} else {
			$products = array();
		}
		
		$this->load->model('catalog/product');
		
		$this->data['gift_promotion_product'] = array();
	
		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if ($product_info) {
				$this->data['gift_promotion_product'][] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name']
				);
			}
		}
		
		if (isset($this->request->post['product_gift'])) {
			$products_gift = $this->request->post['product_gift'];
		} elseif (isset($this->request->get['gift_promotion_id'])) {		
			if(isset($gift_promotion_info['product_gift'])) {
				$products_gift = $gift_promotion_info['product_gift'];
			} else {
			$products_gift = array();
			}
		} else {
			$products_gift = array();
		}
		
		$this->data['gift_promotion_product_gift'] = array();
		
		foreach ($products_gift as $product_id) {
			$product_gift_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($product_gift_info) {
				$this->data['gift_promotion_product_gift'][] = array(
					'product_id' => $product_gift_info['product_id'],
					'name'       => $product_gift_info['name']
				);
			}
		}

		$this->load->model('catalog/category');
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);
				
		$this->load->model('catalog/manufacturer');
		$this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers(0);
				
		$this->load->model('setting/store');
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['store'])) {
			$this->data['gift_promotion_store'] = $this->request->post['store'];
		} elseif (isset($this->request->get['gift_promotion_id'])) {
			$this->data['gift_promotion_store'] = $gift_promotion_info['store'];
		} else {
			$this->data['gift_promotion_store'] = array(0);
		}		
		
		$this->load->model('sale/customer_group');
		
		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		
		if (isset($this->request->post['customer_group'])) {
			$this->data['gift_promotion_customer_group'] = $this->request->post['customer_group'];
		} elseif (isset($this->request->get['gift_promotion_id'])) {
			$this->data['gift_promotion_customer_group'] = $gift_promotion_info['customer_group'];
		} else {
			$this->data['gift_promotion_customer_group'] = array();
		}		
				
		$this->data['days'] = explode(',', $this->language->get('days'));
		
		if (isset($this->request->post['day'])) {
			$this->data['gift_promotion_day'] = $this->request->post['day'];
		} elseif (isset($this->request->get['gift_promotion_id'])) {
			$this->data['gift_promotion_day'] = $gift_promotion_info['day'];
		} else {
			$this->data['gift_promotion_day'] = array();
		}	
					
		if (isset($this->request->post['date_start'])) {
       		$this->data['date_start'] = $this->request->post['date_start'];
		} elseif (isset($gift_promotion_info)) {
			$this->data['date_start'] = date('Y-m-d', strtotime($gift_promotion_info['date_start']));
		} else {
			$this->data['date_start'] = date('Y-m-d', time());
		}

		if (isset($this->request->post['date_end'])) {
       		$this->data['date_end'] = $this->request->post['date_end'];
		} elseif (isset($gift_promotion_info)) {
			$this->data['date_end'] = date('Y-m-d', strtotime($gift_promotion_info['date_end']));
		} else {
			$this->data['date_end'] = date('Y-m-d', time());
		}

    	if (isset($this->request->post['uses_total'])) {
      		$this->data['uses_total'] = $this->request->post['uses_total'];
		} elseif (isset($gift_promotion_info)) {
			$this->data['uses_total'] = $gift_promotion_info['uses_total'];
    	} else {
      		$this->data['uses_total'] = 1;
    	}
  
    	if (isset($this->request->post['uses_customer'])) {
      		$this->data['uses_customer'] = $this->request->post['uses_customer'];
    	} elseif (isset($gift_promotion_info)) {
			$this->data['uses_customer'] = $gift_promotion_info['uses_customer'];
		} else {
      		$this->data['uses_customer'] = 1;
    	}
 
    	if (isset($this->request->post['status'])) { 
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (isset($gift_promotion_info)) {
			$this->data['status'] = $gift_promotion_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}
		
		$this->template = 'sale/gift_promotion_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render());		
  	}
	
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'sale/gift_promotion')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
      	
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 128)) {
        	$this->error['name'] = $this->language->get('error_name');
      	}
		
		$this->load->model('sale/gift_promotion');
		if(isset($this->request->get['gift_promotion_id'])) {
			$gift_promotion_id = $this->request->get['gift_promotion_id'];
			$result = $this->model_sale_gift_promotion->validateGiftPromotionNameById($this->request->post['name'],$gift_promotion_id);
		}
		else {
			$result = $this->model_sale_gift_promotion->validateGiftPromotionName($this->request->post['name']);
		}
		
		if ($result) {
       		 	$this->error['name'] = $this->language->get('error_name_common');
      	}
		
		if (!is_numeric($this->request->post['quantity'])) {
        	$this->error['quantity'] = $this->language->get('error_quantity');
      	}
				
		if (!is_numeric($this->request->post['quantity_gift'])) {
        	$this->error['quantity_gift'] = $this->language->get('error_quantity_gift');
      	}
				
		if(isset($this->request->post['quantity_total'])) {
			if(strpos($this->request->post['quantity_total'],"-") !== false) {
				$quantity_total_range = explode('-',$this->request->post['quantity_total']);	
				if ((!is_numeric($quantity_total_range[0])) or (!is_numeric($quantity_total_range[1]))) {
					$this->error['quantity_total'] = $this->language->get('error_quantity_total');
				}
			}
			else {
				if (!is_numeric($this->request->post['quantity_total'])) {
        			$this->error['quantity_total'] = $this->language->get('error_quantity_total');
				}
			}
		}
		
		if(isset($this->request->post['total'])) {
			if(strpos($this->request->post['total'],"-") !== false) {
				$total_range = explode('-',$this->request->post['total']);	
				if ((!is_numeric($total_range[0])) or (!is_numeric($total_range[1]))) {
					$this->error['total'] = $this->language->get('error_total');
				}
			}
			else {
				if (!is_numeric($this->request->post['total'])) {
        			$this->error['total'] = $this->language->get('error_total');
				}
			}
		}
			
		
		if (!is_numeric($this->request->post['uses_total'])) {
        	$this->error['uses_total'] = $this->language->get('error_uses_total');
      	}
		
		if (!is_numeric($this->request->post['uses_customer'])) {
        	$this->error['uses_customer'] = $this->language->get('error_uses_customer');
      	}
		
		if (!isset($this->request->post['store'])) {
        	$this->error['store'] = $this->language->get('error_store');
      	}
		
		if (!isset($this->request->post['customer_group'])) {
        	$this->error['customer_group'] = $this->language->get('error_customer_group');
      	}
				
		if (!isset($this->request->post['day'])) {
        	$this->error['day'] = $this->language->get('error_day');
      	}   
		   
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}   
		   	
    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
  	}

  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'sale/gift_promotion')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
	  	
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}	
	
	public function history() {
    	$this->language->load('sale/gift_promotion');
		
		$this->load->model('sale/gift_promotion');
				
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		
		$this->data['column_order_id'] = $this->language->get('column_order_id');
		$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_amount'] = $this->language->get('column_amount');
		$this->data['column_date_added'] = $this->language->get('column_date_added');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$this->data['histories'] = array();
			
		$results = $this->model_sale_gift_promotion->getGiftPromotionHistories($this->request->get['gift_promotion_id'], ($page - 1) * 10, 10);
      		
		foreach ($results as $result) {
        	$this->data['histories'][] = array(
				'order_id'   => $result['order_id'],
				'customer'   => $result['customer'],
				'amount'     => $result['amount'],
        		'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
        	);
      	}			
		
		$history_total = $this->model_sale_gift_promotion->getTotalGiftPromotionHistories($this->request->get['gift_promotion_id']);
			
		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->url = $this->url->link('sale/gift_promotion/history', 'token=' . $this->session->data['token'] . '&gift_promotion_id=' . $this->request->get['gift_promotion_id'] . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'sale/gift_promotion_history.tpl';		
		
		$this->response->setOutput($this->render());
  	}		
	
	public function autocompleteGiftPromotion() {
			$json = array();
			
			if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_category_id']) || isset($this->request->get['filter_manufacturer_id'])) {
				$this->load->model('sale/gift_promotion');
				$this->load->model('catalog/product');
				
				if (isset($this->request->get['filter_name'])) {
					$filter_name = $this->request->get['filter_name'];
				} else {
					$filter_name = '';
				}
				
				if (isset($this->request->get['filter_model'])) {
					$filter_model = $this->request->get['filter_model'];
				} else {
					$filter_model = '';
				}
							
				if (isset($this->request->get['filter_category_id'])) {
					$filter_category_id = $this->request->get['filter_category_id'];
				} else {
					$filter_category_id = '';
				}
				
				if (isset($this->request->get['filter_sub_category'])) {
					$filter_sub_category = $this->request->get['filter_sub_category'];
				} else {
					$filter_sub_category = '';
				}
				
				if (isset($this->request->get['filter_manufacturer_id'])) {
					$filter_manufacturer_id = $this->request->get['filter_manufacturer_id'];
				} else {
					$filter_manufacturer_id = '';
				}
				
				if (isset($this->request->get['limit'])) {
					$limit = $this->request->get['limit'];	
				} else {
					$limit = 20;	
				}			
							
				$data = array(
					'filter_name'         => $filter_name,
					'filter_model'        => $filter_model,
					'filter_category_id'  => $filter_category_id,
					'filter_sub_category' => $filter_sub_category,
					'filter_manufacturer_id'  => $filter_manufacturer_id,
					'start'               => 0,
					'limit'               => $limit
				);
				
				$results = $this->model_sale_gift_promotion->getGiftPromotionAutocompleteProducts($data);
				
				foreach ($results as $result) {
					$option_data = array();
					
					$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);	
					
					foreach ($product_options as $product_option) {
						if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox') {
							$option_value_data = array();
						
							foreach ($product_option['product_option_value'] as $product_option_value) {
								if(isset($product_option_value['name'])){
								$product_option_value['name']='';
								}else{
								$product_option_value['name']='';
								}
								
								$option_value_data[] = array(
									'product_option_value_id' => $product_option_value['product_option_value_id'],
									'option_value_id'         => $product_option_value['option_value_id'],
									'name'                    => $product_option_value['name'],
									'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
									'price_prefix'            => $product_option_value['price_prefix']
								);	
							}
						
							$option_data[] = array(
								'product_option_id' => $product_option['product_option_id'],
								'option_id'         => $product_option['option_id'],
								'name'              => $product_option['name'],
								'type'              => $product_option['type'],
								'option_value'      => $option_value_data,
								'required'          => $product_option['required']
							);	
						} else {
							$option_data[] = array(
								'product_option_id' => $product_option['product_option_id'],
								'option_id'         => $product_option['option_id'],
								'name'              => $product_option['name'],
								'type'              => $product_option['type'],
								'option_value'      => $product_option['option_value'],
								'required'          => $product_option['required']
							);				
						}
					}
					
					$json[] = array(
						'product_id' => $result['product_id'],
						'name'       => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),	
						'model'      => $result['model'],
						'option'     => $option_data,
						'price'      => $result['price']
					);	
				}
			}
			
			$this->response->setOutput(json_encode($json)); 
		}
}
?>