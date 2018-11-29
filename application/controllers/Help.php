<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends WebBase_Controller {

	public function __construct()
    {
        parent::__construct();
    }

    public function index()
	{
		$this->loadhelp('help_5');
	}
	public function loadhelp($current_view) 
	{
        $this->load->view('layout/common');
        // $this->session->user_data('username')
        if($this->session->userdata($this->memberSessionName))
        {
        	$id = $this->user['uid'];
            $sql="select * from {$this->prename}members where uid={$id} limit 0,1";
			$view_data['user'] = $this->getRow($sql, $id);
            $this->load->view('layout/header/header2', $view_data);
        } else { 
            $this->load->view('layout/header/header1');
        }
		
		$this->load->view('layout/navbar/navbar1');
		$this->load->view('help/'.$current_view);
		$this->load->view('layout/footer');
	    return NULL;
	}
}

?>