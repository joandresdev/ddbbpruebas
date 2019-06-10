<?php  
/**
 * 
 */
class Errores extends Controller 
{
	
	function __construct()
	{
		
		parent::__construct();
	}

	public function E404($msj)
	{
		$this->view->mensaje = $msj;
		$this->view->render('errores/404');
	}

	public function E500($msj)
	{
		$this->view->mensaje = $msj;
		$this->view->render('errores/500');
	}

	

}
?>