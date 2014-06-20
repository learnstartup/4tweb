<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_Dongta - 数据服务接口
 *
 * @author chenjm <sky_hold@163.com>
 * @copyright http://www.phpwind.net
 * @license http://www.phpwind.net
 */
class App_Dongta {
	
	/**
	 * get a record
	 *
	 * @param unknown_type $id
	 * @return Ambigous <multitype:, multitype:unknown , mixed>
	 */
	public function get($id) {
		return $this->_loadDao()->get($id);
	}

	public function getByUid($uid, $limit, $offset = 0) {
		return $this->_loadDao()->getByUid($uid, $limit, $offset);
	}

	public function countByUid($uid) {
		return $this->_loadDao()->countByUid($uid);
	}

	/**
	 * add record
	 *
	 * @param App_Dongta_Dm $dm
	 * @return multitype:|Ambigous <boolean, number, string, rowCount>
	 */
	public function add(App_Dongta_Dm $dm) {
		if (true !== ($r = $dm->beforeAdd())) return $r;
		return $this->_loadDao()->add($dm->getData());
	}
	
	/**
	 * update record
	 *
	 * @param App_Dongta_Dm $dm
	 * @return multitype:|Ambigous <boolean, number, rowCount>
	 */
	public function update(App_Dongta_Dm $dm) {
		if (true !== ($r = $dm->beforeUpdate())) return $r;
		return $this->_loadDao()->update($dm->getId(), $dm->getData());
	}
	
	/**
	 * delete a record
	 *
	 * @param unknown_type $id
	 * @return Ambigous <number, boolean, rowCount>
	 */
	public function delete($id) {
		return $this->_loadDao()->delete($id);
	}
	
	/**
	 * @return App_Dongta_Dao
	 */
	private function _loadDao() {
		return Wekit::loadDao('EXT:dongta.service.dao.App_Dongta_Dao');
	}
}

?>