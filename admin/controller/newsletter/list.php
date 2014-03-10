<?php

class Controllernewsletterlist extends Controller {

	function printExtender($arr) {
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}

	private function validate() {
		if (!$this -> user -> hasPermission('modify', 'newsletter/newsletter')) {
			$this -> error['warning'] = $this -> language -> get('error_permission');
		}

		if (!$this -> request -> post['subject']) {
			$this -> error['subject'] = $this -> language -> get('error_subject');
		}

		if (!$this -> request -> post['message']) {
			$this -> error['message'] = $this -> language -> get('error_message');
		}

		if (!$this -> error) {
			return true;
		} else {
			return false;
		}
	}

	public function index(){
		$this -> load -> language('newsletter/list');
		$this -> load -> model('newsletter/list');
		
		if(isset($this -> request -> get['del']) && isset($this -> request -> get['uid'])){
			$this -> load -> model('newsletter/list');
			$this -> model_newsletter_list -> deleteUser($this -> request -> get['uid']);
			return;
		}
		
		$leUrl = $this -> url -> link('newsletter/list', 'token=' . $this -> session -> data['token'], 'SSL');
		
		if(isset($this -> request -> get['filter'])){
			$filterData = array();
			$leUrl .= '&filter=1';
			if(isset($this -> request -> get['filter_id'])){
				$filterData['filter_id'] = $this -> request -> get['filter_id'];
				$leUrl .= '&filter_id=' . $this -> request -> get['filter_id'];
			}
			
			if(isset($this -> request -> get['filter_email'])){
				$filterData['filter_email'] = $this -> request -> get['filter_email'];
				$leUrl .= '&filter_email=' . $this -> request -> get['filter_email'];
			}
			
			if(isset($this -> request -> get['filter_cat'])){
				$filterData['filter_cat'] = $this -> request -> get['filter_cat'];
				$leUrl .= '&filter_cat=' . $this -> request -> get['filter_cat'];
				
				$this -> data['minListTotal'] = $this -> model_newsletter_list -> getMinTotal($this -> request -> get['filter_cat']);
				$this -> data['maxListTotal'] = $this -> model_newsletter_list -> getMaxTotal($this -> request -> get['filter_cat']);
				$this -> data['totalUsers'] = $this -> model_newsletter_list -> getAllTotal($this -> request -> get['filter_cat']);
			}else{
			
				$this -> data['minListTotal'] = $this -> model_newsletter_list -> getMinTotal("all");
				$this -> data['maxListTotal'] = $this -> model_newsletter_list -> getMaxTotal("all");
				$this -> data['totalUsers'] = $this -> model_newsletter_list -> getAllTotal("all");
			}
			
			if(isset($this -> request -> get['lim_start'])){
				$filterData['lim_start'] = $this -> request -> get['lim_start'];
			}
			
			$this -> data['subscribers'] = $this -> model_newsletter_list -> getListFilter($filterData);
		}else{
			$this -> data['subscribers'] = $this -> model_newsletter_list -> getList();
			$this -> data['minListTotal'] = $this -> model_newsletter_list -> getMinTotal("all");
			$this -> data['maxListTotal'] = $this -> model_newsletter_list -> getMaxTotal("all");
			$this -> data['totalUsers'] = $this -> model_newsletter_list -> getAllTotal("all");
		}
		
		$limit_start = 0;
		if (isset($this -> request -> get['lim_start'])) {
			$limit_start = $this -> request -> get['lim_start'];
		}
		$this -> data['lim_start'] = $limit_start;
		$this -> data['imex_page_url'] = $leUrl;
		
		$this -> data['heading_title'] = $this -> language -> get('heading_title');
		$this -> data['redirFilterUrl'] = $this -> url -> link('newsletter/list', 'token=' . $this -> session -> data['token'], 'SSL');
		$this -> data['addLik'] = $this -> url -> link('newsletter/list/add', 'token=' . $this -> session -> data['token'], 'SSL');
		
		$this -> data['breadcrumbs'] = array();
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => false);
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('heading_title'), 'href' => $this -> url -> link('newsletter/list', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => ' :: ');

		$this -> template = 'newsletter/list.tpl';
		$this -> children = array('common/header', 'common/footer');

		$this -> response -> setOutput($this -> render());

	}
	
	public function add(){
		$this -> load -> language('newsletter/add');
		$this -> load -> model('newsletter/list');
		
		$this -> data['cancelLink'] = $this -> url -> link('newsletter/list', 'token=' . $this -> session -> data['token'], 'SSL');
		
		$this -> data['heading_title'] = $this -> language -> get('heading_title');
		
		$this -> data['breadcrumbs'] = array();
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => false);
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('heading_title'), 'href' => $this -> url -> link('newsletter/list', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => ' :: ');

		$this -> template = 'newsletter/add.tpl';
		$this -> children = array('common/header', 'common/footer');

		$this -> response -> setOutput($this -> render());
	}
}
