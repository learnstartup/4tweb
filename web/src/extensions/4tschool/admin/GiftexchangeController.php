<?php

Wind::import('EXT:4tschool.admin.T4AdminBaseController');
Wind::import('EXT:4tschool.service.giftexchange.dm.App_Giftexchange_Dm');

class GiftexchangeController extends T4AdminBaseController
{
    private $pageNumber = 10;

    private $_prize_arr = array
    (
        0=>array(
            'id'=>0,
            'name'=>'10元话费',
            'dmoney'=>100,
            'imgurl'=>'/themes/extres/4tschool/images/10yuan.jpg',
            'type'=>'V'
            ),
        1=>array(
            'id'=>1,
            'name'=>'20元话费',
            'dmoney'=>200,
            'imgurl'=>'/themes/extres/4tschool/images/20yuan.jpg',
            'type'=>'V'
            ),
        2=>array(
            'id'=>2,
            'name'=>'30元话费',
            'dmoney'=>300,
            'imgurl'=>'/themes/extres/4tschool/images/30yuan.jpg',
            'type'=>'V'
            )        
    );

    public function run()
    {
    	$giftExchangeInfo = $this->_getGiftExchange()->getAllGiftExchange($searchCondition,$start,$limit);

    	$this->setOutput($giftExchangeInfo, 'giftExchangeInfo');
    	$this->setOutput($this->_prize_arr, 'prizeInfo');
    }

    public function editAction()
    {
    	 date_default_timezone_set('PRC');

    	 list($id, $exchangesuccess, $exceptionexchange) = $this->getInput(array('id', 'exchangesuccess', 'exceptionexchange'));

    	 $oneGiftExchange = $this->_getGiftExchange()->getOneGiftExchange($id);
    	 
    	 if ($this->getInput('type', 'post') === 'do') 
    	 {

    	 	if ($exchangesuccess == $exceptionexchange) {
                $this->showError('不能存在两种是');
                return;
            }

    	 	$dm = new App_Giftexchange_Dm();
            $dm->setExchangeSuccess($exchangesuccess)
               ->setExceptionExchange($exceptionexchange)
               ->setUpdateTime(date("Y-m-d H:i:s"));
            $r = $this->_getGiftExchange()->update($id, $dm);
            if ($r == 1) {
                $this->showMessage('更新成功');
            } else {
                $this->showError('更新失败,请联系管理员');
            }
    	 }

    	 $this->setOutput($oneGiftExchange, 'oneGiftExchange');

    }

    /**
     * @return App_Giftexchange
     */
    private function _getGiftExchange()
    {
        return Wekit::load('EXT:4tschool.service.giftexchange.App_Giftexchange');
    }
      
}

?>      