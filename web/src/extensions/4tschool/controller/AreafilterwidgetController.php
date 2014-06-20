<?php

class AreafilterwidgetController extends PwBaseController {

	public function run() {
		$schoolId=80971;

		$areaList=$this->_getSchoolAreaDs()->getBySchoolid($schoolId);
		
		$this->setOutput($areaList,"areaList");	
	}
	
	private function _getSchoolAreaDs(){
		return Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea');
	}
}