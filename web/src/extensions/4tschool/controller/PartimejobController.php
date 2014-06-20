<?php
Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');

class PartimejobController extends T4BaseNotLoginController
{
 	//赚钱页面显示
    public function run()
    {
    	$schoolId = $this->getCurrentSchoolId();
    	$schoolNameList = $this->_getCateWeekReportDs()->getCurrentSchoolNameById($schoolId);

        $serverClassList = array("电脑及电脑维修店",
                                 "手机贴膜店",
                                 "水果店",
                                 "礼品店",
                                 "奶茶店",
                                 "小超市",
                                 "零食店",
                                 "快递接单店",
                                 "KTV快接店");
    	$this->setOutput($schoolNameList, 'schoolNameList');
        $this->setOutput($serverClassList, 'serverClassList');

        //SEO Information
        $SEOTitleKeyword = '赚人生第一桶金 - '.$schoolNameList['name'].'兼职网，赚钱，创业网，校园代理，学生兼职，外卖网';
        $this->setOutput($SEOTitleKeyword,'SEOTitle');
        $this->setOutput($SEOTitleKeyword,'SEOKeyword');
    }

    private function _getCateWeekReportDs()
    {
        return Wekit::load('EXT:4tschool.service.cateweekreport.App_CateWeekReport');
    }
    
}