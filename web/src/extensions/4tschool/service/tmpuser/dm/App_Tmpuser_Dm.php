<?php

defined('WEKIT_VERSION') or exit(403);

class App_Tmpuser_Dm extends PwBaseDm
{

    protected $id;

    public function setUserId($userid)
    {
        $this->_data['userid'] = $userid;
        return $this;
    }

    public function setFrom($from)
    {
        $this->_data['from'] = $from;
        return $this;
    }

    public function setKey($key)
    {
        $this->_data['key'] = $key;
        return $this;
    }

    /* (non-PHPdoc)
     * @see PwBaseDm::_beforeAdd()
     */

    protected function _beforeAdd()
    {
        // TODO Auto-generated method stub
        //check the fields value before add
        return true;
    }

    /* (non-PHPdoc)
     * @see PwBaseDm::_beforeUpdate()
     */

    protected function _beforeUpdate()
    {
        // TODO Auto-generated method stub
        //check the fields value before update
        return true;
    }

}

?>