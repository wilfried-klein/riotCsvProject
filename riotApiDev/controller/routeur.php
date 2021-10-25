<?php
require_once (__DIR__ . '/../lib/File.php'); // chemin relatif pour tous
require_once File::build_path(array("model","modelRiotApi.php"));
require_once File::build_path(array("controller","controllerError.php"));
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
		if(isset($_GET['summonerName'])){
			$summonerName = $_GET['summonerName'];
		}elseif (isset($_GET['summonerPuuid'])) {
			$summonerPuuid = $_GET['summonerPuuid'];
		}else{
			$controller='error';
			$view = 'errorOccured';
			$pagetitle = "une erreur est survenue";
			require(File::build_path(array("view","view.php")));
		}
		$server = $_GET['server'];
		$test = require File::build_path(array("controller","controllerProfile.php"));
		if(gettype($test) == "boolean"){
			$controller='profile';
			$view='profile';
			$headerProfile='headerProfile';
			$pagetitle = $summonerName . " - League Data Analysis";
			require(File::build_path(array("view","view.php")));
		}else{
			$controller='error';
			$view = ControllerError::$test[0]($test[1]);
			$pagetitle = "une erreur est survenue";
			require(File::build_path(array("view","view.php")));
		}
	}
	public static function formulaire(){
		$controller='formulaire';
		$view='formulaire';
		$pagetitle = 'Accueil - League Data Analysis';
		require(File::build_path(array("view","view.php")));
	}
	public static function getCsv(){
		$summonerName = $_GET['summonerName'];
		$server = $_GET['server'];
		if(isset($_GET['nbGames'])){
			$gameNumber = intval($_GET['nbGames']);
			if($gameNumber > 20){
				$gameNumber = 1;
			}
		}elseif(isset($_GET['matchId'])){
			$matchId = $_GET['matchId'];
		}else{

		}
		$test = require File::build_path(array("controller","controllerCsv.php"));
		if(!$test){
			require(File::build_path(array("view","csv","giveCsv.php")));
		}else{
			$controller='error';
			$view = ControllerError::$test[0]($test[1]);
			$pagetitle = "une erreur est survenue";
			require(File::build_path(array("view","view.php")));
		}
	}
}

?>
