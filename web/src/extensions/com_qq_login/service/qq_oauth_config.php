<?php
class qq_oauth_config{
	private $cfg = array();
	private $oldcfg = array();
	private $file;
	private $changed = false;
    public function __construct() {
		$this->file = Wind::getRealPath('EXT:com_qq_login.config', 'php');
		if(file_exists($this->file)){
			$this->cfg = $this->oldcfg = include($this->file);
		} else {
			if(!is_writable(dirname($this->file))){
				throw new exception('config file '.$this->file.' is not writable,please set mod to 777.');
			}
		}
	}
	function is_changed(){
		return $this->changed && $this->cfg!=$this->oldcfg;
	}
	function __get($key){
		return isset($this->cfg[$key]) ? $this->cfg[$key] : '';
	}
	function __set($key, $value){
		$this->changed = true;
		$this->cfg[$key] = $value;
	}
	function __destruct(){
		if($this->is_changed()){
			file_put_contents($this->file,'<?php return '.var_export($this->cfg,1).';');
		}
	}
}