<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Guestmembers_model extends User_Model
{
	protected $table_name = "ssc_guestmembers";
    public function __construct()
    {
        parent::__construct($this->table_name);
    }

}
?>