<?php
class Util{
	
	private static $objectData = null;
	private static $summonerSpellData = null;
	private static $runeData = null;
	//filter is a array with keey u want in returned array
	//key in filter need to be in $array
	public static function arrayFilter($array, $filter){
		$return = array();
		foreach ($filter as $key) {
			$return[$key] = $array[$key];
		}
		return $return;
	}
	public static function deleteInArray($array,$targets){
		foreach ($targets as $value) {
			unset($array[$value]);
		}
		return $array;
	}
	public static function changeColumnName($array,$oldName,$newName){
		if(array_key_exists($oldName, $array)) {
			$keys = array_keys($array);
			$keys[array_search($oldName, $keys)] = $newName;
			return array_combine($keys, $array);	
		}
		return $array;   
	}
	/*list example : $list = array(
								'kills' => 'Éliminations',
								'killingSpree' => 'Série d\'éliminations'
									);*/
	public static function multiChangeColumnName($array,$list){
		foreach ($list as $oldName => $newName) {
			$array = Util::changeColumnName($array,$oldName,$newName);
		}
		return $array;
	}
	public static function convertBoolean($array){
		foreach($array as $key => $value){
			if(gettype($array[$key]) ==="boolean"){
				if($value){
					$array[$key] = "1";
				}else{
					$array[$key] = "0";
				}
			}
		}
		return $array;
	}
	public static function getObjectName($objectId){
		if(Util::$objectData == null){
			Util::$objectData = ModelRiotApi::getItemsData(ModelRiotApi::getVersionData()[0],"fr_FR");
		}
		foreach (Util::$objectData['data'] as $key => $itemData) {
			if($key == $objectId){
				return $itemData['name'];
			}
		}
	}
	public static function getSummonerSpellName($summonerSpellId){
		if(Util::$summonerSpellData == null){
			Util::$summonerSpellData = ModelRiotApi::getSummonerSpellsData(ModelRiotApi::getVersionData()[0],"fr_FR");
		}
		foreach (Util::$summonerSpellData['data'] as $value) {
			if($value['key'] == $summonerSpellId){
			return $value['name'];
			}
		}
	}
}

?>