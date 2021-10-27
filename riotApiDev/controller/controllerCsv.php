<?php
$language = 'fr_FR';
$summonerName = $_GET['summonerName'];
$server = $_GET['server'];
if(isset($_GET['nbGames'])){
	$gameNumber = intval($_GET['nbGames']);
	if($gameNumber > 20){
		$gameNumber = 1;
	}
}elseif(isset($_GET['matchId'])){
	$matchId = $_GET['matchId'];
}else{
	throw new Exception("missingArgument", 0);	
}
//obtention de la région correspondant au serveur
$region = ModelRiotApi::getRegionByServer($server);
//obtention des données de l'invocateur
$summonerInfo = ModelRiotApi::getSummonerInfoBySummonerName(rawurlencode($summonerName),$server);
$summonerPuuid = $summonerInfo['puuid'];
if(isset($gameNumber)){
	$lastMatchsID = ModelRiotApi::getMatchByPuuid($summonerPuuid,$region,null,null,null,null,0,$gameNumber);
}elseif (isset($matchIod)) {
	$lastMatchsID = array($matchIod);
}
$matchAnalysedNumber = count($lastMatchsID);
//array for all matchs
$result;
//get Data for $summonerName for each match
for($nbG=0; $nbG < $matchAnalysedNumber; $nbG++) {
	//getMatchData
	$matchData = ModelRiotApi::getMatchData($lastMatchsID[$nbG],$region);
	//get summoner index
	$currentSummonerIndex = array_search($summonerPuuid, $matchData['metadata']['participants']);
	//get alls datas for current summoner on an array
	$result[$nbG] = $matchData['info']['participants'][$currentSummonerIndex];
	$runeDataOfCurrentSummoner = $result[$nbG]['perks'];
	unset($result[$nbG]['perks']);
	//ajout de l'id du match, du timestamp, de sa durée, le timeStamp
	$result[$nbG]['matchId'] = $lastMatchsID[$nbG];
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
foreach ($result[0] as $key => $value) {
	$csvContent = $csvContent . $key . ",";
}
foreach ($result as $matchData) {
	$csvContent = $csvContent .  implode(",", $matchData) . "\n";
}
return false;
?>