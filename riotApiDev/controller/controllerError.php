<?php
	/*	liste des vues :
		-serverNotExist : si erreur dans le nom du serveur
		-errorOccured : en cas d'erreur interne ou en cas d'erreur de l'API Riot (qui n'est pas du a une erreur de l'utilisateur)
		-serviceUnavailable
		-summonerNameNotExist
		- serviceOverload correspond à "rate limit exceeded"

		pour la liste des codes d'erreurs voir sur dev.riot.com au niveau du getter correspondant

	*/
	class ControllerError{
		public static function getRegionByServer($errorCode){
			return "serverNotExist";
		}
		public static function getVersionData($errorCode){
			if($errorCode == '404'){
				$view = 'serviceUnavailable';
			}elseif ($errorCode == '403') {
				$view = 'errorOccured';
			}else{
				$view = 'errorOccured';
			}
			return $view;
		}
		public static function getSummonerInfoBySummonerName($errorCode){
			if ($errorCode == '404') {
				$view = 'summonerNameNotExist';
			}elseif($errorCode == '429'){
				$view = 'serviceOverloaded';
			}else{
				$view = 'errorOccured';
			}
			return $view;
		}
		public static function getProfileIconAsset($errorCode){
			return 'errorOccured';
		}
		public static function getLeagueDatabySummonerId($errorCode){
			if($errorCode == '404'){
				$view = 'serviceUnavailable';
			}elseif($errorCode == '429'){
				$view = 'serviceOverloaded';
			}else{
				$view = 'errorOccured';
			}
			return $view;
		}
		public static function getRankedEmblems($errorCode){
			return 'errorOccured';
		}
		public static function getMatchByPuuid($errorCode){
			if($errorCode == '404'){
				$view = 'serviceUnavailable';
			}elseif($errorCode == '429'){
				$view = 'serviceOverloaded';
			}else{
				$view = 'errorOccured';
			}
			return $view;
		}
		public static function getSummonerSpellData($errorCode){
			return 'errorOccured';
		}
		public static function getRunesData($errorCode){
			return 'errorOccured';
		}
		public static function getQueusData($errorCode){
			return 'errorOccured';
		}
		public static function getMatchData($errorCode){
			if($errorCode == '404'){
				$view = 'serviceUnavailable';
			}elseif($errorCode == '429'){
				$view = 'serviceOverloaded';
			}else{
				$view = 'errorOccured';
			}
			return $view;
		}
		public static function getChampionSquareAsset($errorCode){
			return 'errorOccured';
		}
		public static function getRuneAsset($errorCode){
			return 'errorOccured';
		}
		public static function getItemsAsset($errorCode){
			return 'errorOccured';
		}
		public static function getMissingArgument($errorCode){
			return 'errorOccured';
		}
	}

?>