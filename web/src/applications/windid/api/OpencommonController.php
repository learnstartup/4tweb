<?php
Wind::import('APPS:windid.api.OpenBaseController');

/**
 * the last known user to change this file in the repository  <$LastChangedBy: Peter.yan $>
 * @author $Author: Peter.yan $ 215169718@qq.com
 * @copyright ?2003-2103 fenxiangyo.com
 * @license http://www.fenxiangyo.com
 * @package
 */
class OpenCommonController extends OpenBaseController
{
    private $_TAGTREE_TYPE_HOME='HOME';
    private $_TAGTREE_TYPE_COMBO='COMBO';

    public function getNavigationTreeAction(){
        $sysTagTree=$this->_getSysTagTreeDs()->getSysTagTreeByType($this->_TAGTREE_TYPE_HOME);
        $sysTagTree=$sysTagTree[0]['json'];
        $this->output(json_decode($sysTagTree));
    }

    public function getComboTreeAction()
    {
        $comboTree=$this->_getSysTagTreeDs()->getSysTagTreeByType($this->_TAGTREE_TYPE_COMBO);
        $comboTree=json_decode($comboTree[0]['json']);

        //get tag ids
        foreach ($comboTree as $value) {
            $tids.=$value->a_attr->id.',';
        }
        $tids=substr($tids, 0, strlen($tids)-1);

        //get merchandises by tag ids
        $merchandiseList=$this->_getMerchandiseDs()->getMerchandiseBySysTagIds($tids);

        //add merchandises into combo tree
        $children=array();
        foreach ($comboTree as $ckey => $combo) {
            foreach ($merchandiseList as $mkey => $mer) {
                if ($combo->a_attr->id==$mer['tid']) {
                    $children[]=$mer;
                }
            }
            $comboTree[$ckey]->children=$children;
        }

        $this->output($comboTree);
    }

    /**
     * @return App_SysTag_Tree
     */
    private function _getSysTagTreeDs() {
        return Wekit::load('EXT:4tschool.service.tag.App_SysTag_Tree');
    }   

    /**
     * @return App_Merchandise
     */
    private function _getMerchandiseDs()
    {
        return Wekit::load('EXT:4tschool.service.merchandise.App_Merchandise');
    }    
}

?>