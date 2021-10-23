<?php
$language = 'fr_FR';

//obtention de la région correspondant au serveur
try {
	$region = ModelRiotApi::getRegionByServer($server);
} catch (Exception $e) {
	return(array("regionByServer",$e->getMessage()));
}
//obtention des données de l'invocateur
try {
	$summonerInfo = ModelRiotApi::getSummonerInfoBySummonerName(rawurlencode($summonerName),$server);
} catch (Exception $e) {
	return(array("summonerInfoBySummonerName",$e->getMessage()));
}
$summonerPuuid = $summonerInfo['puuid'];

try {
	$lastMatchsID = ModelRiotApi::getMatchByPuuid($summonerPuuid,$region,null,null,null,null,0,$gameNumber);
} catch (Exception $e) {
	return(array("matchByPuuid",$e->getMessage()));
}
//array for all matchs
$allMatchData = array();
//get Data for $summonerName for each match
foreach ($lastMatchsID as $matchID) {
	//getMatchData
	try {
		$matchData = ModelRiotApi::getMatchData($matchID,$region);
	} catch (Exception $e) {
		return(array("matchData",$e->getMessage()));
	}
	//get summoner index
	$currentSummonerIndex = array_search($summonerPuuid, $matchData['metadata']['participants']);
	//get alls datas for current summoner on an array
	$dataOfCurrentSummoner = $matchData['info']['participants'][$currentSummonerIndex];
	$runeDataOfCurrentSummoner = $dataOfCurrentSummoner['perks'];
	unset($dataOfCurrentSummoner['perks']);
	//ajout de l'id du match, du timestamp, de sa durée, le timeStamp
	$dataOfCurrentSummoner['matchId'] = $matchID;
	$dataOfCurrentSummoner['gameStartTimestamp'] = $matchData['info']['gameCreation'];
	if(array_key_exists('gameEndTimestamp', $matchData['info'])){
		$dataOfCurrentSummoner['gameDuration'] = $matchData['info']['gameDuration'];
		$dataOfCurrentSummoner['gameEndTimestamp'] = $matchData['info']['gameEndTimestamp'];
	}else{
		$dataOfCurrentSummoner['gameDuration'] = $matchData['info']['gameDuration']/1000;
		$dataOfCurrentSummoner['gameEndTimestamp'] = -1;
	}
	$allMatchData[] = $dataOfCurrentSummoner;
}
//conversion vers CSV
$csvContent = "";
foreach ($allMatchData as $matchData) {
	foreach ($matchData as $key => $value) {
		$csvContent = $csvContent . $key . ",";
	}
	$csvContent = $csvContent . "\n";
	$csvContent = $csvContent .  implode(",", $matchData) . "\n";
}
return false;
?>
