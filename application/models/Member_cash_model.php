<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Member_cash_model extends User_Model
{
	protected $table_name = "ssc_member_cash";
    public function __construct()
    {
        parent::__construct($this->table_name);
    }

}
?>