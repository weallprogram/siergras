<?php

class ModelBackorderBackorder extends Model {

	public function getEmailAddr($order_id){
		$getEmailAddrQuery = "SELECT `email` FROM  `oc_order` WHERE order_id = " . $order_id;
		$result = $this -> db -> query($getEmailAddrQuery);
		return $result -> row;
	}
	
	public function getNewTotal($orderID){
		$newTotal = 0.00;
		$getProducts = "SELECT " . DB_PREFIX . "order_product.quantity, " . DB_PREFIX . "order_product.price, " . DB_PREFIX . "order_product.total, " . DB_PREFIX . "order_product.tax FROM  `" . DB_PREFIX . "order_product` WHERE order_id = " . $orderID;
		$result = $this -> db -> query($getProducts);
		$resultSet = $result -> rows;
		
		foreach ($resultSet as $key => $value){
			$aantal = $value['quantity'];
			$price = $value['price'];
			$total = $value['total'];
			$tax = $value['tax'];
			$tmpPrice = 0.00;
			
			$tmpPrice = floatval($price) + floatval($tax);
			$tmpPrice = $tmpPrice * $aantal;
			
			$newTotal = floatval($newTotal) + floatval($tmpPrice);
		}
		return $newTotal;
	}
	
    public function copyOrder($order_id) {
        $copyOrder = "INSERT INTO `" . DB_PREFIX . "order` (" . DB_PREFIX . "order.invoice_no, " . DB_PREFIX . "order.invoice_prefix, " . DB_PREFIX . "order.store_id, " . DB_PREFIX . "order.store_name, " . DB_PREFIX . "order.store_url, " . DB_PREFIX . "order.customer_id, " . DB_PREFIX . "order.customer_group_id, " . DB_PREFIX . "order.firstname, " . DB_PREFIX . "order.lastname, " . DB_PREFIX . "order.email, " . DB_PREFIX . "order.telephone, " . DB_PREFIX . "order.fax, " . DB_PREFIX . "order.payment_firstname, " . DB_PREFIX . "order.payment_lastname, " . DB_PREFIX . "order.payment_company, " . DB_PREFIX . "order.payment_company_id, " . DB_PREFIX . "order.payment_banca, " . DB_PREFIX . "order.payment_iban, " . DB_PREFIX . "order.payment_tax_id, " . DB_PREFIX . "order.payment_address_1, " . DB_PREFIX . "order.payment_address_2, " . DB_PREFIX . "order.payment_city, " . DB_PREFIX . "order.payment_postcode, " . DB_PREFIX . "order.payment_country, " . DB_PREFIX . "order.payment_country_id, " . DB_PREFIX . "order.payment_zone, " . DB_PREFIX . "order.payment_zone_id, " . DB_PREFIX . "order.payment_address_format, " . DB_PREFIX . "order.payment_method, " . DB_PREFIX . "order.payment_code, " . DB_PREFIX . "order.shipping_firstname, " . DB_PREFIX . "order.shipping_lastname, " . DB_PREFIX . "order.shipping_company, " . DB_PREFIX . "order.shipping_address_1, " . DB_PREFIX . "order.shipping_address_2, " . DB_PREFIX . "order.shipping_city, " . DB_PREFIX . "order.shipping_postcode, " . DB_PREFIX . "order.shipping_country, " . DB_PREFIX . "order.shipping_country_id, " . DB_PREFIX . "order.shipping_zone, " . DB_PREFIX . "order.shipping_zone_id, " . DB_PREFIX . "order.shipping_address_format, " . DB_PREFIX . "order.shipping_method, " . DB_PREFIX . "order.shipping_code, " . DB_PREFIX . "order.`comment`, " . DB_PREFIX . "order.total, " . DB_PREFIX . "order.order_status_id, " . DB_PREFIX . "order.affiliate_id, " . DB_PREFIX . "order.commission, " . DB_PREFIX . "order.language_id, " . DB_PREFIX . "order.currency_id, " . DB_PREFIX . "order.currency_code, " . DB_PREFIX . "order.currency_value, " . DB_PREFIX . "order.ip, " . DB_PREFIX . "order.forwarded_ip, " . DB_PREFIX . "order.user_agent, " . DB_PREFIX . "order.accept_language, " . DB_PREFIX . "order.date_added, " . DB_PREFIX . "order.date_modified)
                       SELECT " . DB_PREFIX . "order.invoice_no, " . DB_PREFIX . "order.invoice_prefix, " . DB_PREFIX . "order.store_id, " . DB_PREFIX . "order.store_name, " . DB_PREFIX . "order.store_url, " . DB_PREFIX . "order.customer_id, " . DB_PREFIX . "order.customer_group_id, " . DB_PREFIX . "order.firstname, " . DB_PREFIX . "order.lastname, " . DB_PREFIX . "order.email, " . DB_PREFIX . "order.telephone, " . DB_PREFIX . "order.fax, " . DB_PREFIX . "order.payment_firstname, " . DB_PREFIX . "order.payment_lastname, " . DB_PREFIX . "order.payment_company, " . DB_PREFIX . "order.payment_company_id, " . DB_PREFIX . "order.payment_banca, " . DB_PREFIX . "order.payment_iban, " . DB_PREFIX . "order.payment_tax_id, " . DB_PREFIX . "order.payment_address_1, " . DB_PREFIX . "order.payment_address_2, " . DB_PREFIX . "order.payment_city, " . DB_PREFIX . "order.payment_postcode, " . DB_PREFIX . "order.payment_country, " . DB_PREFIX . "order.payment_country_id, " . DB_PREFIX . "order.payment_zone, " . DB_PREFIX . "order.payment_zone_id, " . DB_PREFIX . "order.payment_address_format, " . DB_PREFIX . "order.payment_method, " . DB_PREFIX . "order.payment_code, " . DB_PREFIX . "order.shipping_firstname, " . DB_PREFIX . "order.shipping_lastname, " . DB_PREFIX . "order.shipping_company, " . DB_PREFIX . "order.shipping_address_1, " . DB_PREFIX . "order.shipping_address_2, " . DB_PREFIX . "order.shipping_city, " . DB_PREFIX . "order.shipping_postcode, " . DB_PREFIX . "order.shipping_country, " . DB_PREFIX . "order.shipping_country_id, " . DB_PREFIX . "order.shipping_zone, " . DB_PREFIX . "order.shipping_zone_id, " . DB_PREFIX . "order.shipping_address_format, " . DB_PREFIX . "order.shipping_method, " . DB_PREFIX . "order.shipping_code, " . DB_PREFIX . "order.`comment`, " . DB_PREFIX . "order.total, " . DB_PREFIX . "order.order_status_id, " . DB_PREFIX . "order.affiliate_id, " . DB_PREFIX . "order.commission, " . DB_PREFIX . "order.language_id, " . DB_PREFIX . "order.currency_id, " . DB_PREFIX . "order.currency_code, " . DB_PREFIX . "order.currency_value, " . DB_PREFIX . "order.ip, " . DB_PREFIX . "order.forwarded_ip, " . DB_PREFIX . "order.user_agent, " . DB_PREFIX . "order.accept_language, " . DB_PREFIX . "order.date_added, " . DB_PREFIX . "order.date_modified  FROM `" . DB_PREFIX . "order` WHERE order_id = " . $order_id . ";";
        $result = $this -> db -> query($copyOrder);
        return $this -> db -> getLastId();
    }

