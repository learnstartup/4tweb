<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_Tag - 数据服务接口
 */
class App_Boutique {
	
	public function getBoutiques($isActive) {
		return $this->loadDao()->getBoutiques($isActive);
	}

	public function getBoutiquesBySchoolId ($schoolid,$isActive){
		return $this->loadDao()->getBoutiquesBySchoolId($schoolid,$isActive);
	}
	
	public function getCurrentSchoolBoutiquesByType ($schoolid,$type){
		return $this->loadDao()->getCurrentSchoolBoutiquesByType($schoolid,$type);
	}
	/**
	 * add record
	 *
	 * @param App_Tag_Dm $dm
	 * @return multitype:|Ambigous <boolean, number, string, rowCount>
	 */
	public function add(App_Boutique_Dm $dm) {
		if (true !== ($r = $dm->beforeAdd())) return $r;
		return $this->loadDao()->add($dm->getData());
	}
	
	/**
	 * update record
	 *
	 * @param App_Tag_Dm $dm
	 * @return multitype:|Ambigous <boolean, number, rowCount>
	 */
	public function update($id,App_Boutique_Dm $dm) {
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
	
	public function get($id){
		return $this->loadDao()->get($id);
	}

	public  function checkDuplicateName($name)
	{
		return $this->loadDao()->checkDuplicateName($name);
	}
	
	/**
	 * @return App_Tag_Dao
	 */
	private function loadDao() {
		return Wekit::loadDao('EXT:4tschool.service.boutique.dao.App_Boutique_Dao');
	}
}

?>