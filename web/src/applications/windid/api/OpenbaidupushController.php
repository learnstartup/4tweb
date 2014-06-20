<?php
Wind::import('APPS:windid.api.OpenBaseController');
Wind::import('EXT:4tschool.service.baidupush.dm.App_Baidupush_Dm');

class OpenbaidupushController extends OpenBaseController
{

	public function addAction()
	{
		list($userId, 
			 $baiduUserId, 
			 $baiduChannelId, 
			 $tagId, 
			 $schoolId) = $this->getInput(array('userid', 
			 									'baiduuserid', 
			 									'baiduchannelid', 
			 									'tagid', 
			 									'schoolid'), 'get');

		$dm = new App_Baidupush_Dm();
	    $dm->setUserId($userId)
	       ->setBaiduUserId($baiduUserId)
	       ->setBaiduChannelId($baiduChannelId)
	       ->setTagId($tagId)
	       ->setSchoolId($schoolId);

	    $result = $this->_getBaidupushDs()->add($dm);
	    
	    if ($result > 0) 
	    {
            $this->output(1);
        } 
        else 
        {
            $this->output(0);
        }
	}

    public function _getBaidupushDs()
    {
        return Wekit::loadDao('EXT:4tschool.service.baidupush.App_Baidupush');
    }

}

?>