    public function copyOrderHistory($order_id, $order_id_new) {
        $orderHistory = "SELECT " . DB_PREFIX . "order_history.order_status_id, " . DB_PREFIX . "order_history.notify, " . DB_PREFIX . "order_history.`comment`, " . DB_PREFIX . "order_history.date_added FROM `" . DB_PREFIX . "order_history` WHERE order_id = " . $order_id;
        $result = $this -> db -> query($orderHistory);
        $resultSet = $result -> rows;

        foreach ($resultSet as $key => $value) {
            $insertQuery = "INSERT INTO `" . DB_PREFIX . "order_history` (`order_id`, `order_status_id`, `notify`, `comment`, `date_added`) VALUES ('" . $order_id_new . "', '" . $value['order_status_id'] . "', '" . $value['notify'] . "', '" . $value['comment'] . "', '" . $value['date_added'] . "')";
            $this -> db -> query($insertQuery);
        }
    }

    public function copyOrderField($order_id, $order_id_new) {
        $orderField = "SELECT " . DB_PREFIX . "order_field.custom_field_id, " . DB_PREFIX . "order_field.custom_field_value_id, " . DB_PREFIX . "order_field.`name`, " . DB_PREFIX . "order_field.`value`, " . DB_PREFIX . "order_field.sort_order FROM `" . DB_PREFIX . "order_field` WHERE order_id = " . $order_id;
        $result = $this -> db -> query($orderField);
        $resultSet = $result -> rows;

        foreach ($resultSet as $key => $value) {
            $insertQuery = "INSERT INTO `" . DB_PREFIX . "order_field` (`order_id`, `custom_field_id`, `custom_field_value_id`, `name`, `value`, `sort_order`) VALUES ('" . $order_id_new . "', '" . $value['custom_field_id'] . "', '" . $value['custom_field_value_id'] . "', '" . $value['name'] . "', '" . $value['value'] . "', '" . $value['sort_order'] . "')";
            $this -> db -> query($insertQuery);
        }
    }

