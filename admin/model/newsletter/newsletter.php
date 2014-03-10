<?php

class ModelNewsletterNewsletter extends Model {

    function printExtender($arr) {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }

    public function getTo($catUID) {
        $sql = "SELECT " . DB_PREFIX . "newsletter_old_system.uid FROM `" . DB_PREFIX . "newsletter_old_system` WHERE " . DB_PREFIX . "newsletter_old_system.cat_uid = " . $catUID;
        $query = $this -> db -> query($sql);
        return $query -> rows;
    }
	
	public function getMaxSend($catUID) {
        $sql = "SELECT COUNT(" . DB_PREFIX . "newsletter_old_system.email) FROM `" . DB_PREFIX . "newsletter_old_system` WHERE " . DB_PREFIX . "newsletter_old_system.cat_uid = " . $catUID;
        $query = $this -> db -> query($sql);
        return $query -> row;
    }

    public function insertLetter($from, $subject, $msg, $maxSend, $to) {
        $msg = htmlspecialchars($msg, ENT_QUOTES);
        $subject = htmlspecialchars($subject, ENT_QUOTES);
        
        $sqlInsertMessage = "INSERT INTO `" . DB_PREFIX . "newsletter_letter` (`from`, `subject`, `content`, `max_send`, `created`, `already_send`) VALUES ('" . $from . "', '" . $subject . "', '" . $msg . "', '" . $maxSend . "', NOW(), '0')";
        $this -> db -> query($sqlInsertMessage);
        $msgId = $this -> db -> getLastId();
        
		$maxCounter = 0;
        foreach ($to as $key => $value) {
            $sql = "INSERT INTO `" . DB_PREFIX . "newsletter_queue` (`user_uid`, `newsletter_uid`) VALUES ('" . $value['uid'] . "', '" . $msgId . "')";
            $this -> db -> query($sql);
			$maxCounter++;
        }
		
		$update = "UPDATE `" . DB_PREFIX . "newsletter_letter` SET  `max_send` = " . $maxCounter . " WHERE  `" . DB_PREFIX . "newsletter_letter`.`uid` = " . $msgId;
		$this -> db -> query($update);
    }

    public function getFromEmail($storeId) {
        $sql = "SELECT " . DB_PREFIX . "setting.`value` FROM `" . DB_PREFIX . "setting` WHERE " . DB_PREFIX . "setting.`key` = 'config_email' AND " . DB_PREFIX . "setting.store_id = " . $storeId;
        $query = $this -> db -> query($sql);
        return $query -> row;
    }
}
