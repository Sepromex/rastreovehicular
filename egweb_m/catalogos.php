<?php
include_once('../patError/patErrorManager.php');
include_once('../patSession/patSession.php');
patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );

$options="";
$sess =& patSession::singleton('egw', 'Native', $options );
$estses = $sess->getState();
if (isset($_GET["Logout"])){
	$web = $sess->get("web");
	$sess->Destroy();
	if($web == 1)
		header("Location: indexApa.php?$web");
	else header("Location: index.php?$web");
}
if ($estses == '') {
	if($web == 1)
		header("Location: indexApa.php?$web");
	else header("Location: index.php?$web");
}

$result = $sess->get( 'expire-test' );
if ((!patErrorManager::isError($result)) && ($sess->get('Idu'))){
	$queryString = $sess->getQueryString();	
	$idu = $sess->get("Idu");
	$ide = $sess->get("Ide");
	$usn = $sess->get("Usn");
	$pol = $sess->get("Pol");
	$reg = $sess->get('Registrado');
	$nom = $sess->get('nom');
	$est = $sess->get('sta');
	$prm = $sess->get('per');
	$eve = $sess->get('eve');
	$dis = $sess->get('dis');
	$pan = $sess->get('pan');
	if(!$reg)
		$sess->set('Registrado',1);
}else{
    $web = $sess->get("web"); 
	$sess->Destroy();
	if($web == 1 )
		header("Location: indexApa.php?$web");
	else header("Location: index.php?$web"); 
}

require("librerias/conexion.php");
require("librerias/SistemasConfigurables/Configsis_nuevo.php");
require('../xajaxs/xajax_core/xajax.inc.php');
$xajax = new xajax(); 
$xajax->register(XAJAX_FUNCTION,"findResponseStatus");
if(preg_match('/seprosat/',curPageURL())){
$xajax->configure('javascript URI', 'http://www.sepromex.com.mx:81/'.'xajaxs/');
}
else{
$xajax->configure('javascript URI', '../xajaxs/');
}
$xajax->register(XAJAX_FUNCTION,"catalogo_sitios");
$xajax->register(XAJAX_FUNCTION,"Eliminar_sitio");
$xajax->register(XAJAX_FUNCTION,"modificar_sitio");
$xajax->register(XAJAX_FUNCTION,"update_sitio");
$xajax->register(XAJAX_FUNCTION,"crear_categoria");
$xajax->register(XAJAX_FUNCTION,"guardarDatos");
$xajax->register(XAJAX_FUNCTION,"eliminar_geocerca");
$xajax->register(XAJAX_FUNCTION,"detallar_datos");
$xajax->register(XAJAX_FUNCTION,"desasignar");
$xajax->register(XAJAX_FUNCTION,"eliminaUsr");
$xajax->register(XAJAX_FUNCTION,"crearInterUsr");
$xajax->register(XAJAX_FUNCTION,"generaUsr");
$xajax->register(XAJAX_FUNCTION,"crearInterUsrMod");
$xajax->register(XAJAX_FUNCTION,"modificaUsr");
$xajax->register(XAJAX_FUNCTION,"delCont");
$xajax->register(XAJAX_FUNCTION,"modEmpresa");
$xajax->register(XAJAX_FUNCTION,"updEmpresa");
$xajax->register(XAJAX_FUNCTION,"cncEmpresa");
$xajax->register(XAJAX_FUNCTION,"updLogo");
$xajax->register(XAJAX_FUNCTION,'matarSesion');
$xajax->register(XAJAX_FUNCTION,'modificar');
$xajax->register(XAJAX_FUNCTION,'guardar_correos');
$xajax->register(XAJAX_FUNCTION,'borrar_correo');
$xajax->register(XAJAX_FUNCTION,'n_correo');
$xajax->register(XAJAX_FUNCTION,'o_correo');
$xajax->register(XAJAX_FUNCTION,'agrega_correo');
$xajax->register(XAJAX_FUNCTION,'gn_correo');
$xajax->register(XAJAX_FUNCTION,'gU_correo');
$xajax->register(XAJAX_FUNCTION,'tiempo_motor');
$xajax->register(XAJAX_FUNCTION,'g_tiempo_motor');
$xajax->register(XAJAX_FUNCTION,'exportar');
$xajax->register(XAJAX_FUNCTION,'elimina_todos_sitios');
$xajax->register(XAJAX_FUNCTION,'monitorista');
$xajax->register(XAJAX_FUNCTION,'g_monitor');
$xajax->register(XAJAX_FUNCTION,'todos');
$xajax->register(XAJAX_FUNCTION,'ver_eventos');
$xajax->register(XAJAX_FUNCTION,'info');

