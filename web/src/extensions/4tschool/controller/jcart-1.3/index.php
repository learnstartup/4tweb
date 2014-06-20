<?php

// jCart v1.3
// http://conceptlogic.com/jcart/

// This file demonstrates a basic store setup

// If your page calls session_start() be sure to include jcart.php first
include_once('jcart/jcart.php');

session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />

		<title>jCart - Free Ajax/PHP shopping cart</title>

		<link rel="stylesheet" type="text/css" media="screen, projection" href="style.css" />

		<link rel="stylesheet" type="text/css" media="screen, projection" href="jcart/css/jcart.css" />

	</head>
	<body>
		<div id="wrapper">
			<h2>Demo Store</h2>

			<div id="sidebar">
				<div id="jcart"><?php $jcart->display_cart();?></div>
			</div>

			<div id="content">

				<form method="post" action="" class="jcart">
					<fieldset>
						<input type="hidden" name="jcartToken" value="<?php echo $_SESSION['jcartToken'];?>" />
						<input type="hidden" name="my-item-id" value="ABC-123" />
						<input type="hidden" name="my-item-name" value="Soccer Ball" />
						<input type="hidden" name="my-item-price" value="25.00" />
						<input type="hidden" name="my-item-url" value="" />

						<ul>
							<li><strong>Soccer Ball</strong></li>
							<li>Price: $25.00</li>
							<li>
								<label>Qty: <input type="text" name="my-item-qty" value="1" size="3" /></label>
							</li>
						</ul>

						<input type="submit" name="my-add-button" value="add to cart" class="button" />
					</fieldset>
				</form>

				<form method="post" action="" class="jcart">
					<fieldset>
						<input type="hidden" name="jcartToken" value="<?php echo $_SESSION['jcartToken'];?>" />
						<input type="hidden" name="my-item-id" value="2" />
						<input type="hidden" name="my-item-name" value="Baseball Mitt" />
						<input type="hidden" name="my-item-price" value="19.50" />
						<input type="hidden" name="my-item-url" value="http://yahoo.com" />

						<ul>
							<li><strong>Baseball Mitt</strong></li>
							<li>Price: $19.50</li>
							<li>
								<label>Qty: <input type="text" name="my-item-qty" value="1" size="3" /></label>
							</li>
						</ul>

						<input type="submit" name="my-add-button" value="add to cart" class="button" />
					</fieldset>
				</form>

				<form method="post" action="" class="jcart">
					<fieldset>
						<input type="hidden" name="jcartToken" value="<?php echo $_SESSION['jcartToken'];?>" />
						<input type="hidden" name="my-item-id" value="3" />
						<input type="hidden" name="my-item-name" value="Hockey Stick" />
						<input type="hidden" name="my-item-price" value="33.25" />
						<input type="hidden" name="my-item-url" value="http://bing.com" />

						<ul>
							<li><strong>Hockey Stick</strong></li>
							<li>Price: $33.25</li>
							<li>
								<label>Qty: <input type="text" name="my-item-qty" value="1" size="3" /></label>
							</li>
						</ul>

						<input type="submit" name="my-add-button" value="add to cart" class="button tip" />
					</fieldset>
				</form>

				<div class="clear"></div>

				<p><small>Having trouble? <a href="jcart/server-test.php">Test your server settings.</a></small></p>

				<?php
					//echo '<pre>';
					//var_dump($_SESSION['jcart']);
					//echo '</pre>';
				?>
			</div>

			<div class="clear"></div>
		</div>

		<script type="text/javascript" src="jcart/js/jquery-1.4.4.min.js"></script>
		<script type="text/javascript" src="jcart/js/jcart.min.js"></script>
	</body>
</html>