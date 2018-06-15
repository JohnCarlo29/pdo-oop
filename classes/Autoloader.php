<?php 

class Autoloader{

	public static function classes($classname){
		$directory = 'classes'.DIRECTORY_SEPARATOR;
		$file      = $directory.str_replace('\\', '/', $classname).'.php';

		if(is_readable($file)){
			require_once $file;
		}		
	}
}



?>