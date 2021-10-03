<?php
	require_once '../model/modelRiotApi.php';

	$summonerName = 'PΔblo';
	$server = 'euw';
	$language = 'fr_FR';
	//to get the most recent DDragon Api Version
	$versions = ModelRiotApi::getVersionData();
	$mostRecentVersion = $versions[0];
	$version = $mostRecentVersion;
	//le language dépend du choix de l'utilisateur
	//mais il est possible d'obtenir la liste des  languages d'un serveur via getLanguagesData();
	$language = 'fr_FR';
	$championName = 'Teemo';
	$skinNum = '0';

	$splashArt = ModelRiotApi::getChampionSplashAsset($championName,$skinNum);
	$loadingScreenArt = ModelRiotApi::getChampionLoadingScreenAsset($championName, $skinNum);
	$square = ModelRiotApi::getChampionSquareAsset($version,$championName);

	//print_r($result);
	echo '<img src="data:image/jpeg;base64,'.$splashArt.'">';
	echo "<br>";
	echo '<img src="data:image/jpeg;base64,'.$loadingScreenArt.'">';
	echo "<br>";
	echo '<img src="data:image/jpeg;base64,'.$square.'">';
?>
