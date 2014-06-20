<?php
Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');
class ContributeController extends T4BaseNotLoginController
{
    //投稿页面显示
    public function run()
    {
    	$schoolId = $this->getCurrentSchoolId();
    	$schoolNameList = $this->_getCateWeekReportDs()->getCurrentSchoolNameById($schoolId);

    	$this->setOutput($schoolNameList, 'schoolNameList');

        //SEO Information
        $SEOTitleKeyword = '美食达人 - '.$schoolNameList['name'].'美食天下，吃货, 美食网，小吃店，吃货俱乐部，美食文化，吃货网，小吃网，食谱';
        $this->setOutput($SEOTitleKeyword,'SEOTitle');
        $this->setOutput($SEOTitleKeyword,'SEOKeyword');
    }  

    private function _getCateWeekReportDs()
    {
        return Wekit::load('EXT:4tschool.service.cateweekreport.App_CateWeekReport');
    }

}