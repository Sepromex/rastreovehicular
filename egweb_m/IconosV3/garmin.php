<?
include_once('../patSession/patSession.php');
$options="";
$sess =& patSession::singleton('egw', 'Native', $options );
require("librerias/conexion.php");
require("librerias/SistemasConfigurables/Configsis_nuevo.php");
require('../xajaxs/xajax_core/xajax.inc.php');
$xajax = new xajax(); 
if(preg_match('/seprosat/',curPageURL())){
	$xajax->configure('javascript URI', 'http://www.sepromex.com.mx:81/'.'xajaxs/');
}
else{
	$xajax->configure('javascript URI', '../xajaxs/');
}
$xajax->register(XAJAX_FUNCTION,"vehiculos");
$xajax->register(XAJAX_FUNCTION,"auditabilidad");
$xajax->register(XAJAX_FUNCTION,"findResponseStatus");
$xajax->register(XAJAX_FUNCTION,"sendRequest");
$xajax->register(XAJAX_FUNCTION,"findGeneralResponse");
$xajax->register(XAJAX_FUNCTION,"mostrar_config");
$xajax->register(XAJAX_FUNCTION,"garmin");
$xajax->register(XAJAX_FUNCTION,"ubicacion");
$xajax->register(XAJAX_FUNCTION,"enviados");
$xajax->register(XAJAX_FUNCTION,"borra_garmin");
$xajax->register(XAJAX_FUNCTION,"reporte");
$xajax->register(XAJAX_FUNCTION,"procesa_reporte");

