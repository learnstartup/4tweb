<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_Giftexchange - 数据服务接口
 */
class App_Giftexchange
{
    private $_prize_arr=array
    (
        0=>array(
            'id'=>0,
            'name'=>'10元话费',
            'dmoney'=>100,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Phone_10.jpg',
            'type'=>'V'
            ),
        1=>array(
            'id'=>1,
            'name'=>'50元话费',
            'dmoney'=>500,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Phone_50.jpg',
            'type'=>'V'
            ),
        2=>array(
            'id'=>2,
            'name'=>'100元话费',
            'dmoney'=>1000,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Phone_100.jpg',
            'type'=>'V'
            ),
        3=>array(
            'id'=>3,
            'name'=>'10Q币',
            'dmoney'=>100,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/QB.jpg',
            'type'=>'V'
            ),
        4=>array(
            'id'=>4,
            'name'=>'50Q币',
            'dmoney'=>500,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/QB.jpg',
            'type'=>'V'
            ),
        5=>array(
            'id'=>5,
            'name'=>'100Q币',
            'dmoney'=>1000,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/QB.jpg',
            'type'=>'V'
            ),
        6=>array(
            'id'=>6,
            'name'=>'品牌全棉毛巾',
            'dmoney'=>100,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Towel.jpg',
            'type'=>'E'
            ),
        7=>array(
            'id'=>7,
            'name'=>'高品质音乐枕',
            'dmoney'=>200,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Radio_Pillow.jpg',
            'type'=>'E'
            ),
        8=>array(
            'id'=>8,
            'name'=>'LOCKLOCK正品水杯',
            'dmoney'=>200,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Lock_Cup.jpg',
            'type'=>'E'
            ),
        9=>array(
            'id'=>9,
            'name'=>'Sandisk闪迪U盘(8G)',
            'dmoney'=>300,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Sandisk_8G.jpg',
            'type'=>'E'
            ),
        10=>array(
            'id'=>10,
            'name'=>'创意挤牙膏架',
            'dmoney'=>350,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Oothpaste_Squeezer.jpg',
            'type'=>'E'
            ),        
        11=>array(
            'id'=>11,
            'name'=>'健康夜视体重秤',
            'dmoney'=>360,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Weighing_Scale.jpg',
            'type'=>'E'
            ),
        12=>array(
            'id'=>12,
            'name'=>'LOCKLOCK塑料保鲜盒4件礼盒套装',
            'dmoney'=>450,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Lock_Crisper.jpg',
            'type'=>'E'
            ),        
        13=>array(
            'id'=>13,
            'name'=>'Sandisk闪迪迷你U盘(16G)',
            'dmoney'=>520,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Sandisk_Mini_16G.jpg',
            'type'=>'E'
            ),
        14=>array(
            'id'=>14,
            'name'=>'飞利浦静音电吹风机',
            'dmoney'=>700,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Hair_Drier.jpg',
            'type'=>'E'
            ),                    
        15=>array(
            'id'=>15,
            'name'=>'品能10000毫安移动电源',
            'dmoney'=>700,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Mobile_Power.jpg',
            'type'=>'E'
            ),
        16=>array(
            'id'=>16,
            'name'=>'高大上铁三角耳机',
            'dmoney'=>1200,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Headset.jpg',
            'type'=>'E'
            ),        
        17=>array(
            'id'=>17,
            'name'=>'Razer/雷蛇地狱狂蛇竞技鼠标',
            'dmoney'=>1500,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Mouse.jpg',
            'type'=>'E'
            ),
        18=>array(
            'id'=>18,
            'name'=>'苹果iPod shuffle7 MP3',
            'dmoney'=>3400,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/iPod_Shuffle7.jpg',
            'type'=>'E'
            ),
        19=>array(
            'id'=>19,
            'name'=>'Kindle paperwhite2(二代)',
            'dmoney'=>7200,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Kindle.jpg',
            'type'=>'E'
            ),
        20=>array(
            'id'=>20,
            'name'=>'iPad mini(16G)',
            'dmoney'=>20000,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/iPad_Mini_16G.jpg',
            'type'=>'E'
            ),
        21=>array(
            'id'=>21,
            'name'=>'iPad Air(16G）',
            'dmoney'=>32000,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/iPad_Air_16G.jpg',
            'type'=>'E'
            ),
        22=>array(
            'id'=>22,
            'name'=>'卡通迷你小风扇',
            'dmoney'=>100,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Fan_Mini.jpg',
            'type'=>'E'
            ),
        23=>array(
            'id'=>23,
            'name'=>'USB学生宿舍超静音风扇',
            'dmoney'=>260,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Fan_USB.jpg',
            'type'=>'E'
            ),
        24=>array(
            'id'=>24,
            'name'=>'小黄人50cm毛绒公仔',
            'dmoney'=>420,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Doll_Yellow.jpg',
            'type'=>'E'
            ),
        25=>array(
            'id'=>25,
            'name'=>'33mm直卷两用电卷发棒',
            'dmoney'=>490,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Hair_Curler.jpg',
            'type'=>'E'
            ),
        26=>array(
            'id'=>26,
            'name'=>'宿舍制冷制热台式饮水机',
            'dmoney'=>1500,
            'imgurl'=>'/themes/extres/4tschool/images/prizes/Water_Fountains.jpg',
            'type'=>'E'
            )                                                                                                                                                                  
    );

