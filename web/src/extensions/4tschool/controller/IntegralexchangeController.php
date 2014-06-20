<?php

Wind::import('EXT:4tschool.controller.T4BaseController');
/**
 */
class IntegralExchangeController extends T4BaseController {

	public function beforeAction($handlerAdapter) {
		parent::beforeAction($handlerAdapter);

		
	}

	public function run()
	{

		//print list
		//4th, special offer
		$specialOffers = array(
								0	=> array(
											"shopLink"	=>	"http://www.google.com",
											"shopName"	=>	"联通100元电话充值卡",
											"shopImage"	=>	"4tschool/images/exchange/liantong100.jpg",
											"merchandise"	=>	"联通100元电话充值卡",
											'priceOffer'	=>	"兑换积分:10000",
									),
								1	=> array(
											"shopLink"	=>	"http://www.google.com",
											"shopName"	=>	"联通50元电话充值卡",
											"shopImage"	=>	"4tschool/images/exchange/liantong50.jpg",
											"merchandise"	=>	"联通50元电话充值卡",
											'priceOffer'	=>	"兑换积分:5000",
									),
								3	=> array(
											"shopLink"	=>	"http://www.google.com",
											"shopName"	=>	"联通30元电话充值卡",
											"shopImage"	=>	"4tschool/images/exchange/liantong30.jpg",
											"merchandise"	=>	"联通30元电话充值卡",
											'priceOffer'	=>	"兑换积分:3000",
									),
								4	=> array(
											"shopLink"	=>	"http://www.google.com",
											"shopName"	=>	"电信100元电话充值卡",
											"shopImage"	=>	"4tschool/images/exchange/dianxin100.jpg",
											"merchandise"	=>	"电信100元电话充值卡",
											'priceOffer'	=>	"兑换积分:10000",
									),
								5	=> array(
											"shopLink"	=>	"http://www.google.com",
											"shopName"	=>	"电信50元电话充值卡",
											"shopImage"	=>	"4tschool/images/exchange/dianxin50.jpg",
											"merchandise"	=>	"电信50元电话充值卡",
											'priceOffer'	=>	"兑换积分:5000",
									),
								6	=> array(
											"shopLink"	=>	"http://www.google.com",
											"shopName"	=>	"电信30元电话充值卡",
											"shopImage"	=>	"4tschool/images/exchange/dianxin30.jpg",
											"merchandise"	=>	"电信30元电话充值卡",
											'priceOffer'	=>	"兑换积分:3000",
									),
								7	=> array(
											"shopLink"	=>	"http://www.google.com",
											"shopName"	=>	"移动100元电话充值卡",
											"shopImage"	=>	"4tschool/images/exchange/yidong100.jpg",
											"merchandise"	=>	"移动100元电话充值卡",
											'priceOffer'	=>	"兑换积分:10000",
									),
								8	=> array(
											"shopLink"	=>	"http://www.google.com",
											"shopName"	=>	"移动50元电话充值卡",
											"shopImage"	=>	"4tschool/images/exchange/yidong50.jpg",
											"merchandise"	=>	"移动50元电话充值卡",
											'priceOffer'	=>	"兑换积分:5000",
									),
								9	=> array(
											"shopLink"	=>	"http://www.google.com",
											"shopName"	=>	"移动30元电话充值卡",
											"shopImage"	=>	"4tschool/images/exchange/yidong30.jpg",
											"merchandise"	=>	"移动30元电话充值卡",
											'priceOffer'	=>	"兑换积分:3000",
									),
								10	=> array(
											"shopLink"	=>	"http://www.google.com",
											"shopName"	=>	"英雄联盟充值卡30元",
											"shopImage"	=>	"4tschool/images/exchange/yingxionglianmeng30.jpg",
											"merchandise"	=>	"英雄联盟充值卡30元",
											'priceOffer'	=>	"兑换积分:3000",
									),
								11	=> array(
											"shopLink"	=>	"http://www.google.com",
											"shopName"	=>	"地下城与勇士充值卡30元",
											"shopImage"	=>	"4tschool/images/exchange/dixiacheng30.jpg",
											"merchandise"	=>	"地下城与勇士充值卡30元",
											'priceOffer'	=>	"兑换积分:3000",
									),
								12	=> array(
											"shopLink"	=>	"http://www.google.com",
											"shopName"	=>	"鼠标",
											"shopImage"	=>	"4tschool/images/exchange/moshou30.jpg",
											"merchandise"	=>	"无线光电鼠标",
											'priceOffer'	=>	"兑换积分:3000",
									)

			);

		$this->setOutput($specialOffers,"specialOffers");

	}

	private function _getSchoolAreaDS()
	{
		return Wekit::load('EXT:4tschool.service.schoolarea.App_SchoolArea');
	}


	private function _getSchoolDS()
	{
		return Wekit::load('EXT:4tschool.service.school.App_School');
	}


}