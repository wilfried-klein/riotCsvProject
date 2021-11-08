<?php


class ControllerCsv{
	public static function getMultipleMatch($summonerPuuid,$region,$queue==null){
	//get match list
		$lastMatchsID = ModelRiotApi::getMatchByPuuid($summonerPuuid,$region,null,null,$queue,null,0,$gameNumber);
		$matchAnalysedNumber = count($lastMatchsID);
		$result = array();
		for ($i=0; $i < $matchAnalysedNumber; $i++) { 
			$result[] = getOneMatch($lastMatchsID[$i],$summonerPuuid,$region);
		}
		return $result;
	}

	public static function getOneMatch($matchID,$summonerPuuid,$region){
	//getMatchData
		$matchData = ModelRiotApi::getMatchData($matchID,$region);
	//get summoner index
		$currentSummonerIndex = array_search($summonerPuuid, $matchData['metadata']['participants']);
	//get alls datas for current summoner on an array
		$return = $matchData['info']['participants'][$currentSummonerIndex];
		$runeDataOfCurrentSummoner = $return['perks'];
		unset($return['perks']);
	//ajout de l'id du match, du timestamp, de sa durée, le timeStamp
		$return['matchId'] = $lastMatchsID[$nbG];
		$return['gameStartTimestamp'] = $matchData['info']['gameCreation'];
		if(array_key_exists('gameEndTimestamp', $matchData['info'])){
			$return['gameDuration'] = $matchData['info']['gameDuration'];
			$return['gameEndTimestamp'] = $matchData['info']['gameEndTimestamp'];
		}else{
			$return['gameDuration'] = $matchData['info']['gameDuration']/1000;
			$return['gameEndTimestamp'] = -1;
		}
		return $return;
	}

	public static function arrayToCsvStream($array){
		$csvContent = "";
	//ajout nom colonne
		foreach ($array[0] as $key => $value) {
			$csvContent = $csvContent . $key . ",";
		}
	//remplissage ligne
		foreach ($array as $matchData) {
			$csvContent = $csvContent .  implode(",", $matchData) . "\n";
		}
		return $csvContent;
	}
}
?>