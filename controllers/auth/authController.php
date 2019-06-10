<?php  
/**
 * 
 */

class AuthController extends Controller
{
	
	function __construct()
	{

		$this->auth = new AuthValidator();
		

		parent::__construct();
		
		$this->modeln    = "Auth";	
		$this->path      = "auth";	//dentro de carpeta
		$this->routeView = "auth/login";
	}

	public function render(){
		if ($this->auth->makeAuth()) {
			echo "Existe";
			switch ($_SESSION['usuario']['type']) {
				case 'alumno':
					$this->localRedirect('alumnos/datos');
					break;
				case 'admin':
				echo "eres admin";
					$this->localRedirect('admin');
					break;
				case 'superadmin':
				echo "eres Super admin";
					$this->localRedirect('speradmin');
					break;
				
				default:
					echo "No existe ese tipo de usuario";
					break;
			}
		}else {
			// echo "no existe";
			$this->view->render($this->routeView);
			
		}
		
	}
	public function login(){

		if (isset($_POST['matricula']) && isset($_POST['pass'])) {
			$matricula = $_POST['matricula'];
			$pass      = $_POST['pass'];

			if (filter_var($matricula, FILTER_VALIDATE_INT) && !strcmp($pass, '') == 0) {
				

				
				
				$user = $this->model->getUser($matricula);

				// el usuario esta en ddbb MYSQL
				if ($user) {
					// echo "Estas en mysql <br>";
					if (strcmp($user['pass'],$pass) == 0) {
						
						$_SESSION["usuario"]=[
							'matricula'  => $user['matricula'],
							'index'      => $user['indexx'],
							'type'       => $user['type'],
							# Datos que pueden tener o no
							'email'      => $user['email'], 
							'email_pass' => $user['email_pass'],
							#solo los admin tienen este campo (en esta tabla MYSQL)
							'carrera'    => $user['carrera'],
						];
						$alumn = $this->model->getDbfUser($matricula);

						switch ($_SESSION['usuario']['type']) {
							case 'alumno':
								$mat = $alumn['matricula'];
								$this->localRedirect('alumnos/datos');
								break;
							case 'admin':
							echo "eres admin";
								// $this->view->alumn = $alumn;
								// $this->view->render('alumnos/datosGenerales');
								break;
							case 'superadmin':
							echo "eres Super admin";
								// $this->view->alumn = $alumn;
								// $this->view->render('alumnos/datosGenerales');
								break;
							
							default:
								echo "No existe ese tipo de usuario";
								break;
						}

					}else{
						echo "credenciales invalidas";
						$this->view->error = "Credenciales invalidas :c";
						$this->render();
					}
				}else {
					$alumn = $this->model->getDbfUser($matricula);
					if ($alumn) {
						// var_dump($alumn);
						// crear registro en mysql
						echo "<br>Crear registro";
						if ($this->model->addUser($alumn)) {
							$_SESSION["usuario"]=[
								'matricula'  => $alumn['matricula'],
								'index'      => -1,
								'type'       => 'alumno',
								# Datos que pueden tener o no
								'email'      => $alumn['matricula'].'@upqroo.edu.com', 
								'email_pass' => 'secret2',
								#solo los admin tienen este campo (en esta tabla MYSQL)
								'carrera'    => '--',
							];

							switch ($_SESSION['usuario']['type']) {
							case 'alumno':
								$mat = $alumn['matricula'];
								$this->localRedirect('alumnos/datos');
								break;
							case 'admin':
							echo "eres admin";
								// $this->view->alumn = $alumn;
								// $this->view->render('alumnos/datosGenerales');
								break;
							case 'superadmin':
							echo "eres Super admin";
								// $this->view->alumn = $alumn;
								// $this->view->render('alumnos/datosGenerales');
								break;
							
							default:
								echo "No existe ese tipo de usuario";
								break;
						}
						}else {
							echo "<br>No se pudo crear usuario";
						}

					}else{
						// echo "credenciales invalidas usuario no existe";
						$this->view->error = "Credenciales invalidas :c";
						$this->render();
					}
				}
				
				// print_r($_SESSION["usuario"]);
				// print_r($user);
				// unset($_SESSION["usuario"]);
			}

			
		}else{

			$this->localRedirect('login');
		}
		// se pueden mandar errores, get


	}


	public function logout()
	{
		if (isset($_SESSION['usuario'])) {
			unset($_SESSION['usuario']);
		}
		$this->localRedirect('login');
	}


}
?>