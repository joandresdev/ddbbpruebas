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
            var_dump($getAcademicData);   
            //$this->render(); //Se debería de poner el render hasta abajo por si ocurre un error al traer los datos
            }else{
                $this->localRedirect('login');
            }
  }
  
  

}


?>