    public function getPrizes (){
        $prizes_sort=$this->array_sort_by_keys($this->_prize_arr,array('type'=>'desc','dmoney'=>'asc'));
        $prizes=array();
        foreach ($prizes_sort as $item) {            
            $item['imgurl']=Wekit::C('site', 'info.url').$item['imgurl'];
            $item['key']=$this->getExchangeKey();
            $prizes[]=$item;
        }
        return $prizes;
    }

    public function getPrizeById ($id){
        $prize=null;
        foreach ($this->_prize_arr as $item) {
            if ($item['id']==$id) {
                $prize=$item;
            }
        }    
        return $prize;
    }

    public function getExchangeKey(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
            return $uuid;
        }        
    }

    private function array_sort_by_keys(&$arr, $sort = array()) {
        if (empty($sort) || !is_array($sort) ) {
            return null;
        }
        // 非连续的索引数组 或者 关联数组 先转化成以0开始的索引的数组
        $arr = array_values($arr);

        for ($i = 0; $i < count($arr); $i++) {
            for ($j = 0; $j < count($arr) - $i -1 ; $j++) {
                foreach ($sort as $k => $v) {

                    if (!array_key_exists($k, $arr[$j]) || !array_key_exists($k, $arr[$j + 1])) 
                    {
                        return NULL;
                    }

                    $tmp = $arr[$j][$k];

                    $tmp2 = $arr[$j + 1][$k];

                    if (strtolower($v[0]) == 'i') {
                        $tmp = strtolower($tmp);
                        $tmp2 = strtolower($tmp2);
                    }

                    if (stripos($v, 'asc') !== false) {
                        if ($tmp > $tmp2) {
                            $tmp = $arr[$j];
                            $arr[$j] = $arr[$j + 1];
                            $arr[$j + 1] = $tmp;
                            break;
                        } else if ($tmp < $tmp2) {
                            break;
                        }
                    } else {
                        if ($tmp < $tmp2) {
                            $tmp = $arr[$j];
                            $arr[$j] = $arr[$j + 1];
                            $arr[$j + 1] = $tmp;
                            break;
                        } else if ($tmp > $tmp2) {
                            break;
                        }
                    }
                }
            }
        }
        return $arr;
    }   

    public function getAllGiftExchange($searchCondition,$start,$limit)
    {
        return $this->loadDao()->getAllGiftExchange($searchCondition,$start,$limit);
    }

    public function getOneGiftExchange($id)
    {
        return $this->loadDao()->getOneGiftExchange($id);
    }

	/**
     * add record
     *
     * @param App_Giftexchange_Dm $dm
     * @return multitype:|Ambigous <boolean, number, string, rowCount>
     */
    public function add(App_Giftexchange_Dm $dm)
    {

        if (true !== ($r = $dm->beforeAdd())) return $r;
        return $this->loadDao()->add($dm->getData());
    }

    /**
     * update record
     *
     * @param App_Giftexchange_Dm $dm
     * @return multitype:|Ambigous <boolean, number, rowCount>
     */
    public function update($id, App_Giftexchange_Dm $dm)
    {
        if (true !== ($r = $dm->beforeUpdate())) return $r;
        return $this->loadDao()->update($id, $dm->getData());
    }

    /**
     * delete a record
     *
     * @param unknown_type $id
     * @return Ambigous <number, boolean, rowCount>
     */
    public function delete($id)
    {
        return $this->loadDao()->delete($id);
    }

    public function get($id){
        return $this->loadDao()->get($id);
    }

    /**
     * @return App_Giftexchange_Dao
     */
    private function loadDao()
    {
        return Wekit::loadDao('EXT:4tschool.service.giftexchange.dao.App_Giftexchange_Dao');
    }
}

?>