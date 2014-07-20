<?php
abstract class BootHelper {
	static function configure() {
		include("./configuration/main.php");
		if(DEVELOPMENT) {
			if(file_exists("./configuration/development")) {
				foreach(glob("./configuration/development/*.php") as $filename) require($filename);
			}
		}
	}

	static function include_helpers() {
		if(file_exists("./helpers"))
			foreach (glob("./helpers/*.php") as $filename) require($filename);
	}

	static function page_constructor2() {
		$url = explode("/", $_SERVER['REQUEST_URI']);
		if(!$url[1])
			$url[1] = "home";
		if(file_exists("./modules/".$url[1])) {
			if(!isset($url[2]) || $url[2] == NULL)
				$url[2] = "index";
			if(file_exists("./modules/".$url[1]."/controller")) 
				include("./modules/".$url[1]."/controller/".$url[2].".php");
			if(file_exists("./modules/".$url[1]."/view"))
				include("./modules/".$url[1]."/view/".$url[2].".php");
		} else
			include("./error404.html");
	}	

	static function page_constructor() {
		try {
			$url = explode("/", $_SERVER['REQUEST_URI']);
			if(!$url[1])
				$url[1] = "home";
			if(file_exists("./modules/".$url[1])) {
				if(!isset($url[2]) || $url[2] == NULL)
					$url[2] = "index";
				if(!file_exists("./modules/".$url[1]."/controller/".$url[2].".php") && !file_exists("./modules/".$url[1]."/view/".$url[2].".php"))
					throw new Exception("No controller nor view found with this name.");
				if(file_exists("./modules/".$url[1]."/controller/".$url[2].".php"))
					include("./modules/".$url[1]."/controller/".$url[2].".php");
				if(file_exists("./modules/".$url[1]."/view/".$url[2].".php"))
					include("./modules/".$url[1]."/view/".$url[2].".php");
			} else {
				if(!file_exists("./error404.html"))
					throw new Exception('No error404 page found!');
				include("./error404.html");
			}
		}
		catch(Exception $e) {
			ErrorHelper::log_error($e);
			header("Location: /");
		}
	}

	static function class_loader() {
		function __autoload($classname) {
			$filename = "./classes/". strtolower($classname) .".class.php";
			require($filename);
		}
	}

	static function include_script() {
		try {
			if(!file_exists("./script"))
				throw new Exception("No script folder found!");
			$output = NULL;
			if(JQUERY)
				$output .= '<script src="'.JQUERY_LOC.'"></script>';
			foreach(glob("./script/*.js") as $script)
				$output .= '<script src=".'.$script.'"></script>';
			return $output;
		} 
		catch(Exception $e) {
			ErrorHelper::log_error($e);
		}
	}

	static function include_style() {
		try {
			if(!file_exists("./style"))
				throw new Exception("No style folder found!");
			$output = NULL;
			foreach(glob("./style/*.css") as $style)
				$output .= '<link rel="stylesheet" type="text/css" href=".'.$style.'">';
			return $output;
		}
		catch(Exception $e) {
			ErrorHelper::log_error($e);
		}
	}

	static function load_ajax() {
		$url = explode("/", $_SERVER['REQUEST_URI']);
		if($url[1] != "ajax")
			return false;
		try {
			if(!file_exists(".".explode("?", $_SERVER['REQUEST_URI'])[0]))
				throw new Exception("Given ajax controller not found!");
			include(".".explode("?", $_SERVER['REQUEST_URI'])[0]);
		} 
		catch(Exception $e) {
			ErrorHelper::log_error($e);
		}
		finally {
			return true;
		}
	}

	static function load_script() {
		$url = explode("/", $_SERVER['REQUEST_URI']);
		if($url[1] != "script")
			return false;
		try {
			if(!file_exists("./script/".$url[2]))
				throw new Exception("Given script not found!");
			include("./script/".$url[2]);
		}
		catch(Exception $e) {
			ErrorHelper::log_error($e);
		}
		finally {
			return true;
		}
	}

	static function load_style() {
		$url = explode("/", $_SERVER['REQUEST_URI']);
		if($url[1] != "style")
			return false;
		try {
			if(!file_exists("./style/".$url[2]))
				throw new Exception("Given stylesheet not found!");
			include("./style/".$url[2]);
		}
		catch(Exception $e) {
			ErrorHelper::log_error($e);
		}
		finally {
			return true;
		}
	}

}
?>