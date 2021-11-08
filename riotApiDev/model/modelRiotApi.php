<?php
set_time_limit(0);
//supprimer pour afficher les erreurs
error_reporting(0);
//04/10/2021
//ajout du getter pour données des runes
//images des runes
//images des emblèmes de rang
//modification du getter getMatchbyPuuid,  supression de test et du syteme de gestion de l'url
//suppresion de la fonction jsonGetter()
//la fonction ne faisant qu'une seul ligne je l'ai mise dans chaque getter

//The AMERICAS routing value serves NA, BR, LAN, LAS, and OCE. The ASIA routing value serves KR and JP. The EUROPE routing value serves EUNE, EUW, TR, and RU.

//fonctionnement de matchV5/timeline :
//a chaque minute de la partie le jeu crée un nouveau "participantFrames" plus un au début et un a la fin donc un total de (durée de la partie en minute + 2),
//entre chaque participantFrames un tableau d'event est crée ou a chaque evenement (liste a definir) en jeu indique sont type, sont horodatage (en milliseconde) et les info le concernants
//les métadonnées sont au début et indique la liste des participants
//l'id correspondant au joueur sont a la fin.
class ModelRiotApi{
    private static $api_key = "RGAPI-7f853f0c-a6fd-40f8-a500-8c9222541a88";

    private static $ServerRegionEquivalence = array(
        'na1'  => 'americas',
        'br1'  => 'americas',
        'la1'  => 'americas',
        'la2'  => 'americas',
        'oc1'  => 'americas',
        'kr'   => 'asia',
        'jp1'  => 'asia',
        'eun1' => 'europe',
        'euw1' => 'europe',
        'tr1'  => 'europe',
        'ru'   => 'europe',
    );

    //PARTIE 'CONF' EN MODÈLE MVC

    //RIOT API
    //FAIT DES REQUÊTES VERS L'API RIOT

