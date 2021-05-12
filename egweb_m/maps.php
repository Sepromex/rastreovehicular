<?php
  include('librerias/conexion.php');
  include('ObtenUrl.php');   
	include_once('../patSession/patSession.php');
  $parametros = $_GET["q"];
  $arrayParam = explode(",", $parametros);
  $num_Veh = $arrayParam[0];
  $fecha = $arrayParam[1];
  $longitud = $arrayParam[2];
  $latitud = $arrayParam[3];
  $lon = $arrayParam[2];
  $lat = $arrayParam[3];
  $regla=$arrayParam[4];
  list($padre,$hijo)=explode("-",$regla);
  $query=mysql_query("select num_geo from gpscondicionalertadet where folio=$padre and reg=$hijo");
  //echo $arrayParam[4];
  $ver_geo=mysql_fetch_array($query);
  if($ver_geo[0]>0){
	$num_geo_URL=$ver_geo[0];
  }
  else{
	$num_geo_URL=0;
  }
  
   	require('../xajaxs/xajax_core/xajax.inc.php');
	$xajax = new xajax(); 
	$xajax->configure('javascript URI', '../xajaxs/');
	$xajax->register(XAJAX_FUNCTION,"ver_geocercas");
	$xajax->register(XAJAX_FUNCTION,"mandar_geocercas");
	$xajax->register(XAJAX_FUNCTION,"verParametros");

function verParametros(){
	$objResponse = new xajaxResponse();
	$objResponse->alert(urldecode($GLOBALS['parametros']));
	return $objResponse;
	
}

function ver_geocercas($id_geo){  //
	$objResponse = new xajaxResponse();
	//$objResponse->alert();		
	include('librerias/conexion.php');
	$cad_geo = "select g.latitud,g.longitud,g.radioMts,g.tipo,p.latitud,p.longitud,p.orden,g.nombre";
	$cad_geo .= " from geo_time g left outer join geo_puntos p on g.num_geo = p.id_geo";
	$cad_geo .= " where num_geo = $id_geo";
	$res_geo = mysql_query($cad_geo);
	$num_geo = mysql_num_rows($res_geo);
	if($num_geo == 1){
		$row = mysql_fetch_row($res_geo);
		$radio = $row[2];
		$objResponse->call("mostrar_circular",$row[0],$row[1],$row[2],$row[7]);
	}
	if($num_geo > 1 ){
		$i=0;
		 $arregloLatitud=array(); $arregloLongitud=array();
		$nombre="";
		while($row = mysql_fetch_row($res_geo)){
			array_push($arregloLatitud,$row[4]);
			array_push($arregloLongitud,$row[5]);
			if($i==$num_geo-1) $nombre=$row[7];
			$i++;
		}$objResponse->call("mostrar_poligonal",$arregloLatitud,$arregloLongitud,$nombre);
	}
	
return $objResponse;
}
  
