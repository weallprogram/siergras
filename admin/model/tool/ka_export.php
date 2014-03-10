<?php
/*
  Project: CSV Product Export
  Author : karapuz <support@ka-station.com>

  Version: 3.2 ($Revision: 7 $)

*/

global $vqmod, $registry;

if (!empty($vqmod)) {
	require_once($vqmod->modCheck(DIR_SYSTEM . 'library/tax.php'));
	require_once($vqmod->modCheck(DIR_SYSTEM . 'library/customer.php'));
	if (is_dir(DIR_APPLICATION . 'model/tool/ka_schemes')) {
		require_once($vqmod->modCheck(DIR_APPLICATION . 'model/tool/ka_schemes/ka_scheme.php'));
	}
} else {
	require_once(DIR_SYSTEM . 'library/tax.php');
	require_once(DIR_SYSTEM . 'library/customer.php');
	if (is_dir(DIR_APPLICATION . 'model/tool/ka_schemes')) {
		require_once(DIR_APPLICATION . 'model/tool/ka_schemes/ka_scheme.php');
	}
}

if (!defined('HTTP_IMAGE')) {
	define('HTTP_IMAGE', HTTP_CATALOG . 'image/');
}

$registry->set('customer', new Customer($registry));
$registry->set('tax', new Tax($registry));

class ModelToolKaExport extends Model {

	// constants
	private $sec_per_cycle    = 10;
	private $enclosure        = '"';
	//	private $escape           = '\\'; - not supported;

	private $filter = null;

	// session variables
	private $params;
	private $stat;

	//temporary vaiables
	private $lastError;
	private $columns;
	private $messages;
	private $ka_log = null;

	// experimental functionality
	// 
	private $extendFieldSetSchemes;
	private $extendValueSchemes;
	private $extendProductSchemes;
	private $extendRowSchemes;		// not supported yet, reserved for future use
	
	function __construct(&$registry) {
		parent::__construct($registry);

 		$this->ka_log = new Log('ka_product_export.log');

		if (!isset($this->stat)) {
			if (!isset($this->session->data['ka_pe_stat'])) 
				$this->session->data['ka_pe_stat'] = array();
			$this->stat = &$this->session->data['ka_pe_stat'];
		}

		if (!isset($this->params)) {
			if (!isset($this->session->data['ka_pe_mparams']))
				$this->session->data['ka_pe_mparams'] = array();
			$this->params = &$this->session->data['ka_pe_mparams'];
		}
		
 		$upd = $this->config->get('ka_pe_update_interval');
 		if ($upd >= 5 && $upd <= 25) {
 			$this->sec_per_cycle = $upd;
 		}
 		
 		$this->loadSchemes();
	}


 	/*
 		This function is used for writing messages to log and displaying them instantly during development.
 	*/
 	private function report($msg) {

 		if (defined('KA_DEBUG')) {
 			echo $msg;
 		}

		$this->ka_log->write($msg);
 	}


	private function addExportMessage($msg, $type = 'W') {

		$prefix = '';
		if ($type == 'W') {
			$prefix = 'WARNING';
	  } else if ($type == 'E') {
	  	$prefix = 'ERROR';
	  } elseif ($type == 'I') {
	  	$prefix = 'INFO';
	  }

	  $msg = $prefix . ':' . $msg;

	  $this->ka_log->write("Message: " . $msg);

		$this->messages[] = $msg;
	}


