<?php
Wind::import('APPS:windid.api.OpenBaseController');
Wind::import('SRC:service.push.dao.PwPushDao');

class OpenpushController extends OpenBaseController
{

    public function getOnePushByIdAction()
    {
        list($id, $schoolid) = $this->getInput(array('id', 
                                                    'schoolid'), 'get');

        $onePushList = $this->_getPushDs()->getOnePushById($id);
        $onePushList['content'] = strip_tags($onePushList['content']);
        
        $this->output($onePushList);
    }

    public function getAllPushBySchoolidAction()
    {
        list($schoolid, $limit, $offset) = $this->getInput(array('schoolid',
                                                                 'limit', 
                                                                 'offset'), 'get');
        $searchCondition = array('schoolid' => $schoolid,
                                 'status' => '1');

        $allPushList = $this->_getPushDs()->getSearchPushData($searchCondition, 
                                                              $start,
                                                              $limit);
        foreach ($allPushList as $key => $value) 
        {
            $allPushList[$key]['content'] = strip_tags($value['content']);
        }

        $this->output($allPushList);
    }

    private function _getPushDs() 
    {
        return Wekit::load('EXT:4tschool.service.push.App_Push');
    }

}

?>