<?php
class ModelSaleGiftPromotion extends Model {

	public function serializeGiftPromotionOptions($data) {
		$option = array();
		$option['quantity'] = $data['quantity'];
		$option['quantity_gift'] = $data['quantity_gift'];
		$option['quantity_total'] = $data['quantity_total'];
		$option['total'] = $data['total'];
		$option['logged'] = $data['logged'];
		$option['uses_total'] = $data['uses_total'];
		$option['uses_customer'] = $data['uses_customer'];
		if (isset($data['product'])) {
			$option['product'] = $data['product'];	
		} else {
			$option['product'] = array();
		}
		if (isset($data['product_gift'])) {
			$option['product_gift'] = $data['product_gift'];	
		} else {
			$option['product_gift'] = array();
		}
		$option['store'] = $data['store'];
		$option['customer_group'] = $data['customer_group'];
		$option['day'] = $data['day'];
		$options = serialize($option);
		return $options;
		}

	public function addGiftPromotion($data) {
      	
		$options =  $this->model_sale_gift_promotion->serializeGiftPromotionOptions($data);
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "gift_promotion SET name = '" . $this->db->escape($data['name']) . "', options = '" . $this->db->escape($options) . "', date_start = '" . $this->db->escape($data['date_start']) . "', date_end = '" . $this->db->escape($data['date_end']) . "', status = '" . (int)$data['status'] . "', date_added = NOW()");
		
		}

	public function editGiftPromotion($gift_promotion_id, $data) {
      	
		$options =  $this->model_sale_gift_promotion->serializeGiftPromotionOptions($data);
		
		$this->db->query("UPDATE " . DB_PREFIX . "gift_promotion SET name = '" . $this->db->escape($data['name']) . "', options = '" . $this->db->escape($options) . "', date_start = '" . $this->db->escape($data['date_start']) . "', date_end = '" . $this->db->escape($data['date_end']) . "', status = '" . (int)$data['status'] . "' WHERE gift_promotion_id = '" . (int)$gift_promotion_id . "'");
		
		}
	
	
	public function deleteGiftPromotion($gift_promotion_id) {
      	$this->db->query("DELETE FROM " . DB_PREFIX . "gift_promotion WHERE gift_promotion_id = '" . (int)$gift_promotion_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gift_promotion_history WHERE gift_promotion_id = '" . (int)$gift_promotion_id . "'");		
		}
	
	public function getGiftPromotion($gift_promotion_id) {
      	$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "gift_promotion WHERE gift_promotion_id = '" . (int)$gift_promotion_id . "'");
		
		return $query->row;
	}
	
	public function validateGiftPromotionNameById($name,$gift_promotion_id) {
      	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gift_promotion WHERE name = '" . $name . "' AND gift_promotion_id != '" . (int)$gift_promotion_id . "'");
		
		return $query->row;
	}
	
	public function validateGiftPromotionName($name) {
      	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gift_promotion WHERE name = '" . $name . "'");
		
		return $query->row;
	}
	
	public function getGiftPromotions($data = array()) {
		$sql = "SELECT gift_promotion_id, name, options, date_start, date_end, status FROM " . DB_PREFIX . "gift_promotion";
		
		$sort_data = array(
			'name',
			'options',
			'date_start',
			'date_end',
			'status'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY name";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}		
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getGiftPromotionProductsCategory($gift_promotion_id) {
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gift_promotion WHERE gift_promotion_id = '" . (int)$gift_promotion_id . "'");
			
			$query_result = $query->row;
			$result = unserialize($query_result['options']);
			$result_products = $result['product'];
			
			$product_to_category_data = array();
			
			foreach ($result_products as $product_id) {
				
				$query_product_to_category = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
					
					foreach ($query_product_to_category->rows as $result_product_to_category) {
						$product_to_category_data[] = $result_product_to_category['category_id'];
					}
	
			}
	
			$gift_category_count =  array();
			$gift_category_count = array_count_values($product_to_category_data);
			
			$gift_category_ids = array();
			$gift_category_ids = array_unique($product_to_category_data);
						
			$match_category = array();
			foreach($gift_category_ids as $gift_category_id){
				
			$query_category_id_count = $this->db->query("SELECT count(*) as total_category_products FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$gift_category_id . "'");
					
					$total_category_products = $query_category_id_count->row['total_category_products'];
					
					if( $gift_category_count[$gift_category_id] == $total_category_products){
						$match_category[] = $gift_category_id;
					}
			}
			
			return $match_category;
		}
	
	public function getGiftPromotionProductsManufacturer($gift_promotion_id) {
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gift_promotion WHERE gift_promotion_id = '" . (int)$gift_promotion_id . "'");
			
			$query_result = $query->row;
			$result = unserialize($query_result['options']);
			$result_products = $result['product'];
			
			$product_to_manufacturer_data = array();
			
			foreach ($result_products as $product_id) {
				
				$query_product_to_manufacturer = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
					
					foreach ($query_product_to_manufacturer->rows as $result_product_to_manufacturer) {
						$product_to_manufacturer_data[] = $result_product_to_manufacturer['manufacturer_id'];
					}
	
			}
	
			$gift_manufacturer_count =  array();
			$gift_manufacturer_count = array_count_values($product_to_manufacturer_data);
			
			$gift_manufacturer_ids = array();
			$gift_manufacturer_ids = array_unique($product_to_manufacturer_data);
						
			$match_manufacturer = array();
			foreach($gift_manufacturer_ids as $gift_manufacturer_id){
				
			$query_manufacturer_id_count = $this->db->query("SELECT count(*) as total_manufacturer_products FROM " . DB_PREFIX . "product WHERE manufacturer_id = '" . (int)$gift_manufacturer_id . "'");
					
					$total_manufacturer_products = $query_manufacturer_id_count->row['total_manufacturer_products'];
					
					if( $gift_manufacturer_count[$gift_manufacturer_id] == $total_manufacturer_products){
						$match_manufacturer[] = $gift_manufacturer_id;
					}
			}
			
			return $match_manufacturer;
		}
	
	public function getGiftPromotionProductsCategoryGift($gift_promotion_id) {
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gift_promotion WHERE gift_promotion_id = '" . (int)$gift_promotion_id . "'");
			
			$query_result = $query->row;
			$result = unserialize($query_result['options']);
			$result_products = $result['product_gift'];
			
			$product_to_category_data = array();
			
			foreach ($result_products as $product_id) {
				
				$query_product_to_category = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
					
					foreach ($query_product_to_category->rows as $result_product_to_category) {
						$product_to_category_data[] = $result_product_to_category['category_id'];
					}
	
			}
	
			$gift_category_count =  array();
			$gift_category_count = array_count_values($product_to_category_data);
			
			$gift_category_ids = array();
			$gift_category_ids = array_unique($product_to_category_data);
						
			$match_category = array();
			foreach($gift_category_ids as $gift_category_id){
				
			$query_category_id_count = $this->db->query("SELECT count(*) as total_category_products FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$gift_category_id . "'");
					
					$total_category_products = $query_category_id_count->row['total_category_products'];
					
					if( $gift_category_count[$gift_category_id] == $total_category_products){
						$match_category[] = $gift_category_id;
					}
			}
			
			return $match_category;
		}
		
		public function getGiftPromotionProductsManufacturerGift($gift_promotion_id) {
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gift_promotion WHERE gift_promotion_id = '" . (int)$gift_promotion_id . "'");
			
			$query_result = $query->row;
			$result = unserialize($query_result['options']);
			$result_products = $result['product_gift'];
			
			$product_to_manufacturer_data = array();
			
			foreach ($result_products as $product_id) {
				
				$query_product_to_manufacturer = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
					
					foreach ($query_product_to_manufacturer->rows as $result_product_to_manufacturer) {
						$product_to_manufacturer_data[] = $result_product_to_manufacturer['manufacturer_id'];
					}
	
			}
	
			$gift_manufacturer_count =  array();
			$gift_manufacturer_count = array_count_values($product_to_manufacturer_data);
			
			$gift_manufacturer_ids = array();
			$gift_manufacturer_ids = array_unique($product_to_manufacturer_data);
						
			$match_manufacturer = array();
			foreach($gift_manufacturer_ids as $gift_manufacturer_id){
				
			$query_manufacturer_id_count = $this->db->query("SELECT count(*) as total_manufacturer_products FROM " . DB_PREFIX . "product WHERE manufacturer_id = '" . (int)$gift_manufacturer_id . "'");
					
					$total_manufacturer_products = $query_manufacturer_id_count->row['total_manufacturer_products'];
					
					if( $gift_manufacturer_count[$gift_manufacturer_id] == $total_manufacturer_products){
						$match_manufacturer[] = $gift_manufacturer_id;
					}
			}
			
			return $match_manufacturer;
		}
	
	public function getGiftPromotionStores($gift_promotion_id) {
		$gift_promotion_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gift_promotion_to_store WHERE gift_promotion_id = '" . (int)$gift_promotion_id . "'");

		foreach ($query->rows as $result) {
			$gift_promotion_store_data[] = $result['store_id'];
		}
		
		return $gift_promotion_store_data;
	}

	public function getTotalGiftPromotion() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "gift_promotion");
		
		return $query->row['total'];
	}	
	
	public function getGiftPromotionHistories($gift_promotion_id, $start = 0, $limit = 10) {
		$query = $this->db->query("SELECT ch.order_id, CONCAT(c.firstname, ' ', c.lastname) AS customer, ch.amount, ch.date_added FROM " . DB_PREFIX . "gift_promotion_history ch LEFT JOIN " . DB_PREFIX . "customer c ON (ch.customer_id = c.customer_id) WHERE ch.gift_promotion_id = '" . (int)$gift_promotion_id . "' ORDER BY ch.date_added ASC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}
	
	public function getTotalGiftPromotionHistories($gift_promotion_id) {
	  	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "gift_promotion_history WHERE gift_promotion_id = '" . (int)$gift_promotion_id . "'");

		return $query->row['total'];
	}		
	
	public function getGiftPromotionAutocompleteProducts($data = array()) {
		
		if ($data) {
			$sql = "SELECT *, pd.name as name FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)"; 
		
		if (!empty($data['filter_category_id'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			
			}
			
		if (!empty($data['filter_manufacturer_id'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id)";			
			}	
					
			$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
			
			if (!empty($data['filter_name'])) {
				$sql .= " AND LCASE(pd.name) LIKE '" . $this->db->escape(mb_strtolower($data['filter_name'], 'UTF-8')) . "%'";
			}
	
			if (!empty($data['filter_model'])) {
				$sql .= " AND LCASE(p.model) LIKE '" . $this->db->escape(mb_strtolower($data['filter_model'], 'UTF-8')) . "%'";
			}
			
			if (!empty($data['filter_price'])) {
				$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
			}
			
			if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
				$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
			}
			
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
			}
			
			if (!empty($data['filter_manufacturer_id'])) {
				$sql .= " AND m.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
			}
	
			if (!empty($data['filter_category_id'])) {
							if (!empty($data['filter_sub_category'])) {
								$implode_data = array();
								
								$implode_data[] = "category_id = '" . (int)$data['filter_category_id'] . "'";
								
								$this->load->model('catalog/category');
								
								$categories = $this->model_catalog_category->getCategories($data['filter_category_id']);
								
								foreach ($categories as $category) {
									$implode_data[] = "p2c.category_id = '" . (int)$category['category_id'] . "'";
								}
								
								$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
							} else {
								$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
							}
						}
						
			$sql .= " GROUP BY p.product_id";
						
			$sort_data = array(
				'pd.name',
				'p.model',
				'p.price',
				'p.quantity',
				'p.status',
				'p.sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY pd.name";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
		
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				
	
				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}	
			
			$query = $this->db->query($sql);
		
			return $query->rows;
		} else {
			$product_data = $this->cache->get('product.' . $this->config->get('config_language_id'));
		
			if (!$product_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
	
				$product_data = $query->rows;
			
				$this->cache->set('product.' . $this->config->get('config_language_id'), $product_data);
			}	
	
			return $product_data;
			
		}
	}
		

	}
	
	