    /*
    CORRECT VALUE FOR FUNCTION PARAMETERS :
    $server = {br1,eun1,euw1,jp1,kr,la1,la2,na1,oc1,ru,tr1}
    $region = {americas,asia,europe}
    $queue = {RANKED_SOLO_5x5,RANKED_FLEX_SR,RANKED_FLEX_TT}
    $division = {I,II,III,IV}
    $tier = {DIAMOND,PLATINUM,GOLD,SILVER,BRONZE,IRON}
    //for matchv5/bypuid
    $type = {ranked,normal,tourney,tutorial}
    */
    private static function doHttpRequest($url){
        $content = file_get_contents($url);
        if(!$content){
            return 404;
        }else{
            $response_code = substr($http_response_header[0],9,-3);
            if($response_code != '200'){
                return intval(get_headers($url)[0],9,3);
            }else{
                return $content;
            }
        }
    }
    //CHAMPION-V3
    //lol/platform/v3/champions-rotations
    //obtenir la rotation des champions actuel
    //retourne un array
    public static function getChampRotationbyServer($server){
        $url = "https://" . $server . ".api.riotgames.com/lol/platform/v3/champion-rotations?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }

    }
    //SUMMONER-V4
    //obtenir les informations d'un invocateur
    //lol/summoner/v4/summoners/by-account
    //retourne un array
    public static function getSummonnerInfoByAccountId($accountID, $server){
        $url = "https://" . $server . ".api.riotgames.com/lol/summoner/v4/summoners/by-account/" . $accountID . "?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //lol/summoner/v4/summoners
    //retourne un array
    public static function getSummonnerInfoBySummonerId($summonerID, $server){
        $url = "https://" . $server . ".api.riotgames.com/lol/summoner/v4/summoners/" . $summonerID . "?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //lol/summoner/v4/summoners/by-name
    //retourne un array
    public static function getSummonerInfoBySummonerName($summonerName,$server){
        $url = "https://" . $server . ".api.riotgames.com/lol/summoner/v4/summoners/by-name/" . $summonerName .  "?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //lol/summoner/v4/summoners/by-puuid
    //retourne un array
    public static function getSummonerInfoByPuuid($summonerPuuid, $server){
        $url = "https://" . $server . ".api.riotgames.com/lol/summoner/v4/summoners/by-puuid/" . $summonerPuuid . "?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }

    //CHAMPION-MASTERY-V4
    //lol/champion-mastery/v4/champion-masteries/by-summoner
    //obtenir les informations des maitrise de champions d'un invocateur
    //retourne un array
    public static function getChampionMasteryBySummonerId($summonerID, $server){
        $url = "https://" . $server . ".api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/" . $summonerID . "?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //lol/champion-mastery/v4/champion-masteries/by-summoner/by-champion
    //obtenir les informations des maitrise de champions d'un invocateur suivant l'ID du champion
    //retourne un array
    public static function getChampionMasteryBySummonerIdAndChampionId($summonerID, $championId, $server){
        $url = "https://" . $server . ".api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/" . $summonerID . "/by-champion/" . $championId . "?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //lol/champion-mastery/v4/scores/by-summoner
    //obtenir le nombre total de point de maitrise d'un invocateur
    //retourne un int
    public static function getChampionMasteryScoreBySummonerId($summonerID, $server){
        $url = "https://" . $server . ".api.riotgames.com/lol/champion-mastery/v4/scores/by-summoner/" . $summonerID . "?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }

    //SPECTATOR-V4
    //lol/spectator/v4/active-games/by-summoner
    //obtenir les informations de la partie en cours d'un invocateur
    //retourne 404 si le joueur n'est pas en jeu
    //retourne un array
    public static function getDirectMatchDataBySummonerId($summonerID, $server){
        $url = "https://" . $server . ".api.riotgames.com/lol/spectator/v4/active-games/by-summoner/" . $summonerID . "?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //lol/spectator/v4/featured-games
    //retourne la liste des partie "en vedette" par serveur
    //retourne un array
    public static function getFeaturedGamesByServer($server){
        $url = "https://" . $server . ".api.riotgames.com/lol/spectator/v4/featured-games?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }

    }

    //THIRD-PARTY-CODE-V4
    //lol/platform/v4/third-party-code/by-summoner
    //retourne 404 si celui n'existe pas
    //retourne un array
    public static function getThirdPartyCodebySummonerId($summonerID,$server){
        $url = "https://" . $server . ".api.riotgames.com/lol/platform/v4/third-party-code/by-summoner/" . $summonerID . "?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }

    //LEAGUE-V4
    //lol/league/v4/challengerleagues/by-queue
    //obtenir la liste des challengers et les informations de classement de chaque joueur
    //retourne un array
    public static function getChallengersListByQueueAndServer($queue, $server){
        $url = "https://" . $server . ".api.riotgames.com/lol/league/v4/challengerleagues/by-queue/" . $queue . "?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //lol/league/v4/leagues/
    //obtenir la liste des joueur suivant l'ID de la ligue
    //retourne un array
    public static function getSummonerListByLeagueIdAndServer($leagueID, $server){
        $url = "https://" . $server . ".api.riotgames.com/lol/league/v4/leagues/" . $leagueID . "?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //lol/league/v4/masterleagues/by-queue/
    //obtenir la liste des challengers et les informations de classement de chaque joueur
    //retourne un array
    public static function getMasterListByQueueAndServer($queue, $server){
        $url = "https://" . $server . ".api.riotgames.com/lol/league/v4/masterleagues/by-queue/" . $queue . "?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //lol/league/v4/grandmasterleagues/by-queue
    //obtenir la liste des grandmaster et les informations de classement de chaque joueur
    //retourne un array
    public static function getGrandmasterListByQueueAndServer($queue, $server){
        $url = "https://" . $server . ".api.riotgames.com/lol/league/v4/grandmasterleagues/by-queue/" . $queue . "?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //lol/league/v4/entries/by-summoner
    //obtenir les informations de classement a propos d'un joueur
    //retourne un array
    public static function getLeagueDatabySummonerId($summonerID, $server){
        $url = "https://" . $server . ".api.riotgames.com/lol/league/v4/entries/by-summoner/" . $summonerID . "?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //lol/league/v4/entries/
    //obtenir la liste des joueur suivant la file,le rang et la division
    //retourne un array
    public static function getSummonersInfoByQueueTierAndDivision($queue,$tier,$division,$server,$page=1){
        $url = "https://" . $server . ".api.riotgames.com/lol/league/v4/entries/" . $queue . "/" . $tier . "/" . $division . "?page=" . $page . "&api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //MATCH-V5
    //lol/match/v5/matches/
    //obtenir les données de fin de match
    //retourne un array
    public static function getMatchData($matchID,$region){
        $url = "https://" . $region . ".api.riotgames.com/lol/match/v5/matches/" . $matchID . "?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //lol/match/v5/matches/by-puuid/
    //obtenir la liste des matchs d'un invocateur
    //retourne un array
    //pour le queue : https://static.developer.riotgames.com/docs/lol/queues.json

    //start default = 0
    //count limit = 100 default = 20
    //for queue info go to getQueuesData()
    //valid value for type = {ranked,normal,tourney,tutorial}
    public static function getMatchByPuuid($summonerPuuid,$region,$startTime=null,$endTime=null,$queue=null,$type=null,$start=null,$count=null){
        $url = "https://europe.api.riotgames.com/lol/match/v5/matches/by-puuid/" . $summonerPuuid . "/ids?startTime=" . $startTime . "&endTime=" . $endTime . "&queue=" . $queue . "&type=" . $type . "&start=" . $start . "&count=" . $count . "&api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //lol/match/v5/matches/timeline
    //obtenir les données a propos des envenement au cours d'une partie
    //retourne un array
    public static function getMatchTimeline($matchID,$region){
        $url = "https://" . $region . ".api.riotgames.com/lol/match/v5/matches/" . $matchID . "/timeline?api_key=" . ModelRiotApi::$api_key;
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //DDRAGON-API
    //REQUETES VERS DDRAGON
    //POUR LES OBJET, RUNES...

    //https://developer.riotgames.com/docs/lol#general_game-constants
    public static function getSeasonsData(){
        $url = "https://static.developer.riotgames.com/docs/lol/seasons.json";
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    public static function getQueuesData(){
        $url = "https://static.developer.riotgames.com/docs/lol/queues.json";
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    public static function getMapsData(){
        $url = "https://static.developer.riotgames.com/docs/lol/maps.json";
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    public static function getGameModesData(){
        $url = "https://static.developer.riotgames.com/docs/lol/gameModes.json";
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    public static function getGameTypesData(){
        $url = "https://static.developer.riotgames.com/docs/lol/gameTypes.json";
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //https://developer.riotgames.com/docs/lol#data-dragon_versions
    public static function getVersionData(){
        $url = "https://ddragon.leagueoflegends.com/api/versions.json";
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //https://developer.riotgames.com/docs/lol#data-dragon_regions
    public static function getRegionData($server){
        $url = "https://ddragon.leagueoflegends.com/realms/". $server . ".json";
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //https://developer.riotgames.com/docs/lol#data-dragon_data-assets
    public static function getLanguagesData(){
        $url = "https://ddragon.leagueoflegends.com/cdn/languages.json";
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //https://developer.riotgames.com/docs/lol#data-dragon_champions
    //for champions with space or apostrophe just delete it (ex: Xin Zhao => XinZhao)
    //when need champion Name add uppercase on first letter (ex: jhin => Jhin);
    public static function getAllChampionsData($version, $language){
        $url = "https://ddragon.leagueoflegends.com/cdn/" . $version . "/data/" . $language . "/champion.json";
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    public static function getChampionData($version, $language, $championName){
        $url = "https://ddragon.leagueoflegends.com/cdn/" . $version . "/data/" . $language . "/champion/" . $championName . ".json";
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //return image
    public static function getChampionSplashAsset($championName,$skinNum){
        $url = "https://ddragon.leagueoflegends.com/cdn/img/champion/splash/" . $championName . "_" . $skinNum . ".jpg";
        return $url;
    }
    //return image
    public static function getChampionLoadingScreenAsset($championName, $skinNum){
        $url = "https://ddragon.leagueoflegends.com/cdn/img/champion/loading/" . $championName . "_" . $skinNum . ".jpg";
        return $url;
    }
    //return image
    public static function getChampionSquareAsset($version,$championName){
        if($championName === "FiddleSticks"){
            $championName = "Fiddlesticks";
        }
        $url = "https://ddragon.leagueoflegends.com/cdn/" . $version . "/img/champion/" . $championName . ".png";
        return $url;
    }
    //return image
    public static function getPassiveAsset($version,$imageName){
        $url = "https://ddragon.leagueoflegends.com/cdn/11.19.1/img/passive/" . $imageName;
        return $url;
    }
    public static function getAbilityAsset($version,$imageName){
        $url = "http://ddragon.leagueoflegends.com/cdn/" . $version . "/img/spell/" . $imageName;
        return $url;
    }
    //return image
    //https://developer.riotgames.com/docs/lol#data-dragon_items
    public static function getItemsData($version,$language){
        $url = "https://ddragon.leagueoflegends.com/cdn/" . $version . "/data/" . $language . "/item.json";
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //return image
    public static function getItemAsset($version,$itemID){
        $url = "http://ddragon.leagueoflegends.com/cdn/" . $version . "/img/item/" . $itemID . ".png";
        return $url;
    }
    //https://developer.riotgames.com/docs/lol#data-dragon_other
    public static function getSummonerSpellsData($version,$language){
        $url = "http://ddragon.leagueoflegends.com/cdn/" . $version . "/data/" . $language . "/summoner.json";
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //return image
    public static function getSummonerSpellAsset($version,$imageName){
        $url = "https://ddragon.leagueoflegends.com/cdn/" . $version . "/img/spell/" . $imageName;
        return $url;
    }
    //return array
    public static function getProfileIconData($version,$imageName){
        $url = "https://ddragon.leagueoflegends.com/cdn/" . $version . "/data/" . $language . "/profileicon.json";
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //return image
    public static function getProfileIconAsset($version,$iconID){
        $url = "https://ddragon.leagueoflegends.com/cdn/" . $version . "/img/profileicon/" . $iconID . ".png";
        return $url;
    }
    //return array
    public static function getRunesData($version,$language){
        $url = "https://ddragon.leagueoflegends.com/cdn/" . $version . "/data/" . $language  . "/runesReforged.json";
        $content = ModelRiotApi::doHttpRequest($url);
        if(gettype($content) == "integer"){
            throw new Exception(__FUNCTION__,$content);
        }else{
            return json_decode($content,true);
        }
    }
    //return image
    public static function getRunesAsset($iconPath){
        $url = "https://ddragon.leagueoflegends.com/cdn/img/" . $iconPath;
        return $url;
    }
    //return image
    public static function getMiniMapAsset($version,$miniMapID){
        $url = "https://ddragon.leagueoflegends.com/cdn/" . $version . "/img/map/map" . $miniMapID . ".png";
        return $url;
    }
    //return image
    public static function getSprite($version,$spriteName){
        $url = "https://ddragon.leagueoflegends.com/cdn/" . $version . "/img/sprite/" . $spriteName;
        return $url;
    }
    //IMPORTANT !!!
    //$tier in lowercase and $rank in arab number  (GOLD IV => gold  4)
    public static function getRankedEmblems($tier,$rank){
        if($rank=="I"){
            $rank="1";
        }if($rank=="II"){
            $rank="2";
        }if($rank=="III"){
            $rank="3";
        }if($rank=="IV"){
            $rank="4";
        };
        $url = "https://ddragon.bangingheads.net/other/emblems/" . strtolower($tier) . "_" . $rank . ".png";
        return $url;
    }

    //OTHER GETTER
    public static function getRegionByServer($server){
        if(array_key_exists($server,ModelRiotApi::$ServerRegionEquivalence)){
            return ModelRiotApi::$ServerRegionEquivalence[$server];
        }else{
            throw new Exception("ServerNotExist");
        }

    }
    //pas terminé, il faudra ajouter la liste dans le "array"
    public static function getServerList(){
        $server_list = array();
        foreach (modelRiotApi::$ServerRegionEquivalence as $key => $value) {
            $server_list[] = $key;
        }
        return $server_list;
    }
}
?>