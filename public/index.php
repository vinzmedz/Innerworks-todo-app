<?php
    define( 'VERSION_DIR', dirname( __FILE__ ) . '\\' );

    require_once('../inc/database/pdo_sqlsrv.php');
    require_once('../inc/utils/simple_rest.php');
    require_once('../inc/request.php');

    require_once('../inc/utils/logger.php');
    $log = new logger('../inc/logs/debug.php');
    $log_msg = array();

    $rq = new request();
    $sr = new simple_rest();

    $rq->query = $_REQUEST;

    $req = $rq->process_request();

     $log->error($rq->debug);

    if ($req == 200) {
        $file = $rq->get_file();

        $query = $rq->get_params();

        include("../inc/models/" . $file . '.php' );
        
        $classname = $file;
        
        $cname = new $classname();
        $func_name = $query['cmd'];

        $qry_cnt = count($query);
        // $log->error(array("class_name : " . $file, "func_name : " . $func_name, "data count : " . $qry_cnt));

        if ($qry_cnt <= 1) {
            $response = $cname::$func_name();
        }
        else
        {
            if (isset($query['cmd']))
                unset($query['cmd']);

            $response = $cname::$func_name($query);
        }

        $response_data = $response['rows'];
    
        if(empty($response_data)) {
            $statusCode = 404;
            $response_data = array('error' => $response['response_msg']);
        }
        else
        {
            $statusCode = 200;
        }
    }
    else{

        $statusCode = 400;
        $response_data = array('error' => 'Invalid request.');

    }
    // $log_msg[] = 'response_data : ' . print_r($response_data, true);
    // $log->error($log_msg);

    $requestContentType = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : "application/json";

    $sr->setHttpHeaders($requestContentType, $statusCode);

    $jsonResponse = json_encode($response_data);

    echo $jsonResponse;
?>