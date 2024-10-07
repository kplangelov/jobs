<?php

class FileController
{

    public function fModelMethodError($sql, $eMessage)
    {
        $folder = 'logs';
        $fn = 'log_method_errors_' . date("Ymd") . '.txt';
        $fullPath = $folder . DIRECTORY_SEPARATOR . $fn;
        $file = fopen($fullPath, "a");
        if ($fullPath) {
            $newline = "\n";
            $when = date('Y/m/d h:i:s');
            $ip = $_SERVER['REMOTE_ADDR'];
            $msg = '[' . $when . ']'.$newline . 'IP Execution adress: ' . $ip . $newline .' SQL Query: ' . $sql . $newline.$newline;
            $msg = $msg . " Error message: " . $eMessage . $newline;
            fwrite($file, $msg);
            fclose($file);
        }
    }

    public function logLogin($mail)
    {
        $folder = 'logs';
        $fn = $folder . DIRECTORY_SEPARATOR . 'logLogin_' . date("Ymd") . '.txt';
        $file = fopen($fn, "a");

        if ($file) {
            $when = date('Y/m/d h:i:s');
            $ip = $_SERVER['REMOTE_ADDR'];
            $msg = $when . " Mail:" . $mail . " trying to login from ip: $ip \n";
            fwrite($file, $msg);
            fclose($file);
        }
    }
}
