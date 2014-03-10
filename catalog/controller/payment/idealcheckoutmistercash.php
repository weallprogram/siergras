<?php

// Load gateway settings
$sPath = dirname(dirname(dirname(dirname(__FILE__))));

while(!is_dir($sPath . '/idealcheckout/temp'))
{
	$sPath = dirname($sPath);
}

require_once($sPath . '/idealcheckout/includes/library.php');



class ControllerPaymentIdealcheckoutmistercash extends Controller
{
	public function index() 
	{
		$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['continue'] = $this->url->link('payment/idealcheckoutmistercash/setup');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/idealcheckoutmistercash.tpl')) 
		{
			$this->template = $this->config->get('config_template') . '/template/payment/idealcheckoutmistercash.tpl';
		}
		else
		{
			$this->template = 'default/template/payment/idealcheckoutmistercash.tpl';
		}
	
		$this->render();		 
	}

	public function confirm() 
	{
		//$this->load->model('checkout/order');
		//$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('idealcheckoutmistercash_order_status_id'));
	}

	public function setup()
	{		
		$this->load->model('checkout/order');

		if(isset($this->session->data['order_id']))
		{
			$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

			$this->language->load('payment/idealcheckoutmistercash');

			$aDatabaseSettings = idealcheckout_getDatabaseSettings();

			$sStoreCode = idealcheckout_getStoreCode();
			$sGatewayCode = 'mistercash';
			$sLanguageCode = 'nl'; // nl, de, en
			$sCountryCode = '';
			$sCurrencyCode = 'EUR';

			$sOrderId = $this->session->data['order_id'];
			$sOrderCode = idealcheckout_getRandomCode(32);
			$aOrderParams = array();
			$sTransactionId = idealcheckout_getRandomCode(32);
			$sTransactionCode = idealcheckout_getRandomCode(32);
			$fTransactionAmount = round($order_info['total'] * $order_info['currency_value'], 2);
			$sTransactionDescription = idealcheckout_getTranslation($sLanguageCode, 'idealcheckout', 'Webshop order #{0}', array($sOrderId));
			$sTransactionPaymentUrl = $this->url->link('checkout/checkout'); // HTTPS_SERVER . 'index.php?route=checkout/checkout';
			$sTransactionSuccessUrl = $this->url->link('payment/idealcheckoutmistercash/callback'); // HTTPS_SERVER . 'index.php?route=payment/idealcheckoutmistercash/callback';
			$sTransactionPendingUrl = $sTransactionSuccessUrl;
			$sTransactionFailureUrl = $sTransactionPaymentUrl;

			// Insert into #_transactions
			$sql = "INSERT INTO `" . $aDatabaseSettings['table'] . "` SET 
`id` = NULL, 
`order_id` = '" . idealcheckout_escapeSql($sOrderId) . "', 
`order_code` = '" . idealcheckout_escapeSql($sOrderCode) . "', 
`order_params` = '" . idealcheckout_escapeSql(idealcheckout_serialize($aOrderParams)) . "', 
`store_code` = " . (empty($sStoreCode) ? "NULL" : "'" . idealcheckout_escapeSql($sStoreCode) . "'") . ", 
`gateway_code` = '" . idealcheckout_escapeSql($sGatewayCode) . "', 
`language_code` = " . (empty($sLanguageCode) ? "NULL" : "'" . idealcheckout_escapeSql($sLanguageCode) . "'") . ", 
`country_code` = " . (empty($sCountryCode) ? "NULL" : "'" . idealcheckout_escapeSql($sCountryCode) . "'") . ", 
`currency_code` = '" . idealcheckout_escapeSql($sCurrencyCode) . "', 
`transaction_id` = '" . idealcheckout_escapeSql($sTransactionId) . "', 
`transaction_code` = '" . idealcheckout_escapeSql($sTransactionCode) . "', 
`transaction_params` = NULL, 
`transaction_date` = '" . idealcheckout_escapeSql(time()) . "', 
`transaction_amount` = '" . idealcheckout_escapeSql($fTransactionAmount) . "', 
`transaction_description` = '" . idealcheckout_escapeSql($sTransactionDescription) . "', 
`transaction_status` = NULL, 
`transaction_url` = NULL, 
`transaction_payment_url` = '" . idealcheckout_escapeSql($sTransactionPaymentUrl) . "', 
`transaction_success_url` = '" . idealcheckout_escapeSql($sTransactionSuccessUrl) . "', 
`transaction_pending_url` = '" . idealcheckout_escapeSql($sTransactionPendingUrl) . "', 
`transaction_failure_url` = '" . idealcheckout_escapeSql($sTransactionFailureUrl) . "', 
`transaction_log` = NULL;";

			$query = $this->db->query($sql);


			// Redirect to issuer_request.php
			$this->redirect(HTTPS_SERVER . 'idealcheckout/setup.php?order_id=' . $sOrderId . '&order_code=' . $sOrderCode);
		}
		else
		{
			idealcheckout_output('<code>Error while loading order data from session.</code>');
		}
	}
	
	public function callback() 
	{
		$this->load->model('checkout/order');
		$this->language->load('payment/idealcheckoutmistercash');

		if(isset($this->session->data['order_id']) && ($order_info = $this->model_checkout_order->getOrder($this->session->data['order_id'])))
		{
			$aDatabaseSettings = idealcheckout_getDatabaseSettings();

			// Lookup transaction
			$sql = "SELECT `order_id`, `transaction_status` FROM `" . $aDatabaseSettings['table'] . "` WHERE `order_id` = '" . idealcheckout_escapeSql($this->session->data['order_id']) . "' ORDER BY `id` DESC LIMIT 1;";
			$oRecordSet = $this->db->query($sql);

			if(isset($oRecordSet->rows[0]) && ($oRecord = $oRecordSet->rows[0]))
			{
				if(strcasecmp($oRecord['transaction_status'], 'SUCCESS') === 0)
				{
					$this->model_checkout_order->confirm($oRecord['order_id'], 100, "\n\n" . $this->language->get('text_payable') . "\n" . $this->language->get('text_title'));
					$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/success');
				}
				elseif(strcasecmp($oRecord['transaction_status'], 'PENDING') === 0)
				{
					$this->model_checkout_order->confirm($oRecord['order_id'], 102, "\n\n" . $this->language->get('text_payable') . "\n" . $this->language->get('text_title'));
					$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/success');
				}
				elseif(strcasecmp($oRecord['transaction_status'], 'OPEN') === 0)
				{
					$this->model_checkout_order->update($this->session->data['order_id'], 103, '', false);

					if($oRecord['transaction_url'])
					{
						$this->redirect($oRecord['transaction_url']);
					}
					else
					{
						$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/checkout');
					}
				}
				elseif(strcasecmp($oRecord['transaction_status'], 'CANCELLED') === 0)
				{
					$this->model_checkout_order->update($oRecord['order_id'], 104, '', false);
					$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/checkout');
				}
				elseif(strcasecmp($oRecord['transaction_status'], 'EXPIRED') === 0)
				{
					$this->model_checkout_order->update($oRecord['order_id'], 105, '', false);
					$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/checkout');
				}
				else // if(strcasecmp($oRecord['transaction_status'], 'FAILURE') === 0)
				{
					$this->model_checkout_order->update($oRecord['order_id'], 106, '', false);
					$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/checkout');
				}
			}
		}
		else
		{
			idealcheckout_output('<code>Error while loading order data from session.</code>');
		}
	}
}

?>