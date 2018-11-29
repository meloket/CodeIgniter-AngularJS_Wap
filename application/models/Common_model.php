<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Common_model extends CRM_Model
{
	protected $table_name = "";
    public function __construct()
    {
        parent::__construct($this->table_name);
    }

    public function getRows($sql)
    {
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function getRow($sql)
    {
        $query = $this->db->query($sql);
        if($query->num_rows()>0) {
            $result = $query->row_array();
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get Object From Table
     *
     * @access public
     * @param    $where           get data conditions
     * @return 
     */
    public function getObject($sql, $fieldname)
    {
        $query = $this->db->query($sql);

        if($query->num_rows()>0) {
            $result = $query->result_array();
            $data = array();
            foreach($result as $var){
                $data[$var[$fieldname]]=$var;
            }
            return $data;
        } else {
            return array();
        }
    }

    public function getPage($sql, $page = 1, $pageSize = 10)
    {
        $query = $this->db->query($sql);
        $result['total'] = $query->num_rows();

		$startRow = ($page - 1) * $pageSize;
        $sql .= " LIMIT ".$startRow.", ".$pageSize;
        $query = $this->db->query($sql);

        $result['data'] = $query->result_array();
        return $result;
    }

    public function getCol($sql)
    {
        $query = $this->db->query($sql);
        if($query->num_rows()>0) {
            $result = $query->row_array();
            return isset(array_values($result)[0]) ? array_values($result)[0] : false;
        } else {
            return false;
        }
    }

    public function getValue($sql)
    {
        $query = $this->db->query($sql);
        if($query->num_rows()>0) {
            $result = $query->row_array();
            return isset(array_values($result)[0]) ? array_values($result)[0] : false;
        } else {
            return false;
        }
    }

    public function run_sql($sql)
    {
        $query = $this->db->query($sql);
        return true;
    }

    public function update($table, $data, $where)
    {
    	$this->db->where($where);
    	return $this->db->update($table ,$data);
    }

    public function insert($table, $data)
    {
    	return $this->db->insert($table, $data);
    }

    public function get_inserted_id()
    {
    	$insert_id = $this->db->insert_id();
    	return $insert_id;
    }

}
?>