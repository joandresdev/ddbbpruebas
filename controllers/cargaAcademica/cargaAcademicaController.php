<?php

class CargaAcademicaController extends Controller
{
    function __construct()
	{

		$this->auth = new AuthValidator();
		$this->validatorAuth($this->auth);	
		
		parent::__construct();
		$this->modeln    = "CargaAcademica"; 
		$this->path      = "cargaAcademica";
		$this->routeView = "cargaAcademica/cargaAcademica";
    }
    
    public function render(){
		$this->view->render($this->routeView);
    }
    



    //------------------PARTE DE LOS METODOS--------------------------------

    public function academicDataMethod()
	{
        //Se manda llamar el metodo para obtener datos get Bla bla bla
        echo 'Hola, soy el método Controller y fui llamado c:    ';

        if ($this->validatorAuth($this->auth)) {

            $this->render();	
            $getAcademicData = $this->model->getAcademicData($_SESSION['usuario']['matricula']);

            $getOnlyProffNames = $this->model->getOnlyProffNames($_SESSION['usuario']['matricula']); /* Para Nerino: Obtiene el array de los nombres de los profesores */
            $getOnlySubjectNames = $this->model->getOnlySubjectNames($_SESSION['usuario']['matricula']); /* Para Nerino: Obtiene el array del nombre de las materias */
            //$getProffSubjectNames = $this->model->getProffSubjectNames($_SESSION['usuario']['matricula']); /* Para Nerino: Obtiene un array con el nombre de los profesores y el de las materias por si lo necesitas, si no ps elimina esta linea... */

            var_dump($getOnlyProffNames);
            //$this->render(); //Se debería de poner el render hasta abajo por si ocurre un error al traer los datos
            }else{
                $this->localRedirect('login');
            }
  }
  
  

}


?>