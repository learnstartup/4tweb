<?php
defined('WEKIT_VERSION') or exit(403);
Wind::import('EXT:4tschool.admin.T4AdminBaseController');
Wind::import('EXT:4tschool.service.push.dm.App_Push_Dm');

class PushController extends T4AdminBaseController 
{

	private $pageNumber = 10;
	
	public function run() 
	{
       $this->_setNavType('push');
       $allSchool = $this->_get4TSchoolDS()->getOpenedSchools();
       $allSchool = array_values($allSchool);  
       $pushTypeList = $this->setPushType();        

       $schoolid = -1;
       $type = -1;
       $status = -1;
       if ($this->getInput('submitype', 'post') === 'do') 
       {
          list($schoolid, 
               $type,
               $status) = $this->getInput(array('schoolid',
                                                'type', 
                                                'status'), 'post');
       }

       $page = $this->getInput('page');

       $searchCondition = array('schoolid' => $schoolid, 
                                'type' => $type, 
                                'status' => $status);
       $count =  $this->_getPushDs()->countPush($searchCondition);
       if (0 < $count) 
       {
         $totalPage = ceil($count/$this->pageNumber);
         $page > $totalPage && $page = $totalPage;
         list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

         if($page <= 0)
           $page =1;
       }

       $pushList = $this->_getPushDs()->getSearchPushData($searchCondition, 
        												  $start, 
        												  $limit);
       $pushList = array_values($pushList);

       // if ($this->getInput('pagerecord', 'get') == 'yes')
       // {
       // 	 list($hiddenschoolid, 
       //        $type,
       //        $status) = $this->getInput(array('hiddenschoolid',
       //                                         'type', 
       //                                         'status'), 'request');
       //         echo $hiddenschoolid;exit;
       // } 
       
       $this->setOutput($allSchool, 'allSchool');
       $this->setOutput($pushTypeList, 'pushTypeList');
       $this->setOutput($searchCondition, 'searchCondition');
       $this->setOutput($pushList, 'pushList');
       $this->setOutput($count, 'count');
       $this->setOutput($page, 'page');
       $this->setOutput($schoolid, 'schoolid');
       $this->setOutput($this->pageNumber, 'perPage');
	}

	public function addAction()
	{
	   if ($this->getInput('submitype', 'post') === 'do') 
	   {

            list($schoolid, 
                 $title, 
                 $type,
                 $content,
                 $status) = $this->getInput(array('schoolid',
                                                  'title', 
                                                  'type',
                                                  'content',
                                                  'status'), 'post');
            if (empty($schoolid)) {
                $this->showError('请选择高校.');
                return;
            }
            if (empty($title)) {
                $this->showError('请输入推送标题.');
                return;
            }
            if (empty($type)) {
                $this->showError('请选择推送类型.');
                return;
            }

            $dm = new App_Push_Dm();
			
            $dm->setSchoolId($schoolid)
               ->setType($type)
               ->setTitle($title)
               ->setContent($content)
               ->setStatus($status)
               ->setCreator($this->adminUser->username)
               ->setCreateDate($this->getCurrentDate())
               ->setUpdateDate($this->getCurrentDate());

            $id = $this->getInput('id');
            $id=$this->_getPushDs()->add($dm);

            if ($id > 0) 
            {
                $this->showMessage('添加成功');
            } 
            else 
            {
                $this->showError('添加失败,请联系管理员');
            }

        } 
        else 
        {
        	$id = $this->getInput('id');
        	$pushList = $this->_getPushDs()->getOnePushById($id);
          	$allSchool = $this->_get4TSchoolDS()->getOpenedSchools();
	        $allSchool = array_values($allSchool);
	        $pushTypeList = $this->setPushType();

            $this->setOutput($allSchool, 'allSchool');
       	    $this->setOutput($pushTypeList, 'pushTypeList');
       	    $this->setOutput($pushList, 'pushList');
        }
	}

	public function editAction()
	{
	   if ($this->getInput('submitype', 'post') === 'do') 
	   {

            list($schoolid, 
                 $title, 
                 $type,
                 $content,
                 $status) = $this->getInput(array('schoolid',
                                                  'title', 
                                                  'type',
                                                  'content',
                                                  'status'), 'post');
            if (empty($schoolid)) {
                $this->showError('请选择高校.');
                return;
            }
            if (empty($title)) {
                $this->showError('请输入推送标题.');
                return;
            }
            if (empty($type)) {
                $this->showError('请选择推送类型.');
                return;
            }

            $dm = new App_Push_Dm();
			
            $dm->setSchoolId($schoolid)
               ->setType($type)
               ->setTitle($title)
               ->setContent($content)
               ->setStatus($status)
               ->setCreator($this->adminUser->username)
               ->setUpdateDate($this->getCurrentDate());

            $id = $this->getInput('id');
            $id=$this->_getPushDs()->update($id, $dm);

            if ($id == 1) 
            {
                $this->showMessage('更新成功');
            } 
            else 
            {
                $this->showError('更新失败,请联系管理员');
            }

        } 
        else 
        {
        	$id = $this->getInput('id');
        	$pushList = $this->_getPushDs()->getOnePushById($id);
          $allSchool = $this->_get4TSchoolDS()->getOpenedSchools();
	        $allSchool = array_values($allSchool);
	        $pushTypeList = $this->setPushType();

          $this->setOutput($allSchool, 'allSchool');
     	    $this->setOutput($pushTypeList, 'pushTypeList');
     	    $this->setOutput($pushList, 'pushList');
        }
	}

	public function setPushType()
  {
      return $pushType = array("活动", "优惠", "消息");
  }

  public function getCurrentDate()
  {
  	 date_default_timezone_set('PRC');
 	   $currentdate = date('Y-m-d H:i:s');

 	   return $currentdate;
  }
	
	/**
	 * 加载PwPushService Service 服务
	 *
	 * @return PwPushService
	 */
	private function _getPwPushService() {
		return Wekit::load('push.srv.PwPushService');
	}
	
	/**
	 * 加载PwPush Ds 服务
	 *
	 * @return PwPush
	 */
	private function _getPwPushDs() {
		return Wekit::load('push.PwPush');
	}

	/**
	 * 加载PwPush Ds 服务
	 *
	 * @return PwPush
	 */
	private function _getPushDs() 
	{
		return Wekit::load('EXT:4tschool.service.push.App_Push');
	}

	/**
	 * 加载App_School Ds 服务
	 *
	 * @return App_School
	 */
	private function _getSchoolDS()
	{
		return Wekit::load('EXT:4tschool.service.school.App_School');
	}

	private function _get4TSchoolDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }
}