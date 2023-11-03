<?php
error_reporting(E_ERROR | E_PARSE);

require_once __DIR__."/../vendor/autoload.php";
require_once "Classes/ErrorClass.php";
$ErrLog    = new ErrorClass();

require_once "Classes/Products.php";
require_once "Classes/HTTPanswer.php";
require_once "PaymentProcessor/StripePaymentProcessor.php";

// считаем цену
$http     = new HTTPanswer();
$products = new Products();

$good=$products->Calculate(file_get_contents("php://input"));


if($good["error"]) $http->Bad($good);

// оформляем покупку
$spp = new  StripePaymentProcessor();
$spp->processPayment($good["Price"]);

// вернуть ответ
$http->OK(["Status" =>"Product purchased"]);