<?php
	require_once '../model/modelRiotApi.php';

	$summonerName = 'PΔblo';
	$server = 'euw1';

	$summonerInfo = ModelRiotApi::getSummonerInfoBySummonerName($summonerName,$server);
	$summonerID = $summonerInfo['id'];
	$summonerID = ModelRiotApi::getChampionMasteryBySummonerId($summonerID, $server);
	print_r($summonerInfo);

?>