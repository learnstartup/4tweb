<?php
class qq_oauth_dao extends PwBaseDao {
	
	protected $_table = 'plugin_qq_login';
	protected $_pk = 'qid';
	protected $_dataStruct = array('qid', 'uid', 'access_token', 'nickname', 'avatar', 'gender', 'vip', 'level', 'is_yellow_year_vip', 'openid');
	
	public function count() {
		$sql = $this->_bindSql('SELECT count(*) FROM %s', $this->getTable());
		return $this->getConnection()->createStatement($sql)->getValue();
	}

	public function getList($limit, $offset = 0) {
		$sql = $this->_bindSql('SELECT * FROM %s ORDER BY utime DESC %s', $this->getTable(), $this->sqlLimit($limit, $offset));
		return $this->getConnection()->createStatement($sql)->queryAll();
	}

	public function getOne($openid){
		$sql = $this->_bindSql('SELECT * FROM %s WHERE openid = \'%s\'', $this->getTable(), $openid);
		return $this->getConnection()->createStatement($sql)->query()->fetch();
	}
	public function add($uid, $access_token, $nickname, $avatar, $gender, $vip, $level, $is_yellow_year_vip,$openid) {
		$sql = $this->_bindSql('INSERT INTO %s(uid,access_token,nickname,avatar,gender,vip,level,is_yellow_year_vip,openid) VALUES (\'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\')', $this->getTable(), $uid, $access_token, $nickname, $avatar, $gender, $vip, $level, $is_yellow_year_vip,$openid);
		return $this->getConnection()->createStatement($sql)->query();
	}
	
}