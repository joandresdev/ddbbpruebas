<?php  
	/**
	 * 	Se reciben las peticiones del usuario
	 */

class App 
{
	private $homeController = "AuthController";
	private $rutaLogin      = 'controllers/auth/authController';
	private $rutahome       = '';
	
	private $routeRoutes    = 'routes/mapping'.'.php';

	function __construct()
	{
		$this->rutahome = $this->rutaLogin;

		$url = isset($_GET['url'])? $_GET['url'] : null;
		$url = rtrim($url,'/');
		$url = explode('/',$url);
	
		$type = $_SERVER['REQUEST_METHOD'];
		
		// Empty request
		if (empty($url[0])) {
			require $this->rutahome.'.php';

			
			$controller = new $this->homeController();
			$controller->loadModel(
				$controller->path,
				$controller->modeln
			);
			$controller->render();
			return false;
		}

		$slug = '';
		// concateno la url para el slug
		foreach ($url as $ur) 
			$slug .= $ur.'/';
		
		$slug = substr($slug, 0, -1);
		
		require $this->routeRoutes;
		$map = new Mapping();

		if ($map->mapController($slug,$type)) {
			require $map->path;

			$controller = new $map->controller();
			// echo $map->controller;
			$controller->loadModel(
				$controller->path,
				$controller->modeln
			);
			
			
			if (method_exists($map->controller,$map->method)) {
				// echo "tiene el metodo ". $map->method;
				$controller->{$map->method}($map->method);
			}else{
				// echo "No existe el metodo". $map->method;
				$error = new Errores();
				$error->E404("A2");//metodo

			}
			

		}else{
			$error = new Errores();
			$error->E404("A1");//controller
		}


	}





}
?>