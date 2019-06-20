<?php  
/**
 * 	Controlador que gestiona acciones de los alumnos
 */
#
class HorarioController extends Controller
{
	function __construct()
	{

		$this->auth = new AuthValidator();
		$this->validatorAuth($this->auth);
		


		// if (!$auth->makeAuth()) 
			// $this->localRedirect('login');		
		
		parent::__construct();
		$this->modeln    = "Horario"; 
		$this->path      = "horario";
		$this->routeView = "horario/horario";
	}

	public function render(){
		$this->view->render($this->routeView);

	}

	public function horario(){
		if ($this->validatorAuth($this->auth)) {
			
		$datos = $this->model->getDbfUser($_SESSION['usuario']['matricula']);
		$dbfData = $this->model->getGrupo($_SESSION['usuario']['matricula']);
        //$periodo = $this->model->getPeriodo(2);
			//var_dump($datos);
			$this->view->dbfData = $dbfData;
			$this->view->datos = $datos;
			$this->render();
		}else{
			$this->localRedirect('login');
		}
		

	}

	/*public function buscar(){
		echo "Estas buscando los datos de un alumno";
		$dbfData = $this->model->getGrupo($_SESSION['usuario']['matricula']);

		die(var_dump($dbfData));
	}*/
	public function buscarGrupoActual(){
		$dbfData = $this->model->getGrupoActual('matricula');
		die(var_dump($dbfData));
	}

	public function buscarclave(){

        echo "Estas buscando la clave del alumno";
        $data = $this->model->getClave($_SESSION['usuario']['matricula']);
        echo $data;
        $neros = $data;
        die(var_dump($data));
    }
    public function buscarHorario(){

        echo "Estas buscando los datos de un alumno";
        $dbfData = $this->model->getHorarios(3192,2,'B','09A ');


        die(var_dump($dbfData));
    }

    public function periodo($data){
        echo"Estas buscando los periodos";
        echo ( int )$data;
        $dbfData = $this->model->getPeriodo(3192);
        die(var_dump($dbfData));
    }
     public function Carrera(){
        echo"Estas buscando los horarios";
        $dbfData = $this->model->getCarrera(2);
        die(var_dump($dbfData));
    }
    public function Matter(){
        echo"Estas buscando las materias";
        $dbfData = $this->model->getmatter(3192, 201600057);
        die(var_dump($dbfData));
    }
    public function MaterNombre(){
        echo"Estas buscando las materias";
        $dbfData = $this->model->getMaterNombre('');
        die(var_dump($dbfData));
    }

}
?>