<?php
defined('WEKIT_VERSION') or exit(403);

class App_Common {
	private $_wechat_key=3;

    private $_prize_arr=array
    (
        0=>array(
            'id'=>0,
            'name'=>'10元话费',
            'dmoney'=>100,
            'imgurl'=>'/themes/extres/4tschool/images/10yuan.jpg',
            'type'=>'V'
            ),
        1=>array(
            'id'=>1,
            'name'=>'20元话费',
            'dmoney'=>200,
            'imgurl'=>'/themes/extres/4tschool/images/20yuan.jpg',
            'type'=>'V'
            ),
        2=>array(
            'id'=>2,
            'name'=>'30元话费',
            'dmoney'=>300,
            'imgurl'=>'/themes/extres/4tschool/images/30yuan.jpg',
            'type'=>'V'
            )        
    );	

	public function is_weixin()
	{ 
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
			return true;
		}	
		return false;
	}	

    public function getPrizes (){
        $prizes=array();
        foreach ($this->_prize_arr as $item) {            
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

    public function getWechatKey (){
    	return $this->_wechat_key;
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
}

?>
