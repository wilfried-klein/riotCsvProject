<?php 
/*
----------------!!!! IMPORTANT !!!!----------------
l'utisateur de cette api ne doit envoyer que le nom d'invocateur
des fonctions gere ensuite pour renvoyer les données
les commentaires : //besoin du ***** => non utilisable par l'utilisateur veut simplement dire que la fonction ne respecte pas cette présente règle mais peut être tout de même appeller
---------------------------------------------------
L'API ne gere pour l'instant que les requetes pour le serveur "euw"
les erreurs ne sont pour le moment pas gérer*/
class Api {
	private static $api_key = "RGAPI-d1b01cff-22ad-4ff1-b3b8-117df0ab7cdb";
	//ne fonctionne pas
	/*private static $regionServerEquivalence = array(
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

	//summonerV4/byname/all
	//besoin de summoner_name => utilisable par l'utilisateur
	//renvoie toutes les données reçus via summonerV4/byname/
	public static function getSummonerInfobySummonerName($summoner_name){
		$url = "https://" . "euw1". ".api.riotgames.com/lol/summoner/v4/summoners/by-name/" . $summoner_name . "?api_key=" . Api::$api_key;
		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		return $json_data;
	}

	//summonnerV4/byname/puuid
	//besoin de summoner_name => utilisable par l'utilisateur
	//renvoie le puuid a partir du nom d'invocateur
	public static function getPuuidOfSummoner($summoner_name){
		$array = Api::getSummonerInfobySummonerName($summoner_name);
		return $array["puuid"];
	}

	//matchV5/bypuuids
	//besoin de Puuid et du nombre de match => non utilisable par l'utilisateur
	//renvoie un tableau contenant les n dernier match à partir du puuid
	public static function getMatchsIDListbySummonerName($summoner_name, $numberOfMatchs){
		$puuid = Api::getPuuidOfSummoner($summoner_name);
		$url = "https://europe.api.riotgames.com/lol/match/v5/matches/by-puuid/" . $puuid . "/ids?start=0&count=" . $numberOfMatchs . "&api_key=" . Api::$api_key;
		$json_data = json_decode(file_get_contents($url), true);
		return $json_data;
	}

	//matchV5/bypuuids
	//besoin de summoner_name => utilisable par l'utilisateur
	//renvoie l'Id du dernier match joué par le joueur
	public static function getLastMatchIDbySummonerName($summoner_name){
		$array = Api::getMatchsIDListbySummonerName($summoner_name,1);
		return $array[0];
	}

	//matchV5/{matchid}
	//besoin du matchId => non utilisable par l'utilisateur
	//renvoie un tableau contenant toutes les données d'un match à partir d'un matchId
	public static function getAllMatchData($matchId){
		$url = "https://europe.api.riotgames.com/lol/match/v5/matches/" . $matchId . "?api_key=" . Api::$api_key;
		$json_data = json_decode(file_get_contents($url), true);
		return $json_data;
	}

	//matchv5/{matchid}
	//besoin du matchId et le summoner_name => non utilisable par l'utilisateur
	//retourne les données du joueur d'un match
	public static function getMatchPlayerStats($matchId,$summoner_name){
		$array = Api::getAllMatchData($matchId);
		//get index where player data is indicated
		$answer = $array['metadata'];
		$answer = $answer['participants'];
		$index = array_search(Api::getPuuidOfSummoner($summoner_name), $answer);
		//get match stat for current player
		$answer = $array['info'];
		$answer = $answer['participants'];
		$answer = $answer[$index];
		return $answer;
	}

	//matchV5/{matchID}
	//besoin de summoner_name => utilisable par l'utilisateur
	//retourne les données du joueur pour le dernier match qu'il a joué
	public static function getLastMatchStatsbySummoner($summoner_name){
		$matchId = Api::getLastMatchIDbySummonerName($summoner_name);
		$array = Api::getMatchPlayerStats($matchId,$summoner_name);
		return $array;
	}

	//matchV5/{matchID}
	//besoin du matchId => non utilisable par l'utilisateur
	//retourne les métadonnées d'un match
	public static function getMatchMetadata($matchId){
		$array = Api::getAllMatchData($matchId);
		return $array['metadata'];
	}

	//matchV5/{matchID}
	//besoin du matchId => non utilisable par l'utilisateur
	//retourne les informations générales du match
	public static function getMatchInfo($matchId){
		$array = Api::getAllMatchData($matchId);
		$array = $array['info'];
		unset($array['teams']);
		unset($array['participants']);
		return $array;
	}

	//matchV5/{matchID}
	//besoin du matchId => non utilisable par l'utilisateur
	//retourne les informations propos des équipes du match (section "teams")
	public static function getTeamInfoOfMatch($matchId){
		$array = Api::getAllMatchData($matchId);
		$array = $array['info'];
		$array = $array['teams'];
		return $array;
	}

	//obtenir les inforamtions à propos des champions
	//utilise ddragon : https://riot-api-libraries.readthedocs.io/en/latest/ddragon.html
	public static function getAllChampionsDatas(){
		$url = "https://ddragon.leagueoflegends.com/cdn/9.3.1/data/fr_FR/champion.json";
		$json_data = json_decode(file_get_contents($url), true);
		return $json_data;
	}

	//obtenir le nom du champion suivant sont ID
	//retourne -1 en cas d'erreur
	//utilise ddragon : https://riot-api-libraries.readthedocs.io/en/latest/ddragon.html
	public static function getChampionsNameByChampionsId($championsName){
		$array = Api::getAllChampionsDatas();
		$array = $array['data'];
		foreach ($array as $element) {
			if ($element['key'] == $championsName) {
				return $element['name'];
			}
		}
		return -1;
	}

	//obtenir les données d'un champions en fonction de son nom
	//retourne -1 en cas d'erreur
	//utilise ddragon : https://riot-api-libraries.readthedocs.io/en/latest/ddragon.html
	public static function getChampionDatas($championName){
		$array = Api::getAllChampionsDatas();
		$array = $array['data'];
		foreach ($array as $element) {
			if ($element['id'] == $championName) {
				return $element;
			}
		}
		return -1;
	}
}
?>