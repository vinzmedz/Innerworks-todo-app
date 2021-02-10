<?php

class todo_auth 
{
    private static $dsn;
    private static $user;
    private static $pass;

    private static $db_shs;
    private static $db_col;
    private static $db_dg;

    private $conn_det;

    function __construct()
    {
        $conn_det = new pdo_sqlsrv();

        $dsn = "mysql:host=" . $conn_det->servername . "; dbname=";

        self::$dsn = $dsn;
        self::$user = $conn_det->username;
        self::$pass = $conn_det->password;
    }

    function login()
    {

    }

    public function get_todos($data)
    {
        $pdo = new PDO(self::$dsn . self::$db_col, self::$user, self::$pass);

        $stm = $pdo->prepare("SELECT todo_name, todo_desc, date_created, date_completed, todo_status FROM tbl_todos WHERE user_id=:user_id");
        $stm->bindParam(':user_id', $data['task_id'], PDO::PARAM_STR);
        $stm->execute();

        $rows = (array) $stm->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows))
            $data['response_msg'] = "No record found for Course.";

        $data['rows'] = $rows;

        $stm = null;
        $pdo = null;

        return $data;
    }
}