<?php

defined('WEKIT_VERSION') or exit(403);

class App_Cate_Week_Report_Dm extends PwBaseDm
{

    protected $id;

    public function setCateWeekReport()
    {

    }

    public function setSchoolId($choosenSchoolId)
    {
        $this->_data['schoolid'] = $choosenSchoolId;
        return $this;
    }

    public function setCateType($cateType)
    {
        $this->_data['type'] = $cateType;
        return $this;
    }

    public function setTitle($title)
    {
        $this->_data['title'] = $title;
        return $this;
    }

    public function setLink($link)
    {
        $this->_data['link'] = $link;
        return $this;
    }

    public function setContent($content)
    {
        $this->_data['content'] = $content;
        return $this;
    }

    public function setBreviaryphoto($breviaryPhoto)
    {
        $this->_data['breviaryphoto'] = $breviaryPhoto;
        return $this;
    }

    public function setCreator($creator)
    {
        $this->_data['creator'] = $creator;
        return $this;
    }

    public function setContactinfo($contactInfo)
    {
        $this->_data['contactinfo'] = $contactInfo;
        return $this;
    }

    public function setIsAudited($isAudited)
    {
        $this->_data['audited'] = $isAudited;
        return $this;
    }

    public function setIsReleased($isReleased)
    {
        $this->_data['released'] = $isReleased;
        return $this;
    }

    public function setAuditDate($auditDate)
    {
        $this->_data['auditdate'] = $auditDate;
        return $this;
    }

    public function setReleaseDate($releaseDate)
    {
        $this->_data['releasedate'] = $releaseDate;
        return $this;
    }

    public function setCreateDate($createDate)
    {
        $this->_data['createdate'] = $createDate;
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
