<?php


namespace Applab\Sadad\Requests;

class WCORequest {
    public $order_id;
    public $total_amount;
    public $customer_id;
    public $customer_mobile;
    public $customer_email;
    public $callback_url;
    public $products=[];

    public function __construct() {
    }
    public function getOrderId()
    {
        return $this->random_string();
    }
    public function setProducts($products){
        $productDetails=[];
         foreach($products as $product) {
             $productD['order_id'] = $product['id']??rand(1,100);
             $productD['itemname'] = isset($product['title'])?utf8_encode($product['title']):'item';
             $productD['amount'] = $product['amount']??1;
             $productD['quantity'] = $product['quantity']??1;
             $productD['type'] = isset($product['type'])?utf8_encode($product['type']):'product';
             $productDetails[]=$productD;
        }
        $this->products=$productDetails;
    }
    //creating merchant ref (unique
    private function random_string($prefix='AS')
    {
        $key = uniqid($prefix, true);
        $key = str_replace('.', '', $key);
        return $key;
    }
}
