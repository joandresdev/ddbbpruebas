<?php  
/**
 * 
 */
class Database 
{
	private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

	function __construct()
	{
		// echo "<br> New Database";
		    $this->host     = constant('HOST');
        $this->db       = constant('DB');
        $this->user     = constant('USER');
        $this->password = constant('PASSWORD');
        $this->charset  = constant('CHARSET');
	}

	public function MYSQLconnect(){
    
        try{
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($connection, $this->user, $this->password, $options);
    
            return $pdo;

        }catch(PDOException $e){
        	#poner un error mas decente
            // print_r(' <br>Error en MYSQLconnect: ' . $e->getMessage() ."<br>");
            $error = new Errores();
            $error->E500("conex ddbb A1");//base datos
             exit;
        }   
    }

    public function DBFconnect($dbf){
        // echo " ando en dbf connect <br>";
        $path = "database/".$dbf.".DBF";

        // NO SE PUEDE CONTROLAR 
        $db   = dbase_open($path, 0);
            
        if ($db) {
          return $db;
          // $número_registros = dbase_numrecords($db);

          // for ($i = 1; $i <= $número_registros; $i++) {

          //     $fila = dbase_get_record_with_names($db, $i);
               
              
          //     return $fila;
          // }

          // dbase_close($db);
        }else{
            echo "Redireccionar error de dbf coneexion";
          return null;
        }



    }



 // $fila = dbase_get_record ($db,2);
              // var_dump($fila);
              // if ($fila["ALUAPP"]) {
              //     echo $fila["ALUAPP"] . " - ".$fila["ALUNOM"] . "<br>";
              // }else{
              //   echo "nel <br>";
              // }


	
}
?>