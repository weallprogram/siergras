<?php

/**
 * Ultimate Discount extension for Opencart.
 *
 * @author Anthony Lawrence <freelancer@anthonylawrence.me.uk>
 * @version 1.0
 * @copyright © Anthony Lawrence 2011
 * @license Creative Common's ShareAlike License - http://creativecommons.org/licenses/by-sa/3.0/
 */


class ModelTotalUltimateDiscount extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
            // Load extra files.
            $this->load->language('total/ultimate_discount');
            $this->load->model('catalog/category');
            
            // Default variables
            $sub_total = $total;
            $running_total = $sub_total;
            $totalDiscount = 0;
            $storeDiscount = 0;
            $categoryDiscount = 0;
                    $taxClasses = array();
            $cartProducts = $this->cart->getProducts();
            
            // Check we actualy have a total!
            if($this->cart->getSubTotal()){
                // Now, load the store discounts
                $storeDiscounts = $this->config->get("ultimate_discount_store");
                
                // Find the highest discount we're entitled to.
                $highestEntitled = -1;
                if(is_array($storeDiscounts)){
                    foreach($storeDiscounts as $key => $value){
                        // Skip if not in date range.
                        if(($value["date_start"] != "" && date("Y-m-d") < $value["date_start"]) || ($value["date_end"] != "" && date("Y-m-d") > $value["date_end"])){
                            continue;
                        }
                        
                        // Skip if not above total.
                        if($sub_total < $value["total"]){
                            continue;
                        }
                        
                        // If this customer's group doesn't match the discount one, skip.
                        if($this->customer->getCustomerGroupId() != $value["customer_group_id"] && $value["customer_group_id"] != 'a'){
                            continue;
                        }
                        
                        // Now, is it the highest?
                        if($highestEntitled == -1 || $storeDiscount[$highestEntitled]["total"] < $value["total"]){
                            $highestEntitled = $key;
                        }
                    }
                }
                
                // Now apply the discount, if we have one.
                if($highestEntitled > -1){
                    $storeDiscount = 0;
                    // Add to the counter.
                    if($storeDiscounts[$highestEntitled]["type"] == "P"){
                        $perc = $storeDiscounts[$highestEntitled]["amount"]/100;
                        $discount = ($sub_total-($sub_total*(1-$perc)));
                        $storeDiscount+= $discount;
                    } elseif($storeDiscount < 1) {
                        $storeDiscount+= $storeDiscounts[$highestEntitled]["amount"];
                    }
                    
                    // Now, we'll apply it on a per-product basis so that we can take the tax into account too!
                    $_accum = 0;
                    $_total = $storeDiscount;
                    $_splits = $storeDiscount / $this->cart->countProducts();
                    foreach($cartProducts as $id => $product){
                        // Let's reduce the price of this, based on the discount too!
                        // For percentage based discounts, we can just take off the discount amount from the product price.
                        if($storeDiscounts[$highestEntitled]["type"] == "P"){
                            $perc = $storeDiscounts[$highestEntitled]["amount"]/100;
                            $discount = ($product["price"]-($product["price"]*(1-$perc)));
                            $cartProducts[$id]["total"] -= $discount;
                        } elseif($storeDiscounts[$highestEntitled]["type"] == "F") {
                            // For fixed discounts, we need to deduct the amount of discount based on the number of products.
                            $cartProducts[$id]["total"] -= $_splits * $product["quantity"];
                            $_accum+= $_splits * $product["quantity"];
                        }
                    }
                    if($storeDiscounts[$highestEntitled]["type"] == "F"){
                        $cartProducts[$id]["total"] -= ($_total-$_accum);
                    }
                                                
                    // Now add it!
                    if($storeDiscount > 0){
                        // Add to the text list.
                        $totalDiscount += $storeDiscount;
			$total_data[] = array(
                            'code'       => 'ultimate_discount',
                            'title'      => $this->language->get('text_ultimate_discount_general'),
                            'text'       => $this->currency->format(-$storeDiscount),
                            'value'      => -$storeDiscount,
                            'sort_order' => $this->config->get('ultimate_discount_sort_order')
			);
                    }
                }
                
                // Category discounts
                $categoryDiscounts = $this->config->get("ultimate_discount_category");
                if(is_array($categoryDiscounts) && count($categoryDiscounts) > 0){
                    // Go through and remove any discounts that aren't "in date".
                    foreach($categoryDiscounts as $key => $value){
                        if(($value["date_start"] != "" && date("Y-m-d") < $value["date_start"]) || ($value["date_end"] != "" && date("Y-m-d") > $value["date_end"])){
                            unset($categoryDiscounts[$key]);
                        }
                    }
                    
                    // If there's some left, carry on!
                    if(count($categoryDiscounts) > 0){
                        // Go through cart products and find the total per category.
                        foreach($cartProducts as $pkey => $product){
                            foreach($categoryDiscounts as $key => $catDisc){
                                // Query the database for the prod->cat link.
                                $check_q = $this->db->query("SELECT * FROM `".DB_PREFIX."product_to_category`
                                                            WHERE `product_id` = '".$product["product_id"]."'
                                                                AND `category_id` = '".$catDisc["category_id"]."'");
                                
                                // Is it valid?
                                if($check_q->num_rows > 0){
                                    // Create the link!
                                    if(!array_key_exists("cat_links", $cartProducts[$pkey])){
                                        $cartProducts[$pkey]["cat_links"] = array();
                                    }
                                    $cartProducts[$pkey]["cat_links"][] = $catDisc["category_id"];
                                    
                                    // Add the value of the stock, so we can work out if we qualify.
                                    if(!isset($categoryDiscounts[$key]["total_units"])){
                                        $categoryDiscounts[$key]["total_units"] = $product["quantity"];
                                        $categoryDiscounts[$key]["total_purchased"] = $product["price"] * $product["quantity"];
                                        $categoryDiscounts[$key]["tax_class_id"] = $product["tax_class_id"];
                                    } else {
                                        $categoryDiscounts[$key]["total_units"]+= $product["quantity"];
                                        $categoryDiscounts[$key]["total_purchased"]+= $product["price"] * $product["quantity"];
                                        $categoryDiscounts[$key]["tax_class_id"] = $product["tax_class_id"];
                                    }
                                }
                            }
                        }
                        
                        // Now go through and see if we qualify for the discount in these categories.
                        foreach($categoryDiscounts as $value){
                            if(!isset($value["total_purchased"]) || $value["total_purchased"] < $value["total"]){
                                continue;
                            }
                                                    
                            // If this customer's group doesn't match the discount one, skip.
                            if($this->customer->getCustomerGroupId() != $value["customer_group_id"] && $value["customer_group_id"] != 'a'){
                                continue;
                            }
                                
                            // Since we're allowed it, set it!
                            if($value["type"] == "P"){
                                $perc = $value["amount"]/100;
                                $_tmpDiscount = $value["total_purchased"]-($value["total_purchased"]*(1-$perc));
                                $categoryDiscount+= $_tmpDiscount;
                            } else {
                                $_tmpDiscount = $value["amount"];
                                $categoryDiscount+= $value["amount"];
                            }
                            $totalDiscount+= $categoryDiscount;
                            
                            // NOW, we need to go through the products in this category, and subtract the necessary amount from the price so taxes can be recalculated.
                            $splits = $_tmpDiscount / $value["total_units"];
                            $_accum = 0;
                            foreach($cartProducts as $pId => $product){
                                // Now, modify the product price based on the discount given.
                                if(array_key_exists("cat_links", $product) && in_array($value["category_id"], $product["cat_links"])){
                                    $cartProducts[$pId]["total"] -= $splits * $product["quantity"];
                                    $_accum+= $splits * $product["quantity"];
                                }
                            }
                            $cartProducts[$pId]["total"] -= ($_tmpDiscount - $_accum);
                            
                            // Get the name of the category
                            $catInfo = $this->model_catalog_category->getCategory($value["category_id"]);
                            $value["cat_name"] = $catInfo["name"];

                            // Add to the text list.
                            $total_data[] = array(
                                'code'       => 'ultimate_discount',
                                'title'      => sprintf($this->language->get('text_ultimate_discount_category'), $value["cat_name"]),
                                'text'       => $this->currency->format(-$categoryDiscount),
                                'value'      => -$categoryDiscount,
                                'sort_order' => $this->config->get('ultimate_discount_sort_order')
                            );
                        }
                    }
                }
                
                // Multi-buy discounts
                $usedCategories = array();
                $multiDiscounts = $this->config->get("ultimate_discount_multi");
                if(is_array($multiDiscounts) && count($multiDiscounts) > 0){
                    foreach($multiDiscounts as $mdKey => $discount){
                        if(!isset($discount["date_start"], $discount["date_end"], $discount["customer_group_id"], $discount["category_id"], $discount["rule_amount"], $discount["rule"])){
                            continue;
                        }
                        
                        // Is this discount in date?
                        if(($discount["date_start"] != "" && date("Y-m-d") < $discount["date_start"]) || ($discount["date_end"] != "" && date("Y-m-d") > $discount["date_end"])){
                            continue;
                        }
                        
                        // If this customer's group doesn't match the discount one, skip.
                        if($this->customer->getCustomerGroupId() != $discount["customer_group_id"] && $discount["customer_group_id"] != 'a'){
                            continue;
                        }
                        
                        // Has this category been used? Do we ignore repeat categories?
                        if($this->config->get("ultimate_discount_multi_override") == "1" && in_array($discount["category_id"], $usedCategories)){
                            continue;
                        }
                        
                        // We need to go through each of the products in the cart.
                        // If they're in this category, increase the total for this category.
                        $prods = false;
                        foreach($cartProducts as $pKey => $product){
                            // Query the database for the prod->cat link.
                            $check_q = $this->db->query("SELECT * FROM `".DB_PREFIX."product_to_category`
                                                        WHERE `product_id` = '".$product["product_id"]."'
                                                            AND `category_id` = '".$discount["category_id"]."'");

                            // Is it valid? If not, skip.
                            if($check_q->num_rows < 1){
                                continue;
                            }
                            $prods = true;
                            
                            // Create the link as they're in the category!
                            if(!array_key_exists("cat_links", $cartProducts[$pKey])){
                                $cartProducts[$pKey]["cat_links"] = array();
                            }
                            $cartProducts[$pKey]["cat_links"][] = $discount["category_id"];
                            
                            // Now, increase the total!
                            if(array_key_exists("total_units", $multiDiscounts[$mdKey])){
                                $multiDiscounts[$mdKey]["total_units"]+= $product["quantity"];
                                $multiDiscounts[$mdKey]["total_amount"]+= $product["quantity"]*$product["price"];
                            } else {
                                $multiDiscounts[$mdKey]["total_units"] = $product["quantity"];
                                $multiDiscounts[$mdKey]["total_amount"] = $product["quantity"]*$product["price"];
                            }
                        }
                        if(!$prods){ continue; }
                        
                        // Have we met the minimum?  If not, forget it!
                        if($discount["rule_amount"] > $multiDiscounts[$mdKey]["total_units"]){
                            continue;
                        }
                        
                        // We've now got a total for this category.
                        // Let's work out the multiples, if we have one set.
                        if($discount["rule"] == "E"){
                            $multiples = floor($multiDiscounts[$mdKey]["total_units"] / $discount["rule_amount"]);
                        } else {
                            $multiples = 1;
                        }
                        
                        // Is it fixed price or percentage?
                        if(preg_match("/(\d+(\.\d+)?)\%/i", $discount["amount"], $matches)){
                            $perc = $matches[1];
                            $mdDiscount = ($multiDiscounts[$mdKey]["total_amount"]/100) * $perc;
                        } else {
                            $mdDiscount = ($discount["amount"]*$multiples);
                        }
                        
                        if($mdDiscount <= 0){
                            continue;
                        }
                        $totalDiscount+= $mdDiscount;
                        
                        // Now, modify the products in this category to fix the tax issues.
                        $usedCategories[] = $discount["category_id"];
                        $splits = $mdDiscount / $multiDiscounts[$mdKey]["total_units"];
                        $_accum = 0;
                        foreach($cartProducts as $pId => $product){
                            // Now, modify the product price based on the discount given.
                            if(array_key_exists("cat_links", $product) && in_array($discount["category_id"], $product["cat_links"])){
                                $cartProducts[$pId]["total"] -= $splits * $product["quantity"];
                                $_accum+= $splits * $product["quantity"];
                            }
                        }
                        $cartProducts[$pId]["total"] -= ($mdDiscount-$_accum);
                        
                        // Now we can add the discount.
                        $catInfo = $this->model_catalog_category->getCategory($discount["category_id"]);
                        $total_data[] = array(
                            'code'       => 'ultimate_discount',
                            'title'      => sprintf($this->language->get('text_ultimate_discount_multi'), $catInfo["name"]),
                            'text'       => $this->currency->format(-$mdDiscount),
                            'value'      => -$mdDiscount,
                            'sort_order' => $this->config->get('ultimate_discount_sort_order')
                        );
                    }
                }
            }
            
            
            // FInally, modify all the taxes to take account of the above changes to them!
            // One final sweep of products, to accure tax amounts.
            foreach($cartProducts as $product){
                if(array_key_exists($product["tax_class_id"], $taxClasses)){
                    $taxClasses[$product["tax_class_id"]] += $product["total"];
                } else {
                    $taxClasses[$product["tax_class_id"]] = $product["total"];
                }
            }

            
            // Add taxes
            foreach($taxClasses as $key => $value){
                foreach($this->tax->getRates($value, $key) as $tax_rate){
                    $taxes[$tax_rate["tax_rate_id"]] = $tax_rate["amount"];
                }
            }
            
            $total-= $totalDiscount;
	}
}
?>
