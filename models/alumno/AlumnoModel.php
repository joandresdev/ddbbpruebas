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

	//Retorna informacion del kardex, solo la importante
	public function kardex($matricula){

		$datos = $this->DB->DBFconnect("DKARDE");
		$info = array();
		$aux = 0;

		if($datos){

			$numero_registros = dbase_numrecords($datos);
			for($i = 1; $i <= $numero_registros; $i++){
				$fila = dbase_get_record($datos, $i);
				if(strcmp($fila[0], $matricula) == 0){
					for($j = 0; $j < 9; $j++){
						$info[$aux][$j] = $fila[$j];
					}
					$aux++;
				}
			}
			return $info;
		}
	}
	public function getCalif($matricula)
	{
				
				$datos= "";
				//Connexion a los dbf
				$con = $this->DB->DBFconnect('DLista');
				$aux =[];
				// Validaci[on simple
				if($con)
				{
					//El numero de registro  que contiene 
					$numero_registros = dbase_numrecords($con);
	
					for($i=1; $i<=$numero_registros;$i++) 	
					{
						//devuelve los registros
	
							$fila = dbase_get_record_with_names($con, $i);
								
							//Se realiza una validación para que la matrícula selecionada sea igual a la matricula que esta recibiendo
	
							if(strcmp($fila["Aluctr"],$matricula)== 0)
							{
								$aux =
								[
								
									
									'Materia'  			  =>$fila['Matcve'],
									'CalifPrimerParcial'   => $fila['Lispa1'],
									'CalifSegundoParcial'  =>$fila['Lispa2'],
									'CalifTercerParcial'   =>$fila['Lispa3'],
									'CalifCuartoParcial'   =>$fila['Lispa4'],
									'CalifQuintoParcial'   =>$fila['Lispa5']
	
	
	
	
	
								];
							break;
									
							}
					}
					return $aux;
					//cierro la conexion
					dbase_close($con);
				}
			return null;
	}








}


?>