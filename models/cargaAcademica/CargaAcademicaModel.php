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

		$newArr=array_merge($datosAlumno,$cargaMaterias);

		die(var_dump($newArr));


		return $datosAlumno;
		
	

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
	}
	
	


?>