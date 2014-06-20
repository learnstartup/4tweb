<?php
Wind::import('EXT:4tschool.admin.T4AdminBaseController');
class FirstOrderCheckController extends T4AdminBaseController
{

    public function run()
    {
        date_default_timezone_set('Asia/Shanghai');
        $today = date('Y-m-d H:i:s');

        echo "<pre/>";

        echo $today;echo "<br/>"; 

        $fromDateArray = getdate(strtotime($today));

        //start
        $start = mktime(0,0,0,$fromDateArray['mon'], $fromDateArray['mday'], $fromDateArray['year']);
        $start = date('Y-m-d H:i:s',$start);

        //end
        $end = mktime(23,59,59,$fromDateArray['mon'], $fromDateArray['mday'], $fromDateArray['year']);
        $end = date('Y-m-d H:i:s',$end);

        //list first order since 
        $data = $this->_getMyOrderDS()->getFirstOrderInRangeSinceDate($start,$end,1);
        header("Content-type: text/html; charset=utf-8");
        print_r($data);
        die;

    }


    /**
     * @return App_MyOrder
     */
    private function _getMyOrderDS()
    {
        return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
    }
}