<?php
class ControllerModuleYoutubeEmbed extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('module/youtube_embed');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('youtube_embed', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_enabled'] = $this->language->get('entry_enabled');
		$this->data['entry_category_enabled'] = $this->language->get('entry_category_enabled');
		$this->data['entry_category_width'] = $this->language->get('entry_category_width');
		$this->data['entry_category_height'] = $this->language->get('entry_category_height');
		$this->data['entry_information_enabled'] = $this->language->get('entry_information_enabled');
		$this->data['entry_information_width'] = $this->language->get('entry_information_width');
		$this->data['entry_information_height'] = $this->language->get('entry_information_height');
		$this->data['entry_tab'] = $this->language->get('entry_tab');
		$this->data['entry_tab_text'] = $this->language->get('entry_tab_text');
		$this->data['entry_width'] = $this->language->get('entry_width');
		$this->data['entry_height'] = $this->language->get('entry_height');
		$this->data['entry_autohide'] = $this->language->get('entry_autohide');
		$this->data['entry_autohide_info'] = $this->language->get('entry_autohide_info');
		$this->data['entry_autoplay'] = $this->language->get('entry_autoplay');
		$this->data['entry_autoplay_info'] = $this->language->get('entry_autoplay_info');
		$this->data['entry_border'] = $this->language->get('entry_border');
		$this->data['entry_border_info'] = $this->language->get('entry_border_info');
		$this->data['entry_cc_load_policy'] = $this->language->get('entry_cc_load_policy');
		$this->data['entry_cc_load_policy_info'] = $this->language->get('entry_cc_load_policy_info');
		$this->data['entry_color'] = $this->language->get('entry_color');
		$this->data['entry_color_info'] = $this->language->get('entry_color_info');
		$this->data['entry_color1'] = $this->language->get('entry_color1');
		$this->data['entry_color1_info'] = $this->language->get('entry_color1_info');
		$this->data['entry_color2'] = $this->language->get('entry_color2');
		$this->data['entry_color2_info'] = $this->language->get('entry_color2_info');
		$this->data['entry_controls'] = $this->language->get('entry_controls');
		$this->data['entry_controls_info'] = $this->language->get('entry_controls_info');
		$this->data['entry_disablekb'] = $this->language->get('entry_disablekb');
		$this->data['entry_disablekb_info'] = $this->language->get('entry_disablekb_info');
		$this->data['entry_egm'] = $this->language->get('entry_egm');
		$this->data['entry_egm_info'] = $this->language->get('entry_egm_info');
		$this->data['entry_fs'] = $this->language->get('entry_fs');
		$this->data['entry_fs_info'] = $this->language->get('entry_fs_info');
		$this->data['entry_hd'] = $this->language->get('entry_hd');
		$this->data['entry_hd_info'] = $this->language->get('entry_hd_info');
		$this->data['entry_iv_load_policy'] = $this->language->get('entry_iv_load_policy');
		$this->data['entry_iv_load_policy_info'] = $this->language->get('entry_iv_load_policy_info');
		$this->data['entry_modestbranding'] = $this->language->get('entry_modestbranding');
		$this->data['entry_modestbranding_info'] = $this->language->get('entry_modestbranding_info');
		$this->data['entry_rel'] = $this->language->get('entry_rel');
		$this->data['entry_rel_info'] = $this->language->get('entry_rel_info');
		$this->data['entry_showinfo'] = $this->language->get('entry_showinfo');
		$this->data['entry_showinfo_info'] = $this->language->get('entry_showinfo_info');
		$this->data['entry_showsearch'] = $this->language->get('entry_showsearch');
		$this->data['entry_showsearch_info'] = $this->language->get('entry_showsearch_info');
		$this->data['entry_start'] = $this->language->get('entry_start');
		$this->data['entry_start_info'] = $this->language->get('entry_start_info');
		$this->data['entry_theme'] = $this->language->get('entry_theme');
		$this->data['entry_theme_info'] = $this->language->get('entry_theme_info');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		if (isset($this->error['youtube_embed_tab_text'])) {
			$this->data['error_youtube_embed_tab_text'] = $this->error['youtube_embed_tab_text'];
		} else {
			$this->data['error_youtube_embed_tab_text'] = '';
		}		
		
 		if (isset($this->error['youtube_embed_width'])) {
			$this->data['error_youtube_embed_width'] = $this->error['youtube_embed_width'];
		} else {
			$this->data['error_youtube_embed_width'] = '';
		}
		
 		if (isset($this->error['youtube_embed_height'])) {
			$this->data['error_youtube_embed_height'] = $this->error['youtube_embed_height'];
		} else {
			$this->data['error_youtube_embed_height'] = '';
		}
		
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
			'href'      => $this->url->link('module/youtube_embed', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/youtube_embed', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['youtube_embed_enabled'])) {
			$this->data['youtube_embed_enabled'] = $this->request->post['youtube_embed_enabled'];
		} else {
			$this->data['youtube_embed_enabled'] = $this->config->get('youtube_embed_enabled');
		}
		if (isset($this->request->post['youtube_embed_information_enabled'])) {
			$this->data['youtube_embed_information_enabled'] = $this->request->post['youtube_embed_information_enabled'];
		} else {
			$this->data['youtube_embed_information_enabled'] = $this->config->get('youtube_embed_information_enabled');
		}
		if (isset($this->request->post['youtube_embed_category_enabled'])) {
			$this->data['youtube_embed_category_enabled'] = $this->request->post['youtube_embed_category_enabled'];
		} else {
			$this->data['youtube_embed_category_enabled'] = $this->config->get('youtube_embed_category_enabled');
		}
		if (isset($this->request->post['youtube_embed_width'])) {
			$this->data['youtube_embed_width'] = $this->request->post['youtube_embed_width'];
		} else {
			$this->data['youtube_embed_width'] = $this->config->get('youtube_embed_width');
		}	
		if (isset($this->request->post['youtube_embed_height'])) {
			$this->data['youtube_embed_height'] = $this->request->post['youtube_embed_height'];
		} else {
			$this->data['youtube_embed_height'] = $this->config->get('youtube_embed_height');
		}
		if (isset($this->request->post['youtube_embed_information_width'])) {
			$this->data['youtube_embed_information_width'] = $this->request->post['youtube_embed_information_width'];
		} else {
			$this->data['youtube_embed_information_width'] = $this->config->get('youtube_embed_information_width');
		}	
		if (isset($this->request->post['youtube_embed_information_height'])) {
			$this->data['youtube_embed_information_height'] = $this->request->post['youtube_embed_information_height'];
		} else {
			$this->data['youtube_embed_information_height'] = $this->config->get('youtube_embed_information_height');
		}	
		if (isset($this->request->post['youtube_embed_category_width'])) {
			$this->data['youtube_embed_category_width'] = $this->request->post['youtube_embed_category_width'];
		} else {
			$this->data['youtube_embed_category_width'] = $this->config->get('youtube_embed_category_width');
		}	
		if (isset($this->request->post['youtube_embed_category_height'])) {
			$this->data['youtube_embed_category_height'] = $this->request->post['youtube_embed_category_height'];
		} else {
			$this->data['youtube_embed_category_height'] = $this->config->get('youtube_embed_category_height');
		}	
		if (isset($this->request->post['youtube_embed_autohide'])) {
			$this->data['youtube_embed_autohide'] = $this->request->post['youtube_embed_autohide'];
		} else {
			$this->data['youtube_embed_autohide'] = $this->config->get('youtube_embed_autohide');
		}
		if (isset($this->request->post['youtube_embed_autoplay'])) {
			$this->data['youtube_embed_autoplay'] = $this->request->post['youtube_embed_autoplay'];
		} else {
			$this->data['youtube_embed_autoplay'] = $this->config->get('youtube_embed_autoplay');
		}
		if (isset($this->request->post['youtube_embed_border'])) {
			$this->data['youtube_embed_border'] = $this->request->post['youtube_embed_border'];
		} else {
			$this->data['youtube_embed_border'] = $this->config->get('youtube_embed_border');
		}
		if (isset($this->request->post['youtube_embed_cc_load_policy'])) {
			$this->data['youtube_embed_cc_load_policy'] = $this->request->post['youtube_embed_cc_load_policy'];
		} else {
			$this->data['youtube_embed_cc_load_policy'] = $this->config->get('youtube_embed_cc_load_policy');
		}	
		if (isset($this->request->post['youtube_embed_color'])) {
			$this->data['youtube_embed_color'] = $this->request->post['youtube_embed_color'];
		} else {
			$this->data['youtube_embed_color'] = $this->config->get('youtube_embed_color');
		}
		if (isset($this->request->post['youtube_embed_color1'])) {
			$this->data['youtube_embed_color1'] = $this->request->post['youtube_embed_color1'];
		} else {
			$this->data['youtube_embed_color1'] = $this->config->get('youtube_embed_color1');
		}
		if (isset($this->request->post['youtube_embed_color2'])) {
			$this->data['youtube_embed_color2'] = $this->request->post['youtube_embed_color2'];
		} else {
			$this->data['youtube_embed_color2'] = $this->config->get('youtube_embed_color2');
		}
		if (isset($this->request->post['youtube_embed_controls'])) {
			$this->data['youtube_embed_controls'] = $this->request->post['youtube_embed_controls'];
		} else {
			$this->data['youtube_embed_controls'] = $this->config->get('youtube_embed_controls');
		}
		if (isset($this->request->post['youtube_embed_disablekb'])) {
			$this->data['youtube_embed_disablekb'] = $this->request->post['youtube_embed_disablekb'];
		} else {
			$this->data['youtube_embed_disablekb'] = $this->config->get('youtube_embed_disablekb');
		}
		if (isset($this->request->post['youtube_embed_egm'])) {
			$this->data['youtube_embed_egm'] = $this->request->post['youtube_embed_egm'];
		} else {
			$this->data['youtube_embed_egm'] = $this->config->get('youtube_embed_egm');
		}
		if (isset($this->request->post['youtube_embed_fs'])) {
			$this->data['youtube_embed_fs'] = $this->request->post['youtube_embed_fs'];
		} else {
			$this->data['youtube_embed_fs'] = $this->config->get('youtube_embed_fs');
		}
		if (isset($this->request->post['youtube_embed_hd'])) {
			$this->data['youtube_embed_hd'] = $this->request->post['youtube_embed_hd'];
		} else {
			$this->data['youtube_embed_hd'] = $this->config->get('youtube_embed_hd');
		}
		if (isset($this->request->post['youtube_embed_iv_load_policy'])) {
			$this->data['youtube_embed_iv_load_policy'] = $this->request->post['youtube_embed_iv_load_policy'];
		} else {
			$this->data['youtube_embed_iv_load_policy'] = $this->config->get('youtube_embed_iv_load_policy');
		}
		if (isset($this->request->post['youtube_embed_modestbranding'])) {
			$this->data['youtube_embed_modestbranding'] = $this->request->post['youtube_embed_modestbranding'];
		} else {
			$this->data['youtube_embed_modestbranding'] = $this->config->get('youtube_embed_modestbranding');
		}
		if (isset($this->request->post['youtube_embed_rel'])) {
			$this->data['youtube_embed_rel'] = $this->request->post['youtube_embed_rel'];
		} else {
			$this->data['youtube_embed_rel'] = $this->config->get('youtube_embed_rel');
		}
		if (isset($this->request->post['youtube_embed_showinfo'])) {
			$this->data['youtube_embed_showinfo'] = $this->request->post['youtube_embed_showinfo'];
		} else {
			$this->data['youtube_embed_showinfo'] = $this->config->get('youtube_embed_showinfo');
		}
		if (isset($this->request->post['youtube_embed_showsearch'])) {
			$this->data['youtube_embed_showsearch'] = $this->request->post['youtube_embed_showsearch'];
		} else {
			$this->data['youtube_embed_showsearch'] = $this->config->get('youtube_embed_showsearch');
		}
		if (isset($this->request->post['youtube_embed_theme'])) {
			$this->data['youtube_embed_theme'] = $this->request->post['youtube_embed_theme'];
		} else {
			$this->data['youtube_embed_theme'] = $this->config->get('youtube_embed_theme');
		}
		if (isset($this->request->post['youtube_embed_tab'])) {
			$this->data['youtube_embed_tab'] = $this->request->post['youtube_embed_tab'];
		} else {
			$this->data['youtube_embed_tab'] = $this->config->get('youtube_embed_tab');
		}
		if (isset($this->request->post['youtube_embed_tab_text'])) {
			$this->data['youtube_embed_tab_text'] = $this->request->post['youtube_embed_tab_text'];
		} elseif ($this->config->get('youtube_embed_tab_text')) {
			$this->data['youtube_embed_tab_text'] = $this->config->get('youtube_embed_tab_text');
		} else {
			$this->data['youtube_embed_tab_text'] = $this->language->get('entry_tab_text_default');
		}


		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/youtube_embed.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/youtube_embed')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['youtube_embed_tab'] && !$this->request->post['youtube_embed_tab_text']) {
			$this->error['youtube_embed_tab_text'] = $this->language->get('error_code');
		}		
		
		if (!$this->request->post['youtube_embed_width']) {
			$this->error['youtube_embed_width'] = $this->language->get('error_code');
		}
		
		if (!$this->request->post['youtube_embed_height']) {
			$this->error['youtube_embed_height'] = $this->language->get('error_code');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>