function mandar_geocercas($num_geo){
	$objResponse = new xajaxResponse();
	include('librerias/conexion.php');
	$numVeh=$GLOBALS['num_Veh'];
	$cad_numVeh="SELECT num_veh,id_veh FROM vehiculos v where num_veh='$numVeh'";
	$query_numVeh=mysql_query($cad_numVeh);
	$row_veh=mysql_fetch_row($query_numVeh);
	//$objResponse->alert($num_geo);
	if($num_geo>0){
		$objResponse->script("xajax_ver_geocercas($num_geo)");
	}
	else{
		$cadGeos="SELECT num_geo FROM gpscondicionalertadet where num_veh=$numVeh and num_geo>0 and activo=1 group by num_geo";
		$queryGeos=mysql_query($cadGeos);
		//$objResponse->alert($cadGeos);
		while($rowGeos=mysql_fetch_array($queryGeos)){
			$objResponse->script("xajax_ver_geocercas($rowGeos[0])");
		}
	}	
	if(mysql_error()){
		//$objResponse->alert(mysql_error());
	}
	return $objResponse;
}
  
  include('librerias/conexion.php');
  $query = "select tipoveh,hora,id_veh from sepromex.vehiculos where num_veh=$num_Veh";
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
  
  $newFecha = date("d-m-Y G:i:s",mktime($hora, $min, $seg,$mes, $dia, $anio)); //mktime del tiempo anterior  
  $horaN=$hora.":".$min.":".$seg;
  $newHora=date("h:i a",strtotime($horaN));
  $fechaN=$dia."-".$mes."-".$anio;
  $newFecha = date("Y-m-d G:i:s",mktime($hora+($horar), $min, $seg,$mes, $dia, $anio)); //mktime del tiempo anterior  
  $sess =& patSession::singleton('ham', 'Native', $options );
	$ide=$sess->get("Ide");
	$cad_sit = "select id_sitio,latitud,longitud,nombre from sitios where id_empresa = $ide";
	$res_sit = mysql_query($cad_sit);
	$num = mysql_num_rows($res_sit);
	if($num > 0){
		$degtorad = 0.01745329; 
		$radtodeg = 57.29577951; 
		//$resp = "Aprox. a ";
		$distancia=1000;
		while($row = mysql_fetch_array($res_sit)){
			$dlong = ($lon - $row[2]); 
			$dvalue = (sin($lat * $degtorad) * sin($row[1] * $degtorad)) + (cos($lat * $degtorad) * cos($row[1] * $degtorad) * cos($dlong * $degtorad)); 
			$dd = acos($dvalue) * $radtodeg; 
			$km = ($dd * 111.302)*1000;
			$km = number_format($km,1,'.','');
			if($distancia>$km){
				$cercano= " a ".(int)$km." Mts de ".$row[3]." ,";
				$distancia=$km;
			}
		}
	}
 	//$conec2 = @mysql_connect("10.0.1.3","egweb","53g53pr0");
	//$conec2 = @mysql_connect("localhost","usercruce","server");
	$conec2 = @mysql_connect("10.0.2.13","usercruce","server");
    //$conec2 = @mysql_connect("10.0.0.2","usercruce","server");
	if(!$conec2){
		$error=mysql_error()."error conec2";
		$cadena= $error;
	}
	else{
		mysql_select_db("crucev2", $conec2);
		/*
			obtenemos el estado/municipio del vehiculo
		*/
		$estados="SELECT nombre
		FROM `municipios`
		where Crosses(area,GeomFromText('POINT($lat $lon)')) limit 1";
		$est=mysql_query($estados);
		$estado=mysql_fetch_array($est);
		$estado=$estado[0];
		list($mun,$est)=explode("(",$estado);
		$estadoy=str_replace("(","",$est);
		$esta=str_replace(")","",$estadoy);
		$w=strtolower($mun);
		$y=strtolower($esta);
		$estado=ucwords($w)." (".ucwords($y).")";
		/*
			procedure
		*/
		$procedure="SELECT
		  cast(e.idesquina as char(20)) AS ID,
		  ca.nombre as NOM,
		  (GLength(LineString((PointFromWKB( POINT($lat, $lon))), (PointFromWKB(POINT(X(e.Coordenadas),Y(e.Coordenadas) ) ))))) * 100 AS DIST
		FROM esquinas e
		  inner join calles_esquinas ce on e.idesquina=ce.idesquina
		  inner join calles ca on ce.idcalle=ca.idcalle
		where MBRContains(GeomFromText(
						concat('Polygon((',
										  $lat+0.01001,' ',$lon-0.01001,', ',
										  $lat+0.01001,' ',$lon+0.01001,', ',
										  $lat-0.01001,' ',$lon-0.01001,', ',
										  $lat-0.01001,' ',$lon+0.01001,', ',
										  $lat+0.01001,' ',$lon-0.01001,'))')),coordenadas)
		ORDER BY DIST ASC limit 4;";
		$r=mysql_query($procedure);
		$calle="";
		$distancia=99999;
		$dist=0;
		while($calles=mysql_fetch_array($r)){
			if($calles['DIST']<=$distancia){
				if($dist<=1){
					if($calle!=''){
						if($calles['NOM'][0]=="I" || ($calles['NOM'][0].$calles['NOM'][1]=='Hi'))
						{
							$calle.=' e ';
						}
						else{
							$calle.=' y ';
						}
					}
					$calle.=$calles['NOM'];
					$dist++;
				}
				
				$distancia=$calles['DIST'];
			}
		}
		/*
			Calculamos el sitio cercano a nuestro vehiculo
		*/
		mysql_close();
		
		
		$calle=strtolower($calle);
		$municipio=strtolower($municipio);
		$cadena=utf8_encode(ucwords($calle).",".ucwords($cercano).$estado);
	}
  $xajax->ProcessRequest();  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
	<title>EGWEB 5.0</title>
	<link href="css/black.css" rel="stylesheet" type="text/css" />
	<link href="librerias/default.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="librerias/tabla/tabla.css" type="text/css" media="screen">
	<script type='text/javascript' src="librerias/funciones.js"></script>
	<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&;amp;language=es"></script>-->
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>-->
	<script type="text/javascript"src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbr1ZoDby1GW6nP7RAgokJLqWP_95d6SE" ></script>	
    <script type='text/javascript' src="librerias/jquery.js"></script>
	<script type="text/javascript" src="librerias/func_principalp1.js"></script>
    <script type="text/javascript" >
