<?php
Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');
class AboutController extends T4BaseNotLoginController {

    private $pageNumber = 10;

    private $aboutArray =   array(
        "分享哟平台" => array("关于分享哟","诚聘英才","商家加盟","联系我们"),
        "吃饭与兼职" => array("啥餐可点","兼职可做","免费餐品","美食群组"),
        "服务说明" => array("订餐流程","注册方法","预定美味","查询催单","取消订单"),
        "订餐送达" => array("提前订餐","送餐时间","投诉建议","除了餐品"),
        "法律声明" => array("法律声明"),
        );

    private $menuLinks = array(
            "关于分享哟" =>"index.php?m=app&app=4tschool&c=about#关于分享哟",
            "诚聘英才" =>"index.php?m=app&app=4tschool&c=about&a=hire#诚聘英才",
            "商家加盟" =>"index.php?m=app&app=4tschool&c=about&a=businessjoin#商家加盟",
            "联系我们" =>"index.php?m=app&app=4tschool&c=about&a=contactus#联系我们",
            "啥餐可点" =>"index.php?m=app&app=4tschool&c=about&a=whichorder#啥餐可点",
            "兼职可做" =>"index.php?m=app&app=4tschool&c=about&a=money#兼职可做",
            "免费餐品" =>"index.php?m=app&app=4tschool&c=about&a=whattoexchange#免费餐品",
            "美食群组" =>"index.php?m=app&app=4tschool&c=about&a=group#美食群组",
            "订餐流程" =>"index.php?m=app&app=4tschool&c=about&a=whycellphone#订餐流程",
            "注册方法" =>"index.php?m=app&app=4tschool&c=about&a=whycellphone#注册方法",
            "预定美味" =>"index.php?m=app&app=4tschool&c=about&a=howtoorder#预定美味",
            "查询催单" =>"index.php?m=app&app=4tschool&c=about&a=checkorder#查询催单",
            "取消订单" =>"index.php?m=app&app=4tschool&c=about&a=cancelorder#取消订单",
            "提前订餐" =>"index.php?m=app&app=4tschool&c=about&a=whyorderadvance#提前订餐",
            "送餐时间" =>"index.php?m=app&app=4tschool&c=about&a=orderintime#送餐时间",
            "投诉建议" =>"index.php?m=app&app=4tschool&c=about&a=helpimprove#投诉建议",
            "除了餐品" =>"index.php?m=app&app=4tschool&c=about&a=whatelse#除了餐品",
            "法律声明" =>"index.php?m=app&app=4tschool&c=about&a=law#法律声明",

        );

    public function beforeAction($handlerAdapter) {

        parent::beforeAction($handlerAdapter);

        //SEO Information
        $SEOInfo = $this->getSEOInfo();

        $this->setOutput($SEOInfo['School'].'帮助中心,自助服务中心,'.$SEOInfo['SEOTitle'],'SEOTitle');
        $this->setOutput($SEOInfo['School'].'帮助中心,自助服务中心 '.$SEOInfo['SEOKeyword'],'SEOKeyword');
        $this->setOutput($SEOInfo['School'].'帮助中心,自助服务中心,'.$SEOInfo['SEODescription'],'SEODescription');

    }

    public function run()
    {
        $this->_renderShareData();

        //set selected menu
        $this->setOutput("关于分享哟",'selectedMenu');

        error_reporting(E_ERROR | E_WARNING | E_PARSE);

        $this->setTemplate("about_run");
    }

    public function hireAction()
    {
        $this->_renderShareData();

        //set selected menu
        $this->setOutput("诚聘英才",'selectedMenu');

        $this->setTemplate("about_run");
    }

    public function businessjoinAction()
    {
        $this->_renderShareData();

        //set selected menu
        $this->setOutput("商家加盟",'selectedMenu');

        $this->setTemplate("about_run");
    }

    public function contactusAction()
    {
        $this->_renderShareData();

        //set selected menu
        $this->setOutput("联系我们",'selectedMenu');

        $this->setTemplate("about_run");
    }



    //====================================================================
    //====================================================================
    // 积分与零钱
    //
    //====================================================================

    public function whichorderAction()
    {
        $this->_renderShareData();

        //set selected menu
        $this->setOutput("积分计算规则",'selectedMenu');

        $this->setTemplate("about_foodandgroup");
    }

    public function moneyAction()
    {
        $this->_renderShareData();

        //set selected menu
        $this->setOutput("什么是零钱包",'selectedMenu');

        $this->setTemplate("about_foodandgroup");
    }

    public function whattoexchangeAction()
    {
        $this->_renderShareData();

        //set selected menu
        $this->setOutput("积分可以兑换什么礼品",'selectedMenu');

        $this->setTemplate("about_foodandgroup");
    }

    public function groupAction()
    {
        $this->_renderShareData();

        //set selected menu
        $this->setOutput("信息安全吗",'selectedMenu');

        $this->setTemplate("about_foodandgroup");
    }

    //====================================================================
    //====================================================================
    // 服务说明
    //
    //====================================================================

    public function whycellphoneAction()
    {
        $this->_renderShareData();

        //set selected menu
        $this->setOutput("注册方法",'selectedMenu');

        $this->setTemplate("about_servicehow");
    }

    public function howtoorderAction()
    {
        $this->_renderShareData();

        //set selected menu
        $this->setOutput("预定美味",'selectedMenu');

        $this->setTemplate("about_servicehow");
    }

    public function checkorderAction()
    {
        $this->_renderShareData();

        //set selected menu
        $this->setOutput("查询催单",'selectedMenu');

        $this->setTemplate("about_servicehow");
    }

    public function cancelorderAction()
    {
        $this->_renderShareData();

        //set selected menu
        $this->setOutput("取消订单",'selectedMenu');

        $this->setTemplate("about_servicehow");
    }

    //====================================================================
    //====================================================================
    // 订餐及时达
    //
    //====================================================================

    public function  whyorderadvanceAction()
    {
        $this->_renderShareData();

        //set selected menu
        $this->setOutput("提前订餐",'selectedMenu');

        $this->setTemplate("about_orderintime");
    }

    public function orderintimeAction()
    {
        $this->_renderShareData();

        //set selected menu
        $this->setOutput("送餐时间",'selectedMenu');

        $this->setTemplate("about_orderintime");
    }

    public function helpimproveAction()
    {
        $this->_renderShareData();

        //set selected menu
        $this->setOutput("投诉建议",'selectedMenu');

        $this->setTemplate("about_orderintime");
    }

    public function whatelseAction()
    {
        $this->_renderShareData();

        //set selected menu
        $this->setOutput("除了餐品",'selectedMenu');

        $this->setTemplate("about_orderintime");
    }

    //================================================================
    //================================================================
    //法律声明
    //================================================================
    public function lawAction()
    {
        $this->_renderShareData();

        //set selected menu
        $this->setOutput("法律声明",'selectedMenu');

        $this->setTemplate("about_law");
    }



    private function _renderShareData()
    {
        //render about menu
        $this->setOutput($this->aboutArray,"aboutMenu");

        //set menu links
        $this->setOutput($this->menuLinks,'menuLinks');
    }
}