<?php
  include('librerias/conexion.php');
  include('ObtenUrl.php');   

  $parametros = $_GET["q"];
  $arrayParam = explode(",", $parametros);
  $idVeh = $arrayParam[0];
  $fecha = $arrayParam[1];
  $longitud = $arrayParam[2];
  $latitud = $arrayParam[3];
  
  $query = "select tipoveh,hora from sepromex.vehiculos where id_veh like '$idVeh'";
  //echo "<script>alert(\"$query\");</script>";
  $result = mysql_query($query);
  $row = mysql_fetch_array($result);
  $tipo = $row[0];
  $horar = $row[1];
  $newFecha = "";
  $dia= substr($fecha, 6, 2); //Dia 
  $anio = substr($fecha, 0, 4); //Año 
  $mes = substr($fecha, 4, 2); //Mes 
  $hora = substr($fecha,8,2);//hora
  $min = substr($fecha,10,2);//minitos
  $seg = substr($fecha,12,2);//segundos
  $newFecha = date("Y-m-d G:i:s",mktime($hora+($horar), $min, $seg,$mes, $dia, $anio)); //mktime del tiempo anterior  
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
	<title>EGWEB 3.0</title>
	<link href="librerias/dsn.css" rel="stylesheet" type="text/css" />
	<link href="librerias/default.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="librerias/tabla/tabla.css" type="text/css" media="screen">
	<script type='text/javascript' src="librerias/funciones.js"></script>
    <script type='text/javascript' src="librerias/jquery.js"></script>
	<script type="text/javascript" src="librerias/func_principalp1.js"></script>
    <script type="text/javascript" >
var j = jQuery.noConflict();

j(document).ready(function(){
    load();
    setTimeout("cargaPosicion()",1000);	
});	

function cargaPosicion()
{
	MapaCord(<?php echo $latitud; ?>, <?php echo $longitud;?>, <?php echo $tipo; ?>);
	showAddressByLatLng(<?php echo $latitud; ?>,<?php echo $longitud; ?>);
}

function showAddressByLatLng(lat,lng)
{
	geocoder.getLocations(new GLatLng(lat,lng), addressByLatLng); 
} 

function addressByLatLng(response)
{
  if (!response || response.Status.code != 200) {  
    alertdocument.getElementById("cruce").innerHTML ="Lo sentimos, no se ha encontrado su direcci&ocute;n";  
  } else {
    place = response.Placemark[0];
	document.getElementById("cruce").innerHTML = place.address;	
  } 	
}

	function fijarColor(n){
		xajax_color(n);
	}
	function initPanicos(obj,idu,p){
		if(obj.checked == true){
			tiempo(idu,p);
		}
		else{
			xajax_statusPanico();
			window.clearInterval(time_pan);
		}
	}
    </script> 
<?php 
	
	echo GetKey(); //imprime el API Key de google adecuado
?>
</head>
<body id="fondo" onunload="GUnload()">
<center>
<form id="form1"  name="form1" action="javascript:void(null);" onsubmit="return false;" >
  	<div id="cuerpoSuphead">
    <div id="msg_bvnd" class="fuente">Bienvenido <label ><?php echo $idVeh;?></label></div>
    </div>
    <div id="cuerpo_head">
	<div id="panel2" >
		<table border="0">
			<tr><td><b>Fecha:</b></td><td><?php  echo $newFecha;?></td><td><b>Ubicacion:</b></td><td id="cruce"></td></tr>
			<tr><td><b>Latitud:</b></td><td colspan="3"><?php  echo $latitud;?></td></tr>
			<tr><td><b>Longitud:</b></td><td colspan="3"> <?php  echo $longitud;?></td></tr>
		</table>
	</div>
    <div id="cont_mapa2"></div>
    <div id="cont_mapa_sepro"></div>
  </div>
<div id="cuerpo_medio"></div>
<div id="cuerpo_button">
<div id="contacto_ind">Contactenos al Teléfono 38255200 ext. 206 o envíe un email a 
<a href="mailto:aclientes@sepromex.com.mx" style="text-decoration:none;color:#ffffff;"  ><u>aclientes@sepromex.com.mx</u></a</div>
</div>
</form>
<div style=" display:none">
</div>
</center>
</body>
</html>