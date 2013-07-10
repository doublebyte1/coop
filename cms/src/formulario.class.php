<?php

	/**
	 * Esta clase gestiona los formularios de contacto del gestor
	 */
	class Formulario {
		
		function __construct($destino, $asunto) {
			
		}
		
		/**
		 * Genera un input tipo texto con su respectiva etiqueta
		 * 
		 * @param string $id identificador para el campo, será también la etiqueta name
		 * @param string $etiqueta Etiqueta en lenguja humano
		 * @param boolean $obligatorio Especifica si el campo es obligatorio
		 * @return void
		 * 
		 */
		 
		public function texto($id, $etiqueta, $obligatorio = FALSE)
		{
			
		}
		
		/**
		 * Genera un input tipo email con su respectiva etiqueta
		 * 
		 * @param string $id identificador para el campo, será también la etiqueta name
		 * @param string $etiqueta Etiqueta en lenguja humano
		 * @param boolean $obligatorio Especifica si el campo es obligatorio
		 * @return void
		 * 
		 */
		 
		public function email($id, $etiqueta, $obligatorio = FALSE)
		{
			
		}
		
		/**
		 * Genera un textarea con su respectiva etiqueta
		 * 
		 * @param string $id identificador para el campo, será también la etiqueta name
		 * @param string $etiqueta Etiqueta en lenguja humano
		 * @param boolean $obligatorio Especifica si el campo es obligatorio
		 * @return void
		 * 
		 */
		 
		public function areadetexto($id, $etiqueta, $obligatorio = FALSE)
		{
			
		}
		
	}
	