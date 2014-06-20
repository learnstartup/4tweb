<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_SchoolArea- 数据服务接口
 *
 */
class App_SchoolGroup {

	

	public function getSchoolGroup($schoolid,$type)
	{
		return $this->_loadDao()->getSchoolGroup($schoolid,$type);
	}

	public function getPeopleNotInGroup($schoolid,$type)
	{
		return $this->_loadDao()->getPeopleNotInGroup($schoolid,$type);
	}

	public function getPeopleInGroup($schoolid,$type)
	{
		return $this->_loadDao()->getPeopleInGroup($schoolid,$type);
	}

	public function addSchoolGroup(App_SchoolGroup_Dm $dm)
	{
		return $this->_loadDao()->add($dm->getData());
	}

	public function checkIfExists($schoolid,$groupname,$type)
	{
		return $this->_loadDao()->checkIfExists($schoolid,$groupname,$type);	
	} 

	public function addPeopleInGroup($groupid,$peopleid)
	{
		//delete first
		$this->deletePeopleInGroup($groupid,$peopleid);

		//add
		$this->_loadUserInGroupDao()->add($groupid,$peopleid);

	}

	public function deletePeopleInGroup($groupid,$peopleid)
	{
		return $this->_loadUserInGroupDao()->delete($groupid,$peopleid);
	}

	public function delete($id) {
		return $this->_loadDao()->delete($id);
	}


	/**
	 * @return App_SchoolGroup_Dao
	 */
	private function _loadDao() {
		return Wekit::loadDao('EXT:4tschool.service.schoolgroup.dao.App_SchoolGroup_Dao');
	}

	/**
	 * @return App_SchoolUserInGroup_Dao
	 */
	private function _loadUserInGroupDao() {
		return Wekit::loadDao('EXT:4tschool.service.schoolgroup.dao.App_SchoolUserInGroup_Dao');
	}

}