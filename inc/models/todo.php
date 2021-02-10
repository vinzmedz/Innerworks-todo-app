<?php
class todo
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

    public function new_list($data)
    {
        if (isset($data['cmd']))
            unset($data['cmd']);

        try 
        {
            $pdo = new PDO(self::$dsn . self::$db_dg, self::$user, self::$pass);
            $stm = $pdo->prepare("INSERT INTO tbl_todos (todo_name, todo_desc)
                                  VALUES(:todo_name, :todo_desc)");
            $stm->execute($data);

            $data['rows'] = array('success');
        }
        catch(PDOException $x)
        {
            $data['status'] = FALSE;
            $data['response_msg'] = $x.getMessage();
        }
        
        $stm = null;
        $pdo = null;
        
        $data['rows'] = $rows;
        return $data;
                
    }

    public function new_tasks($data)
    {

        try 
        {
            if (isset($data['cmd'])) unset($data['cmd']);

            $pdo = new PDO(self::$dsn . self::$db_col, self::$user, self::$pass);

            $stm = $pdo->prepare("INSERT INTO tbl_tasks (todo_id, task_name, task_desc)
                                  VALUES(:todo_id, :task_name, :task_desc)");
            $stm->execute($data);

            $data['rows'] = array('success');
        }
        catch(PDOException $x)
        {
            $data['status'] = FALSE;
            $data['response_msg'] = $x.getMessage();
        }

        $stm = null;
        $pdo = null;

        return $data;
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
    
    public function get_tasks($data)
    {
        $pdo = new PDO(self::$dsn . self::$db_col, self::$user, self::$pass);

        $stm = $pdo->prepare("SELECT todo_id, task_id, task_name, date_created, date_finished, task_status FROM tbl_tasks WHERE todo_id=:todo_id");
        $stm->bindParam(':todo_id', $data['todo_id'], PDO::PARAM_STR);
        $stm->execute();

        $rows = (array) $stm->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows))
            $data['response_msg'] = "No record found for Course.";

        $data['rows'] = $rows;

        $stm = null;
        $pdo = null;

        return $data;
    }
 
    public function update_task($data)
    {
        $pdo = new PDO(self::$dsn . self::$db_dg, self::$user, self::$pass);
        $stm = $pdo->prepare("UPDATE tbl_tasks SET task_status=2 WHERE task_id=:task_id");
        $stm->bindParam(':task_id', $data['id'], PDO::PARAM_INT);
        $stm->execute();

        $data['rows'] = array('success');

        return $data;
    }

}