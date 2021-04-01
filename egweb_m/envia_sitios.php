<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Envía sitios de interes</title>
</head>
<body>
<?php
function get_real_ip(){
	if (isset($_SERVER["HTTP_CLIENT_IP"])){
		return $_SERVER["HTTP_CLIENT_IP"];
	}
	elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
		return $_SERVER["HTTP_X_FORWARDED_FOR"];
	}
	elseif (isset($_SERVER["HTTP_X_FORWARDED"])){
		return $_SERVER["HTTP_X_FORWARDED"];
	}
	elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){
		return $_SERVER["HTTP_FORWARDED_FOR"];
	}
	elseif (isset($_SERVER["HTTP_FORWARDED"])){
		return $_SERVER["HTTP_FORWARDED"];
	}
	else{
		return $_SERVER["REMOTE_ADDR"];
	}
} 
	if($_POST['nombre']==''){
		echo "<script type='text/javascript'>alert('No se puede registrar el sitio de interes')</script>";
		echo "<script type='text/javascript'>window.parent.location='principal.php'</script>";
		exit(0);
	}
	else{
		include("librerias/conexion.php");
		//operacion para separar latlng....- 
		$pos_temp = $_POST['lngitud'];	
		$pos_temp =str_replace("(","",$pos_temp); 
		$pos_temp =str_replace(")","",$pos_temp);
		$n = strpos($pos_temp,',');				 
		//variables necesarias para registrar el sitio de interes
		$id_empresa = $_POST['empresa'];			$latitud =  substr($pos_temp,0,$n);
		$idu = $_POST['idu'];			$latitud =  substr($pos_temp,0,$n);
		$longitud = substr($pos_temp,$n+1);			$nom_sitio = $_POST['nombre'];
		$tipo= $_POST['tipo'];						$contacto= $_POST['contacto'];
		$tel1= $_POST['tel1'];						$tel2= $_POST['tel2'];
		//consulta para insertar a la base de datos el sitio de interes
		$insertar = "insert into sitios (id_tipo,nombre,latitud,longitud,contacto,tel1,tel2,id_empresa) ";
		$insertar .= "values ('$tipo','$nom_sitio','$latitud','$longitud','$contacto','$tel1','$tel2','$id_empresa')";
		
		mysql_query($insertar) or die ("Error en sitios");
		$consulta = "insert into auditabilidad values (0,'$idu','".date("Y-m-d H:i:s")."',1,'Creacion de sitios de interes',13,
		$id_empresa,'".get_real_ip()."')";
		mysql_query($consulta);
		echo "<script type='text/javascript'>alert('Se registró el Sitio de Interes')</script>";
		//echo $consulta;
		echo "<script type='text/javascript'>window.parent.location='principal.php'</script>";
	}
?>
</body>
</html>
