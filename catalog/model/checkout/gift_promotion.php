<?php
class ModelCheckoutGiftPromotion extends Model {
	
	public function getGiftPromotion() {
			
		$gift_promotion_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gift_promotion c WHERE ((c.date_start = '0000-00-00' OR c.date_start < NOW()) AND (c.date_end = '0000-00-00' OR c.date_end > NOW())) AND c.status = '1'");
		
		//c2s.store_id = '" . (int)$this->config->get('config_store_id')
		
		if ($gift_promotion_query->num_rows) {
		foreach ($gift_promotion_query->rows as $gift_promotion_result) { 
			$status = true;
			
			$gift_promotion_options = unserialize($gift_promotion_result['options']);
		
			unset($gift_promotion_result['options']);
		
			$result = array_merge($gift_promotion_result, $gift_promotion_options);
			
			$quantity_gift = $result['quantity_gift'];
			$products_gift = $result['product_gift'];		
			
			if(isset($this->session->data['gift_promotion'])) {
					if (in_array($result['gift_promotion_id'], $this->session->data['gift_promotion'])) {
						if($products_gift) {
							foreach ($this->cart->getProducts() as $product) {
								if (in_array($product['product_id'], $products_gift)) {
									if($product['quantity'] >= $quantity_gift) {
										$this->cart->update($product['product_id'], $product['quantity']-$quantity_gift);
									}
								}
							}
						}
					
					foreach ($this->session->data['gift_promotion'] as $key => $row) {
						if($row == $result['gift_promotion_id'])
						unset($this->session->data['gift_promotion'][$key]);
						}
					}
				}
				
			// Condition to display promotion when user logged in
			if ($result['logged'] && !$this->customer->getId()) {
				$status = false;
			}
			
			// Condition for store
			if(isset($result['store'])) {
			if (!(in_array((int)$this->config->get('config_store_id'), $result['store']))) {
				$status = false;
				}
			}
			
			// Condition For Customer Group
			if($this->customer->getId()) {	
				if(isset($result['customer_group'])) {
					if (!(in_array((int)$this->customer->getCustomerGroupId(), $result['customer_group']))) {
					$status = false;
					}
				}
			}
						
			// Condition For Day
			if(isset($result['day'])) {
			if (!(in_array(date("l"), $result['day']))) {
				$status = false;
				}
			}
						
			// Condition for total uses of promotion
			$gift_promotion_history_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "gift_promotion_history` ch WHERE ch.gift_promotion_id = '" . (int)$result['gift_promotion_id'] . "'");

				if ($result['uses_total'] > 0 && ($gift_promotion_history_query->row['total'] >= $result['uses_total'])) {
					$status = false;
				}
			
			// Condition for total uses of promotion per customer							
			if ($this->customer->getId()) {
				$gift_promotion_history_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "gift_promotion_history` ch WHERE ch.gift_promotion_id = '" . (int)$result['gift_promotion_id'] . "' AND ch.customer_id = '" . (int)$this->customer->getId() . "'");
				
				if ($result['uses_customer'] > 0 && ($gift_promotion_history_query->row['total'] >= $result['uses_customer'])) {
					$status = false;
				}
			}
							
			if($result['product']) {
				$gift_product = false;
				foreach ($this->cart->getProducts() as $product) {
					// Selected Products in Cart		
					if (in_array($product['product_id'], $result['product'])) {
						if($product['quantity'] >= $result['quantity']) {
						$gift_product = true;
						break;
						}
					}
				}
				
				if (!$gift_product) {
					$status = false;
				}
			}
					
			// Condition for Total Amount
			$sp_total = $result['total'];
			$cart_subtotal = $this->cart->getSubTotal();
		
			if(strpos($sp_total,"-") !== false) {
     			$sp_total_limit = explode("-", $sp_total);
    			if (($sp_total_limit[0] > $cart_subtotal) || ($sp_total_limit[1] <  $cart_subtotal)) {
				$status = false;
				}     
   			}
			else {
  				if ($sp_total > $cart_subtotal) {
				$status = false;
       			}
			}	
			
			// Condition for Total Quantity
			$sp_quantity_total = $result['quantity_total'];
			$cart_quantity_total = $this->cart->countProducts();
			
			if(strpos($sp_quantity_total,"-") !== false) {
     			$sp_quantity_total_limit = explode("-", $sp_quantity_total);
    			if (($sp_quantity_total_limit[0] > $cart_quantity_total) || ($sp_quantity_total_limit[1] <  $cart_quantity_total)) {
				$status = false;
				}     
   			}
			else {
  				if ($sp_quantity_total > $cart_quantity_total) {
				$status = false;
       			}
			}	
										
		if ($status) {
				$gift_promotion_data[] = array(
					'gift_promotion_id' 		=> $result['gift_promotion_id'],
					'code'           			=> $result['gift_promotion_id'],
					'name'           			=> $result['name'],
					'quantity_gift'   			=> $result['quantity_gift'],
					'product_gift' 			=> $result['product_gift']
					);
			  } 
		}
		
