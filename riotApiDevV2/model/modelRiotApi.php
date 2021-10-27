<?php
class ModelRiotApi{
	private static $api_key = "RGAPI-7f853f0c-a6fd-40f8-a500-8c9222541a88";
	private static $serverRegionEquivalence = array(
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
	private static $urlList = array(
		'riotApi'=> array(
			//need : region, puuid
			//optionnal : startTime: UnixTimestamp, endTime: UnixTimestamp, queue: queueId, type: type of match, start: number, count: number (max 100,default to 20);
			'matchList' => "https://%s.api.riotgames.com/lol/match/v5/matches/by-puuid/%s/ids?startTime=%s&endTime=%s&queue=%s&type=%s&start=%s&count=%s&api_key=",
			//need : region, matchId
			'matchData' => "https://%s.api.riotgames.com/lol/match/v5/matches/%s?api_key=",
			//need : region, matchId
			'matchTimeline' => "https://%s.api.riotgames.com/lol/match/v5/matches/%s/timeline?api_key=",
			//need : server, summonerName
			'summonerInfoByName' => "https://%s.api.riotgames.com/lol/summoner/v4/summoners/by-name/%s?api_key=",
			//need : server, summonerPuuid
			'summonerInfoByPuuid'  => "https://%s.api.riotgames.com/lol/summoner/v4/summoners/by-puuid/%s?api_key=",
			//need : server, summonerId
			'leagueDataBySummonerId' => "https://%s.api.riotgames.com/lol/league/v4/entries/by-summoner/%s?api_key=",
		),
		'ddragon' => array(
			//nothing needed
			'versionData' => "https://ddragon.leagueoflegends.com/api/versions.json",
			//need : version, language
			'summonerSpellsDatas' => "http://ddragon.leagueoflegends.com/cdn/%s/data/%s/summoner.json",
			//need : version, language
			'runesDatas' => "https://ddragon.leagueoflegends.com/cdn/%s/data/%s/runesReforged.json",
			//nothing needed
			'queuesData' => "https://static.developer.riotgames.com/docs/lol/queues.json",
			//need : version, iconID
			'profileIconAsset' => "https://ddragon.leagueoflegends.com/cdn/%s/img/profileicon/%s.png",
			//need : version, championName
			'championSquareAsset' => "https://ddragon.leagueoflegends.com/cdn/%s/img/champion/%s.png",
			//need : version, path of image
			'summonerSpellsAssets' => "https://ddragon.leagueoflegends.com/cdn/%s/img/spell/%s",
			//need : runeId
			'runesAssets' => "https://ddragon.leagueoflegends.com/cdn/img/%s",
			//need : version, imageId
			'itemsAssets' => "http://ddragon.leagueoflegends.com/cdn/%s/img/item/%s.png",
			//need : rank, division
			'rankedEmblems' => "https://ddragon.bangingheads.net/other/emblems/%s_%s.png",
		),

	);

	private static function httpGetter($url){
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
	private static function urlConstructor($service,$userDemand,$neededOption=null){
		$url = ModelRiotApi::$urlList[$service][$userDemand];
		$url = vsprintf($url,$neededOption);
		return $url;
	}
	public static function dataGetter($service,$userDemand,$neededOption=null){
		$url = ModelRiotApi::urlConstructor($service,$userDemand,$neededOption);
		if($service == 'riotApi'){
			$url = $url.ModelRiotApi::$api_key;
		}
		$content = ModelRiotApi::httpGetter($url);
		if(gettype($content) == "integer"){
			throw new Exception($userDemand, $content);
		}else{
			return json_decode($content,	true);
		}
	}
	public static function imageGetter($service,$userDemand,$neededOption=null,$getImageOnCache=false,$verifyImage=false){
		$url = ModelRiotApi::urlConstructor($service,$userDemand,$neededOption);
		if($getImageOnCache){
			$image = ModelRiotApi::httpGetter($url);
			if(gettype($image) == "integer"){
				throw new Exception($userDemand, $image);
			}else{
				return base64_encode($image);
			}
		}else{
			if($verifyImage){
				$httpCode = substr(get_headers($url)[0],9,3);
				if($httpCode != 200){
					throw new Exception($userDemand,intval($httpCode));
				}
			}
			return $url;
		}
	}
	public static function santaClaus($wishlist,$shop){
		$cart = array();
		foreach ($wishlist as $item) {
			$cart[$item] = $shop[$item];
		}
	}
	public static function refoundItem($slayerList,$potentialVictim){
		foreach ($slayerList as $victim) {
			unset($potentialVictim[$victim]);
		}
		return $potentialVictim;
	}
	public static function getRegionByServer($server){
        if(array_key_exists($server,ModelRiotApi::$serverRegionEquivalence)){
            return ModelRiotApi::$serverRegionEquivalence[$server];
        }else{
            throw new Exception('regionByServer',404);
        }

    }
}
?>