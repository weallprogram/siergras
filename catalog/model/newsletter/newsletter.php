<?php

class ModelNewsletterNewsletter extends Model {

	public function getEmails($amount){
		$getQuery = "SELECT queue.uid, queue.user_uid, queue.newsletter_uid FROM  `" . DB_PREFIX . "newsletter_queue` as queue, `" . DB_PREFIX . "newsletter_letter` as letter WHERE letter.paused = 0 AND queue.newsletter_uid = letter.uid LIMIT 0, " . $amount;
		$result = $this -> db -> query($getQuery);
		return $result -> rows;
	}
	
	public function getUserInfo($uid){
		$getQuery = "SELECT `email` FROM  `" . DB_PREFIX . "newsletter_old_system` WHERE `uid` = " . $uid;
		$result = $this -> db -> query($getQuery);
		return $result -> row;
	}
	
	public function getLetterInfo($uid){
		$getQuery = "SELECT `from`, `subject`, `content` FROM  `" . DB_PREFIX . "newsletter_letter` WHERE `uid` = " . $uid;
		$result = $this -> db -> query($getQuery);
		return $result -> row;
	}
	
	public function sendHTMLemail($message, $from, $to, $subject, $letter_uid, $uid, $user_uid) {
		// To send HTML mail, the Content-type header must be set
		// $message = str_replace(chr(128), "&euro;", $message);
		
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

		// Additional headers
		$headers .= 'To: ' . $to . "\r\n";
		$headers .= 'From: ' . $from . "\r\n";

		// Mail it
		if(mail($to, $subject, $message, $headers)){
			return TRUE;
		}
		else{
			$this -> errorHTMLemail($uid, $letter_uid, $user_uid);
		}
		return FALSE;
	}
	
	public function errorHTMLemail($uid, $letter_uid, $user_uid){
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		$headers .= 'To: ' . "info@gospel7.com" . "\r\n";
		$headers .= 'From: ' . "webmaster@newsletter.gospel7.com" . "\r\n";
		
		$message = '<html dir="ltr" lang="en">' . PHP_EOL;
		$message .= '<head>' . PHP_EOL;
		$message .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . PHP_EOL;
		$message .= '<title>' . "Er is een fout opgetreden tijdens het verwerken van de nieuwsbrief wachtrij" . '</title>' . PHP_EOL;
		$message .= '</head>' . PHP_EOL;
		$message .= '<body style="padding:0;margin:0;">' . "<h1>Er is een fout opgetreden tijdens het verwerken van de nieuwsbrief wachtrij</h1><p>Tijdens het verwerken van de niewsbrief ( oude lijst ) is er een fout opgetreden.</p><p>De volgende gegevens zijn bekened:</p><p>Nieuwsbrief UID: " . $letter_uid . "<br />Gebuiker UID: " . $user_uid . "<br />Wachtrij UID: " . $uid . "</p></body>" . PHP_EOL;
		$message .= '</html>' . PHP_EOL;
		mail("info@gospel7.com", "Er is een fout opgetreden tijdens het verwerken van de nieuwsbrief wachtrij", $message, $headers);
	}
	
	public function letterDone($uid, $letterUID){
		$copyOrder = "INSERT INTO `" . DB_PREFIX . "newsletter_done` (" . DB_PREFIX . "newsletter_done.user_uid, " . DB_PREFIX . "newsletter_done.newsletter_uid) SELECT " . DB_PREFIX . "newsletter_queue.user_uid, " . DB_PREFIX . "newsletter_queue.newsletter_uid FROM `" . DB_PREFIX . "newsletter_queue`;";
        // $result = $this -> db -> query($copyOrder);
		
		$sql = "DELETE FROM `" . DB_PREFIX . "newsletter_queue` WHERE (`uid`='" . $uid . "')";
		$this -> db -> query($sql);
		
		$updateQuery = "UPDATE `" . DB_PREFIX . "newsletter_letter` SET `already_send` = `already_send` + 1, `last_send` = NOW() WHERE `uid` = " . $letterUID;
		$this -> db -> query($updateQuery);
	}
	
	public function unsubscribe($uid){
		$sql = "DELETE FROM `" . DB_PREFIX . "newsletter_old_system` WHERE (`uid`='" . $uid . "')";
		$this -> db -> query($sql);
	}
}
