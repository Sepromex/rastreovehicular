<?
	require('../xajaxs/xajax_core/xajax.inc.php');
	require("librerias/conexion.php");
	$xajax = new xajax(); 
	$xajax->configure('javascript URI', '../xajaxs/');
	$xajax->register(XAJAX_FUNCTION,"mostrar");
	function mostrar(){
		 $arregloLatitud=array(); 
		 $arregloLongitud=array();
		$objResponse = new xajaxResponse();
		$num_geo=$_GET['geo'];
		if($num_geo>0){
			$query="SELECT g.num_geo,g.nombre,g.tipo,g.latitud,g.longitud,t.descripcion,g.radioMts
					FROM geo_time g
					INNER JOIN tipo_geocerca t on g.tipo=t.tipo
					WHERE g.num_geo = $num_geo";
			//echo  nl2br($query);
			$rows=mysql_query($query);
			$row=mysql_fetch_array($rows);
			if($row[2]==1){
				$query="SELECT g.num_geo,g.nombre,p.latitud,p.longitud
					FROM geo_time g
					left outer join geo_puntos p on (g.num_geo = p.id_geo)
					where g.num_geo=".$num_geo."
					ORDER BY p.orden DESC";
				//echo  nl2br($query);
				$rows=mysql_query($query);
				$i=0;
				while($rw=mysql_fetch_array($rows)){
					array_push($arregloLatitud,$rw[2]);
					array_push($arregloLongitud,$rw[3]);
					if($i<mysql_num_rows($rows)-1){
						$nombre=$rw[1];
					}
					$i++;
				}
				//$objResponse->call("load");
				$objResponse->call("mostrar_poligonal",$arregloLatitud,$arregloLongitud,$nombre);
				$objResponse->call("veh_seleccion",$arregloLatitud[0],$arregloLongitud[0]);
			}
			else{
				//$objResponse->call("load");
				$objResponse->call("mostrar_circular",$row[3],$row[4],$row[6],$row[1]);
				$objResponse->call("veh_seleccion",$arregloLatitud[0],$arregloLongitud[0]);
				//mostrar_circular(latit,longi,radio,nombre)
			}
		}
		if($num_geo==-1){
				$objResponse->script("window.close()");
		}
	return $objResponse;
	}
	
$xajax->processRequest();//procesa los datos de "xajax"
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
<!DOCTYPE html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>Ver Geocercas</title>
<link href="css/black.css" rel="stylesheet" type="text/css" />
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>-->
<script type="text/javascript"src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbr1ZoDby1GW6nP7RAgokJLqWP_95d6SE" ></script>
<script src="js/geo_admin.js"></script>
</head>
<body id="fondo" onload="load2();xajax_mostrar();" style="overflow:hidden;">
<!--<div id="logo"></div><!--Nos muestra el logo de la pagina "oficial"-->
<!-- Estos divs son para el fondo-->
<div id="fondo1" >
<div id="fondo2">
<div id="fondo3">
<center>
<form id="form1"  name="form1" action="#" method="post">
	<div id='contenido_geo2'></div>
</form>
</center>
</div>
</div>
</div>
</body>
</html>