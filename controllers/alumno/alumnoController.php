<?php  
/**
 * 	Controlador que gestiona acciones de los alumnos
 */


#
class AlumnoController extends Controller
{

	
	function __construct()
	{

		$this->auth = new AuthValidator();
		$this->validatorAuth($this->auth);
		// if (!$auth->makeAuth()) 
			// $this->localRedirect('login');		
		
		parent::__construct();
		$this->modeln    = "Alumno"; 
		$this->path      = "alumno";
		$this->routeView = "alumnos/datosGenerales";
	}

	public function render(){
		$this->view->render($this->routeView);
	}

	public function datosGenerales()
	{
		if ($this->validatorAuth($this->auth)) {
			
		$datos = $this->model->getDbfUser($_SESSION['usuario']['matricula']);
			var_dump($datos);
			$this->view->datos = $datos;
			$this->render();
		}else{
			$this->localRedirect('login');
		}
		
	}


	

}
?>