<?php
require_once (__DIR__ . '/../lib/File.php'); // chemin relatif pour tous
require_once File::build_path(array("model","modelRiotApi.php"));
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
		$summonerName = $_GET['summonerName'];
		$server = $_GET['server'];
		$test = require File::build_path(array("controller","controllerProfile.php"));
		if(gettype($test) == "boolean"){
			$controller='profile';
			$view='profile';
			$headerProfile='headerProfile';
			$pagetitle = $summonerName . " - League Data Analysis";
			require(File::build_path(array("view","view.php")));
		}else{
			require File::build_path(array("controller","controllerError.php"));
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
		$gameNumber = intval($_GET['nbGames']);
		if($gameNumber > 20){
			$gameNumber = 1;
		}
		$test = require File::build_path(array("controller","controllerCsv.php"));
		if(!$test){
			require(File::build_path(array("view","csv","giveCsv.php")));
		}else{
			require File::build_path(array("controller","controllerError.php"));
			$controller='error';
			$view = ControllerError::$test[0]($test[1]);
			$pagetitle = "une erreur est survenue";
			require(File::build_path(array("view","view.php")));
		}
	}
}

?>
