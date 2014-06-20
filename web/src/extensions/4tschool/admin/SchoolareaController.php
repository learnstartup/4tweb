<?php
Wind::import('WINDID:service.area.WindidArea');
Wind::import('EXT:4tschool.service.schoolarea.dm.App_SchoolArea_Dm');
Wind::import('EXT:4tschool.admin.T4AdminBaseController');
/**
 * 应用前台入口
 *
 */
class SchoolAreaController extends T4AdminBaseController
{

    private $pageNumber = 10;

    public function run()
    {
        $this->_setNavType('schoolarea');

        $allArea = $this->_getAreaDs()->getAreaByParentid(0);
        $allArea = array_values($allArea);

        //check if has province id or not, if has, then school list need to based on that
        //get province from url
        $choosenProvinceid = $this->getInput('choosenProvinceid');
        if (!isset($choosenProvinceid) || $choosenProvinceid <= 0) {
            $choosenProvinceid = $allArea[0]['areaid'];
        }

        $allSchool = $this->_getSchoolDs()->getSchoolByAreaidAndTypeid($choosenProvinceid, 3);
        $allSchool = array_values($allSchool);
        $this->setOutput($allSchool, 'allSchool');

        $choosenSchoolid = $this->getInput('choosenSchoolid');
        if (!isset($choosenSchoolid) || $choosenSchoolid <= 0) {
            $choosenSchoolid = $allSchool[0]['schoolid'];
        }

        //check if it is from search, if from search, then search by selected university
        if ($this->getInput('search', 'post') === 'search') {
            $choosenSchoolid = $this->getInput('choosenSchoolid', 'post');
            $areaList = $this->_getSchoolAreaDs()->getBySchoolid($choosenSchoolid);

            $choosenProvinceid = $this->getInput('choosenProvinceid', 'post');

        } else {
            //get first school and show its area
            Wind::import('EXT:4tschool.service.dm.App_SchoolArea_Dm');
            $areaList = $this->_getSchoolAreaDs()->getBySchoolid($choosenSchoolid);
            //print_r($areaList);die;

        }

        $this->setOutput($choosenProvinceid, 'choosenProvinceid');
        $this->setOutput($choosenSchoolid, 'choosenSchoolid');
        $this->setOutput($areaList, 'areaList');
        $this->setOutput($allArea, 'allArea');

    }

    public function addAction()
    {
        $choosenSchoolid = $this->getInput('choosenSchoolid', 'request');
        $choosenProvinceid = $this->getInput('choosenProvinceid', 'request');

        //click submit, then get informaiton
        if ($this->getInput('type', 'post') === 'do') {
            //1. get choosen schoolid
            //$choosenSchoolid  = $this->getInput('school', 'post');
            $areaName = $this->getInput('areaname', 'post');

            //check areaname, it can't be null
            if (empty($areaName)) {
                $this->showError('请输入学校区域的名字');
                return;
            } else {
                //check if has duplicate name in database
                $hasDuplicate = $this->_getSchoolAreaDs()->checkDuplicateName(0, $choosenSchoolid, $areaName);
                if ($hasDuplicate) {
                    $this->showError('此区域的名字在该学校下已经被使用了');
                    return;
                }

                $dm = new App_SchoolArea_Dm();
                $dm->setArea($areaName)
                    ->setSchool($choosenSchoolid);

                $this->_getSchoolAreaDs()->add($dm);

                $this->showMessage('创建成功');
            }

        } else {

            $allSchool = $this->_getSchoolDs()->getSchoolByAreaidAndTypeid($choosenProvinceid, 3);
            $this->setOutput($allSchool, 'allSchool');
        }

        $this->setOutput($choosenProvinceid, 'choosenProvinceid');
        $this->setOutput($choosenSchoolid, 'choosenSchoolid');

    }

    public function editAction()
    {
        $choosenSchoolid = $this->getInput('choosenSchoolid', 'request');
        $choosenProvinceid = $this->getInput('choosenProvinceid', 'request');
        $id = $this->getInput('id', 'request');

        if ($this->getInput('type', 'post') === 'do') {
            //user click submit
            //1. get choosen schoolid
            $areaName = $this->getInput('areaname', 'post');

            if ($id <= 0) {
                $this->showError('无效的id, 请核实' . $id . $areaName . $choosenSchoolid);
                return;
            }

            if (empty($areaName)) {
                $this->showError('请填写学校的区域的名字');
                return;
            }

            //check if has duplicate name in database
            $hasDuplicate = $this->_getSchoolAreaDs()->checkDuplicateName($id, $choosenSchoolid, $areaName);
            if ($hasDuplicate) {
                $this->showError('此区域的名字在该学校下已经被使用了');
                return;
            }

            $dm = new App_SchoolArea_Dm();
            $dm->setArea($areaName)
                ->setSchool($choosenSchoolid);
            $this->_getSchoolAreaDs()->updateArea($id, $dm);
            $this->showMessage('更新成功');

        } else {
            $id = $this->getInput('id', 'request');
            $this->setOutput($id, 'id');

            $areaInfo = $this->_getSchoolAreaDs()->getByid($id);
            if (count($areaInfo) > 0) {
                $this->setOutput($areaInfo[0], 'areainfo');
            }

            $allSchool = $this->_getSchoolDs()->getSchoolByAreaidAndTypeid($choosenProvinceid, 3);
            $this->setOutput($allSchool, 'allSchool');
        }

        $this->setOutput($choosenProvinceid, 'choosenProvinceid');
        $this->setOutput($choosenSchoolid, 'choosenSchoolid');
    }


    /**
     * 获得windid的地区DS
     *
     * @return WindidArea
     */
    private function _getAreaDs()
    {
        return Wekit::load('WINDID:service.area.WindidArea');
    }

    /**
     * @return WindidSchool
     */
    private function _getSchoolDs()
    {
        return Wekit::load('WINDID:service.school.WindidSchool');
    }

    /**
     * @return App_SchoolArea
     */
    private function _getSchoolAreaDs()
    {
        return Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea');
    }
}

?>