<?php
	class Util{

		public static function deleteInArray($array,$targets){
            foreach ($targets as $value ) {
				unset($array[$value]);
			}
			return $array;
		}
	}

?>