<?php  

/**
 * 
 */
class Model 
{
	public $table = "SIN_DATABASE";
	function __construct()
	{
		$this->DB = new Database();
	}
	
}
?>