function findResponseStatus($idsistema,$idRequest,$veh){
	$objResponse = new xajaxResponse();
	$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	//$objResponse->alert($idRequest);
	$result = $equipoGps->getStatusResponse($idRequest);
	//$objResponse->alert($result);
	if($idsistema==23 || $idsistema==26){
		$result="CONECTADO";
	}
	if( $result == "CONECTADO" ){
		$objResponse->script($equipoGps->activaConfig($veh));
	}
	else if ( $result == "DESCONECTADO" ) {
		$objResponse->script("cancelTimerNotConected($veh)");
		$objResponse->script("$('.links').attr('onclick','alert(\"Su vehiculo esta OFFLINE\")');");
	}
	else {
		$objResponse->script("setUpTimerOnline($veh,'".$idRequest."')");
	}
	return $objResponse;		
}
function sendRequest($idsistema,$numveh,$jsonString,$request,$datos){
	$objResponse = new xajaxResponse();
	$options="";
    $sess =& patSession::singleton('egw', 'Native', $options );
	$sistemas=mysql_query("SELECT veh_x1 FROM vehiculos v where v.num_veh=$numveh AND v.id_sistema=$idsistema");
	$sistema=mysql_fetch_array($sistemas);
	if(preg_match("/axps/i",$sistema[0])){
		$equipoGps = CONFIGSIS::getObjectFromSistem(43);
	}
	else{
		$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	}
	$equipoGps->setNumVeh($numveh);
	$equipoGps->sendRequest(trim($jsonString),trim($request),$sess->get("Idu"),trim($datos));
	$sess->set("ACTIVO",trim($jsonString));
	$objResponse->script($equipoGps->callGeneralTimer($request));
	//$objResponse->alert($jsonString."**".$request."--".getIdUsuario()."&&".$datos);
	return $objResponse;		
}
function findGeneralResponse($idsistema,$idRequest,$request){
	$options="";
    $sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	//$objResponse->alert($idRequest."////".$request." @ ".$idsistema);
	$query = "select num_veh from notificaweb where id = $idRequest";
	$ve=mysql_query($query);
	$veh=mysql_fetch_array($ve);
	$sistemas=mysql_query("SELECT veh_x1 FROM vehiculos v where v.num_veh=$veh[0] AND v.id_sistema=$idsistema");
	$sistema=mysql_fetch_array($sistemas);
	if(preg_match("/axps/i",$sistema[0])){
		$equipoGps = CONFIGSIS::getObjectFromSistem(43);
	}
	else{
		$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	}
	$result = $equipoGps->getGeneralResponse($idRequest,$request);
	if ( $result == "Response" ){
		$objResponse->script($equipoGps->noticeResponse($request));
	}else if ( $result == "CancelTimer" ){
		$objResponse->script($equipoGps->cancelGeneralTimer($request));
		$objResponse->script("$('.links').attr('onclick','alert(\"Su vehiculo esta OFFLINE\")');");
	}else if($result == null){
		$objResponse->script($equipoGps->goGeneralTimer($request));
	}
	return $objResponse;
}
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
function auditabilidad($accion,$veh){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('ham', 'Native', $options );
	$idu = $sess->get("Idu");
	$app=13;
	$query=mysql_query("select detalle from sepromex.catalogo_auditabilidad where id_app=$app and accion=".$accion);
	$detalles=mysql_fetch_array($query);
	$detalle=$detalles[0];
	$empresa=$sess->get("Ide");
	$consulta = "insert into sepromex.auditabilidad values (0,$idu,'".date("Y-m-d H:i:s")."',$accion,'$veh: $detalle',
	$app,$empresa,'".get_real_ip()."')";
	mysql_query($consulta);
	mysql_close($conec);
	return $objResponse;
}
function ubicacion($veh){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu=$sess->get("Idu");
	$ide=$sess->get("Ide");
	$ubi=mysql_query("select (u.lat/3600/16),((u.long & 8388607)/3600/12*-1),v.tipoveh 
	from ultimapos u
	inner join vehiculos v on u.num_veh=v.num_veh
	where u.num_veh=$veh");
	$dat=mysql_fetch_array($ubi);
	$objResponse->script("load(".$dat[0].",".$dat[1].")");
	$objResponse->script("setTimeout('MapaCord(\"".$dat[0]."\",\"".$dat[1]."\",".$dat[2].")',3000)");
	$objResponse->script("google.maps.event.clearListeners(map, 'click')");
	$objResponse->script("google.maps.event.addListener(map, 'click', function(event){
		addMarker(event.latLng,event.latLng.lat(),event.latLng.lng(),$veh,'');});");
	return $objResponse;
}
function enviados($veh){
	$objResponse = new xajaxResponse();
	$options="";
    $sess =& patSession::singleton('egw', 'Native', $options );
	$query=mysql_query("select * from veh_garminstop where num_veh=$veh and fechaenviado>'".date("Y-m-d 00:00:00")."'");
	while($row=mysql_fetch_array($query)){
		$sit=mysql_query("SELECT nombre from sitios where id_sitio=".$row[1]);
		$sitio=mysql_fetch_array($sit);
		$puntos_garmin.="
			<tr>
				<td>$sitio[0]</td>
				<td>$row[2]</td>
				<td>$row[3]</td>
				<td>$row[4]</td>
			</tr>
		";
	}
	$tabla="
	<table id='newspaper-a1'>
		<tr>
			<th>Sitio</th>
			<th>Mensaje</th>
			<th>Enviado</th>
			<th>Estatus</th>
		</tr>
		$puntos_garmin
	</table>";
	$objResponse->assign("tabs-3","innerHTML",$tabla);
	return $objResponse;
}
function borra_garmin($veh,$id){
	
}
function vehiculos(){
	$objResponse = new xajaxResponse();
	$options="";
    $sess =& patSession::singleton('egw', 'Native', $options );
	$idu=$sess->get("Idu");
	$query="select DISTINCT(v.id_veh),v.num_veh,v.id_sistema,s.tipo_equipo
			from veh_usr as vu
			inner join vehiculos v on vu.num_veh = v.num_veh
			inner join estveh ev on v.estatus = ev.estatus
			inner join sistemas S ON v.id_sistema=S.id_sistema
			inner join veh_accesorio a on a.num_veh=vu.num_veh
			inner join cat_accesorios c on c.id_accesorio=a.id_accesorio			
			where vu.id_usuario = $idu 
			AND ev.publicapos=1
			and a.activo=1
			and vu.activo=1
			and c.clave like '%garmin%'
			order by v.id_veh asc";
	$rows=mysql_query($query);
	$cont= "<table id='newspaper-a1' width='175px' style='padding:0px;margin:0px;' name='checador'>
			<tr>
				<th colspan='1' style='font-size:14px;width:150px;'>Vehiculo</th>
				<th></th>
			</tr>";
			$i=0;
	$int="";
	while($row=mysql_fetch_array($rows)){
		if(mysql_num_rows($rows)==1){
			$int=1;
		}
		$cont.="<tr>
					<td colspan='2'><input onclick='mostrar(".$row[2].",\"".$row[0]."\",".$row[1].",\"".$row[3]."\");' type='radio' name='vehiculo[]' value='".$row[1]."'>".$row[0]."</td>
				</tr>";
		$i++;
	}
	$cont.= "</table>";	
	$objResponse->assign("vehiculos_alertas_todas","innerHTML",$cont);
return $objResponse;
}
function mostrar_config($idsistema,$idVeh,$veh,$tipo){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$sistemas=mysql_query("SELECT veh_x1 FROM vehiculos v where v.num_veh=$veh AND v.id_sistema=$idsistema");
	$sistema=mysql_fetch_array($sistemas);
	if(preg_match("/axps/i",$sistema[0])){
		$equipoGps = CONFIGSIS::getObjectFromSistem(43);
	}
	else{
		$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	}
	$equipoGps->setNumVeh($veh);
	$equipoGps->createJsonFromDB();
	$objResponse->script("setJsonObjectEquipos('".$equipoGps->getJsonString()."')");
	$objResponse->script($equipoGps->callTimerInit($sess->get('Idu'),$veh));
	$sitios=mysql_query("select s.nombre,s.latitud,s.longitud,s.contacto,s.tel1,s.tel2,t.descripcion,s.id_sitio 
				from sitios s 
				left outer join tipo_sitios t on (t.id_tipo = s.id_tipo) 
				where s.id_empresa = ".$sess->get("Ide")." 
				and s.activo=1
				order by s.nombre ASC");
	$tabla_sitios .= "
	<table width='765px' border='0' id='newspaper-a1'>
	<tr>
		<th width='130px'>Nombre</th>
		<th  width='120px'>Tipo</th>
		<th width='120px'>Lat</th>
		<th width='120px'>Long</th>
		<th width='120px'></th>
	</tr>";
	//$tabla_sitios .="<div style='position:absolute;top:20px;width:865px;height:200px;overflow:auto;'><table width='845' border='0'>";
	while($fila = mysql_fetch_array($sitios)){
		$tabla_sitios .="
		<tr>
			<td width='130px'><a href='#' onclick='ubi_sitio(\"$fila[1]\",\"$fila[2]\",\"$fila[0]\")'>$fila[0]<a/></td>
			<td width='120px'>".htmlentities($fila[6])."</td>
			<td width='120px'>".number_format($fila[1],6,'.','')."</td>
			<td width='120px'>".number_format($fila[2],6,'.','')."</td>
			<td width='120px'><input type='button' value='Enviar' class='guardar1' onclick='abre_msj(\"$fila[1]\",\"$fila[2]\",$veh,$fila[7])'></td>
		</tr>";
	}
	$tabla_sitios .= "</table>";
	$objResponse->assign('tabs-1','innerHTML',$tabla_sitios);
	$objResponse->script("$('#tabs').show()");
	$objResponse->assign("config_equipo","innerHTML",$cont);
	return $objResponse;
}
function garmin($la,$lo,$veh,$msj,$sitio){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	//return $objResponse;
	if($sitio==0){
		$t_gar=mysql_query("SELECT nombre from sitios where nombre like 'Stop Garmin%' and id_empresa=".$sess->get("Ide")." and activo=1");
		$n_sitio="Stop Garmin ".mysql_num_rows($t_gar);
		mysql_query("insert into sitios(id_tipo,nombre,latitud,longitud,id_empresa,activo)
		values(34,'$n_sitio','$la','$lo',".$sess->get('Ide').",1)");
		$sitio=mysql_insert_id();
	}
	else{
		$t_gar=mysql_query("SELECT nombre from sitios where id_sitio=$sitio");
		$nombre=mysql_fetch_array($t_gar);
		$n_sitio=$nombre[0];
	}
	$ipserver='10.0.2.8';//define(IP_EGSERVER,);//server de pruebas (maquina de ricardo)
	$puerto=6678;//define(PORT_EGSERVER,'6668');// Constante PORT_EGSERVER, el puerto del servidor EgServer
	$cmd="GARMINSTOP:".$veh.";%s;1;".trim($la).";".trim($lo).";".addslashes(trim($n_sitio." ".$msj));
	mysql_query("insert into notificaweb(id,num_veh,cmd,solicito,id_usuario,origen,respuesta) 
	values(0,$veh,'$cmd','".date("Y-m-d G:i:s")."',".$sess->get("Idu").",'EGW','')");		
	$idRequest=mysql_insert_id();
	$cmd = sprintf($cmd,$idRequest);
	$socket = socket_create(AF_INET, SOCK_DGRAM, 0);
	$conectado = socket_connect($socket, $ipserver, $puerto);//$ipcerebro	
	if ($conectado) {
		$package = $cmd;
		socket_send($socket, $package, strlen($package), 0);		
		socket_close($socket);	
		//$objResponse->alert("si conecto");
	}
	else{
		//$objResponse->alert("No conecto");
	}
	$incrementable=mysql_query("select * from veh_garminmsg where num_veh=$veh");
	$inc=mysql_fetch_array($incrementable);
	mysql_query("INSERT INTO veh_garminstop(num_veh,id_sitio,notas,fechaenviado,garminid) 
				values($veh,$sitio,'$n_sitio $msj','".date("Y-m-d H:i:s")."',".($inc[1]+1).")");
	return $objResponse;
}
function reporte(){
	$objResponse = new xajaxResponse();
	$form="
	<table width='300' border='0' cellpadding='0' cellspacing='1' id='box-table-a1'>
		<tr>
			<td width='170'>Fecha inicio:</td>
			<td width='160'>
				<label>
					<input name='fecha_ini' id='fecha_ini' 
					style='position: relative; z-index: 10;' 
					size='15' value='".date("Y-m-d")." 00:00:00'/>
				</label>
			</td>
		</tr>
		<tr>
			<td>Fecha fin:</td>
			<td>
				<label>
					<input name='fecha_fin' type='text' 
					style='position: relative; z-index: 10;' 
					id='fecha_fin' size='15' value='".date("Y-m-d H:i:s")."'/>
				</label>
			</td>
		</tr>
		<tr>
			<td colspan='2'>
				<input type='button' class='agregar1' value='Reporte' onclick='procesar()'>
			</td>
		</tr>
	</table>
	";
	$objResponse->assign("formulario","innerHTML",$form);
	$objResponse->script("load_mapa_reporte()");
	return $objResponse;
}
function procesa_reporte($veh,$ini,$fin){
	$objResponse = new xajaxResponse();
	$tabla="
	<div style='height:205px;overflow:auto;'>
	<table id='box-table-a1' width='790px'>
		<tr>
			<th>Sitio</th>
			<th>Fecha envio</th>
			<th></th>
		</tr>
	</table>
	</div>";
	$objResponse->assign("recorrido","innerHTML",$tabla);
	return $objResponse;
}
$xajax->processRequest();  //procesa los datos de "xajax"
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Garmin</title>
	<link href="css/black.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="javascript" src="librerias/SistemasConfigurables/func_Equipos.js"></script>
	<script type="text/javascript" src="jQuery1.9/js/jquery-1.8.2.js"></script>
	<link rel="shortcut icon" href="img2/favicon.png" type="image/png">
	<link href="principal/css/ui-darkness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="principal/js/jquery-ui-1.10.3.custom.js"></script>
	<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>-->
	<script type="text/javascript"src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbr1ZoDby1GW6nP7RAgokJLqWP_95d6SE" ></script>
	<script type="text/javascript" src="js/garmin.js"></script>
	<style>
		#tabs .ui-widget-header{border: 0px solid #333333;background: none;color: #ffffff;font-weight: bold;}
		#tabs .ui-tabs {border: 0px;}
		.ui-widget-content {border: 0px ;background: none;color: #ffffff;}
		#config_equipo #newspaper-a1 tbody tr:hover td{background: none;}
		#config_equipo a:hover{color: #ffffff;}
	</style>
</head>
<body onload="xajax_vehiculos();" id="fondo"style="overflow:hidden;width:1100px;background:url(img2/main-bkg-00.png) transparent repeat;">
<center>
<div id="fondo1" style="overflow:hidden;width:1200px;height:730px;">
	<div id="fondo2" style="overflow:hidden;width:1200px;height:730px;">
		<div id="fondo3" style="overflow:hidden;width:1200px;height:730px;">
			<div id="cuerpo2" width="225" height="156">
				<div id="cuerpoSuphead" style="width:1200px;">
					<div id="logo"><img src='img2/logo1.png'></div><!--Nos muestra el logo de la pagina "oficial"-->
				</div>
				<div id="cuerpo_head" style='top:80px;width:1200px;height:500px;' >
				<div id='vehiculos_alertas_todas'></div>
				<div id='onlineAviso' style='text-align:left;position:absolute;left:220px;top:0px;'></div>
				<div id="config_equipo" style="width:850px;"></div>
				<div id="tabs" style='font-size:12px;width:810px;position:absolute;top:30px;left:220px;height:32px;display:none;'>
					<ul>
						<li id='t1'><a href="#tabs-1" onclick="vehiculos();">Mis sitios</a></li>
						<li id='t2'><a href="#tabs-2" onclick="ubicacion();">Mapa</a></li>
						<li id='t3'><a href="#tabs-3" onclick="enviados()">Enviados hoy</a></li>
						<li id='t4'><a href="#tabs-4" onclick="get_reporte()">Reporte</a></li>
					</ul>
					<div id="tabs-1" style='padding:0;position:absolute;top:40px;left:5px;max-height:400px;overflow:auto;'></div>
					<div id="tabs-2" style='padding:0;position:absolute;top:40px;left:5px;height:490px;width:800px;'></div>
					<div id="tabs-3" style='padding:0;position:absolute;top:40px;left:5px;'></div>
					<div id="tabs-4" style='padding:0;position:absolute;top:40px;left:5px;'>
						<div id='formulario'></div>
						<div id='mapa_recorrido' style="position:absolute;left:310px;top:0px;height:300px;width:480px;"></div>
						<div id='recorrido' style="position:absolute;top:305px;left:left:0px;"></div>
					</div>
				</div>
				<div id='msj-garmin' style='background: #000000 url(images/ui-bg_inset-soft_25_000000_1x100.png) 50% bottom repeat-x;'>
					Mensaje:<br><textarea id='msj' maxlength="200" cols='28' rows='6'></textarea>
					<input type='hidden' id='la' value=''>
					<input type='hidden' id='lo' value=''>
					<input type='hidden' id='veh' value=''>
					<input type='hidden' id='id_sitio' value=''>
					<br>
					<input type="button" value='Enviar' class='guardar1' onclick='msj_envia()'>
				</div>
				<div id='map_sitio' style='background: #000000 url(images/ui-bg_inset-soft_25_000000_1x100.png) 50% bottom repeat-x;'></div>
				</div>
			</div>
		</div>
	</div>
</div>