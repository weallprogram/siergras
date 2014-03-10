<?php
/*
	Project: CSV Product Export
	Author : karapuz <support@ka-station.com>

	Version: 3.2 ($Revision: 9 $)

*/

require_once(DIR_SYSTEM . 'engine/ka_controller.php');

class ControllerToolKaExport extends KaController { 
	protected $tmp_dir;
	protected $store_root_dir;
	protected $store_images_dir;

	protected function isDBPrepared() {
		
		$tbl = DB_PREFIX . "ka_export_profiles";
		$res = $this->db->query("SHOW TABLES LIKE '$tbl'");

		if (empty($res->rows)) {
			return false;
		}

		return true;
	}
	
	
 	public function flush() {
		$x = str_repeat(' ', 1024);
		$this->response->setOutput($x);
		$this->response->output();
		flush();
	}


	protected function upload_max_filesize() {
		static $max_filesize;

		if (!isset($max_filesize)) {
			$post_max_size       = $this->model_tool_ka_export->convertToByte(ini_get('post_max_size'));
			$upload_max_filesize = $this->model_tool_ka_export->convertToByte(ini_get('upload_max_filesize'));
			$max_filesize        = intval(min($post_max_size, $upload_max_filesize));
		}

    	return $max_filesize;
 	}


	protected function init() {

		$this->tmp_dir          = DIR_CACHE;
		$this->store_root_dir   = dirname(DIR_APPLICATION);
		$this->store_images_dir = dirname(DIR_IMAGE) . DIRECTORY_SEPARATOR . basename(DIR_IMAGE);

		if (!$this->validate()) {
			return $this->forward('error/permission');
		}
		
		$this->load->model('tool/ka_export');

		if (!$this->model_tool_ka_export->isInstalled()) {
			return $this->redirect($this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'));
		}

 		$this->loadLanguage('tool/ka_export');
		$this->data['heading_title']    = $this->language->get('heading_title');

		$this->data['store_images_dir'] = $this->store_images_dir;
		$this->data['store_root_dir']   = $this->store_root_dir;

		$this->data['breadcrumbs'] = array();
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => FALSE
		);
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/ka_export', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		$this->children = array(
			'common/header',
			'common/footer',
		);
		
