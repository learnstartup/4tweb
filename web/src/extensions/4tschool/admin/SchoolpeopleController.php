<?php
Wind::import('WINDID:service.area.WindidArea');
Wind::import('EXT:4tschool.admin.T4AdminBaseController');
/**
 * 应用前台入口
 *
 */
class SchoolPeopleController extends T4AdminBaseController {

	private $pageNumber = 10;
	
	public function run() {
		$this->_setNavType('schoolpeople');

		$openSchools = 	$this->_getSchoolPeopleDS()->getByOpenSchool();
		$this->setOutput($openSchools,"openSchools");
	}

	public function peopleAction()
	{
		$schoolid = $this->getInput('schoolid', 'get');
		if(!isset($schoolid) || $schoolid<= 0)
		{
			$this->showError("无效的学校");
		}

		$type = $this->getInput('type','get');
		if(!isset($type) || $type == '' )
		{
			$this->showError("无效的类型参数,例如delivery,master");
		}
		switch($type)
		{
			case "master":
				$typename = "学校管理员";
				break;
			case "orderdispatch":
				$typename = "订单分配";
				break;
			case "delivery":
				$typename = "订单配送";
				break;
			case "areaorderget":
				$typename = "区域下订单人";
				break;
			case "shopaccount":
				$typename = "商家帐号列表";
				break;
			default:
				break;

		}

		//get order area from school
		$areaList = $this->_getSchoolAreaDS()->getBySchoolid($schoolid);
		$this->setOutput($areaList,"areaList");

		if("checkAndAdd" == $this->getInput("checkAndAdd"))
		{
			//get user name
			$username = $this->getInput("peoplename");
			if(empty($username))
			{
				$this->showError("请输入有效的帐号全名");
			}

			
			//check if it is valid user name
			$user = $this->_getUserDs()->getUserByName($username);
			if(empty($user) || count($user) ==0)
			{
				$this->showError("未找到此帐号");	
			}
			//add into table
			//if already added, then ignore	
			$userid = $user['uid'];


			$exists =  $this->_getSchoolPeopleDS()->checkIfExists($schoolid,$userid,$type,0);
			$message = "不能添加重复项";

			if(!$exists)
			{
				Wind::import('EXT:4tschool.service.schoolpeople.dm.App_SchoolPeople_Dm');
				$dm = new App_SchoolPeople_Dm();
				$dm->setSchool($schoolid)
				->setUserid($userid)
				->setAreaId($areaid)
				->setType($type);

				$this->_getSchoolPeopleDS()->addSchoolUser($dm);
			}
			else
			{
				$this->showError($message);
			}
		}

		if("deleteSelected" == $this->getInput("deleteSelected"))
		{
			$checkedItems = $this->getInput("checkItem");
			$itemArray = $this->getInput("eachItem");


			foreach($checkedItems as $checkKey => $checkValue)
			{
				if($checkValue)
				{
					$id = $checkValue;	
					//delete based on id
					$this->_getSchoolPeopleDS()->delete($id);	
				}
			}
		}

		$this->setOutput($schoolid,"schoolid");
		$this->setOutput($type,"type");
		$this->setOutput($typename,"typename");
		
		//get school information
		$schoolInfo = $this->_getSchoolDs()->getSchool($schoolid);
		$this->setOutput($schoolInfo,"schoolInfo");

		$ppls = $this->_getSchoolPeopleDS()->getSchoolPeople($schoolid,$type);
		$this->setOutput($ppls,"ppls");
		
	}

