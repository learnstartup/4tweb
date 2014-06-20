<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_Tag - 数据服务接口
 */
class App_SysTag_Tree {	
	/**
	 * add record
	 *
	 * @param App_SysTag_Tree_Dm $dm
	 * @return multitype:|Ambigous <boolean, number, string, rowCount>
	 */
	public function add(App_SysTag_Tree_Dm $dm) {
		if (true !== ($r = $dm->beforeAdd())) return $r;
		return $this->loadDao()->add($dm->getData());
	}
	
	/**
	 * update record
	 *
	 * @param App_Tag_Dm $dm
	 * @return multitype:|Ambigous <boolean, number, rowCount>
	 */
	public function update($id,App_SysTag_Tree_Dm $dm) {
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

	public function getSysTagTrees(){
		return $this->loadDao()->getSysTagTrees();
	}
	
	public function getSysTagTreeByType ($type){
		return $this->loadDao()->getSysTagTreeByType($type);
	}

	/**
	 * @return App_SysTag_Tree_Dao
	 */
	private function loadDao() {
		return Wekit::loadDao('EXT:4tschool.service.tag.dao.App_SysTag_Tree_Dao');
	}
}

?>