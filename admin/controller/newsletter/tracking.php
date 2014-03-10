<?php


class ControllerNewsletterTracking extends Controller {

	function printExtender($arr) {
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
	
	private function validate() {
		if (!$this -> user -> hasPermission('modify', 'newsletter/tracking')) {
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
	
	public function index() {
	
		$this -> load -> language('newsletter/tracking');
		$this -> load -> model('newsletter/tracking');
		
		$totalQueued = $this -> model_newsletter_tracking -> getTotalQueued();
		$pausedQueued = $this -> model_newsletter_tracking -> getPausedQueued();
		$totalLetterQueued = $this -> model_newsletter_tracking -> getLetterQueued();
		$letters = $this -> model_newsletter_tracking -> getLetters();
		
		$this -> data['totalQueued'] = $totalQueued['COUNT(*)'];
		$this -> data['pausedQueued'] = $pausedQueued['COUNT(queue.uid)'];
		$this -> data['totalLetterQueued'] = $totalLetterQueued['COUNT(DISTINCT `newsletter_uid`)'];
		$this -> data['letters'] = $letters;
		
		$this -> data['watchLink'] = $this -> url -> link('newsletter/tracking/watch', 'token=' . $this -> session -> data['token'], 'SSL');
		$this -> data['watchText'] = $this -> language -> get('watchText');
		
		$this -> data['pauseLink'] = $this -> url -> link('newsletter/tracking/pause', 'token=' . $this -> session -> data['token'], 'SSL');
		$this -> data['pauseText'] = $this -> language -> get('pauseText');
	
		$this -> data['heading_title'] = $this -> language -> get('heading_title');

		$this -> data['breadcrumbs'] = array();
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => false);
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('heading_title'), 'href' => $this -> url -> link('newsletter/tracking', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => ' :: ');

		$this -> template = 'newsletter/tracking.tpl';
		$this -> children = array('common/header', 'common/footer');

		$this -> response -> setOutput($this -> render());
	}
	
	public function watch(){
	
		$this -> load -> language('newsletter/tracking');
		$this -> load -> model('newsletter/tracking');
		
		$uid = $this -> request -> get['uid'];
		$this -> data['letterMainInfo'] = $this -> model_newsletter_tracking -> getMainInfo($uid);
		$this -> data['linkBack'] = $this -> url -> link('newsletter/tracking', 'token=' . $this -> session -> data['token'], 'SSL');
		
		$this -> data['heading_title'] = $this -> language -> get('heading_title');

		$this -> data['breadcrumbs'] = array();
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => false);
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('heading_title'), 'href' => $this -> url -> link('newsletter/tracking', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => ' :: ');
		
		$this -> template = 'newsletter/watch.tpl';
		$this -> children = array('common/header', 'common/footer');

		$this -> response -> setOutput($this -> render());
	}
	
	public function pause(){
		$uid = $this -> request -> get['uid'];
		$this -> load -> model('newsletter/tracking');
		$this -> model_newsletter_tracking -> changePause($uid);
		$this -> redirect($this -> url -> link('newsletter/tracking', 'token=' . $this -> session -> data['token'], 'SSL'));
	}
}