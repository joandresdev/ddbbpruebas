<?php  
/**
 * 
 */
class AuthValidator extends Controller
{
	
	function __construct(){
		
	}


	public function makeAuth(){

		if (isset($_SESSION["usuario"])) {
			return true;
		}

		return false;



	}
}
?>