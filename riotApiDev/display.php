<?php 
	require_once 'Api.php';

	//stock le nom d'invocateur dans un format utilisable dans un URL
	$summoner_name = rawurlencode($_POST["summonerName"]);
	$matchData = Api::getLastMatchStatsbySummoner($summoner_name);
	//extraction des données du champions (sans les runes)
	$champStat = $matchData;
	//supression des runes
	unset($champStat['perks']);
	//extraction des données des runes
	$runesStats = $matchData['perks'];
	//renvoie le puuid de l'invocateur
	//echo Api::getPuuidOfSummoner($summoner_name);
	//renvoie les données de l'invocateur de son dernier match
	//print_r(Api::getLastMatchStatsbySummoner($summoner_name));
	//renvoie le nom du champions en fonctions de son ID
	//echo Api::getChampionsNameByChampionsId(201);
	//renvoie les données du champions suivant son Nom (avec maj)
	//print_r(Api::getChampionDatas('Jhin'));


	//display all datas (expect Runes)
	//affichage des données dans un tableau
	echo '<table>';
	echo 'Champion Stats';
	foreach ($champStat as $key => $value) {
			echo '<tr>';
			echo '<th>';
				echo $key;
			echo '</th>';
			echo '<th>';
				echo $value;
			echo '</th>';
	}
	echo '<br>';
?>