<?php

// jCart v1.3
// http://conceptlogic.com/jcart/

// Do NOT store any sensitive info in this file!!!
// It's loaded into the browser as plain text via Ajax


////////////////////////////////////////////////////////////////////////////////
// REQUIRED SETTINGS

// Path to your jcart files
$config['jcartPath'] = 'jcart/';

// Path to your checkout page
$config['checkoutPath'] = '';

// The HTML name attributes used in your item forms
$config['item']['id'] = 'my-item-id'; // Item id
$config['item']['name'] = 'my-item-name'; // Item name
$config['item']['price'] = 'my-item-price'; // Item price
$config['item']['qty'] = 'my-item-qty'; // Item quantity
$config['item']['dmoney'] = 'my-item-dmoney';// Item dmoney
$config['item']['url'] = 'my-item-url'; // Item URL (optional)
$config['item']['add'] = 'my-add-button'; // Add to cart button
$config['item']['vendor'] = 'my-vendor-guid'; //shop id
$config['item']['vendorname'] = 'my-vendor-name'; //shop name
$config['item']['promo']='my-promo';
$config['item']['needPackingPrice']='my-needPackingPrice';
$config['item']['startingprice']='my-startingprice';

// Your PayPal secure merchant ID
// Found here: https://www.paypal.com/webapps/customerprofile/summary.view
// $config['paypal']['id'] = 'seller_1282188508_biz@conceptlogic.com';

////////////////////////////////////////////////////////////////////////////////
// OPTIONAL SETTINGS

// Three-letter currency code, defaults to USD if empty
// See available options here: http://j.mp/agNsTx
$config['currencyCode'] = 'CNY';

// Add a unique token to form posts to prevent CSRF exploits
// Learn more: http://conceptlogic.com/jcart/security.php
$config['csrfToken'] = true;

// Override default cart text
$config['text']['cartTitle'] = '我的美食篮'; // Shopping Cart
$config['text']['singleItem'] = ''; // Item
$config['text']['multipleItems'] = ''; // Items
$config['text']['subtotal'] = '总计'; // Subtotal
$config['text']['update'] = ''; // update
$config['text']['checkout'] = ''; // checkout
$config['text']['checkoutPaypal'] = ''; // Checkout with PayPal
$config['text']['removeLink'] = '删除'; // remove
$config['text']['emptyButton'] = ''; // empty
$config['text']['emptyMessage'] = '您的篮子还是空的哟,'; // Your cart is empty!
$config['text']['itemAdded'] = '添加成功!'; // Item added!
$config['text']['priceError'] = ''; // Invalid price format!
$config['text']['quantityError'] = ''; // Item quantities must be whole numbers!
$config['text']['checkoutError'] = ''; // Your order could not be processed!
$config['text']['totalIntegral'] = '您将获得积分';
$config['text']['totalDMoney'] = '该订单可返点币';
// Override the default buttons by entering paths to your button images
$config['button']['checkout'] = '';
$config['button']['paypal'] = '';
$config['button']['update'] = '';
$config['button']['empty'] = '';


////////////////////////////////////////////////////////////////////////////////
// ADVANCED SETTINGS

// Display tooltip after the visitor adds an item to their cart?
$config['tooltip'] = false;

// Allow decimals in item quantities?
$config['decimalQtys'] = false;

// How many decimal places are allowed?
$config['decimalPlaces'] = 1;

// Number format for prices, see: http://php.net/manual/en/function.number-format.php
$config['priceFormat'] = array('decimals' => 2, 'dec_point' => '.', 'thousands_sep' => ',');

// Send visitor to PayPal via HTTPS?
$config['paypal']['https'] = true;

// Use PayPal sandbox?
$config['paypal']['sandbox'] = false;

// The URL a visitor is returned to after completing their PayPal transaction
$config['paypal']['returnUrl'] = '';

// The URL of your PayPal IPN script
$config['paypal']['notifyUrl'] = '';

?>