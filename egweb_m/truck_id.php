<?
include_once('../patError/patErrorManager.php');
patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );
include_once('../patSession/patSession.php');
$options="";
$sess =& patSession::singleton('egw', 'Native', $options );
$estses = $sess->getState();
if (isset($_GET["Logout"])){
	$web = $sess->get("web");
	$sess->Destroy();
if($web == 1){
	header("Location: indexApa.php?$web");
}
else {header("Location: index.php?$web");}
}
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
	$sit = $sess->get('sit');
	$geocer = $sess->get('geo');
	$eve = $sess->get('eve');
	$evf = $sess->get('evf');
	$dis = $sess->get('dis');
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
	else header("Location: index.php?$web");      	      	
}
require("librerias/conexion.php");
require("librerias/SistemasConfigurables/Configsis_nuevo_geo.php");
require('../xajaxs/xajax_core/xajax.inc.php');
$xajax = new xajax(); 
if(preg_match('/seprosat/',curPageURL())){
	$xajax->configure('javascript URI', 'http://www.sepromex.com.mx:81/'.'xajaxs/');
}
else{
	$xajax->configure('javascript URI', '../xajaxs/');
}
$xajax->register(XAJAX_FUNCTION,"vehiculos");
$xajax->register(XAJAX_FUNCTION,"truck");
$xajax->register(XAJAX_FUNCTION,"findResponseStatus");

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
function findResponseStatus($idsistema,$idRequest,$veh){
	$objResponse = new xajaxResponse();
	$sistemas=mysql_query("SELECT veh_x1 FROM vehiculos v where v.num_veh=$veh AND v.id_sistema=$idsistema");
	$sistema=mysql_fetch_array($sistemas);
	if(preg_match("/axps/i",$sistema[0])){
		$equipoGps = CONFIGSIS::getObjectFromSistem(43);
	}
	else{
		$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	}
	//$objResponse->alert($idRequest);
	$result = $equipoGps->getStatusResponseGEO($idRequest);
	//$objResponse->alert($result);
	if( $result == "CONECTADO" ){
		$objResponse->script($equipoGps->activaConfigGEO($veh));
	}else if ( $result == "DESCONECTADO" ) {
		$objResponse->script("cancelTimerNotConectedGEO($veh)");
		$objResponse->script("setTimeout('check_online()',3000)");
	}else $objResponse->script("setUpTimerOnlineGEO($veh,'".$idRequest."')");
	return $objResponse;		
}
function vehiculos(){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$idu=$sess->get("Idu");
	$query="select v.id_veh,v.num_veh,v.id_sistema,v.VEH_X1
			from veh_usr as vu
			inner join vehiculos v on vu.num_veh = v.num_veh
			inner join estveh ev on (v.estatus = ev.estatus)
			inner join sistemas as S ON v.id_sistema=S.id_sistema
			inner join veh_accesorio a on v.num_veh=a.num_veh
			inner join cat_accesorios c on a.id_accesorio=c.id_accesorio
			where vu.id_usuario = $idu 
			and a.activo=1
			and c.activo=1
			AND ev.publicapos=1
			AND vu.activo=1
			and c.descripcion like '%Truck Connection%'
			order by v.id_veh asc";
	$rows=mysql_query($query);
	$cont= "<table id='newspaper-a1' width='175px' style='padding:0px;margin:0px;' name='checador'>
			<tr>
				<th style='font-size:14px;width:150px;'>Vehículos</th>
				<th><input type='radio' id='all_veh' onclick='check_All_veh()'></th>
			</tr>";
			$i=0;
	$int="";
	while($row=mysql_fetch_array($rows)){
		if(mysql_num_rows($rows)){
			$int=1;
		}
	
	if(preg_match("/axps/i",$row[3])){
		$equipoGps = CONFIGSIS::getObjectFromSistem(43);
	}
	else{
		$equipoGps = CONFIGSIS::getObjectFromSistem($row[2]);
	}
	$equipoGps->setNumVeh($row[1]);
	$equipoGps->createJsonFromDB();
	//$objResponse->alert($row[2]);
	$objResponse->script("setJsonObjectEquipos('".$equipoGps->getJsonString()."')");
	//$objResponse->alert($row[1]);
	$objResponse->script($equipoGps->callTimerInitGEO($idu,$row[1]));
		$cont.="<tr>
					<td colspan='2'><input type='checkbox' class='Classveh' onclick='contar$int()' id='idVeh' name='Veh".$i."' value='".$row[1]."'>"
					.$row[0]."<div id='online".$row[1]."' style='width:10px;display:inline;float:right;'></div>
					</td>
				</tr>
		";
		$i++;
	}
	$cont.= "</table>";	
		
	$objResponse->assign("vehiculos_config_geo","innerHTML",$cont);
	return $objResponse;
}
function truck(){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$idu=$sess->get("Idu");
	$query=mysql_query("select v.id_veh from veh_usr as vu
	inner join vehiculos v  on vu.num_veh=v.num_veh
	where v.tipoveh in (16,21)
	and vu.id_usuario = $idu 
	order by v.id_veh");
	while($row=mysql_fetch_array($query)){
		$cajas.="
		<tr>
			<td><input type='checkbox' id=''>$row[0]<td>
		</tr>";
	}
	$truck="
	<table id='newspaper-a1' width='175px' style='padding:0px;margin:0px;' name='checador'>
		<tr>
			<th style='font-size:14px;width:150px;'>Truck </th>
			<th><input type='checkbox' id='all_veh' onclick='check_All_veh()'></th>
		</tr>
		$cajas
	</table>";
	$objResponse->assign("geocercas_config","innerHTML",$truck);
	return $objResponse;
}
$xajax->processRequest();//procesa los datos de "xajax"
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Asignaci&oacute;n de Truck Id</title>
	<!--<link href="librerias/dsn.css" rel="stylesheet" type="text/css" />-->
	<link href="css/black.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="css/ui-darkness/jquery-ui-1.10.3.custom.css" rel="Stylesheet" />
	<script src="js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" language="javascript" src="librerias/SistemasConfigurables/func_Equipos.js"></script>
	<link href="css/mobiscroll-1.5.css" rel="stylesheet" type="text/css" />
	<script src="js/mobiscroll-1.5.js" type="text/javascript"></script>
	<script type="text/javascript" >
	var j = jQuery.noConflict();
	function calendario(id){
		j('#'+id).scroller({ preset: 'time' });
		wheels = [];
		wheels[0] = { 'Hours': {} };
		wheels[1] = { 'Minutes': {} };
		for (var i = 0; i < 60; i++) {
			if (i < 16) wheels[0]['Hours'][i] = (i < 10) ? ('0' + i) : i;
			wheels[1]['Minutes'][i] = (i < 10) ? ('0' + i) : i;
		}
	}
	function cerrar_ventana(){
		window.close();
	}
	function check_All_veh() {
		if(j("#all_veh").is(':checked')){
			j(".Classveh").prop('checked', true);
			contar();
		}
		else{
			j(".Classveh").removeAttr('checked');
			contar();
		}
	}
	function check_All_geo() {
		if(j("#all_geo").is(':checked')){
			j(".Classgeo").prop('checked', true);
			contar();
		}
		else{
			j(".Classgeo").removeAttr('checked');
			contar();
		}
	}
	function check_online(){
		var checkboxes2 = document.getElementById("form1").idVeh;
		for(var i=0; i<checkboxes2.length; i++){
			var activo=jQuery("#activo"+checkboxes2[i].value).val();
			//alert(activo);
			if(activo==0 || activo==undefined){
				jQuery(checkboxes2[i]).prop('checked', false);
				jQuery(checkboxes2[i]).prop('disabled', true);
			}
		}
		
	}
	</script>
	<script>
	window.onbeforeunload = confirmaSalida; 
	function confirmaSalida(){    
		if ($("#procesando").val()==1){
			return "Estas seguro de abandonar la pagina? Aun hay un proceso pendiente";  
		}
	}
	</script>
</head>
<body id="fondo1" onload="xajax_vehiculos();xajax_truck();" style="overflow-x:hidden;overflow-y:scroll;width:1100px;height:770px;background:url(img2/main-bkg-00.png) transparent repeat;" >
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
<div id="cuerpo_head" style='top:80px;width:1100px;height:820px;' >
	<div id='vehiculos_config_geo'></div>
	<div id='geocercas_config'></div>
	<div id='mostrar_correos_dialog' style='display:none;'></div>
	<div id='reglas' style='position:absolute;top:560px;left:210px;width:850px;overflow-y:auto;overflow-x:hidden;height:180px;'></div>
	<div id='contenido_geo_asignadas'>
	</div>
	<div id='geo_progreso' style="position:absolute;left:210px;top:300px;width:330px;height:50px;"></div>
	<input type='hidden' id='procesando' value='0'>
</div>
</form>
</div>
</center>
</div>
</div>
</div>
</body>
</html>