		if(isset($gift_promotion_data)) {
			return $gift_promotion_data;
			}
		}
				
		
	}
	
	
	public function redeem($gift_promotion_id, $order_id, $customer_id, $amount) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "gift_promotion_history` SET gift_promotion_id = '" . (int)$gift_promotion_id . "', order_id = '" . (int)$order_id . "', customer_id = '" . (int)$customer_id . "', amount = '" . (float)$amount . "', date_added = NOW()");
	}
	
	public function getGiftPromotionId($code) {
	
		$gift_promotion_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gift_promotion WHERE name = '" . $this->db->escape($code) . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) AND status = '1'");
	
	    if ($gift_promotion_query->num_rows) {
			$gift_promotion_id = $gift_promotion_query->row['gift_promotion_id'];
			}
		return $gift_promotion_id;
		}
	
	public function getGiftPromotionName($gift_promotion_id) {
	
		$gift_promotion_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gift_promotion c WHERE c.gift_promotion_id = '" . $gift_promotion_id . "' AND ((c.date_start = '0000-00-00' OR c.date_start < NOW()) AND c.status = '1' AND (c.date_end = '0000-00-00' OR c.date_end > NOW()))");
		
		if ($gift_promotion_query->num_rows) {
			$gift_promotion_options = unserialize($gift_promotion_query->row['options']);
			// Condition for store
			if ((in_array((int)$this->config->get('config_store_id'), $gift_promotion_options['store']))) {
				$gift_promotion_name = $gift_promotion_query->row['name'];	
			}
		} 
		else {
			$gift_promotion_name = ""; 
			}
		
		return $gift_promotion_name;
	
	}
	
	public function getGiftPromotionProducts($gift_promotion_id) {
		$product_data = array();
		
		$gift_promotion_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gift_promotion c WHERE c.gift_promotion_id = '" . $gift_promotion_id . "' AND ((c.date_start = '0000-00-00' OR c.date_start < NOW()) AND c.status = '1' AND (c.date_end = '0000-00-00' OR c.date_end > NOW()))");
	
		if ($gift_promotion_query->num_rows) {
			$gift_promotion_options = unserialize($gift_promotion_query->row['options']);
			
			$gift_promotion_products = $gift_promotion_options['product'];	
			
			// Condition for store
			if ((in_array((int)$this->config->get('config_store_id'), $gift_promotion_options['store']))) {
				foreach ($gift_promotion_products as $product_id) { 
				$product_data[$product_id] = $this->model_catalog_product->getProduct($product_id);
				}
			} 
			
		}
		return $product_data;
	}
		
	public function getGiftPromotionProductDetails($product_id) {
		$sp_product_details = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gift_promotion c WHERE ((c.date_start = '0000-00-00' OR c.date_start < NOW()) AND c.status = '1' AND (c.date_end = '0000-00-00' OR c.date_end > NOW()))");
	
		foreach ($query->rows as $result) { 
			$gift_promotion_options = unserialize($result['options']);
			
			$gift_promotion_products = array_merge($gift_promotion_options['product'],$gift_promotion_options['product_buy']);	
			$gift_promotion_products  = array_unique($gift_promotion_products);					
			
			// Condition for store
			if ((in_array((int)$this->config->get('config_store_id'), $gift_promotion_options['store']))) {
				if ((in_array((int)$product_id, $gift_promotion_products))) {
				$sp_product_details[] = $result['name'];
				}
			} 
			
		}
		return $sp_product_details;
	}
	
	
}
?>