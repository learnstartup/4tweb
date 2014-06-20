<?php

// jCart v1.3
// http://conceptlogic.com/jcart/

session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />

		<title>jCart Server Test</title>

		<style type="text/css">
			.success { color:green; }
			.error { color:red; }
		</style>

	</head>
	<body>

		<h2>jCart Server Test</h2>

<?php

echo "<h3>Required settings</h3>\n";
echo "<ul>";

$phpVersion = phpversion();
$class = 'error';
if ($phpVersion >= 5.2) {
	$class = 'success';
}
echo "<li class='$class'><strong>PHP version:</strong> Requires version 5.2 or newer, this server is using version $phpVersion</li>\n";

$_SESSION['support'] = true;
if ($_SESSION['support'] === true) {
	echo "<li class='success'><strong>Session support:</strong> Enabled</li>\n";
}
else {
	echo "<li class='error'><strong>Session support:</strong> Not enabled</li>\n";
}
echo "</ul>";

echo "<h3>Recommended settings</h3>\n";
echo "<ul>";

$registerGlobals = ini_get('register_globals');
if ($registerGlobals) {
	echo "<li class='error'><strong>Register globals:</strong> On</li>\n";
}
else {
	echo "<li class='success'><strong>Register globals:</strong> Off</li>\n";
}

$errorReporting = ini_get('error_reporting');
if ($errorReporting) {
	echo "<li class='error'><strong>Display errors:</strong> On</li>\n";
}
else {
	echo "<li class='success'><strong>Display errors:</strong> Off</li>\n";
}
echo "</ul>";

?>

	</body>
</html>