<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_Search - 数据服务接口
 */
class App_HotSearch
{

    public function getHotSearchBySchool($schoolid)
    {
        $hotSearches = array(
            80971 => array(
                array('type' => "s", 'keyword' => '煌上煌'),
                array('type' => "s", 'keyword' => '大食头'),
                array('type' => "s", 'keyword' => '周黑鸭'),
                array('type' => "m", 'keyword' => '盖浇饭'),
                array('type' => "m", 'keyword' => '可乐套餐'),
                array('type' => "m", 'keyword' => '烤鱿鱼'),
                array('type' => "s", 'keyword' => '东北水饺'),
                array('type' => "m", 'keyword' => '香蕉'),

            ), //安源学院
            11016 => array(
                array('type' => "s", 'keyword' => '煌上煌'),
                array('type' => "s", 'keyword' => '大食头'),
                array('type' => "s", 'keyword' => '周黑鸭'),
                array('type' => "m", 'keyword' => '盖浇饭'),
                array('type' => "m", 'keyword' => '可乐套餐'),
                array('type' => "m", 'keyword' => '烤鱿鱼'),
                array('type' => "s", 'keyword' => '东北水饺'),
                array('type' => "m", 'keyword' => '香蕉'),

            ), //南昌航空大学
            11062 => array(
                array('type' => "s", 'keyword' => '煌上煌'),
                array('type' => "s", 'keyword' => '大食头'),
                array('type' => "s", 'keyword' => '周黑鸭'),
                array('type' => "m", 'keyword' => '盖浇饭'),
                array('type' => "m", 'keyword' => '可乐套餐'),
                array('type' => "m", 'keyword' => '烤鱿鱼'),
                array('type' => "s", 'keyword' => '东北水饺'),
                array('type' => "m", 'keyword' => '香蕉'),

            ), //江西师范大学科技学院
            11045 => array(
                array('type' => "s", 'keyword' => '煌上煌'),
                array('type' => "s", 'keyword' => '大食头'),
                array('type' => "s", 'keyword' => '周黑鸭'),
                array('type' => "m", 'keyword' => '盖浇饭'),
                array('type' => "m", 'keyword' => '可乐套餐'),
                array('type' => "m", 'keyword' => '烤鱿鱼'),
                array('type' => "s", 'keyword' => '东北水饺'),
                array('type' => "m", 'keyword' => '香蕉'),

            )
        );

        return $hotSearches[$schoolid];
    }


    public function getHotAdBySchool($schoolid)
    {
        $hotSearches = array(
            80971 => array(
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/phone.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/flow.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/hot.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/whotakeorder.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/faq.gif'),

            ), //安源学院
            11016 => array(
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/phone.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/flow.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/hot.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/whotakeorder.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/faq.gif'),


            ), //南昌航空大学
            11062 => array(
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/phone.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/flow.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/hot.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/whotakeorder.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/faq.gif'),


            ), //江西师范大学科技学院
            11045 => array(
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/phone.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/flow.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/hot.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/whotakeorder.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/faq.gif'),
            )
        );

        return $hotSearches[$schoolid];
    }
}

?>