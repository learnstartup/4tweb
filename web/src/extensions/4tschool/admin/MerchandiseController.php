<?php

Wind::import('EXT:4tschool.admin.T4AdminBaseController');
Wind::import('EXT:4tschool.service.merchandise.dm.App_Merchandise_Dm');
Wind::import('EXT:4tschool.service.merchandise.dm.App_Merchandise_Tag_Dm');

class MerchandiseController extends T4AdminBaseController {

	private $pageNumber = 10;

	public function run() {
		$this->_setNavType('merchandise');

		$shopList = $this->_getShopDs()->getAllShops(array('choosenShopid'=>'-1', 
														   'isactive'=>'-1', 
														   'ispartner'=>'-1',
														   'isaudit' =>'-1'));
		$shopList = array_values($shopList);
		$this->setOutput($shopList, 'shopList');

		$choosenShopid = $this->getInput('choosenShopid');
		if (!isset($choosenShopid) || $choosenShopid <= 0) {
			$choosenShopid = $shopList[0]['id'];
		}

		//check if the shop id come from search,
		if ($this->getInput('type', 'post') === 'search') {	
			$choosenShopid = $this->getInput('searchShopid', 'post');
		}

		//分页
		$page = $this->getInput('page');
		$selectedFilter = $this->getInput('selectedFilter');

        $count =  $this->_getMerchandiseDs()->countGetMerchandiseByShopId($choosenShopid, $schoolId);
        if (!empty($selectedFilter))
		{
			$para = explode('_',$selectedFilter);
			$count = $this->_getMerchandiseDs()->CountGetMerchandiseBySpecialFilter($para[0],$para[1]);
		}

        if (0 < $count) 
        {
          $totalPage = ceil($count/$this->pageNumber);
          $page > $totalPage && $page = $totalPage;
          list($start, $limit) = Pw::page2limit($page, $this->pageNumber);

          if($page <= 0)
            $page = 1;
        }

		$merchandiseList = $this->_getMerchandiseDs()->getMerchandiseByShopId($choosenShopid, $schoolId, $start, $limit);
		if (!empty($selectedFilter)) {
			$para = explode('_', $selectedFilter);
			$merchandiseList = $this->_getMerchandiseDs()->getMerchandiseBySpecialFilter($para[0],$para[1], $schoolId, $start, $limit);
			$this->setOutput($para[0],"selectedFilter");
		}

		$args['choosenShopid'] = $choosenShopid;
		$args['selectedFilter'] = $selectedFilter;
		$args['isall'] = 'all';
		
		$this->setOutput($choosenShopid, "choosenShopid");
		$this->setOutput($merchandiseList, 'merchandiseList');
		$this->setOutput($count, 'count');  
        $this->setOutput($page, 'page');
        $this->setOutput($args, 'args');
        $this->setOutput($this->pageNumber, 'perPage');

        $isall = $this->getInput("isall");
		$this->renderSpecialList($isall);
	}

	public function addAction() {

		$shopid = $this->getInput('shopid', 'get');

		$this->setOutput($shopid, 'shopid');

		//Get all shop, then choose one and add merchandise
		$shopList = $this->_getShopDs()->getAllShops(array('choosenShopid'=>'-1', 
														   'isactive'=>'-1', 
														   'ispartner'=>'-1',
														   'isaudit'=>'-1'));
		$shopList = array_values($shopList);
		$this->setOutput($shopList, 'shopList');
		//Submit form, get and save new merchandise
		if ($this->getInput('type', 'post') === 'do') {
			$shopid = $this->getInput('choosenShopid', 'post');
			list($foodNameList, 
				 $priceList, 
				 $unitList, 
				 $remainderList, 
				 $descriptionList, 
				 $descriptionUrList, 
				 $tagList,
				 $needPackingPrice,
				 $willRecommend,
				 $isActive) = $this->getInput(array('foodname', 
				 									'price', 
				 									'unit', 
				 									'remainder', 
				 									'description', 
				 									'descriptionurl', 
				 									'tag',
				 									'needPackingPrice',
				 									'willRecommend',
				 									'isActive'), 'post');
			
			//verify data
			if(false == $this->verfiyNotEmpty($foodNameList))
			{
				$this->showError("更新失败,菜品名字不能为空 ");
			}

			if(false == $this->verfiyNotEmpty($priceList))
			{
				$this->showError("更新失败,菜品价格不能为空 ");
			}

			if(false == $this->verfiyNotEmpty($unitList))
			{
				$this->showError("更新失败,菜品单位不能为空 ");
			}

			if(false == $this->verfiyNotEmpty($remainderList))
			{
				$this->showError("更新失败,菜品数量不能为空 ");
			}


			//Merchandise support batch added
			for ($i = 0; $i <= count($foodNameList)-1; $i++) {
				$dm = new App_Merchandise_Dm();
				$dm->setMerchandiseName($foodNameList[$i])
				    ->setShopId($shopid)
				    ->setNeedPackingPrice($needPackingPrice[$i])
				    ->setPrice($priceList[$i])
                    ->setCurrentPrice($priceList[$i])
				    ->setUnit($unitList[$i])
				    ->setRemainder($remainderList[$i])
				    ->setRecommend($willRecommend[$i])
				    ->setActive($isActive[$i])
				    ->setDescription($descriptionList[$i])
				    ->setDescriptionUrl($descriptionUrList[$i])
				    ->setTagId($tagList[$i])
				    ->setCreateDate(Pw::getTime())
				    ->setLastUpdateTime(Pw::getTime());
				$this->_getMerchandiseDs()->add($dm);
			}
			$this->showMessage("添加成功");
			return;
		}
		
		$tagList = $this->_getTagDs()->getAllTags();
		$tagList = array_values($tagList);
		$this->setOutput($tagList, 'tagList');
	}

