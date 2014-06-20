<?php

/**
 */
class ChooseController extends PwBaseController {

	public function beforeAction($handlerAdapter) {
		parent::beforeAction($handlerAdapter);

	}


	public function run()
	{
		$schoolid = $this->getInput("schoolid");
		if(!empty($schoolid))
		{
			$webstatus = $this->_getSchoolDS()->getWebSiteStatus($schoolid);
			
			if(!$webstatus)
			{	
				$webstatus = 'close';
				$this->setOutput($webstatus, 'webstatus');
				$this->setTemplate("ifopenwebsite");
			}
			else
			{
				header("Location:index.php?m=app&a=run&schoolid=".$schoolid."&app=4tschool");
			}
		}
	

	}

	private function _getSchoolAreaDS()
	{
		return Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea');
	}


	private function _getSchoolDS()
	{
		return Wekit::load('EXT:4tschool.service.school.App_School');
	}


}