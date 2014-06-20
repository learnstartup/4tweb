<?php
/**
 *重设订单流水号
 */
Wind::import('SRV:cron.srv.base.AbstractCronBase');

class PwCronDoResetOrderNumber extends AbstractCronBase{
	
	public function run($cronId) {
		
		$this->_getMyOrderDS()->resetSequence();die;
	}

	/**
     * @return App_MyOrder
     */
	private function _getMyOrderDS()
	{
		return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
	}
}
?>