function modificar_sitio($id_sitio){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu = $sess->get("Idu");
	$ide= $sess->get("Ide");
	$resp_sitios = mysql_query( "SELECT s.nombre,s.latitud,s.longitud,s.contacto,s.tel1,s.tel2,t.descripcion,s.id_tipo 
	FROM sitios s LEFT OUTER JOIN tipo_sitios t on (t.id_tipo = s.id_tipo) WHERE s.id_empresa = ".$ide." and s.id_sitio = ".$id_sitio);	
	$s_row=mysql_fetch_array($resp_sitios);
	$resp_Tsitios = mysql_query("SELECT id_tipo,descripcion FROM tipo_sitios WHERE id_empresa = $ide OR id_empresa = 15");
	$opc=""; 
	while($row_Tsitios = mysql_fetch_row($resp_Tsitios)){
		$checked="";
		if($s_row[0]==$row_Tsitios[0]){
			$checked=" checked='checked'";
		}
		$opc .="<option value='".$row_Tsitios[0]."' $checked>".htmlentities($row_Tsitios[1])."</option>";			
	}	
	$form="<table id='newspaper-a1' style='margin:0px;padding:0px;'>
		<tr>
			<td width='73'>Nombre:</td>
			<td width='157'>
				<label>
					<input name='nombre' type='text' id='nombre_sitio' value='".$s_row[0]."' size='20'/>
				</label>
			</td>
		</tr>
		<tr>
			<td>Tipo</td>
			<td>
				<select id='tipo_sitio' >
					$opc
				</select>
			</td>
		</tr>
		<tr>
			<td>Longitud:</td>
			<td><input name='long' type='text' id='long' readonly='readonly' value='".$s_row[2]."' size='15'/></td>
		</tr>
		<tr>
			<td>Latitud:</td>
			<td><input name='lat' type='text' id='lat' readonly='readonly' value='".$s_row[1]."' size='15' /></td>
		</tr>
		<tr>
			<td>Contacto:</td>
			<td><input type='text' name='contacto' id='contacto_sitio' value='".$s_row[3]."'/></td>
		</tr>
		<tr>
			<td>Teléfono:</td>
			<td><input name='tel1' type='text' id='tel1'  value='".$s_row[4]."' size='15' maxlength='15'/></td>
		</tr>
		<tr>
			<td>Telefono:</td>
			<td><input type='text' name='tel2' id='tel2' value='".$s_row[5]."' /></td>
		</tr>
		<input type='hidden' value='$id_sitio' id='id_sitio'>
	</table>";
	$objResponse->assign("modifica_sitio",'innerHTML',$form);
	$objResponse->script("nC('#modifica_sitio').dialog('open')");
	return $objResponse;
}
function info($modulo){
	$objResponse = new xajaxResponse();
	$info="";
	switch($modulo){
		case 'monitorista':
		$info="
			<h2>Monitor de eventos.</h1>
			<p align='justify'>
				Esta herramienta le ayudara a supervisar su veh&iacute;culo de forma sencilla y autom&aacute;tica.<br> 
				Con una sencilla configuraci&oacute;n, podr&aacute; estar al tanto de cuando su 
				veh&iacute;culo entra a una zona de baja cobertura o entra en algun resguardo.<br>
				Si desea ver las instrucciones de clic <a href='#' onclick='jQuery(\"#instrucciones\").show()'>aqu&iacute;</a>
			</p>
			<p id='instrucciones' style='display:none;' align='justify'>
				1.-Indique los minutos m&aacute;ximos que el veh&iacute;culo debe permanecer sin reportar
				(Se recomienda un m&iacute;nimo de 120 minutos).<br>
				2.-Seleccione el intervalo entre los correos de notificaci&oacute;n que le llegaran posteriormente al desfase 
				del tiempo de reporte de su veh&iacute;culo.<br>
				3.-Selecciones si las notificaciones por correo estaran activas o solo se creara un registro interno
				(estos registros se pueden consultar en el bot&oacute;n \"Ver Eventos\" en caso de que el veh&iacute;culo
				tenga eventos registrados).<br>
				4.-Seleccione los dias de la semana en que desea que se monitorie el veh&iacute;culo 
				5.-Seleccione la fecha inicial y final de este monitoreo (un m&aacute;ximo de 15 d&iacute;as), tambien seleccione
				el horario en que se monitoreara el veh&iacute;culo.<br>
				6.-Seleccione los correos a los que se enviaran las notificaciones.<br>
				7.-De clic en guardar o modificar seg&uacute;n sea el caso.<br>
			</p>";
		$title="Monitor de eventos";
		break;
	}
	$objResponse->assign("info_dialog",'innerHTML',$info);
	$objResponse->script('jQuery("span.ui-dialog-title").text("'.$title.'");');
	$objResponse->script('jQuery("#info_dialog").dialog("open")');
	return $objResponse;
}
function update_sitio($id_sitio,$nombre_sitio,$tipo_sitio,$contacto_sitio,$tel1,$tel2){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('ham', 'Native', $options );
	$ide=$sess->get("Ide");
	mysql_query("UPDATE sitios SET nombre='$nombre_sitio', id_tipo=$tipo_sitio, contacto='$contacto_sitio',
	tel1='$tel1', tel2='$tel2', activo = 1 WHERE id_sitio = $id_sitio");
	$objResponse->alert(mysql_error());
	$objResponse->script("opener.xajax_opciones();");
	$objResponse->script("c_tipo(2,$ide,19)");
	return $objResponse;
}
function ver_eventos($veh,$pag){
	setlocale(LC_ALL, 'spanish-mexican');
	$objResponse = new xajaxResponse();
	$por_pag=$pag*15;
	$query=mysql_query("SELECT l.fechahora,l.evento,l.procesado FROM el_monitorgpslog l INNER JOIN el_monitorgps m ON l.num_veh=m.num_veh
						WHERE l.num_veh = $veh ORDER BY l.idlog DESC LIMIT $por_pag,15");
	$q_sig=mysql_query("SELECT l.fechahora,l.evento,l.procesado FROM el_monitorgpslog l  INNER JOIN el_monitorgps m ON l.num_veh=m.num_veh
						WHERE l.num_veh = $veh ORDER BY l.idlog DESC LIMIT $por_pag,16");
	$total=mysql_num_rows($q_sig);
	$tabla="<center>
	<table style='width:90%;' id='newspaper-a1'>
		<tr>
			<th>Evento</th>
			<th>Fecha</th>
			<th>Estado</th>
		</tr>";
	while($row=mysql_fetch_array($query)){
		$evento="Posici&oacute;n desfasada";
		if($row[1]==1){
			$evento="Posici&oacute;n reestablecida";
		}
		$fecha_evento=utf8_encode(ucwords(strftime('%d de %B de %Y', strtotime(($row[0])))));
		list($f,$hora_evento)=explode(" ",$row[0]);
		$procesado="Pendiente";
		if($row[2]==1){
			$procesado="Procesado";
		}
		$tabla.="
		<tr>
			<td>$evento</td>
			<td>$fecha_evento a las $hora_evento</td>
			<td>$procesado</td>
		</tr>";
	}
	$atras="";
	if($pag>0){
		$atras="<nput type='button' onclick='xajax_ver_eventos($veh,$pag-1)' style='float: left;'value='Anterior'>";
	}
	$adelante="";
	if($total>15){
		$adelante="<input type='button' onclick='xajax_ver_eventos($veh,$pag+1)' style='float: right;' value='Siguiente'>";
	}
	$display="style='display:none;'";
	if($atras!='' || $adelante!=''){
		$display='';
	}
	$tabla.="
		<tr $display>
			<td colspan='3'>
				$atras
				$adelante 
			</td>
		</tr>
	</table>
	</center>";
	$objResponse->script('jQuery("span.ui-dialog-title").text("Eventos del vehiculo");');
	$objResponse->assign("logs_dialog",'innerHTML',$tabla);
	$objResponse->script('jQuery("#logs_dialog").dialog("open")');
	return $objResponse;
}
function exportar($ide){
	$objResponse = new xajaxResponse();
	$iframe="<iframe src='exporta_sitios.php?ide=$ide'></iframe>";
	$objResponse->assign('exporta','innerHTML',$iframe);
	return $objResponse;
}
function elimina_todos_sitios($ide){
	$objResponse = new xajaxResponse();
	mysql_query("UPDATE sitios set activo=0 where id_empresa=$ide");
	$objResponse->alert("Se eliminaron correctamente sus sitios");
	$objResponse->script("opener.xajax_opciones();");
	$objResponse-> redirect("catalogos.php?tipo=2");
	return $objResponse;
}
function findResponseStatus($idsistema,$idRequest,$veh){
	$objResponse = new xajaxResponse();
	$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	$result = $equipoGps->getStatusResponseGEO($idRequest);
	if($result == "CONECTADO"){
		$objResponse->script($equipoGps->activaConfigGEO($veh));
	}else if($result == "DESCONECTADO"){
		$objResponse->script("cancelTimerNotConectedGEO($veh)");
	}else $objResponse->script("setUpTimerOnlineGEO($veh,'".$idRequest."')");
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
	}else{
		return $_SERVER["REMOTE_ADDR"];
	}
}
function gn_correo($veh,$desc_m,$tiempo_m,$correosX,$inicio,$fin,$T_dias){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('ham', 'Native', $options );
	$q1="INSERT INTO gpscondicionalerta values(0,'$desc_m',0,".$sess->get('Ide').",'".date("Y-m-d H:i:s")."','$correosX',0,0,1,1,15,0,0,0,-1);";
	mysql_query($q1);
	$dias='S:';
	for($x=0;$x<count($T_dias);$x++){
		$dias.=$T_dias[$x];
		if($x<(count($T_dias)-1)){
			$dias.=",";
		}
	}
	$folio=mysql_insert_id();
	mysql_query("INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,0,-1,-1,0,0,0,'$inicio','$fin',
	$tiempo_m,0,1,1,'$dias','".date("Y-m-d H:i:s")."','-1',0,0,0)");
	mysql_query("INSERT INTO gps_config values($folio,'-1','-1',0,0,'$inicio','$fin','$dias',0,1,'server')");
	$consulta = "insert into auditabilidad values (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',63,
	'Agrega notificacion por correo',13,".$sess->get('Ide').",'".get_real_ip()."')";
	mysql_query($consulta);
	$objResponse->script("xajax_o_correo($veh);");
	return $objResponse;
}
function gU_correo($veh,$folio,$desc_m,$tiempo_m,$correosX,$inicio,$fin,$T_dias){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('ham', 'Native', $options );
	$dias='S:';
	for($x=0;$x<count($T_dias);$x++){
		$dias.=$T_dias[$x];
		if($x<(count($T_dias)-1)){
			$dias.=",";
		}
	}
	$q1="UPDATE gpscondicionalerta SET descripcion='$desc_m',fecha='".date("Y-m-d H:i:s")."',enviaremail='$correosX' where folio=$folio;";
	mysql_query($q1);
	
	mysql_query("UPDATE gpscondicionalertadet SET duracion=$tiempo_m,creacion='".date("Y-m-d H:i:s")."',
	horaini='$inicio',horafin='$fin',enlosdias='$dias'
	where folio=$folio");
	mysql_query("UPDATE gps_config set horaini='$inicio',horafin='$fin',enlosdias='$dias' where folio=$folio");
	$objResponse->script("xajax_o_correo($veh);");
	$consulta = "insert into auditabilidad values (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',64,
	'Modifica notificacion por correo',13,".$sess->get('Ide').",'".get_real_ip()."')";
	mysql_query($consulta);	
	return $objResponse;
}
function n_correo($veh){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('ham', 'Native', $options );
	$query=mysql_query("SELECT * FROM correos_empresa WHERE id_empresa=".$sess->get("Ide")." and activo=1 order by nombre");
	$ver=mysql_query("SELECT d.folio,m.descripcion,m.enviaremail,d.duracion,d.horaini,d.horafin,d.enlosdias
					  FROM gpscondicionalertadet d INNER JOIN gpscondicionalerta m ON d.folio=m.folio WHERE d.duracion > 0
					  AND d.num_geo = 0 AND d.vel_min = -1 AND d.vel_max = -1 AND d.id_msjxclave = 0 AND d.entrageo = 0 AND d.salegeo = 0 
					  AND d.activo = 1 AND m.presolicitapos = 15 AND num_veh = $veh");
	if(mysql_num_rows($ver)==0){
		$datos="
		Nombre:<input type='text' id='desc_m'><br>
		Tiempo:<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57;' id='tiempo_m'>(min)<br>
		Seleccione los dias de la semana:<br>
		<input type='checkbox' id='dias' name='dias2' value='2' checked>L
		<input type='checkbox' id='dias' name='dias3' value='3' checked>M
		<input type='checkbox' id='dias' name='dias4' value='4' checked>I
		<input type='checkbox' id='dias' name='dias5' value='5' checked>J
		<input type='checkbox' id='dias' name='dias6' value='6' checked>V
		<input type='checkbox' id='dias' name='dias7' value='7' checked>S
		<input type='checkbox' id='dias' name='dias1' value='1' checked>D<br>
		Seleccione los correos a los que se notificara:<br>";
		while($row=mysql_fetch_array($query)){
			$datos.="<input type='checkbox' name='id_correo' value='$row[1]' onclick='agrega_correo()'>".$row[2].": ".$row[3]."<br>";
		}
		$datos.="
		Inicio:<input type='text' id='inicio' style='position: relative; z-index: 10;' readonly='readonly' size='15'/><br>
		Fin:<input type='text' id='fin' style='position: relative; z-index: 10;' readonly='readonly' size='15'/><br>
		<input type='button' class='agregar1' value='Guardar' onclick='gn_correo($veh);'>";
	}else{
		$row=mysql_fetch_array($ver);
		$datos="
		Nombre:<input type='text' id='desc_m' value='$row[1]'><br>
		Tiempo:<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57;' id='tiempo_m' value='$row[3]'>(min)<br>
		Seleccione los dias de la semana:<br>
		<input type='checkbox' id='dias' name='dias2' value='2' checked>L
		<input type='checkbox' id='dias' name='dias3' value='3' checked>M
		<input type='checkbox' id='dias' name='dias4' value='4' checked>I
		<input type='checkbox' id='dias' name='dias5' value='5' checked>J
		<input type='checkbox' id='dias' name='dias6' value='6' checked>V
		<input type='checkbox' id='dias' name='dias7' value='7' checked>S
		<input type='checkbox' id='dias' name='dias1' value='1' checked>D<br>
		Seleccione los correos a los que se notificara:<br>";
		$query=mysql_query("SELECT * FROM correos_empresa WHERE id_empresa=".$sess->get("Ide")." and activo=1 order by nombre");
		while($rowd=mysql_fetch_array($query)){
			$chek="";
			if(preg_match("/".$rowd[3]."/i",$row[2])){
				$chek="checked";
			}
			$datos.="<input type='checkbox' name='id_correo' value='$rowd[1]' onclick='agrega_correo()' $chek>".$rowd[2].": ".$rowd[3]."<br>";
		}
		$datos.="
		Inicio:<input type='text' id='inicio' style='position: relative; z-index: 10;' value='$row[4]' readonly='readonly' size='15'/><br>
		Fin:<input type='text' id='fin' style='position: relative; z-index: 10; left:15px;' value='$row[5]' readonly='readonly' size='15'/><br>
		<input type='button' class='agregar1' value='Guardar' onclick='gU_correo($veh,$row[0]);'>";
		$objResponse->script("setTimeout(function(){llena()}, 200);");
		$objResponse->script("setTimeout(function(){llena2('".str_replace("S:",'',$row[6])."')}, 500);");
	}
	$objResponse->script("setTimeout('calendario(\"inicio\")',100)");
	$objResponse->script("setTimeout('calendario(\"fin\")',500)");
	$objResponse->assign('correos_varios','innerHTML',$datos);
	$objResponse->assign('b_agr','innerHTML',"<img src='img2/email-not-validated-icon.png' align='right' height='20px' title='Ocultar' onclick='xajax_o_correo($veh)'>");
	$objResponse->script("jQuery('#correos_varios').fadeIn('slow')");
	return $objResponse;
}
function agrega_correo($T_correo){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$correos='';
	$mostrar='';
	for($i=0;$i<count($T_correo);$i++){
		$query=mysql_query("SELECT correo from correos_empresa where id_correo=".$T_correo[$i]." 
		AND id_empresa=".$sess->get("Ide")." and activo=1");
		$add=mysql_fetch_array($query);
		if($correos!=''){
			$correos.=";";
		}
		if($mostrar!=''){
		}
		$correos.=$add[0];
	}
	$mostrar.="<input type='hidden' id='correosX' value='$correos'>";
	$objResponse->assign("mostrar_correos_dialog","innerHTML",$mostrar);
	return $objResponse;
}
function o_correo($veh){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('ham', 'Native', $options );
	$objResponse->assign('b_agr','innerHTML',"<img src='img2/email-add-icon.png' align='right' height='20px' title='Notificar posici&oacute;n' onclick='xajax_n_correo($veh)'>");
	$objResponse->script("jQuery('#correos_varios').fadeOut('slow');");
	return $objResponse;
}
function detallar_datos($veh,$est){
	$objResponse = new xajaxResponse();
	$cad_detalle = "SELECT num_veh,id_veh,economico,placas,color,modelo,detalle,hora FROM vehiculos WHERE num_veh = $veh";
	$resp_detalle = mysql_query($cad_detalle);
	$cad_zona=mysql_query("SELECT gmt FROM veh_gmt WHERE num_veh=$veh");
	if(mysql_num_rows($cad_zona) > 0){
		$dat=mysql_fetch_array($cad_zona);
		$gmt=$dat[0];
	}else{
		$gmt="-5";
	}
	$cad_geo = "SELECT t.nombre,v.num_geo FROM geo_veh v INNER JOIN geo_time t ON(t.num_geo = v.num_geo) 
				WHERE v.num_veh = $veh AND v.activo = 1";
	$resp_geo = mysql_query($cad_geo);
	if($resp_detalle != 0){
		$correo_auto="<img src='img2/email-add-icon.png' align='right' height='20px' title='Notificar posici&oacute;n' onclick='xajax_n_correo($veh)'>";
		$obsoleto=mysql_query("SELECT DISTINCT v.id_sistema, s.tipo_equipo FROM vehiculos v INNER JOIN sistemas s on v.id_sistema=s.id_sistema
							WHERE s.tipo_equipo not IN ('A1','SPIDER','CTRACKER','GALAXY','PDT','PORTMAN','SUNTECH','X8')
							AND s.obsoleto = 0 AND v.num_veh = $veh");
		if(mysql_num_rows($obsoleto) == 0){
			$correo_auto="";
		}
		$row_veh = mysql_fetch_array($resp_detalle);
		$cad_dsn = "
		<table width='580' id='newspaper-a1'>
			<tr>
				<th colspan='1' width='150px'>Datos del vehículo</th> 
				<th id='b_agr'>$correo_auto</th>
			</tr>
			<tr>
				<td colspan='2'><div id='correos_varios' style='display:none;'></div></td>
			</tr>
			<tr>
				<td width='100'>Número:</td><td>".htmlentities($row_veh[0])."</td>
			</tr>
			<tr>
				<td>Identificación:</td><td>".htmlentities($row_veh[1])."</td>
			</tr>
			<tr>
				<td>Económico</td><td >".htmlentities($row_veh[2])."</td>
			</tr>
			<tr>
				<td>Placas</td><td  id='placas'>".htmlentities($row_veh[3])."</td>
			</tr>
			<tr>
				<td>Modelo:</td><td  id='modelo'>".htmlentities($row_veh[5])."</td>
			</tr>
			<tr>
				<td>Detalle:</td><td  id='detalle'>".htmlentities($row_veh[6])."</td>
			</tr>
			<tr>
				<td>Zona Horaria:</td><td  id='zona'>".htmlentities($gmt)."</td>
			</tr>
			<tr>
				<td colspan='2' id=\"botones\">
					<input type='button' class='agregar1' value='Actualizar' onclick=\"actualizar($veh);\"/>
				</td>
			</tr>";
		if(mysql_num_rows($resp_geo) > 0){
			$cad_dsn .= "<tr><th colspan='2'>Geocercas asignadas</th></tr>";
			while($row_geo = mysql_fetch_row($resp_geo)){
				$cad_dsn .="
				<tr>
					<td width='150px'>".htmlentities(strtoupper(utf8_decode($row_geo[0])))."</td>
					<td align='right'>";
				if($est != 3){
					$cad_dsn .="<a href='javascript:void(null);' onclick='xajax_desasignar($row_veh[0],$row_geo[1]);'>";
					$cad_dsn .="<img src='img/ico_delete.png' border='0' title='Eliminar asignación' width='15px' height='15px'/></a>";
				}
				$cad_dsn .="</td></tr>";
			}
		}
		$cad_dsn .= "</table>";
		$objResponse->assign('detalle_veh','innerHTML',$cad_dsn);
	}
	return $objResponse;
}
function guardarDatos($datos,$numveh){
	$objResponse = new xajaxResponse();
	$modelo = $datos[0];
	$placas = $datos[1];
	$detalle = $datos[2];
	$zona = $datos[3];

	if($numveh != "" && $numveh != null){
		$ver=mysql_query("SELECT * from veh_gmt WHERE num_veh=$numveh");
		if(mysql_num_rows($ver) == 0){
			mysql_query("INSERT INTO veh_gmt VALUES($numveh,'$zona')");
		}else{
			mysql_query("UPDATE veh_gmt SET gmt = '$zona' WHERE num_veh=$numveh");
		}

		$update = "UPDATE vehiculos SET modelo='$modelo',placas='$placas',detalle='$detalle' WHERE num_veh=$numveh";
		$result = mysql_query($update);
		$options="";
		$sess =& patSession::singleton('egw', 'Native', $options );
		$consulta = "INSERT INTO auditabilidad VALUES (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',19,
					 'Modificar vehiculo $zona',13,".$sess->get('Ide').",'".get_real_ip()."')";
		mysql_query($consulta);
		if($result){
			$objResponse->alert("Datos actualizados");
			$objResponse->call("datos_vehiculo",$numveh,1);
		}else $objResponse->alert("Error...".mysql_error());
	}
	return $objResponse;	
}
function desasignar($idv,$idg){
	$objResponse = new xajaxResponse();
	$cad_des = "UPDATE geo_veh  SET activo=0 where num_geo = $idg and num_veh = $idv";
	$res_des = mysql_query($cad_des);
		if($res_des != 0){
			$objResponse->alert("Se desasignó la geocerca");
			$objResponse->call('xajax_detallar_datos',$idv);
			$options="";
			$sess =& patSession::singleton('egw', 'Native', $options );
			$consulta = "insert into auditabilidad values (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',77,
			'Desasigno una geocerca ($idg)',13,".$sess->get('Ide').",'".get_real_ip()."')";
			mysql_query($consulta);
		}else{
			$objResponse->alert("Error en el proceso, intente nuevamente");
		}
  	return $objResponse;
}
function catalogo_sitios($n,$ide,$est){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('ham', 'Native', $options );
	switch($n){
		case 1:
				$cad_veh = "SELECT distinct(v.id_veh), v.num_veh 
				from veh_usr as vu 
				inner join vehiculos as v on vu.num_veh = v.num_veh 
				inner join estveh ev on (v.estatus = ev.estatus) 
				where vu.id_usuario = $ide  
				AND ev.publicapos=1 
				and vu.activo=1
				order by v.id_veh asc";
				$resp_veh = mysql_query($cad_veh);
				if($resp_veh != 0 ){
					$cad_cont_veh = "
					<table id='newspaper-a1' width='190px'>
						<tr>
							<th>
								Vehículos
							</th>
						</tr>";
					$cont = 0;
					$numveh = 0;
					while($row = mysql_fetch_array($resp_veh))
					{
						if($numveh==0){
							$numveh = $row[1];
						}
						$cad_cont_veh .= "
						<tr>
							<td>
								<a href='#' onclick='datos_vehiculo($row[1],$est)'>".utf8_encode($row[0])."</a>
							</td>
						</tr>";	
						
					}
				$cad_cont_veh .= "</table>";
				$objResponse->assign('cont_autos_cat','innerHTML',$cad_cont_veh);
				$objResponse->call('datos_vehiculo',$numveh,3);
				}
				else $objResponse->alert('No se encontraron vehículos para este usuario');
		break;
		case 2: if($est != 3){
					$crea_cat="
					<table border='0' class='fuente' align='left'>
						<tr>
							<td>
								<input type='button' class='agregar1' value='Importar'
								onclick='xajax_crear_categoria(1,$ide)'/> &nbsp;
								
							</td>
							<td><input type='button' class='agregar1' value='Exportar'
								onclick='xajax_exportar($ide)'/></td>
						</tr>
					</table>";
					$objResponse->assign('categ_sitios','innerHTML',$crea_cat);
				}
				else $objResponse->assign('categ_sitios','innerHTML','');
				$cad_sitios = "SELECT s.nombre,s.latitud,s.longitud,s.contacto,s.tel1,s.tel2,t.descripcion,s.id_sitio 
				from sitios s 
				left outer join tipo_sitios t on (t.id_tipo = s.id_tipo) 
				where s.id_empresa = ".$ide." 
				and s.activo=1
				order by s.nombre ASC";
				$resp_sitios = mysql_query($cad_sitios);
				mysql_close($conec);
				if(mysql_num_rows($resp_sitios) != 0 ){
				    $tabla_sitios = "
					<div id='sitio_interes'>
						<table width='765px' border='0' id='newspaper-a1'>
							<tr>
								<th width='130px'>Nombre</th>
								<th  width='120px'>Tipo</th>
								<th width='120px'>Lat</th>
								<th width='120px'>Long</th>
								<th width='115px'>Contacto</th>
								<th width='100px'>Tel</th>
								<th width='100px'>Tel</th>
							";
					if($est != 3){
					  $tabla_sitios .= "
						<th colspan='2'>
						<img src='img/ico_delete.png' width='15px' style='float:right;cursor:pointer;' title='Eliminar todos los sitios' 
						onclick='xajax_elimina_todos_sitios(".$sess->get('Ide').")'>
						</th>";
					}
					$tabla_sitios .= "	</tr>";
					while($fila = mysql_fetch_array($resp_sitios)){
						$tabla_sitios .="<tr><td width='130px'>$fila[0]</td><td width='120px'>".htmlentities($fila[6])."</td>";
						$tabla_sitios .="<td width='120px'>".number_format($fila[1],6,'.','')."</td>";
      					$tabla_sitios .="<td width='120px'>".number_format($fila[2],6,'.','')."</td><td width='115px'>$fila[3]</td><td width='100px'>$fila[4]</td><td width='100px'>$fila[5]</td>";
						if($est != 3){
							$tabla_sitios .="<td width='20px'><img src='img2/asig_geo.png' width='20px' height='20px' ";
							//$tabla_sitios .="border='0' title='Modificar sitio' onclick='nueva_ventana($ide,$fila[7])' /></td>";
							$tabla_sitios .="border='0' title='Modificar sitio' onclick='xajax_modificar_sitio($fila[7])' /></td>";
							$tabla_sitios .="<td width='20px'><img src='img/ico_delete.png' width='15px' height='15px' ";
							$tabla_sitios .="border='0' title='Eliminar sitio' onclick='exe_eliminar($fila[7],$ide)'/></td></tr>";
						}
					}
					$tabla_sitios .= "</table></div>";
					$objResponse->assign('sitios_interes','innerHTML',$tabla_sitios);
				}
				else{
					$objResponse->assign('sitios_interes','innerHTML','');
	 			  	$objResponse->alert('No se encontraron sitios de interes para su empresa');
				 }
		break;
		case 3: $cad_sitios = "SELECT num_geo,nombre,IF(tipo = 1,'POLIGONAL','CIRCULAR') AS tipo_geo,tipo 
						from geo_time 
						where id_empresa = $ide 
						and activo=1
						ORDER BY nombre";
				$resp_sitios = mysql_query($cad_sitios);
				mysql_close($conec);
				if(mysql_num_rows($resp_sitios) != 0 )
				{
					$tabla_sitios ="
					<div id='geo_cerca'>
					<table width='630px' border='0' id='newspaper-a1'>
					<tr>
						<th width='335px'>Nombre</th>
						<th width='120'>Tipo</th>
						<th id='modificado' width='100px;'></th>
					</tr>";
					while($fila = mysql_fetch_array($resp_sitios))
					{
						$tabla_sitios .='<tr><td width="335"> <input type="text" value="'.htmlentities($fila[1]).'" id="'.$fila[0].'" size="20" /></td>
						<td width="120">'.$fila[2].'</td>';
						if($est!=3)
						{	
							$tabla_sitios .="<td width='45' align='right'>
								<img src='img2/asig_geo.png' style='cursor:pointer;padding:5px;' width='15px' height='15px' title='Modificar Nombre' onclick='modificar($fila[0])' >
								<img src='img/ico_delete.png' style='cursor:pointer;padding:5px;' width='15px' height='15px' border='0' title='Eliminar geocerca' onclick='exe_eliminar_geo($fila[0],$ide,$fila[3])'/>
								</td>
							</tr>";
						}
						else{
							$tabla_sitios .="<td></td></tr>";
						}
					}
					$tabla_sitios .= "</table></div>";
					$objResponse->assign('sitios_interes','innerHTML',$tabla_sitios);
				}
				else
				{  
					$objResponse->assign('sitios_interes','innerHTML','');
					$objResponse->alert('No se encontraron geocercas para su empresa');
				}
				
		break;
		case 6:
			$query_m=mysql_query("SELECT * FROM correos_empresa WHERE id_empresa=".$sess->get("Ide")." 
			and activo=1 
			and correo='monitoreo_gps@sepromex.com.mx'
			order by nombre");
			if(mysql_num_rows($query_m)==0){
				mysql_query("INSERT INTO correos_empresa values(".$sess->get("Ide").",0,'Monitoreo SEPROMEX','monitoreo_gps@sepromex.com.mx',1)");
			}
			$query=mysql_query("SELECT * FROM correos_empresa WHERE id_empresa=".$sess->get("Ide")." and activo=1 order by nombre");
			$total_correos=mysql_num_rows($query);
		
			$datos="
			<table width='630px' border='0' id='newspaper-a1'>";
			if($total_correos<=30){
				$datos.="
				<tr>
					<th colspan='3' id='agregar_correo' align='right'><img  src='img2/email-add-icon.png' align='right' height='20px' title='Agregar Correo' onclick='mostrar_form_correos(1)'></th>
				</tr>";
			}
			$datos.="	<tr>
					<th>Nombre</th>
					<th>Correo</th>
					<th align='right'>Restantes: ".(30-$total_correos)."</th>
				</tr>
			";
			while($row=mysql_fetch_array($query)){
				$boton="<img src='img2/email-delete-icon.png' align='right' title='Borrar correo' height='20px' onclick='xajax_borrar_correo(".$row[1].")'>";
				if($row[3]=='monitoreo_gps@sepromex.com.mx'){
					$mensaje="Este correo no se puede borrar, puede agregar este correo en alguna de sus reglas para que SEPROMEX atienda la incidencia, esto podria generarle algun costo";
					$boton="<img src='img2/email-info-icon.png' align='right' title='Este correo no se puede borrar' height='20px' 
					onclick='alert(\"$mensaje\")'>";
				}
				$datos.="
					<tr>
						<td>".$row[2]."</td>
						<td>".$row[3]."</td>
						<td>
							$boton
						</td>
					</tr>
				";
			}
			$datos.="</table>";
			$objResponse->assign('correos_empresa','innerHTML',$datos);
			$objResponse->script('mostrar_form_correos()');
		break;
		case 7:
				$cad_veh = "select distinct(v.id_veh), v.num_veh 
				from veh_usr as vu 
				inner join vehiculos as v on vu.num_veh = v.num_veh 
				inner join estveh ev on (v.estatus = ev.estatus) 
				inner join sistemas s on v.id_sistema=s.id_sistema
				where vu.id_usuario =".$sess->get("Idu")."
				AND ev.publicapos=1 
				and vu.activo=1
				and s.tipo_equipo in('U1L','U1','UC','UG','U1CP')
				order by v.id_veh asc";
				$resp_veh = mysql_query($cad_veh);
				if($resp_veh != 0 ){
					$cad_cont_veh = "
					<table id='newspaper-a1' width='190px'>
						<tr>
							<th>
								Vehículos
							</th>
						</tr>";
					$cont = 0;
					$numveh = 0;
					while($row = mysql_fetch_array($resp_veh))
					{
						if($numveh==0){
							$numveh = $row[1];
						}
						$cad_cont_veh .= "
						<tr>
							<td>
								<a href='#' onclick='xajax_tiempo_motor($row[1])'>".utf8_encode($row[0])."</a>
							</td>
						</tr>";	
						
					}
					$cad_cont_veh .= "</table>";
					$objResponse->assign('cont_autos_cat','innerHTML',$cad_cont_veh);
				}
		break;
		case 8:
			$cad_veh = "select distinct(v.id_veh), v.num_veh 
			from veh_usr as vu 
			inner join vehiculos as v on vu.num_veh = v.num_veh 
			inner join estveh ev on (v.estatus = ev.estatus) 
			inner join sistemas s on v.id_sistema=s.id_sistema
			where vu.id_usuario =".$sess->get("Idu")."
			AND ev.publicapos=1 
			and vu.activo=1
			order by v.id_veh asc";
			$resp_veh = mysql_query($cad_veh);
			if($resp_veh != 0 ){
				$cad_cont_veh = "
				<table id='newspaper-a1' width='190px'>
					<tr>
						<th>
							Vehículos
						</th>
					</tr>";
				while($row = mysql_fetch_array($resp_veh))
				{
					$query=mysql_query("SELECT horaini,horafin from el_monitorgps 
					where num_veh=$row[1] 
					and dias like '%".date("N")."%'
					and activo=1");
					$activo="";
					if(mysql_num_rows($query)>0){
						$fechas=mysql_fetch_array($query);
						list($diai,$ini)=explode(" ",$fechas[0]);
						list($diaf,$fin)=explode(" ",$fechas[1]);
						if(date("H:i:s")>=$ini && date("H:i:s")<=$fin){
							$activo="<img src='img2/ejecucion.png' height='15px' style='float:right;' title='Ejecutando...'>";
						}
					}
					$cad_cont_veh .= "
					<tr>
						<td>
							<a href='#' onclick='xajax_monitorista($row[1],0)'>".utf8_encode($row[0])."</a>$activo
						</td>
					</tr>";
				}
				$cad_cont_veh .= "</table>";
				$objResponse->assign('cont_autos_cat','innerHTML',$cad_cont_veh);
			}
		break;
		}
	return $objResponse;
}
function todos(){
	$objResponse = new xajaxResponse();
	$vehiculos=mysql_query("SELECT v.num_veh,v.tpoleo from vehiculos v INNER JOIN estveh e on e.estatus = v.estatus
	INNER JOIN ultimapos u on v.num_veh = u.num_veh WHERE e.publicapos = 1 and u.fecha > '2014-10-29 00:00:00'");
	while($row=mysql_fetch_array($vehiculos)){
		$pos=$row[1]*4;
		mysql_query("INSERT INTO el_monitorgps 
		VALUES($row[0],$pos,1,'".date("Y-m-d H:i:s")."','jfletes@sepromex.com.mx','0000-00-00 00:00:00',1,1,
		'2014-10-30 16:00:00','S:2,3,4,5,6,7,1','2014-10-29 15:00:00','2014-10-30 16:00:00',0)");
	}
	if(mysql_error()){
		return $objResponse->alert(mysql_error());
	}else{
		return $objResponse->alert("OK");
	}
}
function monitorista($veh,$visto){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('ham', 'Native', $options );
	$hora_atras=date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." -1 hour"));
	$query=mysql_query("SELECT distinct(v.id_veh),s.descripcion,v.tpoleo,u.fecha FROM vehiculos v
	INNER JOIN sistemas s ON s.id_sistema = v.id_sistema INNER JOIN ultimapos u on u.num_veh = v.num_veh WHERE v.num_veh = $veh	AND u.fecha >= '$hora_atras'");
	$actualizado=0;
	if(mysql_num_rows($query)>0){
		$actualizado=1;
	}
	$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"monitorista\")'>";
	if($actualizado==1 || $visto==1){
		$query=mysql_query("SELECT distinct(v.id_veh),s.descripcion,v.tpoleo,u.fecha FROM vehiculos v INNER JOIN sistemas s on s.id_sistema=v.id_sistema 
							INNER JOIN ultimapos u on u.num_veh=v.num_veh WHERE v.num_veh=$veh");
		$dat=mysql_fetch_array($query);
		list($id,$sistema)=explode("-",$dat[1]);
		$tabla="<div id='correos_varios_2'></div>";
		$q_logs=mysql_query("SELECT * from el_monitorgpslog WHERE num_veh = $veh");
		$boton_logs="";
		if(mysql_num_rows($q_logs)>0){
			$boton_logs="<input type='button' onclick='xajax_ver_eventos($veh,0)' class='agregar1' value='Ver eventos'>";
		}
		$query=mysql_query("SELECT * FROM correos_empresa WHERE id_empresa=".$sess->get("Ide")." and activo=1 order by nombre");
		$ver=mysql_query("Select * from el_monitorgps where num_veh=$veh and activo=1");
		if(mysql_num_rows($ver) == 0){
			$correos="";
			while($row=mysql_fetch_array($query)){
				$correos.="
				<tr>
					<td><input type='checkbox' name='id_correo' value='$row[1]' onclick='agrega_correo()'>".$row[2]."</td>
					<td> ".$row[3]."</td>
				</tr>";
			}
			$datos="
			<table id='newspaper-a1' width='570px'>
				<tr>
					<th width='400px'>Veh&iacute;culo: $dat[0]</th>
					<th>$sistema $btn_info</th>
				</tr>
				<tr>
					<td colspan='2'>
						Minutos sin posici&oacute;n:
						<input type='number' id='t_max_min' min='60' max='180' value='60' onblur='tiempo_minimo(60,180)' style='width:35px;'  >
						Tiempo entre notificaciones:
						<input type='number' id='t_max_hrs' value='1' min='1' max='72' onblur='hrs_min(1,72)' style='width:35px;'>(hrs)
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						Notificaciones por correo:
						<select id='notificaciones'>
							<option value='1'>Activas</option>
							<option value='0'>Inactivas</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan='2'>Seleccione los dias de la semana:
						<input type='checkbox' id='dias_mon' name='dias2' value='2' checked>L
						<input type='checkbox' id='dias_mon' name='dias3' value='3' checked>M
						<input type='checkbox' id='dias_mon' name='dias4' value='4' checked>I
						<input type='checkbox' id='dias_mon' name='dias5' value='5' checked>J
						<input type='checkbox' id='dias_mon' name='dias6' value='6' checked>V
						<input type='checkbox' id='dias_mon' name='dias7' value='7' checked>S
						<input type='checkbox' id='dias_mon' name='dias1' value='1' checked>D
					</td>
				</tr>
				<tr>
					<td colspan='2'>Horario en el que se aplicara la regla:</td>
				</tr>
				<tr>
					<td colspan='2'>
						Inicio:<input type='text' id='inicio_monitor' style='position: relative; z-index: 10;' readonly='readonly' size='25'/>
						Fin:<input type='text' id='fin_monitor' style='position: relative; z-index: 10;' readonly='readonly' size='25'/>
					</td>
				</tr>
				<tr>
					<td colspan='2'>Seleccione los correos a los que se notificara:</td>
				</tr>
				$correos
				<tr>
					<td colspan='2'>
						<input type='button' onclick='g_monitor($veh,1)' class='agregar1' value='Guardar'>
						$boton_logs
					</td>
				</tr>";
		}else{
			$row=mysql_fetch_array($ver);
			$boton="
			<td colspan='2'>
				<input type='button' class='agregar1' value='Modificar' onclick='g_monitor($veh,2)'>
				<input type='button' class='agregar1' value='Borrar' onclick='g_monitor($veh,0)'>
				$boton_logs
			</td>";
			$query=mysql_query("SELECT * FROM correos_empresa WHERE id_empresa=".$sess->get("Ide")." and activo=1 order by nombre");
			while($rowd=mysql_fetch_array($query)){
				$chek="";
				if(preg_match("/".$rowd[3]."/i",$row[4])){
					$chek="checked";
				}
				$correos.="
				<tr>
					<td><input type='checkbox' name='id_correo' value='$rowd[1]' onclick='agrega_correo()' $chek>".$rowd[2]."</td> 
					<td>".$rowd[3]."</td>
				</tr>";
			}
			$activa="";
			$inactiva="";
			if($row[2]==1){
				$activa="selected='selected'";
			}else{
				$inactiva="selected='selected'";
			}
			$datos="
			<table id='newspaper-a1' width='570px'>
				<tr>
					<th width='400px'>Veh&iacute;culo: $dat[0]</th>
					<th>$sistema $btn_info</th>
				</tr>
				<tr>
					<td colspan='2'>
						Minutos sin posici&oacute;n:
						<input type='number' id='t_max_min'  value='".$row[1]."' min='60' max='180' onblur='tiempo_minimo(60,180)' style='width:35px;'>
						Tiempo entre notificaciones:
						<input type='number' id='t_max_hrs'  value='".$row[6]."' min='1' max='72' onblur='hrs_min(1,72)' style='width:35px;'>(hrs)
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						Notificaciones por correo:
						<select id='notificaciones'>
							<option value='1' $activa>Activas</option>
							<option value='0' $inactiva>Inactivas</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan='2'>Seleccione los dias de la semana:
						<input type='checkbox' id='dias_mon' name='dias2' value='2' checked>L
						<input type='checkbox' id='dias_mon' name='dias3' value='3' checked>M
						<input type='checkbox' id='dias_mon' name='dias4' value='4' checked>I
						<input type='checkbox' id='dias_mon' name='dias5' value='5' checked>J
						<input type='checkbox' id='dias_mon' name='dias6' value='6' checked>V
						<input type='checkbox' id='dias_mon' name='dias7' value='7' checked>S
						<input type='checkbox' id='dias_mon' name='dias1' value='1' checked>D
					</td>
				</tr>
				<tr>
					<td colspan='2'>Horario en el que se aplicara la regla:</td>
				</tr>
				<tr>
					<td colspan='2'>
						Inicio:<input type='text' id='inicio_monitor' style='position: relative; z-index: 10;' value='$row[10]' readonly='readonly' size='25'/>
						Fin:<input type='text' id='fin_monitor' style='position: relative; z-index: 10;' value='$row[11]'  readonly='readonly' size='25'/>
					</td>
				</tr>
				<tr>
					<td colspan='2'>Seleccione los correos a los que se notificara:</td>
				</tr>
				$correos
				<tr>
					$boton 
				</tr>";
			$objResponse->script("setTimeout(function(){llena()}, 200);");
			$objResponse->script("setTimeout(function(){llena2('".str_replace("S:",'',$row[9])."')}, 500);");
			$objResponse->script("setTimeout(function(){agrega_correo()}, 700);");
		}
		$tabla.="</table>";
		$objResponse->assign('detalle_veh','innerHTML',$tabla);
		$objResponse->assign('correosX','value','');
		$objResponse->script("setTimeout('calendario(\"inicio_monitor\")',100)");
		$objResponse->script("setTimeout('calendario(\"fin_monitor\")',500)");
		$objResponse->assign('correos_varios_2','innerHTML',$datos);
		$objResponse->assign('b_agr','innerHTML',"<img src='img2/email-not-validated-icon.png' align='right' height='20px' title='Ocultar' onclick='xajax_o_correo($veh)'>");
		$objResponse->script("jQuery('#correos_varios_2').fadeIn('slow')");
	}else{
		$query=mysql_query("SELECT u.fecha,v.id_veh,v.num_veh from ultimapos u
		inner join vehiculos v on u.num_veh=v.num_veh
		where u.num_veh=$veh");
		$datos=mysql_fetch_array($query);
		setlocale(LC_ALL, 'spanish-mexican');
		$fecha_ultima=utf8_encode(ucwords(strftime('%A %d de %B de %Y', strtotime(($datos[0])))));
		list($f,$hora)=explode(" ",$datos[0]);
		$sin_reporte="El veh&iacute;culo $datos[1] tiene mas de 1 hora sin reportar<br>
		&Uacute;ltimo reporte $fecha_ultima a las $hora <br><br> Redireccionando...";
		$objResponse->assign('detalle_veh','innerHTML',$sin_reporte);
		$objResponse->script("setTimeout(function(){xajax_monitorista($datos[2],1)}, 6000);");
	}	
	return $objResponse;
}
function g_monitor($veh,$tiempo,$hrs,$correos,$activo,$ini,$fin,$T_dias,$notifica){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('ham', 'Native', $options );
	$dias='S:';
	for($x=0;$x<count($T_dias);$x++){
		$dias.=$T_dias[$x];
		if($x<(count($T_dias)-1)){
			$dias.=",";
		}
	}
	$alarmado=0;
	switch($activo){
		case 0:
			mysql_query("UPDATE el_monitorgps SET activo=0 WHERE num_veh=$veh");
			$objResponse->assign("correos_varios_2","innerHTML","Datos borrados");
		break;
		case 1:
			$ver=mysql_query("select * from el_monitorgps where num_veh=$veh");
			if(mysql_num_rows($ver)==0){
				mysql_query("INSERT INTO el_monitorgps VALUES($veh,$tiempo,$notifica,'$ini','$correos',
				'0000-00-00 00:00:00',$hrs,1,'$fin','$dias','$ini','$fin',$alarmado)");
			}
			else{
				mysql_query("UPDATE el_monitorgps SET activo=1,minsinactividad=$tiempo,notificar=$notifica,correo='$correos',
				aviso='0000-00-00 00:00:00',avisarcadahr=$hrs,vence='$fin',dias='$dias',horaini='$ini',horafin='$fin',
				notificar=$notifica,alarmado=0,creacion='$ini'
				where num_veh=$veh");
			}
			$objResponse->assign("correos_varios_2","innerHTML","Datos guardados");
		break;
		case 2:
			mysql_query("UPDATE el_monitorgps SET activo = 1, minsinactividad = $tiempo, notificar = $notifica, correo = '$correos',
			aviso = '0000-00-00 00:00:00', avisarcadahr = $hrs, vence = '$fin', dias = '$dias', horaini = '$ini', horafin = '$fin',
			notificar = $notifica, alarmado = 0, creacion = '$ini' WHERE num_veh=$veh");
			$objResponse->assign("correos_varios_2","innerHTML","Datos actualizados");
		break;
	}
	$idu=$sess->get("Idu");
	$objResponse->script("setTimeout(function(){c_tipo(8,$idu,19);}, 1000);");
	$objResponse->script("setTimeout(function(){xajax_monitorista($veh,0)}, 2000);");
	return $objResponse;
}
function tiempo_motor($veh){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('ham', 'Native', $options );
	$query=mysql_query("SELECT distinct(v.id_veh),s.descripcion 
	from vehiculos v
	inner join sistemas s on s.id_sistema=v.id_sistema
	where num_veh=$veh");
	$dat=mysql_fetch_array($query);
	list($id,$sistema)=explode("-",$dat[1]);
	$boton="<td colspan='2'></td>";
	$tabla="<div id='correos_varios_2'></div>";
	$query=mysql_query("SELECT * FROM correos_empresa WHERE id_empresa=".$sess->get("Ide")." and activo=1 order by nombre");
	$ver=mysql_query("SELECT d.folio,m.descripcion,m.enviaremail,d.duracion ,d.horaini,d.horafin,d.enlosdias
					  FROM gpscondicionalertadet d INNER JOIN gpscondicionalerta m ON d.folio = m.folio WHERE d.duracion > 0 
					  AND d.num_geo = 0 AND d.vel_min = -1 AND d.vel_max = -1 AND d.id_msjxclave = 248 AND d.entrageo = 0 AND d.salegeo = 0 
					  AND d.activo = 1 AND d.duracion >= 60 AND m.presolicitapos = -1 AND d.num_veh = $veh");
	if(mysql_num_rows($ver)==0){
		$boton="<td colspan='2'>
		<input type='button' onclick='g_tiempo_motor($veh,1,0)' class='agregar1' value='Guardar'></td>";
		$correos="";
		while($row=mysql_fetch_array($query)){
			$correos.="<tr>
				<td><input type='checkbox' name='id_correo' value='$row[1]' onclick='agrega_correo()'>".$row[2]."</td>
				<td> ".$row[3]."</td>
			</tr>";
		}
		$datos="
		<table id='newspaper-a1' width='570px'>
			<tr>
				<th width='400px'>Veh&iacute;culo: $dat[0]</th>
				<th>$sistema</th>
			</tr>
			<tr>
				<td colspan='2'>Horas m&aacute;ximas encendido:
				<input type='text' id='t_max' onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
				</td>
			</tr>
			<tr>
				<td colspan='2'>Seleccione los dias de la semana:
					<input type='checkbox' id='dias_m' name='dias2' value='2' checked>L
					<input type='checkbox' id='dias_m' name='dias3' value='3' checked>M
					<input type='checkbox' id='dias_m' name='dias4' value='4' checked>I
					<input type='checkbox' id='dias_m' name='dias5' value='5' checked>J
					<input type='checkbox' id='dias_m' name='dias6' value='6' checked>V
					<input type='checkbox' id='dias_m' name='dias7' value='7' checked>S
					<input type='checkbox' id='dias_m' name='dias1' value='1' checked>D
				</td>
			</tr>
			<tr>
				<td colspan='2'>Horario en el que se aplicara la regla:</td>
			</tr>
			<tr>
				<td colspan='2'>
					Inicio:<input type='text' id='inicio' style='position: relative; z-index: 10;' readonly='readonly' size='15'/>
					Fin:<input type='text' id='fin' style='position: relative; z-index: 10;' readonly='readonly' size='15'/>
				</td>
			</tr>
			<tr>
				<td colspan='2'>Seleccione los correos a los que se notificara:</td>
			</tr>
			$correos
			<tr>
				$boton
			</tr>";
	}else{
		$row=mysql_fetch_array($ver);
		$boton="
		<td colspan='2'>
			<input type='button' class='agregar1' value='Modificar' onclick='g_tiempo_motor($veh,2,$row[0])'>
			<input type='button' class='agregar1' value='Borrar' onclick='g_tiempo_motor($veh,0,$row[0])'>
		</td>";
		$query=mysql_query("SELECT * FROM correos_empresa WHERE id_empresa=".$sess->get("Ide")." and activo=1 order by nombre");
		while($rowd=mysql_fetch_array($query)){
			$chek="";
			if(preg_match("/".$rowd[3]."/i",$row[2])){
				$chek="checked";
			}
			$correos.="
			<tr>
				<td><input type='checkbox' name='id_correo' value='$rowd[1]' onclick='agrega_correo()' $chek>".$rowd[2]."</td> 
				<td>".$rowd[3]."</td>
			</tr>";
		}
		$datos="
		<table id='newspaper-a1' width='570px'>
			<tr>
				<th width='400px'>Veh&iacute;culo: $dat[0]</th>
				<th>$sistema</th>
			</tr>
			<tr>
				<td colspan='2'>Horas m&aacute;ximas encendido:
				<input type='text' id='t_max' readonly='readonly' value='".($row[3]/60)."'>
				</td>
			</tr>
			<tr>
				<td colspan='2'>Seleccione los dias de la semana:
					<input type='checkbox' id='dias_m' name='dias2' value='2' checked>L
					<input type='checkbox' id='dias_m' name='dias3' value='3' checked>M
					<input type='checkbox' id='dias_m' name='dias4' value='4' checked>I
					<input type='checkbox' id='dias_m' name='dias5' value='5' checked>J
					<input type='checkbox' id='dias_m' name='dias6' value='6' checked>V
					<input type='checkbox' id='dias_m' name='dias7' value='7' checked>S
					<input type='checkbox' id='dias_m' name='dias1' value='1' checked>D
				</td>
			</tr>
			<tr>
				<td colspan='2'>Horario en el que se aplicara la regla:</td>
			</tr>
			<tr>
				<td colspan='2'>
					Inicio:<input type='text' id='inicio' style='position: relative; z-index: 10;' value='$row[4]' readonly='readonly' size='15'/>
					Fin:<input type='text' id='fin' style='position: relative; z-index: 10;' value='$row[5]'  readonly='readonly' size='15'/>
				</td>
			</tr>
			<tr>
				<td colspan='2'>Seleccione los correos a los que se notificara:</td>
			</tr>
			$correos
			<tr>
				$boton
			</tr>";
		$objResponse->script("setTimeout(function(){llena()}, 200);");
		$objResponse->script("setTimeout(function(){llena2('".str_replace("S:",'',$row[6])."')}, 500);");
		$objResponse->script("setTimeout(function(){agrega_correo()}, 700);");
	}
	$objResponse->assign('detalle_veh','innerHTML',$tabla);
	$objResponse->assign('correosX','value','');
	$objResponse->script("setTimeout('calendario(\"inicio\")',100)");
	$objResponse->script("setTimeout('calendario(\"fin\")',500)");
	$objResponse->assign('correos_varios_2','innerHTML',$datos);
	$objResponse->assign('b_agr','innerHTML',"<img src='img2/email-not-validated-icon.png' align='right' height='20px' title='Ocultar' onclick='xajax_o_correo($veh)'>");
	$objResponse->script("jQuery('#correos_varios_2').fadeIn('slow')");
	return $objResponse;
}
function g_tiempo_motor($veh,$tiempo,$correos,$activo,$folio,$ini,$fin,$T_dias){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$dias='S:';
	for($x=0;$x<count($T_dias);$x++){
		$dias.=$T_dias[$x];
		if($x<(count($T_dias)-1)){
			$dias.=",";
		}
	}
	switch($activo){
		case 0:
			mysql_query("UPDATE gpscondicionalertadet set activo = 0 where folio = $folio and num_veh=$veh");
			$objResponse->assign("correos_varios_2","innerHTML","Datos borrados");
		break;
		case 1:
			$plural='';
			if($tiempo>1){
				$plural='s';
			}
			$ver=mysql_query("Select d.folio,m.descripcion,m.enviaremail,d.duracion ,d.horaini,d.horafin,d.enlosdias
			from gpscondicionalertadet d
			inner join gpscondicionalerta m on d.folio=m.folio
			where d.duracion>0 
			and d.num_geo=0 
			and d.vel_min=-1 
			and d.vel_max=-1 
			and d.id_msjxclave=248 
			and d.entrageo=0 
			and d.salegeo=0 
			and d.activo=0
			and d.duracion>=60
			and m.presolicitapos=-1
			and d.num_veh=$veh");
			$objResponse->assign("correos_varios_2","innerHTML","Datos guardados");
		break;
		case 2:
			mysql_query("UPDATE gpscondicionalertadet set enlosdias='$dias',creacion='".date("Y-m-d H:i:s")."'
			where folio=$folio and num_veh=$veh");
			mysql_query("UPDATE gpscondicionalerta set enviaremail='$correos' where folio=$folio");
			$objResponse->assign("correos_varios_2","innerHTML","Datos actualizados");
		break;
	}
	return $objResponse;
}
function guardar_correos($nombre,$correo){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$correos=mysql_query("select correo from correos_empresa where correo='$correo' and id_empresa=".$sess->get("Ide"));
	if(mysql_num_rows($correos)>0){
		mysql_query("UPDATE correos_empresa SET nombre = '$nombre',activo = 1 WHERE correo = '$correo'");
	}else{
		mysql_query("INSERT INTO correos_empresa VALUES(".$sess->get("Ide").",0,'$nombre','$correo',1)");
	}
	$objResponse->call('xajax_catalogo_sitios',6,$sess->get("Ide"),$sess->get('sta'));
	return $objResponse;
}
function borrar_correo($id_correo){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$correos=mysql_query("SELECT correo FROM correos_empresa WHERE id_correo=$id_correo AND id_empresa=".$sess->get("Ide"));
	$correo=mysql_fetch_array($correos);
	$maestro=mysql_query("SELECT enviaremail,folio FROM gpscondicionalerta WHERE enviaremail like '%".$correo[0]."%' AND activo = 1 
	AND id_empresa = ".$sess->get("Ide"));
	$activos=0;
	if(mysql_num_rows($maestro)>0){
		$nuevos=array();
		while($row=mysql_fetch_array($maestro)){
			$viejos=explode(";",$row[0]);
			if(count($viejos)>1){
				$new=array();
				for($i=0;$i<count($viejos);$i++){
					if($viejos[$i]!=$correo[0]){
						array_push($new,$viejos[$i]);
					}
				}
				$n_correo=join(";",$new);
				mysql_query("UPDATE gpscondicionalerta SET enviaremail = '$n_correo' WHERE folio = ".$row[1]);
			}
			else{
				$activos=1;
				$objResponse->alert("El correo no se puede eliminar por que esta siendo utilizado en una regla de sus vehiculos");
			}
		}
	}
	if($activos==0){
		mysql_query("UPDATE correos_empresa set activo = 0 WHERE id_empresa = ".$sess->get("Ide")." AND id_correo = $id_correo");
	}
	$objResponse->call('xajax_catalogo_sitios',6,$sess->get("Ide"),$sess->get('sta'));
	return $objResponse;
}
function modificar($geo,$nuevo){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	mysql_query("UPDATE geo_time SET nombre='$nuevo' where num_geo=$geo");
	$consulta = "insert into auditabilidad values (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',34,
	'Modificar nombre Geocerca',13,".$sess->get('Ide').",'".get_real_ip()."')";
	mysql_query($consulta);
	$objResponse->assign('modificado','innerHTML',"Actualizado<img src='img2/apply.png' width='15px' height='15px' />");
	$objResponse->call("actualizado",(int)$sess->get("Ide"),$sess->get('sta'));
	$objResponse->script("opener.xajax_opciones()");
	return $objResponse;
}
function Eliminar_sitio($id_sitio,$ide){
	$objResponse = new xajaxResponse();
	$crea_cat="<table border='0' class='fuente' align='left'>";
	$crea_cat .= "<tr><td><input type='button' class='agregar1' value='Importar' ";
	$crea_cat .= " onclick='xajax_crear_categoria(1,$ide)'/>
	<input type='button' class='agregar1' value='Exportar'
	onclick='xajax_exportar($ide)'/></td></tr>";
	$crea_cat .= "</table>";
	$objResponse->assign('categ_sitios','innerHTML',$crea_cat);	
	$cad_elimina="UPDATE sitios SET activo=0 WHERE id_sitio = ".$id_sitio ." and id_empresa = ".$ide;
	$resp = mysql_query($cad_elimina);
	if($resp!=0){
		//$objResponse->alert('Se eliminó el sitio seleccionado');
		$options="";
		$sess =& patSession::singleton('egw', 'Native', $options );
		$consulta = "INSERT INTO auditabilidad values (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',15,
		'Eliminar sitio de interes',13,".$sess->get('Ide').",'".get_real_ip()."')";
		mysql_query($consulta);
		$cad_sitios = "SELECT s.nombre,s.latitud,s.longitud,s.contacto,s.tel1,s.tel2,t.descripcion,s.id_sitio 
			FROM sitios s 
			LEFT OUTER JOIN tipo_sitios t on (t.id_tipo = s.id_tipo) 
			WHERE s.id_empresa = ".$ide." and s.activo=1";
		$resp_sitios = mysql_query($cad_sitios);
		if(mysql_num_rows($resp_sitios) != 0 ){
			$objResponse->script("opener.xajax_opciones()");
			$objResponse->redirect("catalogos.php?tipo=2");
		}
		else{
			$objResponse->alert('No se encontraron sitios de interes para su empresa');
			$objResponse->assign('sitios_interes','innerHTML','');
			$objResponse->script("opener.xajax_opciones()");
			$objResponse->redirect("catalogos.php?tipo=2");
		}
	}else $objResponse->alert('No se puede eliminar el sitio');
  return $objResponse;
}
function eliminar_geocerca($id_geo,$ide,$tipo){
	$objResponse = new xajaxResponse();
		$cad_elimina="UPDATE geo_time SET activo=0 WHERE num_geo = $id_geo AND id_empresa = $ide";
		$options="";
		$sess =& patSession::singleton('egw', 'Native', $options );
		$consulta = "INSERT INTO auditabilidad values (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',16,
		'Eliminar geocerca',13,".$sess->get('Ide').",'".get_real_ip()."')";
		mysql_query($consulta);
		/*
			eliminamos del vehiculo
		*/
		$v_g=mysql_query("SELECT num_veh FROM geo_veh WHERE num_geo=$id_geo");
		if(mysql_num_rows($v_g)>0){
			while($row=mysql_fetch_array($v_g)){
				$sistema=mysql_query("SELECT id_sistema FROM vehiculos WHERE num_veh=".$row[0]);
				$idsistemas=mysql_fetch_array($sistema);
				$idsistema=$idsistemas[0];
				$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
				$query=mysql_query("SELECT index_equipo FROM geo_equipo WHERE num_veh=".$row[0]." AND num_geo=".$id_geo." AND activo=1");
				$index=mysql_fetch_array($query);
				//formamos el comando a enviar al equipo
				$cmd="SETGEO:".$row[0].";%s;".$sess->get("Idu").";".$index[0].";0";
				mysql_query("INSERT INTO notificaweb(id,num_veh,cmd,solicito,id_usuario,origen,respuesta) values(0,".$row[0].",'$cmd','".date("Y-m-d G:i:s")."',".$sess->get("Idu").",'EGW','')");		
				$idRequest=mysql_insert_id();
				$cmd = sprintf($cmd,$idRequest);
				$objResponse->script($equipoGps->sendCMDtoEGServer($cmd));
				mysql_query("UPDATE geo_equipo SET activo = 0 WHERE num_veh = ".$row[0]." AND num_geo = ".$id_geo);
				mysql_query("UPDATE gpscondicionalertadet SET activo = 0 WHERE num_veh = ".$row[0]." AND num_geo = ".$id_geo);
			}
		}
		$resp = mysql_query($cad_elimina);
		if($resp!=0){
			$cad_asig = "UPDATE geo_veh SET activo = 0 WHERE num_geo = $id_geo";
			mysql_query($cad_asig);//elimina las asignaciones de esa geocerca
			if($tipo == 0){
				//$objResponse->alert('Se Eliminó la Geocerca Seleccionada');
			}
			if($tipo == 1){
				$cad_puntos = "UPDATE geo_puntos SET activo = 0 WHERE id_geo = $id_geo";
				$resp_pts = mysql_query($cad_puntos);
				if($resp_pts!=0){
					//$objResponse->alert('Se eliminó la Geocerca Seleccionada');
				}
				else
					$objResponse->alert('No se eliminaron los vertices de la geocerca');
			}
		}
		else{
			$objResponse->script("opener.xajax_opciones()");
			$objResponse->alert('No se Eliminó la Geocerca Seleccionada');
		}
		$cad_sitios = "SELECT num_geo,nombre,IF(tipo = 1,'POLIGONAL','CIRCULAR') AS tipo_geo,tipo 
		FROM geo_time WHERE id_empresa = $ide  AND activo=1 ORDER BY nombre";
		$resp_sitios = mysql_query($cad_sitios);
		if(mysql_num_rows($resp_sitios) != 0 ){
			$tabla_sitios = "<div id='geo_cerca'><table width='630' border='0' id='newspaper-a1'>";
      		$tabla_sitios .= "<tr>";
			$tabla_sitios .= "<th  width='335px'>Nombre</th><th>Tipo</th><th id='modificado' width='100px;'></th></tr>";
			while($fila = mysql_fetch_array($resp_sitios)){
				$tabla_sitios .="<tr><td  width='335px'><input type='text' value='".htmlentities($fila[1])."' id='$fila[0]' size='20' /></td><td>$fila[2]</td>";
				$tabla_sitios .="<td width='45' align='right'>
									<img src='img2/asig_geo.png' style='cursor:pointer;padding:5px;' width='15px' height='15px' title='Modificar Nombre' onclick='modificar($fila[0])' >
									<img src='img/ico_delete.png' style='cursor:pointer;padding:5px;' width='15px' height='15px' border='0' title='Eliminar geocerca' onclick='exe_eliminar_geo($fila[0],$ide,$fila[3])'/>
								</td></tr>";
			}
			$tabla_sitios .= "</table></div>";
			$objResponse->script("opener.xajax_opciones()");
			$objResponse->assign('sitios_interes','innerHTML',$tabla_sitios);
		}
		else{  
			$objResponse->script("opener.xajax_opciones()");
			$objResponse->alert('No se Encontraron Geocercas para su empresa');
			$objResponse->assign('sitios_interes','innerHTML','');
			}
	mysql_close($conec);
  return $objResponse;
}
function crear_categoria($n,$ide){
	$objResponse = new xajaxResponse();
		$cad_cate = "<div align='left'><table border='0' id='newspaper-a1' width='200px' style='z-index:100;'>";
		if($n==0){
    		$cad_cate .="<tr><td colspan='2' >Crear Nueva Categoria:</td></tr>";
    		$cad_cate .="<tr><td>Nombre:</td><td><input type='text' name='nombre' /></td></tr>";
    		$cad_cate .="<tr><td>Imagen:</td><td><input type='file' class='agregar1' name='imagen'  /></td></tr>";
    		$cad_cate .="<tr><td>&nbsp;</td><td><input type='submit' name='enviar' id='button' value='Enviar' class='guardar1'/>";
			$cad_cate .= " <input type='button' name='cancelar' value='Cancelar' class='cancelar1' onclick='xajax_catalogo_sitios(2,$ide)'/></td></tr>";
		}
		if($n==1){
    		
            $cad_cate .= "<tr><td>Importar Sitios de Interes:</td></tr>";
			$cad_cate .= "<tr><td>Seleccione el archivo exportado por el EGStation</td></tr>";
			$cad_cate .= "<tr><td>Nota: Solo archivos CSV </td></tr>";
		    $cad_cate .= "<tr><td>
			<div class='custom-input-file'><input type='file' id='imp_excel' accept='.csv' name='imp_excel' class='input-file' />
			Seleccionar Archivo
				<div class='archivo'>...</div>
			</div>
			</td></tr>";
			$cad_cate .= "<tr><td><input type='submit' name='procesa' value='Procesa' id='procesa' class='guardar1'/>";
			$cad_cate .= " <input type='button' name='cancelar' value='Cancelar' class='cancelar1' onclick='xajax_catalogo_sitios(2,$ide)'/></td></tr>";
		}
    $cad_cate .= "</table></div>";
	$objResponse ->assign('importa_cat','innerHTML','');
	$objResponse ->assign('categ_sitios','innerHTML',$cad_cate);
	return $objResponse;
}
function eliminaUsr($idu){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$ide=$sess->get('Ide');
	$cad_usr = "UPDATE usuarios SET activo=0 WHERE id_usuario = $idu";
	$res_usr = mysql_query($cad_usr);
	if($res_usr){
		$cad_asg="UPDATE veh_usr SET activo=0 WHERE id_usuario=$idu";
	 	mysql_query($cad_asg);
		$consulta = "INSERT INTO auditabilidad VALUES (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',20,
		'Eliminar usuario ($idu)',13,'".$sess->get('Ide')."','".get_real_ip()."')";
		mysql_query($consulta);
		$objResponse->alert("Se eliminó el usuario seleccionado");
		$objResponse->redirect("catalogos.php?tipo=4",1);
	}else $objResponse->alert("Falló la solicitud, intente nuevamente");
	return $objResponse;
}
function crearInterUsr($idup,$ide){
	$objResponse = new xajaxResponse();
	$dsn = "
	<div id='det_usuario1'>
		<form id='frmusuario' action='javascript:void(null);' method='post' name='frmusuario'>
		<div id='usuario2'>Datos generales
			<div id='usuario5a' style='width:230px;'>
			<table id='rounded-corner' style='width:230px'>
				<tr>
					<td>Usuario</td>
					<td><input type='text' size='15' name='usuario' maxlength='10' /></td>
				</tr>
				<tr>
					<td>Contraseña</td>
					<td><input type='password' size='15' name='passw' maxlength='32'/></td>
				</tr>
				<tr>
					<td>Fecha inicio</td>
					<td><input type='text' size='15' name='fecha_ini' id='fecha_ini'  value='".date('Y-m-d')." 00:00:00'/></td>
				</tr>
				<tr>
					<td>Fecha fin</td>
					<td><input type='text' size='15' name='fecha_fin' id='fecha_fin' value='".date('Y-m-d')." 23:59:59'/></td>
				</tr>
				<input type='hidden' name='empresa' value='$ide' />
				<tr>
					<td colspan='2'>
						<input type='image' height='30' width='30' 
						src='img/filesaveas.png' onclick='guardar_usuario();' title='Guardar datos de usuario'/>
					</td>
				</tr>
			</table>
			</div>
		</div>";
	$dsn .= "
	<div id='usuario6'>Funciones
		<div id='usuario5a' style='width:230px;'>
		<table id='rounded-corner' style='width:230px;padding:0px;' >
			<tr>
				<td width='29'><input type='checkbox' value='1' name='perm0'/></td>
				<td width='166'>Solicitud de posición</td>
			</tr>
			<tr>
				<td><input type='checkbox' value='2' name='perm1'/></td>
				<td>Creación de geocercas</td>
			</tr>
			<tr>
				<td><input type='checkbox' value='3' name='perm2'/></td>
				<td>Creación de sitios de interés </td>
			</tr>
			<tr>
				<td><input type='checkbox' value='5' name='perm4'/></td>
				<td>Acceso a reportes</td>
			</tr>
			<tr>
				<td><input type='checkbox' value='6' name='perm5'/></td>
				<td>Acceso a catálogos </td>
			</tr>
			<tr>
				<td><input type='checkbox' value='7' name='perm6'/></td>
				<td>Acceso a configuraciones </td>
			</tr>
			<tr>
				<td><input type='checkbox' value='8' name='perm7'/></td>
				<td>Acceso a 'Mi empresa' </td>
			</tr>
			<tr>
				<td><input type='checkbox' value='9' name='perm8'/></td>
				<td>No mostrar sitios</td>
			</tr>
			<tr>
				<td><input type='checkbox' value='4' name='perm9'/></td>
				<td>No mostrar geocercas</td>
			</tr>
		</table>
		</div>
	</div>";
	$dsn .= "
	<div id='usuario5'>Asignar vehículos
		<div id='usuario5a' style='width:200px;'>
			<table id='rounded-corner' width='190px'>";
	$cad_veh = "
	SELECT distinct(v.NUM_VEH), v.ID_VEH FROM veh_usr AS vu INNER JOIN vehiculos AS v ON vu.NUM_VEH = v.NUM_VEH 
	INNER JOIN estveh ev ON (v.estatus = ev.estatus) WHERE vu.ID_USUARIO = $idup AND vu.activo = 1 AND ev.publicapos = 1 ORDER BY v.ID_VEH ASC";
   	$res_veh = mysql_query($cad_veh);
	while($row = mysql_fetch_array($res_veh)){
		$dsn .= "<tr><td><input type='checkbox' name='vehiculos[]' value='$row[0]'>".utf8_encode($row[1])."</td></tr>";
	}
	$dsn .= "
		</table>
		</div>
	</div>
	</form>
	</div>";
	$objResponse->assign('det_usuario','innerHTML',$dsn);
	return $objResponse;
}
function crearInterUsrMod($idup,$idu,$ide){
	$objResponse = new xajaxResponse();
		$cad_usr = "SELECT username,password,f_inicio,f_termino,permisos FROM usuarios WHERE id_usuario = $idu AND activo = 1";
		$res_usr = mysql_query($cad_usr);
		$rusr = mysql_fetch_row($res_usr);
		$dsn = "
		<div id='det_usuario1'>
			<form id='frmusuario' action='javascript:void(null);' method='post' name='frmusuario'>
				<div id='usuario2'>Datos generales
					<table id='rounded-corner' style='width:250px'>
					<tr>
						<td>Usuario</td>
						<td><input type='text' size='15' name='usuario' maxlength='10' value='$rusr[0]'/></td>
					</tr>
					<tr>
						<td>Contraseña</td>
						<td><input type='password' size='15' name='passw' maxlength='32' value='$rusr[1]' /></td>
					</tr>
					<tr>
						<td>Fecha inicio</td>
						<td><input type='text' size='15' name='fecha_ini' id='fecha_ini' readonly='readonly' value='$rusr[2]'/></td>
					</tr>
					<tr>
						<td>Fecha fin</td>
						<td><input type='text' size='15' name='fecha_fin' id='fecha_fin' readonly='readonly' value='$rusr[3]'/></td>
					</tr>
					<tr>
						<td colspan='2'>
							<input type='image' height='20px' width='20px' src='img/filesaveas.png' onclick='modificar_usuario();' 
							title='Guardar actualización'/>
							<input type='image' height='20px' width='20px' src='img/cancel.png' onclick='cancelarModUsr();' 
							title='Cancelar actualización' />
						</td>
					</tr>
					<input type='hidden' name='empresa' value='$ide' />
					<input type='hidden' name='idusuario' value='$idu' />
				</table>
			</div>";
		$dsn .= "
			<div id='usuario6'>Funciones
				<div id='usuario5a' style='width:230px;'>
				<table id='rounded-corner' style='width:230px;'>";
		$per = strstr($rusr[4],"1");
			if(!empty($per)) 		
				$dsn .= "<tr><td width='29'><input type='checkbox' value='1' name='perm0' checked='checked'/></td>";
			else
				$dsn .= "<tr><td width='29'><input type='checkbox' value='1' name='perm0'/></td>";
		$dsn .= "<td width='166'>Solicitud de posición</td></tr>";
		$per = strstr($rusr[4],"2");
			if(!empty($per)) 		
				$dsn .= "<tr><td><input type='checkbox' value='2' name='perm1' checked='checked'/></td>";
			else
				$dsn .= "<tr><td><input type='checkbox' value='2' name='perm1'/></td>";
		$dsn .= "<td>Creación de geocercas</td></tr>";
		$per = strstr($rusr[4],"3");
			if(!empty($per)) 
				$dsn .= "<tr><td><input type='checkbox' value='3' name='perm2' checked='checked'/></td>";
			else
				$dsn .= "<tr><td><input type='checkbox' value='3' name='perm2'/></td>";
		$dsn .= "<td>Creación de sitios de interés </td></tr>";
		$per = strstr($rusr[4],"4");
			if(!empty($per)) 
				$dsn .= "<!--<tr><td><input type='checkbox' value='4' name='perm3' checked='checked'/>-->";
			else
				$dsn .= "<!--<tr><td><input type='checkbox' value='4' name='perm3'/>-->";		
		$dsn .= "<!--</td><td>Envío de mensajes</td></tr>-->";
		$per = strstr($rusr[4],"5");
			if(!empty($per))
				$dsn .= "<tr><td><input type='checkbox' value='5' name='perm4' checked='checked'/></td>";
			else
				$dsn .= "<tr><td><input type='checkbox' value='5' name='perm4'/></td>";	
		$dsn .= "<td>Acceso a reportes</td></tr>";
		$per = strstr($rusr[4],"6");
			if(!empty($per))
				$dsn .= "<tr><td><input type='checkbox' value='6' name='perm5' checked='checked'/></td>";
			else
				$dsn .= "<tr><td><input type='checkbox' value='6' name='perm5'/></td>";
		$dsn .= "<td>Acceso a catálogos </td></tr>";
		$per = strstr($rusr[4],"7");
			if(!empty($per))
				$dsn .= "<tr><td><input type='checkbox' value='7' name='perm6' checked='checked'/></td>";
			else
				$dsn .= "<tr><td><input type='checkbox' value='7' name='perm6'/></td>";
		$dsn .= "<td>Acceso a configuraciones </td></tr>";
		$per = strstr($rusr[4],"8");
			if(!empty($per))
				$dsn .= "<tr><td><input type='checkbox' value='8' name='perm7' checked='checked'/></td>";
			else
				$dsn .= "<tr><td><input type='checkbox' value='8' name='perm7'/></td>";
		$dsn .= "<td>Acceso a 'Mi empresa' </td></tr>";
		$per = strstr($rusr[4],"9");
			if(!empty($per))
				$dsn .= "<tr><td><input type='checkbox' value='9' name='perm8' checked='checked'/></td>";
			else
				$dsn .= "<tr><td><input type='checkbox' value='9' name='perm8'/></td>";
		$dsn .= "<td>No mostrar sitios</td></tr>";
		$per = strstr($rusr[4],"4");
			if(!empty($per))
				$dsn .= "<tr><td><input type='checkbox' value='4' name='perm9' checked='checked'/></td>";
			else
				$dsn .= "<tr><td><input type='checkbox' value='4' name='perm9'/></td>";
		$dsn .= "<td>No mostrar geocercas</td></tr>
		</table>
		</div>
		</div>";
		$dsn .= "<div id='usuario5'>Asignar vehículos";
		$dsn .= "<div id='usuario5a' style='width:200px;'>
		<table id='rounded-corner'  width='170px'>";
		$cad_veh = "SELECT DISTINCT(v.NUM_VEH), v.ID_VEH FROM veh_usr AS vu INNER JOIN vehiculos AS v ON 
					vu.NUM_VEH = v.NUM_VEH WHERE vu.ID_USUARIO = $idup AND vu.activo = 1 ORDER BY v.ID_VEH ASC";
   		$res_veh = mysql_query($cad_veh);
		while($row = mysql_fetch_array($res_veh)){
			$cad_vusr = "SELECT num_veh FROM veh_usr WHERE num_veh = ".$row[0]." AND activo=1 AND id_usuario = ".$idu;
			$res_vusr = mysql_query($cad_vusr);
			$num = mysql_num_rows($res_vusr);
			if($num==1)
				$dsn .= "<tr><td><input type='checkbox' name='vehiculos[]'  value='$row[0]' checked >".htmlentities($row[1])."</td></tr>";
			else
				$dsn .= "<tr><td><input type='checkbox' name='vehiculos[]' value='$row[0]'>".htmlentities($row[1])."<td></tr>";
		}
		$dsn .= "
		</table></div>
		</div>
		</form></div>";
		$objResponse->script("setTimeout('calendario(\"fecha_ini\")',500)");
		$objResponse->script("setTimeout('calendario(\"fecha_fin\")',600)");
		$objResponse->assign('det_usuario','innerHTML',$dsn);
	return $objResponse;
}
function generaUsr($formUsr){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu=$sess->get('Idu');
	require_once("librerias/conexion.php");
	$empresa    = $formUsr['empresa'];
	$usrNvo    = $formUsr['usuario'];
	$pass      = $formUsr['passw'];
	$fecha_ini = $formUsr['fecha_ini'];
	$fecha_fin = $formUsr['fecha_fin'];
	$fecha_act = date("Y-m-d H:i:s");
	$permisos  = $formUsr['perm0'].$formUsr['perm1'].$formUsr['perm2'].$formUsr['perm3'].$formUsr['perm4'].$formUsr['perm5'].$formUsr['perm6'].$formUsr['perm7'].$formUsr['perm8'].$formUsr['perm9'];
	$vehiculos  = $formUsr['vehiculos'];
	if(!preg_match('/^[a-zA-Z0-9_\.\-]+$/',$usrNvo)){
		$objResponse->alert("EL numbre de usuario no pude llevar espacios");
	}
	else if($usrNvo == ''){
		$objResponse->alert("Inserte el nombre del usuario");
	}else if($pass == ''){
		$objResponse->alert("Inserte la contraseña para el nuevo usuario");
	}else if(count($vehiculos)==0){
		$objResponse->alert("Seleccione minimo un vehiculo");
	}else if(!stringValido($usrNvo) || !stringValido($pass)){
			$objResponse->alert("Inserte usuario y contraseña validos");						
		}else if((date($fecha_ini) < date($fecha_fin)) && (date($fecha_act) < date($fecha_fin)) ){
			$cad_che = "SELECT username FROM usuarios WHERE username = '$usrNvo'";
			$res_che = mysql_query($cad_che);
			$rownum = mysql_num_rows($res_che);
			if($rownum == 0){
				$cad_qry  ="INSERT INTO usuarios(id_empresa,username,password,estatus,f_inicio,f_termino,statusmxc,poleo_web,permisos,usuario_web) 
				VALUES('$empresa','$usrNvo','$pass',3,'$fecha_ini','$fecha_fin','0','1','$permisos',1)";
				$res_qry = mysql_query($cad_qry);
					if($res_qry){
						$idNvo = mysql_insert_id($conec);
						$cad_asg = "INSERT INTO veh_usr VALUES ";
							for($i=0; $i<count($vehiculos); $i++){
								$cad_asg .= "('$empresa','$idNvo','$vehiculos[$i]','0','0','$fecha_ini','$fecha_fin',1,0),";
							}
						$cad_asig = substr($cad_asg,0,strlen($cad_asg)-1);
						mysql_query($cad_asig);
						$consulta = "INSERT INTO auditabilidad VALUES (0,'$idu','".date("Y-m-d H:i:s")."',17,
						'Crear nuevo usuario',13,$empresa,'".get_real_ip()."')";
						mysql_query($consulta);
						$objResponse->alert("Se creó el usuario correctamente");
						$objResponse->redirect("catalogos.php?tipo=4",1);
					} else $objResponse->alert("Fallo el envio, intente nuevamente");
			}else $objResponse->alert("El nombre del usuario ya está registrado en sepromex, favor de intentar con otro nombre de usuario");
		} else $objResponse->alert("La fecha final debe ser mayor a la fecha inicial y a la actual");
	return $objResponse;
}
function modificaUsr($formUsr){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu=$sess->get('Idu');
	//require("librerias/conexion.php");
	$empresa    = $formUsr['empresa'];
	$idusuario  = $formUsr['idusuario'];
	$usrNvo    = $formUsr['usuario'];
	$pass      = $formUsr['passw'];
	$fecha_ini = $formUsr['fecha_ini'];
	$fecha_fin = $formUsr['fecha_fin'];
	$fecha_act = date("Y-m-d H:i:s");
	$permisos  = $formUsr['perm0'].$formUsr['perm1'].$formUsr['perm2'].$formUsr['perm3'].$formUsr['perm4'].$formUsr['perm5'].$formUsr['perm6'].$formUsr['perm7'].$formUsr['perm8'].$formUsr['perm9'];
	$vehiculos  = $formUsr['vehiculos'];
	//$objResponse->alert($permisos );
	if($usrNvo == ''){ 
		$objResponse->alert("Inserte el nombre del usuario");
	}else if($pass == ''){
		$objResponse->alert("Inserte la contraseña para el nuevo usuario");
	}else if($permisos == ''){
		$objResponse->alert("Seleccione minimo una funcion");
	}else if(count($vehiculos)==0){
		$objResponse->alert("Seleccione minimo un vehiculo");
	}else if(!stringValido($usrNvo) || !stringValido($pass)){
		$objResponse->alert("Inserte usuario y contraseña validos");						
	}else if((date($fecha_ini) < date($fecha_fin)) && (date($fecha_act) < date($fecha_fin)) ){
		$numrow = true;
		$cad_che = "SELECT username FROM usuarios WHERE id_usuario <> '$idusuario'";
		$res_che = mysql_query($cad_che);
		while($rowche = mysql_fetch_row($res_che)){
			if($rowche[0] == $usrNvo){
				$numrow = false;
				break;
			}
		}
		if($numrow){
			$cad_qry  = "UPDATE usuarios SET id_empresa='$empresa',username='$usrNvo',password='$pass',estatus='3',
			f_inicio='$fecha_ini',f_termino='$fecha_fin',statusmxc='0',poleo_web='1',permisos='$permisos'
			WHERE id_usuario = $idusuario";
			$res_qry = mysql_query($cad_qry);
			//$objResponse->alert(mysql_error());
				if($res_qry){
					$cad_des="UPDATE veh_usr SET activo = 0 WHERE id_usuario = '$idusuario'";
					mysql_query($cad_des);
					$cad_asg = "INSERT INTO veh_usr VALUES ";
					for($i=0; $i<count($vehiculos); $i++){
						$cad_asg .= "('$empresa','$idusuario','$vehiculos[$i]','0','0','$fecha_ini','$fecha_fin',1,0),";
					}
				$cad_asig = substr($cad_asg,0,strlen($cad_asg)-1);
				mysql_query($cad_asig);
				$consulta = "INSERT INTO auditabilidad VALUES (0,'$idu','".date("Y-m-d H:i:s")."',34,
				'Modificar Usuario',13,$empresa,'".get_real_ip()."')";
				mysql_query($consulta);
				$objResponse->alert("Se modificó el usuario correctamente");
				$objResponse->redirect("catalogos.php?tipo=4",1);
			} else $objResponse->alert("Fallo el envio de datos, intente nuevamente-  $cad_qry");
		}else $objResponse->alert("El nombre del usuario ya está registrado, favor de intentar con otro");
	} else $objResponse->alert("La fecha final debe ser mayor a la fecha inicial y a la actual");
	return $objResponse;
}
function stringValido($cad){
	for($i = 0; $i < strlen($cad); $i++){
		$num = ord($cad[$i]);
		switch($num){
		case (($num >= 48) && ($num <= 57)):
				$ban = true;
		break;
		case (($num >= 65) && ($num <= 90)):
				$ban = true;
		break;
		case (($num >= 97) && ($num <= 122)):
				$ban = true;
		break;
		default: $ban = false;
		}
		if(!$ban){
			break;
		}
	}
	if($ban){
		return $ban;
	}else return $ban;
}
function delCont($idCont){
	$objResponse = new xajaxResponse();
	$cad_cont = "UPDATE contactos SET activo = 0 WHERE id_contacto = $idCont";
	$res_cont = mysql_query($cad_cont);
	if($res_cont != 0){
		$options="";
		$sess =& patSession::singleton('egw', 'Native', $options );
		$consulta = "INSERT INTO auditabilidad VALUES (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',9,
		'Eliminar Contacto',13,".$sess->get('Ide').",'".get_real_ip()."')";
		mysql_query($consulta);
		$objResponse->alert("Se eliminó el contacto");
		$objResponse->redirect("catalogos.php?tipo=5",1.0);
	}else{
		$objResponse->alert("Falló la solicitud, intente nuevamente");
	}
	return $objResponse;
}
function modEmpresa($ide){
	$objResponse = new xajaxResponse();
	$cad_emp = "SELECT nombre,rfc,rep,direccion,colonia,ciudad,tel_ppal,fax FROM empresas WHERE id_empresa = $ide";
	$res_emp = mysql_query($cad_emp);
	$row_emp = mysql_fetch_row($res_emp);
	$dsn = "<form name='empresas' id='empresas' action='javascrip:void(null);' method='post'>";
	$dsn .= "<table border='0' id='newspaper-a1'>";
   	$dsn .= "<tr>";
   	$dsn .= "<td width='160'>Razón social:*</td>";
	$dsn .= "<td colspan='2'><input type='text' name='nombre' value='$row_emp[0]' size='43' /></td>";
   	$dsn .= "</tr>";
  	$dsn .= "<tr>";
	$dsn .= "<td>RFC:*</td>";
	$dsn .= "<td colspan='2'><input type='text' name='rfc' value='$row_emp[1]' size='43' /></td>";
   	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Representante:</td>";
	$dsn .= "<td colspan='2'><input type='text' name='rep' value='$row_emp[2]' size='43' /></td>";
   	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Dirección:*</td>";
	$dsn .= "<td colspan='2'><input type='text' name='dir' value='$row_emp[3]' size='43' /></td>";
   	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Colonia*:</td>";
	$dsn .= "<td colspan='2'><input type='text' name='col' value='$row_emp[4]' size='43' /></td>";
   	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Ciudad:*</td>";
	$dsn .= "<td colspan='2'><input type='text' name='cd' value='$row_emp[5]' size='43' /></td>";
	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Teléfono:*</td>";
	$dsn .= "<td colspan='2'><input type='text' name='tel' value='$row_emp[6]' size='43' /></td>";
   	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Fax:</td>";
	$dsn .= "<td colspan='2'><input type='text' name='fax' value='$row_emp[7]' size='43' /></td>";
   	$dsn .= "</tr>";
	$dsn .= "<tr>";
	$dsn .= "<td colspan='3' align='center'>";
	$dsn .= "<input type='button' onclick='guardarEmpresa($ide)' value='Guardar' class='guardar1' >&nbsp";
	$dsn .= "<input type='button' onclick='xajax_cncEmpresa();' value='Cancelar' class='cancelar1'/>";
	$dsn .= "</td>";
   	$dsn .= "</tr>";
  	$dsn .= "</table>";
	$dsn .= "</form>";
	$objResponse->assign("emp","innerHTML",$dsn);
	return $objResponse;
}
function updEmpresa($formEmp,$ide){
	$objResponse = new xajaxResponse();
	$nombre =  	$formEmp['nombre'];
	$rfc 	=	$formEmp['rfc'];
	$rep 	= 	$formEmp['rep'];
	$dir 	=	$formEmp['dir'];
	$col 	= 	$formEmp['col'];
	$cd 	=	$formEmp['cd'];
	$tel 	= 	$formEmp['tel'];
	$fax 	= 	$formEmp['fax'];
	if($nombre=='' || $rfc=='' || $dir=='' || $col=='' || $cd=='' || $tel==''){
		$objResponse->alert("Revise los campos marcados con *");
		return $objResponse;
	}else{
		$cad_emp  = "UPDATE empresas SET nombre='$nombre',rfc='$rfc',rep='$rep',direccion='$dir',colonia='$col',ciudad='$cd',tel_ppal='$tel',fax='$fax' WHERE id_empresa = $ide";
		$res_emp = mysql_query($cad_emp);
		if($res_emp){
			$options="";
			$sess =& patSession::singleton('egw', 'Native', $options );
			$consulta = "INSERT INTO auditabilidad VALUES (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',10,
			'Actualizar datos de la empresa',13,".$sess->get('Ide').",'".get_real_ip()."')";
			mysql_query($consulta);
			$objResponse->alert("Se actualizaron los datos");
			$objResponse->redirect("catalogos.php?tipo=5",1.0);
		}
		else{
			$objResponse->alert("Falló el envio, intente nuevamente");
		}
		return $objResponse;
	}
}
function cncEmpresa(){
	$objResponse = new xajaxResponse();
	$objResponse->redirect("catalogos.php?tipo=5",0);
	return $objResponse;
}

if($_POST['log']=="Guardar"){
	if($_FILES['imagen']['name'] != ''){
		$load = copy($_FILES['imagen']['tmp_name'], "Logo/".$ide."_".$_FILES['imagen']['name']);
		if($load){
			$imagen = "Logo/".$ide."_".$_FILES['imagen']['name'];
			mysql_query("UPDATE empresas SET logo = '$imagen' WHERE id_empresa = $ide");
			$consulta = "INSERT INTO auditabilidad VALUES (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',11,
			'Subir logo de empresa',13,".$sess->get('Ide').",'".get_real_ip()."')";
			mysql_query($consulta);
		}
	}
}

$xajax->processRequest(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Catálogos</title>
	<link href="css/black.css" rel="stylesheet" type="text/css" />
	<link href="principal/css/ui-darkness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="css/ui-darkness/jquery-ui-1.10.3.custom.css" rel="Stylesheet" />
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="principal/js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
	<style type="text/css">
		#ui-datepicker-div{ font-size: 70%; }
		.ui-timepicker-div .ui-widget-header{ margin-bottom: 8px; }
		.ui-timepicker-div dl{ text-align: left; }
		.ui-timepicker-div dl dt{ height: 25px; }
		.ui-timepicker-div dl dd{ margin: -25px 10px 10px 65px; }
		.ui-timepicker-div td { font-size: 70%; } 
		.ui-dialog { z-index: 300000 !important ;}
	</style>		
	<script type="text/javascript">
	function calendario(id){
		jQuery("#"+id).datetimepicker({
			yearRange: '2014:2020',
			closeText: 'Cerrar',
			prevText: '<Ant',
			nextText: 'Sig>',
			currentText: 'Hoy',
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
			dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
			dayNamesShort: ['Dom','Lun','Mar','Mer','Juv','Vie','Sab'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sab'],
			weekHeader: 'Sm',
			timeFormat: 'hh:mm:ss',
			dateFormat: "yy-mm-dd",
			minDate: -1
		});
	}
	function llena(){
		for(j=1;j<8;j++){
			jQuery('[name=dias' + j + ']').removeAttr('checked');
		}
	}
	function llena2(dias){
		if(!dias.length){
			jQuery('[name=dias' + dias + ']').prop('checked', true);
		}else{
		var	dias=dias.split(",");
			for(i=0;i<dias.length;i++){
				jQuery('[name=dias' + dias[i] + ']').prop('checked', true);
			}
		}
	}
	function gn_correo(veh){
		var checkboxes3 = jQuery("input[id^='dias']");
		var T_dias = Array();
		for(var i=0; i<checkboxes3.length; i++){
			if(checkboxes3[i].checked==true){
				T_dias.push(checkboxes3[i].value);
			}
		}
		if(jQuery("#desc_m").val()=='' || jQuery("#tiempo_m").val()==''){
			alert("Es necesario poner un nombre a esta regla y el tiempo entre cada notificacion");
		}else{
			xajax_gn_correo(veh,jQuery("#desc_m").val(),jQuery("#tiempo_m").val(),jQuery("#correosX").val(),jQuery("#inicio").val(),jQuery("#fin").val(),T_dias);
		}
	}
	function gU_correo(veh,folio){
		var checkboxes3 = jQuery("input[id^='dias']");
		var T_dias = Array();
		for(var i=0; i<checkboxes3.length; i++){
			if(checkboxes3[i].checked==true){
				T_dias.push(checkboxes3[i].value);
			}
		}
		xajax_gU_correo(veh,folio,jQuery("#desc_m").val(),jQuery("#tiempo_m").val(),jQuery("#correosX").val(),jQuery("#inicio").val(),jQuery("#fin").val(),T_dias);
	}
	function agrega_correo(){
		var T_correos = new Array();
		var checkboxes2 = document.getElementsByName("id_correo");
		for(var i=0; i<checkboxes2.length; i++){
			if(checkboxes2[i].checked==true){
				T_correos.push(checkboxes2[i].value);
			}
		}
		xajax_agrega_correo(T_correos);
	}
	</script>
	<script type="text/javascript">
		jQuery(document).ready(function () {
		    jQuery(this).mousemove(function (e) {
		        opener.idleTime = 0;
		    });
		    jQuery(this).keypress(function (e) {
		        opener.idleTime = 0;
		    });
			jQuery( "#info_dialog" ).dialog({
		       autoOpen: false,
		        width: 400,
				zIndex:-12,
		        modal: true,
		        buttons: {
		            Cerrar: function() {
		                jQuery( this ).dialog( "close" );
		            }
		        }
		    });
		    jQuery( "#logs_dialog" ).dialog({
		       autoOpen: false,
		        width: '80%',
				position: ['top', 150],
		        modal: true,
		        draggable:false,
		        buttons: {
		            Cerrar: function() {
		                jQuery( this ).dialog( "close" );
		            }
		        }
		    });
		});	
		function window_veh(id){
		   var mostrar_veh=window.open('vehiculos.php?idu='+id,'vehiculos','width=280,height=250,left=300,top=200,scrollbars=no');
		   childwindows[childwindows.length]=mostrar_veh;
		}
		function elimina_usuario(idu){
			var c = confirm("Está seguro de eliminar este usuario?");
			if(c)
				xajax_eliminaUsr(idu);
		}
		function sust_agregar(obj,idupadre,ide){
			var ident = obj.parentNode;
			ident.innerHTML='<input type="image" width="20" height="20" src="img/cancel.png" title="Cancela acción" onclick="sust_cancel(this,'+idupadre+','+ide+');"/>';
			xajax_crearInterUsr(idupadre,ide);
			setTimeout('calendario("fecha_ini")',800);
			setTimeout('calendario("fecha_fin")',1000);
		}
		function sust_cancel(obj,idupadre,ide){
			var ident = obj.parentNode;
			ident.innerHTML='<input type="image" width="20" height="20" title="Agregar usuario" src="img/agregar1.png" onclick="sust_agregar(this,'+idupadre+','+ide+');"/>';
			document.getElementById('det_usuario').innerHTML = "";
		}
		function fecha(){
				 var cal2 = new calendar3(document.forms["frmusuario"].elements["fecha_ini"]);
				 cal2.year_scroll = true;
				 cal2.time_comp = true; 	 	 
				 document.forms['frmusuario'].elements['fecha_ini'].value = "";
				 javascript:cal2.popup();
		}
		function fecha2(){
				 var cal3 = new calendar1(document.forms["frmusuario"].elements["fecha_fin"]);
		 	 	 cal3.year_scroll = true;
				 cal3.time_comp = true;	 
				 document.forms['frmusuario'].elements['fecha_fin'].value = "";  
				 javascript:cal3.popup();
		}

		function guardar_usuario(){
			
			xajax_generaUsr(xajax.getFormValues("frmusuario"));
		}

		function modificar_usuario(){

			xajax_modificaUsr(xajax.getFormValues("frmusuario"));
		}
		function cancelarModUsr(){

			document.getElementById('det_usuario').innerHTML = '';
		}
		function modContacto(idc,tipo){
			if(idc!=0 && tipo==1){
				window.open('contacto.php?idc='+idc+'&tipo='+tipo,'contacto','width=400,height=380,left=100,top=200,scrollbars=NO');
			}
			if(idc==0 && tipo==0){
				window.open('contacto.php?idc='+idc+'&tipo='+tipo,'contacto','width=400,height=380,left=100,top=200,scrollbars=NO');
			}
		}
		function guardarEmpresa(ide){
			if(confirm("¿Está usted seguro de hacer modificaciones a los datos actuales?"))
				xajax_updEmpresa(xajax.getFormValues("empresas"),ide);
			else
				xajax_cncEmpresa();
		}
		function eliCont(idc){
			if(confirm("¿Está usted seguro de eliminar este contacto?"))
				xajax_delCont(idc);
		}
		function crearFile(obj){
			var objeto = obj.parentNode;
			objeto.innerHTML = '<input type="submit" name="log"  id="log" value="Guardar" class="guardar1"/>';
			document.getElementById('archivo').innerHTML='<input type="file" class="agregar1" name="imagen" accept="image/*" />';
		}
		function guardarArchivo(){

			xajax_updLogo(xajax.getFormValues("empresas"));
		}
		var nC=jQuery.noConflict();
		nC(function() {
			nC( "#modifica_sitio" ).dialog({
				autoOpen: false,
				height: 280,
				width: 300,
				modal: true,
				buttons: {
					"Guardar":function(){
						xajax_update_sitio(nC("#id_sitio").val(),nC("#nombre_sitio").val(),nC("#tipo_sitio").val(),nC("#contacto_sitio").val(),nC("#tel1").val(),nC("#tel2").val());
						nC( this ).dialog( "close" );
					},
				    "Cancelar": function() {
				        nC( this ).dialog( "close" );
				    }
				}
		    });
		});
	</script>
	<script type="text/javascript" src="librerias/func_catalogos.js"></script>
<?php
$xajax->printJavascript();
$tipo=1;

if($_GET['tipo']){
	$tipo=$_GET['tipo'];
}

if($tipo==2){
	$funcion="c_tipo(".$tipo.",".(int)$ide.",". $est.");";
}else{
	$funcion="c_tipo(".$tipo.",".(int)$idu.",". $est.");";
}

?>
</head>
<body id="fondo" style='overflow-x:hidden;width:980px;height:750px; background:url(img2/main-bkg-00.png) transparent repeat;' onload="<? echo $funcion;?>">
	<div id="fondo1" style='width:980px;height:750px;'>
		<div id="fondo2" style='width:980px;height:750px;'>
			<div id="fondo3" style='width:980px;height:750px;'>
				<center>
		            <div id="cuerpo2" width="225" height="156">
			            <div id="cuerpoSuphead" style="width:800px;">
							<div id="logo" style='position:absolute;left:7px;z-index:10;'><img src='img2/logo1.png'></div>
			    		</div>
			            <form action="procesar_imp2.php" method="post" name="importar" enctype="multipart/form-data">
				            <div id="cuerpo_head" style='width:980px;height:700px;' >
								<? include("includes/menu_catalogos.php"); ?>
							</div>
						    <div id="importa_cat" style="visibility:hidden"></div>
				            <div id='cont_autos_cat' style="visibility:hidden"></div>
				            <div  id="detalle_veh" style="visibility:hidden"></div>
				            <div id="categ_sitios" style="visibility:hidden"></div>
				            <div id="sitios_interes" style="visibility:hidden"></div>
				            <div id="correos_empresa" style="position:absolute;top:155px;left:120px;height:400px;visibility:hidden"></div>
					 	</form>
						<div id="emp2_U" style="visibility:hidden">
							<?php 
							if($est != 3){
								$cad_usr = "SELECT id_usuario, username, f_inicio, f_termino FROM usuarios WHERE id_empresa = $ide AND estatus = 3 AND activo=1";
							}else{
								$cad_usr = "SELECT id_usuario, username, f_inicio, f_termino FROM usuarios WHERE id_usuario = $idu AND activo=1";
							}
							$res_usr = mysql_query($cad_usr);
							?>
							<table width='765' border='0' cellspacing='0' id='newspaper-a1' style='margin-top:0px;'>
								<tr>
									<th colspan='4'>&nbsp;</th>
									<th id='acciones'>
									<?php  if($est != 3){?>
										<input type="image" width="20" height="20" title="Crear usuario" 
										src="img/agregar1.png" onclick="sust_agregar(this,<?php echo (int)$idu;?>,<?php echo (int)$ide;?>);"/>
									<?php } ?>
									</th>
								</tr>
								<tr>
									<th>Usuario</th>
									<th>Fecha Inicio </th>
									<th>Fecha Vencimiento </th>
									<th>Vehículos</th>
									<th> </th>
								</tr>
								 <?php 
									setlocale(LC_ALL, 'spanish-mexican');
								 	while($rowusr = mysql_fetch_array($res_usr)){
										echo "<tr>";
										echo "<td width='80'>$rowusr[1]</td>";
										echo "<td width='110'>".strftime('%d de %B, %Y - %H:%M', strtotime($rowusr[2]))."</td>";
										echo "<td width='110'>".strftime('%d de %B, %Y - %H:%M', strtotime($rowusr[3]))."</td>";
										echo "<td width='50'><a href='#' onclick='window_veh(".(int)$rowusr[0].");' style='color:#fdb930;' title='Ver vehículos asignados'>Mostrar</a></td>";
										echo "<td width='10'>";
										if($est != 3){
											echo "<a href='javascript:void(null)' onclick='xajax_crearInterUsrMod(".(int)$idu.",".(int)$rowusr[0].",".(int)$ide.")' ";
											echo "title='Modificar usuario' >";
											echo "<img src='img/kedit.png' width='18px' height='18px'  border='0' /></a>";
											echo "<a href='javascript:void(null)' onclick='elimina_usuario(".(int)$rowusr[0].");' title='Eliminar usuario'>";
											echo "<img src='img/ico_delete.png' width='18px' height='18px' border='0' /></a>";
										}
										echo "</td>";
										echo "</tr>";
									} ?>
							</table>
						</div>
						<div id="det_usuario"></div>
						<div id="emp" style="visibility:hidden" >
				            <form name='empresas' id='empresas' action='catalogos.php?tipo=5' method='post' enctype="multipart/form-data" > 
				             	<?php $cad_emp = "select nombre,rfc,rep,direccion,colonia,ciudad,tel_ppal,fax,logo from empresas where id_empresa = $ide";
				                $res_emp = mysql_query($cad_emp);
				                $row_emp = mysql_fetch_row($res_emp); ?>
				                <table border='0' id="newspaper-a1">
				                    <tr>
				                   		<td colspan="3" style="height:0;"></td>
				                        <td rowspan="10" style="none;" align="center"><img src="<?php echo $row_emp[8] ?>" alt="logo" width="130" height="132" /><br></td>
				                   </tr>
				                   <tr>
				                   		<td width="160px">Razón social:</td>
				                    	<td><?php echo $row_emp[0] ?></td>
				                   </tr>
				                   <tr>
				                    	<td>RFC:</td>
				                    	<td><?php echo $row_emp[1] ?></td>
				                   </tr>
				                   <tr>
				                    	<td>Representante: </td>
				                    	<td><?php echo $row_emp[2] ?></td>
				                   </tr>
				                   <tr>
				                    	<td>Dirección:</td>
				                    	<td><?php echo $row_emp[3] ?></td>
				                   </tr>
				                   <tr>
				                    	<td>Colonia:</td>
				                    	<td><?php echo $row_emp[4] ?></td>
				                   </tr>
				                   <tr>
				                    	<td>Ciudad:</td>
				                    	<td><?php echo $row_emp[5] ?></td>
				                   </tr>
				                   <tr>
				                    	<td>Teléfono:</td>
				                    	<td><?php echo $row_emp[6] ?></td>
				                   </tr>
				                   <tr>
				                    	<td>Fax:</td>
				                    	<td><?php echo $row_emp[7] ?></td>
				                   <tr>
				                   <tr>
										<td  align="right" height="20px" id='archivo' colspan="4"></td>
							   	   </tr>
				                   <tr>
				                    	<td colspan="2">
				                   			<?php if($est!=3){ ?>
				                    		<a href="javascript:void(null);" style="text-decoration:none;" onclick="xajax_modEmpresa(<?php echo $ide; ?>)" title='Actualizar datos de empresa'>
				                    		<input type="button" class="agregar1" name="actualizar" id="actualizar" onclick="xajax_modEmpresa(<?php echo $ide; ?>)" value="Actualizar datos"/>
				                    		</a>
				                    		<?php }?>
				                    	</td>
				                    	<td align="center" colspan="2">
				                             <input type="button" class="agregar1" name="logo"  id="logoimg" onClick="crearFile(this);" value="Cambiar Logo" />
				                    	</td>
				                   </tr>
				                </table>
				            </form>
	        			</div>
	        			<div style="clear:both;"></div>
	        			<div id="emp1" style="visibility:hidden">
							<?php 
				            $cad_con = "SELECT nombre, puesto, telefonos, correo, horario, id_contacto, comentario FROM contactos WHERE id_empresa = '$ide' AND activo = 1 ORDER BY prioridad ASC";
				            $res_con = mysql_query($cad_con); ?>
				            <table id="newspaper-a1">
				                <tr>
				                	<td colspan="5" align="right">
				                  		<?php if($est!=3){ ?>
						                    <a href="javascript:void(null);" onclick="modContacto(0,0)">
						                    <img src="img/agregar1.png" width="20" height="20" border="0" title="Agregar contacto"/>
						                    </a>
						                <?php }?>
					                </td>
				                  	<td>Contactos</td>
				                </tr>
				                <tr>
					                <th width="209">Nombre</th>
					                <th width="121">Puesto</th>
					                <th width="185">Teléfono</th>
					                <th width="101">Correo</th>
					                <th width="78">Horario</th>
					                <th width="94"></th>
				                </tr>
				                	<?php while($rowCon = mysql_fetch_row($res_con)){
					                  echo "<tr title='".$rowCon[6]."'>";
					                  echo "<td width='209' height='27'>".$rowCon[0]."</td>";
					                  echo "<td width='121'>".utf8_encode($rowCon[1])."</td>";
					                  echo "<td width='185'>".$rowCon[2]."</td>";
					                  echo "<td width='101'>".$rowCon[3]."</td>";
					                  echo "<td width='78'>".$rowCon[4]."</td>";
					                  echo "<td width='94'>";
					                  if($est != 3){
					                      echo "<a href='javascript:void(null);' onclick='modContacto($rowCon[5],1);' title='Editar contacto'>";
					                      echo "<img src='img/kedit.png' width='20' height='20' border='0'></a>";
					                      echo "<a href='javascript:void(null);' onclick='eliCont($rowCon[5]);' title='Eliminar contacto'>";
					                      echo "<img src='img/ico_delete.png' width='20' height='20' border='0'></a></td>";
					                  }
					                  echo "</tr>";
					                } ?>
				            </table>
	        			</div>
				        <div id='modifica_sitio' title="ACTUALIZAR SITIOS DE INTERES" align="center"></div>
						<div id='exporta'></div>
						<div id='mostrar_correos_dialog' style='display:none;'></div>
						<div id='info_dialog' style='display:none;'></div>
						<div id='logs_dialog' style='display:none;'></div>
				        <div id='correos_form' style='position:absolute;top:155px;left:750px;display:none;'>
							 <table id="newspaper-a1">
								<tr>
									<td>Nombre:</td>
									<td><input type='text' id='nombre_c'></td>
								</tr>
								<tr>
									<td>Correo:</td>
									<td><input type='text' id='correo_c'></td>
								</tr>
								<tr>
									<td colspan='2'>
										<input type='button' class='guardar1' onclick="guardar_correos()" value='Guardar'>
									</td>
								</tr>
							 </table>
						</div>
	            	</div>	
				</center>
        	</div>
		</div>
	</div>
</body>
</html>