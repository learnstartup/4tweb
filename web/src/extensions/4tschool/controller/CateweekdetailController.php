<?php
Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');
Wind::import('EXT:4tschool.service.cateweekreport.dm.App_Cate_Week_Report_Dm');

class CateweekdetailController extends T4BaseNotLoginController
{

	private $pageNumber = 5;

	//显示具体的美食周报
  public function run()
  {
  	list($id) = $this->getInput(array('id'), 'request');
  	
  	$oneCateWeekList = $this->_getCateWeekReportDs()->getCateWeekReportById($id);

  	$schoolId = $this->getCurrentSchoolId();
  	$schoolNameList = $this->_getCateWeekReportDs()->getCurrentSchoolNameById($schoolId);

  	$this->setOutput($oneCateWeekList,"oneCateWeekList");
  	$this->setOutput($schoolNameList['name'],"schoolname");
  	
  }

  public function allistAction()
  {
  	$page = $this->getInput('page');
  	$schoolId = $this->getCurrentSchoolId();

    $schoolName = $this->setAreaFilterWidgetData();

    $count = $this->_getCateWeekReportDs()->countCakeWeekBySchoolId($schoolId);
    if (0 < $count) 
    {
      $totalPage = ceil($count/$this->pageNumber);
      $page > $totalPage && $page = $totalPage;
      list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

      if($page <= 0)
        $page =1;
    }


  	$allCateWeekList = $this->_getCateWeekReportDs()->getCakeWeekBySchoolId($schoolId, $start, $limit);

  	foreach ($allCateWeekList as $key => $value) 
    {
    		$date = substr($value['releasedate'], 0, 10);
    		$allCateWeekList[$key]['date'] = $date;
    		$allCateWeekList[$key]['imageurl'] = 'src/extensions/4tschool'. str_replace('\\', '/', $value['breviaryphoto']);
    }
      
  	$this->setOutput($allCateWeekList, "allCateWeekList");

  	$this->setOutput($count, 'count');  
    $this->setOutput($page, 'page');
    $this->setOutput($this->pageNumber, 'perPage'); 
    $this->setOutput($schoolId, 'schoolId'); 

    //SEO Information
    $SEOTitleKeyword = '美食文章 - '.$schoolName.'美食外卖';
    $this->setOutput($SEOTitleKeyword,'SEOTitle');
    $this->setOutput($SEOTitleKeyword,'SEOKeyword');
  }

  public function previewAction()
  {
    $id = $this->getInput('id');
    $cateweekreport = $this->_getCateWeekReportDs()->get($id);
    $cateweekreport['breviaryphoto'] = 'src/extensions/4tschool'. str_replace('\\', '/', $cateweekreport['breviaryphoto']);
    $this->setOutput($cateweekreport,'cateweekreport');
  }

  private function setAreaFilterWidgetData()
  {
      $schoolId = $this->getCurrentSchoolId();

      $areaList = $this->_getSchoolAreaDs()->getBySchoolid($schoolId);

      $schoolName = $areaList[0]['name'];

      return $schoolName;
  }

  /**
   * @return App_Cate_Week_Report
   */
  private function _getCateWeekReportDs()
  {
      return Wekit::load('EXT:4tschool.service.cateweekreport.App_CateWeekReport');
  }

  private function _getSchoolAreaDs()
  {
      return Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea');
  }

}