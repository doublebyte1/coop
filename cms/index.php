<?php
	/**
	 * Mostrar errores, comentar en versión de producción
	 */
	//ini_set('display_errors', 0);
	//error_reporting(E_ALL);
	
	
	// Iniciamos la sesión para trabajar con $_SESSION
	session_start(); 
	
	// Incluimos la configuración y las clases.
	include_once 'config.php';
	include_once 'src/usuario.class.php';
	include_once 'src/seccion.class.php';
	include_once 'src/formulario.class.php';
	
	// Creamos los objetos necesarios para trabajar con secciones y usuarios
	$seccion = new Seccion();
	$usuario = new Usuario();
	
	// Estos dos condicionales aseguran que se forma correctamente el array $ruta.
	if ((isset($_GET['seccion']))&&($_GET['seccion']!='')) {
		$ruta['seccion'] = $_GET['seccion'];
	} else {
		$ruta['seccion'] = 'home';
	}
	
	if ((isset($_GET['accion']))&&($_GET['accion']!='')) {
		$ruta['accion'] = $_GET['accion'];
	} else {
		$ruta['accion'] = '';
	}

	switch ($ruta['seccion']) {
		case 'login':
			if (!$usuario->isLogged()) {	
				switch ($ruta['accion']) {
					case 'login':
						if ((isset($_POST['usuario']))&&(($_POST['password']))) {
						$usuario->login($_POST['usuario'],$_POST['password']);
						} else {
							header("Location:./");
						}
						break;
					case 'error':
						$usuario->formulario(TRUE);
						break;
					case '':
					default:
						$usuario->formulario();
						break;
				}
			} else {
				header("Location:./");
			}
			break;
			
		case 'logout':
			$usuario->logout();
			break;
		
		default:
			switch ($ruta['accion']) {
				case '':
					$seccion->ver($ruta['seccion']);
					break;
				
				case 'editar':
				case 'nueva':
					$seccion->editar($ruta['seccion']);
					break;
				
				case 'guardar':
					$seccion->guardar($ruta['seccion'], $_POST);
					break;
				
				case 'eliminar':
					$seccion->eliminar($ruta['seccion']);
					break;
				
				case 'confirmar':
					$seccion->eliminar($ruta['seccion'],TRUE);
					break;
				
				default:
					
					break;
			}
			break;
	}
	
	// Vemos las opciones de la ruta, quitar en producción
	//var_dump($_GET);
	//var_dump($_POST);
	