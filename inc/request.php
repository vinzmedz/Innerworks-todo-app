<?php
class request
{
    private $file_path = "";

    public $request_method = "";
    private $script_name = "";
    private $request_uri = "";

    public $query = array();

    private $debug_row = "";
    public $debug =array();

    function __construct()
    {
        $this->request_method = $_SERVER["REQUEST_METHOD"];

        $this->script_name = $_SERVER["SCRIPT_NAME"];
        $this->request_uri = $_SERVER['REQUEST_URI'];

    }

    public function get_params()
    {
        return $this->query;
    }

    public function get_file()
    {
        return $this->file_path;
    }

    public function process_request()
    {

        $data_time = date("Y-m-d H:i:s");
        $uri = rtrim( dirname($this->script_name), '/' );

        $uri = '/' . trim( str_replace( $uri, '', $this->request_uri ), '/' );

        $route = urldecode( $this->request_uri );

        if ($pos = strpos($route, "?")) {
            $route = substr($route, 0, $pos);
        }

        $file_path = "";
        $this->file_path .= $this->get_filepath($route);

        $this->debug[] = $this->debug_row;
        if ($this->file_path != "")
        {
            return 200;
        } 
        else
        {
            return 404;
        }
    }

    private function get_filepath($route)
    {
        require_once("routes.php");

        $file_path = "";

        $rules = get_rules();

        foreach ( $rules as $action => $rule ) {

            if ( preg_match( '~^.*'.$rule.'$~i', $route, $params ) ) {

                $file_path = $action;
                break;
            }
        }

        return $file_path;
    }
}