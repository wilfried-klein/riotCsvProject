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
$matchAnalysedNumber = count($lastMatchsID);
//array for all matchs
$result;
//get Data for $summonerName for each match
for($nbG=0; $nbG < $matchAnalysedNumber; $i++) {
	//getMatchData
	try {
		$matchData = ModelRiotApi::getMatchData($matchID,$region);
	} catch (Exception $e) {
		return(array("matchData",$e->getMessage()));
	}
	//get summoner index
	$currentSummonerIndex = array_search($summonerPuuid, $matchData['metadata']['participants']);
	//get alls datas for current summoner on an array
	$result[$nbG] = $matchData['info']['participants'][$currentSummonerIndex];
	$runeDataOfCurrentSummoner = $result[$nbG]['perks'];
	unset($result[$nbG]['perks']);
	//ajout de l'id du match, du timestamp, de sa durée, le timeStamp
	$result[$nbG]['matchId'] = $matchID;
	$result[$nbG]['gameStartTimestamp'] = $matchData['info']['gameCreation'];
	if(array_key_exists('gameEndTimestamp', $matchData['info'])){
		$result[$nbG]['gameDuration'] = $matchData['info']['gameDuration'];
		$result[$nbG]['gameEndTimestamp'] = $matchData['info']['gameEndTimestamp'];
	}else{
		$result[$nbG]['gameDuration'] = $matchData['info']['gameDuration']/1000;
		$result[$nbG]['gameEndTimestamp'] = -1;
	}
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
