 <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>test accountId avec summonerName fournit</title> <!-- CETTE PAGE EST UNE PAGE TEST
	QUI SERT A RETROUVER L'accountId (QUI EST UNE VALEUR DITES "ENCRYPTED" : donc encoder) à l'aide du summonerName -->
</head>
<body>
	<?php
	$summonerName = rawurlencode($_POST["summonerName"]); //recupération du nom d'invocateur entré dans le formulaire

	$url = "https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-name/". $summonerName . "?api_key=RGAPI-d1b01cff-22ad-4ff1-b3b8-117df0ab7cdb";
    //url de l'api qui nous intéresse + $summonerName (donc le nom d'invocateur que l'on vien de récupérer) + l'api KEY (RESET TOUTES LES 24H)

	$json = file_get_contents($url);//je récupère le contenu de la page de l'api qui nous intéresse
	$json_data = json_decode($json, true); //je decode le contenu afin que toutes les variables soient facile d'accès et compréhensible sous forme d'une sorte de tableau
    $accountId = $json_data["accountId"]; //je récupère dans le tableau $json_data la variable $accountId


	echo '<table>';
		echo '<tr>';
			echo '<th>';
                echo "L' accountId de " . $summonerName . " : ";
			echo '</th>';
			echo '<th>';
				echo $accountId;
			echo '</th>';
		echo '<tr>'	;
		echo '<tr>';

echo '</table>';
	?>
</body>
</html>
