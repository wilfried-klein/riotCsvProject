<?php
//require_once ('C:\MAMP\htdocs\projet-s3-outil-analyse-des-donnees-de-league-of-legends\riotApiDev\lib\File.php');
//require_once ('/home/ann2/kleinw/public_html/projet-s3-outil-analyse-des-donnees-de-league-of-legends/riotApiDev/lib/File.php');
require_once ('C:\\Users\Wilfried\projet-s3-outil-analyse-des-donnees-de-league-of-legends\riotApiDev\lib\File.php');
require_once File::build_path(array("model","modelRiotApi.php"));
$action = $_GET['action'];
Routeur::$action();
class Routeur{
	// On recupère l'action passée dans l'URL
	public static function profile() {
		$_GET['summonerName'];
		$_GET['server'];
		require File::build_path(array("controller","controllerProfile.php"));
		$controller='profile';
		$view='profile';
		$headerProfile='headerProfile';
		$pagetitle = $summonerName . " - League Data Analysis";
		require(File::build_path(array("view","view.php")));
	}
	public static function formulaire(){
		$controller='formulaire';
		$view='formulaire';
		$pagetitle = 'Accueil - League Data Analysis';
		require(File::build_path(array("view","view.php")));
	}
	public static function getCsv(){
		require (File::build_path(array("controller","controllerCsv.php")));
	}
}

?>