	public function isInstalled() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE code = 'ka_export'");
		if (empty($query->num_rows)) {
			return false;
		}
		return true;
	}


	public function getLastError() {
		return $this->lastError;
	}


	public function getExportStat() {		
	 	return $this->stat;
	}


	public function getExportMessages() {
		return $this->messages;
	}


	public function getSecPerCycle() {
		return $this->sec_per_cycle;
	}


	/*
		PARAMETERS:
			$str   - string
			$chars - a character or array of characters
	*/
	public function strip($str, $chars) {
		$str = trim($str);

		if (empty($chars)) {
			return $str;
		}

		if (!is_array($chars)) {
			$chars = array($chars);
		}

		$pat = array();
		$rep = array();
		foreach($chars as $char) {
			$pat[] = "/[" . preg_quote($char, '/') . "]*$/";
			$rep[] = '';
		}

		$res = preg_replace($pat, $rep, $str);
		
		return $res;
	}

	/*
		fseek - works in bytes always (regardless of the stream encoding)
		ftell - measures length in bytes for UTF-8 charset
		fread - reads a number of utf characters (not bytes)

		PARAMETERS:
			offset - length in bytes for utf-8 stream
	*/
	public function fseek_utf8($handle, $offset) {

		if (empty($this->filter)) {
			return fseek($handle, $offset);
		}

		rewind($handle);

		$reminder = $offset;	 // reminder in bytes for utf-8 stream

		while ($reminder && !feof($handle)) {

			// calculate max_length in bytes
			//
			// 4 bytes are reserved for possible BOL
			// we assume that the whole string may consists of 2-byte characters
			//
			$max_length = (int)($reminder / 2) - 4;

			if ($max_length > 1) {
				$block_size = min(1024*32, $max_length);
			} else {
				$block_size = 1;
			}

			$buf = fread($handle, $block_size);
			if ($buf === false) {
				return -1;
			} 
			
			$pos = ftell($handle);

			if ($pos > $offset) {
				trigger_error('ftell() function failed, please contact author of this extension.', E_USER_ERROR);
			}

			$reminder = $offset - $pos;
			if ($reminder < 0) {
				trigger_error('fseek() function failed, please contact author of this extension.', E_USER_ERROR);
				return -1;
			}
		}

		return 0;
	}


	public function filesize_utf8($filename, $charset) {

		if (($handle = $this->fopen_utf8($filename, "r", $charset)) == FALSE) {
			return false;
		}
		if ($this->fseek_utf8($handle, 1024*1024*1024) == -1) {
			return false;
		}
		$size = ftell($handle);
		fclose($handle);

		return $size;
	}

	
	/*
		Creates a temporary file and returns a complete path of the file.
		
		on success - string
		on error   - false
	*/
	public function tempname($dir, $prefix, $ext = 'tmp') {
		
		$try = 0;
		$res = false;
		while ($try++ < 100) {
			$name = $dir . $prefix . date("h_i_s") .  '_' . mt_rand(1, 999999) . '.' . $ext;

			if (!file_exists($name)) {
				if ($h = $this->fopen_utf8($name, "w")) {
					fclose($h);
					chmod($name, 0600);
					$res = $name;
					break;
				}
			}
		}

		return $res;
	}
	

	/*
		'r', 'w' or 'a' modes only
	*/
	public function fopen_utf8($filename, $mode, $charset = 'UTF-8') {

		$filesize = 0;
		if (file_exists($filename)) {
			$filesize = filesize($filename);
		}
	
		@ini_set("auto_detect_line_endings", "1");
		$handle = fopen($filename, $mode);

		if ($mode == 'w' || $mode == 'a') {
		
			if ($mode == 'a' && $filesize == 0) {
				if ($charset == 'UTF-16LE') {
					fwrite($handle, chr(0xFF).chr(0xFE), 2);
				}
			}
			
			if ($charset) {
				$this->filter = stream_filter_append($handle, 'convert.iconv.UTF-8/'. $charset);
				setlocale(LC_ALL, 'en_US.UTF8', 'en_US.UTF-8');
			} else {
				fclose($handle);
				$handle = FALSE;
			}
			
		} elseif ($mode == 'r') {
		
			$bom = fread($handle, 2);
			rewind($handle);

			if (in_array($charset, 'UTF-16', 'UTF-16LE')) {
				if ($bom === chr(0xff).chr(0xfe)  || $bom === chr(0xfe).chr(0xff)) {
					// UTF16 Byte Order Mark present
				  $charset = 'UTF-16';
				} else {
					$charset = '';
				}
			}

			if ($charset) {
				$this->filter = stream_filter_append($handle, 'convert.iconv.'.$charset.'/UTF-8');
				setlocale(LC_ALL, 'en_US.UTF8', 'en_US.UTF-8');
			} else {
				fclose($handle);
				$handle = FALSE;
			}
		}
		
		return $handle;
	}

	
	public function convertToByte($file_size) {
		$val = trim($file_size);
		switch (strtolower(substr($val, -1))) {
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}
		return $val;
	}

	
	/*
		Function converts value to human readable format like 10.1 Mb 
	*/
	public function convertToMegabyte($val) {
		
    	if (!is_numeric($val))
        	$val = $this->convertToByte($val);
	
		if ($val >= 1073741824) {
			$val = round($val/1073741824, 1) . " Gb";

		} elseif ($val >= 1048576) {
			$val = round($val/1048576, 1) . " Mb";

		} elseif ($val >= 1024) {
			$val = round($val/1024, 1) . " Kb";
		} else {
			$val = $val . " bytes";
		}

		return $val;
	}

		
	public function time_format($diff) {

 		$periods = array( //suffixes
		    'd' => array(86400, $this->language->get('text_days')),
	    	'h' => array(3600, $this->language->get('text_hours')),
			'm' => array(60, $this->language->get('text_minutes')),
			's' => array(1, $this->language->get('text_seconds'))
	  	);

	  	$ret = '';
    	foreach ($periods as $k => $v) {
	    	$num = floor($diff / $v[0]);
			if ($num || !empty($ret) || $k == 's') {
				$ret .= $num . ' ' . $v[1] . ' ';
			}
			$diff -= $v[0] * $num;
	    }

	    return $ret;
	}

	
	public function formatPrice($val) {
		$val = $this->currency->format($val, $this->params['currency']['code'], '', false);
		return $val;
	}

	
	public function formatWeight($val, $class, $decimal_point = '.', $thousand_point = '') {
		static $weights;
		
		$val = doubleval($val);
		
		if (empty($weights[$class])) {
			$qry = $this->db->query("SELECT * FROM " . DB_PREFIX . "weight_class_description
				WHERE weight_class_id = '$class' 
					AND language_id = '" . $this->params['language_id']. "'"
			);
						
			if (!empty($qry->row)) {
				$weights[$class] = $qry->row;
			} else {
				$weights[$class] = array(
					'unit' => ''
				);
			}
		}
		
		$val = number_format($val, 2, $decimal_point, $thousand_point) . $weights[$class]['unit'];

		return $val;
	}
		
	
	public function formatLength($val, $class, $decimal_point = '.', $thousand_point = '') {
		static $lengths;

		$val = doubleval($val);
		
		if (empty($lengths[$class])) {
			$qry = $this->db->query("SELECT * FROM " . DB_PREFIX . "length_class_description
				WHERE length_class_id = '$class'
				AND language_id = '" . $this->params['language_id']. "'"
			);

			if (!empty($qry->row)) {
				$lengths[$class] = $qry->row;
			} else {
				$lengths[$class] = array('unit' => '');
			}
		}
		
		$val = number_format($val, 2, $decimal_point, $thousand_point) . $lengths[$class]['unit'];

		return $val;
	}

		
	private function getCategoryPath($category_id, $language_id = 0) {
	
		if (empty($language_id)) {
			$language_id = $this->config->get('config_language_id');
		}
	
		$query = $this->db->query("SELECT name, parent_id 
			FROM " . DB_PREFIX . "category c 
				LEFT JOIN " . DB_PREFIX . "category_description cd 
					ON (c.category_id = cd.category_id) 
			WHERE 
				c.category_id = '" . (int)$category_id . "' 
				AND cd.language_id = '" . (int)$language_id . "' 
			ORDER BY c.sort_order, cd.name ASC"
		);
		
		if (empty($query->row)) {
			return '';
		}
		
		if ($query->row['parent_id']) {
			return $this->getCategoryPath($query->row['parent_id'], $language_id) . $this->params['cat_separator'] . $query->row['name'];
		} else {
			return $query->row['name'];
		}
	}


	private function getCustomerGroup($customer_group_id) {
	
		if (version_compare(VERSION, '1.5.3', '>=')) {
			$qry = $this->db->query("SELECT cgd.name FROM " . DB_PREFIX . "customer_group cg
				INNER JOIN " . DB_PREFIX . "customer_group_description cgd
					ON cg.customer_group_id = cgd.customer_group_id 
				WHERE 
					cg.customer_group_id = '" . (int)$customer_group_id . "'"
			);
		} else {
			$qry = $this->db->query("SELECT name FROM " . DB_PREFIX . "customer_group WHERE 
				customer_group_id = '" . (int)$customer_group_id . "'"
			);
		}

		if (empty($qry->row)) {
			return false;
		}

		return $qry->row['name'];
	}


	protected function getProductOptions($product_id) {
	
		$product_option_data = array();		
		$product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po 
			LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) 
			LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) 
			WHERE po.product_id = '" . (int)$product_id . "' 
				AND od.language_id = '" . $this->params['language_id']. "'"
		);
		
		if (empty($product_option_query->row)) {
			return false;
		}
		
		foreach ($product_option_query->rows as $product_option) {
		
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				$product_option_value_data = array();	
				
				$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");
				
				foreach ($product_option_value_query->rows as $product_option_value) {
					$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'name'                    => $product_option_value['name'],
						'image'                   => $product_option_value['image'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'price'                   => $product_option_value['price'],
						'price_prefix'            => $product_option_value['price_prefix'],
						'points'                  => $product_option_value['points'],
						'points_prefix'           => $product_option_value['points_prefix'],						
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix']					
					);
				}
				
				$product_option_data[] = array(
					'product_option_id'    => $product_option['product_option_id'],
					'option_id'            => $product_option['option_id'],
					'name'                 => $product_option['name'],
					'type'                 => $product_option['type'],
					'product_option_value' => $product_option_value_data,
					'required'             => $product_option['required']
				);				
			} else {
				$product_option_data[] = array(
					'product_option_id' => $product_option['product_option_id'],
					'option_id'         => $product_option['option_id'],
					'name'              => $product_option['name'],
					'type'              => $product_option['type'],
					'option_value'      => $product_option['option_value'],
					'required'          => $product_option['required']
				);				
			}
		}	
		
		return $product_option_data;
	}

		
	/*
	
	Function collects all information about the product and returns it as a multidimensional array.

	PARAMETERS:
		$columns - array of field sets. Only selected fields exist there. Example:
	  	array (
			general => array(
	     		sku      => array('name', 'checked')
      			category => array('name', 'checked')
      		...
	      	specials => array(
      			customer_group => array('name', 'checked')
      		...
	      	options => array(
      			<option_id> => array('name', 'checked')
      		...
      	...
      );
	  $language - must match $this->params['language_id']. Some functions inside do 
              not rely on this parameter and use the language_id from params 
              array directly.

	RETURNS:
		false - error. Check log file.

		array - array of field sets with product data. Any product values can be there. Example:
			array (
				general => array(
					sku      => 'sku1'
					category =>  ...
				...
				specials => array(
					customer_group_id => 'id'
					customer_group    => 'customer_group'
				...
				options => array(
					<option_id> => 123
				...
			...
		  );
	*/
	private function getProduct($product_id, $columns, $language_id = 0, $store_id = 0) {

		if (empty($product_id) || empty($columns)) {
			$this->report("empty parameters for getProduct");
			return false;
		}

		if (!empty($store_id)) {
			$qry = $this->db->query("SELECT * FROM " . DB_PREFIX . "store WHERE 
				store_id = '$store_id'");
			if (empty($qry)) {
				$this->report("store not found");
				return false;
			}
			$store_info = $qry->row;
		} else {
			$store_info = array(
				'name' => $this->config->get("config_name"),
				'url' => HTTP_CATALOG
			);
		}

		$this->load->model('catalog/product');

		if (empty($language_id)) {
			$language_id = $this->config->get('config_language_id');
		}

		$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id='$product_id'");
		if (empty($res->row)) {
			$this->report("getProduct - product not found id='$product_id'");
			return false;
		}
    	$product = $res->row;    	
    	
		$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id='$product_id' AND language_id='$language_id'");
		if (empty($res->row)) {
			$this->report("getProduct - product description not found id='$product_id', language_id='$language_id'");
			return false;
		}
    	$product_description = $res->row;

		$sets = $this->getFieldSets();

		//
		// The code below collects information about the product in $data variable.
		// The variable is split to sets, each set is indended for specific complex information.
		//

		// prepare product fields
		//
		$data = array();
		foreach ($columns['general'] as $ck => $cv) {

			if (empty($cv['checked'])) {
				continue;
			}
			
			if (!empty($sets['general'][$ck]['copy'])) {
			
				$data['general'][$ck] = htmlspecialchars_decode($product[$ck]);
				continue;

			} elseif (in_array($ck, array('name', 'description', 'meta_description', 'meta_keyword'))) {

				// MS Excel does not handle 'Carriarge Return' character properly in text fields
				//
				$product_description[$ck] = trim(str_replace("\r", "", $product_description[$ck]));
				$data['general'][$ck] = htmlspecialchars_decode($product_description[$ck]);
				continue;

			} elseif ($ck == 'category') {
				
				$cats = $this->model_catalog_product->getProductCategories($product_id);
				if (!empty($cats)) {
					foreach ($cats as $category_id) {
						$path = $this->getCategoryPath($category_id);
						if (!empty($path)) {
							$data['general']['category'][] = htmlspecialchars_decode($path);
						}
					}
				}
				continue;

			} elseif ($ck == 'image') {
				$val = $product['image'];

				if ($this->params['image_path'] == 'url') {
					$val = HTTP_IMAGE . $product['image'];
				} else {
					$val = $product['image'];
				}
				$data['general']['image'] = $val;
				continue;

			} elseif ($ck == 'additional_image') {

				$sort_qry = "";
				if (version_compare(VERSION, '1.5.2.1') >= 0) {
					$sort_qry = " ORDER BY sort_order";
				}
								
				$qry = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' $sort_qry");
				if (!empty($qry->rows)) {
					foreach ($qry->rows as $qk => $qv) {
						if ($this->params['image_path'] == 'url') {
							$val = HTTP_IMAGE . $qv['image'];
						} else {
							$val = $qv['image'];
						} 
						$data['general']['additional_image'][] = $val;
					}
				}
				continue;

			} elseif ($ck == 'manufacturer') {
				
				$val = '';
				if (!empty($product['manufacturer_id'])) {
					$qry = $this->db->query("SELECT name FROM " . DB_PREFIX . "manufacturer 
						WHERE
							manufacturer_id = '$product[manufacturer_id]'"
					);
					if (empty($qry->row)) {
						$this->report("manufacturer not found");
					} else {
						$val = htmlspecialchars_decode($qry->row['name']);
					}
				}
				$data['general']['manufacturer'] = $val;
				continue;

			} elseif ($ck == 'tax_class') {

				$val = '';
				if (!empty($product['tax_class_id'])) {
					$qry = $this->db->query("SELECT title FROM " . DB_PREFIX . "tax_class 
						WHERE tax_class_id = '$product[tax_class_id]'");
					if (empty($qry->row)) {
						$this->addExportMessage("tax class is empty for productid $product_id");
					} else {
						$val = htmlspecialchars_decode($qry->row['title']);
					}
				}
				$data['general']['tax_class'] = $val;
				continue;

			} elseif ($ck == 'weight') {

				$data['general']['weight'] = $this->formatWeight($product[$ck], $product['weight_class_id']);
				continue;

			} elseif (in_array($ck, array('length', 'height', 'width'))) {

				$data['general'][$ck] = $this->formatLength($product[$ck], $product['length_class_id']);
				continue;

			} elseif ($ck == 'stock_status') {

				$val = '';
				if (!empty($product['stock_status_id'])) {
					$qry = $this->db->query("SELECT name FROM " . DB_PREFIX . "stock_status 
						WHERE stock_status_id = '$product[stock_status_id]' AND language_id = '$language_id'");
					if (empty($qry->row)) {
						$this->report("stock status is empty");
					} else {
						$val = htmlspecialchars_decode($qry->row['name']);
					}
				}
				$data['general']['stock_status'] = $val;
				continue;

			} elseif ($ck == 'seo_keyword' || $ck == 'product_url') {
				
				if (!empty($data['general']['product_url'])) {
					// we already filled in product url and seo keyword for the product
					//
					continue;
				}

				$val = '';
				$qry = $this->db->query("SELECT keyword FROM " . DB_PREFIX . "url_alias
					WHERE query='product_id=$product_id'");
				if (!empty($qry->row)) {
					$val = $qry->row['keyword'];
				}

				$data['general']['seo_keyword'] = $val;

				if ($this->config->get('config_seo_url')) {
			 		$data['general']['product_url'] = $store_info['url'] . $val;
			 	} else {
			 		$data['general']['product_url'] = $store_info['url'] . 'index.php?route=product/product&product_id='.$product_id;
			 	}
				continue;

		 	} elseif ($ck == 'product_tags') {
		 	
		 		if (version_compare(VERSION, '1.5.4', '>=')) {
		 		
		 			$data['general']['product_tags'] = $product_description['tag'];
		 		
		 		} else {
					$arr = $this->model_catalog_product->getProductTags($product_id);
					if (isset($arr[$language_id])) {
						$data['general']['product_tags'] = htmlspecialchars_decode($arr[$language_id]);
					} else {
						$data['general']['product_tags'] = '';
					}
				}				
				continue;

		 	} elseif ($ck == 'related_product') {

				$query = $this->db->query("SELECT p.product_id, model, sku, upc FROM " . DB_PREFIX . "product_related pr
					INNER JOIN " . DB_PREFIX . "product p ON pr.related_id = p.product_id
					WHERE pr.product_id = '" . (int)$product_id . "' AND LENGTH(model) > 0"
				);
				$data['general']['related_product'] = $query->rows;
				
				continue;
								
		 	} elseif (in_array($ck, array('price'))) {
		 		$data['general']['price'] = $this->formatPrice($product[$ck]);

		 		if ($this->params['apply_taxes']) {
			 		$data['general']['taxed_price'] = $this->tax->calculate($product['price'], $product['tax_class_id'], true);
			 		$data['general']['price']       = $data['general']['taxed_price'];
			 	}
		 		
		 		continue;
		 	}

			$this->report("Field was not processed - $ck");
		}
		
		// prepare 'Attributes' data
		//
		if (!empty($columns['attributes'])) {

			$attr_ids = array_keys($columns['attributes']);

			$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE
				product_id='$product_id' 
				AND language_id  = '$language_id'
				AND attribute_id IN ('" . implode("','", $attr_ids) . "')"
			);

			if (!empty($res->row)) {
				foreach ($res->rows as $rk => $rv) {
					if (!empty($columns['attributes'][$rv['attribute_id']]['checked'])) {
						$data['attributes'][$rv['attribute_id']] = htmlspecialchars_decode($rv['text']);
					}
				}
			}
		}
		
		// prepare 'Filter' data
		//
		if (!empty($columns['filter_groups'])) {
		
			$fg_ids = array_keys($columns['filter_groups']);

			$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_filter pf
				LEFT JOIN `" . DB_PREFIX . "filter` f ON pf.filter_id = f.filter_id
				LEFT JOIN `" . DB_PREFIX . "filter_description` fd ON pf.filter_id = fd.filter_id
				WHERE
					pf.product_id='$product_id' 
					AND fd.language_id  = '$language_id'
					AND fd.filter_group_id IN ('" . implode("','", $fg_ids) . "')"
			);
			
			if (!empty($res->rows)) {
				foreach ($res->rows as $rk => $rv) {
					if (!empty($columns['filter_groups'][$rv['filter_group_id']]['checked'])) {
						$data['filter_groups'][$rv['filter_group_id']][] = htmlspecialchars_decode($rv['name']);
					}
				}
			}
		}
		
		// prepare 'Options' data
		//
		// all options will be converted to one-dimension-array regardless of their type.
		// only exported options will be included into the product data.
		//
		if (!empty($columns['options'])) {

			$product_options = $this->getProductOptions($product_id);

			if (!empty($product_options)) {
				
				foreach ($product_options as $pok => $pov) {

					if (empty($columns['options'][$pov['option_id']]['checked'])) {
						continue;
					}

					// 
					// options with the following types has extended option values:
					// 'select', 'radio', 'checkbox', 'image'
					//

					$option = array();

					$option['option_name']     = htmlspecialchars_decode($pov['name']);
					$option['option_type']     = $pov['type'];
					$option['option_required'] = $pov['required'];

					if (isset($pov['product_option_value'])) {						
						if (!empty($pov['product_option_value'])) {
							$sort_order = 10;
							foreach ($pov['product_option_value'] as $valk => $valv) {
								$sub_option = $option;								
								$sub_option['option_value']      = htmlspecialchars_decode($valv['name']);

								// export image
								if ($pov['type'] == 'image') {
									if ($this->params['image_path'] == 'url') {
										$val = HTTP_IMAGE . $valv['image'];
									} else {
										$val = $valv['image'];
									}
									$sub_option['option_image']  = $val;
								}
								
								$sub_option['option_sort_order'] = $sort_order;
								$sort_order += 10;
								
								$sub_option['ovalue_quantity'] = $valv['quantity'];
								$sub_option['ovalue_subtract'] = $valv['subtract'];
								
						 		if ($this->params['apply_taxes']) {
			 						$valv['price'] = $this->tax->calculate($valv['price'], $product['tax_class_id'], true);
							 	}								
								$sub_option['ovalue_price']    = (($valv['price_prefix'] == '-') ? -1:1) * $this->formatPrice($valv['price']);
								$sub_option['ovalue_points']   = (($valv['points_prefix'] == '-') ? -1:1) * $valv['points'];
								$sub_option['ovalue_weight']   = (($valv['weight_prefix'] == '-') ? -1:1) * $valv['weight'];

								$data['product_options'][] = $sub_option;
							}
						} else {
							$this->addExportMessage("Product option $option[option_name] (type = $option[option_type]) has an empty list of product option values. Skipped.");
						}
						
				 	} else {
				 					 		
				 		if (!isset($pov['option_value'])) {
				 			$this->addExportMessage("Product option $option[option_name] does not have any option_value. Initialized with an empty value.");
				 			$pov['option_value'] = '';
				 		}
						$option['option_value']    = htmlspecialchars_decode($pov['option_value']);
						$option['ovalue_name']     = 'n/a';
						$option['ovalue_quantity'] = '';
						$option['ovalue_subtract'] = '';
						$option['ovalue_price']    = '';
						$option['ovalue_points']   = '';
						$option['ovalue_weight']   = '';
						$data['product_options'][] = $option;
					}
				}
			}
		}

		$customer_group_where = '';
		if (!empty($this->params['customer_group_id'])) {
			$customer_group_where = " AND customer_group_id = '" . $this->params['customer_group_id'] . "'";
		}
		
		// prepare 'Specials' data
		//
		if (!empty($columns['specials'])) {
			$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE
				product_id='$product_id' $customer_group_where ORDER BY priority, price");
			if (!empty($res)) {
				foreach ($res->rows as $rk => $rv) {
					$special = array();

					foreach ($columns['specials'] as $ck => $cv) {

						if ($ck == 'customer_group') {
							$special[$ck] = htmlspecialchars_decode($this->getCustomerGroup($rv['customer_group_id']));
							
						} else if ($ck == 'price') {
						
					 		if ($this->params['apply_taxes']) {
		 						$rv['price'] = $this->tax->calculate($rv['price'], $product['tax_class_id'], true);
						 	}
							$special[$ck] = $this->formatPrice($rv[$ck]);
						} else {
							$special[$ck] = htmlspecialchars_decode($rv[$ck]);
						}
					}

					$data['specials'][] = $special;
				}
			}
		}

		// prepare 'Discounts' data
		//
		if (!empty($columns['discounts'])) {
			$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE
				product_id='$product_id' $customer_group_where ORDER BY quantity, priority, price");
				
			if (!empty($res)) {
				foreach ($res->rows as $rk => $rv) {
					$special = array();

					foreach ($columns['discounts'] as $ck => $cv) {

						if ($ck == 'customer_group') {
							$special[$ck] = htmlspecialchars_decode($this->getCustomerGroup($rv['customer_group_id']));
						} else if ($ck == 'price') {
					 		if ($this->params['apply_taxes']) {
		 						$rv['price'] = $this->tax->calculate($rv['price'], $product['tax_class_id'], true);
						 	}
							$special[$ck] = $this->formatPrice($rv[$ck]);
						} else {
							$special[$ck] = htmlspecialchars_decode($rv[$ck]);
						}
					}

					$data['discounts'][] = $special;
				}
			}
		}
		
		// prepare 'Reward Points' data
		//
		if (!empty($columns['reward_points'])) {
			$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_reward WHERE
				product_id='$product_id' AND points != 0 ORDER BY customer_group_id");
			if (!empty($res)) {
				foreach ($res->rows as $rk => $rv) {
					$special = array();

					foreach ($columns['reward_points'] as $ck => $cv) {
						if ($ck == 'customer_group') {
							$special[$ck] = htmlspecialchars_decode($this->getCustomerGroup($rv['customer_group_id']));
						} else {
							$special[$ck] = htmlspecialchars_decode($rv[$ck]);
						}
					}

					$data['reward_points'][] = $special;
				}
			}
		}

		// replace the product price with discounted and special price if they exist
		//
		if (!empty($this->params['use_special_price'])) {
		
			$customer_group_id = (!empty($this->params['customer_group_id'])) ? $this->params['customer_group_id'] : $this->config->get('config_customer_group_id');
		
			// find discounted price
			//
			$qry = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount pd2 
				WHERE pd2.product_id = '" . $product['product_id'] . "'
					AND pd2.customer_group_id = '" . $customer_group_id . "' 
					AND pd2.quantity = '1' 
					AND (
						(pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) 
						AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())
					)
				ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1"
			);
			
			if (!empty($qry->row)) {				
			
				$data['general']['discounted_price'] = $qry->row['price'];
		 		if ($this->params['apply_taxes']) {
					$data['general']['discounted_price'] = $this->tax->calculate($data['general']['discounted_price'], $product['tax_class_id'], true);
			 	}

			 	$data['general']['price'] = $data['general']['discounted_price'];
			}
			
			// find special price
			//
			$qry = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special ps 
				WHERE ps.product_id = '" . $product['product_id'] . "'
					AND ps.customer_group_id = '" . $customer_group_id . "'
					AND (
						(ps.date_start = '0000-00-00' OR ps.date_start < NOW())
						AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())
					)
				ORDER BY ps.priority ASC, ps.price ASC LIMIT 1"
			);
			
			if (!empty($qry->row)) {
				$data['general']['special_price'] = $qry->row['price'];
		 		if ($this->params['apply_taxes']) {
					$data['general']['special_price'] = $this->tax->calculate($data['general']['special_price'], $product['tax_class_id'], true);
			 	}
				$data['general']['price'] = $data['general']['special_price'];
			}
		}
	

		if (!empty($this->extendProductSchemes)) {
			for ($i = count($this->extendProductSchemes) - 1; $i >= 0; $i--) {
				if (!$this->extendProductSchemes[$i]->extendProduct($product, $data, $columns)) {
					$this->report("getProduct: " . $this->extendProductSchemes[$i]->getLastError());
				}
			}
		}

		return $data;
	}

	private function calcRowsRequiredNumber($product, $columns) {
			
		if (empty($product) || empty($columns)) {
			$this->report("Wrong data in calcRowsRequiredNumber");
			return false;
		}

		// do not include 'attributes' here because they take 1 row always
		//
		$sets = array('product_options', 'specials', 'discounts', 'reward_points');

		$rows_required_num = 1;
		foreach ($sets as $sk => $sv) {
			if (!empty($product[$sv]) && is_array($product[$sv])) {
				$rows_required_num = max($rows_required_num, count($product[$sv]));
			}
		}

		if ($this->config->get('ka_pe_cats_in_one_cell') != 'Y') {
			if (!empty($product['general']['category']) && is_array($product['general']['category'])) {
				$rows_required_num = max($rows_required_num, count($product['general']['category']));
			}
		}

		if ($this->config->get('ka_pe_images_in_one_cell') != 'Y') {
			if (!empty($product['general']['additional_image']) && is_array($product['general']['additional_image'])) {
				$rows_required_num = max($rows_required_num, count($product['general']['additional_image']));
			}
		}

		if (!empty($product['filter_groups'])) {
			foreach ($product['filter_groups'] as $fg) {
				$rows_required_num = max($rows_required_num, count($fg));
			}
		}
		
		return $rows_required_num;
	}

	protected function format($val, $type = 'text', $format = '') {
		if ($type == 'date' || $type ='text') {
			if (!empty($this->params['prefix_with_space'])) {
				$val = ' ' . $val;
			}
		}
		
		return $val;
	}
		
	/*
		PARAMETERS:
			$product - array of product field sets returned by $this->getProduct(...).
			$columns - list of columns being exported for the product.

		RETURNS:
			false    - on error.
			array    - one-dimension array of fields suitable for fputcsv function.

		IMPORTANT: export blocks must have the same order as they are defined in getHeader() function.
	*/
	private function fillRow($product, $columns, $row_num) {

		if (empty($product) || empty($columns)) {
			$this->report("Wrong data in fillRow");
			return false;
		}

		$row = array();
		$sep = $this->config->get('ka_pe_general_sep');

		/* columns format
			[0] =>
				'set'   => 'specials',
				'field' => 'customer_group'
		*/
		if (!empty($columns['general'])) {
			foreach ($columns['general'] as $ck => $cv) {
				if (empty($cv['checked'])) {
					continue;
				}
				
				$val = '';
				if ($ck == 'category') {
					if ($this->config->get('ka_pe_cats_in_one_cell') != 'Y') {
					
						$val = (!empty($product['general']['category'][$row_num-1])) ? $product['general']['category'][$row_num-1] : '';
						
					} elseif ($row_num == 1) {
						if (!empty($product['general']['category'])) {
							
							foreach ($product['general']['category'] as $pk => $pv) {
								if (empty($val)) {
									$val = $pv;
								} else {
									$val = $val . $sep . $pv;
								}
							}
						}
					}
					
				} elseif ($ck == 'related_product') {

								
					if ($this->config->get('ka_pe_related_in_one_cell') != 'Y') {
						
						$val = (!empty($product['general']['related_product'][$row_num-1]['model'])) ? $product['general']['related_product'][$row_num-1]['model'] : '';

					} elseif ($row_num == 1) {
					
						if (!empty($product['general']['related_product'])) {
							foreach ($product['general']['related_product'] as $pk => $pv) {
								if (empty($val)) {
									$val = $pv['model'];
								} else {
									$val = $val . $sep . $pv['model'];
								}
							}
						}
					}

				} elseif ($ck == 'additional_image') {
					
					if ($this->config->get('ka_pe_images_in_one_cell') != 'Y') {
					
						$val = (!empty($product['general']['additional_image'][$row_num-1])) ? $product['general']['additional_image'][$row_num-1] : '';
						
					} else {
						if (!empty($product['general']['additional_image'])) {
							foreach ($product['general']['additional_image'] as $pk => $pv) {
								if (empty($val)) {
									$val = $pv;
								} else {
									$val = $val . $sep . $pv;
								}
							}
						}
					}

				} elseif ($ck == 'model') {
					$val = $product['general']['model'];

				} elseif ($ck == 'product_id') {
					$val = $product['general']['product_id'];

				} elseif ($row_num == 1) {
					if (empty($cv['model'])) {
						$val = $product['general'][$ck];

						if (!empty($cv['type'])) {
							$val = $this->format($val, $cv['type']);
						}
					} else {
						$val = $cv->model->extendValue($product, 'general', $cv, $row_num);
					}
				}

				$row[] = $val;
			}
		}

		
		if (!empty($columns['attributes'])) {
			foreach ($columns['attributes'] as $ak => $av) {
				if (!empty($av['checked'])) {
					$row[] = ($row_num == 1 && !empty($product['attributes'][$ak])) ? $product['attributes'][$ak] : '';
				}
			}
	 	}

		if (!empty($columns['filter_groups'])) {
		
			foreach ($columns['filter_groups'] as $fgk => $fgv) {
				if (!empty($fgv['checked'])) {
					$row[] = (!empty($product['filter_groups'][$fgk][$row_num-1])) ? $product['filter_groups'][$fgk][$row_num-1] : '';
				}
			}
	 	}

		if (!empty($columns['discounts'])) {
			$rec = (!empty($product['discounts'][$row_num-1])) ? $product['discounts'][$row_num-1] : false;
			foreach ($columns['discounts'] as $ak => $av) {
				if (!empty($av['checked'])) {
					if (isset($rec[$ak])) {
						$val = $rec[$ak];
						if (!empty($av['type'])) {
							$val = $this->format($val, $av['type']);
						}
						
					} else {
						$val = '';
					}
					$row[] = $val;
				}
			}
	 	}

		if (!empty($columns['specials'])) {
			$rec = (!empty($product['specials'][$row_num-1])) ? $product['specials'][$row_num-1] : false;
			foreach ($columns['specials'] as $ak => $av) {
				if (!empty($av['checked'])) {
					if (isset($rec[$ak])) {
						$val = $rec[$ak];
						if (!empty($av['type'])) {
							$val = $this->format($val, $av['type']);
						}
						
					} else {
						$val = '';
					}
					$row[] = $val;
				}
			}
	 	}

		if (!empty($columns['reward_points'])) {
			$rec = (!empty($product['reward_points'][$row_num-1])) ? $product['reward_points'][$row_num-1] : false;
			foreach ($columns['reward_points'] as $ak => $av) {
				if (!empty($av['checked'])) {
					if (isset($rec[$ak])) {
						$val = $rec[$ak];
						if (!empty($av['type'])) {
							$val = $this->format($val, $av['type']);
						}
						
					} else {
						$val = '';
					}
					$row[] = $val;
				}
			}
	 	}

		if (!empty($columns['options'])) {

			// order of these fields must match the order in getHeader function
			//
			$option_keys = array(
				'option_name'     => 'option_name',
				'option_type'     => 'option_type',
				'option_value'    => 'option_value',
				'option_required' => 'option_required',
				'option_image'    => 'option_image',
				'option_sort_order' => 'option_sort_order',

				'ovalue_quantity' => 'ovalue_quantity',
				'ovalue_subtract' => 'ovalue_subtract',
				'ovalue_price'    => 'ovalue_price',
				'ovalue_points'   => 'ovalue_points',
				'ovalue_weight'   => 'ovalue_weight'
			);

			$rec = (!empty($product['product_options'][$row_num-1])) ? $product['product_options'][$row_num-1] : false;
			$data = array();
			foreach ($option_keys as $ak => $av) {
				if (isset($rec[$ak])) {
					$val = $rec[$ak];
					if ($ak == 'option_value') {
						$val = $this->format($val);
					}
					
				} else {
					$val = '';
				}
				$row[] = $val;
			}
	 	}

		if (!empty($this->extendRowSchemes)) {
			for ($i = count($this->extendRowSchemes) - 1; $i >= 0; $i--) {
				if (!$this->extendRowSchemes[$i]->extendRow($product, $columns, $row, $row_num)) {
					$this->report("fillRow: " . $this->extendRowSchemes[$i]->getLastError());
				}
			}
		}
		
		return $row;
	}


	private function getHeader($columns) {
		
		$header = array();

		$sets = array(
			'general'       => array(''), 
			'attributes'    => array('attribute:'),     // this name is located in the template too
			'filter_groups' => array('filter_group:'), 
			'discounts'     => array('discount:'),
			'specials'      => array('special:'),
			'reward_points' => array('reward point:'),
		);

		foreach ($sets as $sk => $sv) {
			if (!empty($columns[$sk]) && is_array($columns[$sk])) {
				foreach ($columns[$sk] as $ck => $cv) {
					if (empty($cv['column'])) {
						$cv['column'] = $sv[0].$cv['name'];
				 	}
				 	$header[] = htmlspecialchars_decode($cv['column']);
				}
			}
		}

		if (!empty($columns['options'])) {
			$extra = array(
				'option:name',
				'option:type',
				'option:value',
				'option:required',
				'option:image',
				'option:sort_order',
				
				'option:quantity',
				'option:subtract',
				'option:price',
				'option:points',
				'option:weight'
			);

			$header = array_merge($header, $extra);
		}

		return $header;
	}


	public function initExport($params) {

		if (empty($params['file'])) {
			$this->lastError = "File parameter is not defined.";
			return false;
		}
		
		// truncate the file
		//
		if (!($h = fopen($params['file'], 'w'))) {
			$this->lastError = "File ($params[file]) cannot be opened.";
			return false;
		}
		fclose($h);
		

		// remove sets if they are not required in the current export
		//
		$sets = array('general', 'attributes', 'filter_groups', 'specials', 'discounts', 'reward_points', 'options');

		foreach($sets as $sk => $sv) {
			if (isset($params['columns'][$sv])) {
				$has_checked = false;
				if (is_array($params['columns'][$sv])) {
					foreach ($params['columns'][$sv] as $csk => $csv) {
						if (!empty($csv['checked'])) {
							$has_checked = true;							
						} else {
							unset($params['columns'][$sv][$csk]);
						}
					}
				}

				if (!$has_checked) {
					unset($params['columns'][$sv]);
				}
			}
		}

		$this->params = $params;
		$this->params['prefix_with_space'] = $this->config->get('ka_pe_prefix_with_space');
		
		$this->stat = array(
			'offset'           => 0,

			'started_at'       => time(),

			'lines_processed'    => 0,
			'products_processed' => 0,
			'products_total'     => 0,
			'file_size'          => 0,

			'errors'           => array(),
			'status'           => 'not_started',
		);

		$query_where = array();
		$query_join  = '';
		
		if ($this->params['products_from_categories'] == 'selected') {
			if (!empty($params['category_ids'])) {
				$query_where[] = "ptc.category_id IN ('" . implode("','", $this->params['category_ids']) . "')";
				
				$query_join .= " LEFT JOIN " . DB_PREFIX . "product_to_category ptc ON p.product_id = ptc.product_id ";
			}
		}
		
		if ($this->params['products_from_manufacturers'] == 'selected') {
			if (!empty($params['manufacturer_ids'])) {
				$query_where[] = "p.manufacturer_id IN ('" . implode("','", $this->params['manufacturer_ids']) . "')";
			}
		}
		
		if (!empty($query_where)) {
			$query_where = " WHERE " . implode(' AND ', $query_where);
		} else {
			$query_where = "";
		}

		$query_str = "SELECT COUNT(p.product_id) AS total FROM " . DB_PREFIX . "product p";
		if (!empty($query_join)) {
			$query_str .= $query_join;
		}		

		$query_str .= $query_where;
		
		$qry = $this->db->query($query_str);
		
		if (empty($qry)) {
			$this->report("No products found for specified conditions");
			return false;
		}

		$this->stat['products_total'] = $qry->row['total'];

		$this->ka_log->write("Export started. Parameters: " . var_export($this->stat, true));
		return true;
	}


	/*
		function updates $this->stat array.
		
		Status can be determined by 
			$this->stat['status']  - completed, in_progress, error, not_started
			$this->stat['message'] - last fatal error
	*/
	public function process() {

		if ($this->stat['status'] == 'completed') {
			return;
		}

		$max_execution_time = @ini_get('max_execution_time');
		if ($max_execution_time > 5 && $max_execution_time < $this->sec_per_cycle) {
			$this->sec_per_cycle = $max_execution_time - 3;
		}

		$started_at = time();

		if (($handle = $this->fopen_utf8($this->params['file'], "a", $this->params['charset'])) == FALSE) {
			$this->addExportMessage("Cannot open file: " . $this->params['file'], 'E');
			$this->stat['status']  = 'error';
			return;
		}
		
		if (empty($this->params['columns'])) {
			$this->addExportMessage("Columns are undefined", 'E');
			$this->stat['status']  = 'error';
			return;
		}

		$from = $this->stat['products_processed'];
		if ($from == 0) {

			$row = $this->getHeader($this->params['columns']);
			
			if (!fputcsv($handle, $row, $this->params['delimiter'], $this->enclosure)) {
						
				$this->addExportMessage("Cannot write header to '$this->params[file]'", 'E');
				return;
			}
			
			$query_where   = " WHERE 1 ";
			$query_join    = '';
			
			if ($this->params['products_from_categories'] == 'selected') {
				if (!empty($this->params['category_ids'])) {
					$query_where .= " AND ptc.category_id IN ('" . implode("','", $this->params['category_ids']) . "')";
					$query_join .= " LEFT JOIN " . DB_PREFIX . "product_to_category ptc ON p.product_id = ptc.product_id ";
				}
			}

			if ($this->params['products_from_manufacturers'] == 'selected') {
				if (!empty($this->params['manufacturer_ids'])) {
					$query_where .= " AND p.manufacturer_id IN ('" . implode("','", $this->params['manufacturer_ids']) . "')";
				}
			}

			$query_str = "SELECT p.product_id FROM " . DB_PREFIX . "product p";
			if (!empty($query_join)) {
				$query_str .= $query_join;
			}
			$query_orderby = " ORDER BY p.model ";
			$query_str .= $query_where . $query_orderby;
			
			$this->stat['query'] = $query_str;
		}

		$status = '';
		$products_per_request = 50;

		do {
		
			$query_limit = " LIMIT " . $this->stat['products_processed'] . ", $products_per_request";
			$res = $this->db->query($this->stat['query'] . $query_limit);
	
			if (!empty($res->row)) {
		
				foreach ($res->rows as $pk => $pv) {
				
				  $this->stat['products_processed']++;

					$product = $this->getProduct($pv['product_id'], $this->params['columns'], $this->params['language_id'], $this->params['store_id']);
					
					$rows_required_num = $this->calcRowsRequiredNumber($product, $this->params['columns']);
			
					for ($i = 1; $i <= $rows_required_num; $i++) {
						$row = $this->fillRow($product, $this->params['columns'], $i);

						if (empty($row)) {
							$this->report("Empty product data. Productid=$pv[product_id]");
							continue;
						}
					
						if (!fputcsv($handle, $row, $this->params['delimiter'], $this->enclosure)) {
							$this->report("Nothing was written to $pv[product_id]");
							continue;
						}
						
						$this->stat['lines_processed']++;
					}

					if (time() - $started_at > $this->sec_per_cycle) {
						$status = 'in_progress';
						break;
					}
				}
				
			} else {
				$status = "completed";
			}

		} while (empty($status));

	    if ($status == 'completed') {
    		$this->stat['status'] = 'completed';
    		$this->ka_log->write("Export completed. Parameters: " . var_export($this->stat, true));

    		if (!empty($this->params['copy_path'])) {
    		
    			try {
    				$store_root_dir = dirname(DIR_APPLICATION);
	    			copy($this->params['file'], $store_root_dir . '/' . $this->strip($this->params['copy_path'], array('/', '\\')));
	    			
	    		} catch (Exception $err) {
	    			$this->ka_log->write("File not copied to:" . $this->params['copy_path']);
	    		}
    		}
    		
	    } else if ($status == 'error') {
			$this->stat['status'] = $status;

		} else {
			$this->stat['status'] = 'in_progress';
		}
    	fclose($handle);

    	$this->stat['file_size'] = filesize($this->params['file']);
    	
    	return;
	}

	
	public function getProfiles() {
		$qry = $this->db->query("SELECT export_profile_id, name FROM " . DB_PREFIX . "ka_export_profiles");

		$profiles = array();				
		if (!empty($qry->rows)) {
			foreach ($qry->rows as $row) {
				$profiles[$row['export_profile_id']] = $row['name'];
			}
		}
				
		return $profiles;
	}


	public function deleteProfile($profile_id) {

		$this->db->query("DELETE FROM " . DB_PREFIX. "ka_export_profiles WHERE export_profile_id = '" . $this->db->escape($profile_id) . "'");
			
		return true;
	}
	
		
	/*
		returns:
			array - on success
			false - on error
	*/
	public function getProfileParams($profile_id) {
	
		$qry = $this->db->query("SELECT * FROM " . DB_PREFIX . "ka_export_profiles WHERE export_profile_id = '" . $this->db->escape($profile_id) . "'");
		if (empty($qry->rows)) {
			return false;
		}

		if (!empty($qry->row['params'])) {
			$params = unserialize($qry->row['params']);
		} else {
			$params = array();
		}

		return $params;
	}
	
	
	/*
		returns:
			true  - on success
			false - on error
	*/
	public function setProfileParams($profile_id, $name, $params) {
	
		if (empty($profile_id)) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "ka_export_profiles
				SET 
					name = '" . $this->db->escape($name) . "'
			");
			$profile_id = $this->db->getLastId();
		}
		
		$this->db->query("UPDATE " . DB_PREFIX . "ka_export_profiles
			SET 
				name = '" . $this->db->escape($name) . "',
				params = '" . $this->db->escape(serialize($params)) . "'
			WHERE
				export_profile_id = '" . $this->db->escape($profile_id) . "'
		");

		return true;
	}


	/*
		Extends array with custom fields from the product table only.
		
	*/	
	protected function addCustomProductFields(&$fields) {
		$default_fields = array('product_id', 'model', 'sku', 'upc', 'ean', 'jan', 'isbn', 'mpn',
			'location', 'quantity', 'stock_status_id', 'image', 'manufacturer_id', 'shipping',
			'price', 'points', 'tax_class_id', 'date_available', 'weight', 'weight_class_id',
			'length', 'width', 'height', 'length_class_id', 'subtract', 'minimum', 'sort_order',
			'status', 'date_added', 'date_modified', 'viewed'
		);
		
		if (!empty($fields)) {
			foreach ($fields as $field) {
				$default_fields[] = $field['field'];
			}
		}
	
		$qry = $this->db->query('SHOW FIELDS FROM ' . DB_PREFIX . 'product');
		if (empty($qry->rows)) {
			return false;
		}
		
		foreach ($qry->rows as $row) {
			if (in_array($row['Field'], $default_fields)) {
				continue;
			}
			
			$field = array(
				'field' => $row['Field'],
				'copy'  => true,
				'name'  => $row['Field'],
				'descr' => 'Custom field. Type: ' . $row['Type']
			);
			
			$fields[$row['Field']] = $field;
		}
		
		return true;
	}
	

	public function getFieldSets() {

		/* array fields:
			key      - code name of the exported column			
			field    - possible product name
			required - field must be exported
			copy     - product field will be copied to the file as is
			name     - product name and initial column name
			descr    - field description
			column   - added on the second export step to specify column names
		*/
	
		$fields = array(
			'model' => array(
				'field' => 'model',
				'copy'  => true,
				'name'  => $this->language->get('Model'),
				'descr' => $this->language->get('A unique product code required by Opencart')
			),
			'sku' => array(
				'field' => 'sku',
				'copy'  => true,
				'name'  => 'SKU',
				'descr' => ''
			),
			'upc' => array(
				'field' => 'upc',
				'copy'  => true,
				'name'  => $this->language->get('UPC'),
				'descr' => $this->language->get('Universal Product Code'),
			),
		);
		
		$fields2 = array(
			'name' => array(
				'field' => 'name',
				'name'  => $this->language->get('Name'),
				'descr' => $this->language->get('Product name'),
			),
			'description' => array(
				'field'    => 'description',
				'name'     => $this->language->get('Description'),
				'descr'    => $this->language->get('Product description'),
			),
			'category' => array(
				'field'    => 'category',
				'name'     => $this->language->get('Category'),
				'descr'    => $this->language->get('Full category path. If the field is not defined or empty then the default category will be used.'),
			),
			'location' => array(
				'field' => 'location',
				'copy'  => true,
				'name'  => $this->language->get('Location'),
				'descr' => ''
			),
			'quantity' => array(
				'field' => 'quantity',
				'copy'  => true,
				'name'  => $this->language->get('Quantity'),
				'descr' => ''
			),			
			'minimum' => array(
				'field' => 'minimum',
				'copy'  => true,
				'name'  => $this->language->get('Minimum Quantity'),
				'descr' => ''
			),
			'subtract' => array(
				'field' => 'subtract',
				'copy'  => true,
				'name'  => $this->language->get('Subtract Stock'),
				'descr' => ''
			),
			'stock_status' => array(
				'field' => 'stock_status',
				'name'  => $this->language->get('Out of Stock Status'),
				'descr' => ''
			),			 
			'shipping' => array(
				'field' => 'shipping',
				'copy'  => true,
				'name'  => $this->language->get('Requires Shipping'),
				'descr' => ''
			),
			'status' => array(
				'field' => 'status',
				'copy'  => true,
				'name'  => $this->language->get('Status'),
				'descr' => ""
			),			
			'image' => array(
				'field' => 'image',
				'name'  => $this->language->get('Image file'),
				'descr' => $this->language->get('Relative server directory path or URL')
			),
			'additional_image' => array(
				'field' => 'additional_image',
				'name'  => $this->language->get('Additional Image files'),
				'descr' => $this->language->get('Relative server directory path or URL')
			),
			'manufacturer' => array(				
				'field' => 'manufacturer',
				'name'  => $this->language->get('Manufacturer'),
				'descr' => $this->language->get('Manufacturer name')
			),
			'price' => array(
				'field' => 'price',
				'name'  => $this->language->get('Price'),
				'descr' => $this->language->get('Regular product price in the selected currency'),
			),
			'tax_class' => array(
				'field' => 'tax_class',
				'name'  => $this->language->get('Tax class'),
				'descr' => $this->language->get('Tax class name')
			),			
			'weight' => array(
				'field' => 'weight',
				'name'  => $this->language->get('Weight'),
				'descr' => ''
			),
			'length' =>	array(
				'field' => 'length',
				'name'  => $this->language->get('Length'),
				'descr' => ''
			),
			'width' => array(
				'field' => 'width',
				'name'  => $this->language->get('Width'),
				'descr' => ''
			),
			'height' => array(
				'field' => 'height',
				'name'  => $this->language->get('Height'),
				'descr' => ''
			),
			'meta_keyword' => array(
				'field' => 'meta_keyword',
				'name'  => $this->language->get('Meta tag keywords'),
				'descr' => ''
			),
			'meta_description' => array(
				'field' => 'meta_description',
				'name'  => $this->language->get('Meta tag description'),
				'descr' => ''
			),
			'points' => array(
				'field' => 'points',
				'copy'  => true,
				'name'  => $this->language->get('Points Required'),
				'descr' => $this->language->get('Number of reward points required to make purchase')
			),
			'sort_order' => array(
				'field' => 'sort_order',
				'copy'  => true,
				'name'  => $this->language->get('Sort Order'),
				'descr' => ''
			),
			'seo_keyword' => array(
				'field' => 'seo_keyword',
				'name'  => $this->language->get('SEO Keyword'),
				'descr' => ''
			),
			'product_tags' => array(
				'field' => 'product_tags',
				'name'  => $this->language->get('Product Tags'),
				'descr' => $this->language->get('List of product tags separated by comma')
			),
			'date_available' => array(
				'field' => 'date_available',
				'copy'  => true,
				'type'  => 'date',
				'name'  => $this->language->get('Date Available'),
				'descr' => $this->language->get('Format: YYYY-MM-DD')
			),
			'product_url' => array(
				'field' => 'product_url',
				'name'  => $this->language->get('Product URL'),
				'descr' => ''
			),
			'date_added' => array(
				'field' => 'date_added',
				'copy'  => true,
				'type'  => 'date',
				'name'  => $this->language->get('Date Added'),
				'descr' => $this->language->get('Time when the product was added to the store (Format: YYYY-MM-DD HH:MM:SS)')
			),			
			'date_modified' => array(
				'field' => 'date_modified',
				'copy'  => true,
				'type'  => 'date',
				'name'  => $this->language->get('Date Modified'),
				'descr' => $this->language->get('Last time when product was modified (Format: YYYY-MM-DD HH:MM:SS)')
			),
			'related_product' => array(
				'field' => 'related_product',
				'name'  => $this->language->get('Related Product'),
				'descr' => $this->language->get('model identifiers of related products'),
			),
		);
		
		
		if (version_compare(VERSION, '1.5.4', '>=')) {
			$fields_ver154 = array(
				'ean' => array(
					'field' => 'ean',
					'copy'  => true,
					'name'  => 'EAN',
					'descr' => $this->language->get('European Article Number'),
				),
				'jan' => array(
					'field' => 'jan',
					'copy'  => true,
					'name'  => 'JAN',
					'descr' => $this->language->get('Japanese Article Number'),
				),
				'isbn' => array(
					'field' => 'isbn',
					'copy'  => true,
					'name'  => 'ISBN',
					'descr' => 'International Standard Book Number',
				),
				'mpn' => array(
					'field' => 'mpn',
					'copy'  => true,
					'name'  => 'MPN',
					'descr' => 'Manufacturer Part Number',
				),
			);
			
			$fields = array_merge($fields, $fields_ver154);
		}
				
		$fields = array_merge($fields, $fields2);
		
		if ($this->config->get('ka_pe_enable_product_id') == 'Y') {
			$custom_fields = array(
				'product_id' => array(
					'field' => 'product_id',
					'required' => false,
					'copy'  => true,
					'name'  => 'Product ID',
					'descr' => 'product ID'
				),
			);
			$fields = array_merge($custom_fields, $fields);
		}

		$this->addCustomProductFields($fields);
				
		$discounts = array(
			'customer_group' => array(
				'field' => 'customer_group',
				'name'  => $this->language->get('Customer Group'),
				'descr' => ''
			),
			'quantity' => array(
				'field' => 'quantity',
				'name'  => $this->language->get('Quantity'),
				'descr' => ''
			),
			'priority' => array(
				'field' => 'priority',
				'name'  => $this->language->get('Prioirity'),
				'descr' => ''
			),
			'price' => array(
				'field' => 'price',
				'name'  => $this->language->get('Price'),
				'descr' => ''
			),
			'date_start' => array(
				'field' => 'date_start',
				'name'  => $this->language->get('Date Start'),
				'type'  => 'date',				
				'descr' => ''
			),
			'date_end' => array(
				'field' => 'date_end',
				'name'  => $this->language->get('Date End'),
				'type'  => 'date',
				'descr' => ''
			),
		);			

		$specials = array(
			'customer_group' => array(
				'field' => 'customer_group',
				'name'  => $this->language->get('Customer Group'),
				'descr' => ''
			),
			'priority' => array(
				'field' => 'priority',
				'name'  => $this->language->get('Prioirity'),
				'descr' => ''
			),
			'price' => array(
				'field' => 'price',
				'name'  => $this->language->get('Price'),
				'descr' => ''
			),
			'date_start' => array(
				'field' => 'date_start',
				'name'  => $this->language->get('Date Start'),
				'type'  => 'date',
				'descr' => ''
			),
			'date_end' => array(
				'field' => 'date_end',
				'name'  => $this->language->get('Date End'),
				'type'  => 'date',
				'descr' => ''
			),
		);			

		$reward_points = array(
			array(
				'field' => 'customer_group',
				'name'  => $this->language->get('Customer Group'),
				'descr' => '',
			),
			array(
				'field' => 'points',
				'name'  => $this->language->get('Reward Points'),
				'descr' => '',
			),
		);

		$this->load->model('catalog/attribute');
		$attributes  = $this->model_catalog_attribute->getAttributes();

		if (version_compare(VERSION, '1.5.5', '>=')) {
			$this->load->model('catalog/filter');
			$filter_groups  = $this->model_catalog_filter->getFilterGroups();
		} else {
			$filter_groups = false;
		}
				
		$this->load->model('catalog/option');
		$options    = $this->model_catalog_option->getOptions();
		
		$sets = array(
			'general'       => $fields,
			'attributes'    => $attributes,
			'filter_groups' => $filter_groups,
			'options'       => $options,	
			'discounts'     => $discounts,
			'specials'      => $specials,
			'reward_points' => $reward_points,
		);
		
		if (!empty($this->extendFieldSetSchemes)) {
			for ($i = count($this->extendFieldSetSchemes) - 1; $i >= 0; $i--) {
				if (!$this->extendFieldSetSchemes[$i]->extendFieldSets($sets)) {
					$this->report("fieldSets: " . $this->extendFieldSetSchemes[$i]->getLastError());
				}
			}
		}

		return $sets;
	}


	public function getCharsets() {
		$arr = array(
			'ISO-8859-1'   => 'ISO-8859-1 (Western Europe)',
			'ISO-8859-5'   => 'ISO-8859-5 (Cyrillc, DOS)',
			'KOI-8R'       => 'KOI-8R (Cyrillic, Unix)',
			'UTF-16LE'     => 'UNICODE (MS Excel text format)',
			'UTF-8'        => 'UTF-8',
			'windows-1250' => 'windows-1250 (Central European languages)',
			'windows-1251' => 'windows-1251 (Cyrillc)',
			'windows-1252' => 'windows-1252 (Western languages)',
			'windows-1253' => 'windows-1253 (Greek)',
			'windows-1254' => 'windows-1254 (Turkish)',
			'windows-1255' => 'windows-1255 (Hebrew)',
			'windows-1256' => 'windows-1256 (Arabic)',
			'windows-1257' => 'windows-1257 (Baltic languages)',
			'windows-1258' => 'windows-1258 (Vietnamese)',
			'CP932'        => 'CP932 (Japanese)',
		);

		return $arr;
	}
	
	
	/*
		
	
	*/
	public function requestSchedulerOperations() {
	
		if (!$this->db->isKaInstalled('ka_export')) {
			return false;
		}
	
		$ret = array(
			'export' => 'Export'
		);
	
		return $ret;
	}
	
	
	public function requestSchedulerOperationParams($operation) {
	
		$ret = array(
			'profile' => array(
				'title' => 'Export Profile',
				'type'  => 'select',
				'required' => true,
			),
		);

		$ret['profile']['options'] = $this->getProfiles();

		return $ret;
	}

			
	protected function initSchedulerExport($profile_id) {
	
		/*
				'charset'             => 'UTF-8'
				'cat_separator'       => '///',
				'delimiter'           => 's',
				'store_id'            => array(0),
				'sort_by'             => 'name',
				'image_path'          => 'path',
				'products_from_categories'  => 'all',
				'products_from_manufacturers' => 'all',
				'category_ids'        => array(),
				'manufacturer_ids'    => array(),
		*/			
		$params = $this->getProfileParams($profile_id);
		if (empty($params)) {
			$this->lastError = "Profile not found";
			return false;
		}
		
		if (!$this->initExport($params)) {
			return false;
		}

		return true;
	}


	/*
		return a code:			
			finished      - export is complete
			not_finished  - still working (additional runs needed)
	*/
	public function runSchedulerOperation($operation, $params, &$stat) {

		$ret = 'finished';

		if (!$this->db->isKaInstalled('ka_export')) {
			return $ret;
		}
		
		if (version_compare(VERSION, '1.5.5', '>=')) {
			$this->language->load('tool/ka_export');
		} else {
			$this->load->language('tool/ka_export');
		}

		if ($operation != 'export') {
			$stats['error'] = "Unsupported operation code";
			return $ret;
		}

		if (empty($params['profile'])) {
			$stats['error'] = "Unsupported parameters were passed to the module.";
			return $ret;
		}

		if (empty($this->params) || empty($stat)) {
			if (!$this->initSchedulerExport($params['profile'])) {
				return $ret;
			}
		}

		$this->process();

		$stat = array();
		$stat['Lines Processed']    = $this->stat['lines_processed'];
		$stat['Products Processed'] = $this->stat['products_processed'];
		$stat['Products Total']     = $this->stat['products_total'];
		$stat['Time Passed']        = $this->time_format(time() - $this->stat['started_at']);
		$stat['File Size']          = $this->convertToMegabyte($this->stat['file_size']);
		
		if ($this->stat['status'] == 'in_progress') {
			$stat['Completion At'] = sprintf("%.2f%%", $this->stat['products_processed'] * 100 / $this->stat['products_total']);
			$ret = 'not_finished';
			
		} elseif ($this->stat['status'] == 'completed') {
			$stat['Completion At'] = sprintf("%.2f%%", 100);
			$ret = 'finished';
		}

		return $ret;
	}
	
	
	public function loadSchemes() {
		global $vqmod;
	
		$models = array();
			
		if (!is_dir(DIR_APPLICATION . 'model/tool/ka_schemes')) {
			return false;
		}
		
		$files = glob(DIR_APPLICATION . 'model/tool/ka_schemes/*.php');

		foreach ($files as $file) {
			$file = str_replace(DIR_APPLICATION . 'model/', '', $file);
			$name = basename($file, '.php');
			if ($name == 'ka_scheme') {
				continue;
			}
			
			$model = dirname($file) . '/' . $name;
			$models[] = $model;
		}
		
		if (empty($models)) {
			return false;
		}
		
		foreach ($models as $model) {

			$file = DIR_APPLICATION . 'model/' . $model . '.php';
			
			if (!empty($vqmod)) {
				$file = $vqmod->modCheck($file);
			}
						
			if (!file_exists($file)) {
				continue;
			}

			@include_once($file);
			
			$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $model);

			if (!class_exists($class)) {
				continue;
			}
			
			$methods = get_class_methods($class);
			if (empty($methods)) {
				continue;
			}

			$this->load->model($model);
			$name = 'model_' . str_replace('/', '_', $model);
			
			if (in_array('extendFieldSets', $methods)) {
				$this->extendFieldSetSchemes[] = &$this->$name;
			}
			
			if (in_array('extendProduct', $methods)) {
				$this->extendProductSchemes[] = &$this->$name;
			}

			if (in_array('extendValue', $methods)) {
				$this->extendValueSchemes[] = &$this->$name;
			}
			
			if (in_array('extendRow', $methods)) {
				$this->extendRowSchemes[] = &$this->$name;
			}			
		}
	}
}
?>