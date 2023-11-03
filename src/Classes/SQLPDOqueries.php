<?php
// склад запросов к mysql для более легкого изменения
class SQLPDOqueries
{
  public $DBH;


  public function __construct()
  {

    // подключение к базе mysql
    // данные доступа к sql
    $sqlhost="localhost";
    $sqllogin="root";
    $sqlpass="root";
    $sqldbase="systemeio";


     try
      {
      # MySQL через PDO_MYSQL
      $this->DBH = new PDO("mysql:host=$sqlhost;dbname=$sqldbase", $sqllogin, $sqlpass);
      $this->DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
      $this->DBH->exec("set names utf8");
      }
    catch(PDOException $e)
      {
          die($e->getMessage());

      }


  }


  ////////////
  // azenv
  ////////////
  public function sql_tax_select1($countryCode)
  {
   // выбираем из функции query_warehouse запрос одноименный вызыаемой  функции и отправляем с параметрами на выполнение в фугкцию execute
   return $this->execute($this->query_warehouse(__FUNCTION__ ),
       array(
           'Code' => $countryCode
           )
   );
  }


    // склад запросов
    private function query_warehouse(string $req, $append = array())
  {

    switch ($req)
    {

        ////////////
        // Tax
        ////////////
        case "sql_tax_select1": $s = "SELECT * FROM tax WHERE Code=:Code "; break;


         default : // обработка ошибки
             die("неверный запрос $req ");
    }
   return $s;
  }

    // функция исполнения запроса
    private function execute(string $query, array $data=[])
 {


     try
     {
      $all=[];

      $STH = $this->DBH->prepare($query);
      $STH->execute($data);

      # устанавливаем ассоциативный режим выборки
      $STH->setFetchMode(PDO::FETCH_ASSOC);
      while($res=$STH->fetch()) array_push($all,$res);
      return $all;
     }
    catch(PDOException $e)
    {
    die($e->getMessage()." запрос :$query ");
    }
 }


}