    public function copyOrderIncasso($order_id, $order_id_new) {
        $orderIncasso = "SELECT " . DB_PREFIX . "order_incasso.iban FROM `" . DB_PREFIX . "order_incasso` WHERE order_id = " . $order_id;
        $result = $this -> db -> query($orderIncasso);
        $resultSet = $result -> rows;

        foreach ($resultSet as $key => $value) {
            $insertQuery = "INSERT INTO `" . DB_PREFIX . "order_incasso` (`order_id`, `iban`) VALUES ('" . $order_id_new . "', '" . $value['iban'] . "')";
            $this -> db -> query($insertQuery);
        }
    }

    public function copyOrderOption($order_id, $order_id_new) {
        $orderOption = "SELECT " . DB_PREFIX . "order_option.order_product_id, " . DB_PREFIX . "order_option.product_option_id, " . DB_PREFIX . "order_option.product_option_value_id, " . DB_PREFIX . "order_option.`name`, " . DB_PREFIX . "order_option.`value`, " . DB_PREFIX . "order_option.type FROM `" . DB_PREFIX . "order_option` WHERE order_id = " . $order_id;
        $result = $this -> db -> query($orderOption);
        $resultSet = $result -> rows;

        foreach ($resultSet as $key => $value) {
            $insertQuery = "INSERT INTO `" . DB_PREFIX . "order_option` (`order_id`, `order_product_id`, `product_option_id`, `product_option_value_id`, `name`, `value`, `type`) VALUES ('" . $order_id_new . "', '" . $value['order_product_id'] . "', '" . $value['product_option_id'] . "', '" . $value['product_option_value_id'] . "', '" . $value['name'] . "', '" . $value['value'] . "', '" . $value['type'] . "')";
            $this -> db -> query($insertQuery);
        }
    }

    public function copyOrderVoucher($order_id, $order_id_new) {
        $orderVoucher = "SELECT " . DB_PREFIX . "order_voucher.order_voucher_id, " . DB_PREFIX . "order_voucher.order_id, " . DB_PREFIX . "order_voucher.voucher_id, " . DB_PREFIX . "order_voucher.description, " . DB_PREFIX . "order_voucher.`code`, " . DB_PREFIX . "order_voucher.from_name, " . DB_PREFIX . "order_voucher.from_email, " . DB_PREFIX . "order_voucher.to_name, " . DB_PREFIX . "order_voucher.to_email, " . DB_PREFIX . "order_voucher.voucher_theme_id, " . DB_PREFIX . "order_voucher.message, " . DB_PREFIX . "order_voucher.amount FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = " . $order_id;
        $result = $this -> db -> query($orderVoucher);
        $resultSet = $result -> rows;

        foreach ($resultSet as $key => $value) {
            $insertQuery = "INSERT INTO `" . DB_PREFIX . "order_voucher` (`order_id`, `voucher_id`, `description`, `code`, `from_name`, `from_email`, `to_name`, `to_email`, `voucher_theme_id`, `message`, `amount`) VALUES ('" . $order_id_new . "', '" . $value['voucher_id'] . "', '" . $value['description'] . "', '" . $value['code'] . "', '" . $value['from_name'] . "', '" . $value['from_email'] . "', '" . $value['to_name'] . "', '" . $value['to_email'] . "', '" . $value['voucher_theme_id'] . "', '" . $value['message'] . "', '" . $value['amount'] . "')";
            $this -> db -> query($insertQuery);
        }
    }
	
