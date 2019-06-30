<?
public function buscarMateriasKardex(){
		$dbfData = $this->model->getMateriasKardex(2,'B','09A ');
		die(var_dump($dbfData));
	}

public function getMateriasKardex($claveCarrera,$clavePeriodo,$grupokardex){
		$con = $this->DB->DBFconnect('DGRUPO');
		$aux = 0;
		if ($con) {
			$numero_registros = dbase_numrecords($con);
          for ($i = 1; $i <= $numero_registros; $i++) {
			  $fila = dbase_get_record_with_names($con, $i);
              if(strcmp($fila['CARCVE'],$claveCarrera)==0){
					if(strcmp($fila['PLACVE'],$clavePeriodo)==0){
 						$aux[$fila['MATCVE']][] =array(
								'Clave de plan Estudio'=>$fila['PDOCVE'],	
								'Clave de carrera'     =>$fila['CARCVE'],	
								'Clave de periodo'     =>$fila['PLACVE'],	
								'clave_materia'        =>$fila['MATCVE'],
								'nombre_mater'  => '',
								'cr'            => ''
							);
					}
					 
				  }              
          }
          dbase_close($con);
		  return $aux;
		
		}
		return null;
		
	}
?>