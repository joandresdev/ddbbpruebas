<?php  
	// TIPOS ACEPTADOS GET Y POST
/**
 * Rutas Autenticacion de usuarios
 */
	$this->newRoute('login','auth/authController','render');
	$this->newRoute('login','auth/authController','login','POST');
	$this->newRoute('logout','auth/authController','logout');


	$this->newRoute('alumnos/datos','alumno/alumnoController','datosGenerales');

?>