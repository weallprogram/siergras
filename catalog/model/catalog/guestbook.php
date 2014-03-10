<?php
class ModelCatalogGuestbook extends Model {		
	public function addReview($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "guestbook SET name = '" . $this->db->escape($data['name']) . "', customer_id = '" . (int)$this->customer->getId() . "', text = '" . $this->db->escape($data['enquiry']) . "', date_added = NOW(), status=0");
	}
		
	public function getReviews($start = 0, $limit = 20) {
		$query = $this->db->query("SELECT * from " . DB_PREFIX . "guestbook WHERE status = '1' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
		
		return $query->rows;
	}
	

	public function getTotalReviews() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "guestbook WHERE status = '1' ");
		
		return $query->row['total'];
	}
}
?>