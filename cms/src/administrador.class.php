<?php

	/**
	 * Esta clase se encarga de la parte visible de administración del sitio
	 */
	 
	class Administrador {

		var $admin;
		var $html_mensaje;
		
		function __construct() {
			include_once 'src/plantilla.class.php';
			$this->admin 		= new Plantilla('admin');
			$this->html_mensaje	= new Plantilla('mensaje');
		}
		
		
		/**
		 * Crea un codigo html para la barra de administración
		 * 
		 * @return string HTML
		 * 
		 */
		 
		public function barra($url, $activos)
		{
			$contenido_admin = array(
				"editar" => '',
				"borrar" => '',
				"nueva" => '',
				"guardar" => '',
				"cancelar" => '',
				"seccion" => $url
			);
			
			foreach ($activos as $elemento) {
				$contenido_admin[$elemento] = 'activo';
			}
			
			$this->admin->asigna_variables($contenido_admin);
			
			return($this->admin->muestra());
		
		}
		
		/**
		 * Genera el un mensaje con una pregunta
		 * 
		 * Da la opción al usuario de aceptar la opción o cancelarla
		 * 
		 * @param string $url Es el identificador unico de la sección
		 * @return void
		 * 
		 */
		 
		public function mensaje($url, $accion, $mensaje)
		{
			
			include 'config.php';
			$contenido  = array(
				'base' => $config['base'],
				'mensaje' => $mensaje,
				'accion' => $accion,
				'titulo' => $mensaje,
				'seccion' => $url,
				'titular' => $config['titular']
			 );
			
			$this->html_mensaje->asigna_variables($contenido);
			echo $this->html_mensaje->muestra();
		}
	}
	