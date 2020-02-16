<?php


namespace app\Models;


class Error
{
    private $error;
    public function __construct($error)
    {
        $this->error = $error;
    }
    function writeError(){
        $file = fopen("app/data/errors.txt", "a");

        $string = basename($_SERVER['REQUEST_URI']) . "\t" . date("d.m.Y H:i:s") . "\t" . $_SERVER['REMOTE_ADDR']  . "\t" . $this->error . "\n";

        fwrite($file, $string);
        fclose($file);

    }
}