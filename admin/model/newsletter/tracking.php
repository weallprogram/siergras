<?php

class ModelNewsletterTracking extends Model {

    function printExtender($arr) {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }
	
	public function getTotalQueued(){
		$getQuery = "SELECT COUNT(*) FROM  `" . DB_PREFIX . "newsletter_queue`";
		$result = $this -> db -> query($getQuery);
		return $result -> row;
	}
	
	public function getPausedQueued(){
		$getQuery = "SELECT COUNT(queue.uid) FROM  `" . DB_PREFIX . "newsletter_queue` as queue, `" . DB_PREFIX . "newsletter_letter` as letter WHERE letter.paused = 1 AND queue.newsletter_uid = letter.uid";
		$result = $this -> db -> query($getQuery);
		return $result -> row;
	}
	
	public function getLetterQueued(){
		$getQuery= "SELECT COUNT(DISTINCT `newsletter_uid`) FROM  `" . DB_PREFIX . "newsletter_queue`";
		$result = $this -> db -> query($getQuery);
		return $result -> row;
	}
	
	public function getLetters(){
		$getQuery = "SELECT `uid`, `from`, `subject`, `max_send`, `already_send`, `created`, `last_send`, `paused` FROM  `" . DB_PREFIX . "newsletter_letter`  ORDER BY  `" . DB_PREFIX . "newsletter_letter`.`uid` DESC ";
		$result = $this -> db -> query($getQuery);
		return $result -> rows;
	}
	
	public function getMainInfo($uid){
		$getQuery = "SELECT `uid`, `from`, `subject`, `content`, `max_send`, `already_send`, `paused` FROM  `" . DB_PREFIX . "newsletter_letter` WHERE uid = " . $uid;
		$result = $this -> db -> query($getQuery);
		return $result -> row;
	}
	
	public function changePause($uid){
		$newStatus = array(0 => 1, 1 => 0);
		$getQuery = "SELECT `paused` FROM  `" . DB_PREFIX . "newsletter_letter` WHERE uid = " . $uid;
		$result = $this -> db -> query($getQuery);
		$resultSet = $result -> row;
		
		$updateQuery = "UPDATE  `" . DB_PREFIX . "newsletter_letter` SET `paused` = '" . $newStatus[$resultSet['paused']] . "' WHERE `uid` = ". $uid;
		$this -> db -> query($updateQuery);
	}
}