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
               array('type' => "s", 'keyword' => '蒸菜'),
                array('type' => "m", 'keyword' => '丸'),
                array('type' => "m", 'keyword' => '炒饭'),
                array('type' => "m", 'keyword' => '盖浇'),
                array('type' => "m", 'keyword' => '粉'),
                array('type' => "m", 'keyword' => '肉'),
                array('type' => "s", 'keyword' => '华莱士'),
                array('type' => "m", 'keyword' => '红烧'),
                array('type' => "m", 'keyword' => '拌饭'),
                array('type' => "m", 'keyword' => '面'),
                array('type' => "m", 'keyword' => '套餐'),

            ), //安源学院
            11016 => array(
                array('type' => "s", 'keyword' => '蒸菜'),
                array('type' => "m", 'keyword' => '丸'),
                array('type' => "m", 'keyword' => '炒饭'),
                array('type' => "m", 'keyword' => '盖浇'),
                array('type' => "m", 'keyword' => '粉'),
                array('type' => "m", 'keyword' => '肉'),
                array('type' => "s", 'keyword' => '华莱士'),
                array('type' => "m", 'keyword' => '红烧'),
                array('type' => "m", 'keyword' => '拌饭'),
                array('type' => "m", 'keyword' => '面'),
                array('type' => "m", 'keyword' => '套餐'),

            ), //南昌航空大学
            11062 => array(
                 array('type' => "s", 'keyword' => '蒸菜'),
                array('type' => "m", 'keyword' => '丸'),
                array('type' => "m", 'keyword' => '炒饭'),
                array('type' => "m", 'keyword' => '盖浇'),
                array('type' => "m", 'keyword' => '粉'),
                array('type' => "m", 'keyword' => '肉'),
                array('type' => "s", 'keyword' => '华莱士'),
                array('type' => "m", 'keyword' => '红烧'),
                array('type' => "m", 'keyword' => '拌饭'),
                array('type' => "m", 'keyword' => '面'),
                array('type' => "m", 'keyword' => '套餐'),

            ), //江西师范大学科技学院
            11045 => array(
                array('type' => "s", 'keyword' => '蒸菜'),
                array('type' => "m", 'keyword' => '丸'),
                array('type' => "m", 'keyword' => '炒饭'),
                array('type' => "m", 'keyword' => '盖浇'),
                array('type' => "m", 'keyword' => '粉'),
                array('type' => "m", 'keyword' => '肉'),
                array('type' => "m", 'keyword' => '红烧'),
                array('type' => "m", 'keyword' => '拌饭'),
                array('type' => "m", 'keyword' => '面'),
                array('type' => "m", 'keyword' => '套餐'),

            ),
            1001292 => array(
                array('type' => "s", 'keyword' => '蒸菜'),
                array('type' => "m", 'keyword' => '丸'),
                array('type' => "m", 'keyword' => '炒饭'),
                array('type' => "m", 'keyword' => '盖浇'),
                array('type' => "m", 'keyword' => '粉'),
                array('type' => "m", 'keyword' => '肉'),
                array('type' => "m", 'keyword' => '红烧'),
                array('type' => "m", 'keyword' => '拌饭'),
                array('type' => "m", 'keyword' => '面'),
                array('type' => "m", 'keyword' => '套餐'),

            ),
            1001293 => array(
                array('type' => "s", 'keyword' => '蒸菜'),
                array('type' => "m", 'keyword' => '丸'),
                array('type' => "m", 'keyword' => '炒饭'),
                array('type' => "m", 'keyword' => '盖浇'),
                array('type' => "m", 'keyword' => '粉'),
                array('type' => "m", 'keyword' => '肉'),
                array('type' => "m", 'keyword' => '红烧'),
                array('type' => "m", 'keyword' => '拌饭'),
                array('type' => "m", 'keyword' => '面'),
                array('type' => "m", 'keyword' => '套餐'),

            ),
            1001294 => array(
                array('type' => "s", 'keyword' => '蒸菜'),
                array('type' => "m", 'keyword' => '丸'),
                array('type' => "m", 'keyword' => '炒饭'),
                array('type' => "m", 'keyword' => '盖浇'),
                array('type' => "m", 'keyword' => '粉'),
                array('type' => "m", 'keyword' => '肉'),
                array('type' => "m", 'keyword' => '红烧'),
                array('type' => "m", 'keyword' => '拌饭'),
                array('type' => "m", 'keyword' => '面'),
                array('type' => "m", 'keyword' => '套餐'),

            ),
            1001295 => array(
                array('type' => "s", 'keyword' => '蒸菜'),
                array('type' => "m", 'keyword' => '丸'),
                array('type' => "m", 'keyword' => '炒饭'),
                array('type' => "m", 'keyword' => '盖浇'),
                array('type' => "m", 'keyword' => '粉'),
                array('type' => "m", 'keyword' => '肉'),
                array('type' => "m", 'keyword' => '红烧'),
                array('type' => "m", 'keyword' => '拌饭'),
                array('type' => "m", 'keyword' => '面'),
                array('type' => "m", 'keyword' => '套餐'),

            )
            ,
            11033 => array(
                array('type' => "s", 'keyword' => '蒸菜'),
                array('type' => "m", 'keyword' => '丸'),
                array('type' => "m", 'keyword' => '炒饭'),
                array('type' => "m", 'keyword' => '盖浇'),
                array('type' => "m", 'keyword' => '粉'),
                array('type' => "m", 'keyword' => '肉'),
                array('type' => "m", 'keyword' => '红烧'),
                array('type' => "m", 'keyword' => '拌饭'),
                array('type' => "m", 'keyword' => '面'),
                array('type' => "m", 'keyword' => '套餐'),

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
                array('link' => "index.php?m=app&app=4tschool&c=about&a=whycellphone", 'image' => 'themes/extres/4tschool/images/faq.gif'),

            ), //安源学院
            11016 => array(
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/phone.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/flow.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/hot.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/whotakeorder.gif'),
                array('link' => "index.php?m=app&app=4tschool&c=about&a=whycellphone", 'image' => 'themes/extres/4tschool/images/faq.gif'),


            ), //南昌航空大学
            11062 => array(
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/phone.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/flow.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/hot.gif'),
                array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/whotakeorder.gif'),
                array('link' => "index.php?m=app&app=4tschool&c=about&a=whycellphone", 'image' => 'themes/extres/4tschool/images/faq.gif'),


            ), //江西师范大学科技学院
            11045 => array(
                array('link' => "index.php?m=app&app=4tschool&c=shopdetails&a=apps", 'image' => 'themes/extres/4tschool/images/phone.gif'),
                array('link' => "index.php?m=app&app=4tschool&c=about&a=whycellphone#订餐流程", 'image' => 'themes/extres/4tschool/images/flow.gif'),
                array('link' => "#HotMerchandises", 'image' => 'themes/extres/4tschool/images/hot.gif'),
                //array('link' => "index.php?m=app&app=4tschool", 'image' => 'themes/extres/4tschool/images/whotakeorder.gif'),
                array('link' => "index.php?m=app&app=4tschool&c=about&a=whycellphone", 'image' => 'themes/extres/4tschool/images/faq.gif'),
            )
        );

        return $hotSearches[$schoolid];
    }
}

?>