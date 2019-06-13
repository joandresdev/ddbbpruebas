<?php  
/**
 * 
 */
class AlumnoModel extends Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = 'sinTablita:3';
	}

	public function getDbfUser($matricula){
		$con = $this->DB->DBFconnect('DALUMN');
		$aux = null;

		if ($con) {
			$numero_registros = dbase_numrecords($con);
			

          for ($i = 1; $i <= $numero_registros; $i++) {

              $fila = dbase_get_record_with_names($con, $i);
               
              if (strcmp($fila["ALUCTR"],$matricula) == 0) {
              		// $aux = $fila;
              		$aux = [
							'matricula' => $fila['ALUCTR'],
							'nombre'    => $fila['ALUAPP'].' '.$fila['ALUAPM'].' '.$fila['ALUNOM'],
							'cumple'    => $fila['ALUNAC'],
							'direccion' => $fila['ALUTCL'].' '.$fila['ALUTNU'].' '.$fila['ALUTCO'],
							'cp'        => $fila['ALUTCP'],
							'cel'       => $fila['ALUTTE1'],
							'tel'       => $fila['ALUTTE2'],
							'email'     => $fila['ALUTMAI'],
							'curp'      => $fila['ALUCUR'],
							'sex'       => (strcmp($fila['ALUSEX'],'1') == 0 ? 'Hombre': 'Mujer')
              		];
              		break;
              }
              
              
          }

          dbase_close($con);
          return $aux;
		}
		return null;

	}
	public function updatePasswordUser($matricula)
	{
		$con = $this->DB->DBFconnect('DALUMN');
		//$db = dbase_open('DALUMN', 2); //Ingresar la ruta de la BD


		/*if ($db) {
			$row = dbase_get_record_with_names($db, 1);
			unset($row['deleted']);

			$row['date'] = date('Ymd');

			dbase_replace_record($db, $row, 1); //ERROR :c
			dbase_close($db);
		}*/
		return "Aquí se ejecutaría el código de arriba y cambiaría la contraseña... Si sirviera :'v";
	}
}


?>