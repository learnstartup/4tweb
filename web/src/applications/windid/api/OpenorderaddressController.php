<?php
Wind::import('APPS:windid.api.OpenBaseController');
/**
 * the last known user to change this file in the repository  <$LastChangedBy: Peter.yan $>
 * @author $Author: Peter.yan $ 215169718@qq.com
 * @copyright ?2003-2103 fenxiangyo.com
 * @license http://www.fenxiangyo.com
 * @package
 */
class OpenOrderAddressController extends OpenBaseController
{

    //my order address list based on userid
    public function getMyAddressAction()
    {
        $userid = $this->getInput('userid','get');

        if(empty($userid))
        {
            $this->output(-1);
            return;
        }

        $result = $this->_getMyOrderAddressDS()->getOrderAddress($userid);
        $this->output($result);
    }

    //create order address based userid
    public function addorUpdateOrderAddressAction()
    {
        $userid = $this->getInput('userid','get');
        $rname = $this->getInput('rname','get');
        $raddress = $this->getInput('raddress','get');
        $rphone = $this->getInput('rphone','get');
        $id = $this->getInput('id','get');

        $result = array(
                         "Success" => false,
                         "Message" => ""

                );

        if(empty($userid) || empty($rname) || empty($raddress) || empty($rphone))
        {
            $result['Success'] = false;
            $result['Message'] = "数据不能为空";

            $this->output($result);
            return;
        }

        $affected = $this->_getMyOrderAddressDS()->addorUpdateOrderAddress($id,$userid,$rname,$raddress,$rphone);
        if($affected > 0)
        {
            $result['Success'] = true;
            $result['Message'] = "操作成功";

            if($id <= 0)
            {
                $result['Id'] = $affected;
            }
            else
                $result['Id'] = $id;
        }
        else
        {
            $result['Success'] = false;
            $result['Message'] = "插入失败,请检查是否有重复的数据";
        }
        
        $this->output($result);
    }

    
    /**
     * @return App_MyOrder
     */
    private function _getMyOrderDS()
    {
        return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
    }

    /**
     * @return App_MyOrder
     */
    private function _getMyOrderAddressDS()
    {
        return Wekit::load('EXT:4tschool.service.orderaddress.App_OrderAddress');
    }

}

?>