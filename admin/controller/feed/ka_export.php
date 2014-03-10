<?php
/*
	Project: CSV Product Export
	Author : karapuz <support@ka-station.com>

	Version: 3.2 ($Revision: 10 $)

*/

require_once(DIR_SYSTEM . 'engine/ka_controller.php');

class ControllerFeedKaExport extends KaController {

	private $error;
	private $extension_version = '3.2.1';
	private $min_store_version = '1.5.1';
	private $max_store_version = '1.5.5.9';
	private $tables;
	private $db_exists = false;

	private function init() {
		
 		$this->tables = array(
 		
 			'product' => array(
 				'fields' => array(),
 				'indexes' => array(
 					'model' => array()
 				)
 			),
 			
 			'ka_export_profiles' => array(
 				'is_new' => true,
 				'fields' => array(
  					'export_profile_id' => array(
  						'type' => 'int(11)',
  					),
  					'name' => array(
  						'type' => 'varchar(128)',
  					), 					
  					'params' => array(
  						'type' => 'mediumtext',
  					),
  				),
				'indexes' => array(
					'PRIMARY' => array(
						'query' => "ALTER TABLE `" . DB_PREFIX . "ka_export_profiles` ADD PRIMARY KEY (`export_profile_id`)",
					),
					'name' => array(
						'query' => "ALTER TABLE `" . DB_PREFIX . "ka_export_profiles` ADD INDEX (`name`)",
					),
				),
			),
		);

		$this->tables['product']['indexes']['model']['query'] = 
			"ALTER TABLE " . DB_PREFIX . "product ADD INDEX (`model`)";

		$this->tables['ka_export_profiles']['query'] = "
			CREATE TABLE `" . DB_PREFIX . "ka_export_profiles` (
			  `export_profile_id` int(11) NOT NULL auto_increment,
			  `name` varchar(128) NOT NULL,
			  `params` mediumtext NOT NULL,
			  PRIMARY KEY  (`export_profile_id`),
			  KEY `name` (`name`)
			) DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		";
		
		return true;
	}

