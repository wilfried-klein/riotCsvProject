	<?php
	require_once '../model/modelRiotApi.php';

		//obtention des informations du formulaire
	$summonerName = rawurlencode($_POST['summonerName']);
	$server = $_POST['server'];

		//determination de la region suivant le serveur (A VERIFIER !!)
	$regionServerEquivalence = array(
		'br1' => 'americas',
		'eun1' => 'europe',
		'euw1' => 'europe',
		'jp1' => 'asia',
		'kr' => 'asia',
		'la1' => 'americas',
		'la2' => 'americas',
		'na1' => 'americas',
		'oc1' => 'americas',
		'ru' => 'europe',
		'tr1' => 'europe',
	);
		//obtention de la dernière version de Ddragon
	$versionsList = ModelRiotApi::getVersionData();
	$version = $versionsList[0];

		//obtention de la region
	$region = $regionServerEquivalence[$server];

		//obtention des infos de l'invocateur
	$summonerInfo = ModelRiotApi::getSummonerInfoBySummonerName($summonerName,$server);

		//obtention de l'image de profil
	$iconID = $summonerInfo['profileIconId'];
	$summonerIcon = ModelRiotApi::getProfileIconAsset($version,$iconID);

		//obtention des informations de classement
	$rankingData = ModelRiotApi::getLeagueDatabySummonerId($summonerInfo['id'], $server);
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
	$rankedEmblems = ModelRiotApi::getRankedEmblems($tier,$rank);
	//$rankedEmblems = base64_encode(file_get_contents('../data/ranked_emblems/' . $tier . '.png'));

		//obtention du dernier match joué
	$lastMatchID = ModelRiotApi::getMatchByPuuid($summonerInfo['puuid'],$region,null,null,null,null,0,1)[0];

		//obtention des données du match
	$matchData = ModelRiotApi::getMatchData($lastMatchID,$region);

		//obtention de l'index du joueur
	$index = $matchData['metadata'];
	$index = $index['participants'];
	$index = array_search($summonerInfo['puuid'], $index);

		//obtention de la liste des objets
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
		//obtention des images de chaque objet
	$itemsIcon = array();
	for ($i=0; $i < 6; $i++) { 
		if($itemsList[$i] != '0'){
			$itemsIcon[$i] = ModelRiotApi::getItemAsset($version,$itemsList[$i]);
		}
	}
		//obtention du nom du champion
	$championName = $summonerMatchData['championName'];
	$championIcon = ModelRiotApi::getChampionSquareAsset($version,$championName);
	$summonerName = rawurldecode($summonerName);
		//print_r($itemsIcon);
	require '../view/test.php';

	
?>