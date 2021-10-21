<?php
$summonerName = $_GET['summonerName'];
$server = $_GET['server'];
$language = 'fr_FR';



try {
    $region = ModelRiotApi::getRegionByServer($server);
} catch (Exception $e) {
    die($e->getMessage());
}
try {
    $version = ModelRiotApi::getVersionData()[0];
} catch (Exception $e) {
    die("une erreur est survenue15");
}
try {
    $summonerInfo = ModelRiotApi::getSummonerInfoBySummonerName(rawurlencode($summonerName),$server);
} catch (Exception $e) {
    $errorCode = $e->getMessage();
    if ($errorCode == "404") {
        die("Cette invocateur n'existe pas");
    }
    if ($errorCode == "429") {
        die("Trop de demande,veuiller reéssayer");
    }
    if($errorCode == "503"){
        die("le service est temporairement indisponible, veuiller reéssayer plus tard");
    }
}
try {
    $rankingData = ModelRiotApi::getLeagueDatabySummonerId($summonerInfo['id'], $server);
    foreach ($rankingData as $value) {
        if($value['queueType'] == "RANKED_SOLO_5x5"){
            $rankingInfo = $value;
            break;
        }
    }
    unset($value);
} catch (Exception $e) {
    $errorCode = $e->getMessage();
    if ($errorCode == "403") {
        die("Cette invocateur n'existe pas");
    }
    if ($errorCode == "429") {
        die("Trop de demande,veuiller reéssayer");
    }
    if($errorCode == "503"){
        die("le service est temporairement indisponible, veuiller reéssayer plus tard");
    }
}
if(isset($rankingInfo)){
    //obtention des informations necessaires a l'affichage
    $tier = $rankingInfo['tier'];
    $rank = $rankingInfo['rank'];
    $leaguePoints = $rankingInfo['leaguePoints'];
    $wins = $rankingInfo['wins'];
    $loses = $rankingInfo['losses'];
    $winRatio = round(($wins/($wins+$loses))*100);
}else{
    $tier = "unranked";
    $rank = "1";
}
try {
    $rankedEmblems = ModelRiotApi::getRankedEmblems($tier,$rank);
} catch (Exception $e) {
    $errorCode = $e->getMessage();
    if($errorCode == "404"){
        die("une erreur est survenue74");
    }
    if ($errorCode == "403") {
        die("ce rang n'existe pas");
    }
}
try {
    $partieNumber = 10;
    $lastMatchsID = ModelRiotApi::getMatchByPuuid($summonerInfo['puuid'],$region,null,null,null,null,0,$partieNumber);
} catch (Exception $e) {
    $errorCode = $e->getMessage();
    if ($errorCode == "403") {
        die("Cette invocateur n'existe pas");
    }
    if ($errorCode == "429") {
        die("Trop de demande,veuiller reéssayer");
    }
    if($errorCode == "503"){
        die("le service est temporairement indisponible, veuiller reéssayer plus tard");
    }
}
$matchAnalysedNumber = count($lastMatchsID);
try {
    $summonerSpellData = ModelRiotApi::getSummonerSpellsData($version,$language)['data'];
} catch (Exception $e) {
    die("erreur lors de la récupération des données des sorts d'invocateur");
}
try {
    $runeData = ModelRiotApi::getRunesData($version,$language);
} catch (Exception $e) {
    die("erreur lors de la récupération des données des runes");
}
try {
    $queueData = ModelRiotApi::getQueuesData();
} catch (Exception $e) {
    die("erreur lors de la récupération des données des files");
}
/*
********************************************************************************************************************************************
********************************************************************************************************************************************
********************************************************************************************************************************************
********************************************************************************************************************************************
*/

function msInMinAndSec($secondes){
    $minutes = floor($secondes / 60);

    $secondes = $secondes % 60;
    $minutes = $minutes % 60;

    $format = '%u Min %02u';
    $time = sprintf($format, $minutes, $secondes);

    return $time;
}

