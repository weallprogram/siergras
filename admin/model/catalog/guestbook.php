<?php
class ModelCatalogGuestbook extends Model {
    
	public function addReview($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "guestbook SET name = '" . $this->db->escape($data['author']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', status = '" . (int)$data['status'] . "', date_added = NOW(), entry_reply='".$this->db->escape(strip_tags($data['reply']))."', date_reply = NOW()");
	}
	
	public function editReview($review_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "guestbook SET name = '" . $this->db->escape($data['author']) .  "', text = '" . $this->db->escape(strip_tags($data['text'])) ."', status = '" . (int)$data['status'] . "', date_modified = NOW(), entry_reply='".$this->db->escape(strip_tags($data['reply']))."', date_reply = NOW() WHERE entry_id = '" . (int)$review_id . "'");
	}
	
	public function deleteReview($review_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "guestbook WHERE entry_id = '" . (int)$review_id . "'");
	}
	
	public function getReview($review_id) {
		$query = $this->db->query("SELECT *  FROM " . DB_PREFIX . "guestbook r WHERE r.entry_id  = '" . (int)$review_id . "'");
		
		return $query->row;
	}

	public function getReviews($data = array()) {
		$sql = "SELECT r.entry_id, r.name, r.status, r.date_added FROM " . DB_PREFIX . "guestbook r ";  
		
		$sort_data = array(
			'r.entry_id',
			'r.name',
			'r.status',
			'r.date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY r.date_added";
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
																																							  
		$query = $this->db->query($sql);																																				
		
		return $query->rows;	
	}
	
	public function getTotalEntries() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "guestbook");
		
		return $query->row['total'];
	}
	
	public function getTotalEntriesAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "guestbook WHERE status = '0'");
		
		return $query->row['total'];
	}	
}
?>