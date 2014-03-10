<?php

class ModelToolExportCustomers extends Model {

	public function export() {

		$output = '';

		$fp = fopen('php://temp', 'r+');

		fputs($fp, $bom = ( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

		$query = "
			SELECT
			c.customer_id AS `Customer ID`,
			c.firstname AS `First Name`,
			c.lastname AS `Last Name`,
			CONCAT(c.firstname, ' ', c.lastname) AS `Full Name`,
			c.email AS `Email`,
			c.telephone AS `Telephone`,
			c.fax AS `Fax`,
			a.company AS `Company`,
			a.address_1 AS `Address 1`,
			a.address_2 AS `Address 2`,
			a.city AS `City`,
			z.name AS `County`,
			a.postcode AS `Postcode`,
			co.name AS `Country`,";

		if (VERSION >= "1.5.3") {
			$query .= "cgd.name AS `Customer Group`,";
		} else {
			$query .= "cg.name AS `Customer Group`,";
		}

		$query .= "
			s.name AS `Store`,
			c.newsletter AS `Newsletter`,
			c.status AS `Status`,
			c.approved AS `Approved`
			FROM " . DB_PREFIX . "customer c
			LEFT JOIN " . DB_PREFIX . "customer_group cg ON  cg.customer_group_id = c.customer_group_id";

		if (VERSION >= "1.5.3") {
			$query .= "	LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON cgd.customer_group_id = c.customer_group_id AND cgd.language_id = " . (int)$this->config->get('config_language_id');
		}

		$query .= "
			LEFT JOIN " . DB_PREFIX . "store s ON s.store_id = c.store_id
			LEFT JOIN " . DB_PREFIX . "address a ON a.address_id = c.address_id
			LEFT JOIN " . DB_PREFIX . "zone z ON z.zone_id = a.zone_id
			LEFT JOIN " . DB_PREFIX . "country co ON co.country_id = a.country_id";

		$results = $this->db->query($query);

		$row = $results->row;

		fputcsv($fp, array_keys($row));

		rewind($fp);

		$output .= fgets($fp);

		$default_store = $this->config->get('config_name');

		foreach ($results->rows as $result) {

			if (is_null($result['Store'])) {
				$result['Store'] = $default_store;
			}

			rewind($fp);
			fputcsv($fp, $result);
			rewind($fp);
			$output .= fgets($fp);
		}

		return $output;
	}

}

?>