<?php
defined('WEKIT_VERSION') or exit(403);

class App_OrderSequence_Dao extends PwBaseDao {
	
	/**
	 * primary key
	 */
	protected $_pk = 'id';

	/**
	 * table name
	 */
	protected $_table = '4t_order_sequence';
	
	/**
	 * table fields
	 */
	protected $_dataStruct = array('id', 'orderid', 'createdat');
	

	public function add($fields) {
		
		return $this->_add($fields, true);
	}

	public function resetSequence()
	{
		$sql = "DROP TABLE IF EXISTS `pw_4t_order_sequence`;
				CREATE TABLE IF NOT EXISTS `pw_4t_order_sequence` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `orderid` int(11) NOT NULL,
				  `createdat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				  PRIMARY KEY (`id`),
				  UNIQUE KEY `orderid` (`orderid`)
				) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
		$smt = $this->getConnection()->createStatement($sql);

        return $smt->execute();
		
	}

}

?>