<?php
$language = 'fr_FR';
$partieNumber = 10;
$server = $_GET['server'];
$region = ModelRiotApi::getRegionByServer($server);
$versionList = ModelRiotApi::getVersionData();
$currentVersion = $versionList[0];
if(isset($_GET['summonerName'])){
    $summonerName = $_GET['summonerName'];
    $summonerInfo = ModelRiotApi::getSummonerInfoBySummonerName(rawurlencode($_GET['summonerName']),$server);
}elseif(isset($_GET['summonerPuuid'])){
    $summonerInfo = ModelRiotApi::getSummonerInfoByPuuid(rawurlencode($_GET['summonerPuuid']), $server);
    $summonerName = $summonerInfo['name'];
}else{
    throw new Exception("missingArgument",0);
    
}
$summonerPuuid = $summonerInfo['puuid'];
$summonerLevel = $summonerInfo['summonerLevel'];
$summonerIcon = ModelRiotApi::getProfileIconAsset($currentVersion,$summonerInfo['profileIconId']);
$rankingData = ModelRiotApi::getLeagueDatabySummonerId($summonerInfo['id'], $server);
foreach ($rankingData as $rankingInfo) {
    if($rankingInfo['queueType'] == "RANKED_SOLO_5x5"){
        break;
    }
}
if(isset($rankingInfo)){
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
$rankedEmblems = ModelRiotApi::getRankedEmblems($tier,$rank);
$lastMatchsID = ModelRiotApi::getMatchByPuuid($summonerInfo['puuid'],$region,null,null,null,null,0,$partieNumber);
$matchAnalysedNumber = count($lastMatchsID);
$summonerSpellData = ModelRiotApi::getSummonerSpellsData($currentVersion,$language)['data'];
$runeData = ModelRiotApi::getRunesData($currentVersion,$language);
$queueData = ModelRiotApi::getQueuesData();
$result;
for($nbG=0; $nbG < $matchAnalysedNumber;$nbG++) {
    $matchData = ModelRiotApi::getMatchData($lastMatchsID[$nbG],$region);
    $result[$nbG]['matchId'] = strtoupper($server)."_".$matchData['info']['gameId'];
    $matchVersion = explode(".",$matchData['info']['gameVersion'])[0] .".".explode(".",$matchData['info']['gameVersion'])[1] . ".1";
    $currentSummonerIndex = array_search($summonerInfo['puuid'], $matchData['metadata']['participants']);
    $summonerMatchData = $matchData['info']['participants'];
    for($i = 0; $i < 10; $i++) {
        $soloSummonerInfo = $summonerMatchData[$i];
        $result[$nbG]['summonerIconList'][$i] = ModelRiotApi::getChampionSquareAsset($matchVersion,$summonerMatchData[$i]['championName']);
        $result[$nbG]['summonerNameList'][$i] = $soloSummonerInfo['summonerName'];
        $result[$nbG]['summonerPuuid'][$i] = $soloSummonerInfo['puuid'];
    }
    $soloSummonerInfo = $summonerMatchData[$currentSummonerIndex];
    $result[$nbG]['championName'] = $soloSummonerInfo['championName'];
    $result[$nbG]['championIcon'] = ModelRiotApi::getChampionSquareAsset($matchVersion,$result[$nbG]['championName']);
    foreach ($summonerSpellData as $value) {
        if($value['key'] == $soloSummonerInfo['summoner1Id']){
            $result[$nbG]['summonerSpell1'] = ModelRiotApi::getSummonerSpellAsset($matchVersion,$value['image']['full']);
        }
    }
    foreach ($summonerSpellData as $value) {
        if($value['key'] == $soloSummonerInfo['summoner2Id']){
            $result[$nbG]['summonerSpell2'] = ModelRiotApi::getSummonerSpellAsset($matchVersion,$value['image']['full']);
        }
    }
    $rune1 = $soloSummonerInfo['perks']['styles'][0]['selections'][0]['perk'];
    $branch = $soloSummonerInfo['perks']['styles'][0]['style'];
    for ($i=0; $i < count($runeData); $i++) {
        if($runeData[$i]['id'] == $branch){
            $subRuneData = $runeData[$i]['slots'];
            for ($h=0; $h < count($subRuneData) ; $h++) {
                $array = $subRuneData[$h]['runes'];
                for ($j=0; $j < count($array); $j++) {
                    if($array[$j]['id'] == $rune1){
                        $result[$nbG]['rune1Icon'] = ModelRiotApi::getRunesAsset($array[$j]['icon']);
                        break(3);
                    }
                }
            }
        }
    }
    $rune2 = $soloSummonerInfo['perks']['styles'][1]['style'];
    for ($i=0; $i < count($runeData); $i++) {
        if($runeData[$i]['id'] == $rune2){
            $result[$nbG]['rune2Icon'] = ModelRiotApi::getRunesAsset($runeData[$i]['icon']);
            break;
        }
    }
    if(array_key_exists('gameEndTimestamp',$matchData['info'])){
        $result[$nbG]['gameDuration'] = $matchData['info']['gameDuration'];
        $result[$nbG]['gameDurationMinAndSec'] = msInMinAndSec($matchData['info']['gameDuration']);
    }else{
        $result[$nbG]['gameDuration'] = $matchData['info']['gameDuration']/1000;
        $result[$nbG]['gameDurationMinAndSec'] = msInMinAndSec($matchData['info']['gameDuration']/1000);
    }
    foreach ($queueData as $value) {
        if($value['queueId'] == $matchData['info']['queueId']) {
            $result[$nbG]['matchType'] = $value['description'];
            break;
        }
    }
    $result[$nbG]['matchDate'] = getdate(($matchData['info']['gameCreation'])/1000);
    $result[$nbG]['kills'] = $soloSummonerInfo['kills'];
    $result[$nbG]['deaths'] = $soloSummonerInfo['deaths'];
    $result[$nbG]['assists'] = $soloSummonerInfo['assists'];
    $result[$nbG]['creepScore'] = $soloSummonerInfo['totalMinionsKilled'];
    $result[$nbG]['visionScore'] = $soloSummonerInfo['visionScore'];
    $result[$nbG]['result'] = $soloSummonerInfo['win'];
    for ($i=0; $i < 6; $i++) {
        if($soloSummonerInfo["item$i"] != "0"){
            $result[$nbG]['itemsIcon'][] = ModelRiotApi::getItemAsset($matchVersion,$soloSummonerInfo["item$i"]);
        }
    }
    $result[$nbG]['wardIcon'] = ModelRiotApi::getItemAsset($matchVersion,$soloSummonerInfo["item6"]);
    $result[$nbG]['goldEarned'] = $soloSummonerInfo['goldEarned'];
    $result[$nbG]['role'] = $soloSummonerInfo['teamPosition'];
}
if($matchAnalysedNumber > 0){
    $favoriteRole;
    $average = array(
        'averageVision' => 0,
        'averageKills' => 0,
        'averageDeaths' => 0,
        'averageGolds' => 0,
        'averageDuration' => 0,
        'favoriteRole' => "",
    );
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
    $counts = array_count_values($favoriteRole);
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
function msInMinAndSec($secondes){
    $minutes = floor($secondes / 60);
    $secondes = $secondes % 60;
    $minutes = $minutes % 60;
    $format = '%u Min %02u';
    $time = sprintf($format, $minutes, $secondes);
    return $time;
}
?>