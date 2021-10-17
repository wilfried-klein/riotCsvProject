<?php
require_once '../model/modelRiotApi.php';

$summonerName = $_POST['summonerName'];
$server = $_POST['server'];
$language = 'fr_FR';

try {
	$region = ModelRiotApi::getRegionByServer($server);
} catch (Exception $e) {
	die($e->getMessage());
}
try {
	$version = ModelRiotApi::getVersionData()[0];
} catch (Exception $e) {
	die("une erreur est survenue15");
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
		die("une erreur est survenue74");
	}
	if ($errorCode == "403") {
		die("ce rang n'existe pas");
	}
}
try {
	$lastMatchsID = ModelRiotApi::getMatchByPuuid($summonerInfo['puuid'],$region,null,null,null,null,0,2);
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
	$summonerSpellData = ModelRiotApi::getSummonerSpellsData($version,$language)['data'];
} catch (Exception $e) {
	die("erreur lors de la récupération des données des sorts d'invocateur");
}
try {
	$runeData = ModelRiotApi::getRunesData('11.20.1','fr_FR');
} catch (Exception $e) {
	die("erreur lors de la récupération des données des runes");
}
try {
	$queueData = ModelRiotApi::getQueuesData();
} catch (Exception $e) {
	die("erreur lors de la récupération des données des files");
}
/*
********************************************************************************************************************************************
********************************************************************************************************************************************
********************************************************************************************************************************************
********************************************************************************************************************************************
*/
$result = array();
for ($numG=0; $numG < count($lastMatchsID); $numG++) { 
	try {
		$matchData = ModelRiotApi::getMatchData($lastMatchsID[$numG],$region);
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
	$participantPuuidList = $matchData['metadata']['participants'];
	$currentSummonerIndex = array_search($summonerInfo['puuid'], $participantPuuidList);

	$summonerMatchData = $matchData['info']['participants'];

	$return = array();
	$SummonerIconList = array();
	$summonerNameList = array();
//liste des joueurs + liste des icones de joueurs
	for($i = 0; $i < 10; $i++) {
		$soloSummonerInfo = $summonerMatchData[$i];
		try {
			$summonerIconList[$i] = ModelRiotApi::getChampionSquareAsset($version,$summonerMatchData[$i]['championName']);
		} catch (Exception $e) {
			$errorCode = $e->getMessage();
			if($errorCode == "404"){
				die("une erreur est survenue");
			}
			if ($errorCode == "403") {
				die("cette image de profil n'existe pas");
			}
		}
		$summonerNameList[$i] = $soloSummonerInfo['summonerName'];
	}
	$return['summonerNameList'] = $summonerNameList;
	$return['summonerIconList'] = $summonerIconList; 
	$soloSummonerInfo = $summonerMatchData[$currentSummonerIndex];
//nom du champion, icone du champion
	try {
		$return['championName'] = $summonerMatchData[$currentSummonerIndex]['championName'];
		$return['championIcon'] = ModelRiotApi::getChampionSquareAsset($version,$return['championName']);
	} catch (Exception $e) {
		$errorCode = $e->getMessage();
		if($errorCode == "404"){
			die("une erreur est survenue");
		}
		if ($errorCode == "403") {
			die("cet champion n'existe pas");
		}
	}
	
//search summoner spell
	foreach ($summonerSpellData as $value) {
		if($value['key'] == $soloSummonerInfo['summoner1Id']){
			$return['summonerSpell1'] = ModelRiotApi::getSummonerSpellAsset($version,$value['image']['full']);
		}
	}
	foreach ($summonerSpellData as $value) {
		if($value['key'] == $soloSummonerInfo['summoner2Id']){
			$return['summonerSpell2'] = ModelRiotApi::getSummonerSpellAsset($version,$value['image']['full']);
		}
	}

//icones des runes
	//obtention du chemin vers l'image de la rune
	$rune1 = $summonerMatchData[$currentSummonerIndex]['perks']['styles'][0]['selections'][0]['perk'];
	$branch = $summonerMatchData[$currentSummonerIndex]['perks']['styles'][0]['style'];
	try {
		for ($i=0; $i < count($runeData); $i++) { 
			if($runeData[$i]['id'] == $branch){
				$subRuneData = $runeData[$i]['slots'];
				for ($h=0; $h < count($subRuneData) ; $h++) { 
					$array = $subRuneData[$h]['runes'];
					for ($j=0; $j < count($array); $j++) {
						if($array[$j]['id'] == $rune1){
							$return['rune1Icon'] = ModelRiotApi::getRunesAsset($array[$j]['icon']);
							break(3); 
						}
					}
				}
			}
		}
	} catch (Exception $e) {
		die();
	}
	$rune2 = $summonerMatchData[$currentSummonerIndex]['perks']['styles'][1]['style'];
	try {
		for ($i=0; $i < count($runeData); $i++) { 
			if($runeData[$i]['id'] == $rune2){
				$return['rune2Icon'] = ModelRiotApi::getRunesAsset($runeData[$i]['icon']);
				break;
			}
		}
	} catch (Exception $e) {
		die();
	}
	$return['gameDuration'] = $matchData['info']['gameDuration'];
	foreach ($queueData as $value) {
		if($value['queueId'] == $matchData['info']['queueId']) {
			$return['matchType'] = $value['description'];
			break;
		}
	}

	$return['matchDate'] = getdate(($matchData['info']['gameCreation'])/1000);

	$return['kills'] = $summonerMatchData[$currentSummonerIndex]['kills'];
	$return['deaths'] = $summonerMatchData[$currentSummonerIndex]['deaths'];
	$return['assists'] = $summonerMatchData[$currentSummonerIndex]['assists'];

	$return['creepScore'] = $summonerMatchData[$currentSummonerIndex]['totalMinionsKilled'];
	$return['visionScore'] = $summonerMatchData[$currentSummonerIndex]['visionScore'];
	$return['result'] = $summonerMatchData[$currentSummonerIndex]['win'];


	$itemsList = array(
		$summonerMatchData[$currentSummonerIndex]['item0'],
		$summonerMatchData[$currentSummonerIndex]['item1'],
		$summonerMatchData[$currentSummonerIndex]['item2'],
		$summonerMatchData[$currentSummonerIndex]['item3'],
		$summonerMatchData[$currentSummonerIndex]['item4'],
		$summonerMatchData[$currentSummonerIndex]['item5'],
		$summonerMatchData[$currentSummonerIndex]['item6']
	);
	try {
		$itemsIcon = array();
		for ($i=0; $i < 7; $i++) {
			if($itemsList[$i] != '0'){
				$itemsIcon[] = ModelRiotApi::getItemAsset($version,$itemsList[$i]);
			}
		}
	} catch (Exception $e) {
		$errorCode = $e->getMessage();
		if($errorCode == "404"){
			die("une erreur est survenue136");
		}
		if ($errorCode == "403") {
			die("cet objet n'existe pas");
		}
	}
	$return['itemsIcon'] = $itemsIcon;
	$result[] = $return;
	$summonerIcon = $return['summonerIconList'][$currentSummonerIndex];
}
require '../view/displayLastTenMatchs.php';
?>