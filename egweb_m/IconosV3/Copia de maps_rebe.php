<?php
  include('librerias/conexion.php');
  include('ObtenUrl.php');   

  $parametros = $_GET["q"];
  $arrayParam = explode(",", $parametros);
  $idVeh = $arrayParam[0];
  $fecha = $arrayParam[1];
  $longitud = $arrayParam[2];
  $latitud = $arrayParam[3];
  
   	require('../xajaxs/xajax_core/xajax.inc.php');
	$xajax = new xajax(); 
	$xajax->configure('javascript URI', '../xajaxs/');
	$xajax->register(XAJAX_FUNCTION,"ver_geocercas");
	$xajax->register(XAJAX_FUNCTION,"mandar_geocercas");
	
	function ver_geocercas($id_geo){  //
$objResponse = new xajaxResponse();
	$cad_geo = "select g.latitud,g.longitud,g.radioMts,g.tipo,p.latitud,p.longitud,p.orden,g.nombre";
	$cad_geo .= " from geo_time g	left outer join geo_puntos p on (g.num_geo = p.id_geo)";
	$cad_geo .= " where num_geo = $id_geo";
	$res_geo = mysql_query($cad_geo);
	$num_geo = mysql_num_rows($res_geo);
		if($num_geo == 1){
			$row = mysql_fetch_row($res_geo);
			$radio = $row[2]/1000;
			$objResponse->call("mostrar_circular",$row[0],$row[1],$radio,$row[7]);
		}
	if($num_geo > 1 ){
		while($row = mysql_fetch_row($res_geo)){
			$objResponse->call("mostrar_poligonal",$row[4],$row[5],$row[6],$num_geo,$row[7]);
		}
	}
return $objResponse;
}
  
  function mandar_geocercas(){
  $objResponse = new xajaxResponse();
  $idVeh=$GLOBALS['idVeh'];
  $cad_numVeh="SELECT num_veh,id_veh FROM vehiculos v where id_veh='$idVeh'";
  $query_numVeh=mysql_query($cad_numVeh);
  $row_veh=mysql_fetch_row($query_numVeh);
  $cadGeos="select num_geo from geo_veh where num_veh=$row_veh[0]";
  $queryGeos=mysql_query($cadGeos);
  while($rowGeos=mysql_fetch_row($queryGeos)){
		$objResponse->script("xajax_ver_geocercas($rowGeos[0]);");
  }
  return $objResponse;
  
  }
  
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
  
  $xajax->ProcessRequest();  
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
function ver_geo(){
	//alert("Geocercas");
	xajax_mandar_geocercas();
}	
    </script> 
<?php 
	echo GetKey(); //imprime el API Key de google adecuado
	$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
</head>
<body id="fondo" onunload="GUnload()"  onload="ver_geo();">
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