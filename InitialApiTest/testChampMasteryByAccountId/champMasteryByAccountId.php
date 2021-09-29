<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>test accountId avec summonerName fournit</title>
</head>
<body>
<?php
require_once "formulaireChampMastery.html";

$summonerName = rawurlencode($_POST["summonerName"]);
$championId = rawurlencode($_POST["championid"]);

$url = "https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-name/". $summonerName . "?api_key=RGAPI-d1b01cff-22ad-4ff1-b3b8-117df0ab7cdb";
$json = file_get_contents($url);
$json_data = json_decode($json, true);
$id = $json_data["id"];


$url = "https://euw1.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/". $id . "/by-champion/" . $championId . "?api_key=RGAPI-d1b01cff-22ad-4ff1-b3b8-117df0ab7cdb";
$json = file_get_contents($url);
$json_data = json_decode($json, true);

$championId = $json_data["championId"];



$result = array(
    'championId' =>$json_data['championId'],
    'championLevel' => $json_data['championLevel'],
    'championPoints' => $json_data['championPoints'],
    'lastPlayTime' => $json_data['lastPlayTime'],
    'championPointsSinceLastLevel' => $json_data['championPointsSinceLastLevel'],
    'championPointsUntilNextLevel' => $json_data['championPointsUntilNextLevel'],
    'chestGranted' => $json_data['chestGranted'],
    'tokensEarned' => $json_data['tokensEarned'],
);
?>
<table>

<tr>
    <th>
        Champion Level :
    </th>
<th>
    <?php
        echo $result['championLevel'];
    ?>
</th>
<tr>

<tr>
    <th>
        Champion Points :
    </th>
    <th>
        <?php
        echo $result['championPoints'];
        ?>
    </th>
<tr>
</table>';

</body>
</html>
