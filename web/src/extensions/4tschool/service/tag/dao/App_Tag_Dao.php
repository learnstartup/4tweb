<?php

defined('WEKIT_VERSION') or exit(403);

class App_Tag_Dao extends PwBaseDao {

	/**
	 * table name
	 */
	protected $_table = '4t_tag';

	/**
	 * primary key
	 */
	protected $_pk = 'id';

	/**
	 * table fields
	 */
	protected $_dataStruct = array('id', 'shopid', 'name', 'issystem', 'isactive','createdate','lastupdatetime');

	public function get($id) {
		return $this->_get($id);
	}

	public function getAllTags() {
		$sql = $this->_bindSql('SELECT * FROM %s ', $this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll();
	}

	public function getSysTags (){
		$sql = $this->_bindSql('SELECT * FROM %s WHERE issystem=1 ', $this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll();
	}

    public function getIncidentallyTags($idList)
    {
        $sql = $this->_bindSql('SELECT * FROM %s WHERE %s ', $this->getTable(), 'id in (' . $idList . ')');
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->queryAll();
    }

    public function getTagsByShopId ($shopId,$isActive){
    	$sql = $this->_bindSql('SELECT * FROM %s WHERE shopid=? AND %s AND issystem = 0 ORDER BY id', 
    		$this->getTable(), 
    		$isActive?" isactive=1 ":" ( 1 = 1) ");
    	$smt = $this->getConnection()->createStatement($sql);
    	return $smt->queryAll(array($shopId));
    }

	public function add($tag) {
		return $this->_add($tag, true);
	}

	public function update($id, $tag) {
		return $this->_update($id, $tag);
	}

	public function delete($id) {
		return $this->_delete($id);
	}
	
	public  function checkDuplicateName($name)
	{
		$sql = $this->_bindSql('SELECT count(*) as total FROM %s where name=?', $this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		$result=$smt->queryAll(array($name));
		return $result[0]['total'] > 0;
	}

}

?>