<?php
require_once('model/modelRiotApi.php');
$service = 'ddragon';
$userDemand = 'runesAssets';
$neededOption = array('11.20.1','SummonerFlash.png');
try {
	//$content = ModelRiotApi::dataGetter($service,$userDemand,$neededOption);
	//print_r($content);
	$image = ModelRiotApi::imageGetter($service,$userDemand,$neededOption);
	echo "<img src=".$image.">";
} catch (Exception $e) {
	echo $e->getMessage()." ".$e->getCode();
}
?>