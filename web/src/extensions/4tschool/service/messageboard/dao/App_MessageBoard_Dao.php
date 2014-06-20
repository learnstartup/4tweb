<?php
defined('WEKIT_VERSION') or exit(403);
/**
 * App_SchoolArea_Dao - dao
 *
 * @author yang <yangyan7777@gmail.com>
 * @copyright http://www.fenxiangyo.net
 * @license http://www.fenxiangyo.net
 */
class App_MessageBoard_Dao extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = '4t_user_messageboard';

	/**
	 * primary key
	 */
	protected $_pk = 'id';
	/**
	 * table fields
	 */
	protected $_dataStruct = array('id','schoolid','userid','cookie','question','approved','replyby','reply','deleted','deletedby','deletedat','createdat','repliedat');
	
	
	public function getByUserid($schoolid,$userid,$approved,$replyed, $limit, $offset) {
		$sql = $this->_bindSql('SELECT * FROM %s  WHERE userid =? and schoolid = ? and %s and %s  ORDER BY createdat DESC %s',
						$this->getTable(),
						$approved== -1?" 1= 1" :($approved == 1?"approved = 1":" approved = 0"),
						$replyed == -1?" 1= 1 ": ($replyed == 1?" replyby > 0 ":" replyby <= 0 "),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($userid,$schoolid));
	}

	public function countByUserid($schoolid,$userid,$approved,$replyed, $limit, $offset) {
		$sql = $this->_bindSql('SELECT count(*) FROM %s  WHERE userid =? and schoolid = ? and %s and %s ORDER BY createdat DESC %s',
						$this->getTable(),
						$approved== -1?" 1= 1" :($approved == 1?"approved = 1":" approved = 0"),
						$replyed == -1?" 1= 1 ": ($replyed == 1?" replyby > 0 ":" replyby <= 0"),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue(array($userid,$schoolid));
	}

	public function getByid($id) 
	{
		$sql = $this->_bindSql('SELECT * FROM %s  where id=? ORDER BY createdat DESC',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($id));	
	}

	public function getMessages($schoolid,$approved,$replyed,$limit, $offset)
	{
		$sql = $this->_bindSql('SELECT * FROM %s  WHERE schoolid =? and %s and %s  and deleted = 0 ORDER BY createdat DESC %s',
						$this->getTable(),
						$approved== -1?" 1= 1" :($approved == 1?"approved = 1":" approved = 0"),
						$replyed == -1?" 1= 1 ": ($replyed == 1?" replyby > 0":" replyby = 0"),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid));
	}

	public function countMessages($schoolid,$approved,$replyed,$limit, $offset)
	{
		$sql = $this->_bindSql('SELECT count(*) FROM %s  WHERE schoolid =? and %s and %s and deleted = 0 ORDER BY createdat DESC %s',
						$this->getTable(),
						$approved== -1?" 1= 1" :($approved == 1?"approved = 1":" approved = 0"),
						$replyed == -1?" 1= 1 ": ($replyed == 1?" replyby > 0 ":" replyby <= 0"),
						$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue(array($schoolid));
	}

	public function updateAsDeleted($id,$deletedby)
	{
		$sql = $this->_bindSql('UPDATE %s SET deleted = 1 , deletedat = now() ,reply = "无效的留言" , repliedat = now(),deletedby = ? WHERE id =? ',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->execute(array($deletedby,$id));
	}

	public function reply($id,$repliedby,$message)
	{
		$sql = $this->_bindSql('UPDATE %s SET repliedat = now() , reply = ? , replyby = ? WHERE id =? ',
						$this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->execute(array($message,$repliedby,$id));
	}

	
	public function add($fields) {
		return $this->_add($fields, true);
	}
	
	public function update($id, $fields) {
		return $this->_update($id, $fields);
	}
	
	public function delete($id) {
		return $this->_delete($id);
	}
}

?>