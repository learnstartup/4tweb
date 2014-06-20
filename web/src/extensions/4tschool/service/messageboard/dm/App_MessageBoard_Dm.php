<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_MessageBoard_Dm - 数据模型
 *
 * @author yang <yangyan7777@sina.com> 
 * @copyright http://www.fenxiangyo.com
 */
class App_MessageBoard_Dm extends PwBaseDm {

	protected $id;

	public function setSchoolId($schoolid) {
		$this->_data['schoolid'] = intval($schoolid);
		return $this;
	}
	
	public function setUserId($userid) {
		$this->_data['userid'] = intval($userid);
		return $this;
	}

	public function setCookie($cookie) {
		$this->_data['cookie'] = $cookie;
		return $this;
	}


	public function setQuestion($question) {
		$this->_data['question'] = $question;
		return $this;
	}


	public function setApproved($approved) {
		$this->_data['approved'] = $approved;
		return $this;
	}


	public function setReplyby($replyby) {
		$this->_data['replyby'] = $replyby;
		return $this;
	}


	public function setReply($reply) {
		$this->_data['reply'] = $reply;
		return $this;
	}


	public function setDeleted($deleted) {
		$this->_data['deleted'] = $deleted;
		return $this;
	}

	public function setDeletedAt($deletedat) {
		$this->_data['deletedat'] = $deletedat;
		return $this;
	}

	public function setRepliedAt($repliedat) {
		$this->_data['repliedat'] = $repliedat;
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

?>