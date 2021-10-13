<?php
require_once '../model/modelRiotApi.php';

$summonerName = $_POST['summonerName'];
$server = $_POST['server'];

try {
	$region = ModelRiotApi::getRegionByServer($server);
} catch (Exception $e) {
	die($e->getMessage());
}
try {
	$version = ModelRiotApi::getVersionData()[0];
} catch (Exception $e) {
	die("une erreur est survenue");
}
try {
	$summonerInfo = ModelRiotApi::getSummonerInfoBySummonerName(rawurlencode($summonerName),$server);
} catch (Exception $e) {
	$errorCode = $e->getMessage();
	if ($errorCode == "404") {
		die("Cette invocateur n'existe pas");
	}
	if ($errorCode == "429") {
		die("Trop de demande,veuiller reéssayer");
	}
	if($errorCode == "503"){
		die("le service est temporairement indisponible, veuiller reéssayer plus tard");
	}
}
try {
	$summonerIcon = ModelRiotApi::getProfileIconAsset($version,$summonerInfo['profileIconId']);
} catch (Exception $e) {
	$errorCode = $e->getMessage();
	if($errorCode == "404"){
		die("une erreur est survenue");
	}
	if ($errorCode == "403") {
		die("cette image de profil n'existe pas");
	}
}
try {
	$rankingData = ModelRiotApi::getLeagueDatabySummonerId($summonerInfo['id'], $server);
} catch (Exception $e) {
	$errorCode = $e->getMessage();
	if ($errorCode == "403") {
		die("Cette invocateur n'existe pas");
	}
	if ($errorCode == "429") {
		die("Trop de demande,veuiller reéssayer");
	}
	if($errorCode == "503"){
		die("le service est temporairement indisponible, veuiller reéssayer plus tard");
	}
}
if(array_key_exists(0, $rankingData)){
	$rankingInfo = $rankingData[0];
	//obtention des informations necessaires a l'affichage
	$tier = $rankingInfo['tier'];
	$rank = $rankingInfo['rank'];
	$leaguePoints = $rankingInfo['leaguePoints'];
	$wins = $rankingInfo['wins'];
	$loses = $rankingInfo['losses'];
	$winRatio = round(($wins/($wins+$loses))*100);
}else{
	$tier = "unranked";
	$rank = "1";
}
try {
	$rankedEmblems = ModelRiotApi::getRankedEmblems($tier,$rank);
} catch (Exception $e) {
	$errorCode = $e->getMessage();
	if($errorCode == "404"){
		die("une erreur est survenue");
	}
	if ($errorCode == "403") {
		die("ce rang n'existe pas");
	}
}
try {
	$lastMatchID = ModelRiotApi::getMatchByPuuid($summonerInfo['puuid'],$region,null,null,null,null,0,1)[0];
} catch (Exception $e) {
	$errorCode = $e->getMessage();
	if ($errorCode == "403") {
		die("Cette invocateur n'existe pas");
	}
	if ($errorCode == "429") {
		die("Trop de demande,veuiller reéssayer");
	}
	if($errorCode == "503"){
		die("le service est temporairement indisponible, veuiller reéssayer plus tard");
	}
}
try {
	$matchData = ModelRiotApi::getMatchData($lastMatchID,$region);
} catch (Exception $e) {
	$errorCode = $e->getMessage();
	if ($errorCode == "403") {
		die("Le match demandé n'existe pas");
	}
	if ($errorCode == "429") {
		die("Trop de demande,veuiller reéssayer");
	}
	if($errorCode == "503"){
		die("le service est temporairement indisponible, veuiller reéssayer plus tard");
	}
}
$index = $matchData['metadata'];
$index = $index['participants'];
$index = array_search($summonerInfo['puuid'], $index);

$summonerMatchData = $matchData['info'];
$summonerMatchData = $summonerMatchData['participants'];
$summonerMatchData = $summonerMatchData[$index];
$itemsList = array(
	$summonerMatchData['item0'],
	$summonerMatchData['item1'],
	$summonerMatchData['item2'],
	$summonerMatchData['item4'],
	$summonerMatchData['item5'],
	$summonerMatchData['item6']
);
try {
	$itemsIcon = array();
	for ($i=0; $i < 6; $i++) { 
		if($itemsList[$i] != '0'){
			$itemsIcon[$i] = ModelRiotApi::getItemAsset($version,$itemsList[$i]);
		}
	}
} catch (Exception $e) {
	$errorCode = $e->getMessage();
	if($errorCode == "404"){
		die("une erreur est survenue");
	}
	if ($errorCode == "403") {
		die("cet objet n'existe pas");
	}
}
try {
	$championName = $summonerMatchData['championName'];
	$championIcon = ModelRiotApi::getChampionSquareAsset($version,$championName);
} catch (Exception $e) {
	$errorCode = $e->getMessage();
	if($errorCode == "404"){
		die("une erreur est survenue");
	}
	if ($errorCode == "403") {
		die("cet champion n'existe pas");
	}
}
require '../view/test.php';
?>