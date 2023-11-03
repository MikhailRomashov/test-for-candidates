<?php
// склад запросов к mysql для более легкого изменения
class SQLPDOqueries
{
    public $DBH;


    public function __construct()
    {

        // подключение к базе mysql
        // данные доступа к sql

        $sqlhostlocal="localhost";
        $sqlhostdocker="sqlserver";
        $sqllogin="root";
        $sqlpass="root";
        $sqldbase="systemeio";


        try
        {
            try {
                # MySQL через PDO_MYSQL
                $this->DBH = new PDO("mysql:host=$sqlhostlocal;port=3306;dbname=$sqldbase", $sqllogin, $sqlpass);
                }
            catch(PDOException $e)
                {
                    $this->DBH = new PDO("mysql:host=$sqlhostdocker;port=3306;dbname=$sqldbase", $sqllogin, $sqlpass);
                }

            $this->DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $this->DBH->exec("set names utf8");
        }
        catch(PDOException $e)
        {
            die($e->getMessage());

        }


    }



    public function sql_tax_select1($countryCode)
    {
        // выбираем из функции query_warehouse запрос одноименный вызыаемой  функции и отправляем с параметрами на выполнение в фугкцию execute
        return $this->execute($this->query_warehouse(__FUNCTION__ ),
            array(
                'Code' => $countryCode
            )
        );
    }

    public function sql_goods_select1($product_id)
    {
        // выбираем из функции query_warehouse запрос одноименный вызыаемой  функции и отправляем с параметрами на выполнение в фугкцию execute
        return $this->execute($this->query_warehouse(__FUNCTION__ ),
            array(
                'product_id' =>$product_id
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

            ////////////
            // goods
            ////////////
            case "sql_goods_select1": $s = "SELECT * FROM goods WHERE id=:product_id "; break;


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


