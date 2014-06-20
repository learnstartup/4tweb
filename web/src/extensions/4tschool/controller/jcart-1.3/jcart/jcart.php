<?php

// jCart v1.3
// http://conceptlogic.com/jcart/

// Cart logic based on Webforce Cart: http://www.webforcecart.com/
class Jcart
{

    public $config = array();
    private $items = array();
    private $names = array();
    private $prices = array();
    private $qtys = array();
    private $dmoneys = array();
    private $urls = array();
    private $shops = array();
    private $itemPackingPrice = array();
    private $needPackingPrices = array();
    private $startingprice = array();
    private $promos = array();
    private $vendors = array();
    private $perShopSubtotal = array();
    private $packingPrice = array();
    private $totalIntegral = 0;
    private $totalDMoney = 0;
    private $subtotal = 0;
    private $itemCount = 0;
    private $integralCal;
    private $redirectUrl;
    private $inOrderPreview;

    function __construct()
    {

        // Get $config array
        include_once('config-loader.php');
        $this->config = $config;
        $this->integralCal = new Integral();
    }

    /**
     * Get cart contents
     *
     * @return array
     */
    public function get_contents()
    {
        $items = array();
        foreach ($this->items as $tmpItem) {
            $item = null;
            $item['id'] = $tmpItem;
            $item['name'] = $this->names[$tmpItem];
            $item['price'] = $this->prices[$tmpItem];
            $item['qty'] = $this->qtys[$tmpItem];
            $item['dmoney'] = $this->dmoneys[$tmpItem];
            $item['url'] = $this->urls[$tmpItem];
            $item['vendor'] = $this->vendors[$tmpItem];
            $item['itemPackingPrice'] = $this->itemPackingPrice[$tmpItem];
            //$item['promo'] = $this->promos[$tmpItem];
            $item['integral'] = $this->integralCal->get_integral($this->prices[$tmpItem], 'Dessert', $item['qty']);
            $item['subtotal'] = ($item['price'] + $item['itemPackingPrice']) * $item['qty'];
            $item['totalIntegral'] = $this->totalIntegral;
            $item['needPackingPrice'] = $this->needPackingPrices[$tmpItem];
            $item['startingprice'] = $this->startingprice[$tmpItem];
            $items[] = $item;
        }
        return $items;
    }

    public function get_count()
    {
        return $this->itemCount;
    }

    public function set_redirect_url($url = null)
    {
        $this->redirectUrl = $url;
    }

    public function in_order_preview($bool = false)
    {
        $this->inOrderPreview = $bool;
    }

    public function set_packing_price($shopid,$price)
    {
        $this->packingPrice[$shopid] = $price;
    }

    public function get_subtotal()
    {
        return $this->subtotal;
    }

    public function get_shops()
    {
        $items = array();
        foreach ($this->shops as $key => $tmpItem) {
            $item = null;
            $item['shopid'] = $key;
            $item['shopname'] = $tmpItem['shopname'];
            $items[] = $item;
        }
        return $items;
    }

    public function get_merchandises ()
    {
        $items = array();
        foreach ($this->get_contents() as $key => $item) {
            $items[$key]['id']=$item['id'];
            $items[$key]['shopid']=$item['vendor'];
            $items[$key]['qty']=$item['qty'];
        }
        return $items;
    }

    public function get_shop_subtotal()
    {
        $items = array();
        foreach ($this->perShopSubtotal as $key => $tmpItem) {
            $items[$key]=$tmpItem;
        }
        return $items;
    }

    public function clearItemsByshopId ($shopid){
        foreach ($this->get_contents() as $key => $item) {
            if ($item['vendor']==$shopid) {
                $this->remove_item($item['id']);
            }
        }
    }

