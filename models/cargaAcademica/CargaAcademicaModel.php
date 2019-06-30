<?php

class CargaAcademicaModel extends Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = '';
    }
    
    public function getAcademicData($matricula)
	{
		
		/**Es muy importante que la matricula este bien validada, ya que con esta se realizan los metodos para validar
		 * en los DBF* */
		$cargaMaterias=$this->procesarDatosMaterias($matricula);
		$datosAlumno= $this->procesarDatosPeriodo($matricula);
		//$proffAndSubjectNames = $this->getProffSubjectNames($matricula);
		//$testArr=array_merge($proffAndSubjectNames);
		//die(var_dump($testArr));
		$newArr=array_merge($datosAlumno,$cargaMaterias);
		//die(var_dump($newArr));
		return $newArr;

	}

	/**
	 * Metodo: procesarDatosMateria
	 * Descripcion: Se asigna el nombre y el cr de las materias
	 * Autor: Gloria Aguilar
	 * Fecha: 14/06/2019* */
	public function procesarDatosMaterias($matricula){

		$aux=$this->procesarMaterias($matricula);
		
		foreach ($aux as $key => $value) {
			$nombres[]=$this->getMateriasNombres($key);
		}

		if(count($nombres)>0 && is_array($nombres)){
			foreach ($nombres as $indice=>$arrDatos){
				if(array_key_exists($arrDatos['clave_materia'],$aux))
				{
					$aux[$arrDatos['clave_materia']]['nombre_mater']=$arrDatos['materia_nom'];
					$aux[$arrDatos['clave_materia']]['cr']=$arrDatos['cr'];
				}
			}
		
			return $aux;
		}
		return null;
	
	}

	/**
	 * Metodo: procesarDatosPeriodo
	 * Descripcion: En este metodo se obtiene la descripcion de la carrera, 
	 * el periodo en el que ingreso el alumno, la clave de la carrera, la clave del plan,
	 * y se adjuntan los datos generales del alumno, todo en un array.
	 * NOTA: queda pendiente presentar el periodo actual, sin embargo parece inecesario porque ya existe
	 * vista general.
	 * Autor: Gloria Aguilar
	 * Fecha: 14/06/2019** */
	public function procesarDatosPeriodo($matricula)
	{
		$datos              = $this->getAlumnoUltimoCursado($matricula);
		$periodoAlumnoIngre = $this->getPeriodoAlumnoIngreso($datos['plan_clave'],$datos['clave_carrera']);
		$descripcionCarrera = $this->getCarreras($datos['clave_carrera']);
		$datosAlum			= $this->getDatosAlumn($matricula);

		$datos=array_merge($periodoAlumnoIngre,$descripcionCarrera);
		$datosGenerales=array_merge($datos,$datosAlum);


		return $datosGenerales;
		
	}

	/**
	 * Metodo:getDatosAlumn
	 * Descripcion: Obtenemos los datos del alumno con el que trabajaremos
	 * -importante: la matricula tiene que estar bien validad para que esto funcione correctamente-
	 * Nota: Parece ser inecesario porque ya existe vista general del alumno
	 * Autor: Gloria Aguilar
	 * Fecha: 13/06/2019* */
	public function getDatosAlumn($matricula){        
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
              		];
              		break;
              }           
		  }
          dbase_close($con);
          return $aux;
		}
		return null;
	}

	/**
	 * Metodo: procesarMateris
	 * Descripcion: En esta funcion, se manda a llamar: las materias del respectivo periodo, los ultimos datos del
	 * del alumno que se ingresaron en los dbf, unna vez teniendo eso, se adjunta en un array los días de la semana, horas y el aula en la 
	 *donde se tomara la materia ¡AQUI NO SE ASIGNA EL NOMBRE!
	 * Autor: Gloria Aguilar
	 * Fecha: 13/06/2019
	 * Ultima modificacion: 14/06/2019
	 ** */
	public function procesarMaterias($matricula){
		/**Obtener ultimos datos cursados del alumno*/
		$datosCurso=$this->getAlumnoUltimoCursado($matricula);
		$datosCurso=((count($datosCurso)>0 && is_array($datosCurso))?$datosCurso:array());


		/**Obtener la carga de materias en el periodo actual*/
		$datosMateria = $this->getMateriasCargaH($matricula);
		$datosMateria = ((count($datosMateria)>0 && is_array($datosMateria))?$datosMateria:array());

		foreach($datosMateria as $ky=>$val){		
			$cargaMaterias[]=$this->getHorario($val['periodo'],$datosCurso['clave_carrera'],$datosCurso['plan_clave'],$val['clave_materia']);
			$grupoEstudiante=$val['grupo'];
		}

		/**Se realizo un metodo para quitar los espacios en blanco**/
		$grupoLimpio =$this->limpiarString($grupoEstudiante);

		/**Se recorre el array con las materias y grupo cargados, en este array se busca el
		 * grupo correspondiente del alumno para que se sepa el horario** */	
		if(count($cargaMaterias)>0 && is_array($cargaMaterias)){
			foreach($cargaMaterias as $indice=>$arrDatos){
				foreach($arrDatos as $key=>$arrMaterias){
					foreach($arrMaterias as $valores){
						if(strpos($valores['grupo'],$grupoLimpio)!==false){
							$datosCarga[$key]=$valores;
						}
					}
				}
			}
			return $datosCarga;
		}else{
			echo "Error #100";
		}
			return null;
		}


	/**
	 * Metodo: getAlumnoUltimoCursado,
	 * Descripcion: Este método obtiene la clave de la carrera, el ultimo cuatrimestre cursado,
	 * y el grupo al que pertenece. Este método servirá para obtener datos de otras tables.
	 * Autor: Gloria Aguilar
	 * Módulo: Carga Alumno
	 * Fecha: 13/06/2019
	 * */
	public function getAlumnoUltimoCursado($matricula){
		$con = $this->DB->DBFconnect('DCALUM');
		$aux = null;

		if ($con) {
			$numero_registros = dbase_numrecords($con);
          for ($i = 1; $i <= $numero_registros; $i++) {
              $fila = dbase_get_record_with_names($con, $i);
              if (strcmp($fila["ALUCTR"],$matricula) == 0) {
              		// $aux = $fila;
              		$aux = array(
							'clave_carrera' => $fila['CARCVE'],
							'plan_clave'    => $fila['PLACVE'],
							'periodo_ingreso' =>$fila['CALING']
					  );
              		break;
              }              
          }
          dbase_close($con);
          return $aux;
		}
		return null;
	}


	/**
	 * Metodo: getMateriasCargaH
	 * Descripcion: En este metodo se el periodo del alumno que esta cursando
	 * -importante: es necesario pasar la matricula-
	 * Autor: Gloria Aguilar
	 * Fecha: 13/06/2019* */
	public function getMateriasCargaH($matricula){
		$con = $this->DB->DBFconnect('DLISTA');
		$aux = null;
		if ($con) {
			$numero_registros = dbase_numrecords($con);
          for ($i = 1; $i <= $numero_registros; $i++) {
              $fila = dbase_get_record_with_names($con, $i);
              if (strcmp($fila["ALUCTR"],$matricula) == 0) {
				  if($fila['TCACVE']===0){
					$aux[] =array(
						'periodo'       => $fila['PDOCVE'],
						'matricula'     => $fila['ALUCTR'],
						'clave_materia' => $fila['MATCVE'],
						'grupo'         => $fila['GPOCVE'],
					
					);
				  }
              }              
          }
          dbase_close($con);
          return $aux;
		}
		return null;
	}

	/**
	 * Metodo:getHorario.
	 *Descripcion: En este metodo se obtienen los días, las horas
	 *en las que el alumno tendra la materia.
	 *Importante: Es necesario el periodo, la clave de la carrera, clave del periodo y el grupo
	 *Autor: Gloria Aguilar
	 *Fecha: 13/06/2019
	 * 
	  **/

	public function getHorario($periodo,$claveCarrera,$clavePeriodo,$materia){
		$con = $this->DB->DBFconnect('DGRUPO');
		$aux = null;
		if ($con) {
			$numero_registros = dbase_numrecords($con);
          for ($i = 1; $i <= $numero_registros; $i++) {
			  $fila = dbase_get_record_with_names($con, $i);
			  //Obtenemos el periodo de la carga
              if (strcmp($fila["PDOCVE"],$periodo) == 0) {
				  if(strcmp($fila['CARCVE'],$claveCarrera)==0){
					if(strcmp($fila['PLACVE'],$clavePeriodo)==0){
 						if(strcmp($fila['MATCVE'],$materia)==0){
							$aux[$fila['MATCVE']][] =array(
								'lunes'			=>$fila['LUNHRA'],	
								'lunes_aula'	=>$fila['LUNAUL'],	
								'martes'		=>$fila['MARHRA'],	
								'martes_aula'	=>$fila['MARAUL'],	
								'miercoles'		=>$fila['MIEHRA'],	
								'miercoles_aula'=>$fila['MIEAUL'],	
								'jueves'		=>$fila['JUEHRA'],	
								'jueves_aula'	=>$fila['JUEAUL'],	
								'viernes'		=>$fila['VIEHRA'],	
								'viernes_aula'	=>$fila['VIEAUL'],
								'grupo'			=>$fila['GPOCVE'],
								'clave_materia' =>$fila['MATCVE'],
								'nombre_mater'  => '',
								'cr'            => ''
							);						
					  }
					}
					 
				  }
              }              
          }
          dbase_close($con);
		  return $aux;
		
		}
		return null;
		
	}

	public function getMateriasNombres($claveMateria){
		$con = $this->DB->DBFconnect('DMATER');
		$aux = null;

		if ($con) {
			$numero_registros = dbase_numrecords($con);
          for ($i = 1; $i <= $numero_registros; $i++) {
              $fila = dbase_get_record_with_names($con, $i);
              if (strcmp($fila["MATCVE"],$claveMateria) == 0) {
              		$aux = array(
							'clave_materia' => $fila['MATCVE'],
							'materia_nom'   => $fila['MATNOM'],
							'cr'            => $fila['MATCRE']
					  );
              }              
          }
          dbase_close($con);
          return $aux;
		}
		return null;
	}


	/**
	 * Funcion: limpiarString
	 * Descripcion: Esta función sirve para limpiar los espacios en blanco de los datos
	 * que llegan de los DBF, se implementó por que si la cadena cuenta con algun espacio, este no lo detecta 
	 * y se omite el registro.
	 * Autor: Gloria Aguilar
	 * Fecha: 14/06/2019
	 * *** */
	public function limpiarString($cadena)
	{
		if($cadena!=="")
		{
			$newString =str_replace(' ', '', $cadena);
			return $newString;
		}
		return null;
	}

	/***
	 * Metodo: getPeriodoAlumnoIngreso
	 * Descripcion: Se obtienen el periodo del alumno cuando ingreso a la institucion
	 * Nota: Parecer ser inecesario pero así se muestra en la vista de Front
	 * Autor: Gloria Aguilar
	 * Fecha: 14/06/2019** */

	public function getPeriodoAlumnoIngreso($planClave,$carreraClave){
		$con = $this->DB->DBFconnect('DPLANE');
		$aux = null;

		if ($con) {
			$numero_registros = dbase_numrecords($con);
          for ($i = 1; $i <= $numero_registros; $i++) {
              $fila = dbase_get_record_with_names($con, $i);
              if (strcmp($fila["PLACVE"],$planClave) == 0) {
				if (strcmp($fila["CARCVE"],$carreraClave) == 0) {
					$aux = array(
						'plan_inicio'  => $fila['PLACOF'],
						'clave_carrera' => $fila['CARCVE'],
						'plan_clave'    => $fila['PLACVE']
				  );
				  break;
				}
              }              
          }
          dbase_close($con);
          return $aux;
		}
		return null;
	}

	/***
	 * Metodo: getCarreras
	 * Descripcion: se obtiene el nombre y la descripcion de la carrera
	 * NOTA: parece ser inecesario porque ya existe una vista General y ahí se pueden obtener datos
	 * Autor: Gloria Aguilar
	 * Fecha: 14/06/2019** */

	public function getCarreras($clave_carrera)
	{
		$con = $this->DB->DBFconnect('DCARRE');
		$aux = null;

		if ($con) {
			$numero_registros = dbase_numrecords($con);
          for ($i = 1; $i <= $numero_registros; $i++) {
              $fila = dbase_get_record_with_names($con, $i);
				if (strcmp($fila["CARCVE"],$clave_carrera) == 0) {
					$aux = array(
						'carrera_nombre'=> $fila['CARNOM'],
						'carrera_abre'  => $fila['CARNCO']
				  );
				  break;
				}            
          	}		
          dbase_close($con);
          return $aux;
		}
		return null;
	}

	/**
	 * Descripcion: Se obtiene únicamente las claves de las materias que se está cursando, filtrando los datos que trae getMateriasCargaH
	 * Autor: Juan Octaviano
	 * Fecha: 29/06/2019* 
	 * */

	public function getClaveMateria($matricula)
	{
		$aux=$this->getMateriasCargaH($matricula);
		$allKeySubjects = array();

		for($i = 0; $i <= (count($aux) - 1); $i++){
			$allKeySubjects[$i] = $aux[$i]["clave_materia"];
		}
		
		return $allKeySubjects;
	}
	/**
	 * Descripcion: Se obtiene los turnos en qué está cursando las materias el alumno ej: Samos que cursa una materia en la tarde y las demás en la mañana. Esto para evitar errores.
	 * Autor: Juan Octaviano
	 * Fecha: 29/06/2019* 
	 * */
	public function getTurnosAlumno($matricula)
	{
		$aux=$this->getMateriasCargaH($matricula);
		$allKeysTurns = array();

		for($i = 0; $i <= (count($aux) - 1); $i++){
			$allKeysTurns[$i] = $aux[$i]["grupo"];
		}

		return $allKeysTurns;
	}
	/**
	 * Descripcion: Se obtiene los periodos en qué está cursando las materias el alumno Esto se usa para mejorar la búsqueda en mergeProffSubjectKeys.
	 * Autor: Juan Octaviano
	 * Fecha: 29/06/2019* 
	 * */
	public function getPeriodosAlumno($matricula)
	{
		$aux=$this->getMateriasCargaH($matricula);
		$allKeysPeriods = array();

		for($i = 0; $i <= (count($aux) - 1); $i++){
			$allKeysPeriods[$i] = $aux[$i]["periodo"];
		}
		
		return $allKeysPeriods;
	}
	/**
	 * Descripcion: Se junta y devuelve en un array las claves de las materias con las claves de los maestros.
	 * Autor: Juan Octaviano
	 * Fecha: 29/06/2019* 
	 * */
	public function mergeProffSubjectKeys($matricula)
	{
		$con = $this->DB->DBFconnect('DGRUPO');
		$aux = Array();
		$allSbujects=$this->getClaveMateria($matricula);
		$allTurns=$this->getTurnosAlumno($matricula);
		$allPeriods=$this->getPeriodosAlumno($matricula);
		
		if ($con) {
			$numero_registros = dbase_numrecords($con);
			for	 ($j = 0; $j <= (count($allSbujects) - 1); $j++)
			{
				for ($i = 1; $i <= $numero_registros; $i++) {
					$fila = dbase_get_record_with_names($con, $i);
					if (strcmp($fila["MATCVE"],$allSbujects[$j]) == 0) {
					  if (strcmp($fila["GPOCVE"],$allTurns[$j]) == 0) {
						  if(strcmp($fila["PDOCVE"],$allPeriods[$j]) == 0){
								$aux[$j] = array(
									'clave_profesor'  => $fila['PERCVE'],
									'clave_materia' => $fila['MATCVE'],
							);
							break;
						  }
					  	}
					}              
				}
			}
			dbase_close($con);
			return $aux;
		}
		return $aux;
	}
	/**
	 * Descripcion: Método final que obtiene y devuelve en un array el Nombre de las materias y el Nombre de los profesores que imparten dichas materias actualmente.
	 * Autor: Juan Octaviano
	 * Fecha: 30/06/2019* 
	 * */
	public function getProffSubjectNames($matricula)
	{
		$allProffNames = array();
		$allSubjectsNames = array();
		$allProffKeys = array();
		$allSubjectsKeys = array();

		$conSubjects = $this->DB->DBFconnect('DMATER');
		$conProff = $this->DB->DBFconnect('DPERSO');
		$mergedData = $this->mergeProffSubjectKeys($matricula);

		for($i = 0; $i <= (count($mergedData) - 1); $i++){
			$allProffKeys[$i] = $mergedData[$i]["clave_profesor"];
		}
		for($i = 0; $i <= (count($mergedData) - 1); $i++){
			$allSubjectsKeys[$i] = $mergedData[$i]["clave_materia"];
		}

		if ($conProff) {
			$numero_registros = dbase_numrecords($conProff);
			for	 ($j = 0; $j <= (count($allProffKeys) - 1); $j++)
			{
				for ($i = 1; $i <= $numero_registros; $i++) {
					$fila = dbase_get_record_with_names($conProff, $i);
					if (strcmp($fila["PERCVE"],$allProffKeys[$j]) == 0) {
						$allProffNames[$j] = array(
							'nombre_profesor'  => $fila['PERNOM'],
							'apellido_profesor'  => $fila['PERAPE'],
						);
					break;  	
					}              
				}
			}
		}

		if ($conSubjects) {
			$numero_registros = dbase_numrecords($conSubjects);
			for	 ($j = 0; $j <= (count($allSubjectsKeys) - 1); $j++)
			{
				for ($i = 1; $i <= $numero_registros; $i++) {
					$fila = dbase_get_record_with_names($conSubjects, $i);
					if (strcmp($fila["MATCVE"],$allSubjectsKeys[$j]) == 0) {
						$allSubjectsNames[$j] = array(
							('nombre_materia ')  => $fila['MATNOM'],
						);
					break;  	
					}              
				}
			}
		}
		$allData = array_merge($allProffNames,$allSubjectsNames);

		return $allData;
	}
	/**
	 * Descripcion: Método final que obtiene y devuelve en un array únicamente el Nombre de los profesores que tiene el alumno actualmente.
	 * Autor: Juan Octaviano
	 * Fecha: 30/06/2019* 
	 * */
	public function getOnlyProffNames($matricula)
	{
		$allProffNames = array();
		$allProffKeys = array();

		$conProff = $this->DB->DBFconnect('DPERSO');
		$mergedData = $this->mergeProffSubjectKeys($matricula);

		for($i = 0; $i <= (count($mergedData) - 1); $i++){
			$allProffKeys[$i] = $mergedData[$i]["clave_profesor"];
		}

		if ($conProff) {
			$numero_registros = dbase_numrecords($conProff);
			for	 ($j = 0; $j <= (count($allProffKeys) - 1); $j++)
			{
				for ($i = 1; $i <= $numero_registros; $i++) {
					$fila = dbase_get_record_with_names($conProff, $i);
					if (strcmp($fila["PERCVE"],$allProffKeys[$j]) == 0) {
						$allProffNames[$j] = array(
							'nombre_profesor'  => $fila['PERNOM'],
							'apellido_profesor'  => $fila['PERAPE'],
						);
					break;  	
					}              
				}
			}
		}
	
		return $allProffNames;
	}
	/**
	 * Descripcion: Método final que obtiene y devuelve en un array únicamente el Nombre de las materias que tiene el alumno actualmente.
	 * Autor: Juan Octaviano
	 * Fecha: 30/06/2019* 
	 * */
	public function getOnlySubjectNames($matricula)
	{
		$allSubjectsNames = array();
		$allSubjectsKeys = array();

		$allSubjectsKeys = array();
		$conSubjects = $this->DB->DBFconnect('DMATER');
		$mergedData = $this->mergeProffSubjectKeys($matricula);

		for($i = 0; $i <= (count($mergedData) - 1); $i++){
			$allSubjectsKeys[$i] = $mergedData[$i]["clave_materia"];
		}
		if ($conSubjects) {
			$numero_registros = dbase_numrecords($conSubjects);
			for	 ($j = 0; $j <= (count($allSubjectsKeys) - 1); $j++)
			{
				for ($i = 1; $i <= $numero_registros; $i++) {
					$fila = dbase_get_record_with_names($conSubjects, $i);
					if (strcmp($fila["MATCVE"],$allSubjectsKeys[$j]) == 0) {
						$allSubjectsNames[$j] = array(
							('nombre_materia ')  => $fila['MATNOM'],
						);
					break;  	
					}              
				}
			}
		}
			
		return $allSubjectsNames;
	}
}
?>