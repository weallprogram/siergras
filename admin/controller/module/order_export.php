<?php
class ControllerModuleorderexport extends Controller {
	private $error = array();

	public function index() {
		$this -> language -> load('module/order_export');
		$this -> load -> model('order_export/order_export');

		$this -> document -> setTitle($this -> language -> get('heading_title'));

		if (isset($this -> error['warning'])) {
			$this -> data['error_warning'] = $this -> error['warning'];
		} else {
			$this -> data['error_warning'] = '';
		}

		$this -> data['heading_title'] = $this -> language -> get('heading_title');

		$this -> data['button_save'] = $this -> language -> get('button_save');
		$this -> data['button_cancel'] = $this -> language -> get('button_cancel');
		$this -> data['button_filter'] = $this -> language -> get('button_filter');

		$this -> data['order_num'] = $this -> language -> get("order_num");
		$this -> data['articel'] = $this -> language -> get("articel");
		$this -> data['buyer'] = $this -> language -> get("buyer");
		$this -> data['status'] = $this -> language -> get("status");
		$this -> data['order_date'] = $this -> language -> get("order_date");
		$this -> data['order_change'] = $this -> language -> get("order_change");
		$this -> data['amount'] = $this -> language -> get("amount");
		$this -> data['total'] = $this -> language -> get("total");
		$this -> data['action'] = $this -> language -> get("action");
		$this -> data['button_apply_filter'] = $this -> language -> get("button_filter_apply");
		$this -> data['button_apply_filters'] = $this -> language -> get("button_filters_apply");
		$this -> data['apply'] = $this -> language -> get("apply");
		$this -> data['exportToExcel'] = $this -> language -> get("exportToExcel");

		$this -> data['orderData'] = $this -> model_order_export_order_export -> getOrders(array("order" => "DESC", "filter_order_status_id" => 107));
		$this -> data['minOrderId'] = $this -> model_order_export_order_export -> getMinOrder();
		$this -> data['maxOrderId'] = $this -> model_order_export_order_export -> getMaxOrder();
		$this -> data['orderStatusen'] = $this -> model_order_export_order_export -> getOrderStatusen();
		$this -> data['minOrderTotal'] = $this -> model_order_export_order_export -> getMinTotal();
		$this -> data['maxOrderTotal'] = $this -> model_order_export_order_export -> getMaxTotal();

		$filterUrl = $this -> url -> link('module/order_export/filter', 'token=' . $this -> session -> data['token'], 'SSL');
		$filterUrl = htmlspecialchars_decode($filterUrl);
		$this -> data['filterUrl'] = $filterUrl;
		$exportUrl = $this -> url -> link('module/order_export/export', 'token=' . $this -> session -> data['token'], 'SSL');
		$exportUrl = htmlspecialchars_decode($exportUrl);
		$this -> data['exportUrl'] = $exportUrl;

		$this -> data['breadcrumbs'] = array();
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => false);
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_module'), 'href' => $this -> url -> link('module/order_export', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => ' :: ');

		$this -> template = 'module/order_export.tpl';
		$this -> children = array('common/header', 'common/footer');

