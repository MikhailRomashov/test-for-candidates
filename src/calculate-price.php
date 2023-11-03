<?php
require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/classes/Json.php";
require_once __DIR__."/classes/MyValidator.php";


$json = new Json();
$json->json_processing(file_get_contents("php://input"));

$val=new MyValidator();
$val->check("!");