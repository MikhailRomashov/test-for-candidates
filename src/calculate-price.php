<?php
require_once __DIR__."/classes/Json.php";

$json = new Json();
$json->json_processing(file_get_contents("php://input"));

