<?php
defined('WEKIT_VERSION') or exit(403);

class App_SysTag_Tree_Dm extends PwBaseDm {

	protected $id;

	public function setSysTagTree ($sysTagTree){
		
	}

	public function setJson($json) {
		$this->_data['json']=$json;
		return $this;
	}

	public function setDescription ($description){
		$this->_data['description']=$description;
		return $this;
	}
	
	public function setType ($type){
		$this->_data['type']=$type;
		return $this;
	}

	public function setCreateDate ($createDate){
		$this->_data['createdate']=$createDate;
		return $this;
	}

	/* (non-PHPdoc)
	 * @see PwBaseDm::_beforeAdd()
	 */
	protected function _beforeAdd() {
		// TODO Auto-generated method stub
		//check the fields value before add
		return true;
	}

	/* (non-PHPdoc)
	 * @see PwBaseDm::_beforeUpdate()
	 */
	 protected function _beforeUpdate() {
		// TODO Auto-generated method stub
	 	//check the fields value before update
		return true;
	}
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
