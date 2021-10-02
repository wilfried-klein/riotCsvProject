<?php
	class ModelRiotApi{
		private static $api_key = "RGAPI-d1b01cff-22ad-4ff1-b3b8-117df0ab7cdb";


		//PARTIE 'CONF' EN MODÈLE MVC

		//json getter
		private static function jsonGetter($url){
			$json = file_get_contents($url);
			$json_data = json_decode($json, true);
			return $json_data;
		}

		//RIOT API
		//FAIT DES REQUÊTES VERS L'API RIOT

		/*
		CORRECT VALUE FOR FUNCTION PARAMETERS :
		$server = {br1,eun1,euw1,jp1,kr,la1,la2,na1,oc1,ru,tr1}
		$region = {americas,asia,europe}
		$queue = {RANKED_SOLO_5x5,RANKED_FLEX_SR,RANKED_FLEX_TT}
		$division = {I,II,III,IV}
		$tier = {DIAMOND,PLATINUM,GOLD,SILVER,BRONZE,IRON}
		//for matchv5/bypuid
		$type = {ranked,normal,tourney,tutorial}
		*/

		//CHAMPION-V3
		//lol/platform/v3/champions-rotations
		//obtenir la rotation des champions actuel
		//retourne un array
		public static function getChampRotationbyServer($server){
			$url = "https://" . $server . ".api.riotgames.com/lol/platform/v3/champion-rotations?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);
		}

		//SUMMONER-V4
		//obtenir les informations d'un invocateur
		//lol/summoner/v4/summoners/by-account
		//retourne un array
		public static function getSummonnerInfoByAccountId($accountID, $server){
			$url = "https://" . $server . ".api.riotgames.com/lol/summoner/v4/summoners/by-account/" . $accountID . "?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);
		}
		//lol/summoner/v4/summoners
		//retourne un array
		public static function getSummonnerInfoBySummonerId($summonerID, $server){
			$url = "https://" . $server . ".api.riotgames.com/lol/summoner/v4/summoners/" . $summonerID . "?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);
		}
		//lol/summoner/v4/summoners/by-name
		//retourne un array
		public static function getSummonerInfoBySummonerName($summonerName,$server){
			$url = "https://" . $server . ".api.riotgames.com/lol/summoner/v4/summoners/by-name/" . $summonerName .  "?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);
		}
		//lol/summoner/v4/summoners/by-puuid
		//retourne un array
		public static function getSummonerInfoByPuuid($summonerPuuid, $server){
			$url = "https://" . $server . ".api.riotgames.com/lol/summoner/v4/summoners/by-puuid/" . $summonerPuuid . "?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);
		}

		//CHAMPION-MASTERY-V4
		//lol/champion-mastery/v4/champion-masteries/by-summoner
		//obtenir les informations des maitrise de champions d'un invocateur
		//retourne un array
		public static function getChampionMasteryBySummonerId($summonerID, $server){
			$url = "https://" . $server . ".api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/" . $summonerID . "?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);
		}
		//lol/champion-mastery/v4/champion-masteries/by-summoner/by-champion
		//obtenir les informations des maitrise de champions d'un invocateur suivant l'ID du champion
		//retourne un array
		public static function getChampionMasteryBySummonerIdAndChampionId($summonerID, $championId, $server){
			$url = "https://" . $server . ".api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/" . $summonerID . "/by-champion/" . $championId . "?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url); 
		}
		//lol/champion-mastery/v4/scores/by-summoner
		//obtenir le nombre total de point de maitrise d'un invocateur
		//retourne un int
		public static function getChampionMasteryScoreBySummonerId($summonerID, $server){
			$url = "https://" . $server . ".api.riotgames.com/lol/champion-mastery/v4/scores/by-summoner/" . $summonerID . "?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);
		}

		//SPECTATOR-V4
		//lol/spectator/v4/active-games/by-summoner
		//obtenir les informations de la partie en cours d'un invocateur
		//retourne 404 si le joueur n'est pas en jeu
		//retourne un array
		public static function getDirectMatchDataBySummonerId($summonerID, $server){
			$url = "https://" . $server . ".api.riotgames.com/lol/spectator/v4/active-games/by-summoner/" . $summonerID . "?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);
		}
		//lol/spectator/v4/featured-games
		//retourne la liste des partie "en vedette" par serveur
		//retourne un array
		public static function getFeaturedGamesByServer($server){
			$url = "https://" . $server . ".api.riotgames.com/lol/spectator/v4/featured-games?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);

		}

		//THIRD-PARTY-CODE-V4
		//lol/platform/v4/third-party-code/by-summoner
		//retourne 404 si celui n'existe pas
		//retourne un array
		public static function getThirdPartyCodebySummonerId($summonerID,$server){
			$url = "https://" . $server . ".api.riotgames.com/lol/platform/v4/third-party-code/by-summoner/" . $summonerID . "?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);
		}

		//LEAGUE-V4
		//lol/league/v4/challengerleagues/by-queue
		//obtenir la liste des challengers et les informations de classement de chaque joueur
		//retourne un array
		public static function getChallengersListByQueueAndServer($queue, $server){
			$url = "https://" . $server . ".api.riotgames.com/lol/league/v4/challengerleagues/by-queue/" . $queue . "?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);
		}
		//lol/league/v4/leagues/
		//obtenir la liste des joueur suivant l'ID de la ligue
		//retourne un array
		public static function getSummonerListByLeagueIdAndServer($leagueID, $server){
			$url = "https://" . $server . ".api.riotgames.com/lol/league/v4/leagues/" . $leagueID . "?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);
		}
		//lol/league/v4/masterleagues/by-queue/
		//obtenir la liste des challengers et les informations de classement de chaque joueur
		//retourne un array
		public static function getMasterListByQueueAndServer($queue, $server){
			$url = "https://" . $server . ".api.riotgames.com/lol/league/v4/masterleagues/by-queue/" . $queue . "?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);
		}
		//lol/league/v4/grandmasterleagues/by-queue
		//obtenir la liste des grandmaster et les informations de classement de chaque joueur
		//retourne un array
		public static function getGrandmasterListByQueueAndServer($queue, $server){
			$url = "https://" . $server . ".api.riotgames.com/lol/league/v4/grandmasterleagues/by-queue/" . $queue . "?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);
		}
		//lol/league/v4/entries/by-summoner
		//obtenir les informations de classement a propos d'un joueur
		//retourne un array
		public static function getLeagueDatabySummonerId($summonerID, $server){
			$url = "https://" . $server . ".api.riotgames.com/lol/league/v4/entries/by-summoner/" . $summonerID . "?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);
		}
		//lol/league/v4/entries/
		//obtenir la liste des joueur suivant la file,le rang et la division
		//retourne un array
		public static function getSummonersInfoByQueueTierAndDivision($queue,$tier,$division,$server,$page=1){
			$url = "https://" . $server . ".api.riotgames.com/lol/league/v4/entries/" . $queue . "/" . $tier . "/" . $division . "?page=" . $page . "&api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);
		}
		//MATCH-V5
		//lol/match/v5/matches/
		//obtenir les données de fin de match
		//retourne un array
		public static function getMatchData($matchID,$region){
			$url = "https://" . $region . ".api.riotgames.com/lol/match/v5/matches/" . $matchID . "?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);
		}
		//lol/match/v5/matches/by-puuid/
		//obtenir la liste des matchs d'un invocateur
		//retourne un array
		//pour le queue : https://static.developer.riotgames.com/docs/lol/queues.json
		public static function getMatchByPuuid($summonerPuuid,$region,$startTime=null,$endTime=null,$queue=null,$type=null,$start=null,$count=null){
			$url = "https://" . $region . ".api.riotgames.com/lol/match/v5/matches/by-puuid/" . $summonerPuuid . "/ids?api_key=" . ModelRiotApi::$api_key;
			if ($startTime != null) {
				$url = $url . "&startTime=" . $starTime;
			}if ($endTime != null) {
				$url = $url . "&endTime=" . $endTime;
			}if ($queue != null) {
				$url = $url . "&queue=" . $queue;
			}if ($type != null) {
				$url = $url . "&type=" . $type;
			}if ($start != null) {
				$url = $url . "&start=" . $start;
			}if ($count != null) {
				$url = $url . "&count=" . $count;
			}
			return ModelRiotApi::jsonGetter($url); 
		}
		//lol/match/v5/matches/timeline
		//obtenir les données a propos des envenement au cours d'une partie
		//retourne un array
		public static function getMatchTimeline($matchID,$region){
			$url = "https://" . $region . ".api.riotgames.com/lol/match/v5/matches/" . $matchID . "/timeline?api_key=" . ModelRiotApi::$api_key;
			return ModelRiotApi::jsonGetter($url);
		}

		//DDRAGON-API
		//REQUETES VERS DDRAGON
		//À COMPLÉTER
		//POUR LES OBJET, RUNES...
		//https://developer.riotgames.com/docs/lol#data-dragon
	}



?>