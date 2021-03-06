<?php

	/**
	 * Esta clase gestiona las secciones del gestor
	 */
	 
	class Seccion {

		var $usuario;
		var $admin;
		
		function __construct() {
			include_once 'src/plantilla.class.php';
			include_once 'src/administrador.class.php';
			include_once 'src/usuario.class.php';
			
			$this->usuario = new Usuario();
			$this->admin = new Administrador();
		}
		
		/**
		 * Muestra un formulario, vacío para crear una sección nueva. O con los datos de la sección que se pretende editar.
		 * 
		 * @param string $url El identificador unico de la sección que se desea crear, será la url amigable del sistema
		 * @return boolean Devuelve FALSE si algo ha ido mal.
		 * 
		 */
		 
		public function editar($url)
		{
			if (!$this->usuario->isLogged())
			{
				die("No tiene permiso para crear una nueva sección.");
			}
			include 'config.php';
			$con = mysqli_connect($bd['servidor'],$bd['usuario'],$bd['password'],$bd['nombre']);

			if (mysqli_connect_errno()) {
			    printf("Conexión fallida: %s\n", mysqli_connect_error());
			    exit();
			}
			$con->set_charset("utf8");
			$resultado = mysqli_query($con,"SELECT * FROM secciones WHERE url = '$url';");
			if ($resultado->num_rows > 0)
			{
				$fila = $resultado->fetch_assoc();
				 
				$plantilla = new Plantilla('editar');
				
				$html_admin = $this->admin->barra($url, array('guardar','cancelar'));
				
				$contenido  = array(
					'base' => $config['base'],
					'titulo' => $fila['titulo'].' - '.$config['titulo'],
					'admin' => $html_admin,
					'menu' => $this->menu(),
					'seccion' => $url,
					'titular' => $config['titular'],
					'editar_tipo' => $fila['tipo'],
					'editar_titulo' => $fila['titulo'],
					'editar_cuerpo' => $fila['cuerpo']
				 ); 
				
				$plantilla->asigna_variables($contenido);
					
				echo $plantilla->muestra();
			} else {
				 
				$plantilla = new Plantilla('editar');
				
				
				$html_admin = $this->admin->barra($url, array('guardar','cancelar'));
				
				$contenido  = array(
					'base' => $config['base'],
					'titulo' => 'Nueva sección - '.$config['titulo'],
					'admin' => $html_admin,
					'menu' => $this->menu(),
					'seccion' => $url,
					'titular' => $config['titular'],
					'editar_tipo' => '',
					'editar_titulo' => '',
					'editar_cuerpo' => ''
				 ); 
				
				$plantilla->asigna_variables($contenido);
					
				echo $plantilla->muestra();
			}
			
			
	
			mysqli_close($con);
			
			return($resultado);
		}
		
		/**
		 * Actualiza la sección expecificada
		 * 
		 * @param string $url Es el identificador unico de la sección
		 * @param string $titulo Titulo de la sección, FALSE por defecto
		 * @param string $cuerpo Cuerpo de la sección, FALSE por defecto
		 * @return mixed El ID de la sección generada
		 * 
		 */
		 
		public function guardar($url, $datos)
		{
			if (!$this->usuario->isLogged())
			{
				die("No tiene permiso para editar esta sección.");
			}
			include 'config.php';
			$con = mysqli_connect($bd['servidor'],$bd['usuario'],$bd['password'],$bd['nombre']);

			if (mysqli_connect_errno()) {
			    printf("Conexión fallida: %s\n", mysqli_connect_error());
			    exit();
			}
			$con->set_charset("utf8");
			
			$url		= htmlspecialchars($url);
			$tipo		= htmlspecialchars($datos['tipo']);
			$titulo		= htmlspecialchars($datos['titulo']);
			$cuerpo		= $datos['cuerpo']; 
			
			
			$resultado = mysqli_query($con,"SELECT id FROM secciones WHERE url = '$url'");
			if ($resultado->num_rows > 0)
			{
				$fila = $resultado->fetch_assoc();
				$id = $fila['id'];
				
				$guardar = mysqli_query($con, "UPDATE secciones SET url = '$url', tipo = '$tipo', titulo = '$titulo', cuerpo = '$cuerpo' WHERE id = '$id';");
			} else {
				$guardar = mysqli_query($con,"INSERT INTO secciones (url, tipo, titulo, cuerpo) VALUES ('$url', '$tipo', '$titulo', '$cuerpo');");
			}
			
			mysqli_close($con);
			header("Location:./");
		}
		
		/**
		 * devuelve los datos de una sección en concreto
		 * 
		 * @param string $url Es el identificador unico de la sección
		 * @return array Un array con el tipo, el título y el cuerpo de la sección
		 * 
		 */
		 
		public function ver($url)
		{
			include 'config.php';
			$con = mysqli_connect($bd['servidor'],$bd['usuario'],$bd['password'],$bd['nombre']);

			if (mysqli_connect_errno()) {
			    printf("Conexión fallida: %s\n", mysqli_connect_error());
			    exit();
			}
			$con->set_charset("utf8");
			
			if ($url == 'home') {
				$resultado = mysqli_query($con,"SELECT * FROM secciones WHERE tipo = 'portada';");
			} else {
				$resultado = mysqli_query($con,"SELECT * FROM secciones WHERE url = '$url';");
			}
			 
			if ($resultado->num_rows > 0) {
				
				$fila = $resultado->fetch_assoc();
				 
				$plantilla = new Plantilla($fila['tipo']);
				
				/*include "karma.class.php";
				$karma = new Karma();
				$karma_point = $karma->getKarma('carmen'); */
				$karma_point = 50;
				if ($this->usuario->isLogged())
				{
					$html_admin = $this->admin->barra($url, array('editar','borrar'));
				} else {
					$html_admin = "";
				}
				
				$contenido  = array(
				'base' => $config['base'],
				'titulo' => $fila['titulo'].' - '.$config['titulo'],
				'admin' => $html_admin,
				'menu' => $this->menu(),
				'karma'=> $karma_point,
				'titular' => $config['titular'],
				'cuerpo' => $fila['cuerpo']
				 ); 
				
				$plantilla->asigna_variables($contenido);
					
				echo $plantilla->muestra();
				
				
			} else {
				//include 'src/plantilla.class.php';
				$plantilla = new Plantilla('error');
				
				if ($this->usuario->isLogged())
				{
					$html_admin = $this->admin->barra($url, array('nueva'));
				} else {
					$html_admin = "";
				}
				
				$contenido  = array(
				'base' => $config['base'],
				'admin' => $html_admin,
				'ERROR' => "404 La página solicitada no existe."
				 );
				
				$plantilla->asigna_variables($contenido);
				header("HTTP/1.0 404 Not Found");
				echo $plantilla->muestra();
			}
			
			mysqli_close($con);
		}
		
		/**
		 * Genera el menú automaticamente
		 * 
		 * Genera el menú con home, secciones y contacto automaticamente, para poder insertarlo en la plantilla
		 * 
		 * @param string $url Es el identificador unico de la sección
		 * @return boolean True si no ha habido errores
		 * 
		 */
		 
		private function menu()
		{
			
			include 'config.php';
			$con = mysqli_connect($bd['servidor'],$bd['usuario'],$bd['password'],$bd['nombre']);
			
			if (mysqli_connect_errno()) {
			    printf("Conexión fallida: %s\n", mysqli_connect_error());
			    exit();
			}
			$con->set_charset("utf8");
			
			
			$salida = '<nav><ul>';
			
			$resultado = mysqli_query($con,"SELECT * FROM secciones WHERE tipo = 'portada';");
			while($fila =  $resultado->fetch_assoc()){
		   		$salida .= '<li><a href="'.$fila['url'].'">'.$fila['titulo'].'</a></li>';
		    }
		    
			$resultado = mysqli_query($con,"SELECT * FROM secciones WHERE tipo = 'seccion';");
			while($fila =  $resultado->fetch_assoc()){
		   		$salida .= '<li><a href="'.$fila['url'].'">'.$fila['titulo'].'</a></li>';
		    }
			
			$resultado = mysqli_query($con,"SELECT * FROM secciones WHERE tipo = 'contacto';");
			while($fila =  $resultado->fetch_assoc()){
		   		$salida .= '<li><a href="'.$fila['url'].'">'.$fila['titulo'].'</a></li>';
		    }
		    
			$salida .= '</ul></nav>';
			
			mysqli_close($con);
			
			return($salida);
		}

		
		/**
		 * Elimina la sección cuyo ID se pasa como parametro
		 * 
		 * @param string $url Es el identificador unico de la sección
		 * @return boolean True si no ha habido errores
		 * 
		 */
		 
		public function eliminar($url, $confirmacion = FALSE)
		{
			if (!$this->usuario->isLogged())
			{
				die("No tiene permiso para eliminar la sección.");
			}
			
			if (!$confirmacion) {
				$this->admin->mensaje($url, 'Eliminar', '¿Está seguro que quiere eliminar esta sección? No podrá desacer la acción.');
			} else {
				include 'config.php';
				$con = mysqli_connect($bd['servidor'],$bd['usuario'],$bd['password'],$bd['nombre']);
				
				if (mysqli_connect_errno()) {
				    printf("Conexión fallida: %s\n", mysqli_connect_error());
				    exit();
				}
				
				$resultado = mysqli_query($con,"DELETE FROM secciones WHERE url = '$url';");
				
				mysqli_close($con);
				
				header("Location:../");
				
			}
			
			
		}
	}
	