<?php
require_once "Classes/CurlClass.php";

$url = "http://127.0.0.1/src/calculate-price.php";
$content = array(
    "product"   => 1,
    "taxNumber" => "FRAA345678900",
    "couponCode"=> "D15");

$curl= new CurlClass();
$price = $curl->jsonPost($url,$content);
echo $price["Price"];
die;