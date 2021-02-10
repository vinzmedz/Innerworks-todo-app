<?php

class pdo_sqlsrv
{
    public $servername = "localhost";
    public $username = "root";
    public $password = "qwerty";
   
    public $conn;

    public function query($sql)
    {
        try {
            $dsn = "sqlsrv:Server=" . self::$servername . "; Database=" . self::$dbname;

            $conn = new PDO( $dsn, self::$username, self::$password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));  

            $result = $conn->query($sql);

        } catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "<br />";
        }
    }

}