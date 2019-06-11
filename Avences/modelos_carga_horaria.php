<?
//------------------------------------------------------------------------
//buscar el grupo del alumno
//------------------------------------------------------------------------
public function buscar(){

		echo "Estas buscando los datos de un alumno";
		$dbfData = $this->model->getGrupo(201600057);


		die(var_dump($dbfData));
	}

public function getGrupo($matricula){
$datos= $this->getDbf("DCALUM");
		if(count($datos)>0 && is_array($datos)){
		  foreach ($datos as $key=>$value) {
			  if(is_array($value) && count($value)>0){
				  if($value[0]==$matricula){
				  	//echo"PRUEBA--".$value[0]."---";
				  	$Respuesta = "0".$value[9].$value[10];
				  	//$datos1 = $this->getMaterias($matricula);
					return $Respuesta;
					//return $value;
				  }
			  }
			}
		}
	}
//------------------------------------------------------------------------
//buscar materias del alumno,->recive matricula
	//------------------------------------------------------------------------
	public function buscar(){

		echo "Estas buscando los datos de un alumno";
		$dbfData = $this->model->getMaterias(201600057);


		die(var_dump($dbfData));
	}
	
public function getMaterias($matricula){
		$datos= $this->getDbf("DLISTA");
		if(count($datos)>0 && is_array($datos)){
		  foreach ($datos as $key=>$value) {
			  if(is_array($value) && count($value)>0){
				  if($value[1]==$matricula){
				  	$resp = $value[0].$value[2];
					return $resp;
				  }
			  }
			}
		}
	}
//------------------------------------------------------------------------
	//Buscar carga horaria
//------------------------------------------------------------------------
public function buscar(){

		echo "Estas buscando los datos de un alumno";
		$dbfData = $this->model->getAlumno(3163,2,'B','07A');
		// primer parametro clave de plan de estudio, segundo, clave de alumno 1 ,  3ro clave de grupo alumno, 4to Cuatrimestre actual y grupo actual. 
		//datos de muestra
		//solo estan los horarios de 7mo cuatrimestre para abajo - Comprobar con DLISTA y DGRUPO y DMATER

		die(var_dump($dbfData));
	}
//horarios
public function getAlumno($matricula,$clave,$letra,$grupo){
$datos= $this->getDbf("DGRUPO");
		$pila=array();
		if(count($datos)>0 && is_array($datos)){
		  foreach ($datos as $key=>$value) {
			  if(is_array($value) && count($value)>0){
				  if($value[0]==$matricula && $value[3]==$clave && $value[4]==$letra && $value[6]==$grupo){
				  	$Mater = $value[7];
				  	$Lunes = $value[13];
				  	$Martes = $value[15];
				  	$Miercoles = $value[17];
				  	$Jueves = $value[19];
				  	$Viernes = $value[21];
				  	$Resultados ="Materia:".$Mater."Lunes:".$Lunes."Martes:".$Martes."Miercoles:".$Miercoles."Jueves:".$Jueves."Viernes:".$Viernes;
				  	array_push($pila, $Resultados);
					
				  }
				  
			  }
			}
			return $pila;
		}
	}

?>