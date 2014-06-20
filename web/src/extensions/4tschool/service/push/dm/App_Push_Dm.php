<?php

defined('WEKIT_VERSION') or exit(403);

class App_Push_Dm extends PwBaseDm
{

    protected $id;

    public function setSchoolId($schoolid)
    {
        $this->_data['schoolid'] = $schoolid;
        return $this;
    }

    public function setType($type)
    {
        $this->_data['type'] = $type;
        return $this;
    }

    public function setTitle($title)
    {
        $this->_data['title'] = $title;
        return $this;
    }

    public function setContent($content)
    {
        $this->_data['content'] = $content;
        return $this;
    }

    public function setStatus($status)
    {
        $this->_data['status'] = $status;
        return $this;
    }

    public function setCreator($creator)
    {
        $this->_data['creator'] = $creator;
        return $this;
    }

    public function setCreateDate($createDate)
    {
        $this->_data['createdate'] = $createDate;
        return $this;
    }

    public function setUpdateDate($updateDate)
    {
        $this->_data['updatedate'] = $updateDate;
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

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
