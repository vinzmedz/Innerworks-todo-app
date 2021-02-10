<?php

class logger
{
    public $filepath;

    public function __construct($file = "")
    {
        // if ($file != "") {
            //"../inc/logs/debug_logs.php"
            $this->filepath = $file;

        // }
    }

    public function error($msg)
    {
        if (!empty($msg))
        {
            $_err = $msg;
            if (is_array($msg)) $_err = implode("\n", $msg);
            
            file_put_contents("$this->filepath", $_err . "\n", FILE_APPEND | LOCK_EX);
            return true;
        }

        return true;
    }
}