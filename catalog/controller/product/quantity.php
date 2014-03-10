<?php  
header('Access-Control-Allow-Origin: *');  
class ControllerProductQuantity extends Controller {

	public function index(){
		if(!isset($this -> request -> get['p']) || !isset($this -> request -> get['q'])){
			return;
		}

		$this->load->model('catalog/product');	
		$product_info = $this -> model_catalog_product -> getProduct($this -> request -> get['p']);
		$pro_quantity = $product_info['quantity'];
		$order_quantity = $this -> request -> get['q'];
		
		$difrnce = $pro_quantity - $order_quantity;
		if($difrnce >= 0){
			echo "ok";
		}else{
			echo $pro_quantity;
		}

	}
}