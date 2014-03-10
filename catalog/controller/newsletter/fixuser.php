<?php

class Controllernewsletterfixuser extends Controller {

	function printExtender($arr) {
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}

	public function index() {
		$this -> load -> model('newsletter/fixuser');
		$this -> model_newsletter_fixuser -> fixIt();
		echo "DONE!";
	}
	
}