    private function update_shop_subtotal()
    {
        if (sizeof($this->items > 0)) {
            $this->perShopSubtotal = array();
            foreach ($this->get_shops() as $shop) {
                $subtotal = 0;
                foreach ($this->get_contents() as $item) {
                    if ($item['vendor'] == $shop['shopid']) {
                        $subtotal += $item['subtotal'];
                    }
                }
                $this->perShopSubtotal[$shop['shopid']] = $subtotal;
            }
        }
    }

    private function add_shop($shopId, $shopName, $packingprice,$startingprice=0)
    {
        if (!array_key_exists($shopId, $this->shops)) {
            $this->shops[$shopId] = array('shopname' => $shopName, 'packingprice' => $packingprice[$shopId],'startingprice' => $startingprice);
        }
    }

    private function update_shops()
    {
        $shopsId = array();
        foreach ($this->get_contents() as $item) {
            if (!array_key_exists($item['vendor'], $shopsId)) {
                $shopsId[$item['vendor']] = $item['vendor'];
            }
        }
        foreach ($this->shops as $key => $item) {
            if (!array_key_exists($key, $shopsId)) {
                unset($this->shops[$key]);
            }
        }
    }

    /**
     * Add an item to the cart
     *
     * @param string $id
     * @param string $name
     * @param float $price
     * @param mixed $qty
     * @param string $url
     *
     * @return mixed
     */
    private function add_item($id, $name, $price, $qty = 1, $dmoney, $url, $vendor, $packingPrice, $promo,$needPackingPrice = 1,$startingprice =0)
    {

        $validPrice = false;
        $validQty = false;

        // Verify the price is numeric
        if (is_numeric($price)) {
            $validPrice = true;
        }

        // If decimal quantities are enabled, verify the quantity is a positive float
        if ($this->config['decimalQtys'] === true && filter_var($qty, FILTER_VALIDATE_FLOAT) && $qty > 0) {
            $validQty = true;
        } // By default, verify the quantity is a positive integer
        elseif (filter_var($qty, FILTER_VALIDATE_INT) && $qty > 0) {
            $validQty = true;
        }

        // Add the item
        if ($validPrice !== false && $validQty !== false) {

            // If the item is already in the cart, increase its quantity
            if (isset($this->qtys[$id]) && $this->qtys[$id] > 0) {
                $this->qtys[$id] += $qty;
                $this->update_subtotal();
                $this->update_total_dmoney();
            } // This is a new item
            else {
                $this->items[] = $id;
                $this->names[$id] = $name;
                $this->prices[$id] = $price;
                $this->qtys[$id] = $qty;
                $this->dmoneys[$id] = $dmoney;
                $this->urls[$id] = $url;
                $this->vendors[$id] = $vendor;
                $this->needPackingPrices[$id] = $needPackingPrice;
                //judge whether it is  identally merchandise
                if($needPackingPrice)
                    $this->itemPackingPrice[$id] = $packingPrice[$vendor];
                else
                    $this->itemPackingPrice[$id] = 0.0;
                //$this->promos[$id] = $promo;
                $this->startingprice[$id] = $startingprice;
            }
            $this->update_subtotal();
            $this->update_total_dmoney();
            $this->update_shop_subtotal();
            return true;
        } elseif ($validPrice !== true) {
            $errorType = 'price';
            return $errorType;
        } elseif ($validQty !== true) {
            $errorType = 'qty';
            return $errorType;
        }
    }

    /**
     * Update an item in the cart
     *
     * @param string $id
     * @param mixed $qty
     *
     * @return boolean
     */
    private function update_item($id, $qty)
    {

        // If the quantity is zero, no futher validation is required
        if ((int)$qty === 0) {
            $validQty = true;
        } // If decimal quantities are enabled, verify it's a float
        elseif ($this->config['decimalQtys'] === true && filter_var($qty, FILTER_VALIDATE_FLOAT)) {
            $validQty = true;
        } // By default, verify the quantity is an integer
        elseif (filter_var($qty, FILTER_VALIDATE_INT)) {
            $validQty = true;
        }

        // If it's a valid quantity, remove or update as necessary
        if ($validQty === true) {
            if ($qty < 1) {
                $this->remove_item($id);
            } else {
                $this->qtys[$id] = $qty;
            }
            $this->update_subtotal();
            $this->update_total_dmoney();
            $this->update_shop_subtotal();
            return true;
        }
    }


