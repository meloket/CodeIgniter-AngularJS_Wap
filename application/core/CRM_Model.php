<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CRM_Model extends CI_Model
{
	protected $table_name;
    public function __construct($table_name)
    {
        parent::__construct();
        $this->table_name = $table_name;
    }
}
?>