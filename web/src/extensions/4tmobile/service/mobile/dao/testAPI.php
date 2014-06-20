<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>test</title>
	</head>
	<body>		
		<?php
                $url="http://dev.diancanyo.com/windid/index.php?m=api&clientid=1&c=User&a=weiXinLogin&username=water.sun&password=water.sun";
                require_once("getpost.php");
                $api = new getpost();
		$result = $api->AddWindidKeyAndTime($url);
                echo $result;
                die();
		require_once("common.php");
                
		//$test="test11";
		$common = new common();
		$results = $common->getAllSchools("dev"); //, 115.936360, 28.682493);
		$arraySchools = array();
		foreach ($results as $school) {
//			echo $school['name'] . $school['schoolid'];
			if ($school['name'] == "江西省南昌大学[南院]") {
				$school['schlongitude'] = 115.937486;
				$school['schlatitude'] = 28.682973;
				echo $school['name'] . $school['schoolid'];
			}
			if ($school['schlongitude'] != 0 && $school['schlatitude'] != 0) {
				if ($common->getdistance($school['schlongitude'], $school['schlatitude'], 115.936360, 28.682493) < 1000) {
					echo $school['name'] . $school['schoolid'];
					array_push($arraySchools, $school);
				}
			}
		}
		?>
	</body>
</html>
