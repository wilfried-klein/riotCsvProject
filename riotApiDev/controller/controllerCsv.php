<?php
class ControllerCsv{
	public static function getMultipleMatch($summonerPuuid,$region,$queue,$gameNumber){
		$lastMatchsID = ModelRiotApi::getMatchByPuuid($summonerPuuid,$region,null,null,$queue,null,0,$gameNumber);
		$matchAnalysedNumber = count($lastMatchsID);
		$result = array();
		for ($i=0; $i < $matchAnalysedNumber; $i++) { 
			$result[] = ControllerCsv::getOneMatch($lastMatchsID[$i],$summonerPuuid,$region);
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
	//ajout de l'id du match, du timestamp, de sa durée, le timeStamp
		$return['matchId'] = $matchID;
		$return['gameStartTimestamp'] = $matchData['info']['gameCreation'];
		if(array_key_exists('gameEndTimestamp', $matchData['info'])){
			$return['gameDuration'] = $matchData['info']['gameDuration'];
			$return['gameEndTimestamp'] = $matchData['info']['gameEndTimestamp'];
		}else{
			$return['gameDuration'] = $matchData['info']['gameDuration']/1000;
			$return['gameEndTimestamp'] = -1;
		}
        //suppression des infos non voulue
        $targets = array('participantId','profileIcon','puuid','riotIdName','riotIdTagline','summonerId','perks','championId','teamId','matchId','gameStartTimestamp','gameEndTimestamp');
        $return = Util::deleteInArray($return,$targets);
        //conversion des booléens
        $return = Util::convertBoolean($return);
		return $return;
	}

	public static function arrayToCsvStream($array){
		$csvContent = "";
	//ajout nom colonne
		foreach ($array[0] as $key => $value) {
			$csvContent = $csvContent . $key . ",";
		}
		$csvContent .= "\n";
	//remplissage ligne
		foreach ($array as $matchData) {
			$csvContent = $csvContent .  implode(",", $matchData) . "\n";
		}
		return $csvContent;
	}
}
?>