var j = jQuery.noConflict();

j(document).ready(function(){
    load();
    cargaPosicion();	
});	

function cargaPosicion()
{
	MapaCord(<?php echo $latitud; ?>, <?php echo $longitud;?>, <?php echo $tipo; ?>);
	if(j("#cruce").html()==', ()'){
		showAddressByLatLng(<?php echo $latitud; ?>,<?php echo $longitud; ?>);
		//var result=http://maps.googleapis.com/maps/api/geocode/json?latlng=<?php echo $latitud; ?>,<?php echo $longitud; ?>&sensor=true_or_false
	}
	if(j("#cruce").html()=='error conec2'){
		j("#cruce").html("Hubo un error con nuestro servidor, vuelva a cargar la página");
	}
}
var geocoder;
function showAddressByLatLng(lat,lng){	
	//alert(lat+"--" + lng);
	geocoder = new google.maps.Geocoder();
	var latlng = new google.maps.LatLng(lat, lng);
  geocoder.geocode({'latLng': latlng}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[1]) {
        //map.setZoom(15);
		document.getElementById("cruce").innerHTML=results[0].formatted_address;
      } else {
        document.getElementById("cruce").innerHTML="Lo sentimos, no se ha encontrado su direcci&oacute;n."
      }
    } else {
      alert('Geocoder failed due to: ' + status);
    }
  });


} 

function addressByLatLng(response)
{
  if (!response || response.Status.code != 200) {  
    document.getElementById("cruce").innerHTML ="Lo sentimos, no se ha encontrado su direcci&ocute;n";  
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
function ver_geo(num_geo){
	xajax_mandar_geocercas(num_geo);
}	
    </script> 
<?php 
	
	$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
</head>
<body id="fondo" onload="ver_geo(<? echo $num_geo_URL;?>);" style='overflow:auto;'> <!--     -->
<center>

<div id="fondo1" style='height:100%;'>
<div id="fondo2" style='height:100%;'>
<div id="fondo3" style='height:100%;'>

    <div id="cuerpo_head" >
		<div >
		<div id="logo" style='position:absolute;left:7px;z-index:10;'><img src='img2/logo1.png'></div><!--Nos muestra el logo de la pagina "oficial"-->
		<div id="panel2" style='left:100px;top:585px;'>
			<table id='box-table-a1' style='width:1150px;'>
				<tr><td style='width:100px;'><b>Veh&iacute;culo</b></td><td><?php echo $row[2];?></td></tr>
				<tr><td><b>Fecha:</b></td><td><?php  echo $fechaN; echo " ".$newHora;?></td></tr>
				<tr><td><b>Ubicacion:</b></td><td id="cruce"><? echo $cadena;?></td></tr>
				<!--<tr><td><b>Fecha:</b></td><td><?php  echo $newFecha;?></td><td><b>Ubicacion:</b></td><td id="cruce"></td></tr>-->
				<tr><td><b>Latitud:</b></td><td colspan="3"><?php  echo $latitud;?></td></tr>
				<tr><td><b>Longitud:</b></td><td colspan="3"><?php  echo $longitud;?></td></tr>
			</table>
		</div>
		<div id="cont_mapa2" style='position:absolute;top:115px;left:100px;height:470px;width:1150px;'></div>
		<div id="cont_mapa_sepro" style='position:absolute;top:115px;left:100px;height:470px;width:1150px;'></div>
	  </div>
  </div>
<div id="cuerpo_medio"></div>
<div id="cuerpo_button">
<div id="contacto_ind" style="left:92px;">Contactenos al Teléfono 38255200 ext. 104 o envíe un email a 
<a href="mailto:monitoreo_gps@sepromex.com.mx">monitoreo_gps@sepromex.com.mx</a></div>
</div>
</div>
</div>
</div>
</center>
</body>
</html>