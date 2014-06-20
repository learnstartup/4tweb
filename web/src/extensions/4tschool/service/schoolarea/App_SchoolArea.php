<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_SchoolArea- 数据服务接口
 *
 */
class App_SchoolArea {
	
	/**
	 * get school area by id
	 *
	 * @param unknown_type $id
	 * @return Ambigous <multitype:, multitype:unknown , mixed>
	 */
	public function getBySchoolid($schoolid) {
		return $this->_loadDao()->getBySchoolid($schoolid);
	}

	public function getByid($areaid)
	{
		return $this->_loadDao()->getByid($areaid);	
	}

	public function add(App_SchoolArea_Dm $dm)
	{
        if (true !== ($r = $dm->beforeAdd())) return $r;
        return $this->_loadDao()->add($dm->getData());
	}

	public function updateArea($id,App_SchoolArea_Dm $dm)
	{
		return $this->_loadDao()->update($id,$dm->getData());
	}

	public function checkDuplicateName($id,$schoolid,$areaname)
	{
		return $this->_loadDao()->checkDuplicateName($id,$schoolid,$areaname);
	}

	/**
	 * @return App_SchoolArea_Dao
	 */
	private function _loadDao() {
		return Wekit::loadDao('EXT:4tschool.service.schoolarea.dao.App_SchoolArea_Dao');
	}
}

?>