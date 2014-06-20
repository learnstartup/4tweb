<?php

defined('WEKIT_VERSION') or exit(403);

class App_Image_Dao extends PwBaseDao {

	/**
	 * table name
	 */
	protected $_table = '4t_image';

	/**
	 * primary key
	 */
	protected $_pk = 'id';

	/**
	 * table fields
	 */
	protected $_dataStruct = array('id', 'fid', 'imgurl', 'type', 'standard', 'createdate', 'isactive');

	public function get($id) {
		return $this->_get($id);
	}

	public function getImageByFidAndType($fid,$type) {
		$sql = $this->_bindSql('SELECT * FROM %s WHERE fid = ? AND type = ?', $this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($fid,$type));
	}

	public function add($image) {
		return $this->_add($image, true);
	}

	public function update($id, $image) {
		return $this->_update($id, $image);
	}

	public function delete($id) {
		return $this->_delete($id);
	}
	
	public  function existsFid($fid,$type)
	{
		$sql = $this->_bindSql('SELECT count(*) as total FROM %s WHERE fid = ? AND type = ?', $this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		$result=$smt->queryAll(array($fid,$type));
		return $result[0]['total'] > 0;
	}

}

?>