	public function groupAction()
	{
		$schoolid = $this->getInput('schoolid', 'get');
		if(!isset($schoolid) || $schoolid<= 0)
		{
			$this->showError("无效的学校");
		}

		$type = $this->getInput('type','get');
		if(!isset($type) || $type == '' )
		{
			$this->showError("无效的类型参数,例如delivery,master");
		}

		$this->setOutput($schoolid,"schoolid");
		$this->setOutput($type,"type");
		$this->setOutput($typename,"typename");

		

		if("addGroup" == $this->getInput("addGroup"))
		{
			$groupName = $this->getInput("groupname");
			if(empty($groupName))
			{
				$this->showError("组名不能为空");
			}

			$leaderId = $this->getInput("leader");
			if($leaderId <= 0)
			{
				$this->showError("必须选择一个组长");
			}

			//check 重复项
			$exists =  $this->_getSchoolGroupDS()->checkIfExists($schoolid,$groupName,$type,0);
			$message = "不能添加重复项";

			if($exists)
				$this->showError($message);

			//add the group and leader
			Wind::import('EXT:4tschool.service.schoolgroup.dm.App_SchoolGroup_Dm');
				$dm = new App_SchoolGroup_Dm();
				$dm->setSchool($schoolid)
				->setName($groupName)
				->setLeaderId($leaderId)
				->setType($type);

			$this->_getSchoolGroupDS()->addSchoolGroup($dm);
		}

		if("deleteSelected" == $this->getInput("deleteSelected"))
		{
			$checkedItems = $this->getInput("checkItem");
			$itemArray = $this->getInput("eachItem");


			foreach($checkedItems as $checkKey => $checkValue)
			{
				if($checkValue)
				{
					$id = $checkValue;	
					//delete based on id
					$this->_getSchoolGroupDS()->delete($id);	
				}
			}
		}

		//get school information
		$schoolInfo = $this->_getSchoolDs()->getSchool($schoolid);
		$this->setOutput($schoolInfo,"schoolInfo");

		$ppls = $this->_getSchoolPeopleDS()->getSchoolPeople($schoolid,'delivery');
		$this->setOutput($ppls,"ppls");

		//get school group
		$groups  = $this->_getSchoolGroupDS()->getSchoolGroup($schoolid,'delivery');
		$this->setOutput($groups,'groups');


	}

	public function peopleingroupAction()
	{
		$schoolid = $this->getInput('schoolid', 'get');
		if(!isset($schoolid) || $schoolid<= 0)
		{
			$this->showError("无效的学校");
		}

		//get school information
		$schoolInfo = $this->_getSchoolDs()->getSchool($schoolid);
		$this->setOutput($schoolInfo,"schoolInfo");

		//all delivery ppls
		$deliveryppls = $this->_getSchoolPeopleDS()->getSchoolPeople($schoolid,'delivery');
		//得到所有不在配送组里面的人
		$pplsNotinGroup = $this->_getSchoolGroupDS()->getPeopleNotInGroup($schoolid,'delivery');
		foreach($deliveryppls as $key => &$eachppl)
		{
			$notin = false;
			foreach($pplsNotinGroup as $key1 => $eachppl1)
			{
				if($eachppl['userid'] == $eachppl1['userid'])
				{
					$notin = true;
					break;
				}
			}

			$eachppl['notin'] = $notin;

		}

		$this->setOutput($deliveryppls,"deliveryppls");

		//get school group
		$groups  = $this->_getSchoolGroupDS()->getSchoolGroup($schoolid,'delivery');
		$this->setOutput($groups,'groups');

		$pplsinGroup = $this->_getSchoolGroupDS()->getPeopleInGroup($schoolid,'delivery');
		$this->setOutput($pplsinGroup,'pplsingroup');

	}

