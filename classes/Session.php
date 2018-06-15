<?php
	class Session{
		private static $isStart = false;

		public static function start(){
			if (self::$isStart == false){
				session_start();
				self::$isStart = true;
			}
		}

		public static function getSession($key, $subkey = false){
			if($subkey == true){
				if (isset ($_SESSION[$key][$subkey])){
					return $_SESSION[$key][$subkey];
				}
			}else{
				if (isset ($_SESSION[$key])){
					return $_SESSION[$key];
				}
			}

			return false;
		}

		public static function setSession($key,$value){
			$_SESSION[$key] = $value;
		}

		public static function setSession_md($key,$subkey,$value){
			$_SESSION[$key][$subkey] = $value;
		}
		
		public static function display(){
			echo "<pre>";
			print_r($_SESSION);
			echo "</pre>";					
		}

		public static function destroy(){
			if (self::$isStart == true){
				session_unset();
				session_destroy();
			}
		}

		public static function unset_session($key, $subkey=false){
			if($subkey == true){
				unset($_SESSION[$key][$subkey]);
			}else{
				if (isset($_SESSION[$key])){
					unset($_SESSION[$key]);
				}
			}

			return;
		}
	}
?>