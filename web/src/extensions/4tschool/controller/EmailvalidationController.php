<?php
Wind::import('SRV:user.srv.PwRegisterService');
Wind::import('APPS:.profile.controller.BaseProfileController');
Wind::import('SRV:user.srv.PwUserProfileService');
Wind::import('SRV:user.validator.PwUserValidator');
Wind::import('SRV:user.PwUserBan');
Wind::import('APPS:profile.service.PwUserProfileExtends');
Wind::import('APPS:u.service.helper.PwUserHelper');

Wind::import('EXT:4tschool.controller.T4BaseController');
/**
 */
class EmailValidationController extends T4BaseController {

	private $pageNumber = 2;

	public function beforeAction($handlerAdapter) {
		parent::beforeAction($handlerAdapter);

		//no need to valiation if users are login or not
	}

		
	public function run() {

		$schoolId = $this->getCurrentSchoolId();
		$userid = $this->loginUser->uid;

		$myMenus =  $this->_getMyOrderDS()->getMyMenus($schoolId,$userid);
		$this->setOutput($myMenus,'myMenus');
		//check email
		$code = $this->getInput('code');
		$PwUserRegisterBp = new PwRegisterService();
		$result = $PwUserRegisterBp->activeEmail($this->loginUser->uid, $this->loginUser->info['email'], $code);
		if ($result instanceof PwError)
		{
			$code = $result->getError();
			$errorMessage = "验证失败，请联系管理员";

			if($code == "USER:active.email.dumplicate")
			{
				$errorMessage = "此邮箱已被验证";
			}
			else if($code == "USER:illegal.request")
			{
				$errorMessage = "无效的验证请求，请联系管理员";
			}
			else if($code == "USER:active.email.overtime")
			{
				$errorMessage = "验证码超时, 请再次请求";
			}

			print_r($result->getError());die;
			$this->showError($result->getError());
			$this->setOutput(false,"validated");
		}
		else
		{
			$this->setOutput(true,"validated");
		}

		
	}

    /**
     * @return     App_MyOrder
     */
	private function _getMyOrderDS()
	{
		return Wekit::load('EXT:4tschool.service.myorder.App_MyOrder');
	}

    /**
     * @return App_MyFavorite
     */
	private function _getMyFavoriteDS()
	{
		return Wekit::load('EXT:4tschool.service.myfavorite.App_MyFavorite');
	}

    /**
     * @return App_MyMoney
     */
	private function _getMyMoneyDS()
	{
		return Wekit::load('EXT:4tschool.service.mymoney.App_MyMoney');
	}

    /**
     * @return App_OrderAddress
     */
	private function _getMyOrderAddressDS()
	{
		return Wekit::load('EXT:4tschool.service.orderaddress.App_OrderAddress');
	}

    /**
     * @return PwUserMobile
     */
	private function _getUserMobileDS()
	{
		return Wekit::load('SRV:user.PwUserMobile');
	}

    /**
     * @return App_SchoolArea
     */
	private function _getSchoolAreaDS()
	{
		return Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea');
	}

    /**
     * @return App_School
     */
	private function _getSchoolDS()
	{
		return Wekit::load('EXT:4tschool.service.school.App_School');
	}

    /**
     * @return App_SchoolPeople
     */
	private function _getSchoolPeopleDS()
	{
		return Wekit::load('EXT:4tschool.service.schoolpeople.App_SchoolPeople');
	}

    /**
     * @return App_Security
     */
	private function _getSecurityDS()
	{
		return Wekit::load('EXT:4tschool.service.security.App_Security');
	}


}