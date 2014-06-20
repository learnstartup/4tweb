<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_cateweekreport - 数据服务接口
 */
class App_CateWeekReport
{

    public function getAllCateWeekReports($start, $limit)
    {
        return $this->loadDao()->getAllCateWeekReports($start, $limit);
    }

    /**
     * add record
     *
     * @param App_Cate_Week_Report_Dm $dm
     * @return multitype:|Ambigous <boolean, number, string, rowCount>
     */
    public function add(App_Cate_Week_Report_Dm $dm)
    {

        if (true !== ($r = $dm->beforeAdd())) return $r;
        return $this->loadDao()->add($dm->getData());
    }

    /**
     * update record
     *
     * @param App_Cate_Week_Report_Dm $dm
     * @return multitype:|Ambigous <boolean, number, rowCount>
     */
    public function update($id, App_Cate_Week_Report_Dm $dm)
    {
        if (true !== ($r = $dm->beforeUpdate())) return $r;
        return $this->loadDao()->update($id, $dm->getData());
    }

    public function getCateWeekReportById ($id){
        return $this->loadDao()->getCateWeekReportById($id);
    }

    public function getSearchCateWeekData ($searchCondition, $start, $limit){
        return $this->loadDao()->getSearchCateWeekData($searchCondition, $start, $limit);
    }

    public function countCateWeek ($searchCondition){
        return $this->loadDao()->countCateWeek($searchCondition);
    }

    public function getCurrentSchoolNameById ($schoolId){
        return $this->loadDao()->getCurrentSchoolNameById($schoolId);
    }

    public function getCakeWeekBySchoolId($schoolId, $start, $limit)
    {
        return $this->loadDao()->getCakeWeekBySchoolId($schoolId, $start, $limit);
    }

    public function countCakeWeekBySchoolId($schoolId)
    {
        return $this->loadDao()->countCakeWeekBySchoolId($schoolId);
    }

    public function get($id){
        return $this->loadDao()->get($id);
    }

    /**
     * @return App_CateWeekReport_Dao
     */
    private function loadDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.cateweekreport.dao.App_Cate_Week_Report_Dao');
    }
}