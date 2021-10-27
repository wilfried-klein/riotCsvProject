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
		public static function regionByServer($errorCode){
			return "serverNotExist";
		}
		public static function versionData($errorCode){
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
		public static function profileIconAsset($errorCode){
			return 'errorOccured';
		}
		public static function leagueDatabySummonerId($errorCode){
			if($errorCode == '404'){
				$view = 'serviceUnavailable';
			}elseif($errorCode == '429'){
				$view = 'serviceOverloaded';
			}else{
				$view = 'errorOccured';
			}
			return $view;
		}
		public static function rankedEmblems($errorCode){
			return 'errorOccured';
		}
		public static function matchByPuuid($errorCode){
			if($errorCode == '404'){
				$view = 'serviceUnavailable';
			}elseif($errorCode == '429'){
				$view = 'serviceOverloaded';
			}else{
				$view = 'errorOccured';
			}
			return $view;
		}
		public static function summonerSpellData($errorCode){
			return 'errorOccured';
		}
		public static function runesData($errorCode){
			return 'errorOccured';
		}
		public static function queusData($errorCode){
			return 'errorOccured';
		}
		public static function matchData($errorCode){
			if($errorCode == '404'){
				$view = 'serviceUnavailable';
			}elseif($errorCode == '429'){
				$view = 'serviceOverloaded';
			}else{
				$view = 'errorOccured';
			}
			return $view;
		}
		public static function championSquareAsset($errorCode){
			return 'errorOccured';
		}
		public static function runeAsset($errorCode){
			return 'errorOccured';
		}
		public static function itemsAsset($errorCode){
			return 'errorOccured';
		}
		public static function missingArgument($errorCode){
			return 'errorOccured';
		}
	}

?>