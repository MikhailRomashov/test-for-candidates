<?php

require_once __DIR__."/../vendor/autoload.php";
require_once "Classes/SQLPDOqueries.php";
require_once "Classes/HTTPanswer.php";
require_once "Classes/Json.php";
require_once "Classes/MyValidator.php";

$http    =   new HTTPanswer();
$json = new Json();

// преобразовать json в массив
$request=$json->json_processing(file_get_contents("php://input"));


// проверить наличие обязательных параметров
if(!$request["product"] || !$request["taxNumber"] ) $http->Bad(["error" =>"отсутствуют обязательные поля"]);

// вычленить код страны
$countryCode = mb_substr($request["taxNumber"],0, 2);

// запросить данные о длине налогового номера
$MySQL    =   new SQLPDOqueries();

// если такой страны нет вернуть ошибку
if(!$tax = $MySQL->sql_tax_select1($countryCode)) $http->Bad(["error" =>"Страна $countryCode не поддерживается"]);

// добавить параметры длины taxNumber для проверки
$param["taxNumberLength"]   = $tax[0]["taxNumberLength"];
$param["digitsLength"]      = $tax[0]["digitsLength"];

// проверить корректность данных
$val=new MyValidator();
if($err=$val->check($request,$param)) $http->Bad($err);

// получить из базы цену товара
if(!$good = $MySQL->sql_goods_select1($request["product"])) $http->Bad(["error" =>"Продукт по кодом ".$request["product"]." отсутствует"]);

// расчитать стоимость с налогом
$finalPrice=$good[0]["price"]*($tax[0]['Tax']+100)/100;

// не понял как расчитывать скидку. D15 это купон на скидку 15 % или это код купона по которому нжо искать в базе размер скидки?
// вернуть ответ
$http->OK(["Price" =>"$finalPrice"]);