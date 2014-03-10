<?php

class ModelModuleProdisc extends Model {
	public function printExtender($data) {
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}

	public function doit($pro_uid) {
		$this -> load -> model('catalog/product');

		$cartProductsTMP = $this -> model_catalog_product -> getProduct($pro_uid);
		$categoryDiscounts = $this -> config -> get("ultimate_discount_category");

		$cartProducts = array($cartProductsTMP['product_id'] => $cartProductsTMP);
		$categoryDiscount = 0;
		$totalDiscount = 0;

		if (is_array($categoryDiscounts) && count($categoryDiscounts) > 0) {
			// Go through and remove any discounts that aren't "in date".
			foreach ($categoryDiscounts as $key => $value) {
				if (($value["date_start"] != "" && date("Y-m-d") < $value["date_start"]) || ($value["date_end"] != "" && date("Y-m-d") > $value["date_end"])) {
					unset($categoryDiscounts[$key]);
				}
			}

			// If there's some left, carry on!
			if (count($categoryDiscounts) > 0) {
				foreach ($cartProducts as $pkey => $product) {
					foreach ($categoryDiscounts as $key => $catDisc) {
						// Query the database for the prod->cat link.
						$check_q = $this -> db -> query("SELECT * FROM `" . DB_PREFIX . "product_to_category` WHERE `product_id` = '" . $pro_uid . "' AND `category_id` = '" . $catDisc["category_id"] . "'");

						// Is it valid?
						if ($check_q -> num_rows > 0) {
							// Create the link!
							if (!array_key_exists("cat_links", $cartProducts[$pkey])) {
								$cartProducts[$pkey]["cat_links"] = array();
							}
							$cartProducts[$pkey]["cat_links"][] = $catDisc["category_id"];

							// Add the value of the stock, so we can work out if we qualify.
							if (!isset($categoryDiscounts[$key]["total_units"])) {
								$categoryDiscounts[$key]["total_units"] = $product["quantity"];
								$categoryDiscounts[$key]["total_purchased"] = $product["price"] * $product["quantity"];
								$categoryDiscounts[$key]["tax_class_id"] = $product["tax_class_id"];
							} else {
								$categoryDiscounts[$key]["total_units"] += $product["quantity"];
								$categoryDiscounts[$key]["total_purchased"] += $product["price"] * $product["quantity"];
								$categoryDiscounts[$key]["tax_class_id"] = $product["tax_class_id"];
							}
						}
					}
				}

				// Now go through and see if we qualify for the discount in these categories.
				foreach ($categoryDiscounts as $value) {
					if (!isset($value["total_purchased"]) || $value["total_purchased"] < $value["total"]) {
						continue;
					}

					// If this customer's group doesn't match the discount one, skip.
					if ($this -> customer -> getCustomerGroupId() != $value["customer_group_id"] && $value["customer_group_id"] != 'a') {
						continue;
					}

					// Since we're allowed it, set it!
					if ($value["type"] == "P") {
						$perc = $value["amount"] / 100;
						$_tmpDiscount = $value["total_purchased"] - ($value["total_purchased"] * (1 - $perc));
						$categoryDiscount += $_tmpDiscount;
					} else {
						$_tmpDiscount = $value["amount"];
						$categoryDiscount += $value["amount"];
					}
					$totalDiscount += $categoryDiscount;
					return $totalDiscount;
				}

			}

		}
	}

	public function doit_old($pro_uid) {
		$this -> load -> model('catalog/product');

		$storeDiscounts = $this -> config -> get("ultimate_discount_category");
		$product = $this -> model_catalog_product -> getProduct($pro_uid);

		$storeDiscount = 0;
		$sub_total = $product['price'];

		// Find the highest discount we're entitled to.
		$highestEntitled = -1;
		if (is_array($storeDiscounts)) {
			foreach ($storeDiscounts as $key => $value) {
				// Skip if not in date range.
				if (($value["date_start"] != "" && date("Y-m-d") < $value["date_start"]) || ($value["date_end"] != "" && date("Y-m-d") > $value["date_end"])) {
					continue;
				}

				// If this customer's group doesn't match the discount one, skip.
				if ($this -> customer -> getCustomerGroupId() != $value["customer_group_id"] && $value["customer_group_id"] != 'a') {
					continue;
				}

				// Now, is it the highest?
				if ($highestEntitled == -1 || $storeDiscount[$highestEntitled]["total"] < $value["total"]) {
					$highestEntitled = $key;
				}
			}
		}

		// Now apply the discount, if we have one.
		if ($highestEntitled > -1) {
			$storeDiscount = 0;
			// Add to the counter.
			if ($storeDiscounts[$highestEntitled]["type"] == "P") {
				$perc = $storeDiscounts[$highestEntitled]["amount"] / 100;
				$discount = ($sub_total - ($sub_total * (1 - $perc)));
				$storeDiscount += $discount;
			} elseif ($storeDiscount < 1) {
				$storeDiscount += $storeDiscounts[$highestEntitled]["amount"];
			}
		}

		// $this -> printExtender($storeDiscounts);
		// $this -> printExtender($product);
		// echo "StoreDiscount: " . $storeDiscount;

		return $storeDiscount;
	}

}
