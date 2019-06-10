<?php  
/**
 * 
 */
class Mapping 
{

	public $path       = "SINPATH";
	public $controller = "SINCONTROLLER";
	public $method     = "SINMETHOD";

	private $routes = [];


	function __construct()
	{
		// echo "<br>MapMapeando";
		require 'routes/routes.php';
	}

	public function mapController($slug,$type){
		foreach ($this->routes as $route) {
			if (strcmp($route['slug'],$slug) == 0 && strcmp($route['type'],$type) == 0) {
				// echo "<br> -> ".$slug.'<br>';
				$this->path = 'controllers/'.$route['path'].'.php';
				// if (strcmp($route['type'] ,'POST') == 0) {
				// 	echo "<br>es post <br>";
				// }
				if (file_exists($this->path)) {
					$this->controller = $this->getController($this->path);
					$this->method     = $route['method'];
					return true;
				}
			}
		}
		return false;
	}

	// public function mapMethod(){
	// 	foreach ($this->routes as $route) {
	// 		if (strcmp($route['method'],$this->method) == 0 && strcmp ($route['name'],$name ) == 0) {
	// 			$this->method = $method;
	// 			return true;
	// 		}
	// 	}
	// 	return false;
	// }
	public function newRoute($slug,$path,$method,$type = 'GET'){
		array_push($this->routes,[
			'slug'   =>$slug,
			'path'   =>$path,
			'method' =>$method,
			'type'	 =>$type
		]);
	}

	public function getController($path){
		$controller = explode('/',$path);
		$controller = explode('.',$controller[sizeof($controller)-1]);
		$controller = $controller[0];
		return ucwords($controller);
	}


}
?>