<?php
  /**
  * Class para gestionar el Karma.
  *
  */

  class Karma {
    private $usuario;

     function __construct ()
    {
    }
    
    /**
    * Se encargar de incrementar al compartir
    * @param string $url Es la url de destino para redirigir despues de realizar la accion en la BD
    */

    public function compartir($url)
    {
      incrementar('shared',1,$this->user);
      header('location:'.$url);
    }

    /**
    * Se encargar de incrementar al donar
    * @param string $url Es la url de destino para redirigir despues de realizar la accion en la BD
    */

    public function donar($url)
    {
      if(funcion_que_dona_con_paypal()){
	incrementar('donation',1,$this->user);
	header('location:'.$url);
      }	else {
	error('No se ha completado la donacion');
      }
      
    }

    /**
    * Se encargar de calcular los puntos de Karma
    * @return int el valor de puntos Karma
    */

    public function getKarma($usuario)
    {
      include 'config.php';
      
      $karma = ($factor['shared']*$usuario['shared']) + ($factor['donation']*$usuario['donation']);
      return($karma);
    }

     /**
    * Se encargar de calcular los puntos de Karma
    * @return int el valor de puntos Karma
    */

    public function incrementar($tipo, $incremento, $usuario)
    {
	include 'config.php';
	$con = mysqli_connect($bd['servidor'],$bd['usuario'],$bd['password'],$bd['nombre']);

	if (mysqli_connect_errno()) {
	    printf("Conexión fallida: %s\n", mysqli_connect_error());
	    exit();
	}
	$con->set_charset("utf8");
	$resultado = mysqli_query($con,"SELECT * FROM users WHERE user = '$usuario';");
	if ($resultado->num_rows > 0)
	{
	  $fila = $resultado->fetch_assoc();
	    $acumulado = $fila[$tipo] + $incremento;

	    $guardar = mysqli_query($con, "UPDATE users SET $tipo = $acumulado  WHERE user = '$usuario';");
	}
    }
  }