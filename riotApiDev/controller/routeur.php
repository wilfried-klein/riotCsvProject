<?php
require_once (__DIR__ . '/../lib/File.php'); // chemin relatif pour tous
require_once File::build_path(array("model","modelRiotApi.php"));
require_once File::build_path(array("controller","controllerError.php"));
require_once File::build_path(array("controller","controllerCsv.php"));
//definition et vérification de la fonction
//formualaire sera celle par défaut
if(isset($_GET['action'])){
	$action = $_GET['action'];
	if(array_search($action,get_class_methods('Routeur')) === false){
		$action = 'formulaire';
	}
}else{
	$action = 'formulaire';
}
Routeur::$action();
class Routeur{
	public static function profile() {
		try {
			require File::build_path(array("controller","controllerProfile.php"));
			$controller='profile';
			$view='profile';
			$headerProfile='headerProfile';
			$pagetitle = $summonerName . " - League Data Analysis";
			require(File::build_path(array("view","view.php")));
		} catch (Exception $e) {
			$controller='error';
			$function = $e->getMessage();
			$errorCode =$e->getCode();
			$view = ControllerError::$function($errorCode);
			$pagetitle = "une erreur est survenue";
			require(File::build_path(array("view","view.php")));
		}
	}
	public static function formulaire(){
		echo "test";
		$controller='formulaire';
		$view='formulaire';
		$pagetitle = 'Accueil - League Data Analysis';
		require(File::build_path(array("view","view.php")));
	}
	public static function getCsv(){
		try {
			if(!isset($_GET['summonerPuuid']) || !isset($_GET['queue']) || !isset($_GET['region']) || !isset($_GET['gameNumber'])){
				throw new Exception("MissingArgument");
			}else{
				$queue = $_GET['queue'];
				$summonerPuuid = $_GET['summonerPuuid'];
				$region = $_GET['region'];
				$gameNumber = $_GET['gameNumber'];
			}
			$matchData = ControllerCsv::getMultipleMatch($summonerPuuid,$region,$queue,$gameNumber);
			$csvContent = ControllerCsv::arrayToCsvStream($matchData);
			require(File::build_path(array("view","csv","giveCsv.php")));
		} catch (Exception $e) {
			$controller='error';
			$function = $e->getMessage();
			$errorCode =$e->getCode();
			$view = ControllerError::$function($errorCode);
			$pagetitle = "une erreur est survenue";
			require(File::build_path(array("view","view.php")));
		}
	}
	public static function getOneCsv(){
		try {
			if(!isset($_GET['matchId']) || !isset($_GET['summonerPuuid']) || !isset($_GET['region'])){
				throw new Exception("MissingArgument");
			}else{
				$matchID = $_GET['matchId'];
				$summonerPuuid = $_GET['summonerPuuid'];
				$region = $_GET['region'];
			}
			$matchData = ControllerCsv::getOneMatch($matchID,$summonerPuuid,$region);
			$array = array($matchData);
			$csvContent = ControllerCsv::arrayToCsvStream($array);
			require(File::build_path(array("view","csv","giveCsv.php")));
		} catch (Exception $e) {
			$controller='error';
			$function = $e->getMessage();
			$errorCode =$e->getCode();
			$view = ControllerError::$function($errorCode);
			$pagetitle = "une erreur est survenue";
			require(File::build_path(array("view","view.php")));
		}
	}
}

?>
