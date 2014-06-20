<?php
Wind::import('EXT:4tschool.service.boutique.dm.App_Boutique_Dm');
Wind::import('EXT:4tschool.admin.T4AdminBaseController');
class BoutiqueController extends T4AdminBaseController {
	
	public function run() 
	{
		$this->_setNavType('boutique');

		list($choosenSchoolId,$isActive)=$this->getInput(array('choosenschoolid','isactive'),'get');
		$this->setOutput($isActive,'isActive');
		$this->setOutput($choosenSchoolId,'choosenschoolid');
		// print_r($choosenSchoolId);

		if (empty($choosenSchoolId) && empty($isActive)) {
			$boutiqueList=$this->_getBoutiqueDs()->getBoutiques();
		}
		elseif (empty($choosenSchoolId)) {
			$boutiqueList=$this->_getBoutiqueDs()->getBoutiques($isActive);
		}
		else{
			$boutiqueList=$this->_getBoutiqueDs()->getBoutiquesBySchoolId($choosenSchoolId,$isActive);
		}
		
		$this->setOutput($boutiqueList,"boutiqueList");

        $allSchool = $this->_get4TSchoolDS()->getOpenedSchools();	
        $allSchool = array_values($allSchool);
        $this->setOutput($allSchool,"allSchool");

	}
	
	public function dorunAction()
	{
		list($data,$newData) = $this->getInput(array('data', 'newdata'), 'post');

		foreach ($data as $item) {
			if (!$item['link']||!$item['type']) continue;

			$dm=new App_Boutique_Dm();
			$dm->setSchoolId($item['schoolid'])
			  ->setType($item['type'])
			  // ->setImgUrl($item['imgurl'])
			  ->setLink($item['link'])
			  ->setDescription($item['description'])
			  ->setStartDate($item['startdate'])
			  ->setEndDate($item['enddate'])
			  ->setLastUpdateTime(Pw::getTime());

			$r=$this->_getBoutiqueDs()->update($item['id'],$dm);
		}

		foreach ($newData as $item) {
			if (!$item['link']||!$item['type']) continue;

			$dm=new App_Boutique_Dm();
			$dm->setSchoolId($item['schoolid'])
			  ->setType($item['type'])
			  // ->setImgUrl($item['imgurl'])
			  ->setLink($item['link'])
			  ->setDescription($item['description'])
			  ->setStartDate($item['startdate'])
			  ->setEndDate($item['enddate'])
			  ->setLastUpdateTime(Pw::getTime());

			$r=$this->_getBoutiqueDs()->add($dm);
		}

		print_r($r);

		die;
	}

	public function imguploadAction() {
		$id = $this->getInput('id');
		$schoolid = $this->getInput('sid');
		$imgUrl = $this->getInput('url');
		$this->setOutput($id, 'id');
		$this->setOutput($schoolid, 'sid');
		$this->setOutput($imgUrl, 'imgurl');

		if ($this->getInput('type', 'post') === 'do' && is_uploaded_file($_FILES["uploadimg"]["tmp_name"])) {
			list($id, $schoolid, $imgUrl) = $this->getInput(array('id', 'sid', 'imgurl'), 'post');

			if (empty($id) || empty($schoolid)) {
				$this->showError("未知的错误,请联系管理员");
			}

			$file = $_FILES["uploadimg"];

			//check the uploaded file whether it is a image.
			$ext = strtolower(substr(strrchr($file['name'], '.'), 1));
			
			if (!$this->isImage($ext)) {
				$this->showError("文件格式不正确!");
			}

			//build dir
			$image_path = '/uploaded_images/boutique/' . $schoolid . '/';
			$destination_folder = dirname(dirname(__FILE__)) . $image_path;

			if (!file_exists($destination_folder)) {
				mkdir($destination_folder);
			}

			$imgName = $id . "." . $ext;
			$destination = $destination_folder . $imgName;

			//if the image of current merchandise already exists, change the exists one to history.
			if (file_exists($destination)) {

				$imgHistory = $destination_folder . $id . "_" . "hist" . "_" . time() . "." . $ext;
				rename($destination, $imgHistory);
			}

			//save image and stroage url to db.
			if (move_uploaded_file($file['tmp_name'], $destination)) {
				$url = $image_path . $imgName;

				if ($this->saveUrl($id, $url)) {
					$this->showMessage("上传成功！");
				}
			}
		}
	}

	public function previewAction (){
		$id=$this->getInput('id');
		$boutique=$this->_getBoutiqueDs()->get($id);
		$boutique['imgurl']=$this->getDomain() . str_replace('\\', '/', $boutique['imgurl']);
		$this->setOutput($boutique,'boutique');
	}

	//ajax method
	public function releaseAction (){
		list($id,$release)=$this->getInput(array('id','release'));

		$dm=new App_Boutique_Dm();
		$dm->setIsRelease($release)
		   ->setLastUpdateTime(Pw::getTime());

		$r=$this->_getBoutiqueDs()->update($id,$dm);

		print_r($r);
		die;
	}

	public function saveUrl($id, $url) {
		$dm = new App_Boutique_Dm();
		$dm->setImgUrl($url)
		    ->setLastUpdateTime(Pw::getTime());
		$r = $this->_getBoutiqueDs()->update($id, $dm);
		return $r;
	}

	public function isImage($ext) {
		return in_array($ext, array('gif', 'jpg', 'jpeg', 'png', 'bmp', 'swf'));
	}	

	/**
	 * 删除处理器
	 *
	 * @return void
	 */
	public function delAction() {
		$id = $this->getInput('id', 'get');

		// $r = $this->_getNavDs()->delNav($navid);
		$r = $this->_getBoutiqueDs()->delete($id);
		// if ($r instanceof PwError) $this->showError($r->getError());

		$this->showMessage($r);
	}	

    /**
     * @return App_Boutique
     */
    private function _getBoutiqueDs()
    {
        return Wekit::load('EXT:4tschool.service.boutique.App_Boutique');
    }

    /**
     * @return App_School
     */
    private function _get4TSchoolDS()
    {
        return Wekit::load('EXT:4tschool.service.school.App_School');
    }    

}