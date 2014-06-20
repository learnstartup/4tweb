<?php

Wind::import('EXT:4tschool.admin.T4AdminBaseController');
Wind::import('EXT:4tschool.service.tag.dm.App_Tag_Dm');

class TagController extends T4AdminBaseController {
	
	public function run() {
		$this->_setNavType('tag');

		$tagList=  $this->_getTagDs()->getAllTags();
		$tagList=array_values($tagList);
		
		$this->setOutput($tagList, 'tagList');
	}	

	public function addAction() {
		if ($this->getInput('type','post') === 'do') {
			
			$tagName=$this->getInput('tagname','post');
			
			if (empty($tagName)) {
				$this->showError('请输入Tag名称');
				return;
			}
			else{				
				$hasDuplicate = $this->_getTagDs()->checkDuplicateName($tagName);
				
				if ($hasDuplicate) {
					$this->showError('Tag:'.'"'.$tagName.'"'.'已存在');
					return;;
				}
				
				$tag['name']=  $tagName;
				$tag['issystem']= $this->getInput('tagtype');
				$tag['createdate']= Pw::getTime();
				$tag['lastupdatetime']= Pw::getTime();
				$dm=new App_Tag_Dm();
				$dm->setTag($tag);
				$this->_getTagDs()->add($dm);
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
			
			$hasDuplicate = $this->_getTagDs()->checkDuplicateName($tagName);
			
			if ($hasDuplicate) {
				$this->showError('Tag:'.'"'.$tagName.'"'.'已存在');
				return;
			}

			$dm=new App_Tag_Dm();
			$dm->setTagName($tagName)
			    ->setLastUpdateTime(Pw::getTime());

			$this->_getTagDs()->update($tagId,$dm);
			$this->showMessage('更新成功');
		}else{
			$this->setOutput($tagId,'tagId');
			$this->setOutput($tagName,'tagName');
			$this->setOutput($tagType,'tagType');
		}
	}


	private function _getTagDs() {
		return Wekit::load('EXT:4tschool.service.tag.App_Tag');
	}

}