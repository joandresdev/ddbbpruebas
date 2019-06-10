<?php  
/**
 * 
 */
class View 
{
	
	function __construct()
	{
		
	}

	public function render($ruta){
		require 'views/'.$ruta.'.php';
	}

}
?>