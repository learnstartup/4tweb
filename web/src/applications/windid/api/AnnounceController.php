<?php
Wind::import('APPS:windid.api.OpenBaseController');
Wind::import('SRC:service.announce.dao.PwAnnounceDao');
/**
 * the last known user to change this file in the repository<$LastChangedBy: Aaron $>
 * @author $Author: Aaron $ 504662465@qq.com
 * @copyright ?2003-2103 fenxiangyo.com
 * @license http://www.fenxiangyo.com
 * @package
 */
class AnnounceController extends OpenBaseController
{

    //my announce list based on aid
    public function getMyAnnounceByAidAction()
    {
        $aid = $this->getInput('aid','get');

        if(empty($aid))
        {
            $this->output(-1);
            return;
        }

        $result = $this->_getPwAnnounceDs()->getAnnounce($aid);
        $this->output($result);
    }

    //my announce list based on schoolid
    public function getMyAnnounceBySchoolIdAction()
    {
        $schoolid = $this->getInput('schoolid','get');

        if(empty($schoolid))
        {
            $this->output(-1);
            return;
        }

        $result = $this->_getPwAnnounceDs()->getAnnounceBySchoolId($schoolid, Pw::str2time(Pw::time2str(Pw::getTime(), 'Y-m-d')), 9, 0);
        $this->output($result);
    }

    /**
     * 加载PwAnnounce Ds 服务
     *
     * @return PwAnnounce
     */
    private function _getPwAnnounceDs() {
        return Wekit::load('announce.PwAnnounce');
    }

}

?>