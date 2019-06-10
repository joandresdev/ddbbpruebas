<?php  
/**
 * 
 */
class AuthModel extends Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = 'sinTablita:3';
	}

	public function getUser($matricula){

		try{
			
			$query = $this->DB->MYSQLconnect()->prepare("call getUser(:matri);");
			$data = [
				':matri' => $matricula
			];
			$query->execute($data);
				
			return $query->fetch();

		}catch(PDOException $e){
			echo "<br> error ".$e." <br>";
			return null;
		}
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

	public function addUser($alumn){
		
		$items = [];
		try{


			// CALL addAlumno(201600114,'secret','email@gmail.com',-1);
			// $sql = "CALL addAlumno(".
			// 	$alumn['matricula'].",
			// 	'secret','".	
			// 	$alumn['email']."',
			// 	-1
			// );";

			$sql = "CALL addAlumno(:matricula,:pass,:email,:index);";
			$query = $this->DB->MYSQLconnect()->prepare($sql);
			
			$data = [
				':matricula' => $alumn['matricula'],
				':pass'      => 'secret',
				':email'     => $alumn['matricula'].'@upqroo.alumnos.com',
				':index'     => -1,
			];
			
			$query->execute($data);
			
			// $this->DB = null;
			return true;

		}catch(PDOException $e){
			echo "<br> error ".$e." <br>";
			return false;
		}

	}


}
?>