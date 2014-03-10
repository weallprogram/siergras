<?php

class Modelneneoldlist extends Model {
	function getOldBrian() {
		$sql = "SELECT oc_newsletter_old_system.email FROM `oc_newsletter_old_system` WHERE oc_newsletter_old_system.cat_uid = 1";
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}
	
	function getOldDunamis() {
		$sql = "SELECT oc_newsletter_old_system.email FROM `oc_newsletter_old_system` WHERE oc_newsletter_old_system.cat_uid = 2";
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}
	
	function getOldFrohlich() {
		$sql = "SELECT oc_newsletter_old_system.email FROM `oc_newsletter_old_system` WHERE oc_newsletter_old_system.cat_uid = 3";
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}
	
	function getOldGaithers() {
		$sql = "SELECT oc_newsletter_old_system.email FROM `oc_newsletter_old_system` WHERE oc_newsletter_old_system.cat_uid = 4";
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}
	
	function getOldGospel7() {
		$sql = "SELECT oc_newsletter_old_system.email FROM `oc_newsletter_old_system` WHERE oc_newsletter_old_system.cat_uid = 5";
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}
	
	function getOldLifeshop() {
		$sql = "SELECT oc_newsletter_old_system.email FROM `oc_newsletter_old_system` WHERE oc_newsletter_old_system.cat_uid = 6";
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}
	
	function getOldMeyer() {
		$sql = "SELECT oc_newsletter_old_system.email FROM `oc_newsletter_old_system` WHERE oc_newsletter_old_system.cat_uid = 7";
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}
	
	function getOldOpwekking() {
		$sql = "SELECT oc_newsletter_old_system.email FROM `oc_newsletter_old_system` WHERE oc_newsletter_old_system.cat_uid = 8";
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}
	
	function getOldPelgrimKerken() {
		$sql = "SELECT oc_newsletter_old_system.email FROM `oc_newsletter_old_system` WHERE oc_newsletter_old_system.cat_uid = 9";
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}
	
	function getOldPelgrimKlanten() {
		$sql = "SELECT oc_newsletter_old_system.email FROM `oc_newsletter_old_system` WHERE oc_newsletter_old_system.cat_uid = 10";
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}
	
	function getOldPelgrimPers() {
		$sql = "SELECT oc_newsletter_old_system.email FROM `oc_newsletter_old_system` WHERE oc_newsletter_old_system.cat_uid = 11";
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}
	
	function getOldPelgrimScholen() {
		$sql = "SELECT oc_newsletter_old_system.email FROM `oc_newsletter_old_system` WHERE oc_newsletter_old_system.cat_uid = 12";
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}
	
	function getOldTest() {
		$sql = "SELECT oc_newsletter_old_system.email FROM `oc_newsletter_old_system` WHERE oc_newsletter_old_system.cat_uid = 13";
		$query = $this -> db -> query($sql);
		return $query -> rows;
	}

}
