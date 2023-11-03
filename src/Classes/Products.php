<?php
require_once "MyValidator.php";
require_once "SQLPDOqueries.php";
require_once "Json.php";


class Products
{
    public function Calculate($jsonString)
    {
       
        $json = new Json();

        // анализируем переданный json на ошибка и преобразуем в массив
        $request=$json->json_processing($jsonString);

        // считаем цену и возвращаем
        return $this->GetPrice($request);
    }
    
    public function GetPrice($request)
    {

        // проверить наличие обязательных параметров
        if(!$request["product"] || !$request["taxNumber"] ) return array("error" =>"отсутствуют обязательные поля");

        // вычленить код страны
        $countryCode = mb_substr($request["taxNumber"],0, 2);

        // запросить данные о длине налогового номера
        $MySQL    =   new SQLPDOqueries();

        // если такой страны нет вернуть ошибку
        if(!$tax = $MySQL->sql_tax_select1($countryCode)) return array("error" =>"Страна $countryCode не поддерживается");

        // добавить параметры длины taxNumber для проверки
        $param["taxNumberLength"]   = $tax[0]["taxNumberLength"];
        $param["digitsLength"]      = $tax[0]["digitsLength"];

        // проверить корректность данных
        $val=new MyValidator();
        if($err=$val->check($request,$param)) return $err;

        // получить из базы цену товара
        if(!$good = $MySQL->sql_goods_select1($request["product"])) return array("error" =>"Продукт по кодом ".$request["product"]." отсутствует");

        // расчитать стоимость с налогом
        $finalPrice=$good[0]["price"]*($tax[0]['Tax']+100)/100;
        
        // не понял как расчитывать скидку. D15 это купон на скидку 15 % или это код купона по которому нжо искать в базе размер скидки?
        return array("Price" => $finalPrice);
    }
}