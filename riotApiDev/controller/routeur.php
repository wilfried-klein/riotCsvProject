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
		$controller='formulaire';
		$view='formulaire';
		$pagetitle = 'Accueil - League Data Analysis';
		require(File::build_path(array("view","view.php")));
	}
	public static function getCsv(){
		try {
			require File::build_path(array("controller","controllerCsv.php"));
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
