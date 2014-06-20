<?php

defined('WEKIT_VERSION') or exit(403);

class App_Search_Dm extends PwBaseDm {	
	protected $id;	

	public function setUid($uid) {
		$this->_data['uid'] = $uid;
		return $this;
	}

	public function setSchoolid($schoolId){
		$this->_data['schoolid']=$schoolId;
		return $this;
	}

	public function setKeyword($keyword){
		$this->_data['keyword']=$keyword;
		return $this;
	}

	public function setSearchType($type){
		$this->_data['searchtype']=$type;
		return $this;
	}

	public function setCreateDate($date){
		$this->_data['createdate']=$date;
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