    /* Using post vars to remove items doesn't work because we have to pass the
    id of the item to be removed as the value of the button. If using an input
    with type submit, all browsers display the item id, instead of allowing for
    user-friendly text. If using an input with type image, IE does not submit
    the   value, only x and y coordinates where button was clicked. Can't use a
    hidden input either since the cart form has to encompass all items to
    recalculate   subtotal when a quantity is changed, which means there are
    multiple remove   buttons and no way to associate them with the correct
    hidden input. */

    /**
     * Reamove an item from the cart
     *
     * @param string $id   *
     */
    private function remove_item($id)
    {
        $tmpItems = array();

        unset($this->names[$id]);
        unset($this->prices[$id]);
        unset($this->qtys[$id]);
        unset($this->dmoneys[$id]);
        unset($this->urls[$id]);

        // Rebuild the items array, excluding the id we just removed
        foreach ($this->items as $item) {
            if ($item != $id) {
                $tmpItems[] = $item;
            }
        }

        $this->items = $tmpItems;
        $this->update_shops();
        $this->update_subtotal();
        $this->update_total_dmoney();
        $this->update_shop_subtotal();
    }

    /**
     * Empty the cart
     */
    public function empty_cart()
    {
        $this->items = array();
        $this->names = array();
        $this->prices = array();
        $this->qtys = array();
        $this->urls = array();
        $this->shops = array();
        $this->perShopSubtotal = array();
        $this->subtotal = 0;
        $this->itemCount = 0;
        $this->totalIntegral = 0;
        $this->totalDMoney = 0;
    }

    /**
     * Update the entire cart
     */
    public function update_cart()
    {

        // Post value is an array of all item quantities in the cart
        // Treat array as a string for validation
        if (isset($_POST['jcartItemQty']) && is_array($_POST['jcartItemQty'])) {
            $qtys = implode($_POST['jcartItemQty']);
        }

        // If no item ids, the cart is empty
        if (isset($_POST['jcartItemId'])) {

            $validQtys = false;

            // If decimal quantities are enabled, verify the combined string only contain digits and decimal points
            if ($this->config['decimalQtys'] === true && preg_match("/^[0-9.]+$/i", $qtys)) {
                $validQtys = true;
            } // By default, verify the string only contains integers
            elseif (filter_var($qtys, FILTER_VALIDATE_INT) || $qtys == '') {
                $validQtys = true;
            }

            if ($validQtys === true) {

                // The item index
                $count = 0;

                // For each item in the cart, remove or update as necessary
                foreach ($_POST['jcartItemId'] as $id) {

                    $qty = $_POST['jcartItemQty'][$count];

                    if ($qty < 1) {
                        $this->remove_item($id);
                    } else {
                        $this->update_item($id, $qty);
                    }

                    // Increment index for the next item
                    $count++;
                }
                return true;
            }
        } // If no items in the cart, return true to prevent unnecssary error message
        elseif (!isset($_POST['jcartItemId'])) {
            return true;
        }
    }

    /**
     * Recalculate subtotal
     */
    private function update_subtotal()
    {
        $this->itemCount = 0;
        $this->subtotal = 0;

        if (sizeof($this->items > 0)) {
            foreach ($this->items as $item) {
                $this->subtotal += ($this->qtys[$item] * ($this->prices[$item] + $this->itemPackingPrice[$item]));

                // Total number of items
                $this->itemCount += $this->qtys[$item];
            }
        }
    }

    private function update_total_dmoney ()
    {
        $this->totalDMoney=0;
        if (sizeof($this->items > 0)) {
            foreach ($this->items as $item) {
                $this->totalDMoney += ($this->qtys[$item] * $this->dmoneys[$item]);
            }
        }
    }