	public function copyOrderTotal($order_id, $order_id_new){
		$orderVoucher = "SELECT " . DB_PREFIX . "order_total.code, " . DB_PREFIX . "order_total.title, " . DB_PREFIX . "order_total.text, " . DB_PREFIX . "order_total.value, " . DB_PREFIX . "order_total.`sort_order` FROM `" . DB_PREFIX . "order_total` WHERE order_id = " . $order_id;
        $result = $this -> db -> query($orderVoucher);
        $resultSet = $result -> rows;

        foreach ($resultSet as $key => $value) {
            $insertQuery = "INSERT INTO `" . DB_PREFIX . "order_total` (`order_id`, `code`, `title`, `text`, `value`, `sort_order`) VALUES ('" . $order_id_new . "', '" . $value['code'] . "', '" . $value['title'] . "', '" . $value['text'] . "', '" . $value['value'] . "', '" . $value['sort_order'] . "')";
            $this -> db -> query($insertQuery);
        }
	}	

    public function fixOrderProducts($order_id, $order_id_new, $proNum) {
        foreach ($proNum as $key => $value) {
            $productInfo = "SELECT " . DB_PREFIX . "order_product.`name`, " . DB_PREFIX . "order_product.model, " . DB_PREFIX . "order_product.quantity, " . DB_PREFIX . "order_product.price, " . DB_PREFIX . "order_product.total, " . DB_PREFIX . "order_product.tax, " . DB_PREFIX . "order_product.reward FROM `" . DB_PREFIX . "order_product` WHERE order_id = " . $order_id . " AND product_id = " . $value . ";";
            $result = $this -> db -> query($productInfo);
            $resultSet = $result -> rows;

            foreach ($resultSet as $key2 => $value2) {
                $insertQuery = "INSERT INTO `" . DB_PREFIX . "order_product` (`order_id`, `product_id`, `name`, `model`, `quantity`, `price`, `total`, `tax`, `reward`) VALUES ('" . $order_id_new . "', '" . $value ."', '" . $value2['name'] . "', '" . $value2['model'] . "', '" . $value2['quantity'] . "', '" . $value2['price'] . "', '" . $value2['total'] . "', '" . $value2['tax'] . "', '" . $value2['reward'] . "')";
                $this -> db -> query($insertQuery);
                
                $deleteQuery = "DELETE FROM `" . DB_PREFIX . "order_product` WHERE ( `order_id` = '" . $order_id . "' AND `product_id` = '" . $value . "')";
                $this -> db -> query($deleteQuery);
            }
        }
    }
	
	public function fixTotalFirst($orderUID, $newTotal){
		$subTotal = ($newTotal / 121 ) * 100;
		$tax = ($subTotal / 100 ) * 21;
		
		$subTotalText = round($subTotal, 2);
		$taxText = round($tax, 2);
		$newTotalText = round($newTotal, 2);
		
		$updateFixTotalOrder = "UPDATE  `" . DB_PREFIX . "order` SET `total` = '" . $newTotal . "' WHERE `order_id` = " . $orderUID;
		$orderTotalFix1 = "UPDATE `" . DB_PREFIX . "order_total` SET `value` = " . $subTotal . ", `text` = '€" . $subTotalText . "' WHERE `order_id` = " . $orderUID . " AND `code` = 'sub_total'";
		$orderTotalFix2 = "UPDATE `" . DB_PREFIX . "order_total` SET `value` = " . $tax . ", `text` = '€" . $taxText . "' WHERE `order_id` = " . $orderUID . " AND `code` = 'tax'";
		$orderTotalFix3 = "UPDATE `" . DB_PREFIX . "order_total` SET `value` = " . $newTotal . ", `text` = '€" . $newTotalText . "' WHERE `order_id` = " . $orderUID . " AND `code` = 'total'";
		
		$this -> db -> query($updateFixTotalOrder);
		$this -> db -> query($orderTotalFix1);
		$this -> db -> query($orderTotalFix2);
		$this -> db -> query($orderTotalFix3);
		
	}
	
