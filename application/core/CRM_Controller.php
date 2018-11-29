<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CRM_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        //echo $this->router->fetch_class(); // class = controller
		//echo $this->router->fetch_method(); // method = action
		header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Authorization, Content-Type, Origin, X-Auth-Token' );
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    }

    
}