<?php

// jCart v1.3
// http://conceptlogic.com/jcart/

// By default, this file returns the $config array for use with PHP scripts
// If requested via Ajax, the array is encoded as JSON and echoed out to the browser

// Don't edit here, edit config.php
include_once('config.php');

// Use default values for any settings that have been left empty
if (!$config['currencyCode']) $config['currencyCode']                     = '元';
if (!$config['text']['cartTitle']) $config['text']['cartTitle']           = '购物车';
if (!$config['text']['singleItem']) $config['text']['singleItem']         = '';
if (!$config['text']['multipleItems']) $config['text']['multipleItems']   = '';
if (!$config['text']['subtotal']) $config['text']['subtotal']             = '小计';
if (!$config['text']['update']) $config['text']['update']                 = '更新';
if (!$config['text']['checkout']) $config['text']['checkout']             = '结算';
if (!$config['text']['checkoutPaypal']) $config['text']['checkoutPaypal'] = 'Checkout with PayPal';
if (!$config['text']['removeLink']) $config['text']['removeLink']         = '移除';
if (!$config['text']['emptyButton']) $config['text']['emptyButton']       = '清空';
if (!$config['text']['emptyMessage']) $config['text']['emptyMessage']     = '您的购物车是空的!';
if (!$config['text']['itemAdded']) $config['text']['itemAdded']           = '商品添加成功!';
if (!$config['text']['priceError']) $config['text']['priceError']         = '无效的价格格式!';
if (!$config['text']['quantityError']) $config['text']['quantityError']   = '商品数量必须是整数哦!';
if (!$config['text']['checkoutError']) $config['text']['checkoutError']   = '您的订单处理失败!';

if ($_GET['ajax'] == 'true') {
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($config);	
}
?>