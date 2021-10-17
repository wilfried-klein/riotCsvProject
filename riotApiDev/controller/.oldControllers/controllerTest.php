<?php
	require_once '../model/modelRiotApi.php';

	//obtenir les informations du dernier match du joueur suivant son ID
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
		'oc1' => 'asia',
		'ru' => 'europe',
		'tr1' => 'europe',
	);
	$region = $regionServerEquivalence[$server];
	//obtention du puuid
	$summonerInfo = ModelRiotApi::getSummonerInfoBySummonerName($summonerName,$server);
	$summonerPuuid = $summonerInfo['puuid'];
	//obtention du dernier match joué
	$lastMatchId = ModelRiotApi::getMatchByPuuid($summonerPuuid,$region,null,null,null,null,0,1)[0];
	//obtention des infos post match
	$matchData = ModelRiotApi::getMatchData($lastMatchId,$region);
	//$playerIdOnGame = $matchData['metadata'];
	$playerMatchData = $matchData['info'];
	$playerMatchData = $playerMatchData['participants'];
	foreach ($playerMatchData as $key => $value) {
		if($value['puuid'] == $summonerPuuid){
			$playerMatchData = $playerMatchData[$key];
		}
	};
	require '../view/displayDatas.php';
?>