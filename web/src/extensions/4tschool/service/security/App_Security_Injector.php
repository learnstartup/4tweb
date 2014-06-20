<?php
defined('WEKIT_VERSION') or exit(403);

/**
 * App_Security - 数据服务接口
 *
 */
class App_Security_Injector  extends PwBaseHookInjector {

	public function afterMobileVerified($mobile)
	{
		
		//return Wekit::load('user.PwUserMobile')->addMobile($mobile);
	}
}

?>