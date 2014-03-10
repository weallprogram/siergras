<?php
class ModelPaymentIncasso extends Model {
	public function getMethod($address, $total) {
		$this -> language -> load('payment/incasso');

		$query = $this -> db -> query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this -> config -> get('incasso_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this -> config -> get('incasso_total') > 0 && $this -> config -> get('incasso_total') > $total) {
			$status = false;
		} elseif (!$this -> config -> get('incasso_geo_zone_id')) {
			$status = true;
		} elseif ($query -> num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array('code' => 'incasso', 'title' => $this -> language -> get('text_title'), 'sort_order' => $this -> config -> get('incasso_sort_order'));
		}

		return $method_data;
	}

	public function insertRekNum($orderNum, $rekNum) {
		$sql = "INSERT INTO  `" . DB_PREFIX . "order_incasso` (
					`order_id` ,
					`iban`
					)
					VALUES (
					'$orderNum',  '$rekNum'
					);";
		$this -> db -> query($sql);
	}

}
?>