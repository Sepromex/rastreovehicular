<?php
  include('librerias\conexion.php');
  
  $result = mysql_query("SELECT respuesta FROM notificaweb where id=728120740");
  $row = mysql_fetch_array($result);
  
  /*echo $row[0]." mide: ".strlen($row[0])."<br>";
  $array = explode('\r\n',$row[0]);
  echo $array[0]." mide: ".strlen($array[0])."<br>";
  $array2 = explode(',',$array[0]);
  echo $array2[1];*/
  /*$newStrign = str_replace('$MOTION=', '', $row[0]);
  $arrayPartes = explode(",",$newStrign);
  if ($arrayPartes[0] == "0")
	echo "Activo: ".$arrayPartes[0];*/
	/*$cont = 0;
	for($i = 0 ; $i <= 360 ; $i+=18)
	{
		echo $i."<br>";
		$cont++;
	}
	echo "Totales: ".$cont;*/
	$consulta = "(27.527758206861883,-106.58935546875,1,num_geo)(15.623036831528264,-104.39208984375,2,num_geo)(18.020527657852337,-97.88818359375,3,num_geo)(23.40276490540795,-94.63623046875,4,num_geo)(26.82407078047018,-95.38330078125,5,num_geo)(28.998531814051795,-101.22802734375,6,num_geo)(27.527758206861883,-106.58935546875,7,num_geo):";
	$consulta = str_replace(",","','",$consulta); 
	$consulta = str_replace("(","('",$consulta); 
	$consulta = str_replace(")","'),",$consulta);
	$consulta = str_replace("),:",")",$consulta);
	$consulta = str_replace("num_geo",12,$consulta);
	$cad_cons = "insert into geo_puntos (latitud,longitud,orden,id_geo) values $consulta";	
	echo $cad_cons;
  
 ?>