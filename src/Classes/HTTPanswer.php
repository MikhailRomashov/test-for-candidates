<?php

class HTTPanswer
{
    public function OK($answ)
    {
        header("HTTP/1.0 200 OK");
        $this->answer($answ);
    }

    public function Bad($answ)
    {
        header("HTTP/1.0 400 BAD_REQUEST");
        $this->answer($answ);
    }

    public function answer($answ)
    {
        echo json_encode($answ);
        die;
    }
}