    /**
     * Process and display cart
     */
    public function display_cart()
    {

        $config = $this->config;
        $errorMessage = null;

        // Simplify some config variables
        $checkout = $config['checkoutPath'];
        $priceFormat = $config['priceFormat'];

        $id = $config['item']['id'];
        $name = $config['item']['name'];
        $price = $config['item']['price'];
        $qty = $config['item']['qty'];
        $dmoney = $config['item']['dmoney'];
        $url = $config['item']['url'];
        $add = $config['item']['add'];
        $vendor = $config['item']['vendor'];
        $vendorName = $config['item']['vendorname'];
        $needPackingPriceName = $config['item']['needPackingPrice'];
        $startingPriceName = $config['item']['startingprice'];

        // Use config values as literal indices for incoming POST values
        // Values are the HTML name attributes set in config.json
        if (isset($_POST[$id])) {
            $id = $_POST[$id];
            $name = $_POST[$name];
            $price = $_POST[$price];
            $qty = $_POST[$qty];
            $dmoney = $_POST[$dmoney];
            $url = $_POST[$url];
            $vendor = $_POST[$vendor];
            $vendorName = $_POST[$vendorName];
            //$promo = $_POST[$promo];
            $needPackingPrice = $_POST[$needPackingPriceName];
            $startingprice = $_POST[$startingPriceName];

            // Optional CSRF protection, see: http://conceptlogic.com/jcart/security.php
            $jcartToken = $_POST['jcartToken'];
        }

        // Only generate unique token once per session
        if (!isset($_SESSION['jcartToken'])) {
            $_SESSION['jcartToken'] = md5(session_id() . time() . $_SERVER['HTTP_USER_AGENT']);
        }
        // If enabled, check submitted token against session token for POST requests
        if ($config['csrfToken'] === 'true' && $_POST && $jcartToken != $_SESSION['jcartToken']) {
            $errorMessage = 'Invalid token!' . $jcartToken . ' / ' . $_SESSION['jcartToken'];
        }

        // Sanitize values for output in the browser
        $id = filter_var($id, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
        $name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
        $url = filter_var($url, FILTER_SANITIZE_URL);

        // Round the quantity if necessary
        if ($config['decimalPlaces'] === true) {
            $qty = round($qty, $config['decimalPlaces']);
        }

        // Add an item
        if (isset($_POST[$add])) {

            $this->add_shop($vendor, $vendorName, $this->packingPrice,$startingprice);

            $itemAdded = $this->add_item($id, $name, $price, $qty, $dmoney, $url, $vendor, $this->packingPrice, '',$needPackingPrice);
            // If not true the add item function returns the error type
            if ($itemAdded !== true) {
                $errorType = $itemAdded;
                switch ($errorType) {
                    case 'qty':
                        $errorMessage = $config['text']['quantityError'];
                        break;
                    case 'price':
                        $errorMessage = $config['text']['priceError'];
                        break;
                }
            }
        }

        // Update a single item
        if (isset($_POST['jcartUpdate'])) {
            $itemUpdated = $this->update_item($_POST['itemId'], $_POST['itemQty']);
            if ($itemUpdated !== true) {
                $errorMessage = $config['text']['quantityError'];
            }
        }

        // Update all items in the cart
        if (isset($_POST['jcartUpdateCart']) || isset($_POST['jcartCheckout'])) {
            $cartUpdated = $this->update_cart();
            if ($cartUpdated !== true) {
                $errorMessage = $config['text']['quantityError'];
            }
        }

        // Remove an item
        /* After an item is removed, its id stays set in the query string,
        preventing the same item from being added back to the cart in
        subsequent POST requests.  As result, it's not enough to check for
        GET before deleting the item, must also check that this isn't a POST
        request. */
        if (isset($_GET['jcartRemove']) && !$_POST) {
            $this->remove_item($_GET['jcartRemove']);
        }

        // Empty the cart
        if (isset($_POST['jcartEmpty'])) {
            $this->empty_cart();
        }

        // Determine which text to use for the number of items in the cart
        $itemsText = $config['text']['multipleItems'];
        if ($this->itemCount == 1) {
            $itemsText = $config['text']['singleItem'];
        }

        // Determine if this is the checkout page
        /* First we check the request uri against the config checkout (set when
        the visitor first clicks checkout), then check for the hidden input
        sent with Ajax request (set when visitor has javascript enabled and
           updates an item quantity). */
        // $isCheckout = strpos(request_uri(), $checkout);
        // if ($isCheckout !== false || (isset($_REQUEST['jcartIsCheckout']) && $_REQUEST['jcartIsCheckout'] == 'true')) {
        //    $isCheckout = true;
        // }
        // else {
        //    $isCheckout = false;
        // }

        // Overwrite the form action to post to gateway.php instead of posting back to checkout page
        // if ($isCheckout === true) {

        //    // Sanititze config path
        //    $path = filter_var($config['jcartPath'], FILTER_SANITIZE_URL);

        //    // Trim trailing slash if necessary
        //    $path = rtrim($path, '/');

        //    $checkout = $path . '/gateway.php';
        // }

        // Default input type
        // Overridden if using button images in config.php
        $inputType = 'submit';

        // If this error is true the visitor updated the cart from the checkout page using an invalid price format
        // Passed as a session var since the checkout page uses a header redirect
        // If passed via GET the query string stays set even after subsequent POST requests
        if ((isset($_SESSION['quantityError']) && $_SESSION['quantityError'] === true)) {
            $errorMessage = $config['text']['quantityError'];
            unset($_SESSION['quantityError']);
        }

        // Set currency symbol based on config currency code
        $currencyCode = trim(strtoupper($config['currencyCode']));
        switch ($currencyCode) {
            case 'CNY':
                $currencySymbol = '￥';
                break;
            case 'EUR':
                $currencySymbol = '&#128;';
                break;
            case 'GBP':
                $currencySymbol = '&#163;';
                break;
            case 'JPY':
                $currencySymbol = '&#165;';
                break;
            case 'CHF':
                $currencySymbol = 'CHF&nbsp;';
                break;
            case 'SEK':
            case 'DKK':
            case 'NOK':
                $currencySymbol = 'Kr&nbsp;';
                break;
            case 'PLN':
                $currencySymbol = 'z&#322;&nbsp;';
                break;
            case 'HUF':
                $currencySymbol = 'Ft&nbsp;';
                break;
            case 'CZK':
                $currencySymbol = 'K&#269;&nbsp;';
                break;
            case 'ILS':
                $currencySymbol = '&#8362;&nbsp;';
                break;
            case 'TWD':
                $currencySymbol = 'NT$';
                break;
            case 'THB':
                $currencySymbol = '&#3647;';
                break;
            case 'MYR':
                $currencySymbol = 'RM';
                break;
            case 'PHP':
                $currencySymbol = 'Php';
                break;
            case 'BRL':
                $currencySymbol = 'R$';
                break;
            case 'USD':
            default:
                $currencySymbol = '$';
                break;
        }

        ////////////////////////////////////////////////////////////////////////
        // Output the cart

        // Return specified number of tabs to improve readability of HTML output
        function tab($n)
        {
            $tabs = null;
            while ($n > 0) {
                $tabs .= "\t";
                --$n;
            }
            return $tabs;
        }

        // If there's an error message wrap it in some HTML
        if ($errorMessage) {
            $errorMessage = "<p id='jcart-error'>$errorMessage</p>";
        }

        $this->totalIntegral = $this->integralCal->get_integral($this->subtotal, 'Dessert');

        // Display the cart header
        echo tab(1) . "$errorMessage\n";
        echo tab(1) . "<form method='post' action='$checkout'>\n";
        echo tab(2) . "<fieldset>\n";
        echo tab(3) . "<input type='hidden' name='jcartToken' value='{$_SESSION['jcartToken']}' />\n";
        echo tab(3) . "<input type='hidden' value='{$this->itemCount}' id='merchandiseCount' />\n";
        echo tab(3) . "<table border='1'>\n";
        echo tab(4) . "<thead>\n";
        echo tab(5) . "<tr>\n";
        echo tab(6) . "<th colspan='3'>\n";
        echo tab(7) . "&nbsp;<strong id='jcart-title'>{$config['text']['cartTitle']}</strong> ($this->itemCount)\n";
        echo tab(6) . "</th>\n";
        echo tab(5) . "</tr>" . "\n";
        echo tab(4) . "</thead>\n";

        // Display the cart footer
        echo tab(4) . "<tfoot>\n";
        echo tab(5) . "<tr>\n";
        echo tab(6) . "<th colspan='2'>\n";
        echo tab(7) . "<span id='jcart-integral'>&nbsp;{$config['text']['totalIntegral']}: <strong>" . $this->totalIntegral . "</strong></span>\n";
        echo tab(6) . "</th>\n";
        echo tab(6) . "<th colspan='1'>\n";
        echo tab(7) . "<span id='jcart-subtotal'>{$config['text']['subtotal']}: <strong>$currencySymbol" . number_format($this->subtotal, $priceFormat['decimals'], $priceFormat['dec_point'], $priceFormat['thousands_sep']) . "</strong></span>\n";
        echo tab(6) . "</th>\n";
        echo tab(5) . "</tr>\n";

        if (!isset($_REQUEST['openid'])) {
        echo tab(5) . "<tr>\n";
        echo tab(6) . "<th colspan='3'>\n";
        echo tab(7) . "<span id='jcart-dmoney'>&nbsp;{$config['text']['totalDMoney']}: <strong>" . $this->totalDMoney . "(" . $this->totalDMoney/10 . "元RMB)</strong></span>\n";
        echo tab(6) . "</th>\n";
        echo tab(5) . "</tr>\n";            
        }

        echo tab(4) . "</tfoot>\n";

        echo tab(4) . "<tbody>\n";

        $schoolid = @$_REQUEST['schoolid'];
        
        // If any items in the cart
        if ($this->itemCount > 0) {
            foreach ($this->shops as $sid => $shop) {
                //set  shop title info
                $packingPrice = $shop['packingprice'];
                $startingPrice = $shop['startingprice'];
                $startingpriceless = ($this->perShopSubtotal[$sid]) - $startingPrice;
                
                if($startingpriceless >= 0)
                {
                    $startingpriceless = '';      
                }
                else
                {
                    $status = 'no';
                    $startingpriceless = '<span><input type="hidden" value='.$status.' id="formstatus"/>(缺少'.$currencySymbol.-$startingpriceless.')</span>';
                }
                
                if(empty($shop['startingprice'])) $startingPrice =0;
                if(empty($shop['packingprice'])) $packingPrice =0;
                echo tab(7) . "<tr class='jcart-title'><td colspan='2'><span>{$shop['shopname']}<br/>起送价:{$startingPrice}<br/>打包费:{$packingPrice}元/份</span>
                </td><td><span>小计:$currencySymbol{$this->perShopSubtotal[$sid]}</span></br>{$startingpriceless}</td></tr>\n";
                
                foreach ($this->get_contents() as $item) {

                    $item['packingMessage'] = ($item['needPackingPrice']==0?"(无打包费)":"");
                    
                    if ($item['vendor'] == $sid) {
                        echo tab(5) . "<tr>\n";
                        
                        echo tab(6) . "<td class='jcart-item-name'>\n";

                        echo tab(7) . "{$item['name']}". "{$item['packingMessage']}"."\n";
                        echo tab(7) . "<input name='jcartItemName[]' type='hidden' value='{$item['name']}' />\n";
                        echo tab(6) . "</td>\n";

                        echo tab(6) . "<td class='jcart-item-qty'>\n";
                        echo tab(7) . "<input name='jcartItemId[]' type='hidden' value='{$item['id']}' />\n";
                        echo tab(7) . "<input name='jcartOriQty[]' type='hidden' value='{$item['qty']}' />\n";

                        if ($this->inOrderPreview) {
                            echo tab(7) . "{$item['qty']} \n";
                        } else {
                            echo tab(7) . "<input id='jcartItemQty-{$item['id']}' name='jcartItemQty[]' size='2' type='text' value='{$item['qty']}' />\n";
                        }


                        echo tab(6) . "</td>\n";

                        echo tab(6) . "<td class='jcart-item-price'>\n";
                        echo tab(7) . "<span>$currencySymbol" . number_format($item['subtotal'], $priceFormat['decimals'], $priceFormat['dec_point'], $priceFormat['thousands_sep']) . "</span><input name='jcartItemPrice[]' type='hidden' value='{$item['price']}' />\n";

                        if (!$this->inOrderPreview) {
                            echo tab(7) . "<a class='jcart-remove' href='?jcartRemove={$item['id']}'>{$config['text']['removeLink']}</a>\n";
                        }

                        echo tab(6) . "</td>\n";
                        echo tab(7) . "<input name='jartItemIntegral[]' type='hidden' value='{$item['integral']}' />\n";
                        echo tab(5) . "</tr>\n";
                    }
                }
            }
        } // The cart is empty
        else {
            echo tab(5) . "<tr><td id='jcart-empty' colspan='3'>";
            //if has redirect url, that means current page is order preview.
            if ($this->redirectUrl) {
                echo tab(5) . "<div class='shoppingcart_general_none'>{$config['text']['emptyMessage']}<a href='{$this->redirectUrl}'>去点餐&gt;&gt;</a></div>";
            } else {
                echo tab(5) . "{$config['text']['emptyMessage']}";
            }
            echo tab(5) . "</td></tr>\n";
        }
        echo tab(4) . "</tbody>\n";
        echo tab(3) . "</table>\n\n";
        echo tab(2) . "</fieldset>\n";
        echo tab(1) . "</form>\n\n";

    }

    public function checkstartingprice($status)
    {
        $status = $status;
    }
}

// Start a new session in case it hasn't already been started on the including page
if (!isset($_SESSION)) { //new
    @session_start();
} //new

// Initialize jcart after session start
$jcart = isset($_SESSION['jcart']) ? $_SESSION['jcart'] : '';
if (!is_object($jcart)) {
    $jcart = $_SESSION['jcart'] = new Jcart();
}

// Enable request_uri for non-Apache environments
// See: http://api.drupal.org/api/function/request_uri/7
if (!function_exists('request_uri')) {
    function request_uri()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $uri = $_SERVER['REQUEST_URI'];
        } else {
            if (isset($_SERVER['argv'])) {
                $uri = $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['argv'][0];
            } elseif (isset($_SERVER['QUERY_STRING'])) {
                $uri = $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING'];
            } else {
                $uri = $_SERVER['SCRIPT_NAME'];
            }
        }
        $uri = '/' . ltrim($uri, '/');
        return $uri;
    }
}


/**
 *
 */
class Integral
{
    private $price;

    private $type;

    private $qty;

    private $currentCoeff;

    private $coefficients;

    function __construct()
    {
//        $this->price = $price;
//        $this->type = $merchandiseType;
        // $this->confficients=$confficients;
        // $this->set_coefficient();
    }


    public function get_integral($price, $merchandiseType, $qty = 1)
    {
        $this->price = $price;
        $this->type = $merchandiseType;
        $this->qty = $qty;

        if ($this->price > 0) {
            $this->currentCoeff = 1;
            return $this->price * $this->currentCoeff * $this->qty;
        }
    }

    private function set_coefficient()
    {
        $this->currentCoeff = $this->coefficient[$this->type];
    }
}

?>