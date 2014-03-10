<?php

class ModelNewsletterList extends Model {

    function printExtender($arr) {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }
	
	function getList(){
		$getQuery = "SELECT em.uid, em.email, cat.name FROM  `" . DB_PREFIX . "newsletter_old_system` AS em, `" . DB_PREFIX . "newsletter_categorie` AS cat WHERE em.cat_uid = cat.uid ORDER BY  em.cat_uid ASC LIMIT 0, 1000";
		$result = $this -> db -> query($getQuery);
		return $result -> rows;
	}
	
	function getListFilter($data){
		$getQuery = "SELECT em.uid, em.email, cat.name 
					FROM  `" . DB_PREFIX . "newsletter_old_system` AS em, `" . DB_PREFIX . "newsletter_categorie` AS cat 
					WHERE em.cat_uid = cat.uid ";
					
		if(isset($data['filter_id'])){
			$getQuery .= " AND em.uid = " . $data['filter_id'] . " ";
		}
		
		if(isset($data['filter_email'])){
			$getQuery .= " AND em.email = '" . $data['filter_email'] . "' ";
		}
		
		if(isset($data['filter_cat'])){
			$getQuery .= " AND cat.uid = " . $data['filter_cat'] . " ";
		}
		
		$getQuery .= "ORDER BY  em.cat_uid ASC ";
		
		if(isset($data['lim_start'])){
			$getQuery .= "LIMIT " . (int)$data['lim_start'] . ", " . ((int)$data['lim_start'] + 1000 );
		}else{
			$getQuery .= "LIMIT 0, 1000";
		}
		
		$result = $this -> db -> query($getQuery);
		return $result -> rows;
	}
	
	function getMinTotal($type){
		$sql = "";
		switch($type){
			case 'all':
				$sql = "SELECT em.uid FROM  `" . DB_PREFIX . "newsletter_old_system` AS em, `" . DB_PREFIX . "newsletter_categorie` AS cat WHERE em.cat_uid = cat.uid ORDER BY  em.uid ASC LIMIT 0, 1";				
				break;
			default:
				$sql = "SELECT em.uid FROM  `" . DB_PREFIX . "newsletter_old_system` AS em, `" . DB_PREFIX . "newsletter_categorie` AS cat WHERE em.cat_uid = cat.uid AND cat.uid = " . $type . " ORDER BY  em.uid ASC LIMIT 0, 1";
				break;
		}
		$query = $this -> db -> query($sql);
		return $query -> row;
	}
	
	function getMaxTotal($type){
		$sql = "";
		switch($type){
			case 'all':
				$sql = "SELECT em.uid FROM  `" . DB_PREFIX . "newsletter_old_system` AS em, `" . DB_PREFIX . "newsletter_categorie` AS cat WHERE em.cat_uid = cat.uid ORDER BY  em.uid DESC LIMIT 0, 1";
				break;
			default:
				$sql = "SELECT em.uid FROM  `" . DB_PREFIX . "newsletter_old_system` AS em, `" . DB_PREFIX . "newsletter_categorie` AS cat WHERE em.cat_uid = cat.uid AND cat.uid = " . $type . " ORDER BY  em.uid DESC LIMIT 0, 1";
				break;
		}
		$query = $this -> db -> query($sql);
		return $query -> row;
	}
	
	function getAllTotal($type){
		$sql = "";
		switch ($type){
			case 'all':
				$sql = "SELECT COUNT(*) FROM  `" . DB_PREFIX . "newsletter_old_system` AS em, `" . DB_PREFIX . "newsletter_categorie` AS cat WHERE em.cat_uid = cat.uid";
				break;
			default:
				$sql = "SELECT COUNT(*) FROM  `" . DB_PREFIX . "newsletter_old_system` AS em, `" . DB_PREFIX . "newsletter_categorie` AS cat WHERE em.cat_uid = cat.uid AND cat.uid = " . $type;
				break;
		}
		$query = $this -> db -> query($sql);
		return $query -> row;
	}
	
	function deleteUser($uid){
		$sql = "DELETE FROM " . DB_PREFIX . "newsletter_old_system WHERE `uid` = " . $uid;
		$this -> db -> query($sql);
	}
}