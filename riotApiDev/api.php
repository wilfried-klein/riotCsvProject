<?php 
/*29/09/2021 
Pour le moment :
- toutes les fonctions fonctionnes
- le tableau d'équivalence serveur<=>region (pour les requetes necessitant un region) ne fonctionne pas regionServerEquivalence
- il n'est donc possible d'obtenir seulement les infos des joueurs en "europe" 
À faire :
- resoudre pb regionServerEquivalence
- reflechir à l'ajout du puuid en tant que variable global (appelle de fonction dans le constructeur ?, Singleton Pattern ?)
- creation d'une nouvelle classe renvoyant les données plus precisement
ou simplement dans cette meme classe
*/ 
class Api {
	private $api_key = "RGAPI-d1b01cff-22ad-4ff1-b3b8-117df0ab7cdb";
	private $server;
	private $summoner_name;
	/*private $regionServerEquivalence = array(
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
	);*/
	public function __construct($server, $summoner_name){
		$this->server = $server;
		$this->summoner_name = rawurlencode($summoner_name);
	}
	public function setApiKey($apiKey) {
		$this->apikey = $apikey;
	}
	//return array with info from current summonners
	public function getSummonerInfo(){
		$url = "https://" . $this->server . ".api.riotgames.com/lol/summoner/v4/summoners/by-name/" . $this->summoner_name . "?api_key=" . $this->api_key;
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		return $json_data;
	}
	public function getPuuidOfSummoner(){
		$array = $this->getSummonerInfo();
		return $array["puuid"];
	}
	//return array with marchId by most most recent for current summonner
	public function getMatchsIDListbyPUUID($puuid,$numberOfMatchs){
		$server = $this->server;
		//$region = $this->$regionServerEquivalence[$server];
		$url = "https://" . "europe" . ".api.riotgames.com/lol/match/v5/matches/by-puuid/" . $puuid . "/ids?start=0&count=" . $numberOfMatchs . "&api_key=" . $this->api_key;
		$json_data = json_decode(file_get_contents($url), true);
		return $json_data;
	}
	//return string of last match played for current summoner
	public function getLastMatchIDbyPUUID($puuid){
		$array = $this->getMatchsIDListbyPUUID($puuid,1);
		return $array[0];
	}
	//return array with all data for match by matchId
	public function getAllMatchData($matchId){
		//$region = $this->$regionServerEquivalence[$this->server];
		$url = "https://" . "europe" . ".api.riotgames.com/lol/match/v5/matches/" . $matchId . "?api_key=" . $this->api_key;
		$json_data = json_decode(file_get_contents($url), true);
		return $json_data;
	}
	public function getMatchStats($matchId){
		$array = $this->getAllMatchData($matchId);
		//get index where player data is indicated
		$answer = $array['metadata'];
		$answer = $answer['participants'];
		$index = array_search($this->getPuuidOfSummoner(), $answer);
		//get match stat for current player
		$answer = $array['info'];
		$answer = $answer['participants'];
		$answer = $answer[$index];
		return $answer;
	}
}



?>
