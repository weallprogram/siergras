<?php 
class ControllerModuleCart extends Controller {
	public function index() {
		$this->language->load('module/cart');
		
      	if (isset($this->request->get['remove'])) {
          	$this->cart->remove($this->request->get['remove']);
			
			unset($this->session->data['vouchers'][$this->request->get['remove']]);
      	}

      	if (isset($this->request->get['remove_opt'])) {
          	$this->cart->remove_opt(rawurldecode($this->request->get['remove_opt']));
      	}	
			
		// Totals
		$this->load->model('setting/extension');
		
		$total_data = array();					
		$total = 0;
		$taxes = $this->cart->getTaxes();
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total));
		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_cart'] = $this->language->get('text_cart');
		$this->data['text_checkout'] = $this->language->get('text_checkout');
		
		$this->data['button_remove'] = $this->language->get('button_remove');
		
		$this->load->model('tool/image');
		
		$this->data['products'] = array();
		
		$this->load->model('catalog/product');

		$totalAll = 0.00;
		$fakeProCount = 0;
		foreach ($this->cart->getProducts() as $product) {
			$extra_pro_info = $this -> model_catalog_product -> getProduct($product['product_id']);
			$opt_pro_info = $this -> model_catalog_product -> getProductOptions($product['product_id']);

			$basePrice = number_format((float)str_replace(',', '.',str_replace('€', '', $extra_pro_info['price'])), 2, '.', '');

			if ($product['image']) {
				$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
			} else {
				$image = '';
			}
							
			$option_data = array();
			$totalOptions = 0;

			foreach ($product['option'] as $option) {
				$optPrice = $this -> model_catalog_product -> getOptionPrice($option['product_option_value_id']);

				if ($option['type'] != 'file') {
					$value = $option['option_value'];	
				} else {
					$filename = $this->encryption->decrypt($option['option_value']);
					
					$value = utf8_substr($filename, 0, utf8_strrpos($filename, '.'));
				}				
				
				$optTimes = $option['name'];
				$optTimes = explode('x', $optTimes);
				$optTimes = str_replace('(', '', $optTimes[0]);
				$totalOptions += floatval($optTimes);

				$option_data[] = array(								   
					'name'  => $option['name'],
					'optTimes' => $optTimes,
					'optPrice' => $optPrice,
					'optTotal' => ($optTimes * ($basePrice + $optPrice)),
					'optID' => $option['product_option_value_id'],
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value),
					'type'  => $option['type']
				);
			}
			
			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
			 
			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
			} else {
				$total = false;
			}

			$newTotal = number_format((float)str_replace(',', '.',str_replace('€', '', $total)), 2, '.', '');
			$newTotal = number_format(($newTotal + ($basePrice * ($totalOptions - 1))), 2, '.', '');
			$totalAll += $newTotal;
			$fakeProCount += $totalOptions;

			$this->data['products'][] = array(
				'key'      => $product['key'],
				'thumb'    => $image,
				'name'     => $product['name'],
				'model'    => $product['model'], 
				'option'   => $option_data,
				'totalOptions' => $totalOptions,
				'quantity' => $product['quantity'],
				'price'    => $price,
				'price_base' => $basePrice,
				'total'    => $total,	
				'newTotal' => $newTotal,
				'href'     => $this->url->link('product/product', 'product_id=' . $product['product_id'])		
			);
		}

		$this -> data['ownData'] = array(
			'totalAll' => number_format($totalAll, 2, '.', ''),
			'totalFakePro' => $fakeProCount
		);

		// Gift Voucher
		$this->data['vouchers'] = array();
		
		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $key => $voucher) {
				$this->data['vouchers'][] = array(
					'key'         => $key,
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'])
				);
			}
		}

		// Display prices
		if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
			$sort_order = array(); 
			
			$results = $this->model_setting_extension->getExtensions('total');
			
			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}
			
			array_multisort($sort_order, SORT_ASC, $results);
			
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					if( $result['code'] == "sub_total"){
						$this->load->model('total/' . $result['code']);
						$this->{'model_total_' . $result['code']}->getTotalFixed($total_data, $total, $taxes, $totalAll);
					}else{
						$this->load->model('total/' . $result['code']);
						$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					}
				}
				
				$sort_order = array(); 
			  
				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}
	
				array_multisort($sort_order, SORT_ASC, $total_data);			
			}		
		}

		$this->data['totals'] = $total_data;
					
		$this->data['cart'] = $this->url->link('checkout/cart');
						
		$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/cart.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/cart.tpl';
		} else {
			$this->template = 'default/template/module/cart.tpl';
		}
				
		$this->response->setOutput($this->render());		
	}
}
?>