<?php
class ControllerCsv{
	
	//$list of column name of css
	private static $list = null;

	public static function getList(){
		if(ControllerCsv::$list == null){
			ControllerCsv::$list = json_decode(file_get_contents('list.json'),true);
		}
		return ControllerCsv::$list;
	}

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
	//itemId => itemName
		for ($i=0; $i < 7; $i++) { 
			$return["item$i"] = Util::getObjectName($return["item$i"]);
		}
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
        //filtrage des données du match
		$return = Util::arrayFilter($return,array_keys(ControllerCsv::getList()));
        //conversion des booléens
		$return = Util::convertBoolean($return);
		return $return;
	}

	public static function arrayToCsvStream($array){
		$csvContent = "";
		//modification nom colonne
		$array[0] = Util::multiChangeColumnName($array[0],ControllerCsv::getList());
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