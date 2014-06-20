<?php
defined('WEKIT_VERSION') or exit(403);
/**
 * 编辑器扩展
 *
 * @author yang <yangyan7777@gmail.com>
 * @copyright http://www.fenxiangyo.com
 */
class AppSchoolArea_PwEditor_AppDo {
	
	/**
	 * @param array $var
	 * @return array
	 */
	public function appSchoolAreaDo($var) {
		$var[] = array(
			'name' => 'SchoolArea',
			'params' => array('len' => 8, 'age' => 2)
		);
		return $var;
	}
}

?>