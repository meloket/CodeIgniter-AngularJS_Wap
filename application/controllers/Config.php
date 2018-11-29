<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends WebLoginBase_Controller {

	public function __construct()
    {
        parent::__construct();
    }

    public final function configjs(){
		$this->display('config/config.php');
		$this->getSystemSettings();
		$config=array();
		$config['logoUrl']=$this->settings['logoUrl'];
		$config['skin']=$this->settings['defaultSkin'];
		$config['copyright']='';
		$config['isLocal']=false;

		echo "var base_url = '".site_url()."';";
		//var base_url = 'http://localhost/wap';
		echo 'var appConfig = '.json_encode($config).';';
		echo "var localConfig = {
			apiPath: '',
			staticPath: '/static/'
		};";
		echo "var slideList = ['./images/slide/zc/m1.jpg'];";
	}
}

?>