<?php


class ErrorClass
{
    public function __construct()
    {
      register_shutdown_function(array($this, 'ShutDown'));

    }



// обработчик ошибок
    function ShutDown()
    {
        $code = array(1,4,16,64,256,4096);
        if(in_array(@error_get_last()['type'],$code)) $this->SaveToFile(@error_get_last());
    }


    private function SaveToFile($mess,$LogFilePref="FatalError")
    {
        $from_file= ucfirst(pathinfo($mess["file"], PATHINFO_FILENAME));

        file_put_contents(
            "$LogFilePref$from_file.txt",
            date("d.m.Y H:i:s")."\r\n".
            var_export($mess,true)
            ."\r\n================================\r\n",
            FILE_APPEND | LOCK_EX);
    }
}

