<?php
################################################################################################
#  developed by dedalx http://dedalx.com/		                              	       #
#  All rights reserved                                                                         #
################################################################################################
class ControllerModuleMetroshop extends Controller {
	
	private $error = array(); 
	
	public function index() {
		
		// OpenCart 1.5.4
		// $this->load->language('module/metroshop'))
		
		// OpenCart 1.5.5
		$this->language->load('module/metroshop');

		//Set the title from the language file $_['heading_title'] string
		//$this->document->setTitle($this->language->get('heading_title'));
		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		//Load the settings model. You can also add any other models you want to load here.
		$this->load->model('setting/setting');
		
					$this->load->model('tool/image');
	
	if (isset($this->request->post['dxmetroshop_image'])) {
			$this->data['dxmetroshop_image'] = $this->request->post['dxmetroshop_image'];
			$dxmetroshop_image = $this->request->post['dxmetroshop_image'];
		} else {
			$this->data['dxmetroshop_image'] = '';
		}
		
		if (isset($this->request->post['dxmetroshop_full_image'])) {
			$this->data['dxmetroshop_full_image'] = $this->request->post['dxmetroshop_full_image'];
			$dxmetroshop_image = $this->request->post['dxmetroshop_full_image'];
		} else {
			$this->data['dxmetroshop_full_image'] = '';
		}
		
		
		//Save the settings if the user has submitted the admin form (ie if someone has pressed save).
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('metroshop', $this->request->post);	

				
					
			$this->session->data['success'] = $this->language->get('text_success');
		
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
			$this->data['text_image_manager'] = 'Image manager';
					$this->data['token'] = $this->session->data['token'];		
		
		$text_strings = array(
				'heading_title',
				'text_enabled',
				'text_disabled',
				'text_content_top',
				'text_content_bottom',
				'text_column_left',
				'text_column_right',
				'entry_layout',
				'entry_position',
				'entry_status',
				'entry_sort_order',
				'button_save',
				'button_cancel',
				'button_add_module',
				'button_remove',
				'entry_example' 
		);
		
		foreach ($text_strings as $text) {
			$this->data[$text] = $this->language->get($text);
		}
		

		// store config data
		
		$config_data = array(
		'metroshop_status',
		'metroshop_color_body_bg',
		'metroshop_color_content_bg',
		'metroshop_color_headermenu_link',
		'metroshop_color_link',
		'metroshop_color_linkhover',
		'metroshop_color_text',
		'metroshop_color_price',
		'metroshop_color_priceold',
		'metroshop_color_buttonbg',
		'metroshop_color_buttonhoverbg',
		'metroshop_color_buttonlink',
		'metroshop_color_headermenu_logo',
		'metroshop_color_headermenu_button1',
		'metroshop_color_headermenu_button2',
		'metroshop_color_headermenu_buttoncart',
		'metroshop_color_topmenu_hover_link',
		'metroshop_color_topmenu_hover_bg',
		'metroshop_color_topmenu_separator',
		'metroshop_color_topmenu_submenu_bg',
		'metroshop_color_topmenu_submenu_hover_bg',
		'metroshop_color_topmenu_submenu_hover_link',
		'metroshop_color_searchblock_bg',
		'metroshop_color_navbuttonbg',
		'metroshop_color_productbg',
		'metroshop_color_hover_productbg',
		'metroshop_color_product_link',
		'metroshop_color_wlbuttonbg',
		'metroshop_color_cmpbuttonbg',
		'metroshop_color_header_text',
		'metroshop_color_displaybg',
		'metroshop_color_product_descr',
		'metroshop_color_product_descr_border',
		'metroshop_color_abouttext',
		'metroshop_color_topmenu_link',
		'metroshop_color_topmenu_linkhover',
		'metroshop_color_border',
		'metroshop_color_aboutbg',
		'metroshop_color_aboutheader',
		'metroshop_color_footerbg',
		'metroshop_color_footerheader',
		'metroshop_color_footerlink',
		'metroshop_color_footertext',
		'metroshop_color_formbg',
		'metroshop_color_tableheader_bg',
		'metroshop_color_tableheader_text',
		'metroshop_body_bg_pattern',
		'metroshop_body_font',
		'metroshop_body_fontsize',
		'metroshop_header_font',
		'metroshop_buttons_font',
		'metroshop_header_font_weight',
		'metroshop_buttons_font_weight',
		'metroshop_header_font_subset',
		'metroshop_buttons_font_subset',
		'metroshop_buttons_fontsize',
		'metroshop_header_fontsize',
		'metroshop_fonts_transform',
		'metroshop_bfonts_transform',
		'metroshop_footer_b',
		'dxmetroshop_image',
		'metroshop_preview',
		'dxmetroshop_bg_image',
		'dxmetroshop_full_image',
		'metroshop_full_preview',
		'dxmetroshop_full_bg_image',
		'metroshop_transparent_content',
		
		'metroshop_layout_responsive',
		'metroshop_layout_related',
	
		'metroshop_layout_rightbaners',
		'metroshop_layout_bottombaners',
		'metroshop_layout_pdisplay',
		'metroshop_invert_images',
	
		'metroshop_layout_custommenu',
		'metroshop_layout_custommenu_item1_text',
		'metroshop_layout_custommenu_item2_text',
		'metroshop_layout_custommenu_item3_text',
		'metroshop_layout_custommenu_item4_text',
		'metroshop_layout_custommenu_item5_text',
		'metroshop_layout_custommenu_item6_text',
		'metroshop_layout_custommenu_item7_text',
		'metroshop_layout_custommenu_item8_text',
		'metroshop_layout_custommenu_item9_text',
		'metroshop_layout_custommenu_item10_text',
		'metroshop_layout_custommenu_item1_url',
		'metroshop_layout_custommenu_item2_url',
		'metroshop_layout_custommenu_item3_url',
		'metroshop_layout_custommenu_item4_url',
		'metroshop_layout_custommenu_item5_url',
		'metroshop_layout_custommenu_item6_url',
		'metroshop_layout_custommenu_item7_url',
		'metroshop_layout_custommenu_item8_url',
		'metroshop_layout_custommenu_item9_url',
		'metroshop_layout_custommenu_item10_url',
		
		'metroshop_effects_slideranim',
		'metroshop_effects_carousel',
		'metroshop_effects_productimage',
		
		'metroshop_custom_css',
		'metroshop_custom_js',
		
		'customFooter_status',
		'about_status',
		'about_header', 
		'about_text',
		'contact_header',
		'contact_status',
		'contact_subheader',
		'telephone1',
		'telephone2',
		'email1',
		'email2',
		'skype',
		'fax',
		'facebook_status',
		'facebook_id',
		'custom_footer_column_status',
		'custom_footer_column_header',
		'custom_footer_column_content',
		'twitter_column_status',
		'twitter_column_header',
		'twitter_number_of_tweets',
		'twitter_username',
		'categories_column_status',
		'about_us_image',
		'about_us_image_status',
		'about_us_image_preview'
		);
		
		foreach ($config_data as $conf) {
			if (isset($this->request->post[$conf])) {
				$this->data[$conf] = $this->request->post[$conf];
			} else {
				$this->data[$conf] = $this->config->get($conf);
			}
		}
		
		
		
	
		//This creates an error message. The error['warning'] variable is set by the call to function validate() in this controller (below)
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		//SET UP BREADCRUMB TRAIL. YOU WILL NOT NEED TO MODIFY THIS UNLESS YOU CHANGE YOUR MODULE NAME.
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/metroshop', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/metroshop', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

	
		//This code handles the situation where you have multiple instances of this module, for different layouts.
		if (isset($this->request->post['metroshop_module'])) {
			$modules = explode(',', $this->request->post['metroshop_module']);
		} elseif ($this->config->get('metroshop_module') != '') {
			$modules = explode(',', $this->config->get('metroshop_module'));
		} else {
			$modules = array();
		}			
				
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
				
		foreach ($modules as $module) {
			if (isset($this->request->post['metroshop_' . $module . '_layout_id'])) {
				$this->data['metroshop_' . $module . '_layout_id'] = $this->request->post['metroshop_' . $module . '_layout_id'];
			} else {
				$this->data['metroshop_' . $module . '_layout_id'] = $this->config->get('metroshop_' . $module . '_layout_id');
			}	
			
			if (isset($this->request->post['metroshop_' . $module . '_position'])) {
				$this->data['metroshop_' . $module . '_position'] = $this->request->post['metroshop_' . $module . '_position'];
			} else {
				$this->data['metroshop_' . $module . '_position'] = $this->config->get('metroshop_' . $module . '_position');
			}	
			
			if (isset($this->request->post['metroshop_' . $module . '_status'])) {
				$this->data['metroshop_' . $module . '_status'] = $this->request->post['metroshop_' . $module . '_status'];
			} else {
				$this->data['metroshop_' . $module . '_status'] = $this->config->get('metroshop_' . $module . '_status');
			}	
						
			if (isset($this->request->post['metroshop_' . $module . '_sort_order'])) {
				$this->data['metroshop_' . $module . '_sort_order'] = $this->request->post['metroshop_' . $module . '_sort_order'];
			} else {
				$this->data['metroshop_' . $module . '_sort_order'] = $this->config->get('metroshop_' . $module . '_sort_order');
			}				
		}
		

		
		$this->data['modules'] = $modules;
		
		if (isset($this->request->post['metroshop_module'])) {
			$this->data['metroshop_module'] = $this->request->post['metroshop_module'];
		} else {
			$this->data['metroshop_module'] = $this->config->get('metroshop_module');
		}

		//Choose which template file will be used to display this request.
		$this->template = 'module/metroshop.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
		

		
		if (isset($this->data['dxmetroshop_image']) && file_exists(DIR_IMAGE . $this->data['dxmetroshop_image'])) {
			$this->data['metroshop_preview'] = $this->model_tool_image->resize($this->data['dxmetroshop_image'], 70, 70);
		} else {
			$this->data['metroshop_preview'] = $this->model_tool_image->resize('no_image.jpg', 50, 70);
		}
		
		
		if (isset($this->data['dxmetroshop_full_image']) && file_exists(DIR_IMAGE . $this->data['dxmetroshop_full_image'])) {
			$this->data['metroshop_full_preview'] = $this->model_tool_image->resize($this->data['dxmetroshop_full_image'], 70, 70);
		} else {
			$this->data['metroshop_full_preview'] = $this->model_tool_image->resize('no_image.jpg', 50, 70);
		}

		if (isset($this->data['about_us_image']) && file_exists(DIR_IMAGE . $this->data['about_us_image'])) {
			$this->data['about_us_image_preview'] = $this->model_tool_image->resize($this->data['about_us_image'], 70, 70);
		} else {
			$this->data['about_us_image_preview'] = $this->model_tool_image->resize('no_image.jpg', 50, 70);
		}
		
		//Send the output.
		$this->response->setOutput($this->render());
	}
	
	/*
	 * 
	 * This function is called to ensure that the settings chosen by the admin user are allowed/valid.
	 * You can add checks in here of your own.
	 * 
	 */
	
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/metroshop')) {
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