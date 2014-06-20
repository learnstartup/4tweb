<?php

/**
 */
class T4BaseController extends PwBaseController
{
    protected $jcart;

    protected $schoolExtra;

    public function beforeAction($handlerAdapter)
    {
        parent::beforeAction($handlerAdapter);

        $newschoolId = $this->getInput("schoolid");
        $url = $this->_getSchoolDS()->validateAndForwardUrlForSchoolandLogin(false, $this->loginUser->uid, $newschoolId);

        if (!empty($url)) {
            $this->forwardRedirect($url);
        }

        ($currentSchoolId = $this->getCurrentSchoolId()) || ($currentSchoolId = $this->getInput("schoolid"));

        //get school name and related information, then do output
        $schoolInfo = $this->_getSchoolDS()->getSchoolExtra($currentSchoolId);

        if (empty($schoolInfo)) {
            //choose school
            $this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/choose/run'));
        } else {

            $this->schoolExtra = $schoolInfo[0];
            $this->setOutput($schoolInfo[0], 'schoolInfo');
        }

        $userid = $this->loginUser->uid;
        if ($userid == 0) {
            $backUrl = $_SERVER['REQUEST_URI'];
            $this->forwardRedirect(WindUrlHelper::createUrl('u/login/run', array('backurl' => $backUrl)));
        }

        $userInfo = $this->loginUser;
        $this->setOutput($userInfo, "loginUser");

        //set the number of header cart
        include_once('jcart-1.3/jcart/jcart.php');
        $url = WindUrlHelper::createUrl('app/4tschool/index/run');
        $jcart->set_redirect_url($url);
        $itemCount = $jcart->get_count();
        $this->jcart = $jcart;
        $this->setOutput($itemCount, 'itemCount');

        //set the search part info
        $searchArgs['type'] = is_null($this->getInput('type')) ? null : $this->getInput('type');
        $searchArgs['keyword'] = is_null($this->getInput('keyword')) ? null : $this->getInput('keyword');
        $searchArgs['target'] = is_null($searchArgs['type']) ? 'merchandiselist' : $searchArgs['type'] == 'm' ? 'merchandiselist' : 'shoplist';
        $this->setOutput($searchArgs, 'searchArgs');

        //set hotsearches
        $hotSearches = $this->_getHotSearchDS()->getHotSearchBySchool($currentSchoolId);
        foreach($hotSearches as $key => &$eachSearch)
        {
            $eachSearch['link'] = ($eachSearch['type'] == 'm'?WindUrlHelper::createUrl('app/4tschool/merchandiselist/run'):WindUrlHelper::createUrl('app/4tschool/shoplist/run'));
        }

        $this->setOutput($hotSearches, 'hotsearches');
    }

    protected function getDomain()
    {
        $serverHost = $_SERVER['HTTP_HOST'];
        $parsedInfo = parse_url($serverHost);
        $scheme =  empty($parsedInfo['scheme'])?"http":$parsedInfo['scheme'];
        $path =  $parsedInfo['path'];
        $host =  $parsedInfo['host'];
        $port =  $_SERVER['SERVER_PORT'] == "80"?"":$_SERVER['SERVER_PORT'];

        $baseUrl =  $scheme.'://'.$host.(empty($port)?"":":".$port).$path;

        return $baseUrl . '/src/extensions/4tschool';
    }

    protected function getCartRelayPath()
    {
        return "/controller/jcart-1.3/jcart/relay.php";
    }

    protected function getIncidentallyShopId()
    {
        if($this->schoolExtra['openshundai'] == 1)
            return $this->schoolExtra['shundaiid'];
        
        return -1;
    }

    protected function getIncidentallyTagId()
    {
        return implode(',', array(33, 34, 35, 36));
    }

    protected function getCurrentSchoolId()
    {
        if ($_REQUEST['schoolid'] > 0)
            return $_REQUEST['schoolid'];

        return $_COOKIE['schoolid'];
    }

    protected function stringToDateLowerest($fromTime)
    {
        $fromDateArray = getdate(strtotime($fromTime));
        $fromTime = mktime(0, 0, 0, $fromDateArray['mon'], $fromDateArray['mday'], $fromDateArray['year']);

        return date('Y-m-d H:i:s', $fromTime);
    }

    protected function stringToDateBiggest($toTime)
    {
        $toDateArray = getdate(strtotime($toTime));
        $toTime = mktime(23, 59, 59, $toDateArray['mon'], $toDateArray['mday'], $toDateArray['year']);

        return date('Y-m-d H:i:s', $toTime);
    }

    private function _getSchoolDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }

    private function _getHotSearchDS()
    {
        return Wekit::load('EXT:4tschool.service.searches.App_HotSearch');
    }


}