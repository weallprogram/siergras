<?php
//-----------------------------------------------------
// Newsletter Enhancements for Opencart
// Created by DmitryNek
// exmail.Nek@gmail.com
//-----------------------------------------------------

class ModelNeCheckDouble extends Model {

	public function getCustomerEmails() {
		$sql = "SELECT " . DB_PREFIX . "customer.email FROM `" . DB_PREFIX . "customer`";
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}

	public function getOldEmailsDouble() {
		$sql = "SELECT " . DB_PREFIX . "newsletter_old_system.uid, " . DB_PREFIX . "newsletter_old_system.email, " . DB_PREFIX . "newsletter_old_system.cat_uid FROM " . DB_PREFIX . "newsletter_old_system , " . DB_PREFIX . "customer WHERE " . DB_PREFIX . "customer.email = " . DB_PREFIX . "newsletter_old_system.email AND " . DB_PREFIX . "customer.newsletter = 1 ORDER BY " . DB_PREFIX . "newsletter_old_system.email ASC";
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}
	
	public function delete($uid){
		$sql = "DELETE FROM `" . DB_PREFIX . "newsletter_old_system` WHERE (`uid`='79998')";
		$this -> db -> query($sql);
	}
}
