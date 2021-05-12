<?php
  $nombre = $_POST['nombre'];
  $pass = $_POST['pass'];
  
  if( $nombre == "carlos" && $pass == "cruz")
  {  
	echo "aviso=Datos correctos&mensaje=Datos: $nombre y $pass";	
  }else 
  {
	echo "aviso=Datos incorrectos";
  }
?>