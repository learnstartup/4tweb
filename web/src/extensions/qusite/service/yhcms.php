<?php
/**
 * 
 *
 * @author 杨周 <yzhou91@aliyun-inc.com> QQ:89652519
 * @copyright ?2003-2103 phpwind.com
 * @license http://www.yhcms.com
 * @package wind
 */


class yhcms {
  /**
 * 写文件
 *
 * @param string $fileName 文件绝对路径
 * @param string $data 数据
 * @param string $method 读写模式
 * @param bool $ifLock 是否锁文件
 * @param bool $ifCheckPath 是否检查文件名中的“..”
 * @param bool $ifChmod 是否将文件属性改为可读写
 * @return bool 是否写入成功   :注意rb+创建新文件均返回的false,请用wb+
 */
function writeover($fileName, $data, $method = 'rb+', $ifLock = true, $ifCheckPath = true, $ifChmod = true) {
	$fileName = $this->escapePath($fileName, $ifCheckPath);
	touch($fileName);
	$handle = fopen($fileName, $method);
	$ifLock && flock($handle, LOCK_EX);
	$writeCheck = fwrite($handle, $data);
	$method == 'rb+' && ftruncate($handle, strlen($data));
	fclose($handle);
	$ifChmod && @chmod($fileName, 0777);
	return $writeCheck;
}

	/**
	 * 路径转换
	 * @param $fileName
	 * @param $ifCheck
	 * @return string
	 */
	function escapePath($fileName, $ifCheck = true) {
		if (!$this->_escapePath($fileName, $ifCheck)) {
			exit('Forbidden');
		}
		return $fileName;
	}
		/**
	 * 私用路径转换
	 * @param $fileName
	 * @param $ifCheck
	 * @return boolean
	 */
	function _escapePath($fileName, $ifCheck = true) {
		$tmpname = strtolower($fileName);
		$tmparray = array('://',"\0");
		$ifCheck && $tmparray[] = '..';
		if (str_replace($tmparray, '', $tmpname) != $tmpname) {
			return false;
		}
		return true;
	}
}
?>