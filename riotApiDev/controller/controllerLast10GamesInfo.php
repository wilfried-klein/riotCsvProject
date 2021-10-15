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
	$last10MatchesID = ModelRiotApi::getMatchByPuuid($summonerInfo['puuid'],$region,null,null,null,null,0,10);
    //print_r($last10MatchesID);
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
$Matches10 = array();
for ($i=0; $i < count($last10MatchesID); $i++){
	$matchID = $last10MatchesID[$i];
	try{
		$matchData = ModelRiotApi::getMatchData($matchID, $region);
	}
	catch (Exception $e) {
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
		$summonerMatchData['item3'],
		$summonerMatchData['item4'],
		$summonerMatchData['item5'],
		$summonerMatchData['item6']
	);
	try {
		$itemsIcon = array();
		for ($j=0; $j < 7; $j++) {
			if($itemsList[$j] != '0'){
				$itemsIcon[$j] = ModelRiotApi::getItemAsset($version,$itemsList[$j]);
			}
		}
	}
	catch (Exception $e) {
		$errorCode = $e->getMessage();
		if($errorCode == "404"){
			die("une erreur est survenueee");
		}
		if ($errorCode == "403") {
			die("cet objet n'existe pas");
		}
	}

	try {
		$itemsIcon['championName'] = $summonerMatchData['championName'];
		$itemsIcon['championIcon'] = ModelRiotApi::getChampionSquareAsset($version,$itemsIcon['championName']);
	} catch (Exception $e) {
		$errorCode = $e->getMessage();
		if($errorCode == "404"){
			die("une erreur est survenue");
		}
		if ($errorCode == "403") {
			die("cet champion n'existe pas");
		}
	}
	$itemsIcon['result'] = $summonerMatchData['win'];
	$Matches10[] = $itemsIcon;
}
//print_r($Matches10);
require '../view/testPlusieursGames.php';
?>