<?php  
/**
 * 
 */
class horarioModel extends Model
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
							'matricula' => $fila['ALUCTR']
              		];
              		break;
              }
              
              
          }

          dbase_close($con);
          return $aux;
		}
		return null;

	}


	public function getGrupo($matricula){
		 $con = $this->DB->DBFconnect('DCALUM');
        $aux = null;

        if ($con) {
            $numero_registros = dbase_numrecords($con);


          for ($i = 1; $i <= $numero_registros; $i++) {

              $fila = dbase_get_record_with_names($con, $i);

              if (strcmp($fila["ALUCTR"],$matricula) == 0) {
                      // $aux = $fila;
                      $aux = [
                            'estudia' => "0".$fila["CARCVE"].$fila["PLACVE"].$fila["CALNPE"].$fila["CALGPO"]
                      ];
                      break;
              }


          }

          dbase_close($con);
          return $aux;
        }
        return null;
	}


	public function getClave($matricula)
    {
        $datos = $this->DB->DBFconnect('DLISTA');
     	  $info = array();
        $aux = 0;

        if($datos){

            $numero_registros = dbase_numrecords($datos);
            for($i = 1; $i <= $numero_registros; $i++){
                $fila = dbase_get_record($datos, $i);
                if(strcmp($fila[1], $matricula) == 0){
                    $info=$fila[0];
                    $aux++;
                }
            }
            return (int)$info;


        }

    }

    public function getHorarios($matricula,$clave,$letra,$grupo){
        $datos= $this->DB->DBFconnect('DGRUPO');
		    $info = array();
        $aux = 0;

        if($datos){

            $numero_registros = dbase_numrecords($datos);
            for($i = 1; $i <= $numero_registros; $i++){
                $fila = dbase_get_record($datos, $i);
                if(strcmp($fila[0], $matricula)==0)
                {
                    if(strcmp($fila[3], $clave)==0)
                    {
                        if(strcmp($fila[4],$letra)==0)
                        {
                            if(strcmp($grupo,$fila[6])==0)
                              {
                                  $Mater = $fila[7];
                                  $grup = $fila[6];
                                  $Lunes = $fila[13];
                                  $Martes = $fila[15];
                                  $Miercoles = $fila[17];
                                  $Jueves = $fila[19];
                                  $Viernes = $fila[21];
                                  $Resultados ="Materia:".$Mater."Grupo".$grup."Lunes:".$Lunes."Martes:".$Martes."Miercoles:".$Miercoles."Jueves:".$Jueves."Viernes:".$Viernes;
                                  array_push($info, $Resultados);
                                  $aux++;
                             }
                        }
                    }
                }


            }
            return $info;
        }
}
public function getPeriodo($clavedeplan)
    {
      $datos = $this->DB->DBFconnect('DPERIO');
            $info = array();
            $aux = 0;

              if($datos){

                  $numero_registros = dbase_numrecords($datos);
                  for($i = 1; $i <= $numero_registros; $i++){
                      $fila = dbase_get_record($datos, $i);
                      if(strcmp($fila[0], $clavedeplan) == 0){
                          $info=$fila[3];
                          $aux++;
                      }
                  }
                  return $info;


              }

    }
    public function getMaterNombre($matricula)
    {
        $datos = $this->DB->DBFconnect('DMATER');
        $info = array();
        $aux = 0;

        if($datos){

            $numero_registros = dbase_numrecords($datos);
            for($i = 1; $i <= $numero_registros; $i++){
                $fila = dbase_get_record($datos, $i);
                if(strcmp($fila[0], $matricula) == 0){
                    $info=$fila[2];
                    $aux++;
                }
            }
            return (int)$info;


        }

    }
    public function getCarrera($Carcb)
    {
        $datos = $this->DB->DBFconnect('DCARRE');
        $carrerabr = array();
        $aux = 0;

        if($datos){

            $numero_registros = dbase_numrecords($datos);
            for($i = 1; $i <= $numero_registros; $i++){
                $fila = dbase_get_record($datos, $i);
                if(strcmp($fila[0], $Carcb) == 0){
                    $carrerabr=$fila[3];
                    $aux++;
                }
            }
            return $carrerabr;
        }

    }
    public function getmatter($Claveplan,$matricula)
    {
        $datos = $this->DB->DBFconnect('DLISTA');
        $matter = array();
        $aux = 0;

        if($datos){

            $numero_registros = dbase_numrecords($datos);
            for($i = 1; $i <= $numero_registros; $i++){
                $fila = dbase_get_record($datos, $i);
                if(strcmp($fila[0], $Claveplan) == 0){
                    if(strcmp($fila[1], $matricula)==0)
                    {
                        $materia1=$fila[2];
                        array_push($matter, $materia1);
                         $aux++;
                    }
                }
            }
            return $matter;
        }

    }
}



?>