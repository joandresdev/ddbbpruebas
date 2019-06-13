<?php

class CargaAcademicaModel extends Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = '';
    }
    



    //--------------------PARTE MODELOS PARA TRAER DATOS DE LA BD o DBF----------------------------
    public function getAcademicData()
	{
        //Método para obtener datoo c:	
        
        return 'Hola soy los datos que obtuve de la BD o DBF y fui obtenido en el Model con getAcademicData c:';
	}

}

?>