	public function fixTotalSecond($orderUID, $newTotal){
		$subTotal = ($newTotal / 121 ) * 100;
		$tax = ($subTotal / 100 ) * 21;
		
		$subTotalText = round($subTotal, 2);
		$taxText = round($tax, 2);
		$newTotalText = round($newTotal, 2);
		
		$updateFixTotalOrder = "UPDATE  `" . DB_PREFIX . "order` SET `total` = '" . $newTotal . "' WHERE `order_id` = " . $orderUID;
		$deletePromotion = "DELETE FROM `" . DB_PREFIX . "order_total` WHERE ( `order_id` = '" . $orderUID . "' AND `code` = 'gift_promotion')";
		$orderTotalFix1 = "UPDATE `" . DB_PREFIX . "order_total` SET `value` = " . $subTotal . ", `text` = '€" . $subTotalText . "' WHERE `order_id` = " . $orderUID . " AND `code` = 'sub_total'";
		$orderTotalFix2 = "UPDATE `" . DB_PREFIX . "order_total` SET `value` = " . $tax . ", `text` = '€" . $taxText . "' WHERE `order_id` = " . $orderUID . " AND `code` = 'tax'";
		$orderTotalFix3 = "UPDATE `" . DB_PREFIX . "order_total` SET `value` = " . $newTotal . ", `text` = '€" . $newTotalText . "' WHERE `order_id` = " . $orderUID . " AND `code` = 'total'";
		
		$this -> db -> query($updateFixTotalOrder);
		$this -> db -> query($deletePromotion);
		$this -> db -> query($orderTotalFix1);
		$this -> db -> query($orderTotalFix2);
		$this -> db -> query($orderTotalFix3);
		
	}
	
	public function insertNewHistory($order_id, $order_status_id, $notify, $comment, $date_added){
		$comment = str_replace("'", "&prime;", $comment);
		$comment = html_entity_decode($comment);
		$comment = str_replace("'", "&prime;", $comment);
		$insertHistory = "INSERT INTO `" . DB_PREFIX . "order_history` (`order_id`, `order_status_id`, `notify`, `comment`, `date_added`) VALUES ('" . $order_id . "', '" . $order_status_id . "', '" . $notify . "', '" . $comment . "', '" . $date_added . "' )";
		$this -> db -> query($insertHistory);
	}
	
	public function setNewOrderState($order_id, $order_status_id){
		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
	}
	
	public function emailCustomer($email, $msg){
		$message  = '<html dir="ltr" lang="en">' . PHP_EOL;
        $message .= '<head>' . PHP_EOL;
        $message .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . PHP_EOL;
        $message .= '<title>Er zijn wijzigingen aangebracht aan uw order</title>' . PHP_EOL;
        $message .= '</head>' . PHP_EOL;
        $message .= '<body style="padding:0;margin:0;">' . $msg . '</body>' . PHP_EOL;
        $message .= '</html>' . PHP_EOL;
		
		$message = html_entity_decode($message);
		
		$message = str_replace(array(chr(3)), '', $message);

		// Content-type header instellen om HTML-mail te versturen  
		// $headers = "Content-type: text/html; charset=iso-8859-1\r\n";  
		// $headers .= "MIME-Version: 1.0\r\n";     
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		$headers .= 'To: ' . $email . "\r\n";
		$headers .= 'From: Verburg Services <info@gospel7.com>' . "\r\n";
		
		mail($email, 'Er zijn wijzigingen aangebracht aan uw order', $message, $headers);
	}

    private function printExtender($arr) {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }

}
?>