	public function editAction() {
		if ($this->getInput('type', 'post') === 'do') {
			$merchandiseId = $this->getInput('id', 'request');
			list($foodName, 
				 $price, 
				 $currentprice, 
				 $unit, 
				 $remainder, 
				 $description, 
				 $merchandisedescription,
				 $descriptionurl, 
				 $tag, 
				 $needPackingPrice, 
				 $willRecommend, 
				 $isActive, 
				 $isStar, 
				 $sysTags) = $this->getInput(array('foodname', 
				 								   'price', 
				 								   'currentprice',
				 								   'unit', 
				 								   'remainder', 
				 								   'description', 
				 								   'merchandisedescription',
				 								   'descriptionurl',
				 								   'choosenTagid',
				 								   'needPackingPrice',
				 								   'willRecommend',
				 								   'isActive', 
				 								   'isStar',
				 								   'systags'), 'post');
            //33||34||35||
			// $this->showError($sysTags);
			$sysTagList=explode('||', $sysTags);
			$r=$this->_getMerchandiseDs()->deleteMerchandiseTag($merchandiseId);
			if(!empty($sysTagList[0])){
				// $this->showError($r);
			    foreach ($sysTagList as $key => $value) {
				  if (!empty($value)) {
					  $dm = new App_Merchandise_Tag_Dm();
					  $dm->setMid($merchandiseId)
					     ->setTid($value);
					  $this->_getMerchandiseDs()->addMerchandiseTag($dm);
					  // $this->showError($r);
				  }
			   }				
			};


			$dm = new App_Merchandise_Dm();
			$dm->setMerchandiseName($foodName)
			    ->setPrice($price)
			    ->setCurrentPrice($currentprice)
			    ->setNeedPackingPrice($needPackingPrice)
			    ->setUnit($unit)
			    ->setRemainder($remainder)
			    ->setActive($isActive)
			    ->setIsStar($isStar)
			    ->setRecommend($willRecommend)
			    ->setDescription($description)
			    ->setMerchandiseDescription($merchandisedescription)
			    ->setDescriptionUrl($descriptionurl)
			    ->setTagId($tag)
			    ->setLastUpdateTime(Pw::getTime());

			$result = $this->_getMerchandiseDs()->update($merchandiseId, $dm);
			if ($result == 1) {
				$this->showMessage("更新成功");
			} else {
				$this->showError("更新失败,请联系管理员");
			}
			return;
		}

		$merchandiseId = $this->getInput('id', 'request');
		$merchandise = $this->_getMerchandiseDs()->getMerchandiseById($merchandiseId);
		$this->setOutput($merchandise, 'merchandise');

		$tagList =  $this->_getTagDs()->getAllTags();
		$tagList = array_values($tagList);
		$this->setOutput($tagList, 'tagList');

		//set seleted system tag for merchandise
		$selectedSysTagList=$this->_getMerchandiseDs()->getMerchandiseTagsByMid($merchandiseId);
		$sysTagList=$this->_getTagDs()->getSysTags();
		$sysTagList=array_values($sysTagList);
		foreach ($sysTagList as $key => $sysTag) {
			$sysTagList[$key]['selected']="";
			foreach ($selectedSysTagList as $selectedTag) {
				if ($sysTag['id']==$selectedTag['tid']) {
					$sysTagList[$key]['selected']="selected";
				}
			}
		}
		// print_r($sysTagList);
		$this->setOutput($sysTagList, 'sysTagList');		
	}

