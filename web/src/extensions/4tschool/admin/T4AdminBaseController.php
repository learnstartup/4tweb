<?php

Wind::import('APPS:admin.library.AdminBaseController');

class T4AdminBaseController extends AdminBaseController {
	
	public function run() {

	}

	public function _setNavType ($controllerName){
		$this->setOutput($this->navType[$controllerName], 'navType');
	}

	public $navType=array(
		"boutique"=>"b",
		"manage"=>"sm",//system manage
		"merchandise"=>"m",
		"promo"=>"p",
		"schoolarea"=>"sa",
		"schoolpeople"=>"sp",
		"shop"=>"s",
		"systagtree"=>"st",
		"tag"=>"t",
		"cateweekreport"=>"cateweekreport",
		"manage"=>"manage"
		);

    protected function getDomain()
    {
        $serverHost = $_SERVER['HTTP_HOST'];
        $parsedInfo = parse_url($serverHost);
        $scheme =  empty($parsedInfo['scheme'])?"http":$parsedInfo['scheme'];
        $path =  $parsedInfo['path'];
        $host =  $parsedInfo['host'];
        $port =  $_SERVER['SERVER_PORT'] == "80"?"":$_SERVER['SERVER_PORT'];

        $baseUrl =  $scheme.'://'.$host.(empty($port)?"":":".$port).$path;

        return $baseUrl . '/src/extensions/4tschool';
    }	
}