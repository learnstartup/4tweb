<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_Tag - 数据服务接口
 */
class App_Tag {

	public function getTag($id)
	{
		return $this->loadDao()->get($id);
	}
	
	public function getAllTags() {
		return $this->loadDao()->getAllTags();
	}

	public function getSysTags (){
		return $this->loadDao()->getSysTags();
	}

    public function getIncidentallyTags($idList)
    {
        return $this->loadDao()->getIncidentallyTags($idList);
    }

    public function getTagsByShopId ($shopId,$isActive){
    	return $this->loadDao()->getTagsByShopId($shopId,$isActive);
    }
	
	/**
	 * add record
	 *
	 * @param App_Tag_Dm $dm
	 * @return multitype:|Ambigous <boolean, number, string, rowCount>
	 */
	public function add(App_Tag_Dm $dm) {
		if (true !== ($r = $dm->beforeAdd())) return $r;
		return $this->loadDao()->add($dm->getData());
	}
	
	/**
	 * update record
	 *
	 * @param App_Tag_Dm $dm
	 * @return multitype:|Ambigous <boolean, number, rowCount>
	 */
	public function update($id,App_Tag_Dm $dm) {
		if (true !== ($r = $dm->beforeUpdate())) return $r;
		return $this->loadDao()->update($id, $dm->getData());
	}
	
	/**
	 * delete a record
	 *
	 * @param unknown_type $id
	 * @return Ambigous <number, boolean, rowCount>
	 */
	public function delete($id) {
		return $this->loadDao()->delete($id);
	}
	
	public  function checkDuplicateName($name)
	{
		return $this->loadDao()->checkDuplicateName($name);
	}
	
	/**
	 * @return App_Tag_Dao
	 */
	private function loadDao() {
		return Wekit::loadDao('EXT:4tschool.service.tag.dao.App_Tag_Dao');
	}
}

?>