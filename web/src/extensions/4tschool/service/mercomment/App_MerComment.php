<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_SchoolMyFavorite- 数据服务接口
 *
 */
class App_MerComment {
	
	public function addMyComment($userid,$mid,$orderid,$comment,$environmentscore,$servicescore,$tastescore)
	{
		Wind::import('EXT:4tschool.service.mercomment.dm.App_MerComment_Dm');
		$dm = new App_MerComment_Dm();
		$dm->setUserId($userid)
			->setMID($mid)
			->setOrderId($orderid)
			->setComment($comment)
			->setEnvironmentscore($environmentscore)
			->setServicescore($servicescore)
			->setTastescore($tastescore);
		return $this->_loadDao()->add($dm->getData());
	}

	public function getMyUnComment($schoolid,$userid,$limit,$offset)
	{
		return $this->_loadDao()->getMyUnComment($schoolid,$userid,$limit,$offset);
	}

	public function getCountOfMyUnComment($schoolid,$userid)
	{
		return $this->_loadDao()->getCountOfMyUnComment($schoolid,$userid);
	}

	public function getMyComment($schoolid,$userid,$limit,$offset)
	{
		return $this->_loadDao()->getMyComment($schoolid,$userid,$limit,$offset);
	}

	public function getMcommentMessage($mid)
	{
		return $this->_loadDao()->getMcommentMessage($mid);
	}

	public function getCountOfMyComment($schoolid,$userid)
	{
		return $this->_loadDao()->getCountOfMyComment($schoolid,$userid);
	}

	public function getCountOfMcomment($mid)
	{
		return $this->_loadDao()->getCountOfMcomment($mid);
	}

	public function getMcomment($mid,$limit,$offset)
	{
		return $this->_loadDao()->getMcomment($mid,$limit,$offset);
	}

	public function checkIfExists($userid,$orderid,$merchandiseid)
	{
		return $this->_loadDao()->checkIfExists($userid,$orderid,$merchandiseid);
	}

	public function getMOverall($shopid)
	{
		return $this->_loadDao()->getMcomment($shopid);
	}

	public function delete($id) {
		return $this->_loadDao()->delete($id);
	}

	/**
	 * @return App_MerComment_Dao
	 */
	private function _loadDao() {
		return Wekit::loadDao('EXT:4tschool.service.mercomment.dao.App_MerComment_Dao');
	}
}