	//ajax action
	//save relationship
	public function savepeopleingroupAction()
	{
		$returnData = array(
			"success"	=> true,
			"data"	=> "Success"
			);

		$relationshiptosave = $this->getInput("relationshiptosave");
		$relationshiptodelete = $this->getInput("relationshiptodelete");

		//先处理删除的关系
		$deletePeopleInGroups = explode(";",$relationshiptodelete);
		foreach($deletePeopleInGroups as $key => $eachPair)
		{
			$groupandpeople = explode(":", $eachPair);
			$groupid = $groupandpeople[0];
			$peopleids = $groupandpeople[1];

			$peopleIdArray = explode(",",$peopleids);

			foreach($peopleIdArray as $key1 => $peopleId)
			{
				if($groupid > 0 && $peopleId > 0)
				{
					$this->_getSchoolGroupDS()->deletePeopleInGroup($groupid,$peopleId);
				}
			}
		}

		//再处理保存的关系
		$savePeopleInGroups = explode(";",$relationshiptosave);
		foreach($savePeopleInGroups as $key => $eachPair)
		{
			$groupandpeople = explode(":", $eachPair);
			$groupid = $groupandpeople[0];
			$peopleids = $groupandpeople[1];

			$peopleIdArray = explode(",",$peopleids);

			foreach($peopleIdArray as $key1 => $peopleId)
			{
				if($groupid > 0 && $peopleId > 0)
				{
					$this->_getSchoolGroupDS()->addPeopleInGroup($groupid,$peopleId);
				}
			}
		}


		print_r(json_encode($returnData));
		die;

	}

	public function setupAction()
	{
		$schoolid = $this->getInput('schoolid', 'get');
		if(!isset($schoolid) || $schoolid<= 0)
		{
			$this->showError("无效的学校");
		}
		$this->setOutput($schoolid,'schoolid');

		if('do' == $this->getInput("type"))
		{
			$schoolopen = $this->getInput("schoolopen");
			$openorder = $this->getInput("orderopen");
			$openmap = $this->getInput("openmap");
			$openshundai = $this->getInput("shundaiopen");
			$shundaiid = $this->getInput("shundaiid");
			$openwallet = $this->getInput("walletopen");
			$openliuyanban = $this->getInput("liuyanbanopen");
			$openwebsite = $this->getInput("openwebsite");
			$opencombo = $this->getInput("opencombo");
			$openclassannounce = $this->getInput("openclassannounce");
			$schlatitude = $this->getInput("schlatitude");
			$schlongitude = $this->getInput("schlongitude");
			$abbreviation = $this->getInput("abbreviation");

			$fields['opened'] = $schoolopen;
			$fields['openorder'] = $openorder;
			$fields['openmap'] = $openmap;
			$fields['openshundai'] = $openshundai;
			$fields['openwallet'] = $openwallet;
			$fields['shundaiid'] = $shundaiid;
			$fields['openliuyanban'] = $openliuyanban;
			$fields['openwebsite'] = $openwebsite;
			$fields['opencombo'] = $opencombo;
			$fields['openclassannounce'] = $openclassannounce;
			$fields['schlatitude'] = $schlatitude;
			$fields['schlongitude'] = $schlongitude;
			$fields['abbreviation'] = $abbreviation;

			$this->_get4TSchoolDS()->update($schoolid,$fields);

			//get school information
			$schoolExtra = $this->_get4TSchoolDS()->getSchoolExtra($schoolid);
			$this->setOutput($schoolExtra[0],"schoolExtra");

			$this->showMessage("保存成功");

		}

		//get school information
		$schoolExtra = $this->_get4TSchoolDS()->getSchoolExtra($schoolid);
		$this->setOutput($schoolExtra[0],"schoolExtra");
		

	}

	private function _getSchoolPeopleDS()
	{
		return Wekit::load('EXT:4tschool.service.schoolpeople.App_SchoolPeople');
	}

	private function _getSchoolGroupDS()
	{
		return Wekit::load('EXT:4tschool.service.schoolgroup.App_SchoolGroup');
	}

	private function _getSchoolDs()
	{
		return Wekit::load('WINDID:service.school.WindidSchool');
	}

	private function _get4TSchoolDS()
	{
		return Wekit::load('EXT:4tschool.service.school.App_School');
	}

	private function _getSchoolAreaDS()
	{
		return Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea');
	}

	private function _getUserDs(){
		return Wekit::load('user.PwUser');
	}

}

?>