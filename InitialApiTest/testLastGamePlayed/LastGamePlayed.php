<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Resultat</title>
</head>
<body>
	<?php
	$summonerName = rawurlencode($_POST["summonerName"]);
	$url = "https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-name/". $summonerName . "?api_key=RGAPI-d1b01cff-22ad-4ff1-b3b8-117df0ab7cdb";
	$json = file_get_contents($url);
	$json_data = json_decode($json, true);
	$puuid = $json_data["puuid"];
	$url = "https://europe.api.riotgames.com/lol/match/v5/matches/by-puuid/" . $puuid . "/ids?start=0&count=1&api_key=RGAPI-d1b01cff-22ad-4ff1-b3b8-117df0ab7cdb";
	$json = file_get_contents($url);
	$json_data = json_decode($json, true);
	$matchId = $json_data[0];
	$url = "https://europe.api.riotgames.com/lol/match/v5/matches/" . $matchId . "?api_key=RGAPI-d1b01cff-22ad-4ff1-b3b8-117df0ab7cdb";
	$json = file_get_contents($url);
	$json_data = json_decode($json, true);
	$echo = $json_data['metadata'];
	$echo = $echo['participants'];
	$count = array_search($puuid, $echo);
	$echo = $json_data['info'];
	$gamemode = $echo['gameMode'];
	$gameType = $echo['gameType'];
	$gameDuration = $echo['gameDuration'];
	$echo = $echo['participants'];
	$echo = $echo[$count];
	$result = array(
		'championName' => $echo['championName'],
		'totalDamageDealtToChampions' => $echo['totalDamageDealtToChampions'],
		'totalMinionsKilled' => $echo['totalMinionsKilled'],
		'visionScore' => $echo['visionScore'],
		'kills' => $echo['kills'],
		'deaths' => $echo['deaths'],
		'assists' => $echo['assists'],
		'goldEarned' => $echo['goldEarned'],
	);
	echo '<table>';
		echo '<caption>Summonner stats for last game</caption>';
		echo '<tr>';
			echo '<th>';
				echo "Durée de la partie";
			echo '</th>';
			echo '<th>';
				$gameDurationInMin = $gameDuration / 60000;
				echo floor($gameDurationInMin) . "min " . floor(($gameDurationInMin - floor($gameDurationInMin))*60) . "s";
			echo '</th>';
		echo '<tr>'	;
		echo '<tr>';
			echo '<th>';
				echo "Champions";
			echo '</th>';
			echo '<th>';
				echo $result['championName'];
			echo '</th>';
		echo '<tr>'	;
		echo '<tr>';
			echo '<th>';
				echo "Dégats Infligés";
			echo '</th>';
			echo '<th>';
				echo $result['totalDamageDealtToChampions'];
			echo '</th>';
		echo '<tr>';
		echo '<tr>';
			echo '<th>';
				echo "Creep Tués";
			echo '</th>';
			echo '<th>';
				echo $result['totalMinionsKilled'] . " *";
			echo '</th>';
		echo '<tr>';
		echo '<tr>';
			echo '<th>';
				echo "Or Gagné";
			echo '</th>';
			echo '<th>';
				echo $result['goldEarned'];
			echo '</th>';
		echo '<tr>';
		echo '<tr>';
			echo '<th>';
				echo "Score de Vision";
			echo '</th>';
			echo '<th>';
				echo $result['visionScore'];
			echo '</th>';
		echo '<tr>';
		echo '<tr>';
			echo '<th>';
				echo "Kills";
			echo '</th>';
			echo '<th>';
				echo $result['kills'];
			echo '</th>';
		echo '<tr>';
		echo '<tr>';
			echo '<th>';
				echo "Morts";
			echo '</th>';
			echo '<th>';
				echo $result['deaths'];
			echo '</th>';
		echo '<tr>';
		echo '<tr>';
			echo '<th>';
				echo "Assistances";
			echo '</th>';
			echo '<th>';
				echo $result['assists'];
			echo '</th>';
		echo '<tr>';
echo '</table>';
echo "*ne prend pas en compte les balises détruites";
	?>
</body>
</html>