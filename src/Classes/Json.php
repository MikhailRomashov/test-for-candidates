<?php


class Json
{
    public function json_processing($json)
    {
        $array = json_decode($json, true);

        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                header("HTTP/1.0 200 OK");
                return $array;

            case JSON_ERROR_DEPTH:
                $message =  'Достигнута максимальная глубина стека';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $message =  'Некорректные разряды или несоответствие режимов';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $message =  'Некорректный управляющий символ';
                break;
            case JSON_ERROR_SYNTAX:
                $message =  'Синтаксическая ошибка, некорректный JSON';
                break;
            case JSON_ERROR_UTF8:
                $message =  'Некорректные символы UTF-8, возможно неверно закодирован';
                break;
            default:
                $message =  'Неизвестная ошибка';
                break;
        }


        header("HTTP/1.0 400 BAD_REQUEST");
        echo "
        {   'Status':'Error',
            'Error':"   .$json["message"].",
            'Json' : "  .$json["json"]."
        }
        ";
        die;
        


    }

}