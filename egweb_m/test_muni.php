<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

  include('conn.php');
  include('ObtenUrl.php');
  include('../adodb/adodb.inc.php');
  require_once('../FirePHPCore/FirePHP.class.php'); // Clase FirePhp para hace debug con Firebug 
  include_once('../patError/patErrorManager.php');
  patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
  patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
  patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );
  include_once('../patSession/patSession.php');
  $sess =& patSession::singleton('egw', 'Native', $options );
  $web = $sess->get("web");
  $estses = $sess->getState();
  /*
  if (isset($_GET["Logout"])){
    $web = $sess->get("web");
	$sess->Destroy();
	if($web == 1)
		header("Location: indexApa.php?$web");
	else header("Location: index.php?$web");
  }
  */
  if ($estses == empty_referer) {
    if($web == 1)
		header("Location: indexApa.php?$web");
	else header("Location: index.php?$web");		
  } 

  $result = $sess->get( 'expire-test' );
  if((!patErrorManager::isError($result)) && ($sess->get('Idu'))) 
  {
		$queryString = $sess->getQueryString();	
		$idu = $sess->get("Idu");
		$ide = $sess->get("Ide");
    	$usn = $sess->get("Usn");
		$pol = $sess->get("Pol");
		$reg = $sess->get('Registrado');
		$nom = $sess->get('nom');
		$prm = $sess->get("per");
		$est = $sess->get('sta');
		//$sit = $sess->get('sit');
		//$geocer = $sess->get('geo');
		$eve = $sess->get('eve');
		$evf = $sess->get('evf');
		$dis = $sess->get('dis');
		$sess->set('pan',1);//siempre activados
		$pan = $sess->get('pan');
		$veh_actual = $sess->get('veh');
		if(!$reg)
			$sess->set('Registrado',1);
  }
  else{
	    $web = $sess->get("web"); 
		$sess->Destroy();
		if($web == 1 )
			header("Location: indexApa.php?$web");
		else header("Location: index.php?$web");      	 //caduca la session     	
   }          
//se registran variables
	require("librerias/conexion.php");
  	require('../xajaxs/xajax_core/xajax.inc.php');
	$xajax = new xajax(); 
	$xajax->configure('javascript URI', '../xajaxs/');
	$xajax->register(XAJAX_FUNCTION,'otro_server');

function otro_server(){
	$objResponse = new xajaxResponse();
	//$conec2 = @mysql_connect("localhost","root","admin");
	//$conec2 = @mysql_connect("localhost","usercruce","server");
	$conec2 = @mysql_connect("10.0.2.13","usercruce","server");
	//$conec2 = @mysql_connect("localhost:3306","usercruce","server");
	if(!$conec2){
		//$error=mysql_error()."error conec2";
		return $error;
	}
	else{
		mysql_select_db("crucev2", $conec2);
		/*
			obtenemos el estado/municipio del vehiculo
		*/
		$estados="SELECT nombre,astext(area)
		FROM `municipios`
		where idmunicipio in(557,572,578)";//zapopan, guadalajara, tlaquepaque
		$est=mysql_query($estados);
		
		while($estado=mysql_fetch_array($est)){
			$arregloLatitud=array(); 
			$arregloLongitud=array();
			$nombre=$estado[0];
			$cadena=$estado[1];
			$cad=str_replace("POLYGON((","",$cadena);
			$cad1=str_replace("))","",$cad);
			$coordenadas=explode(",",$cad1);
			for($i=0;$i<count($coordenadas);$i++){
				list($lat,$lon)=explode(" ",$coordenadas[$i]);
				array_push($arregloLatitud,$lat);
				array_push($arregloLongitud,$lon);
			}
			$objResponse->call("mostrar_poligonal_reporte",$arregloLatitud,$arregloLongitud,$nombre);
		}
	}
	return $objResponse;
}
$xajax->ProcessRequest();  
$xajax->printJavascript();
?>
<link href="css/black.css" rel="stylesheet" type="text/css" />
<link href="css/black.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="css/ui-darkness/jquery-ui-1.10.3.custom.css" rel="Stylesheet" />
	<script src="js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>	
	<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>-->
	<script type="text/javascript"src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbr1ZoDby1GW6nP7RAgokJLqWP_95d6SE" ></script>	
	<script type="text/javascript" src="librerias/func_principal.js"></script>
<body id="fondo1" onload="load();xajax_otro_server();" style="overflow-x:hidden;width:1100px;background:url(img2/main-bkg-00.png) transparent repeat;">
<!--<div id="logo"></div><!--Nos muestra el logo de la pagina "oficial"-->
<!-- Estos divs son para el fondo-->
<div id="fondo1" style="overflow:hidden;width:1100px;">
<div id="fondo2" style="overflow:hidden;width:1100px;">
<div id="fondo3" style="overflow:hidden;width:1100px;">
<center>
<div id="cuerpo2" width="225" height="156">
	<div id="cuerpoSuphead" style="width:1100px;">
	<div id="logo" style='position:absolute;z-index:10;top:0px;left:10px;'><img src='img2/logo1.png'></div><!--Nos muestra el logo de la pagina "oficial"-->
	</div>
<form id="form1"  name="form1" action="g_config.php" method="post">
<div id="cuerpo_head"style='top:80px;width:1100px;height:820px;' >
	<div id='vehiculos_config_geo'></div>
	<div id='geocercas_config'></div>
	<div id='mostrar_correos_dialog' style='display:none;'></div>
	 <div id="cont_mapa" style='position:absolute;top:0px;left:100px;width:1050px;height:700px'></div>
	<div id='reglas' style='position:absolute;top:560px;left:210px;width:850px;overflow-y:auto;overflow-x:hidden;height:180px;'></div>
	<div id='contenido_geo_asignadas'>
		<?
		if(isset($_GET['g'])){
			switch($_GET['g']){
				case 'a':
					$mensaje="Se actualizo correctamente sus registros";
					break;
				case 'f':
					$mensaje="Se creo su nueva configuracion";
					break;
				case 'r':
					$mensaje="Se agrego una nueva regla";
					break;
			}
			echo $mensaje;
		}?>
	</div>
</div>
</form>
</div>
</center>
</div>
</div>
</div>
</body>
</html>