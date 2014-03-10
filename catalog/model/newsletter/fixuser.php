<?php

class ModelNewsletterFixuser extends Model {

	public function fixIt(){
		$getQuery = "SELECT oc_customer.customer_id, oc_customer.email FROM `oc_customer`";
		$result = $this -> db -> query($getQuery);
		$resultSet = $result -> rows;
		
		foreach($resultSet as $key => $item){
			$password = $this -> randomPassword();
			$salt = substr(md5(uniqid(rand(), true)), 0, 9);
			$passDb = sha1($salt . sha1($salt . sha1($password)));
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET salt = '" . $this->db->escape($salt) . "', password = '" . $this->db->escape($passDb) . "' WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($item['email'])) . "'");
			$leEmail = $item["email"];
			
			$leMSG = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Uw nieuwe aanmeld gegevens voor Kadobos.nl</title></head>' . PHP_EOL;
			$leMSG .= '<body><p>Beste klant van Kadobos.nl,</p>' . PHP_EOL;
			$leMSG .= '<p>Kadobos.nl is overgegaan naar een nieuw systeem en uw account is mee verhuisd. Helaas konden we niet uw oude wachtwoord gebruiken, aangezien die beveiligd was opgeslagen. Daarom waren wij genoodzaakt om uw wachtwoord te resetten.</p>' . PHP_EOL;
			$leMSG .= '<p>Uw nieuwe gegevens zijn:<br />Email: ' . $leEmail . '<br />Wachtwoord: ' . $password . '</p>' . PHP_EOL;
			$leMSG .= '<p>U kunt uw gegevens <a href="http://wwww.kadobos.nl/index.php?route=account/account"> hier </a> na lopen en desnoods veranderen.</p>' . PHP_EOL;
			$leMSG .= '<p>Mochten er nog vragen / opmerkingen zijn, dan horen wij dat graag.</p>' . PHP_EOL;
			$leMSG .= '<p>Met Vriendelijke Groet,<br />Webbeheer Kadobos.nl</p></body></html>' . PHP_EOL;
			$this -> mailer($leMSG, $item['email'], $item['customer_id']);
		}
	}
	
	function mailer($msg, $to, $id){
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		// $headers .= 'To: marcmeesters@telfort.nl\r\n';
		$headers .= 'From: Webmaster Kadobos.nl <webmaster@kadobos.nl>';
		
		if(mail($to, 'Uw nieuwe aanmeld gegevens voor Kadobos.nl', $msg, $headers)){
			return TRUE;
		}
		else{
			echo "<br />ERROR @id_" . $id;
		}
	}
	
	function randomPassword() {
		$alphabet = "abcdefghijklmnopqrstuwxyz_ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 10; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}
}