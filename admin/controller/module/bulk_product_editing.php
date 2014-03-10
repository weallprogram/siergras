<?php
//==============================================================================
// Bulk Product Editing v155.4
// 
// Author: Clear Thinking, LLC
// E-mail: johnathan@getclearthinking.com
// Website: http://www.getclearthinking.com
//==============================================================================

class ControllerModuleBulkProductEditing extends Controller {
	private $error = array(); 
	private $type = 'module';
	private $name = 'bulk_product_editing';
	
	public function index() {
		$this->data['type'] = $this->type;
		$this->data['name'] = $this->name;
		
		$version = $this->data['version'] = (!defined('VERSION')) ? 140 : (int)substr(str_replace('.', '', VERSION), 0, 3);
		$token = $this->data['token'] = isset($this->session->data['token']) ? $this->session->data['token'] : '';
		
		$this->data = array_merge($this->data, $this->load->language('catalog/product'));
		$this->data = array_merge($this->data, $this->load->language($this->type . '/' . $this->name));
		$this->data['exit'] = $this->makeURL('extension/' . $this->type, 'token=' . $token, 'SSL');
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			// non-standard
			$data = $this->request->post;
			
			$product_ids = array();
			if ($data['edit'] == 'c') {
				$product_id_query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE category_id = " . implode(" OR category_id = ", array_map('intval', $data['edit-c'])));
				foreach ($product_id_query->rows as $p) {
					$product_ids[] = $p['product_id'];
				}
			} elseif ($data['edit'] == 'm') {
				$product_id_query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE manufacturer_id = " . implode(" OR manufacturer_id = ", array_map('intval', $data['edit-m'])));
				foreach ($product_id_query->rows as $p) {
					$product_ids[] = $p['product_id'];
				}
			} else {
				$product_ids = array_map('intval', $data['edit-p']);
			}
			$product_ids = array_unique($product_ids);
			
			if (!empty($product_ids)) {
				// Edit General Data
				$sql = "";
				
				if ($data['status'] != '')			$sql .= " status = " . (int)$data['status'] . ",";
				if ($data['model'] != '')			$sql .= " model = '" . $this->db->escape($data['model']) . "',";
				if ($data['sku'] != '')				$sql .= " sku = '" . $this->db->escape($data['sku']) . "',";
				if ($data['upc'] != '')				$sql .= " upc = '" . $this->db->escape($data['upc']) . "',";
				if ($data['ean'] != '')				$sql .= " ean = '" . $this->db->escape($data['ean']) . "',";
				if ($data['jan'] != '')				$sql .= " jan = '" . $this->db->escape($data['jan']) . "',";
				if ($data['isbn'] != '')			$sql .= " isbn = '" . $this->db->escape($data['isbn']) . "',";
				if ($data['mpn'] != '')				$sql .= " mpn = '" . $this->db->escape($data['mpn']) . "',";
				if ($data['location'] != '')		$sql .= " location = '" . $this->db->escape($data['location']) . "',";
				if ($data['price'] != '')			$sql .= $this->calculationSQL('price');
				if ($data['tax_class_id'] != '')	$sql .= " tax_class_id = " . (int)$data['tax_class_id'] . ",";
				if ($data['quantity'] != '')		$sql .= $this->calculationSQL('quantity');
				if ($data['minimum'] != '')			$sql .= " minimum = " . (int)$data['minimum'] . ",";
				if ($data['subtract'] != '')		$sql .= " subtract = " . (int)$data['subtract'] . ",";
				if ($data['stock_status_id'] != '')	$sql .= " stock_status_id = " . (int)$data['stock_status_id'] . ",";
				if ($data['shipping'] != '')		$sql .= " shipping = " . (int)$data['shipping'] . ",";
				if ($data['image'] != '')			$sql .= " image = '" . $this->db->escape($data['image']) . "',";
				if ($data['date_available'] != '')	$sql .= " date_available = '" . $this->db->escape($data['date_available']) . "',";
				if ($data['length'] != '')			$sql .= $this->calculationSQL('length');
				if ($data['width'] != '')			$sql .= $this->calculationSQL('width');
				if ($data['height'] != '')			$sql .= $this->calculationSQL('height');
				if ($data['length_class_id'] != '')	$sql .= " length_class_id = " . (int)$data['length_class_id'] . ",";
				if ($data['weight'] != '')			$sql .= $this->calculationSQL('weight');
				if ($data['weight_class_id'] != '')	$sql .= " weight_class_id = " . (int)$data['weight_class_id'] . ",";
				if ($data['sort_order'] != '')		$sql .= " sort_order = " . (int)$data['sort_order'] . ",";
				if ($data['points'] != '')			$sql .= $this->calculationSQL('points');
				if ($data['viewed'] != '')			$sql .= " viewed = " . (int)$data['viewed'] . ",";
				if ($data['manufacturer_id'] != '')	$sql .= " manufacturer_id = " . (int)$data['manufacturer_id'] . ",";
				
				if ($sql) {
					$this->db->query("UPDATE " . DB_PREFIX . "product SET" . $sql . " date_modified = NOW() WHERE product_id = " . implode(" OR product_id = ", $product_ids));
				}
				
				foreach ($data['product_reward'] as $customer_group_id => $product_reward) {
					if ($product_reward['points'] != '') {
						foreach ($product_ids as $p) {
							$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = " . (int)$p . " AND customer_group_id = " . (int)$customer_group_id);
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = " . (int)$p . ", customer_group_id = " . (int)$customer_group_id . ", points = " . (int)$product_reward['points']);
						}
					}
				}
				
				// Edit Categories
				if (!empty($data['add-c'])) {
					$sql = "INSERT IGNORE INTO " . DB_PREFIX . "product_to_category (product_id, category_id) VALUES";
					foreach (array_map('intval', $data['add-c']) as $c) {
						foreach ($product_ids as $p) {
							$sql .= " (" . $p . "," . $c . "),";
						}
					}
					$this->db->query(substr($sql, 0, -1));
				}
				if (!empty($data['remove-c'])) {
					$sql = "DELETE FROM " . DB_PREFIX . "product_to_category WHERE";
					foreach (array_map('intval', $data['remove-c']) as $c) {
						foreach ($product_ids as $p) {
							$sql .= " (product_id =" . $p . " AND category_id = " . $c . ") OR";
						}
					}
					$this->db->query(substr($sql, 0, -3));
				}
				
				// Edit Stores
				if (!empty($data['add-s'])) {
					$sql = "INSERT IGNORE INTO " . DB_PREFIX . "product_to_store (product_id, store_id) VALUES";
					foreach (array_map('intval', $data['add-s']) as $s) {
						foreach ($product_ids as $p) {
							$sql .= " (" . $p . "," . $s . "),";
						}
					}
					$this->db->query(substr($sql, 0, -1));
				}
				if (!empty($data['remove-s'])) {
					$sql = "DELETE FROM " . DB_PREFIX . "product_to_store WHERE";
					foreach (array_map('intval', $data['remove-s']) as $s) {
						foreach ($product_ids as $p) {
							$sql .= " (product_id = " . $p . " AND store_id = " . $s . ") OR";
						}
					}
					$this->db->query(substr($sql, 0, -3));
				}
				
				// Edit Related Products
				if (!empty($data['remove-all-r'])) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = " . implode(" OR product_id = ", $product_ids));
					if (empty($data['oneway'])) {
						$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = " . implode(" OR related_id = ", $product_ids));
					}
				}
				if (!empty($data['related'])) {
					$oneway_values = array();
					$twoway_values = array();
					foreach (array_map('intval', $data['related']) as $r) {
						foreach ($product_ids as $p) {
							$oneway_values[] = "(" . $p . "," . $r . ")";
							$twoway_values[] = "(" . $r . "," . $p . ")";
						}
					}
					$this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "product_related (product_id, related_id) VALUES " . implode(", ", $oneway_values));
					if (empty($data['oneway'])) {
						$this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "product_related (product_id, related_id) VALUES " . implode(", ", $twoway_values));
					}
				}
				
				// Edit Discounts
				if (!empty($data['remove-all-d'])) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = " . implode(" OR product_id = ", $product_ids));
				}
				if (!empty($data['product_discount'])) {
					$x = $data['product_discount'];
					$sql = "INSERT INTO " . DB_PREFIX . "product_discount (product_id, customer_group_id, quantity, priority, price, date_start, date_end) VALUES";
					foreach ($product_ids as $p) {
						for ($i = 0; $i < count($x['customer_group_id']); $i++) {
							if (strpos($x['price'][$i], '-') !== false) {
								$price_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product WHERE product_id = " . $p);
								$price = $price_query->row['price'] + (float)$x['price'][$i];
							} elseif (strpos($x['price'][$i], '%') !== false) {
								$price_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product WHERE product_id = " . $p);
								$price = $price_query->row['price'] * (1 - (float)$x['price'][$i] / 100);
								if (!empty($data['round-d'])) $price = round($price);
							} else {
								$price = $x['price'][$i];
							}
							$sql .= " (" . $p . ", " . (int)$x['customer_group_id'][$i] . ", " . (int)$x['quantity'][$i] . ", " . (int)$x['priority'][$i] . ", " . (float)$price . ", '" . $this->db->escape($x['date_start'][$i]) . "', '" . $this->db->escape($x['date_end'][$i]) . "'),";
						}
					}
					$this->db->query(substr($sql, 0, -1));
				}
				
				// Edit Specials
				if (!empty($data['remove-all-s'])) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = " . implode(" OR product_id = ", $product_ids));
				}
				if (!empty($data['product_special'])) {
					$x = $data['product_special'];
					$sql = "INSERT INTO " . DB_PREFIX . "product_special (product_id, customer_group_id, priority, price, date_start, date_end) VALUES";
					foreach ($product_ids as $p) {
						for ($i = 0; $i < count($x['customer_group_id']); $i++) {
							if (strpos($x['price'][$i], '-') !== false) {
								$price_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product WHERE product_id = " . $p);
								$price = $price_query->row['price'] + (float)$x['price'][$i];
							} elseif (strpos($x['price'][$i], '%') !== false) {
								$price_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product WHERE product_id = " . $p);
								$price = $price_query->row['price'] * (1 - (float)$x['price'][$i] / 100);
								if (!empty($data['round-s'])) $price = round($price);
							} else {
								$price = $x['price'][$i];
							}
							$sql .= " (" . $p . ", " . (int)$x['customer_group_id'][$i] . ", " . (int)$x['priority'][$i] . ", " . (float)$price . ", '" . $this->db->escape($x['date_start'][$i]) . "', '" . $this->db->escape($x['date_end'][$i]) . "'),";
						}
					}
					$this->db->query(substr($sql, 0, -1));
				}
				
				$this->cache->delete('product');
			}
			// end
			
			file_put_contents(DIR_LOGS.'clearthinking.txt',date('Y-m-d H:i:s')."\t".$this->request->server['REMOTE_ADDR']."\t".serialize($this->request->post)."\n",FILE_APPEND|LOCK_EX);
			$this->session->data['success'] = $this->data['standard_success'];
			$this->redirect(isset($this->request->get['exit']) ? $this->data['exit'] : $this->makeURL($this->type . '/' . $this->name, 'token=' . $token, 'SSL'));
		}
		
		$breadcrumbs = array();
		$breadcrumbs[] = array(
			'href'		=> $this->makeURL('common/home', 'token=' . $token, 'SSL'),
			'text'		=> $this->data['text_home'],
			'separator' => false
		);
		$breadcrumbs[] = array(
			'href'		=> $this->makeURL('extension/' . $this->type, 'token=' . $token, 'SSL'),
			'text'		=> $this->data['standard_' . $this->type],
			'separator' => ' :: '
		);
		$breadcrumbs[] = array(
			'href'		=> $this->makeURL($this->type . '/' . $this->name, 'token=' . $token, 'SSL'),
			'text'		=> $this->data['heading_title'],
			'separator' => ' :: '
		);
		
		$this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
		$this->data['success'] = isset($this->session->data['success']) ? $this->session->data['success'] : '';
		unset($this->session->data['success']);
		
		// non-standard
		$this->load->model('catalog/category');
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);
		
		$this->load->model('catalog/manufacturer');
		$this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();
		
		$this->data['selectall_links'] = '<div class="selectall-links"><a onclick="$(this).parent().prev().find(\':checkbox\').attr(\'checked\', true)">' . $this->data['text_select_all'] . '</a> / <a onclick="$(this).parent().prev().find(\':checkbox\').attr(\'checked\', false)">' . $this->data['text_unselect_all'] . '</a></div>';
		
		$this->load->model('localisation/tax_class');
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$this->load->model('localisation/stock_status');
		$this->data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();
		
		$this->load->model('localisation/weight_class');
		$this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();
		
		$this->load->model('localisation/length_class');
		$this->data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();
		
		$this->load->model('sale/customer_group');
		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		
		$stores = $this->db->query("SELECT * FROM " . DB_PREFIX . "store ORDER BY name");
		$this->data['stores'] = $stores->rows;
		array_unshift($this->data['stores'], array('store_id' => 0, 'name' => $this->config->get('config_name')));
		// end
		
		$this->template = $this->type . '/' . $this->name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		if ($version < 150) {
			$this->document->title = $this->data['heading_title'];
			$this->document->breadcrumbs = $breadcrumbs;
			$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
		} else {
			$this->document->setTitle($this->data['heading_title']);
			$this->data['breadcrumbs'] = $breadcrumbs;
			$this->response->setOutput($this->render());
		}
	}
	
	private function calculationSQL($field) {
		if (strpos($this->request->post[$field], '+') !== false) {
			$calculation_sql = " " . $field . " = (" . $field . " + " . (float)str_replace('+', '', $this->request->post[$field]) . "),";
		} elseif (strpos($this->request->post[$field], '-') !== false) {
			$calculation_sql = " " . $field . " = (" . $field . " - " . (float)str_replace('-', '', $this->request->post[$field]) . "),";
		} elseif (strpos($this->request->post[$field], '%') !== false) {
			$round = (!empty($this->request->post['round-g'])) ? "ROUND" : "";
			$calculation_sql = " " . $field . " = " . $round . "(" . $field . " * " . (float)$this->request->post[$field] . " / 100),";
		} else {
			$calculation_sql = " " . $field . " = " . (float)$this->request->post[$field] . ",";
		}
		return $calculation_sql;
	}
	
	private function makeURL($route, $args = '', $connection = 'NONSSL') {
		if (!defined('VERSION') || VERSION < 1.5) {
			$url = ($connection == 'NONSSL') ? HTTP_SERVER : HTTPS_SERVER;
			$url .= 'index.php?route=' . $route;
			$url .= ($args) ? '&' . ltrim($args, '&') : '';
			return $url;
		} else {
			return $this->url->link($route, $args, $connection);
		}
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', $this->type . '/' . $this->name)) {
			$this->error['warning'] = $this->data['standard_error'];
		}
		// non-standard
		if (($this->request->post['edit'] == 'c' && empty($this->request->post['edit-c'])) ||
			($this->request->post['edit'] == 'm' && empty($this->request->post['edit-m'])) ||
			($this->request->post['edit'] == 'p' && empty($this->request->post['edit-p'])) ||
			empty($this->request->post['edit'])
		) {
			$this->error['warning'] = $this->data['text_error'];
		}
		// end
		return ($this->error) ? false : true;
	}
	
	// non-standard
	public function getProducts() {
		$sql = "SELECT p.product_id, p.status, pd.name, p.model FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id AND pd.language_id = " . (int)$this->config->get('config_language_id') . ")";
		if (!empty($this->request->get['id'])) {
			if (substr($this->request->get['id'], 0, 1) == 'm') {
				$sql .= " WHERE p.manufacturer_id = " . (int)substr($this->request->get['id'], 1);
			} elseif (substr($this->request->get['id'], 0, 1) == 'c') {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE p2c.category_id = " . (int)substr($this->request->get['id'], 1);
			}
		}
		$sql .= " ORDER BY p.status DESC, LOWER(pd.name) ASC";
		$query = $this->db->query($sql);
		$this->response->setOutput(json_encode($query->rows));
	}
	// end
}
?>