	public function index() {
		$this->loadLanguage('feed/ka_export');

		$heading_title = $this->language->get('heading_title_plain');
		$this->document->setTitle($heading_title);

		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$val = max(5, $this->request->post['ka_pe_update_interval']);
			$this->request->post['ka_pe_update_interval'] = min(25, $val);
			$this->request->post['ka_export_status'] = 'Y'; // displays status on product feeds page
			
			if (empty($this->request->post['ka_pe_direct_download'])) {
				$this->request->post['ka_pe_direct_download'] = '';
			}

			if (empty($this->request->post['ka_pe_prefix_with_space'])) {
				$this->request->post['ka_pe_prefix_with_space'] = '';
			}

			if (empty($this->request->post['ka_pe_enable_product_id'])) {
				$this->request->post['ka_pe_enable_product_id'] = 'N';
			}
			
			if (empty($this->request->post['ka_pe_cats_in_one_cell'])) {
				$this->request->post['ka_pe_cats_in_one_cell'] = '';
			}
			
			if (empty($this->request->post['ka_pe_related_in_one_cell'])) {
				$this->request->post['ka_pe_related_in_one_cell'] = '';
			}

			if (empty($this->request->post['ka_pe_cats_in_one_cell'])) {
				$this->request->post['ka_pe_images_in_one_cell'] = '';
			}
									
			$this->model_setting_setting->editSetting('ka_export', $this->request->post);
			$this->session->data['success'] = $this->language->get('Settings have been stored sucessfully.');
			$this->redirect($this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title']         = $heading_title;
		$this->data['extension_version']     = $this->extension_version;
	
		$this->data['button_save']           = $this->language->get('button_save');
		$this->data['button_cancel']         = $this->language->get('button_cancel');

		$this->data['ka_pe_update_interval']     = $this->config->get('ka_pe_update_interval');
		$this->data['ka_pe_direct_download']     = $this->config->get('ka_pe_direct_download');
		$this->data['ka_pe_prefix_with_space']   = $this->config->get('ka_pe_prefix_with_space');
		$this->data['ka_pe_enable_product_id']   = $this->config->get('ka_pe_enable_product_id');
		$this->data['ka_pe_cats_in_one_cell']    = $this->config->get('ka_pe_cats_in_one_cell');
		$this->data['ka_pe_related_in_one_cell'] = $this->config->get('ka_pe_related_in_one_cell');
		$this->data['ka_pe_images_in_one_cell']  = $this->config->get('ka_pe_images_in_one_cell');
		
		$this->data['ka_pe_general_sep']       = $this->config->get('ka_pe_general_sep');

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
   			'text'      => $this->language->get('text_feed'),
			'href'      => $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'),
	   		'separator' => ' :: '
  		);
		
 		$this->data['breadcrumbs'][] = array(
   		'text'      => $heading_title,
			'href'      => $this->url->link('feed/ka_export', 'token=' . $this->session->data['token'], 'SSL'),
   		'separator' => ' :: '
 		);
		
		$this->data['action'] = $this->url->link('feed/ka_export', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['export_page']        = $this->url->link('tool/ka_export', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['is_vqmod_available'] = $this->isVQModAvailable();

		$this->template = 'feed/ka_export.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'feed/ka_export')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function isVQModAvailable() {

		// check vqmod presence
		if (!class_exists('VQModObject')) {
			return false;
		}
		return true;
	}

	
	/*
		Compatible db may be fully patched or not patched at all. Partial changes are
		treated as a corrupted db.

		Returns
			true  - db is compatible
			false - db is not compatible

	*/
	private function checkDBCompatibility(&$messages) {

		$this->db_patched = false;
		if (empty($this->tables)) {
			return true;
		}

		foreach ($this->tables as $tk => $tv) {

			$tbl = DB_PREFIX . $tk;
			$res = $this->db->query("SHOW TABLES LIKE '$tbl'");

			if (empty($res->rows)) {
				if (empty($tv['is_new'])) {
					$messages .= "Table '$tbl' is not found in DB. Administrator action is required.";
					return false;
			 	} elseif ($this->db_patched) {
			 		$messages .= "DB is patched partially. Manual database update is required to install the extension.";
			 		return false;
			 	}
				continue;
			}

			// existing table is being checked
			if (!empty($tv['is_new'])) {
				$this->db_patched = true;
			}

			$fields = $this->db->query("DESCRIBE `$tbl`");
			if (empty($fields->rows)) {
				$messages .= "Table '$tbl' exists in the database but it is empty. Please remove this table and try to install the extension again.";
				return false;
			}

			// check fields 
			//
			$db_fields = array();
			foreach ($fields->rows as $v) {
				$db_fields[$v['Field']] = array(
					'type'  => $v['Type']
				);
			}

			foreach ($tv['fields'] as $fk => $field) {
				if (empty($db_fields[$fk])) {
					if ($this->db_patched) {
						$messages .= "Required changes are present in DB but they are not valid. Field '$fk' is not found in the table '$tbl'.";
						return false;
					}
					continue;
				}

				// if the field is found we validate its type

				$db_field = $db_fields[$fk];

				if ($field['type'] != $db_field['type']) {
					$messages .= "Field type '$db_field[type]' for '$fk' in the table '$tbl' does not match the required field type '$field[type]'.";
					return false;
				} else {
					$this->db_patched = true;
				}
			}

			if (!empty($tv['is_new']) && count($db_fields) != count($tv['fields'])) {
				$messages .= "Table '$tbl' exists but it has redundant fields. Maybe this table belongs to another extension. Administrator action is required.";
				return false;
			}

			// check indexes
			//
			if (!empty($tv['indexes'])) {

				$rec = $this->db->query("SHOW INDEXES FROM `$tbl`");
				$db_indexes = array();
				foreach ($rec->rows as $v) {
					$db_indexes[$v['Key_name']] = array(
						'columns' => $v['Column_name']
					);
				}

				foreach ($tv['indexes'] as $ik => $index) {
					if (!empty($db_indexes[$ik])) {
						$this->tables[$tk]['indexes'][$ik]['exists'] = true;
					}
				}
			}
		}

		return true;
	}


	private function patchDB(&$messages) {

		// create db
		//
		if (empty($this->tables)) {
			return true;
		}

		foreach ($this->tables as $tk => $tv) {
			if (!empty($tv['is_new'])) {
				$this->db->query($tv['query']);
				continue;
			}

			if (!empty($tv['fields'])) {
				foreach ($tv['fields'] as $fk => $fv) {
					$this->db->query($fv['query']);
				}
			}

			if (!empty($tv['indexes'])) {
				foreach ($tv['indexes'] as $ik => $iv) {
					if (empty($iv['exists'])) {
						$this->db->query($iv['query']);
					}
				}
			}
		}

		return true;
	}

		
	private function checkCompatibility(&$messages) {
		$messages = '';

		// check store version 
		if (version_compare(VERSION, $this->min_store_version, '<')
			|| version_compare(VERSION, $this->max_store_version, '>'))
		{
			$messages .= "compatibility of this extension with your store version (" . VERSION . ") was not checked.
				please contact an author of the extension for update.";
				
			return false;
		}

		//check database
		if (!$this->checkDBCompatibility($messages)) {
			return false;
		}
    
		return true;
	}


	public function install() {

		$this->init();

		$this->load->model('setting/extension');
		$this->load->model('setting/setting');
		
		$success = false;
		$messsages = '';
		
		if ($this->checkCompatibility($messages)) {
			if (!$this->db_patched) {
				if ($this->patchDB($messages)) {
					$success = true;
				}
			} else {
				$success = true;
			}
		}
		
		if ($success) {

			// grant permissions to the extension page automatically
			$this->load->model('user/user_group');
			$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'tool/ka_export');
			$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'tool/ka_export');

			$settings = array(
				'ka_pe_update_interval'   => 10,
				'ka_pe_direct_download'   => 'N',
				'ka_pe_prefix_with_space' => 'N',
				'ka_pe_enable_product_id' => 'N',
				'ka_export_status'        => 'Y',   // it is used for displaying extension status on product feeds page
				'ka_pe_general_sep'       => ':::',
				'ka_pe_cats_in_one_cell'    => 'Y',
				'ka_pe_images_in_one_cell'  => 'Y',
				'ka_pe_related_in_one_cell' => 'Y',
			);
			$this->model_setting_setting->editSetting('ka_export', $settings);

			$this->db->query("DELETE FROM " . DB_PREFIX . "ka_export_profiles");

			$success = true;
		}

		if (!$success) {
			$this->model_setting_extension->uninstall('feed', 'ka_export');
			$this->model_setting_setting->deleteSetting('ka_export');

			$this->session->data['error'] = 'Extension installation failed. List of errors are below:<br/>' . $messages;
		} else {
			$this->session->data['success'] = 'Extension is installed successfully.';
		}
	}

	public function uninstall() {
		
	}
}
?>