$result = array();
for ($numG=0; $numG < $matchAnalysedNumber; $numG++) {
    try {
        $matchData = ModelRiotApi::getMatchData($lastMatchsID[$numG],$region);
    } catch (Exception $e) {
        $errorCode = $e->getMessage();
        if ($errorCode == "403") {
            die("Le match demandé n'existe pas");
        }
        if ($errorCode == "429") {
            die("Trop de demande,veuiller reéssayer");
        }
        if($errorCode == "503"){
            die("le service est temporairement indisponible, veuiller reéssayer plus tard");
        }
    }
    $participantPuuidList = $matchData['metadata']['participants'];
    $currentSummonerIndex = array_search($summonerInfo['puuid'], $participantPuuidList);

    $summonerMatchData = $matchData['info']['participants'];

    $return = array();
    $SummonerIconList = array();
    $summonerNameList = array();
//liste des joueurs + liste des icones de joueurs
    for($i = 0; $i < 10; $i++) {
        $soloSummonerInfo = $summonerMatchData[$i];
        try {
            $summonerIconList[$i] = ModelRiotApi::getChampionSquareAsset($version,$summonerMatchData[$i]['championName']);
        } catch (Exception $e) {
            $errorCode = $e->getMessage();
            if($errorCode == "404"){
                die("une erreur est survenue");
            }
            if ($errorCode == "403") {
                die("cette image de profil n'existe pas");
            }
        }
        $summonerNameList[$i] = $soloSummonerInfo['summonerName'];
    }
    $return['summonerNameList'] = $summonerNameList;
    $return['summonerIconList'] = $summonerIconList;
    $soloSummonerInfo = $summonerMatchData[$currentSummonerIndex];
//nom du champion, icone du champion
    try {
        $return['championName'] = $summonerMatchData[$currentSummonerIndex]['championName'];
        $return['championIcon'] = ModelRiotApi::getChampionSquareAsset($version,$return['championName']);
    } catch (Exception $e) {
        $errorCode = $e->getMessage();
        if($errorCode == "404"){
            die("une erreur est survenue");
        }
        if ($errorCode == "403") {
            die("cet champion n'existe pas");
        }
    }

//search summoner spell
    foreach ($summonerSpellData as $value) {
        if($value['key'] == $soloSummonerInfo['summoner1Id']){
            $return['summonerSpell1'] = ModelRiotApi::getSummonerSpellAsset($version,$value['image']['full']);
        }
    }
    foreach ($summonerSpellData as $value) {
        if($value['key'] == $soloSummonerInfo['summoner2Id']){
            $return['summonerSpell2'] = ModelRiotApi::getSummonerSpellAsset($version,$value['image']['full']);
        }
    }

//icones des runes
    //obtention du chemin vers l'image de la rune
    $rune1 = $summonerMatchData[$currentSummonerIndex]['perks']['styles'][0]['selections'][0]['perk'];
    $branch = $summonerMatchData[$currentSummonerIndex]['perks']['styles'][0]['style'];
    try {
        for ($i=0; $i < count($runeData); $i++) {
            if($runeData[$i]['id'] == $branch){
                $subRuneData = $runeData[$i]['slots'];
                for ($h=0; $h < count($subRuneData) ; $h++) {
                    $array = $subRuneData[$h]['runes'];
                    for ($j=0; $j < count($array); $j++) {
                        if($array[$j]['id'] == $rune1){
                            $return['rune1Icon'] = ModelRiotApi::getRunesAsset($array[$j]['icon']);
                            break(3);
                        }
                    }
                }
            }
        }
    } catch (Exception $e) {
        die();
    }
    $rune2 = $summonerMatchData[$currentSummonerIndex]['perks']['styles'][1]['style'];
    try {
        for ($i=0; $i < count($runeData); $i++) {
            if($runeData[$i]['id'] == $rune2){
                $return['rune2Icon'] = ModelRiotApi::getRunesAsset($runeData[$i]['icon']);
                break;
            }
        }
    } catch (Exception $e) {
        die();
    }

    if(array_key_exists('gameEndTimestamp',$matchData['info'])){
        $return['gameDuration'] = $matchData['info']['gameDuration'];
        $return['gameDurationMinAndSec'] = msInMinAndSec($matchData['info']['gameDuration']);
    }else{
        $return['gameDurationMinAndSec'] = msInMinAndSec($matchData['info']['gameDuration']/1000);
        $return['gameDuration'] = $matchData['info']['gameDuration']/1000;
    }
    foreach ($queueData as $value) {
        if($value['queueId'] == $matchData['info']['queueId']) {
            $return['matchType'] = $value['description'];
            break;
        }
    }

    $return['matchDate'] = getdate(($matchData['info']['gameCreation'])/1000);

    $return['kills'] = $summonerMatchData[$currentSummonerIndex]['kills'];
    $return['deaths'] = $summonerMatchData[$currentSummonerIndex]['deaths'];
    $return['assists'] = $summonerMatchData[$currentSummonerIndex]['assists'];

    $return['creepScore'] = $summonerMatchData[$currentSummonerIndex]['totalMinionsKilled'];
    $return['visionScore'] = $summonerMatchData[$currentSummonerIndex]['visionScore'];
    $return['result'] = $summonerMatchData[$currentSummonerIndex]['win'];


    $itemsList = array(
        $summonerMatchData[$currentSummonerIndex]['item0'],
        $summonerMatchData[$currentSummonerIndex]['item1'],
        $summonerMatchData[$currentSummonerIndex]['item2'],
        $summonerMatchData[$currentSummonerIndex]['item3'],
        $summonerMatchData[$currentSummonerIndex]['item4'],
        $summonerMatchData[$currentSummonerIndex]['item5'],
        $summonerMatchData[$currentSummonerIndex]['item6']
    );
    try {
        $itemsIcon = array();
        for ($i=0; $i < 6; $i++) {
            if($itemsList[$i] != '0'){
                $itemsIcon[] = ModelRiotApi::getItemAsset($version,$itemsList[$i]);
            }
        }
        $return['wardIcon'] = ModelRiotApi::getItemAsset($version,$itemsList[6]);
    } catch (Exception $e) {
        $errorCode = $e->getMessage();
        if($errorCode == "404"){
            die("une erreur est survenue136");
        }
        if ($errorCode == "403") {
            die("cet objet n'existe pas");
        }
    }
    $return['itemsIcon'] = $itemsIcon;
    $return['goldEarned'] = $summonerMatchData[$currentSummonerIndex]['goldEarned'];
    $return['role'] = $summonerMatchData[$currentSummonerIndex]['teamPosition'];

    $result[] = $return;
    try {
        $summonerIcon = ModelRiotApi::getProfileIconAsset($version,$summonerInfo['profileIconId']);
    } catch (Exception $e) {
        die("erreur 261");
    }
}
//moyenne
if($matchAnalysedNumber > 0){
    $average = array(
        'averageVision' => 0,
        'averageKills' => 0,
        'averageDeaths' => 0,
        'averageGolds' => 0,
        'averageDuration' => 0,
        'favoriteRole' => "",
    );
    $favoriteRole = array();
    for ($i=0; $i < $matchAnalysedNumber; $i++) {
        $average['averageVision'] = $average['averageVision'] + $result[$i]['visionScore'];
        $average['averageKills'] = $average['averageKills'] + $result[$i]['kills'];
        $average['averageDeaths'] = $average['averageDeaths'] + $result[$i]['deaths'];
        $average['averageGolds'] = $average['averageGolds'] + $result[$i]['goldEarned'];
        $average['averageDuration'] = $average['averageDuration'] + $result[$i]['gameDuration'];
        $favoriteRole[] = $result[$i]['role'];
    }
    $average['averageVision'] = number_format($average['averageVision']/$matchAnalysedNumber, 2);
    $average['averageKills'] = number_format($average['averageKills']/$matchAnalysedNumber, 2);
    $average['averageDeaths'] = number_format($average['averageDeaths']/$matchAnalysedNumber, 2);
    $average['averageGolds'] = floor($average['averageGolds']/$matchAnalysedNumber);

    $average['averageDuration'] = msInMinAndSec($average['averageDuration']/$matchAnalysedNumber);

    //favorite role :

    $counts = array_count_values($favoriteRole);
    $favoriteRole = 'ARAM';
    arsort($counts);

    if (!function_exists('array_key_first')) {

        function array_key_first(array $arr) {
            foreach($arr as $key => $unused) {
                return $key;
            }
            return NULL;
        }

    }

    $favoriteRole = array_key_first($counts);

    if($favoriteRole=="BOTTOM"){
        $favoriteRole="Botlane";
    }
    if($favoriteRole=="MIDDLE"){
        $favoriteRole="Midlane";
    }
    if($favoriteRole=="TOP"){
        $favoriteRole="Toplane";
    }
    if($favoriteRole=="JUNGLE"){
        $favoriteRole="Jungle";
    }
    if($favoriteRole==""){
        $favoriteRole="ARAM";
    }

}else{
    $average = -1;
}
?>