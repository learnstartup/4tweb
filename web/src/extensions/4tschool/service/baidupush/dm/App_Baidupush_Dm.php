<?php

defined('WEKIT_VERSION') or exit(403);

class App_Baidupush_Dm extends PwBaseDm
{
	protected $id;

	public function setUserId($userId)
    {
        $this->_data['userid'] = $userId;
        return $this;
    }

    public function setBaiduUserId($baiduUserId)
    {
        $this->_data['baiduuserid'] = $baiduUserId;
        return $this;
    }

    public function setBaiduChannelId($baiduChannelId)
    {
        $this->_data['baiduchannelid'] = $baiduChannelId;
        return $this;
    }

    public function setTagId($tagId)
    {
        $this->_data['tagid'] = $tagId;
        return $this;
    }

    public function setSchoolId($schoolId)
    {
        $this->_data['schoolid'] = $schoolId;
        return $this;
    }

    protected function _beforeAdd()
    {
        // TODO Auto-generated method stub
        //check the fields value before add
        return true;
    }

    protected function _beforeUpdate()
    {
        // TODO Auto-generated method stub
        //check the fields value before update
        return true;
    }

}

?>