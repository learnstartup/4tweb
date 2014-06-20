<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_SchoolArea- 数据服务接口
 *
 */
class App_School {

	public function validateAndForwardUrlForSchoolandLogin($needLogin,$userid,$newschoolId)
	{
		//check query string, if has schoolid, need to write that to cookie;
		$oldschoolId = $this->getCurrentSchoolId();

		if($newschoolId > 0)
		{
			//write cookie for new schoolid
			setcookie("schoolid", $newschoolId);
		}
		else if($oldschoolId <= 0)
		{
			//redirection
			return WindUrlHelper::createUrl('app/4tschool/choose/run');
		}

		if($needLogin && $userid <= 0)
		{
			$backUrl =   $_SERVER['REQUEST_URI'];
			return WindUrlHelper::createUrl('u/login/run',array('backurl' => $backUrl));
		}

		return '';

	}

	public function getCurrentSchoolId()
	{
		if($_REQUEST['schoolid'] > 0)
			return $_REQUEST['schoolid'];

		return $_COOKIE['schoolid'];
	}

	public function getOpenedSchools()
	{
		//retrive from database
		return $this->_loadSchoolExtraDao()->getOpenedSchools();
	}

	public function isSchoolOpenNow($schoolid)
	{
		$schoolSchedule = include Wind::getRealPath('ROOT:conf.schoolOpenSchedule.php', true);
		$dayofweek = strtolower(date("D"));

		$open = $schoolSchedule[$schoolid]["overall"];
		if($open != "open")
		{
			return false;
		}

		$info = $schoolSchedule[$schoolid][$dayofweek];


		if($info['open'])
		{
			$timeRanges = $info['openTime'];
			if(empty($timeRanges))
				return true; //如果不指定时间，则认为全天开放

			//check if current time is avaliable to open
			date_default_timezone_set("Asia/Shanghai");
			$currentTime = date("H:i:s");

			foreach ($timeRanges as $key => $eachRange) {
				
				if(($currentTime >= $eachRange['start'])
					&& ($currentTime <= $eachRange['end']))
				{
					return true;
				}
			}

		}
		else
		{
			return false;
		}

		return false;
	}

	//得到学校订餐时间
	public function getSchoolOpenTime($schoolid)
	{
		$schoolSchedule = include Wind::getRealPath('ROOT:conf.schoolOpenSchedule.php', true);
		$info = $schoolSchedule[$schoolid];

		return $info;
	}

	public function getWebSiteStatus($schoolid)
	{
		return $this->_loadSchoolExtraDao()->getWebSiteStatus($schoolid);
	}

	/*
	*
	*/
	public function getSchoolExtra($schoolid)
	{
		return $this->_loadSchoolExtraDao()->getSchoolExtra($schoolid);
	}


	/*
	*
	*/
	public function update($schoolid,$fields)
	{
		return $this->_loadSchoolExtraDao()->update($schoolid,$fields);
	}


	/**
	 * @return App_SchoolExtra_Dao
	 */
	private function _loadSchoolExtraDao() {
		return Wekit::loadDao('EXT:4tschool.service.school.dao.App_SchoolExtra_Dao');
	}


}

?>