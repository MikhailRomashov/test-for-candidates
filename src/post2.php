<?php
require_once "Classes/CurlClass.php";

$url = "http://127.0.0.1/src/purchase.php";

$content = array(
    "product"   => 1,
    "taxNumber" => "DE123456789",
    "couponCode"=> "D15",
    "paymentProcessor" => "paypal"
);

$curl= new CurlClass();
$price = $curl->jsonPost($url,$content);

echo $price["Status"];
die;