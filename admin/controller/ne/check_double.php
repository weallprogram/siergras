<?php
//-----------------------------------------------------
// Newsletter Enhancements for Opencart
// Created by DmitryNek
// exmail.Nek@gmail.com
//-----------------------------------------------------

class ControllerNeCheckDouble extends Controller {
	public function index() {
		$this -> language -> load('ne/check_double');
		$this -> load -> model('ne/check_double');

		$this -> document -> setTitle($this -> language -> get('heading_title'));

		$this -> data['breadcrumbs'] = array();
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => false);
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('heading_title'), 'href' => $this -> url -> link('ne/check_double', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => ' :: ');

		if (isset($this -> error['warning'])) {
			$this -> data['error_warning'] = $this -> error['warning'];
		} else {
			$this -> data['error_warning'] = '';
		}

		$this -> data['heading_title'] = $this -> language -> get('heading_title');
		$this -> data['button_check'] = $this -> language -> get('button_check');
		$this -> data['token'] = $this -> session -> data['token'];
		$this -> data['deleteLink'] = $this->url->link('ne/check_double/delete', 'token=' . $this->session->data['token'], 'SSL');

		$this -> data['doubleEmails'] = $this -> model_ne_check_double -> getOldEmailsDouble();
		
		$this -> template = 'ne/check_double.tpl';
		$this -> children = array('common/header', 'common/footer');

		$this -> response -> setOutput($this -> render());
	}

	function printExtender($array){
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}

	public function delete(){
		$uid = $this -> request -> get['uid'];
		$this -> load -> model('ne/check_double');
		$this -> model_ne_check_double -> delete($uid);
		$this->redirect($this->url->link('ne/check_double', 'token=' . $this->session->data['token'], 'SSL'));
	}
	
}
