<?php

class Controllernewsletterunsubscribe extends Controller {

	function printExtender($arr) {
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}

	public function index() {
		$this -> load -> model('newsletter/newsletter');
		$get = $this -> request -> get;
		$this -> model_newsletter_newsletter -> unsubscribe($get['id']);
		// $this -> session -> data['success'] = "U bent succesvol uitgeschreven.";
		
		$this->language->load('newsletter/unsubscribe');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['breadcrumbs'] = array();
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),			
			'separator' => false
		);
		
		$this->template = 'default/template/newsletter/newsletter.tpl';
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);
				
		$this->response->setOutput($this->render());
		// $this -> redirect($this -> url -> link('common/home', ""));
	}

}
