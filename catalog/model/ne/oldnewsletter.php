<?php

class Modelneoldnewsletter extends Model {

	public function removeFromList($email, $catUID){
		$query = "DELETE FROM `oc_newsletter_old_system` WHERE (`email`='$email' AND `cat_uid` = '$catUID')";
		$this->db->query($query);
		return true;
	}
}

?>