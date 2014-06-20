<?php
class ManageController extends PwBaseController {
	private $cfg;
    public function run() {
		$method = strtoupper($_SERVER['REQUEST_METHOD']);
		call_user_func(array($this,$method));
    }
	
	public function GET() {
		$this->setOutput($this->cfg('appid'),'appid');
		$this->setOutput($this->cfg('secret'),'secret');
		$msg = $this->getInput('msg');
		$msg = htmlspecialchars($msg);
		$this->setOutput($msg,'msg');
        $this->setTemplate('manage_run');
	}
	public function POST() {
		$appid = $this->getInput('appid');
		$secret = $this->getInput('secret');
		if(empty($appid) || !is_numeric($appid)){
			$this->showMessage('请确保填写了正确的 app id!');
		}
		if(!preg_match('/^[a-zA-Z0-9]+$/', $secret)){
			$this->showMessage('请确保填写了正确的 APP KEY!');
		}
		try{
			$this->cfg('appid', $appid);
			$this->cfg('secret', $secret);
			if($this->cfg->is_changed()){
				header('Location:'.$_SERVER['HTTP_REFERER'].'&msg='.'您的设置已保存');
			} else {
				header('Location:'.$_SERVER['HTTP_REFERER']);
			}
		} catch(Exception $e){
			$this->showMessage($e->getMessage());
			
		}
	}
	private function cfg($key=false,$value=false) {
		if(is_null($this->cfg)) {
			$this->cfg = Wekit::load('SRC:extensions.com_qq_login.service.qq_oauth_config');
		}
		if(empty($key)){
			return $this->cfg;
		}
		if(empty($value)){
			return $this->cfg->$key;
		} else {
			$this->cfg->$key = $value;
		}
	}
	function get_rand(){
		$func = function_exists('mt_rand') ? 'mt_rand' : 'rand';
		return $func();
	}
	
 
}