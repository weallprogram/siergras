<?php
class ControllerPaymentIncasso extends Controller {
	protected function index() {
		$this -> language -> load('payment/incasso');

		$this -> data['text_instruction'] = $this -> language -> get('text_instruction');
		$this -> data['text_description'] = $this -> language -> get('text_description');
		$this -> data['text_payment'] = $this -> language -> get('text_payment');
		$this -> data['text_number_insert'] = $this -> language -> get('text_number_insert');
		$this -> data['bankNumberError'] = $this -> language -> get('bankNumberError');

		$this -> data['button_confirm'] = $this -> language -> get('button_confirm');

		$this -> data['bank'] = nl2br($this -> config -> get('incasso_bank_' . $this -> config -> get('config_language_id')));

		$this -> data['continue'] = $this -> url -> link('checkout/success');

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/payment/incasso.tpl')) {
			$this -> template = $this -> config -> get('config_template') . '/template/payment/incasso.tpl';
		} else {
			$this -> template = 'default/template/payment/incasso.tpl';
		}

		$this -> render();
	}

	public function confirm() {
		$this -> language -> load('payment/incasso');

		$this -> load -> model('checkout/order');
		$this -> load -> model('payment/incasso');

		$comment = $this -> language -> get('text_instruction') . "\n\n";
		$comment .= $this -> config -> get('incasso_bank_' . $this -> config -> get('config_language_id')) . "\n\n";
		$comment .= $this -> language -> get('text_payment');

		$this -> model_checkout_order -> confirm($this -> session -> data['order_id'], $this -> config -> get('incasso_order_status_id'), $comment, true);
		
		$rekNum = $_GET['rn'];
		$this -> model_payment_incasso -> insertRekNum($this -> session -> data['order_id'], $rekNum);
	}

}
?>