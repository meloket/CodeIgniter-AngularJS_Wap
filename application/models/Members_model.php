<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Members_model extends User_Model
{
	protected $table_name = "ssc_members";
    public function __construct()
    {
        parent::__construct($this->table_name);
    }

}
?>