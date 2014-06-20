<?php
Wind::import('EXT:4tschool.admin.T4AdminBaseController');
Wind::import('EXT:4tschool.service.tag.dm.App_SysTag_Tree_Dm');

class SysTagTreeController extends T4AdminBaseController {

	private $pageNumber = 5;
	
	public function run() {
		$this->_setNavType('systagtree');

		$tagList=$this->_getTagDs()->getSysTags();
		$tagList=array_values($tagList);
		$this->setOutput($tagList, 'tagList');

		$key_tree_list=$this->buildTreeList();

		$treeListJsonStr=json_encode($key_tree_list[count($key_tree_list)]);
		$this->setOutput($treeListJsonStr,'treeList');
	}	

	public function saveAsNewVersionAction()
	{
		$des=$this->getInput("des","post");
		$type=$this->getInput("type","post");
		$json=json_encode($this->getInput("data","post"));

		$dm=new App_SysTag_Tree_Dm();
		$dm -> setJson($json)
		    -> setDescription($des)
		    -> setType($type);

		$r=$this->_getSysTagTreeDs()->add($dm);

		print_r($r);
		die;
	}

	public function createNewTypeAction()
	{
		$type=$this->getInput("type","post");
		$json=json_encode($this->getInput("data","post"));

		$dm=new App_SysTag_Tree_Dm();
		$dm->setJson($json)
		   ->setDescription("base version")
		   ->setType($type);

		$r=$this->_getSysTagTreeDs()->add($dm);

		print_r($r);
		die;
	}

	public function getSysTagTreeVersionByTypeAction (){
		$type=$this->getInput("type","post");
		$tree_version_list=array();

		$treeList=$this->_getSysTagTreeDs()->getSysTagTrees();
		foreach ($treeList as $key => $value) {
			if ($type==$value['type']||$type=="ALL") {
				$tree_version_list[$key]['id']=$value['id'];
				$tree_version_list[$key]['value']=$value['description'].'['.$value['createdate'].']';
			}
		}
		print_r(json_encode($tree_version_list));
		die;
	}

	public function getSysTagTreeByIdAction(){
		$id=$this->getInput("id","post");

		$key_tree_list=$this->buildTreeList();

		$r=$key_tree_list[$id];

		print_r(json_encode($r));
		die;
	}

	public function buildTreeList (){	
	    $key_tree_list=array();
	    $tree_version_list=array();
	    $tree_type_list=array();	

		$treeList=$this->_getSysTagTreeDs()->getSysTagTrees();
		// print_r($treeList);

		foreach ($treeList as $key => $value) {
			$key_tree_list[$value['id']]=$value;
			$tree_version_list[$value['id']]=$value['description'].'['.$value['createdate'].']';
			$tree_type_list[$value['id']]=$value['type'];
		}
		$this->setOutput($tree_version_list,"treeVersion");

		$tree_type_list['0']="ALL";
		$tree_type_list=array_unique($tree_type_list);
		// print_r(array_unique($tree_type_list));
		$this->setOutput($tree_type_list,"treeType");

		return $key_tree_list;
	}

	private function _getTagDs() {
		return Wekit::load('EXT:4tschool.service.tag.App_Tag');
	}

	private function _getSysTagTreeDs() {
		return Wekit::load('EXT:4tschool.service.tag.App_SysTag_Tree');
	}	
}