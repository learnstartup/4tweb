<?php
Wind::import('EXT:4tschool.controller.T4BaseController');
/**
 */
class NotopenController extends T4BaseController {

	private $pageNumber = 10;

	public function beforeAction($handlerAdapter) {

		parent::beforeAction($handlerAdapter);
	
	}

	//get all messages
	public function run() {
		$schoolId = $this->getCurrentSchoolId();
		
		$extras = $this->_getSchoolDS()->getSchoolExtra($schoolId);
		if($extras[0]['opened'])
		{
			$this->forwardRedirect(WindUrlHelper::createUrl('app/4tschool/index/run?schoolid='.$schoolId));
		}

		$this->setOutput($schoolId, "schoolId");
	}

	/**
     * @return App_School
     */
    private function _getSchoolDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }

}