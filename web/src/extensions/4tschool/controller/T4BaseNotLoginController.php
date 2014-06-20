<?php

/**
 */
class T4BaseNotLoginController extends PwBaseController
{

    protected $jcart;

    protected $schoolExtra;
    

    public function beforeAction($handlerAdapter)
    {
        parent::beforeAction($handlerAdapter);

        //set the number of header cart
        include_once('jcart-1.3/jcart/jcart.php');
        $url = WindUrlHelper::createUrl('app/4tschool/index/run');
        if ($this->isSameSchool()==false) {
            $jcart->empty_cart();
        }
        $jcart->in_order_preview(false);
        $jcart->set_redirect_url($url);
        $itemCount = $jcart->get_count();
        $this->jcart = $jcart;
        $this->setOutput($itemCount, 'itemCount');        

        $newschoolId = $this->getInput("schoolid");
        $url = $this->_getSchoolDS()->validateAndForwardUrlForSchoolandLogin(false, $this->loginUser->uid, $newschoolId);

        if (!empty($url)) {
            $this->forwardRedirect($url);
        }


        ($currentSchoolId = $this->getCurrentSchoolId()) || ($currentSchoolId = $this->getInput("schoolid"));

        //get school name and related information, then do output
        $schoolInfo = $this->_getSchoolDS()->getSchoolExtra($currentSchoolId);

        if (empty($schoolInfo)) {

            $wechatId = $this->getInput("openId");
            if(isset($wechatId) && empty($wechatId) == false && $this->is_weixin() == true)
            {
                $this->forwardRedirect(WindUrlHelper::createUrl('app/4tmobile/mobileschool/run',array('openId'=>$wechatId)));
            }
            else
            {
                //choose school
                $this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/choose/run'));
            }
        } else {

            //check if school opened or not
            if ($schoolInfo[0]['opened'] == 0) {
                //not opened school, redirect to another page
                $this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/notopen/run'));
            }

            $this->schoolExtra = $schoolInfo[0];

            $this->setOutput($schoolInfo[0], 'schoolInfo');
        }

        //set the search part info
        $searchArgs['type'] = is_null($this->getInput('type','get')) ? null : $this->getInput('type','get');
        $searchArgs['keyword'] = is_null($this->getInput('keyword')) ? null : $this->getInput('keyword');
        $searchArgs['target'] = is_null($searchArgs['type']) ? 'merchandiselist' : $searchArgs['type'] == 'm' ? 'merchandiselist' : 'shoplist';
        $searchArgs['orderby'] = is_null($this->getInput('orderby')) ? null : $this->getInput('orderby');
        $searchArgs['sort'] = is_null($this->getInput('sort')) ? null : $this->getInput('sort');
        $this->setOutput($searchArgs, 'searchArgs');        

        //set hotsearches
        $hotSearches = $this->_getHotSearchDS()->getHotSearchBySchool($currentSchoolId);
        foreach($hotSearches as $key => &$eachSearch)
        {
            $eachSearch['link'] = ($eachSearch['type'] == 'm'?WindUrlHelper::createUrl('app/4tschool/merchandiselist/run'):WindUrlHelper::createUrl('app/4tschool/shoplist/run'));
        }
        $this->setOutput($hotSearches, 'hotsearches');

        //set hotsearches
        $hotads = $this->_getHotSearchDS()->getHotAdBySchool($currentSchoolId);
        $this->setOutput($hotads, 'hotads');

        $SEOInfo = $this->getSEOInfo();
        $this->setOutput($SEOInfo['SEOTitle'],'SEOTitle');
        $this->setOutput($SEOInfo['SEOKeyword'],'SEOKeyword');
        $this->setOutput($SEOInfo['SEODescription'],'SEODescription');

        //set 公告 in top header, shows like a notification
        //check if current time is avaliable to open
        date_default_timezone_set("Asia/Shanghai");
        $currentTime = time();//date("Y-m-d H:i:s");

        //有效的公告
        $announceList = $this->_getPwAnnounceDs()->getAnnounceByTimeOrderByVieworder($currentTime);
        $topAnn = null;

        foreach ($announceList as $key => $eachAnn) {
            
            if($eachAnn['schoolid'] == $schoolInfo[0]['schoolid'])
            {
                $topAnn = $eachAnn;
                break;
            }

        }

        $this->setOutput($topAnn,"topAnn");

    }

    public function getSEOInfo()
    {

        ($currentSchoolId = $this->getCurrentSchoolId()) || ($currentSchoolId = $this->getInput("schoolid"));

        $subject = '点餐哟开源外卖平台 - ';

        //get school name and related information, then do output
        $schoolInfo = $this->_getSchoolDS()->getSchoolExtra($currentSchoolId);

         //SEO
        //学校 - 服务 - 特色
        $schoolName = $schoolInfo[0]['name'];
        $schoolAbbreviation = $schoolInfo[0]['abbreviation'];
        if(!empty($schoolAbbreviation))
        {
            $SEOTitle = $SEODescription = '大学生创业平台,'
							  .$schoolAbbreviation.'点餐,'
                              .$schoolAbbreviation.'外卖,'
                              .$schoolAbbreviation.'网络订餐,'
                              .$schoolAbbreviation.'点餐哟';
        }
        else
        {
            $SEOTitle = $SEODescription = '大学生创业平台,'
						.$schoolName.'点餐,'
                       .$schoolName.'外卖,'
                       .$schoolName.'网络订餐,'
                       .$schoolName.'点餐哟'; 
        }
        
                
        $result['SEOTitle'] = $SEOTitle;
        $result['SEOKeyword'] = $SEOKeyword;
        $result['SEODescription'] = $SEODescription;
        $result['School'] = $schoolName;

        return $result;

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
        //33顺带饮料,34顺带香烟,35顺带水果,36顺带零食
        return implode(',', array(33, 34));
        
    }

    protected function getCurrentSchoolId()
    {
        if ($this->getInput("schoolid") > 0)
            return $this->getInput("schoolid");

        return $_COOKIE['schoolid'];
    }

    protected function isSameSchool(){
        $curSchoolId=$this->getInput("schoolid");
        $oldSchoolId=$_COOKIE['schoolid'];        
        if ($curSchoolId>0) {
            return $curSchoolId==$oldSchoolId;
        }
        return true;
    }
    protected function is_weixin()
    { 
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
                return true;
        }   
        return false;
    }

    private function _getSchoolDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }

    private function _getHotSearchDS()
    {
        return Wekit::load('EXT:4tschool.service.searches.App_HotSearch');
    }

    /**
     * 加载PwAnnounce Ds 服务
     *
     * @return PwAnnounceDs
     */
    private function _getPwAnnounceDs() {
        return Wekit::load('announce.PwAnnounce');
    }


}