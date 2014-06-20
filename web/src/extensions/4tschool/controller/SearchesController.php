<?php

class SearchesController extends PwBaseController {

	public function run() {
		if ($this->getInput('type', 'post') === 'do') {
			$type = $this->getInput('searchtype', 'post');
			$keyword = $this->getInput('keyword', 'post');
			switch ($type) {
				case'M':
					$results = $this->_getSearchDs()->searchMerchandise($keyword);
					break;
				case'S':
					$results = $this->_getSearchDs()->searchShop($keyword);
					break;
				default :
					break;
			}
			if (!empty($results)) {
				// print_r($results);
			}
		}
	}

	public function searchAction() {
		
	}

	private function _getSearchDs() {
		return Wekit::load('EXT:4tschool.service.searches.App_Search');
	}

}