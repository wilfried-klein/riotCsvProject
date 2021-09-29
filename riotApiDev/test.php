<?php 
	require_once 'api.php';
	$api = new Api('euw1','PΔblo');
	$puuid = $api->getPuuidOfSummoner();
	$matchId = $api->getLastMatchIDbyPuuid($puuid);
	$playerdata = $api->getMatchStats($matchId);
	print_r($playerdata);
?>