		$this -> response -> setOutput($this -> render());
	}

	public function filter() {
		$this -> load -> model('order_export/order_export');
		$this -> data['orderData'] = $this -> model_order_export_order_export -> getOrdersFilter($_GET);
		$this -> template = 'module/order_export_filter.tpl';
		$this -> response -> setOutput($this -> render());
	}

	public function export() {
		$this -> load -> model('setting/setting');
		$this -> load -> model('order_export/order_export');

		$orderData = $this -> model_order_export_order_export -> getOrdersWithId(array("order" => "DESC", "orderNum" => $_GET['orNum']));
		$flatPorto = $this -> model_setting_setting -> getSetting("flat");

		// Start renderinging Excel file with PHPEXCEL Class ( http://phpexcel.codeplex.com/ )
		define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
		require_once 'order_export_classes/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		$objPHPExcel -> getProperties() -> setCreator("Verburg Services") -> setLastModifiedBy("Verburg Services") -> setTitle("Order Export Gospel 7 " . date('H:i:s')) -> setSubject("Order Export Gospel 7 " . date('H:i:s')) -> setDescription("Order Export Gospel 7 " . date('H:i:s')) -> setKeywords("Order Export Gospel 7 " . date('H:i:s')) -> setCategory("Order Export Gospel 7 ");

		$rowCount = 1;

		foreach ($orderData as $key => $value) {

			$total = " € - ";
			$totalNum = 0;
			$btw6incl = " € - ";
			$btw6 = " € - ";
			$btw6Excl = " € - ";
			$btw6Text = " € - ";
			$btw21Incl = " € - ";
			$btw21 = " € - ";
			$btw21Excl = " € - ";
			$btw21Text = " € - ";
			$portoCost = " € - ";
			$waardeboon = " € - ";
			$J = " € - ";
			$JCounter = 0;
			$K = " € - ";
			$KCounter = 0;
			$L = " € - ";
			$LCounter = 0;
			$M = " € - ";
			$MCounter = 0;
			$N = " € - ";
			$NCounter = 0.00;
			$O = " € - ";
			$OCounter = 0;

			$product = $this -> model_order_export_order_export -> getProducts($value['order_id']);
			$orderTotal = $this -> model_order_export_order_export -> getOrderTotal($value['order_id']);
			$couponData = $this -> model_order_export_order_export -> getCouponData($value['order_id']);

			// echo "<pre>";
			// print_r($orderData);
			// echo "</pre>";
			// echo "<pre>";
			// print_r($product);
			// echo "</pre>";
			// echo "<pre>";
			// print_r($orderTotal);
			// echo "</pre>";
			// echo "<pre>";
			// print_r($couponData);
			// echo "</pre>";

			foreach ($orderTotal as $key3 => $value3) {
				switch ($value3['code']) {
					case 'sub_total' :
						break;
					case 'shipping' :
						$portoCost = $value3['text'];
						break;
					case 'tax' :
						if ($value3['title'] == "6.0%") {
							$btw6 = $value3['value'];
							$btw6Text = $value3['text'];
						} else {
							$btw21 = $value3['value'];
							$btw21Text = $value3['text'];
						}
						break;
					case 'total' :
						$total = $value3['text'];
						$totalNum = $value3['value'];
						break;
					case 'coupon' :
						$waardeboon = $value3['text'];
						break;
					default :
						break;
				}
			}

			foreach ($product as $key2 => $value2) {

				// Eerst de korting, en dan pas de BTW
				$proPrice = $value2['total'];
				$proPrice += $portoCost;

				$tax = $this -> model_order_export_order_export -> getTax($value2['product_id']);

				switch ((int)$tax['rate']) {
					case 6 :
						$proTax = ($proPrice / 100) * 6;
						$proAll = $proPrice + $proTax;
						$JCounter = $JCounter + $proAll;
						$KCounter = $KCounter + $proTax;
						$LCounter = $LCounter + $proPrice;
						break;
					case 21 :
						$proTax = ($proPrice / 100) * 21;
						$proAll = $proPrice + $proTax;
						$MCounter = $MCounter + $proAll;
						$NCounter = $NCounter + $proTax;
						$OCounter = $OCounter + $proPrice;
						break;
					default :
						break;
				}
			}

			$J = " € " . $this -> round_to_2dp($JCounter);
			$K = " € " . $this -> round_to_2dp($KCounter);
			$L = " € " . $this -> round_to_2dp($LCounter);
			$M = " € " . $this -> round_to_2dp($MCounter);
			$N = " € " . $this -> round_to_2dp($NCounter);
			$O = " € " . $this -> round_to_2dp($OCounter);

			$rekNum = $this -> model_order_export_order_export -> getRekNum($value['order_id']);

			$objPHPExcel -> getActiveSheet() -> getStyle('E' . $rowCount) -> getFill() -> applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'FF0000'), ));
			$objPHPExcel -> getActiveSheet() -> getStyle('J' . $rowCount) -> getFill() -> applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => '00FF00'), ));
			$objPHPExcel -> getActiveSheet() -> getStyle('M' . $rowCount) -> getFill() -> applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => '00FF00'), ));
			$objPHPExcel -> getActiveSheet() -> getStyle('P' . $rowCount) -> getFill() -> applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => '00FF00'), ));
			$objPHPExcel -> getActiveSheet() -> getStyle('Q' . $rowCount) -> getFill() -> applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => '00FF00'), ));

			$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('A' . $rowCount, $rowCount) -> setCellValue('B' . $rowCount, $value['customer']) -> setCellValue('C' . $rowCount, $value['payment_city']) -> setCellValue('D' . $rowCount, $value['currency_code']) -> setCellValue('E' . $rowCount, $total) -> setCellValue('F' . $rowCount, $rekNum['iban']) -> setCellValue('G' . $rowCount, "Gospel 7") -> setCellValue('H' . $rowCount, $value['order_id']) -> setCellValue('I' . $rowCount, $value['email']) -> setCellValue('J' . $rowCount, $J) -> setCellValue('K' . $rowCount, $K) -> setCellValue('L' . $rowCount, $L) -> setCellValue('M' . $rowCount, $M) -> setCellValue('N' . $rowCount, $N) -> setCellValue('O' . $rowCount, $O) -> setCellValue('P' . $rowCount, $portoCost) -> setCellValue('Q' . $rowCount, $waardeboon);

			$time = date('Y-m-d H:i:s');
			$this -> model_order_export_order_export -> changeOrderStatus($value['order_id'], 108, $time);
			$rowCount++;
		}

		$fileName = 'order_export_' . date('Y_m_d_H_i_s') . '.xlsx';
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter -> save(str_replace(__FILE__, $fileName, __FILE__));
		echo $fileName;
	}

	public function export_all() {
		$this -> load -> model('setting/setting');
		$this -> load -> model('order_export/order_export');

		$orderData = $this -> model_order_export_order_export -> getOrdersWithId(array("order" => "DESC", "orderNum" => $_GET['orNum']));
		$flatPorto = $this -> model_setting_setting -> getSetting("flat");

		// Start renderinging Excel file with PHPEXCEL Class ( http://phpexcel.codeplex.com/ )
		define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
		require_once 'order_export_classes/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		$objPHPExcel -> getProperties() -> setCreator("Verburg Services") -> setLastModifiedBy("Verburg Services") -> setTitle("Order Export Gospel 7 " . date('H:i:s')) -> setSubject("Order Export Gospel 7 " . date('H:i:s')) -> setDescription("Order Export Gospel 7 " . date('H:i:s')) -> setKeywords("Order Export Gospel 7 " . date('H:i:s')) -> setCategory("Order Export Gospel 7 ");

		$rowCount = 1;

		foreach ($orderData as $key => $value) {
			$payMethod = $value['payment_method'];
			
			$total = " € - ";
			$totalNum = 0;
			$btw6incl = " € - ";
			$btw6 = " € - ";
			$btw6Excl = " € - ";
			$btw6Text = " € - ";
			$btw21Incl = " € - ";
			$btw21 = " € - ";
			$btw21Excl = " € - ";
			$btw21Text = " € - ";
			$portoCost = " € - ";
			$waardeboon = " € - ";
			$J = " € - ";
			$JCounter = 0;
			$K = " € - ";
			$KCounter = 0;
			$L = " € - ";
			$LCounter = 0;
			$M = " € - ";
			$MCounter = 0;
			$N = " € - ";
			$NCounter = 0.00;
			$O = " € - ";
			$OCounter = 0;

			$product = $this -> model_order_export_order_export -> getProducts($value['order_id']);
			$orderTotal = $this -> model_order_export_order_export -> getOrderTotal($value['order_id']);
			$couponData = $this -> model_order_export_order_export -> getCouponData($value['order_id']);

			foreach ($orderTotal as $key3 => $value3) {
				switch ($value3['code']) {
					case 'sub_total' :
						break;
					case 'shipping' :
						$portoCost = $value3['text'];
						break;
					case 'tax' :
						if ($value3['title'] == "6.0%") {
							$btw6 = $value3['value'];
							$btw6Text = $value3['text'];
						} else {
							$btw21 = $value3['value'];
							$btw21Text = $value3['text'];
						}
						break;
					case 'total' :
						$total = $value3['text'];
						$totalNum = $value3['value'];
						break;
					case 'coupon' :
						$waardeboon = $value3['text'];
						break;
					default :
						break;
				}
			}

			foreach ($product as $key2 => $value2) {

				// Eerst de korting, en dan pas de BTW
				$proPrice = $value2['total'];
				$proPrice += $portoCost;

				$tax = $this -> model_order_export_order_export -> getTax($value2['product_id']);
				
				if(!isset($tax['rate'])){
					$tax['rate'] = 21;
				}
				
				switch ((int)$tax['rate']) {
					case 6 :
						$proTax = ($proPrice / 100) * 6;
						$proAll = $proPrice + $proTax;
						$JCounter = $JCounter + $proAll;
						$KCounter = $KCounter + $proTax;
						$LCounter = $LCounter + $proPrice;
						break;
					case 21 :
						$proTax = ($proPrice / 100) * 21;
						$proAll = $proPrice + $proTax;
						$MCounter = $MCounter + $proAll;
						$NCounter = $NCounter + $proTax;
						$OCounter = $OCounter + $proPrice;
						break;
					default :
						break;
				}
			}

			$J = " € " . $this -> round_to_2dp($JCounter);
			$K = " € " . $this -> round_to_2dp($KCounter);
			$L = " € " . $this -> round_to_2dp($LCounter);
			$M = " € " . $this -> round_to_2dp($MCounter);
			$N = " € " . $this -> round_to_2dp($NCounter);
			$O = " € " . $this -> round_to_2dp($OCounter);

			$rekNum = $this -> model_order_export_order_export -> getRekNum($value['order_id']);
			if(isset($rekNum['iban'])){
				$iban = $rekNum['iban'];
			}else{
				$iban = " - ";
			}
			
			$orderStatus = $this -> model_order_export_order_export -> status($value['order_id']);
			$orderStatus = $orderStatus[0]['order_status_id'];
			
			
			$objPHPExcel -> getActiveSheet() -> getStyle('E' . $rowCount) -> getFill() -> applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'FF0000'), ));
			$objPHPExcel -> getActiveSheet() -> getStyle('J' . $rowCount) -> getFill() -> applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => '00FF00'), ));
			$objPHPExcel -> getActiveSheet() -> getStyle('M' . $rowCount) -> getFill() -> applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => '00FF00'), ));
			$objPHPExcel -> getActiveSheet() -> getStyle('P' . $rowCount) -> getFill() -> applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => '00FF00'), ));
			$objPHPExcel -> getActiveSheet() -> getStyle('Q' . $rowCount) -> getFill() -> applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => '00FF00'), ));

			$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue('A' . $rowCount, $rowCount) -> setCellValue('B' . $rowCount, $value['customer']) -> setCellValue('C' . $rowCount, $value['payment_city']) -> setCellValue('D' . $rowCount, $value['currency_code']) -> setCellValue('E' . $rowCount, $total) -> setCellValue('F' . $rowCount, $iban) -> setCellValue('G' . $rowCount, "Gospel 7") -> setCellValue('H' . $rowCount, $value['order_id']) -> setCellValue('I' . $rowCount, $value['email']) -> setCellValue('J' . $rowCount, $J) -> setCellValue('K' . $rowCount, $K) -> setCellValue('L' . $rowCount, $L) -> setCellValue('M' . $rowCount, $M) -> setCellValue('N' . $rowCount, $N) -> setCellValue('O' . $rowCount, $O) -> setCellValue('P' . $rowCount, $portoCost) -> setCellValue('Q' . $rowCount, $waardeboon) -> setCellValue('R' . $rowCount, $payMethod);
			
			$time = date('Y-m-d H:i:s');
			
			if($orderStatus == 113){
				$this -> model_order_export_order_export -> changeOrderStatus($value['order_id'], 114, $time);
			}elseif($orderStatus == 107){
				$this -> model_order_export_order_export -> changeOrderStatus($value['order_id'], 108, $time);
			}
			
			$rowCount++;
		}

		$fileName = 'order_export_' . date('Y_m_d_H_i_s') . '.xlsx';
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter -> save(str_replace(__FILE__, $fileName, __FILE__));
		echo $fileName;
	}

	public function install() {
		$this -> load -> model('setting/setting');
		$this -> model_setting_setting -> editSetting('order_export', array('order_export_status' => 1));
	}

	public function uninstall() {
		$this -> load -> model('setting/setting');
		$this -> model_setting_setting -> editSetting('order_export', array('order_export_status' => 0));
	}

	function round_to_2dp($number) {
		return number_format((float)$number, 2, '.', ',');
	}

	public function inchandle() {
		$this -> language -> load('module/order_export');
		$this -> load -> model('order_export/order_export');

		if (isset($this -> error['warning'])) {
			$this -> data['error_warning'] = $this -> error['warning'];
		} else {
			$this -> data['error_warning'] = '';
		}

		$this -> document -> setTitle($this -> language -> get('heading_title'));
		$this -> data['heading_title'] = $this -> language -> get('heading_title');

		$this -> data['button_save'] = $this -> language -> get('button_save');
		$this -> data['button_cancel'] = $this -> language -> get('button_cancel');
		$this -> data['button_filter'] = $this -> language -> get('button_filter');

		$this -> data['order_num'] = $this -> language -> get("order_num");
		$this -> data['articel'] = $this -> language -> get("articel");
		$this -> data['buyer'] = $this -> language -> get("buyer");
		$this -> data['status'] = $this -> language -> get("status");
		$this -> data['order_date'] = $this -> language -> get("order_date");
		$this -> data['order_change'] = $this -> language -> get("order_change");
		$this -> data['amount'] = $this -> language -> get("amount");
		$this -> data['total'] = $this -> language -> get("total");
		$this -> data['action'] = $this -> language -> get("action");
		$this -> data['button_apply_filter'] = $this -> language -> get("button_filter_apply");
		$this -> data['button_apply_filters'] = $this -> language -> get("button_filters_apply");
		$this -> data['apply'] = $this -> language -> get("apply");
		$this -> data['exportToExcel'] = $this -> language -> get("exportToExcel");
		$this -> data['succeed'] = $this -> language -> get("succeed");
		$this -> data['sucYes'] = $this -> language -> get("sucYes");
		$this -> data['sucNo'] = $this -> language -> get("sucNo");
		$this -> data['handleInc'] = $this -> language -> get("handleInc");

		$this -> data['orderData'] = $this -> model_order_export_order_export -> getOrders(array("order" => "DESC", "filter_order_status_id" => array(108, 114)));
		$this -> data['orderStatusen'] = $this -> model_order_export_order_export -> getOrderStatusen();

		$handleUrl = $this -> url -> link('module/order_export/inchandledo', 'token=' . $this -> session -> data['token'], 'SSL');
		$handleUrl = htmlspecialchars_decode($handleUrl);
		$this -> data['handleUrl'] = $handleUrl;

		$this -> data['breadcrumbs'] = array();

		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => false);
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_module'), 'href' => $this -> url -> link('module/order_export', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => ' :: ');
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_module_incHandle'), 'href' => $this -> url -> link('module/order_export/inchandle', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => ' :: ');

		$this -> template = 'module/order_export_inchandle.tpl';
		$this -> children = array('common/header', 'common/footer');

		$this -> response -> setOutput($this -> render());
	}

	public function inchandledo() {
		$this -> load -> model('setting/setting');
		$this -> load -> model('order_export/order_export');

		$orNum = explode("_", $_GET['orNum']);
		$orSucces = explode("_", $_GET['orSucces']);
		
		$succes = TRUE;
		$response = FALSE;
		foreach ($orNum as $key => $value) {
			$orderStatus = $this -> model_order_export_order_export -> status($value);
			$orderStatus = $orderStatus[0]['order_status_id'];
			
			$time = date('Y-m-d H:i:s');

			if ($orSucces[$key] == 0) {
				if($orderStatus == 114){
					$response = $this -> model_order_export_order_export -> changeOrderStatus($value, 113, $time);
				}else{
					$response = $this -> model_order_export_order_export -> changeOrderStatus($value, 107, $time);
				}
			} elseif ($orSucces[$key] == 1) {
				if($orderStatus == 114){
					$response = $this -> model_order_export_order_export -> changeOrderStatus($value, 3, $time);
				}else{
					$response = $this -> model_order_export_order_export -> changeOrderStatus($value, 101, $time);
				}
			}
			if ($response == FALSE) {
				$succes = FALSE;
			}
		}
		echo $succes;
	}

	public function all() {
		$this -> language -> load('module/order_export');
		$this -> load -> model('order_export/order_export');

		$this -> document -> setTitle($this -> language -> get('heading_title'));

		if (isset($this -> error['warning'])) {
			$this -> data['error_warning'] = $this -> error['warning'];
		} else {
			$this -> data['error_warning'] = '';
		}

		$this -> data['heading_title'] = $this -> language -> get('heading_title');

		$this -> data['button_save'] = $this -> language -> get('button_save');
		$this -> data['button_cancel'] = $this -> language -> get('button_cancel');
		$this -> data['button_filter'] = $this -> language -> get('button_filter');

		$this -> data['order_num'] = $this -> language -> get("order_num");
		$this -> data['articel'] = $this -> language -> get("articel");
		$this -> data['buyer'] = $this -> language -> get("buyer");
		$this -> data['status'] = $this -> language -> get("status");
		$this -> data['order_date'] = $this -> language -> get("order_date");
		$this -> data['order_change'] = $this -> language -> get("order_change");
		$this -> data['amount'] = $this -> language -> get("amount");
		$this -> data['total'] = $this -> language -> get("total");
		$this -> data['action'] = $this -> language -> get("action");
		$this -> data['button_apply_filter'] = $this -> language -> get("button_filter_apply");
		$this -> data['button_apply_filters'] = $this -> language -> get("button_filters_apply");
		$this -> data['apply'] = $this -> language -> get("apply");
		$this -> data['exportToExcel'] = $this -> language -> get("exportToExcel");

		$limit_start = 0;
		if (isset($this -> request -> get['lim_start'])) {
			$limit_start = $this -> request -> get['lim_start'];
		}
		$this -> data['lim_start'] = $limit_start;

		$this -> data['orderData'] = $this -> model_order_export_order_export -> getOrders(array("order" => "DESC", "start" => $limit_start, "limit" => 2000));
		$this -> data['minOrderId'] = $this -> model_order_export_order_export -> getMinOrder();
		$this -> data['maxOrderId'] = $this -> model_order_export_order_export -> getMaxOrder();
		$this -> data['orderStatusen'] = $this -> model_order_export_order_export -> getOrderStatusen();
		$this -> data['minOrderTotal'] = $this -> model_order_export_order_export -> getMinTotal();
		$this -> data['maxOrderTotal'] = $this -> model_order_export_order_export -> getMaxTotal();
		$this -> data['totalOrders'] = $this -> model_order_export_order_export -> countOrders();

		$page_url = $this -> url -> link('module/order_export/all', 'token=' . $this -> session -> data['token'], 'SSL');
		$page_url = htmlspecialchars_decode($page_url);
		$this -> data['imex_page_url'] = $page_url;
		$filterUrl = $this -> url -> link('module/order_export/filter', 'token=' . $this -> session -> data['token'], 'SSL');
		$filterUrl = htmlspecialchars_decode($filterUrl);
		$this -> data['filterUrl'] = $filterUrl;
		$exportUrl = $this -> url -> link('module/order_export/export_all', 'token=' . $this -> session -> data['token'], 'SSL');
		$exportUrl = htmlspecialchars_decode($exportUrl);
		$this -> data['exportUrl'] = $exportUrl;
		
		$this -> data['breadcrumbs'] = array();
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => false);
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_module'), 'href' => $this -> url -> link('module/order_export/all', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => ' :: ');

		$this -> template = 'module/order_export_all.tpl';
		$this -> children = array('common/header', 'common/footer');

		$this -> response -> setOutput($this -> render());
	}

}
