<?php

class HeadController extends PwBaseController {

	public function run() {
		if ($this->getInput('type', 'post') === 'do') {
			$type = $this->getInput('searchtype', 'post');
			$keyword = $this->getInput('keyword', 'post');
			$headDao = Wekit::load('EXT:4tschool.service.head.App_Head');
			switch ($type) {
				case'M':
					$results = $headDao->searchMerchandise($keyword);
					break;
				case'S':
					$results = $headDao->searchShop($keyword);
					break;
				default :
					break;
			}
			if (!empty($results)) {
				print_r($results);
			}
		}
	}

	public function searchAction() {
		
	}

}