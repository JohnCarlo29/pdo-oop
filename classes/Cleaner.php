<?php
	class Cleaner{

		public static function clean($data){
			$input = htmlspecialchars(htmlentities(strip_tags($data),ENT_QUOTES));
			return $input;
		}
	}
	
?>