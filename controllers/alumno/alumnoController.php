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
	
	public function getKardex(){
		echo "Estas buscando informacion del kardex <br>";
		$dbfData = $this->model->kardex(201600111);
		die(var_dump($dbfData));
	}

	public function getcalif()
	{
		echo "Estoy buscando las  califiaciones prro <br><br>";
		//$dbf= $this ->model->getcalif(201600088,$this->model->getPeriodo($aux));
		
	$dbf= $this ->model->getcalif(201600088,3192);
		die(var_dump($dbf));
	}
	public function getPeriodo()
	{
		echo "Te daré  el período actual <br><br>";
		$dbf= $this ->model->getPeriodo(201600088);
		die(var_dump($dbf));

	}
	

}
?>