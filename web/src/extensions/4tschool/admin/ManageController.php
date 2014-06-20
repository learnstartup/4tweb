<?php

Wind::import('EXT:4tschool.admin.T4AdminBaseController');
Wind::import('EXT:4tschool.service.tag.dm.App_Tag_Dm');

class ManageController extends T4AdminBaseController {

	private $pageNumber = 5;
	
	public function run() {
		$this->_setNavType('manage');

		$tagDao = Wekit::load('EXT:4tschool.service.tag.App_Tag');
		
		$allTag=$tagDao->getAllTags();
		$allTag=array_values($allTag);
		
		$this->setOutput($allTag, 'allTag');
	}	

	public function addAction() {
		if ($this->getInput('type','post') === 'do') {
			
			$tagName=$this->getInput('tagname','post');
			
			if (empty($tagName)) {
				$this->showError('请输入Tag名称');
				return;
			}
			else{				
				$hasDuplicate = Wekit::load('EXT:4tschool.service.tag.App_Tag')->checkDuplicateName($tagName);
				
				if ($hasDuplicate) {
					$this->showError('Tag:'.'"'.$tagName.'"'.'已存在');
					return;
				}
				
				$tagdao = Wekit::load('EXT:4tschool.service.tag.App_Tag');
				$tag['name']=  $tagName;
				$tag['issystem']= $this->getInput('tagtype');
				$tag['createdate']= Pw::getTime();
				$tag['lastupdatetime']= Pw::getTime();
				$dm=new App_Tag_Dm();
				$dm->setTag($tag);
				$tagdao->add($dm);
				$this->showMessage('添加成功');
			}	
		}
	}
	
	public function editAction()
	{
		$tagId=$this->getInput('id','Request');
		$tagName=$this->getInput('name','Request');
		$tagType=$this->getInput('type','Request');
		if ($this->getInput('type', 'post') === 'do') {
			
			$tagName=  $this->getInput('tagname','post');
			
			if (empty($tagName)) {
				$this->showError('请输入Tag名称');
				return;
			}
			
			$hasDuplicate = Wekit::load('EXT:4tschool.service.tag.App_Tag')->checkDuplicateName($tagName);
			
			if ($hasDuplicate) {
				$this->showError('Tag:'.'"'.$tagName.'"'.'已存在');
				return;
			}
			
			$tagdao = Wekit::load('EXT:4tschool.service.tag.App_Tag');
			
			$dm=new App_Tag_Dm();
			$dm->setTagName($tagName)
			    ->setLastUpdateTime(Pw::getTime());

			$tagdao->update($tagId,$dm);
			$this->showMessage('更新成功');
		}else{
			$this->setOutput($tagId,'tagId');
			$this->setOutput($tagName,'tagName');
			$this->setOutput($tagType,'tagType');
		}
	}


	private function _loadConfigService() {
		return Wekit::load('config.PwConfig');
	}

}