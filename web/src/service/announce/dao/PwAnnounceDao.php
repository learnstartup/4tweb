<?php
defined('WEKIT_VERSION') || exit('Forbidden');

/**
 * 公告管理基础表dao服务
 *
 * @author MingXing Sun <mingxing.sun@aliyun-inc.com>
 * @copyright ©2003-2103 phpwind.com
 * @license http://www.phpwind.com
 * @version $Id: PwAnnounceDao.php 5140 2012-02-29 08:21:33Z mingxing.sun $
 * @package announce
 */

class PwAnnounceDao extends PwBaseDao {
	
	protected $_table = 'announce';
	protected $_pk = 'aid';
	protected $_dataStruct = array('aid','schoolid', 'vieworder', 'created_userid', 'typeid', 'url', 'subject', 'content', 'start_date', 'end_date');
	
	/**
	 * 添加一条公告信息
	 * 
	 * @param array $fields
	 * @return int
	 */
	public function addAnnounce($fields){
		return $this->_add($fields);
	}
	
	/**
	 * 删除一条公告信息
	 *
	 * @param int $aid
	 * @return boolean
	 */
	public function deleteAnnounce($aid){
		return $this->_delete($aid);
	}
	
	/**
	 * 批量删除公告信息
	 *
	 * @param array $aids
	 * @return boolean
	 */
	public function batchDeleteAnnounce($aids){
        return $this->_batchDelete($aids);
	}
	
	/**
	 * 更新一条公告信息
	 * @param int $aid
	 * @param array $fields
	 * @return boolean
	 */
	public function updateAnnounce($aid, $fields){
		return $this->_update($aid, $fields);
	}
	
	/**
	 * 获取公告信息
	 *
	 * @param $offset
	 * @param $limit
	 * @return array
	 */
	public function getAnnounceOrderByVieworder($schoolid, $limit, $start)
	{
		if(!empty($schoolid))
		{
			$schoolcondition = "schoolid = ".$schoolid.' or schoolid = 0';
		}
		else
		{
			$schoolcondition = '1 = 1';	
		}

		$sql = $this->_bindSql('SELECT *, SUBSTRING(subject, 1, 12) as title 
								FROM %s 
								where %s
								ORDER BY vieworder ASC %s' ,
								$this->getTable(), 
								$schoolcondition,
								$this->sqlLimit($limit, $start));

		$smt = $this->getConnection()->query($sql);
		return $smt->fetchAll('aid');
	}
	
	/**
	 * 通过时间获取公告信息
	 * 业务为获取正在发布中的公告信息
	 *
	 * @param $time
	 * @param $offset
	 * @param $limit
	 * @return array
	 */
	public function getAnnounceByTimeOrderByVieworder($time, $limit, $offset){
		$sql = $this->_bindSql('SELECT * FROM %s WHERE start_date <= ? AND end_date >= ? ORDER BY vieworder ASC %s' ,$this->getTable(),$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($time, $time), 'aid');
	}
	
	
	/**
	 * 获取公告数
	 *
	 * @return int
	 */
	public function countCateWeek(){
		$sql = $this->_bindSql ( "SELECT COUNT(*) as count FROM %s ", $this->getTable());
		$smt = $this->getConnection()->query($sql);
		return $smt->fetchColumn();	
	}
	
	/**
	 * 获取某一时间内的公告数
	 * 业务为获取发布中公告的数量值
	 *
	 * @param int $time
	 * @return int
	 */
	public function countAnnounceByTime($time){
		$sql = $this->_bindSql ( "SELECT COUNT(*) as count FROM %s WHERE start_date <= ? AND end_date >= ? ", $this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue(array($time, $time));
	}

	/**
	 * 获取某一时间内的公告数
	 * 业务为获取发布中公告的数量值
	 *
	 * @return int
	 */
	public function countAnnounce()
	{
		$sql = $this->_bindSql ( "SELECT COUNT(*) as count FROM %s ", $this->getTable());
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->getValue();
	}
	
	/**
	 * 获取一条公告信息
	 * 
	 * @param int $aid
	 * @return array
	 */
	public function getAnnounce($aid){
		return $this->_get($aid);
	}

	/**
	 * 获取公告信息
	 * 
	 * @param int $schoolid
	 * @return array
	 */
	public function getAnnounceBySchoolId($schoolid, $time, $limit, $offset){
		$sql = $this->_bindSql('SELECT * FROM %s WHERE schoolid = ? AND start_date <= ? AND end_date >= ? ORDER BY vieworder ASC %s' ,$this->getTable(),$this->sqlLimit($limit, $offset));
		$smt = $this->getConnection()->createStatement($sql);
		return $smt->queryAll(array($schoolid, $time, $time));
	}

	/**
	 * 显示某个学校的公告
	 * 
	 * @param int $schoolid
	 * @return array
	 */
    public function getAnnouncePageTurn($schoolid, $aid, $pagetag)
    {
    	if($pagetag == 'next')
    	{
    		$idfilter = "aid".' > '. $aid." ORDER BY aid ASC"; 
    	}else{
    		$idfilter = "aid".' < '. $aid." ORDER BY aid DESC";
    	}
        $sql = $this->_bindSql('SELECT * FROM %s WHERE schoolid = ? AND '.$idfilter.'  %s', $this->getTable(), $this->sqlLimit(1));
        $smt = $this->getConnection()->createStatement($sql);
        return $smt->getOne(array($schoolid));
    }
	
}