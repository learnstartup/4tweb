<?php
Wind::import('EXT:4tschool.service.tag.dm.App_Tag_Dm');

class DataAdjustmentController extends PwBaseController {

	public function beforeAction($handlerAdapter) {
		parent::beforeAction($handlerAdapter);

	}


	public function run()
	{
		// $allTags=$this->_getTagDs()->getAllTags();
		// var_dump($allTags);
		$allMerchandises=$this->_getMerchandiseDs()->getAllMerchandises();
		// var_dump($allMerchandises);
		foreach ($allMerchandises as $item) {
			$tagidList[]=$item['tagid'];
		}
		// var_dump(count($tagidList));
		$tagidList=implode(',', $tagidList);
		// var_dump($tagidList);
		$tags=$this->_getTagDs()->getIncidentallyTags($tagidList);
		// var_dump($tags);
		$updateShopIdForTags=array();
		$index=0;
		foreach ($tags as $tag) {
			foreach ($allMerchandises as $mer) {
				if ($tag['issystem']==0&&$tag['id']==$mer['tagid']) {
					$index++;
					$updateShopIdForTags[$index]['tagid']=$mer['tagid'];
					$updateShopIdForTags[$index]['shopid']=$mer['shopid'];
					$updateShopIdForTags[$index]['name']=$tag['name'];
				}				
			}
		}		
		
		echo "需要更新shopid的tag(".count($updateShopIdForTags).")：";
		echo "<pre>";
		var_export($updateShopIdForTags);

		//update
		$count=0;
		foreach ($updateShopIdForTags as $item) {
			$count++;
			$dm=new App_Tag_Dm();
            $dm->setShopId($item['shopid'])
               ->setLastUpdateTime(Pw::getTime());
            $this->_getTagDs()->update($item['tagid'],$dm);
		}
		echo "<pre>";
		echo "成功更新".$count."个tag";
	}

	private function _getMerchandiseDs() {
		return Wekit::load('EXT:4tschool.service.merchandise.App_Merchandise');
	}

	private function _getTagDs() {
		return Wekit::load('EXT:4tschool.service.tag.App_Tag');
	}
}