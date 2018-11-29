<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CRM_Controller {

	public function __construct()
    {
        parent::__construct();
    }

    public function index()
	{
		$this->loadLandingTemplate('landing');
	}
	public function loadLandingTemplate($current_view) 
	{
	    $this->load->view('layout/common');
		$this->load->view('layout/header/header1');
		$this->load->view('layout/navbar/navbar1');
		$this->load->view('layout/login_dialog/login1');
		$this->load->view($current_view);
		$this->load->view('layout/footer');
	    return NULL;
	}
}

?>