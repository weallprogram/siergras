<?php
class ModelModuleSlider extends Model {
    public function getProducts(){
        $sql = "SELECT " . DB_PREFIX . "product.product_id, " . DB_PREFIX . "product.image, " . DB_PREFIX . "product_description.`name` FROM " . DB_PREFIX . "product , " . DB_PREFIX . "product_description WHERE " . DB_PREFIX . "product.product_id = " . DB_PREFIX . "product_description.product_id Order By rand() LIMIT 0, 10";
        $result = $this -> db -> query($sql);
        return $result -> rows;
    }
}
    