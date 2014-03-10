<?php

class Modelorderexportorderexport extends Model {
	public function getOrders($data = array()) {
		$sql = "SELECT o.order_id, CONCAT(o.firstname, ' ', o.lastname) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this -> config -> get('config_language_id') . "') AS status, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified FROM `" . DB_PREFIX . "order` o";

		$sql .= " WHERE ";

		if (isset($data['filter_order_status_id'])) {
			$andDone = 0;
			if(is_array($data['filter_order_status_id'])){
				foreach ($data['filter_order_status_id'] as $key => $value) {
					if ($andDone > 0) {
						$sql .= ' OR ';
					}
					$sql .= " o.order_status_id = '" . (int)$value . "'";
					$andDone++;
				}
			}else{
				$sql .= " o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
			}
		} else {
			$sql .= " o.order_status_id > '0'";
		}

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this -> db -> escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this -> db -> escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(o.date_modified) = DATE('" . $this -> db -> escape($data['filter_date_modified']) . "')";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
		}

		$sort_data = array('o.order_id', 'customer', 'status', 'o.date_added', 'o.date_modified', 'o.total');

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY o.order_id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this -> db -> query($sql);

		return $query -> rows;
	}

	public function getMinOrder() {
		$sql = "SELECT o.order_id FROM `" . DB_PREFIX . "order` o  WHERE order_status_id > '0' ORDER BY o.order_id ASC  LIMIT 0,1";
		$query = $this -> db -> query($sql);
		return $query -> row;
	}

	public function getMaxOrder() {
		$sql = "SELECT o.order_id FROM `" . DB_PREFIX . "order` o  WHERE order_status_id > '0' ORDER BY o.order_id DESC  LIMIT 0,1";
		$query = $this -> db -> query($sql);
		return $query -> row;
	}

	public function getOrderStatusen() {
		$sql = "SELECT name, order_status_id FROM " . DB_PREFIX . "order_status WHERE language_id = '" . (int)$this -> config -> get('config_language_id') . "' AND order_status_id > '0' ";
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}

	public function getMinTotal() {
		$sql = "SELECT o.total FROM `" . DB_PREFIX . "order` o  WHERE o.order_status_id > '0' ORDER BY o.total ASC  LIMIT 0,1";
		$query = $this -> db -> query($sql);
		return $query -> row;
	}

	public function getMaxTotal() {
		$sql = "SELECT o.total FROM `" . DB_PREFIX . "order` o WHERE o.order_status_id > '0' ORDER BY o.total  DESC  LIMIT 0,1";
		$query = $this -> db -> query($sql);
		return $query -> row;
	}

	public function getOrdersFilter($data = array()) {
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		$orNum = explode("-", $data['orNum']);
		$startStartDate = trim(trim(str_replace("_", " ", $data['startStartDate'])));
		$startEndDate = trim(str_replace("_", " ", $data['startEndDate']));
		$editStartDate = trim(str_replace("_", " ", $data['editStartDate']));
		$editEndDate = trim(str_replace("_", " ", $data['editEndDate']));
		$total = explode("-", $data['total']);
		if((int)$total[1] < 1 || $total[1] == "" ){
			$total[1] = 0;
		}

		$sql = "SELECT o.order_id,  CONCAT(o.firstname, ' ', o.lastname) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this -> config -> get('config_language_id') . "') AS status, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified FROM `" . DB_PREFIX . "order` o";

		if (isset($data['status']) && !is_null($data['status']) && $data['status'] != "*") {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['status'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id = '107'";
			$sql .= " OR o.order_status_id = 113";
			$sql .= " OR o.order_status_id = 101";
			$sql .= " OR o.order_status_id = 1";
		}

		$sql .= " AND o.order_id >= '" . (int)$orNum[0] . "'";
		$sql .= " AND o.order_id <= '" . (int)$orNum[1] . "'";

		if (isset($data['name']) && trim($data['name']) !== "") {
			$sql .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this -> db -> escape($data['name']) . "%'";
		}

		if (isset($startStartDate) && trim($startStartDate) !== "") {
			$sql .= " AND DATE(o.date_added) >= DATE('" . $startStartDate . "')";
		}

		if (isset($startEndDate) && trim($startEndDate) !== "") {
			$sql .= " AND DATE(o.date_added) <= DATE('" . $startEndDate . "')";
		}

		if (isset($editStartDate) && trim($editStartDate) !== "") {
			$sql .= " AND DATE(o.date_modified) >= DATE('" . $editStartDate . "')";
		}
		if (isset($editEndDate) && trim($editEndDate) !== "") {
			$sql .= " AND DATE(o.date_modified) <= DATE('" . $editEndDate . "')";
		}

		if (isset($total[0])) {
			$sql .= " AND o.total >= '" . (float)$total[1] . "'";
		}
		if (isset($total[1])) {
			$sql .= " AND o.total <= '" . (float)$total[2] . "'";
		}

		$sql .= " ORDER BY o.order_id DESC";

		$query = $this -> db -> query($sql);
		return $query -> rows;
	}

	public function getOrdersWithId($data = array()) {
		$sql = "SELECT o.order_id, o.shipping_code, o.payment_city, o.order_status_id, o.payment_method, CONCAT(o.firstname, ' ', o.lastname) AS customer, o.customer_id, o.email, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this -> config -> get('config_language_id') . "') AS status, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified FROM `" . DB_PREFIX . "order` o";

		if (isset($data['filter_order_status_id']) && !is_null($data['filter_order_status_id'])) {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}

		$firstOrder = 0;
		if (!empty($data['orderNum'])) {
			$orderNum = explode("_", $data['orderNum']);
			foreach ($orderNum as $key => $value) {
				if ($firstOrder == 0) {
					$sql .= " AND o.order_id = " . (int)$value;
					$firstOrder++;
				} else {
					$sql .= " OR o.order_id = " . (int)$value;
				}
			}
		}

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this -> db -> escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this -> db -> escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(o.date_modified) = DATE('" . $this -> db -> escape($data['filter_date_modified']) . "')";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
		}

		$sort_data = array('o.order_id', 'customer', 'status', 'o.date_added', 'o.date_modified', 'o.total');

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY o.order_id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this -> db -> query($sql);

		return $query -> rows;
	}

	public function getRekNum($orderId) {
		$sql = "	SELECT o.iban 
					FROM
					`" . DB_PREFIX . "order_incasso` o  
					WHERE
					o.order_id = " . (int)$orderId;
		$query = $this -> db -> query($sql);
		return $query -> row;
	}

	public function getProducts($orderNum) {
		$sql = "	SELECT
					o.product_id,
					o.price,
					o.total,
					o.quantity
					FROM
					`" . DB_PREFIX . "order_product` o
					WHERE
					o.order_id = " . (int)$orderNum;
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}

	public function getTax($productId) {
		$sql = "	SELECT
					o.tax_class_id
					FROM
					`" . DB_PREFIX . "product` o
					WHERE
					o.product_id = " . (int)$productId;
		$query = $this -> db -> query($sql);
		$taxId = $query -> row;

		if(!isset($taxId['tax_class_id'])){
			$taxId['tax_class_id'] = 11;
		}
		
		$sql = "	SELECT
					o.tax_rate_id
					FROM
					`" . DB_PREFIX . "tax_rule` o
					WHERE
					o.tax_class_id = " . (int)$taxId['tax_class_id'];
		$query = $this -> db -> query($sql);
		$queryResult = $query -> row;

		if(!isset($queryResult['tax_rate_id'])){
			$queryResult['tax_rate_id'] = 89;
		}
		$sql = "	SELECT
					o.rate,
					o.`name`
					FROM
					`" . DB_PREFIX . "tax_rate` o 
					WHERE
					o.tax_rate_id = " . (int)$queryResult['tax_rate_id'];
		$query = $this -> db -> query($sql);
		return $query -> row;
	}

	function getCouponData($orderNum) {
		$sql = "	SELECT
					o.coupon_id
					FROM
					`" . DB_PREFIX . "coupon_history` o
					WHERE
					o.order_id = " . (int)$orderNum;
		$query = $this -> db -> query($sql);
		$queryResult = $query -> row;

		if (isset($queryResult['coupon_id']) && trim($queryResult['coupon_id']) != "") {
			$sql = "	SELECT
						o.type,
						o.discount
						FROM
						`" . DB_PREFIX . "coupon` o
						WHERE
						o.coupon_id = " . (int)$queryResult['coupon_id'];
			$query = $this -> db -> query($sql);
			return $query -> row;
		} else {
			return FALSE;
		}
	}

	function getOrderTotal($orderId) {
		$sql = "	SELECT * 
					FROM  `" . DB_PREFIX . "order_total` 
					WHERE  `order_id` = " . (int)$orderId;
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}

	function changeOrderStatus($orderId, $newStatus, $time) {
		$sql = "	UPDATE `" . DB_PREFIX . "order` SET `order_status_id`='$newStatus' WHERE (`order_id`='$orderId')";
		$response1 = $this -> db -> query($sql);
		$sql = "	INSERT INTO `" . DB_PREFIX . "order_history` (`order_id`, `order_status_id`, `notify`, `comment`, `date_added`) VALUES ('$orderId', '$newStatus', '1', 'Incasso wordt uitgevoerd', '$time')";
		$response2 = $this -> db -> query($sql);
		if ($response1 == TRUE && $response2 == TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function status($orderId) {
		$sql = "SELECT order_status_id FROM `" . DB_PREFIX . "order` WHERE order_id = " . (int)$orderId;
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}
	
	function countOrders(){
		$sql = "SELECT COUNT(*) FROM `oc_order`";
		$query = $this -> db -> query($sql);
		return $query -> row;
	}

}
