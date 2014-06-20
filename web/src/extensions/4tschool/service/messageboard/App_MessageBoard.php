<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_SchoolArea- 数据服务接口
 *
 */
class App_MessageBoard {


	public function getMessages($schoolid,$approved,$replied,$limit, $offset)
	{
		return $this->_loadDao()->getMessages($schoolid,$approved,$replied,$limit, $offset);
	}

	public function countMessages($schoolid,$approved,$replied,$limit, $offset)
	{
		return $this->_loadDao()->countMessages($schoolid,$approved,$replied,$limit, $offset);
	}

	public function getByUserid($schoolid,$userid,$approved,$replyed, $limit, $offset)
	{
		return $this->_loadDao()->getByUserid($schoolid,$userid,$approved,$replyed, $limit, $offset);
	}

	public function countByUserid($schoolid,$userid,$approved,$replyed, $limit, $offset)
	{
		return $this->_loadDao()->countByUserid($schoolid,$userid,$approved,$replyed, $limit, $offset);
	}

	public function getByid($id) 
	{
		return $this->_loadDao()->getByid($id);
	}

	public function updateAsDeleted($id,$deletedby)
	{
		return $this->_loadDao()->updateAsDeleted($id,$deletedby);
	}

	public function reply($id,$repliedby,$message)
	{
		return $this->_loadDao()->reply($id,$repliedby,$message);
	}

	public function insertFeedback($schoolid,$userid,$message)
	{
		Wind::import('EXT:4tschool.service.messageboard.dm.App_MessageBoard_Dm');
		$dm = new App_MessageBoard_Dm();


		$dm->setUserId($userid)
			->setSchoolId($schoolid)
			->setQuestion($message);

		return $this->_loadDao()->add($dm->getData());

	}
	
	
	/**
	 * @return App_SchoolMessageBoard_Dao
	 */
	private function _loadDao() {
		return Wekit::loadDao('EXT:4tschool.service.messageboard.dao.App_MessageBoard_Dao');
	}
}

?>