		return true;
	}


	protected function prepareOutput() {
		$this->document->setTitle($this->data['heading_title']);

		$this->response->setOutput($this->render());
	}


	protected function validate() {
		if (!$this->user->hasPermission('modify', 'tool/ka_export')) {
			return FALSE;
		}

		return TRUE;
	}


	protected function getStores() {

		$this->load->model('setting/store');
		$stores = $this->model_setting_store->getStores();

		$stores[] = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name') . $this->language->get('text_default'),
			'url'      => HTTP_CATALOG,
		);

		return $stores;
	}

	
	// 
	// public actions
	//
	
	public function index() { // step1
	
		$this->init();
		
		// do we need to re-install the extension?
		//
		if (!$this->isDBPrepared()) {
			$this->data['is_wrong_db'] = true;
			$this->template = 'tool/ka_export.tpl';
			$this->prepareOutput();
			return;
		}

		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('localisation/currency');
		$this->data['currencies'] = $this->model_localisation_currency->getCurrencies();

		$profiles = $this->model_tool_ka_export->getProfiles();
		$this->data['profiles'] = $profiles;
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$msg = '';

			if ($this->request->post['mode'] == 'load_profile') {
			
				$this->params = $this->model_tool_ka_export->getProfileParams($this->request->post['profile_id']);

				$this->params['profile_id'] = $this->request->post['profile_id'];
				$this->session->data['save_params'] = true;
				$this->addTopMessage("Profile has been loaded succesfully");
				
				return $this->redirect($this->url->link('tool/ka_export', 'token=' . $this->session->data['token'], 'SSL'));
				
			} elseif ($this->request->post['mode'] == 'delete_profile') {
			
				$this->model_tool_ka_export->deleteProfile($this->request->post['profile_id']);
				$this->session->data['save_params'] = true;
				$this->addTopMessage("Profile has been deleted succesfully");
				
				return $this->redirect($this->url->link('tool/ka_export', 'token=' . $this->session->data['token'], 'SSL'));
			}
					
			$this->params['cat_separator']  = $this->request->post['cat_separator']; 
			$this->params['delimiter']      = $this->request->post['delimiter'];
			$this->params['language_id']    = $this->request->post['language_id'];
			$this->params['copy_path']      = $this->request->post['copy_path']; 
			
			// we store the entire currency array in the variable
			$this->params['currency']       = $this->data['currencies'][$this->request->post['currency']];
			
			$this->params['store_id']           = $this->request->post['store_id'];
			$this->params['image_path']         = $this->request->post['image_path'];
			
			$this->params['products_from_categories']    = $this->request->post['products_from_categories'];			
			$this->params['products_from_manufacturers'] = $this->request->post['products_from_manufacturers'];

			$this->params['apply_taxes']        = (!empty($this->request->post['apply_taxes'])) ? true:false;
			$this->params['use_special_price']  = (!empty($this->request->post['use_special_price'])) ? true:false;
			
			$this->params['charset_option'] = $this->request->post['charset_option']; 
			if ($this->params['charset_option'] == 'predefined') {
				$this->params['charset']        = $this->request->post['charset']; 
			} else {
				$this->params['charset'] = $this->request->post['custom_charset']; 
			}

			if ($this->params['products_from_categories'] == 'selected') {
				if (empty($this->request->post['category_ids'])) {
					$msg = "Please specify what products you want to export.";
				} else {
					$this->params['category_ids'] = $this->request->post['category_ids'];
				}
			}

			if ($this->params['products_from_manufacturers'] == 'selected') {
				if (empty($this->request->post['manufacturer_ids'])) {
					$msg = "Please specify what products you want to export.";
				} else {
					$this->params['manufacturer_ids'] = $this->request->post['manufacturer_ids'];
				}
			}

			if (!empty($msg)) {
				$this->addTopMessage($msg, 'E');
				$this->session->data['save_params'] = true;
			 	return $this->redirect($this->url->link('tool/ka_export', 'token=' . $this->session->data['token'], 'SSL'));
			}

			return $this->redirect($this->url->link('tool/ka_export/step2', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if (empty($this->params) || ($this->request->server['REQUEST_METHOD'] == 'GET' && empty($this->session->data['save_params']))) {
		
			$this->params = array(
				'charset'             => 'UTF-8', // 'UTF-16LE' - MS Excel
				'charset_option'      => 'predefined',
				'cat_separator'       => '///',
				'delimiter'           => 's',
				'store_id'            => array(0),
				'sort_by'             => 'name',
				'image_path'          => 'path',
				'products_from_categories'    => 'all',
				'products_from_manufacturers' => 'all',
				'category_ids'        => array(),
				'manufacturer_ids'    => array(),
				'profile_name'        => '',
				'profile_id'          => '',
				'copy_path'           => '',
				'geo_zone_id'         => '',
				'customer_group_id'   => 0,
				'apply_taxes'         => false,
				'use_special_price'   => false,
			);

			$language_code = $this->config->get('config_language');
			if (!empty($this->data['languages'][$language_code])) {
				$this->params['language_id'] = $this->data['languages'][$language_code]['language_id'];
			} else {
				$this->params['language_id'] = 0;
			}
			$currency_code = $this->config->get('config_currency');
			if (!empty($this->data['currencies'][$currency_code])) {
				$this->params['currency'] = $this->data['currencies'][$currency_code];
			} else {
				$this->params['currency']= array('code' => $currency_code);
			}
			
			$this->params['file'] = $this->model_tool_ka_export->tempname(DIR_CACHE, "export_" . date("Y-m-d") . '_', 'csv');
	 	}
	 	
	 	$this->params['step']          = 1;
		$this->params['iconv_exists']  = function_exists('iconv');
		$this->params['filter_exists'] = in_array('convert.iconv.*', stream_get_filters());
	 	
	 	$this->session->data['save_params'] = false;

		$this->load->model('setting/store');
		$this->data['stores']     = $this->getStores();
		
		$this->load->model('localisation/geo_zone');
		$this->data['geo_zones']  = $this->model_localisation_geo_zone->getGeoZones();

		$this->load->model('sale/customer_group');
		$this->data['customer_groups']  = $this->model_sale_customer_group->getCustomerGroups();
				
		$this->load->model('catalog/category');		
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);
		$this->load->model('catalog/manufacturer');		
		$this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();
		$this->data['charsets']   = $this->model_tool_ka_export->getCharsets();

		$this->data['action']    = $this->url->link('tool/ka_export', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['params']    = $this->params;

		$this->data['max_file_size'] = $this->model_tool_ka_export->convertToMegabyte($this->upload_max_filesize());

		$this->template = 'tool/ka_export.tpl';
		return $this->prepareOutput();
	}


	public function step2() { // step2

		$this->init();
		$this->params['step'] = 2;
		$sets = $this->model_tool_ka_export->getFieldSets();

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->params['columns'] = $this->request->post['columns'];
			
			if (!empty($this->params['columns'])) {

				// 1) fill in the type column (it is used for 'date' only at this time)
				// 2) trim custom column names
				//
				foreach (array('general', 'attributes', 'specials', 'discounts') as $set_name) {
					if (!empty($this->params['columns'][$set_name])) {
						foreach ($this->params['columns'][$set_name] as $col_name => &$col_data) {
							if (!empty($sets[$set_name][$col_name]['type'])) {
								$col_data['type'] = $sets[$set_name][$col_name]['type'];
							}
							if (isset($col_data['column'])) {
								$col_data['column'] = trim($col_data['column']);
							}
						}
					}
				}
			}
			
			if ($this->request->post['mode'] == 'save_profile') {
			
				if (empty($this->request->post['profile_name'])) {
					$this->addTopMessage("Profile name is empty", "E");
					
				} else {
					if ($this->model_tool_ka_export->setProfileParams($this->request->post['profile_id'], $this->request->post['profile_name'], $this->params)) {
						$this->addTopMessage("Profile has been saved succesfully");
					}
				}
				
				return $this->redirect($this->url->link('tool/ka_export/step2', 'token=' . $this->session->data['token'], 'SSL'));
			}

			$errors_found = false;

			if ($errors_found) {
				return $this->redirect($this->url->link('tool/ka_export/step2', 'token=' . $this->session->data['token'], 'SSL'));
			}
	
			return $this->redirect($this->url->link('tool/ka_export/step3', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['general']       = $sets['general'];
		$this->data['specials']      = $sets['specials'];
		$this->data['discounts']     = $sets['discounts'];
		$this->data['reward_points'] = $sets['reward_points'];
		$this->data['attributes']    = $sets['attributes'];
		$this->data['filter_groups'] = $sets['filter_groups'];
		if (version_compare(VERSION, '1.5.5', '>=')) {
			$this->data['filters_enabled'] = true;
		} else {
			$this->data['filters_enabled'] = false;
		}
		$this->data['options']       = $sets['options'];

		if (!empty($this->params['columns'])) {
			$this->data['columns']    = $this->params['columns'];
		}
		
		$this->data['attribute_page_url'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['filter_page_url']    = $this->url->link('catalog/filter', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['option_page_url']    = $this->url->link('catalog/option', 'token=' . $this->session->data['token'], 'SSL');
    	$this->data['action']             = $this->url->link('tool/ka_export/step2', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['back_action']        = $this->url->link('tool/ka_export', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['params']             = $this->params;

		$this->template = 'tool/ka_export.tpl';

		return $this->prepareOutput();
	}

	
	public function step3() { // step3

		$this->init();
		$this->params['step'] = 3;

		$params = $this->params;

		$params['delimiter'] = strtr($params['delimiter'], array('c'=>',', 's'=>';', 't'=>"\t"));

		if (!$this->model_tool_ka_export->initExport($params)) {
			$this->addTopMessage($this->model_tool_ka_export->getLastError(), 'E');
			return $this->redirect($this->url->link('tool/ka_export/step2', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['done_action']        = $this->url->link('tool/ka_export', 'token=' . $this->session->data['token'], 'SSL');

		if ($this->config->get('ka_pe_direct_download') == 'Y') {
			chmod($params['file'], 0644);
			$this->data['download_link']  = HTTP_CATALOG . 'system/cache/' . basename($params['file']);
		} else {
	    	$this->data['download_link']  = $this->url->link('tool/ka_export/download', 'token=' . $this->session->data['token'], 'SSL');
	    }

		$this->data['params']             = $this->params;

		$sec = $this->model_tool_ka_export->getSecPerCycle();

		$this->data['update_interval']    = $sec.' - ' .($sec + 5);
 		$this->data['page_url'] = str_replace('&amp;', '&', $this->url->link('tool/ka_export/stat', 'token=' . $this->session->data['token'], 'SSL'));
		$this->template = 'tool/ka_export.tpl';

		return $this->prepareOutput();
	}


	/*
		The function is called by ajax script and it outputs information in json format.

		json format:
			status - in progress, completed, error;
			...    - extra export parameters.
	*/
	public function stat() {
		$this->init();

		if ($this->params['step'] != 3) {
			$this->addTopMessage('This script can be requested on the step 3 only', 'E');
			return $this->redirect($this->url->link('tool/ka_export/step2', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->model_tool_ka_export->process($this);

		$stat                  = $this->model_tool_ka_export->getExportStat();
		$stat['messages']      = $this->model_tool_ka_export->getExportMessages();
		$stat['time_passed']   = $this->model_tool_ka_export->time_format(time() - $stat['started_at']);
		$stat['file_size']     = $this->model_tool_ka_export->convertToMegabyte($stat['file_size']);
		
		if ($stat['status'] == 'in_progress') {
			$stat['completion_at'] = sprintf("%.2f%%", $stat['products_processed'] * 100 / $stat['products_total']);
		} elseif ($stat['status'] == 'completed') {
		
			$stat['completion_at'] = sprintf("%.2f%%", 100);
		}
	
 		$this->response->setOutput(json_encode($stat));
	}


	public function download() {
		$this->init();

		$stat = $this->model_tool_ka_export->getExportStat();

		if ($stat['status'] == 'completed') {
			$file = $this->params['file'];
			$name = "export_" . date("Y-m-d") . ".csv";

			if (!headers_sent()) {
				if (file_exists($file)) {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header("Content-Disposition: attachment; filename=\"$name\"");
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));
					
					readfile($file, 'rb');
					
					exit;
				} else {
					exit('Error: Could not find file ' . $file . '!');
				}
			} else {
				exit('Error: Headers were already sent out!');
			}
		} else {
			$this->redirect($this->url->link('tool/ka_export/step2', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	
	public function showSelector($name, $data, $selected = '', $extra = '') {
		$template = new Template();
		$template->data['name']     = $name;
		$template->data['data']     = $data;
		$template->data['selected'] = $selected;
		$template->data['extra']    = $extra;
		$text = $template->fetch("tool/ka_selector_export.tpl");
		echo $text;
 	}
}
?>