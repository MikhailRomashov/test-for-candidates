<?php
error_reporting(E_ERROR | E_PARSE);

require_once __DIR__."/../vendor/autoload.php";
require_once "Classes/ErrorClass.php";
$ErrLog    = new ErrorClass();

require_once "Classes/Products.php";
require_once "Classes/HTTPanswer.php";

// считаем цену
$http     = new HTTPanswer();
$products = new Products();
$good=$products->Calculate(file_get_contents("php://input"));

if($good["error"]) $http->Bad($good);


// вернуть ответ
$http->OK(["Price" =>$good["Price"]]);