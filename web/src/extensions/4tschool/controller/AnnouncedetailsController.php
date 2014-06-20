<?php
Wind::import('EXT:4tschool.controller.T4BaseNotLoginController');
Wind::import('SRC:service.announce.dao.PwAnnounceDao');
class AnnounceDetailsController extends T4BaseNotLoginController
{
    
    //显示公告
    public function run()
    {
        $aid = $this->getInput('id','get');
        $this->setOutput($aid,'id');

        $pagetag = $this->getInput('pagetag','get');
        $this->setOutput($pagetag,'pagetag');


        $schoolid = $this->getCurrentSchoolId();

        if(empty($pagetag))
        {
            $info = $this->_getPwAnnounceDs()->getAnnounce($aid);
        }
        else
        {
            $info = $this->_getPwAnnounceDs()->getAnnouncePageTurn($schoolid, $aid, $pagetag);

        }

        $currentime = time();
        $this->setOutput($currentime, 'currentime');

        $this->setOutput(Pw::time2str($info['start_date'], 'Y-m-d'), 'startdate');
        $this->setOutput(Pw::time2str($info['end_date'], 'Y-m-d'), 'enddate');
        $this->setOutput($info,'schoolAnnounceInfo');

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