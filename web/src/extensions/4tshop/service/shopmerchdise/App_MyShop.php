<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_MyShop - 数据服务接口
 *
 */
class App_MyShop
{
	private $myMenus = array(
        '我的管理' => array(
            array('name' => "我家菜单", 'extra' =>"shopadvantage", 'role' => 'shopaccount', 'link' => 'index.php?app=4tshop&m=app&c=shopadvantage&a=shopmerchdise'),
            array('name' => "外卖统计", 'extra' =>"shopadvantage", 'role' => 'shopaccount', 'link' => 'index.php?m=app&c=shopadvantage&app=4tshop&a=orderStatistics'),
            array('name' => "订单列表", 'extra' =>"shopadvantage", 'role' => 'shopaccount', 'link' => 'index.php?m=app&c=shopadvantage&app=4tshop&a=shoporder'),
            array('name' => "用户评论", 'extra' =>"shopadvantage", 'role' => 'shopaccount', 'link' => 'index.php?m=app&c=shopadvantage&app=4tshop&a=shopcomment')
        )
    );

    public function getMyMenus($userid)
    {
    	return $this->myMenus;
    }


}

?>