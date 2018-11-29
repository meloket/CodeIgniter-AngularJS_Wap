<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DBAccess_Controller extends CRM_Controller
{
	private $charset;
	public $cacheDir;
	public $expire;
	public $prename;
	public $time;

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        
        $this->time = intval($_SERVER['REQUEST_TIME']);
        $this->prename = $this->config->item('db')['prename'];
        $this->cacheDir = $this->config->item('cache')['dir'];
        $this->expire = $this->config->item('cache')['expire'];

        $this->load->model('common_model');
	}
	
	public function __destruct() {  
        $this->db->close();  
    }

	public function beginTransaction()
	{
		$this->db->trans_begin();
	}
	public function rollBack()
	{
		$this->db->trans_rollback();
	}
	public function commit()
	{
		$this->db->trans_commit();
	}
	
	public function getCacheDir(){
		return $this->cacheDir;
	}

	public function setCharset($charset){
		if($charset && $this->charset != $charset){
			$this->charset = $charset;
			/* aaron-nnn */
			//$this->query('set names '.$charset);
		}
	}

	public function setCacheDir($dir){
		$this->makefolder($dir);
		$this->cacheDir = $dir;
	}

	// 读取操作
	//{{{
	public function getRows($sql, $params = null, $expire = 0){
		if($expire){

			if(is_file($file=$this->getCacheDir().md5($sql.serialize($params))) && filemtime($file) + $expire>$this->time){
				return unserialize(file_get_contents($file));
			}else{
				file_put_contents($file, serialize($data=$this->getRows($sql, $params)));
				return $data;
			}

		}else{

			return $this->common_model->getRows($sql);
		}
	//}}}
	}
	
	public function getObject($sql, $field, $params=null, $expire=0){
		//echo $sql;exit;
		if($expire){
			//var_dump($this->getCacheDir());exit;
			if(is_file($file=$this->getCacheDir().md5($sql.serialize($params))) && filemtime($file)+$expire>$this->time){
				return unserialize(file_get_contents($file));
			}else{
				file_put_contents($file, serialize($data=$this->getObject($sql, $field, $params)));
				return $data;
			}

		}else{
			
			return $this->common_model->getObject($sql, $field);
		}
	}

	public function getPage($sql, $page = 1, $pageSize = 10, $params = null, $expire = 0){
	//{{{
		if($expire){

			if(is_file($file=$this->getCacheDir().md5($sql.serialize($params))) && filemtime($file)+$expire>$this->time){			
				return unserialize(file_get_contents($file));
			}else{
				file_put_contents($file, serialize($data=$this->getPage($sql, $page, $pageSize, $params)));
				return $data;
			}

		}else{
			return $this->common_model->getPage($sql, $page, $pageSize);
		}
	//}}}
	}

	public function getRow($sql, $params=null, $expire=0){//{{{
		if($expire){

			if(is_file($file=$this->getCacheDir().md5($sql.serialize($params))) && filemtime($file)+$expire>$this->time){
				return unserialize(file_get_contents($file));
			}else{
				file_put_contents($file, serialize($data=$this->getRow($sql, $params)));
				return $data;
			}

		}else{

			return $this->common_model->getRow($sql);
		}
	//}}}
	}

	public function  getCol($sql, $params=null, $expire=0){
		if($expire){

			if(is_file($file=$this->getCacheDir().md5($sql.serialize($params))) && filemtime($file)+$expire>$this->time){
				return unserialize(file_get_contents($file));
			}else{
				file_put_contents($file, serialize($data=$this->getCol($sql, $params)));
				return $data;
			}

		}else{

			return $this->common_model->getCol($sql);
		}
	}

	public function getValue($sql, $params=null, $expire=0){
		if($expire){

			if(is_file($file=$this->getCacheDir().md5($sql.serialize($params))) && filemtime($file)+$expire>$this->time){
				return file_get_contents($file);
			}else{
				file_put_contents($file, $data=$this->getValue($sql, $params));
				return $data;
			}

		}else{
			return $this->common_model->getValue($sql);
		}
	}
	//}}}

	// 写操作
	//{{{
	public function update($query, $params=null){
		return $this->common_model->run_sql($query);
	}

	public function delete($query, $params=null){
		return $this->common_model->run_sql($query);
	}

	public function setRows($table, $data, $valueKeys){

	}

	public function updateRows($table, $data, $where){
		return $this->update($table, $data, $where);
	}

	public function insert($query, $params=null){
		if($this->common_model->run_sql($query))
			return $this->common_model->get_inserted_id();
		else
			return null;
	}

	public function insertRow($table, $data){
		if($this->common_model->insert($table, $data))
			return $this->common_model->get_inserted_id();
		else
			return null;
	}

	public function insertRows($table, $data){

	}

	//}}}

	/**
	 * 创建深层目录
	 */
	public static final function makefolder($dir, $mode = 0777){
		return is_dir($dir) || makefolder(dirname($dir), $mode) && mkdir($dir, $mode);
	}
}