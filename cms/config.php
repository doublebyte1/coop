 <?php

	 /**
         * Archivo con todas las configuraciones del sitio
         * 
         */
         
         /**
          * Configuración básica
          */
          
          
          $config['titulo']	= "Coop 2.0 :)";
	  $config['titular']	= "Cooperante 2.0";
          $config['logo']	= "images/logo.png";
          $config['base']	= "http://localhost/coop/cms/";
	  $config['feed']	= "http://www.accioncontraelhambre.org/blog/feed/";
        
         /**
          * Configuración base de datos
          */
          
          $bd['servidor']	= "localhost";
          $bd['nombre']		= "coop";
          $bd['usuario']	= "root";
          $bd['password']	= "bioport";
        
          $usuario['user']    	= "admin";
          $usuario['password']	= "1089c794da9b5edd26e6f5d46ed7363a94e119c5"; 
	  $usuario['shared']	= (int) 50;
	  $usuario['donation']	= (int) 60;

         /**
          * Factores de conversion para el Karma
          */

	  $factor['shared']	= (int) 1;
	  $factor['donation']	= (int) 1;