	public function imguploadAction() {
		$shopId = $this->getInput('sid');
		$merchandiseId = $this->getInput('mid');
		$imageUrl = $this->getInput('url');
		$this->setOutput($shopId, 'shopId');
		$this->setOutput($merchandiseId, 'merchandiseId');
		$this->setOutput($imageUrl, 'imageUrl');

		if ($this->getInput('type', 'post') === 'do' && is_uploaded_file($_FILES["uploadimg"]["tmp_name"])) {
			list($shopId, $merchandiseId, $imageUrl) = $this->getInput(array('shopid', 'merchandiseid', 'imageurl'), 'post');

			if (empty($merchandiseId) || empty($shopId)) {
				$this->showError("未知的错误,请联系管理员");
			}

			$file = $_FILES["uploadimg"];

			//check the uploaded file whether it is a image.
			$ext = strtolower(substr(strrchr($file['name'], '.'), 1));
			if (!$this->isImage($ext)) {
				$this->showError("文件格式不正确!");
			}

			//build dir
			$image_path = '/uploaded_images/' . $shopId . '/';
			$destination_folder = dirname(dirname(__FILE__)) . $image_path;

			if (!file_exists($destination_folder)) {
				mkdir($destination_folder);
			}

			$imgName = $merchandiseId . "." . $ext;
			$destination = $destination_folder . $imgName;

			//if the image of current merchandise already exists, change the exists one to history.
			if (file_exists($destination)) {

				$imgHistory = $destination_folder . $merchandiseId . "_" . "hist" . "_" . time() . "." . $ext;
				rename($destination, $imgHistory);
			}

			//save image and stroage url to db.
			if (move_uploaded_file($file['tmp_name'], $destination)) {
				$url = $image_path . $imgName;

				$this->saveUrl($merchandiseId, $url);
				// if (empty($imageUrl)) {
				// 	$this->saveUrl($merchandiseId, $url);
				// }
				$this->showMessage("上传成功！");
			}
		}
	}

	public function noitemAction()
	{
		$shopList = $this->_getShopDs()->getAllShops(array('choosenShopid'=>'-1', 
			                                               'isactive'=>'-1', 
			                                               'ispartner'=>'-1',
			                                               'isaudit'=>'-1'));
		$shopList = array_values($shopList);
		$this->setOutput($shopList, 'shopList');

		$merchandiseList = $this->_getMerchandiseDs()->getNoItemMerchandisesBySchool(11045); //没办法，暂时写死吧
		$this->setOutput($merchandiseList,"merchandiseList");
	}

	public function markAsHasItemAction()
	{
		$returnData = array(
			"success"	=> true,
			"data"	=> "更新成功，页面会刷新"
			);

		$itemid = $this->getInput("noitemid");
		if($itemid > 0)
		{
			//update item count to 100
			$dm = new App_Merchandise_Dm();
			$dm->setRemainder(100)
			    ->setLastUpdateTime(Pw::getTime());

			$result = $this->_getMerchandiseDs()->update($itemid, $dm);

			print_r(json_encode($returnData));die;

		}
		else
		{
			$returnData['success'] = false;
			$returnData['data'] = '更新失败';

			print_r(json_encode($returnData));die;

		}
	}

	public function renderSpecialList ($isall){
		if(empty($isall))
		{
			$specialList=array(
			"active"=>array("name"=>"所有未上架的菜","value"=>"0"),
			"recommend"=>array("name"=>"所有推荐菜","value"=>"1"),
			"isstar"=>array("name"=>"所有精品菜","value"=>"2")
			);
		}else{
			$specialList=array(
			"active"=>array("name"=>"所有上架的菜","value"=>"0"),
			"recommend"=>array("name"=>"所有推荐菜","value"=>"1"),
			"isstar"=>array("name"=>"所有精品菜","value"=>"2")
			);
		}
		$this->setOutput($specialList,"specialList");
	}

	public function isImage($ext) {
		return in_array($ext, array('gif', 'jpg', 'jpeg', 'png', 'bmp', 'swf'));
	}

	public function saveUrl($merchandiseId, $url) {
		$dm = new App_Merchandise_Dm();
		$dm->setImageUrl($url)
		    ->setLastUpdateTime(Pw::getTime());
		$result = $this->_getMerchandiseDs()->update($merchandiseId, $dm);
		return $result;
	}


	private function verfiyNotEmpty($dataArray)
	{
		foreach ($dataArray as $key => $value) {
			
			if(empty($value))
				return false;
		}

		return true;
	}

	private function _getMerchandiseDs() {
		return Wekit::load('EXT:4tschool.service.merchandise.App_Merchandise');
	}

	private function _getShopDs() {
		return Wekit::load('EXT:4tschool.service.shop.App_Shop');
	}

	private function _getTagDs() {
		return Wekit::load('EXT:4tschool.service.tag.App_Tag');
	}

}