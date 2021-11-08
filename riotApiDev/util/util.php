<?php
	class Util{

		public static function deleteInArray($array,$targets){
			foreach ($target as $value) {
				unset($array[$target]);
			}
			return $array;
		}
	}

?>