<?php 
include('otro_server.php');
require_once("librerias/conexion.php");
include('ObtenUrl.php');
include('../adodb/adodb.inc.php');
require_once('../FirePHPCore/FirePHP.class.php'); // Clase FirePhp para hace debug con Firebug 
include_once('../patSession/patSession.php');
$options = array('expire'=>40);
$sess =& patSession::singleton('egw', 'Native', $options );
//$sess    =&    patSession::singleton( 'egw' );
//$web = $sess->get("web");
$web = $_SESSION['web'];
$estses = $sess->getState();
$sess->set('veh','');
$sess->set("caduca",0);

if ($estses == '') {
if($web == 1)
	header("Location: indexApa.php?$web");
else header("Location: index.php?$web");		
}

$result = $SESSION[ 'expire-test' ];
if(/*(!patErrorManager::isError($result)) &&*/ ($_SESSION['Idu'])){
	$queryString = $sess->getQueryString();	
	$idu = $_SESSION["Idu"]; $sess->set('Idu', $_SESSION['Idu']);
	$ide = $_SESSION["Ide"]; $sess->set('Ide', $_SESSION['Ide']);
	$usn = $_SESSION["Usn"]; $sess->set('Usn', $_SESSION['Usn']);// nombre de usuario
	$pol = $_SESSION["Pol"]; $sess->set('Pol', $_SESSION['Pol']);
	$reg = $_SESSION['Registrado']; $sess->set('Registrado', $_SESSION['Registrado']);
	$nom = $_SESSION['nom']; $sess->set('nom', $_SESSION['nom']); // nombre
	$prm = $_SESSION["per"]; $sess->set('per', $_SESSION['per']); // 
	$est = $_SESSION['sta']; $sess->set('sta', $_SESSION['sta']);
	//$sit = $sess->get('sit');
	$geocer = $_SESSION['geo'];
	$eve = $_SESSION['eve']; $sess->set('eve', $_SESSION['eve']);
	$evf = $_SESSION['evf']; $sess->set('evf', $_SESSION['evf']);
	$dis = $_SESSION['dis']; $sess->set('dis', $_SESSION['dis']);
	$pan = $_SESSION['pan']; $sess->set('pan',1); //siempre activados
	$veh_actual = $_SESSION['veh']; $sess->set('veh', $_SESSION['veh']); // vehiculo actual
	if(!$reg)
		$sess->set('Registrado',1);
}else{
    $web = $_SESSION[web];
	$sess->Destroy();
	if($web == 1 ){
		header("Location: indexApa.php?$web");
	}else{
		header("Location: index.php?$web");
	}	//caduca la session     	
}

//se registran variables
require('../xajaxs/xajax_core/xajax.inc.php');
$xajax = new xajax(); 
/*if(preg_match('/seprosat/',curPageURL())){
$xajax->configure('javascript URI', 'http://www.sepromex.com.mx:81/'.'xajaxs/');
}
else{
$xajax->configure('javascript URI', '../xajaxs/');
}*/

$xajax->configure('javascript URI', '../xajaxs/');
$xajax->register(XAJAX_FUNCTION,"posicion");
$xajax->register(XAJAX_FUNCTION,"poleo");
$xajax->register(XAJAX_FUNCTION,"mensaje");
$xajax->register(XAJAX_FUNCTION,"sitios_interes");
$xajax->register(XAJAX_FUNCTION,"crear_mapa_sepro");
$xajax->register(XAJAX_FUNCTION,"ver_geocercas");
$xajax->register(XAJAX_FUNCTION,"reg_config");
$xajax->register(XAJAX_FUNCTION,"configuracion");
$xajax->register(XAJAX_FUNCTION,"alertas");
$xajax->register(XAJAX_FUNCTION,"salida");
$xajax->register(XAJAX_FUNCTION,"muestra_alerta");
$xajax->register(XAJAX_FUNCTION,"posicion_alarma");
$xajax->register(XAJAX_FUNCTION,"modo_live");
$xajax->register(XAJAX_FUNCTION,"arreglo");
$xajax->register(XAJAX_FUNCTION,"cambioPass");
$xajax->register(XAJAX_FUNCTION,"color");
$xajax->register(XAJAX_FUNCTION,"statusPanico");
$xajax->register(XAJAX_FUNCTION,'matarSesion');
$xajax->register(XAJAX_FUNCTION,'checandoEstatus');
$xajax->register(XAJAX_FUNCTION,'checandoHorario');
$xajax->register(XAJAX_FUNCTION,'mostrar_vehiculos_act');
$xajax->register(XAJAX_FUNCTION,'mostrar_otros');
$xajax->register(XAJAX_FUNCTION,'guardar_circular');
$xajax->register(XAJAX_FUNCTION,'guardar_poly');
$xajax->register(XAJAX_FUNCTION,'leer_todos');
$xajax->register(XAJAX_FUNCTION,'vel_veh');
$xajax->register(XAJAX_FUNCTION,'elpoleo2');
$xajax->register(XAJAX_FUNCTION,'cargaVehsILSP');
$xajax->register(XAJAX_FUNCTION,'cargaVehsFEMSA');
$xajax->register(XAJAX_FUNCTION,'activaDesRegistro');
$xajax->register(XAJAX_FUNCTION,'activaDesRegistroFemsa');
$xajax->register(XAJAX_FUNCTION,'registra_descarga');
$xajax->register(XAJAX_FUNCTION,'cont_dias');
$xajax->register(XAJAX_FUNCTION,'rutas');
$xajax->register(XAJAX_FUNCTION,'dRuta');
$xajax->register(XAJAX_FUNCTION,'auditabilidad');
$xajax->register(XAJAX_FUNCTION,'user_live');
$xajax->register(XAJAX_FUNCTION,'alertas_pendietnes');
$xajax->register(XAJAX_FUNCTION,'ver_sitio');
$xajax->register(XAJAX_FUNCTION,'set_puntos');//inicial
$xajax->register(XAJAX_FUNCTION,'add_puntos');//add
$xajax->register(XAJAX_FUNCTION,'fin_puntos');//ultimo
$xajax->register(XAJAX_FUNCTION,'del_puntos');//borrar
$xajax->register(XAJAX_FUNCTION,'procesar_ruta');
$xajax->register(XAJAX_FUNCTION,'id_punto');
$xajax->register(XAJAX_FUNCTION,'cambia_ubi');
$xajax->register(XAJAX_FUNCTION,'opciones');
$xajax->register(XAJAX_FUNCTION,'carga_form_sitio');
$xajax->register(XAJAX_FUNCTION,'guarda_sitio');
$xajax->register(XAJAX_FUNCTION,'caducar');
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
function carga_form_sitio($lat,$lon){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu = $sess->get("Idu");
	$ide= $sess->get("Ide");
	$resp_Tsitios = mysql_query("select id_tipo,descripcion from tipo_sitios where id_empresa = $ide or id_empresa = 15");
	$opc=""; 
	while($row_Tsitios = mysql_fetch_row($resp_Tsitios)){
		$opc .="<option value='".$row_Tsitios[0]."'>".htmlentities($row_Tsitios[1])."</option>";			
	}
	
	$form="
	<input type='hidden' id='lat' value='$lat' />
	<input type='hidden' id='lon' value='$lon' />
	<table border='0' cellspacing='0' cellpaddin='0' id='newspaper-a1' style='text-align:left;'>
		<tr>
			<th colspan='2'>Registra Tu Sitio de Interes</th>
		</tr>
		<tr>
			<td>Nombre:</td>
			<td><input type='text' id='nombre_sitio' size='30'/></td>
		</tr>
		<tr>
			<td>Tipo:</td>
			<td>
				<select id='tipo_sitio'>$opc</select>
			</td>
		</tr>
		<tr>
			<td>Contacto:</td>
			<td><input type='text' id='contacto_sitio' size='15' /></td>
		</tr>
		<tr>
			<td>Tel Uno:</td>
			<td><input type='text' id='tel1' size='10'/></td>
		</tr>
		<tr>
			<td>Tel Dos:</td>
			<td><input type='text' name='tel2' size='10' /></td>
		</tr>
	</table>";
	$objResponse->assign("form_sitios",'innerHTML',$form);
	$objResponse->script("nC('#form_sitios').dialog('open')");
	return $objResponse;
}
function guarda_sitio($lat,$lon,$nom_sitio,$tipo,$contacto,$tel1,$tel2){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu = $sess->get("Idu");
	$ide= $sess->get("Ide");
	mysql_query("insert into sitios (id_tipo,nombre,latitud,longitud,contacto,tel1,tel2,id_empresa)
	values ('$tipo','$nom_sitio','$lat','$lon','$contacto','$tel1','$tel2','$ide')");
	mysql_query("insert into auditabilidad values (0,'$idu','".date("Y-m-d H:i:s")."',1,'Creacion de sitios de interes',13,
	$id_empresa,'".get_real_ip()."')");
	$objResponse->script("marker = [];");
	//$objResponse->script("load();");
	$objResponse->script("xajax_opciones()");
	return $objResponse;
}
function caducar($activo){
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$sess->set("caduca",$activo);
}
function opciones(){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu = $sess->get("Idu");
	$ide= $sess->get("Ide");
	//Sitios			
	$genTsit="";
	$cad_cir2="";
	$cad_cir="";
	$spanSit="";
	$muesSit = mysql_query("select s.id_sitio,s.nombre,s.latitud,s.longitud
	from sitios s 
	left outer join tipo_sitios t on (s.id_tipo = t.id_tipo) where s.id_empresa = $ide  
	and s.activo=1 ORDER BY s.nombre ASC");
	$sitios="";
	while ($rowSit = mysql_fetch_row($muesSit)){
		$sitios.="
			<li >
				<input type='checkbox' id='".$rowSit[0]."' 
					value='".$rowSit[0]."' 
					name='sitio' 
					onclick='ver_sitio(".$rowSit[0].")'>
				<a href='#' style='display:inline;'>
					<span title='Clic para ir al sitio' 
					onclick='veh_seleccion(".$rowSit[2].",".$rowSit[3].")' >".
						strtolower(addslashes($rowSit[1]))."
					</span>
				</a>
			</li>";
	}
	
	//geocercas de usuario
	$con_geo = "select G.num_geo,G.nombre,G.tipo,G.latitud,G.longitud,T.descripcion
				from geo_time AS G
				INNER JOIN tipo_geocerca AS T ON G.tipo=T.tipo
				where id_empresa = $ide 
				and g.activo=1 
				and id_usuario=$idu
				order by nombre ASC";
	$res_geo = mysql_query($con_geo);
	
	$geo_user="";
	if(mysql_num_rows($res_geo)>0){
	
		while ($rowGeo = mysql_fetch_row($res_geo)){
			$geo_user.= "<li><input type='checkbox' name='ejec' id='ejec' onclick='contar()' value='".$rowGeo[0]."'/>";
			if($rowGeo[2]==1){ //mandar el foco a la geocerca ya sea circular o poligonal
				$punt = mysql_query("select latitud, longitud 
				from geo_puntos 
				where id_geo = ".$rowGeo[0]." 
				and activo=1 
				order by orden asc 
				limit 1");
				$rowPunt = mysql_fetch_row($punt);
				$geo_user.="<a href='#' style='display:inline;'><span onclick='veh_seleccion(".$rowPunt[0].",".$rowPunt[1].")'>".addslashes($rowGeo[1])."</span></a></li>";
			}
			else{
				$geo_user.="<a href='#' style='display:inline;'><span onclick='veh_seleccion(".$rowGeo[3].",".$rowGeo[4].")'>".addslashes($rowGeo[1])."</span></a></li>";
			}
		}
	}
	//geocercas empresa
	$con_geo = "select G.num_geo,G.nombre,G.tipo,G.latitud,G.longitud,T.descripcion,G.id_usuario
				from geo_time AS G
				INNER JOIN tipo_geocerca AS T ON G.tipo=T.tipo
				where id_empresa = $ide 
				and g.activo=1 
				order by nombre ASC";
	$res_geo = mysql_query($con_geo);
	
	$geo_emp="";
	if(mysql_num_rows($res_geo)){
		while ($rowGeo = mysql_fetch_row($res_geo)){
			$geo_emp.= "<li><input type='checkbox' name='ejec' id='ejec' onclick='contar()' value='".$rowGeo[0]."'/>";
			if($rowGeo[2]==1){ //mandar el foco a la geocerca ya sea circular o poligonal
				$punt = mysql_query("select latitud, longitud 
				from geo_puntos 
				where id_geo = ".$rowGeo[0]." 
				and activo=1 
				order by orden asc 
				limit 1");
				$rowPunt = mysql_fetch_row($punt);
				$geo_emp.="<a href='#' style='display:inline;'><span onclick='veh_seleccion(".$rowPunt[0].",".$rowPunt[1].")'>".addslashes($rowGeo[1])."</span></a></li>";
			}
			else{
				$geo_emp.="<a href='#' style='display:inline;'><span onclick='veh_seleccion(".$rowGeo[3].",".$rowGeo[4].")'>".addslashes($rowGeo[1])."</span></a></li>";
			}
		}
	}
	mysql_close();
	$prm=$sess->get("per");
	$est = $sess->get('sta');
	$contenido="
	<div id='cssmenu'>
		<ul>
		";
	$si = strstr($prm,'9');
	if(($est != 3) ||($est == 3 && empty($si))){
		$contenido.="
				<li class='has-sub'><a href='#'><span>Sitios</span></a>
				  <ul>
				  	<li style='text-decoration: underline;'><input type='checkbox' name='cs' id='cs' onclick='exe_crea_sitios()'>VER TODOS</li>
				  	$sitios
				  	<li class='last'><a href='#'><span>Product 3</span></a></li>
				  </ul>
				</li>";
	}
	$si = strstr($prm,'4');
	if(($est != 3) ||($est == 3 && empty($si))){
		$contenido.="
			<li class='has-sub'><a href='#'><span>Geocercas Empresa</span></a>
			  <ul>
			  	$geo_emp
			  	<li class='last'><a href='#'><span>Product 3</span></a></li>
			  </ul>
			</li>";
	}
	$cheked='';
	if($sess->get('caduca')==1){
		$checked="checked='checked'";
	}
	$contenido.="
			<li class='has-sub'><a href='#'><span>Mis Geocercas</span></a>
			  <ul>
			  	$geo_user
			  </ul>
			</li>
			<li class='last'><input type='checkbox' id='no_caduca' onclick='no_caducar()' $checked><span>No Caducar sesión</span></li>
		</ul>
	</div>";
	//$objResponse->alert($sitios);
	$objResponse->assign("las_opciones",'innerHTML',$contenido);
	$objResponse->script("jQuery('#cssmenu > ul > li > a').click(function() {
	  jQuery('#cssmenu li').removeClass('active');
	  jQuery(this).closest('li').addClass('active');	
	  var checkElement = jQuery(this).next();
	  if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
	    jQuery(this).closest('li').removeClass('active');
	    checkElement.slideUp('normal');
	  }
	  if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
	    jQuery('#cssmenu ul ul:visible').slideUp('normal');
	    checkElement.slideDown('normal');
	  }
	  if(jQuery(this).closest('li').find('ul').children().length == 0) {
	    return true;
	  } else {
	    return false;	
	  }		
	});");
	return $objResponse;
}
function auditabilidad($accion){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu = $sess->get("Idu");
	$app=13;
	$query=mysql_query("select detalle from sepromex.catalogo_auditabilidad where id_app=$app and accion=".$accion);
	$detalles=mysql_fetch_array($query);
	$detalle=$detalles[0];
	$empresa=$sess->get("Ide");;
	$consulta = "insert into sepromex.auditabilidad values (0,$idu,'".date("Y-m-d H:i:s")."',$accion,'$detalle',
	$app,$empresa,'".get_real_ip()."')";
	mysql_query($consulta);
	//$objResponse->alert(mysql_error());
	mysql_close($conec);
	return $objResponse;
}
function procesar_ruta($puntos){
	$objResponse = new xajaxResponse();
	if(count($puntos)==2){
		for($i=0;$i<count($puntos);$i++){
			list($lat,$lon)=explode(",",$puntos[$i]);
			if($i==0){
				$objResponse->script("set_inicio($lat,$lon)");
			}
			else{
				$objResponse->script("set_fin($lat,$lon)");
			}
		}
	}
	else{
		for($i=0;$i<count($puntos);$i++){
			list($lat,$lon)=explode(",",$puntos[$i]);
			if($i==0){
				$objResponse->script("set_inicio($lat,$lon)");
			}
			else{
				$objResponse->script("set_inter($lat,$lon)");	
			}
		}
	}
	$objResponse->script("calcRoute()");
	return $objResponse;
}

function set_puntos($latlon,$num,$total){
	require("librerias/conexion.php");
	if($latlon!='0,0'){
		list($lat,$lon)=explode(",",$latlon);
		$num=$num+1;
		$objResponse = new xajaxResponse();
		$options="";
		$sess =& patSession::singleton('egw', 'Native', $options );
		$ide=$sess->get("Ide");
		$sit=mysql_query("select nombre,id_sitio from sitios where latitud like '%$lat%' and longitud like '%$lon%' 
		and id_empresa=$ide and activo=1");
		if(mysql_num_rows($sit)==0){
			$nom_sit=$latlong;
		}else{
			$n_sit=mysql_fetch_array($sit);
			$nom_sit=$n_sit[0];
		}
		if($total<10){
			$tabla="
			<div id='r_$num' style='cursor:pointer;' class='r_int'>
				<div id='img_$num' style='display:inline;'></div>
				<div id='nom_$num' style='display:inline;'>$nom_sit</div>
				<input type='hidden' name='los_puntos' id='puntos_$num' value='$lat,$lon'>
			</div>";
			$objResponse->prepend("r_inter",'innerHTML',$tabla);
			$objResponse->script("nC('#mis_puntos').dialog('open')");
			$objResponse->script("clearWaypoints()");
			$objResponse->assign("t_puntos",'value',$num);
			$objResponse->script("var latlng=new google.maps.LatLng($lat,$lon);
						var id = $num; // get new id
						xajax_id_punto($num);
						var marcador=new google.maps.Marker({
							position: latlng,
							map: map,
							draggable: true,
							id: id,
							animation: google.maps.Animation.DROP
						})
						markers_rutas.push(marcador);
						google.maps.event.addListener(marcador, 'dragend', function() {
							xajax_cambia_ubi(marcador.getPosition().lat(),marcador.getPosition().lng(),$num);
						});");
		}
		else{
			$objResponse->alert("No puede agregar tantos puntos intermedios");
		}
	}
	mysql_close();
	return $objResponse;
}
function add_puntos($latlong,$num,$total){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	list($lat,$lon)=explode(",",$latlong);
	$num=$num+1;
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$ide=$sess->get("Ide");
	$sit=mysql_query("select nombre,id_sitio from sitios where latitud like '%$lat%' and longitud like '%$lon%' 
	and id_empresa=$ide and activo=1");
	if(mysql_num_rows($sit)==0){
		$nom_sit=$latlong;
	}
	else{
		$n_sit=mysql_fetch_array($sit);
		$nom_sit=$n_sit[0];
	}
	
	if($total<10){
		$tabla="
		<div id='r_$num' style='cursor:pointer;' class='r_int'>
			<div id='img_$num' style='display:inline;'></div>
			<div id='nom_$num' style='display:inline;'>$nom_sit</div>
			<input type='hidden' name='los_puntos' id='puntos_$num' value='$lat,$lon'>
		</div>";
		$objResponse->append("r_inter",'innerHTML',$tabla);
		$objResponse->script("clearWaypoints()");
		$objResponse->script("nC('#mis_puntos').dialog('open')");
		$objResponse->assign("t_puntos",'value',$num);
		$objResponse->script("var latlng=new google.maps.LatLng($lat,$lon);
					var id = $num; // get new id
					xajax_id_punto($num);
					var marcador=new google.maps.Marker({
						position: latlng,
						map: map,
						draggable: true,
						id: id,
						animation: google.maps.Animation.DROP
					})
					markers_rutas.push(marcador);
					google.maps.event.addListener(marcador, 'dragend', function() {
						xajax_cambia_ubi(marcador.getPosition().lat(),marcador.getPosition().lng(),$num);
					});");
	}
	else{
		$objResponse->alert("No puede agregar tantos puntos intermedios");
	}
	mysql_close();
	return $objResponse;
}
function fin_puntos($latlong,$num,$total){
	require("librerias/conexion.php");
	list($lat,$lon)=explode(",",$latlong);
	$num=$num+1;
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$ide=$sess->get("Ide");
	$sit=mysql_query("select nombre,id_sitio from sitios where latitud like '%$lat%' and longitud like '%$lon%' 
	and id_empresa=$ide and activo=1");
	if(mysql_num_rows($sit)==0){
		$nom_sit=$latlong;
	}
	else{
		$n_sit=mysql_fetch_array($sit);
		$nom_sit=$n_sit[0];
	}
	if($total<10){
		$tabla="
		<div id='r_$num' style='cursor:pointer;' class='r_int'>
			<div id='img_$num' style='display:inline;'></div>
			<div id='nom_$num' style='display:inline;'>$nom_sit</div>
			<input type='hidden' name='los_puntos' id='puntos_$num' value='$lat,$lon'>
		</div>";
		$objResponse->append("r_inter",'innerHTML',$tabla);
		$objResponse->script("nC('#mis_puntos').dialog('open')");
		$objResponse->script("clearWaypoints()");
		$objResponse->assign("t_puntos",'value',$num);
		$objResponse->script("var latlng=new google.maps.LatLng($lat,$lon);
					var id = $num; // get new id
					xajax_id_punto($num);
					var marcador=new google.maps.Marker({
						position: latlng,
						map: map,
						draggable: true,
						id: id,
						animation: google.maps.Animation.DROP
					})
					markers_rutas.push(marcador);
					google.maps.event.addListener(marcador, 'dragend', function() {
						xajax_cambia_ubi(marcador.getPosition().lat(),marcador.getPosition().lng(),$num);
					});");
	}
	else{
		$objResponse->alert("No puede agregar tantos puntos intermedios");
	}
	mysql_close();
	return $objResponse;
}
function cambia_ubi($lat,$lon,$num){
	$objResponse = new xajaxResponse();
	$objResponse->assign("puntos_$num",'value',$lat.",".$lon);
	$objResponse->assign("nom_$num",'innerHTML',$lat.",".$lon);
	return $objResponse;
}
function id_punto($num){
	$objResponse = new xajaxResponse();
	$objResponse->append("img_$num",'innerHTML',"<img src='img/ico_delete.png' width='15px' style='cursor:pointer;' 
				onclick='xajax_del_puntos($num,$num)'>");
	return $objResponse;
}
function del_puntos($id){
	$objResponse = new xajaxResponse();
	//$objResponse->alert($num." - ".$id);
	$objResponse->script("del_punto($id);");
	$objResponse->script("nC('#r_$id').remove();");
	$objResponse->script("clearWaypoints()");
	return $objResponse;
}
function user_live(){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	if(/*$sess->get('Idu')==42630 || */$sess->get('Idu')==1094){
		$objResponse->script("load_cliente()");
		$objResponse->script("setTimeout(function(){nC('[name=mark_live]').attr('checked','checked');},1000)");
		$objResponse->script("setTimeout(function(){genera_arreglo()},4000)");
	}
	return $objResponse;
}
function ver_sitio($id){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$cons_sitios = "select s.nombre,s.latitud,s.longitud,s.contacto,s.tel1,s.tel2,t.imagen,t.descripcion from sitios s 
					left outer join tipo_sitios t on (s.id_tipo = t.id_tipo) where s.id_sitio = $id ";
	$sto_int = mysql_query($cons_sitios); //consulta para llenar lista de sitios en funcion js
	while($row=mysql_fetch_array($sto_int)){
		$objResponse->call("crea_sitios",utf8_encode($row[0]),$row[1],$row[2],utf8_encode($row[3]),utf8_encode($row[4]),utf8_encode($row[5]),utf8_encode($row[6]),utf8_encode($row[7]));		
	}
	mysql_close($conec);
	return $objResponse;
}
function dRuta($data,$ini,$fin){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	if(preg_match('/,/',$ini) || preg_match('/,/',$fin)){
		$archivo="rutas/Ruta_".date("Y_m_d_H_i_s").".txt";
	}
	else{
		$archivo="rutas/Ruta_".trim($ini)."_a_".trim($fin)."_".date("Y_m_d_H_i_s").".txt";
	}
	//ini_set('track_errors', 1);
	//$archivo="rutas/Ruta.txt";
	//mkdir("rutas/".$archivo, 0777, true);
	$fp = fopen($archivo, "w");
	
	//$objResponse->alert("valido");
	//return $objResponse;
	
	$x=preg_replace("/(km)/","km\r\n",$data);
	$x2=preg_replace("/(min)/","min\r\n",$x);
	$x3=preg_replace("/\sm(\s|$|\n)/"," m\r\n",$x2);
	fwrite($fp,$x3);
	fclose($fp);
	$form="
	<form name='down_ruta' id='down_ruta' target='_blank' action='descargar_ruta.php' method='post'>
		<input type='hidden' name='archivo' value='$archivo'>
	</form>";
	//$objResponse->script("window.open('$archivo')");
	//$objResponse->append('la_ruta','innerHTML',$form);
	//$objResponse->script('setTimeout("window.open(\"descargar_ruta.php?archivo='.$archivo.'\",\"Descargar Ruta\",\"location=NO,width=500,height=200,left=50,top=0,resizable=NO\")",500)');
	$objResponse->assign("el_iframe",'innerHTML',"<iframe src='descargar_ruta.php?archivo=$archivo' style='display:none;'></iframe>");
	return $objResponse;
}
function rutas(){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$query_gen=mysql_query("SELECT * from sitios where id_empresa=".$sess->get('Ide')." and activo=1 order by nombre");
	if(mysql_num_rows($query_gen)>1){
		$tab="
		<input type='hidden' id='t_puntos' value='1'>
		<table id='newspaper-a1' style='float:left;width:200px;'>
				<tr>
					<td colspan='2'>Seleccione los sitios de interes.</td>
				</tr>
				<tr style='display:none;'>
				  <td>
					<select id='mode' onchange='updateMode()'>
					  <option value='bicycling'>Bicycling</option>
					  <option value='driving' selected>Driving</option>
					  <option value='walking'>Walking</option>
					</select>
				  </td>
				</tr>
				<tr style='display:none;'>
				  <td><input type='checkbox' id='highways'/>Avoid highways</td>
				</tr>";
		/*
			inicio fin con sitios de interes
		*/
		$query=mysql_query("SELECT * from sitios where id_empresa=".$sess->get('Ide')." and activo=1 order by nombre");
		$query1=mysql_query("SELECT * from sitios where id_empresa=".$sess->get('Ide')." and activo=1 order by nombre");
		$query2=mysql_query("SELECT * from sitios where id_empresa=".$sess->get('Ide')." and activo=1 order by nombre");
		$tab.="<tr>
				<td>Inicio:</td>
				<td>
				<select id='inicio_ruta' style='width:180px;' 
				onchange='xajax_set_puntos(this.value,nC(\"#t_puntos\").val(),nC(\".r_int\").length)'>
					<option value='0,0'>Inicio</option>";
					while($row=mysql_fetch_array($query)){
						$tab.="<option value='$row[3]".","."$row[4]'>$row[2]</option>";
					}
		$tab.="
				</select> 
				</td>
			</tr>
			<tr id='los_intermedios' style='display:none;'>
				<td>Intermedios:</td>
				<td>
				<select id='inter_ruta' style='width:180px;' 
				onchange='xajax_add_puntos(this.value,nC(\"#t_puntos\").val(),nC(\".r_int\").length)'>
				<option value='0,0'>Puntos intermedios</option>";
		while($row=mysql_fetch_array($query1)){
			$tab.="<option value='$row[3]".","."$row[4]'>$row[2]</option>";
		}
		$tab.="
				</select> 
				</td>
			</tr>
			<tr>
				<td>Fin:</td>
				<td>
				<select id='fin_ruta' style='width:180px;' 
				onchange='xajax_fin_puntos(this.value,nC(\"#t_puntos\").val(),nC(\".r_int\").length)'>
				<option value='0,0'>Fin</option>";
		while($row=mysql_fetch_array($query2)){
			$tab.="<option value='$row[3]".","."$row[4]'>$row[2]</option>";
		}
		$tab.="
				</select> 
				</td>
			</tr>
			<tr>
				<td colspan='2'><input type='checkbox' id='intermedios' onclick='mostrar_inter();' />Puntos intermedios</td>
			</tr>
			<tr>
				 <td colspan='2'><input type='checkbox' id='tolls' />Evitar casetas</td>
			</tr>
			<tr>
				 <td colspan='2'><input type='checkbox' id='optimize'/>Optimizar Ruta</td>
			</tr>
			<tr>
				 <td colspan='2'><input type='button' class='agregar1' value='Reset' onclick='reset();clear_ruta();' /></td>
			</tr>
		  </table>";
	}
	else{
		$tab="Es necesario que tenga al menos 2 sitios de interes para usar esta herramienta";
	}
	$objResponse->assign('la_ruta','innerHTML',$tab);
	$objResponse->script("reset()");
	$objResponse->script("nC('#la_ruta').dialog('open')");
	$objResponse->script("google.maps.event.clearListeners(map, 'click')");
	$objResponse->script("google.maps.event.addListener(map, 'click', function(event) {
							var myLatLng = event.latLng;
							var lat = myLatLng.lat();
							var lng = myLatLng.lng();
							xajax_add_puntos(lat+','+lng,nC(\"#t_puntos\").val(),nC(\".r_int\").length);
						});");
	mysql_close($conec);
	return $objResponse;
}
function cont_dias(){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$query=mysql_query("SELECT id_usuario from eventos where id_usuario=".$sess->get('Idu')." 
						AND fecha>'".date("Y-m-d 00:00:00")."'");
	if(mysql_num_rows($query)<=5){
		if($sess->get("manual")==0){
			//$objResponse->script("nC('#dialog-herramientas').dialog('open')");
			$sess->set("manual","1");
		}
	}
	//$objResponse->script("nC('#dialog-herramientas').dialog('open')");
	mysql_close($conec);
	return $objResponse;
}
function registra_descarga($tipo){
	/*
		funcion para el historial de descargas
	*/
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	switch($tipo){
		case 1: $mensaje="Se descargo una Actualizacion del EGStation";break;
		case 2: $mensaje="Se descargo una Version Completa del EGStation";break;
		case 3: $mensaje="Se descargo una Actualizacion del EGRepeater";break;
		}
	mysql_query("insert into descargas values(0,".$sess->get("Idu").",".$sess->get("Ide").",'".date("Y-m-d H:i:s")."','$mensaje','".get_real_ip()."')");
	//$objResponse->alert(mysql_error());
	mysql_close($conec);
	return $objResponse;
}	
/*	ILSP  */
function estaActivo($numVeh){
	//$debug=FirePhp::getInstance(true);
	require("librerias/conexion.php");
	$cad="select activo from ilsp_vehactivos where num_veh=$numVeh";
	$query=mysql_query($cad);
	$row=mysql_fetch_array($query);
	//$debug->log($row[0]);
	mysql_close($conec);
	return $row[0];
}
function existe($numVeh){
	require("librerias/conexion.php");
	$cad="select count(*) from  ilsp_vehactivos where num_veh=$numVeh";
	$query=mysql_query($cad);
	$row=mysql_fetch_array($query);
	if($row[0]==1){ 
		return 1;
	}
	else{ 
		return 0;
	}
	mysql_close($conec);
}
function obtenerMaxPos(){
	require("librerias/conexion.php");
	$cad="select max(id_pos) from posiciones";
	$query=mysql_query($cad);
	$row=mysql_fetch_array($query);
	mysql_close($conec);
	return $row[0];
}
function buscaRegistro($numVeh){
	require("librerias/conexion.php");
	$cad="select count(*) from  ilsp_vehactivos where num_veh=$numVeh and activo=1";
	$query=mysql_query($cad);
	$row=mysql_fetch_array($query);
	mysql_close($conec);
	if($row[0]==1) return 1;
	else return 0;
}
function activaDesRegistro($numVeh,$estatus,$pagina){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	//$debug=FirePhp::getInstance(true);
	//$debug->log("Vehiculo:".$numVeh);
	//$debug->log("Estatus".$estatus);
	switch($estatus){
		case 0: $cad="update ilsp_vehactivos set activo=0 where num_veh=$numVeh";
					$query=mysql_query($cad);
					if(!$query){ 
						//$debug->log(mysql_error());
						//$objResponse->alert(mysql_error());
					}
					break;
		case 1: $maxidpos=obtenerMaxPos();
					$existe=existe($numVeh);
					//$debug->log("Existe: ".$existe);
					$fecha=date("Y-m-d H:i:s");
					if($existe==1){ 
						$cad="update ilsp_vehactivos set activo=1, 
						desde_idpos=$maxidpos, marcador_idpos=$maxidpos 
						where num_veh=$numVeh"; 
						$queryU=mysql_query($cad); 
						//$debug->log(mysql_error());
					}
					else {
						mysql_query("insert into ilsp_vehactivos(num_veh,desde_fecha,desde_idpos,marcador_idpos,activo) 
						values($numVeh,'$fecha',$maxidpos,$maxidpos,1)");
					}
					break;
	}
	$objResponse->script("xajax_cargaVehsILSP($pagina)");
	mysql_close($conec);
	return $objResponse;
}
function cargaVehsILSP($pagina){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	//$debug=FirePhp::getInstance(true);
	$idu= $_SESSION['idu'];
	$cad="select v.id_veh, v.num_veh
		from veh_usr as vu
		inner join vehiculos as v on vu.num_veh = v.num_veh
		inner join estveh e on (v.estatus=e.estatus)
		where vu.id_usuario = $idu 
		/*and v.id_empresa=277*/
        and e.publicapos=1 
		and e.activo=1
		and vu.activo=1
		order by v.id_veh asc";
	$query=mysql_query($cad);
	$cont=mysql_num_rows($query);
	$TAMANO_PAGINA = 15;
	$total_paginas = ceil($cont / $TAMANO_PAGINA);
	$num_fila = 0;
    if (!$pagina) {
		$inicio = 0;
		$pagina=1;
	}
	else {
			$inicio = ($pagina - 1) * $TAMANO_PAGINA;
	}
	$tabla="<table width='250px' style='border: 1px solid #A6C9E2;' cellspacing='0' id='newspaper-a1'>
		<tr >
			<th align='center' colspan='2'>Veh&iacute;culos</th>
		</tr>";
	$cad1=$cad." limit ".$inicio.",".$TAMANO_PAGINA;
	//$debug->log($cad1);
	$query1=mysql_query($cad1);
	$i=0;
	while($row=mysql_fetch_array($query1)){
		$existe=buscaRegistro($row[1]);
		if($existe==0){
			if($i%2==0){ 
				$tabla.="
				<tr>
					<td>$row[0]</td>
					<td align='center'>
						<a href='javascript:void(null)' onclick='xajax_activaDesRegistro($row[1],1,$pagina)' >
							<img src='img/agregar1.png' width='16' height='16' title='Habilitar Envio'/>
						</a>
					</td>
				</tr>";  
			}
			else{ 
				$tabla.="
				<tr>
					<td>$row[0]</td>
					<td align='center' width='20px'>
						<a href='javascript:void(null)' onclick='xajax_activaDesRegistro($row[1],1,$pagina)' >
							<img src='img/agregar1.png' width='16' height='16' title='Agregar Vehiculo'/>
						</a>
					</td>
				</tr>";
				}
		}
		$i++;
	}
	$tabla.="</table>
	<table width='250px' id='newspaper-a1' class='ui-widget-content'>";
		if($total_paginas > 1){
			$tabla.= "
			<tr align='right'>
				<td align='center'>
					<b> << </b>";
			for ($i=1;$i<=$total_paginas;$i++){
				if($pagina == $i){
					$tabla.= "<b class='fuente8' style='color: #FFF; font-size: 9pt'>&nbsp;  $pagina  </b> &nbsp;";
				}
				else{
					$tabla.= "
					<a href='javascript:void(null)' onclick='xajax_cargaVehsILSP($i)' style='text-decoration: none'>  
						<b > &nbsp; " . $i . " </b>  &nbsp;
					</a> ";
				}
			}								
			$tabla.= "<b> >> </b>
				</td>
			</tr>";
		} 
	//while($row=mysql_fetch){}
	$tabla.="</table>";
	$tabla2="<table style='border: 1px solid #A6C9E2;' id='newspaper-a1' width='250px' cellspacing='0'>
		<tr align='center'>
			<th colspan='2'>Veh&iacute;culos Activos</th>
		</tr>";
	$cadActivos="select v.id_veh,i.num_veh
		from ilsp_vehactivos i
		inner join vehiculos v on (i.num_veh=v.num_veh)
		where i.activo=1";
	$queryActivos=mysql_query($cadActivos);	
	while($rowActivos=mysql_fetch_array($queryActivos)){
		$tabla2.="
			<tr>
				<td> $rowActivos[0]</td>
				<td align='center' width='20px'>
					<a href='javascript:void(null)' onclick='xajax_activaDesRegistro($rowActivos[1],0,$pagina)'>
						<img src='img/ico_delete.png' width='16' height='16' title='Deshabilitar Envio'/>
					</a>
				</td>
			</tr>";
	}
	$tabla2.="</table>";
	$objResponse->assign('listaVehILSP','innerHTML',$tabla);
	$objResponse->assign('listaActivosILSP','innerHTML',$tabla2);
	mysql_close($conec);
	return $objResponse;
}
/*	TERMINA ILSP  */
/*	FEMSA */
function existeFemsa($numVeh){
	require("librerias/conexion.php");
	$cad="select count(*) from  femsa_vehactivos where num_veh=$numVeh";
	$query=mysql_query($cad);
	$row=mysql_fetch_array($query);
	if($row[0]==1){ 
		return 1;
	}
	else{ 
		return 0;
	}
	mysql_close($conec);
}
function buscaRegistroFemsa($numVeh){
	require("librerias/conexion.php");
	$cad="select count(*) from  femsa_vehactivos where num_veh=$numVeh and activo=1";
	$query=mysql_query($cad);
	$row=mysql_fetch_array($query);
	mysql_close($conec);
	if($row[0]==1) return 1;
	else return 0;
}
function activaDesRegistroFemsa($numVeh,$estatus,$pagina){
 require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	//$debug=FirePhp::getInstance(true);
	//$debug->log("Vehiculo:".$numVeh);
	//$debug->log("Estatus".$estatus);
	switch($estatus){
		case 0: $cad="update femsa_vehactivos set activo=0 where num_veh=$numVeh";
					$query=mysql_query($cad);
					if(!$query){ 
						//$debug->log(mysql_error());
						//$objResponse->alert(mysql_error());
					}
					break;
		case 1: $maxidpos=obtenerMaxPos();
					$existe=existeFemsa($numVeh);
					//$debug->log("Existe: ".$existe);
					$fecha=date("Y-m-d H:i:s");
					if($existe==1){ 
						$cad="update femsa_vehactivos set activo=1, 
						desde_idpos=$maxidpos, marcador_idpos=$maxidpos 
						where num_veh=$numVeh"; 
						$queryU=mysql_query($cad); 
						//$debug->log(mysql_error());
					}
					else {
						mysql_query("insert into femsa_vehactivos(num_veh,desde_fecha,desde_idpos,marcador_idpos,activo) 
						values($numVeh,'$fecha',$maxidpos,$maxidpos,1)");
					}
					break;
	}
	$objResponse->script("xajax_cargaVehsFEMSA($pagina)");
	mysql_close($conec);
	return $objResponse;
}
function cargaVehsFEMSA($pagina){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	//$debug=FirePhp::getInstance(true);
	$idu=$GLOBALS['idu'];
	$cad="select v.id_veh, v.num_veh
		from veh_usr as vu
		inner join vehiculos as v on vu.num_veh = v.num_veh
		inner join estveh e on (v.estatus=e.estatus)
		where vu.id_usuario = $idu 
		/*and v.id_empresa=277*/
        and e.publicapos=1 
		and e.activo=1
		and vu.activo=1
		order by v.id_veh asc";
	$query=mysql_query($cad);
	$cont=mysql_num_rows($query);
	$TAMANO_PAGINA = 15;
	$total_paginas = ceil($cont / $TAMANO_PAGINA);
	$num_fila = 0;
    if (!$pagina) {
		$inicio = 0;
		$pagina=1;
	}
	else {
			$inicio = ($pagina - 1) * $TAMANO_PAGINA;
	}
	$tabla="<table width='250px' style='border: 1px solid #A6C9E2;' cellspacing='0' id='newspaper-a1'>
		<tr >
			<th align='center' colspan='2'>Veh&iacute;culos</th>
		</tr>";
	$cad1=$cad." limit ".$inicio.",".$TAMANO_PAGINA;
	//$debug->log($cad1);
	$query1=mysql_query($cad1);
	$i=0;
	while($row=mysql_fetch_array($query1)){
		$existe=buscaRegistroFemsa($row[1]);
		if($existe==0){
			if($i%2==0){ 
				$tabla.="
				<tr>
					<td>$row[0]</td>
					<td align='center'>
						<a href='javascript:void(null)' onclick='xajax_activaDesRegistroFemsa($row[1],1,$pagina)' >
							<img src='img/agregar1.png' width='16' height='16' title='Habilitar Envio'/>
						</a>
					</td>
				</tr>";  
			}
			else{ 
				$tabla.="
				<tr>
					<td>$row[0]</td>
					<td align='center' width='20px'>
						<a href='javascript:void(null)' onclick='xajax_activaDesRegistroFemsa($row[1],1,$pagina)' >
							<img src='img/agregar1.png' width='16' height='16' title='Agregar Vehiculo'/>
						</a>
					</td>
				</tr>";
				}
		}
		$i++;
	}
	$tabla.="</table>
	<table width='250px' id='newspaper-a1' class='ui-widget-content'>";
		if($total_paginas > 1){
			$tabla.= "
			<tr align='right'>
				<td align='center'>
					<b> << </b>";
			for ($i=1;$i<=$total_paginas;$i++){
				if($pagina == $i){
					$tabla.= "<b class='fuente8' style='color: #FFF; font-size: 9pt'>&nbsp;  $pagina  </b> &nbsp;";
				}
				else{
					$tabla.= "
					<a href='javascript:void(null)' onclick='xajax_cargaVehsFEMSA($i)' style='text-decoration: none'>  
						<b > &nbsp; " . $i . " </b>  &nbsp;
					</a> ";
				}
			}								
			$tabla.= "<b> >> </b>
				</td>
			</tr>";
		} 
	//while($row=mysql_fetch){}
	$tabla.="</table>";
	$tabla2="<table style='border: 1px solid #A6C9E2;' id='newspaper-a1' width='250px' cellspacing='0'>
		<tr align='center'>
			<th colspan='2'>Veh&iacute;culos Activos</th>
		</tr>";
	$cadActivos="select v.id_veh,i.num_veh
		from femsa_vehactivos i
		inner join vehiculos v on (i.num_veh=v.num_veh)
		where i.activo=1";
	$queryActivos=mysql_query($cadActivos);	
	while($rowActivos=mysql_fetch_array($queryActivos)){
		$tabla2.="
			<tr>
				<td> $rowActivos[0]</td>
				<td align='center' width='20px'>
					<a href='javascript:void(null)' onclick='xajax_activaDesRegistroFemsa($rowActivos[1],0,$pagina)'>
						<img src='img/ico_delete.png' width='16' height='16' title='Deshabilitar Envio'/>
					</a>
				</td>
			</tr>";
	}
	$tabla2.="</table>";
	$objResponse->assign('listaVehFEMSA','innerHTML',$tabla);
	$objResponse->assign('listaActivosFEMSA','innerHTML',$tabla2);
	mysql_close($conec);
	return $objResponse;
}

function guardar_circular($nombre,$latitud,$longitud,$radio){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$empresa=$sess->get('Ide');
	$idu=$sess->get('Idu');
	$cad_geo = "insert into geo_time (latitud,longitud,radioMts,agenda,nombre,tipo,id_empresa,id_usuario,activo) 
		values ('$latitud','$longitud','$radio','0','".addslashes($nombre)."','0','$empresa','$idu',1)"; //registrar geocercas circulares
	mysql_query($cad_geo);
	$consulta = "insert into auditabilidad values (0,'$idu','".date("Y-m-d H:i:s")."',3,'Creacion de geocerca circular',
	13,$empresa,'".get_real_ip()."')";
	mysql_query($consulta);
	if(!mysql_error()){
		$objResponse->alert("Se registro su geocerca correctamente");
		$objResponse->script("xajax_opciones()");
	}
	else{
		$objResponse->alert("No se registro su geocerca, intente no poner caracteres especiales");
		$objResponse->script("xajax_opciones()");
	}
	//$objResponse->script("load();");
	mysql_close($conec);
	return $objResponse;
}
function guardar_poly($nombre,$consulta){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$ide=$sess->get('Ide');
	$idu=$sess->get('Idu');
	$cad_geo = "insert into geo_time (latitud,longitud,radioMts,agenda,nombre,id_usuario,tipo,id_empresa,activo) 
		values('0','0','0','0','".addslashes($nombre)."','$idu','1','$ide',1)";
	$consultar = "insert into auditabilidad values (0,'$idu','".date("Y-m-d H:i:s")."',2,'Creacion de sitios de interes',13
	,$ide,'".get_real_ip()."')";
	mysql_query($consultar);
	//$objResponse->alert($cad_geo);
	$resp = mysql_query($cad_geo);
	if($resp != 0){
		$newgeo = mysql_insert_id();
		$consulta = str_replace(",","','",$consulta); 
		$consulta = str_replace("(","('",$consulta); 
		$consulta = str_replace(")","'),",$consulta);
		$consulta = str_replace("),:",")",$consulta);
		$consulta = str_replace("num_geo",$newgeo,$consulta);
		$cad_cons = "insert into geo_puntos (latitud,longitud,orden,id_geo) values $consulta";
		//$objResponse->alert($cad_cons);
		//echo $cad_cons;
		$resp_puntos = mysql_query($cad_cons);
		if($resp_puntos != 0){
			$objResponse->alert("Se guardo la geocerca correctamente");
			$objResponse->script("xajax_opciones()");
		}
		else{
			$objResponse->alert("No se guardo correctamente");
			$objResponse->script("xajax_opciones()");
		}	
	}
	mysql_close($conec);
	return $objResponse;
}
function checandoHorario(){
	$objResponse = new xajaxResponse();
	$horaInicio="2013-03-23 15:00:00";
	$strInicio=strtotime($horaInicio);
	$horaFin="2013-03-25 06:00:00";
	$strFin=strtotime($horaFin);
	$horaActual=strtotime(date("Y-m-d H:i:s"));
	if($horaActual>=$strInicio && $horaActual<=$strFin) $objResponse->script("abreMensajeImportante()");
	return $objResponse;
}
function checandoEstatus($numVeh){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$cadLeyenda="select v.estatus,e.leyenda
				from vehiculos v
				left outer join estveh e on (v.estatus=e.estatus)
				where num_veh=".$numVeh." limit 1";
		$queryLeyenda=mysql_query($cadLeyenda);
		$rowLeyenda=mysql_fetch_array($queryLeyenda);
		if($rowLeyenda[1]!='') $objResponse->alert($rowLeyenda[1]);
		if($rowLeyenda[0]!=52){
		$objResponse->script("ubicacion();");
		}
		else {
		$objResponse->script("load()");
		$sit=$GLOBALS['sit'];
		$geocer=$GLOBALS['geocer'];
		$pan=$GLOBALS['pan'];
		$idu=$GLOBALS['idu'];
		$objResponse->script("xajax_configuracion($sit,$geocer)");
		$objResponse->script("tiempo($idu,$pan,1)"); 
		//$objResponse->script("GUnload()");
		$objResponse->script(" borroDatosPosicion()");
		
		}
	mysql_close($conec);
	return $objResponse;
} 
function matarSesion(){
	// PORQUE REQUERIR LA CONEXION DE NUEVO!? !?!?!?!?!?!?!?!?!?!??!?
	// require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$ide=$sess->get('Ide');
	$idu=$sess->get('Idu');
	$apa=$sess->get('apa'); // Que es esto?
	$consultar = "insert into auditabilidad values (0,'$idu','".date("Y-m-d H:i:s")."',61,'Cerrando sesion',13,$ide,'".get_real_ip()."')";
	// Para que hacer una query que no se utiliza para nada? O_____O
	//mysql_query($consultar);
	//mysql_close($conec);
	$objResponse->script("cerrar_ventanas()");
	$sess->Destroy();
	if($apa==0){
		$objResponse->redirect("index.php?");
	} else {
		$objResponse->redirect("indexApa.php");
	}
	if ($handle = opendir('rutas/')) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$stat=stat("rutas/".$entry);
				if($stat){
					if(date("Y-m-d",$stat['mtime'])<date("Y-m-d")){
						unlink("rutas/".$entry);
					}
				}
			}
		}
		closedir($handle);
	}
	return $objResponse;
} 
function ppolear() {
	
	  //include('../adodb/adodb.inc.php');
	  /*include_once('../patError/patErrorManager.php');
	  patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
	  patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
	  patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );*/
	  include_once('../patSession/patSession.php');
	  $options="";
	  $sess =& patSession::singleton('egw', 'Native', $options );  
	  return $sess->get("Pol");
}
//FUNCION PARA OBTENER LA POSICION REGISTRADA EN LA TABLA ULTIMAPOS
function posicion($aFormValues){
	// LO HIZO DE NUEVO !!!
	// require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$firephp= FirePhp::getInstance(true);
	$idemp = $sess->get("Ide");
	$consulta = "insert into auditabilidad values (0,'".$sess->get("Idu")."','".date("Y-m-d H:i:s")."','35',
	'Ver Posicion',13,".$sess->get("Ide").",'".get_real_ip()."')";
	mysql_query($consulta);
	$veh=$aFormValues;
	$Q="SELECT id_empresa from vehiculos where num_veh=$veh";
	$query=mysql_query($Q);
	$xxx=mysql_fetch_array($query);
	$sess->set("veh",$veh);//asigno a la session
	$hidden="<input type='hidden' id='veh_actual1' value='$veh'>";
	$objResponse->assign('veh_actual','innerHTML',$hidden);
	$cad_msj = "select id_empresa from c_mensajes where id_empresa = $xxx[0]";
	$res_msj = mysql_query($cad_msj);
	
	if(mysql_num_rows($res_msj)){
		$id_emp = $xxx[0];
	}else{
		$id_emp = 15;
	}

	// ERROR en este if
	if($aFormValues!=0){
		$veh=$aFormValues;
		$ayer=strtotime(date("Y-m-d")."-1 day");
		$query="SELECT id from id_pos where fechahora>'".date("Y-m-d H:i:s",$ayer)."' order by id limit 1";
		$ultimas=mysql_query($query);
		$ultima=mysql_fetch_array($ultimas);
		$max_pos='';
		if($ultima[0]>0){
			$max_pos="and p.id_pos>$ultima[0]";
		}
		$datosveh  = "select distinct(v.id_veh),(u.lat/3600/16),((u.long & 8388607)/3600/12*-1),u.mensaje,u.velocidad,u.fecha,
		v.tipoveh,u.t_mensaje,v.id_empresa,u.entradas,u.odometro,u.entradas_a,u.id_tipo,v.id_sistema,
		pm.descripcion,cm.mensaje,p.obsoleto,p.satelites,p.hdop
		from vehiculos v
		left outer join ultimapos u on (v.num_veh = u.num_veh)
		left outer join posiciones p on (v.num_veh = p.num_veh and p.fecha = u.fecha)
		left outer join postmens pm on (pm.t_mensaje = u.t_mensaje)
		left outer join c_mensajes cm on (cm.id_mensaje = u.entradas and cm.id_empresa = $id_emp)
		left outer join estveh s on (v.estatus = s.estatus)
		where v.num_veh = $veh and s.publicapos=1 $max_pos";
		//$firephp-> log($datosveh,'Query');
		$resveh = mysql_query($datosveh);
		if(mysql_num_rows($resveh)==0){
			$datosveh  = "select distinct(v.id_veh),(u.lat/3600/16),((u.long & 8388607)/3600/12*-1),u.mensaje,u.velocidad,u.fecha,
			v.tipoveh,u.t_mensaje,v.id_empresa,u.entradas,u.odometro,u.entradas_a,u.id_tipo,v.id_sistema,
			pm.descripcion,cm.mensaje,p.obsoleto,p.satelites,p.hdop
			from vehiculos v
			left outer join ultimapos u on (v.num_veh = u.num_veh)
			left outer join posiciones p on (v.num_veh = p.num_veh and p.fecha = u.fecha)
			left outer join postmens pm on (pm.t_mensaje = u.t_mensaje)
			left outer join c_mensajes cm on (cm.id_mensaje = u.entradas and cm.id_empresa = $id_emp)
			left outer join estveh s on (v.estatus = s.estatus)
			where v.num_veh = $veh and s.publicapos=1";
			$resveh = mysql_query($datosveh);
		}
		//$objResponse->alert(mysql_error());
		$rowveh = mysql_fetch_array($resveh);
		$v = utf8_encode($rowveh[0]);
		$lat = $rowveh[1];
		$lon = $rowveh[2];		
		$vel = $rowveh[4];
		$fe = $rowveh[5];
		$tipov = $rowveh[6];
		$t_msj = $rowveh[7];
		$empresa = $rowveh[8];
		$clv = $rowveh[9];
		$odo = $rowveh[10];
		$bat = $rowveh[11];
		$idtipo = $rowveh[12];
		$idsis = $rowveh[13];
		//$cruce = $rowveh[14];
		$obsoleto = $rowveh[16];
		$zona=mysql_query("select gmt from veh_gmt where num_veh=$veh");
		if(mysql_num_rows($zona)==0){
			mysql_query("Insert into veh_gmt values($veh,'-5')");
			$dif="+0";
		}
		else{
			$d_z=mysql_fetch_array($zona);
			$dif=(5)+($d_z[0]);
			$fe=date("Y-m-d H:i:s",strtotime($rowveh[5]." $dif hours"));
		}
		//$firephp-> log($cruce,'Cruce:');
		$men   = $rowveh[15];
		$cab_bat=""; 
		$cabe="";
		$cuer_bat="";
		$cabe="";
		$cuerpo="";
		if($idsis == 23 || $idsis == 26){
			if($bat<= 100 && $bat > 90){
				$bateria = "<img src='./img/carga1.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<=90  && $bat >75 ){
				$bateria = "<img src='./img/carga2.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<= 75 && $bat > 60){
				$bateria = "<img src='./img/carga3.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<= 60 && $bat > 48){
				$bateria = "<img src='./img/carga4.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<= 48 && $bat > 30){
				$bateria = "<img src='./img/carga5.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<= 30 && $bat >15){
				$bateria = "<img src='./img/carga6.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<= 15 && $bat >=1){
				$bateria = "<img src='./img/carga7.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat == 0){
				$bateria = "<img src='./img/carga8.png' width='10' height='20' title='$bat %'/>";
			}
			$cab_bat  = "<th>Bateria</th>";
			$cuer_bat = "<td>$bateria</td>";
		}
		if( $idsis == 20 || $idsis == 34  ){//$veh == 67948  || $veh == 66887
			$cabe = "<th>ODO</th>";
			$cuerpo = "<td>$odo</td>";
		}	
		if($t_msj == 2 || $t_msj == 1 || $t_msj == 13)
			$men = $rowveh[3];		
		if($men != ''){
			$img='<img src="./img/msg.png" border = "0" title="'.$men.'" width = "25" height="16" onclick = "alert(\''.$men.'\')" >';
		}
		else
			$img = "&nbsp;";	


		// ERROR EN ESTE IF
		if((($lat != "") || ($lon != "")) && (($lat != 0) || ($lon != 0))){
			$cruce = otro_server($lat,$lon);

			if($cruce==''){//si no trae cruce entra al web service				 			 
			}
			else 
			if( $obsoleto != 1 )
			{
				$calle = $cruce; //si trae cruce no entra al web service y recibe al valor de la consulta
				if($calle != ''){
					//$calle .= " ".sitio_cercano($idemp,$lat,$lon);
				}
			}else $calle = utf8_decode("Posición"). " obsoleta: $cruce";
			$datos = "
			<div id='mostrar_veh' >
				<div style='float:right;'><img onclick='ocultar_veh();' src='img2/cerrar.png' width='20px'></div>
				<table border='0' id='box-table-a' style='width:775px;margin:0px;'>
					<tr class='fuente_siete'>
						<th width='70' align='center'>Veh&iacute;culo</th>
						<th width='70' align='center'>Fecha / Hora</th>
						<th align='center'>Km/H</th>
						$cab_bat 
						$cabe
						<th align='center'>Latitud,Longitud</th>
						<th width='230' align='center'>Ubicaci&oacute;n</th>
						<th align='center'>MSJ</th>
						<th>Satelites</th>
						<!--<th>HDOP</th>-->
					</tr>
					<tr class='fuente_ocho'>";
			$fec1=strtotime($fe,date('Y-m-d h:i:s'));
			$mes=date('n',$fec1);

			switch($mes){
			 case 1: $mess='Ene'; break;
			 case 2: $mess='Feb'; break;
			 case 3: $mess='Mar'; break;
			 case 4: $mess='Abr'; break;
			 case 5: $mess='May'; break;
			 case 6: $mess='Jun'; break;
			 case 7: $mess='Jul'; break;
			 case 8: $mess='Ago'; break;
			 case 9: $mess='Sep'; break;
			 case 10: $mess='Oct'; break;
			 case 11: $mess='Nov'; break;
			 case 12: $mess='Dic'; break;
			}
			//$calle .= " ".sitio_cercano($idemp,$lat,$lon);
			$datos .= "
						<td>".$v."</td>
						<td>".date('d',$fec1).'-'.$mess.'-'.date('Y h:i:s A', $fec1)."</td>
						<td>".$vel."</td>
						$cuer_bat 
						$cuerpo
						<td>".number_format($lat,7,'.','').",".number_format($lon,7,'.','')."</td>
						<td>".utf8_encode($calle)."</td>
						<td>".$img."</td>
						<td align='center'>".$rowveh[17]."</td>
						<!--<td align='center'>".$rowveh[18]."</td>-->
					</tr>
				</table>
			</div>";
			$objResponse->assign('cuerpo_medio','innerHTML',$datos);	 			  
			$objResponse->call("MapaCord", $lat, $lon, $tipov);
			//DAVID
			$Q = "SELECT ( p.lat/3600/16 ),( (p.long & 8388607) /3600 /12*-1 ),v.tipoveh  FROM posiciones p LEFT JOIN vehiculos v ON p.num_veh = v.num_veh 
				  WHERE p.num_veh = '$veh' ORDER BY p.ID_POS DESC limit 10";
			$res_sit = mysql_query($Q);
			$objResponse->script(" elimR()");
			while($row = mysql_fetch_array($res_sit)){
				$objResponse->call("crea_recorrido",$row[0],$row[1],$tipov,0);
			}
			$objResponse->script("mostrarLinea2(0);");
			//DAVID
			$objResponse->script("muestra_cuerpo()");
			
		}else{//Sucede cuando no hay datos de ese vehiculo en la tabla ultimapos
			$objResponse->alert("No hay posición válida del vehículo seleccionado en este momento, 
			vuelva a intentar en unos momentos o envíe un poleo ");
		}
	} else { //si selecciona el valor "0" le decimos al usuario que seleccione un vehiculo de la lista
		$objResponse->alert("Seleccione un vehiculo de la lista."); 
	}
	
	$change="<label onclick='polear($veh);'>Solicitar posici&oacute;n</label>";
	$objResponse->assign('elpoleo','innerHTML',$change);
	// mysql_close($conec);*/
	return $objResponse;		
}
function sitio_cercano($ide,$lat,$lon){
	require("librerias/conexion.php");
	$cad_sit = "select id_sitio,latitud,longitud,nombre from sitios where id_empresa = $ide and activo=1";
	$res_sit = mysql_query($cad_sit);
	$num = mysql_num_rows($res_sit);
	if($num > 0){
		$degtorad = 0.01745329; 
		$radtodeg = 57.29577951; 
		//$resp = "Aprox. a ";
		$i=0;
		while($row = mysql_fetch_array($res_sit)){
			$dlong = ($lon - $row[2]); 
			$dvalue = (sin($lat * $degtorad) * sin($row[1] * $degtorad)) + (cos($lat * $degtorad) * cos($row[1] * $degtorad) * cos($dlong * $degtorad)); 
			$dd = acos($dvalue) * $radtodeg; 
			$km = ($dd * 111.302)*1000;
			$km = number_format($km,1,'.','');
			if($km < 1000){
				$ver[$i]= " a ".(int)$km." Mts de ".$row[3]." ";
			}
			$i++;
		}
		$cercano=min($ver);
		$resp=$cercano;
		mysql_close($conec);
		return $resp;
	}else {
		mysql_close($conec);
		return NULL;
	}
}
//FUNCION PARA PEDIR POSICION ACTUAL DEL VEHICULO.  
function poleo($aFormValues){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );  
	//foreach ($aFormValues['vehiculos'] as $veh);
	$veh=$aFormValues;
	//$objResponse->alert($veh);				
	if ($veh==0){
		$objResponse->alert("Seleccione el vehículo para continuar.");				
	 }
	 else{
		$cad_pol .= "SELECT count(p.num_veh),v.id_veh";
		$cad_pol .= " FROM poleos p";
		$cad_pol .= " left outer join vehiculos v on (v.num_veh = p.num_veh)";
		$cad_pol .= " where p.num_veh = $veh and p.f_inicio like '%".date('Y-m')."%'";
		$cad_pol .= " ORDER BY p.f_inicio";
		$res_pol = mysql_query($cad_pol);
		$poleo = mysql_fetch_row($res_pol);
		//$objResponse->alert(
		if ($poleo[0] <= 90){		
			$pol = ppolear();	 	
			if ($pol == 1) {
				$objResponse->assign("cuerpo_medio","innerHTML",'<img src="img2/loader.gif" width="15px" height="15px" />');
				//$idu = $aFormValues['idusuario'];		
				$idu = $sess->get("Idu");
				$ide = $sess->get("Ide");
				$socket = socket_create(AF_INET, SOCK_DGRAM, 0);
				$conectado = socket_connect($socket, "10.0.2.8", '6668');		//$ipcerebro	
				if ($conectado) {
					$package = "POLL:".$idu.";".$veh;
					socket_send($socket, $package, strlen($package), 0);		
					socket_close($socket);
					$consulta = "insert into auditabilidad values (0,'$idu','".date("Y-m-d H:i:s")."','4',
					'Solicitar Posicion (poleo)',13,$ide,'".get_real_ip()."')";
					mysql_query($consulta);
				}
				else{
					$objResponse->alert("No pudo efectuar la opreación.");						
				}
			$objResponse->call("times2");		
			} 
			else{
				$objResponse->alert("Esta función está restringida para el usuario actual.");						
			}
		}
		else{
			$objResponse->alert("El vehículo ".$poleo->fields[1]." excedió el limite de 90 solicitudes de posiciones al mes");
		}
	}
	mysql_close($conec);
	return $objResponse;	 
}  
//FUNCION PARA ENVIAR MENSAJES.  
function mensaje($aFormValues){
	$objResponse = new xajaxResponse();
	//foreach ($aFormValues['vehiculos'] as $veh);
	$veh=$aFormValues;
	 if ($veh == '') {
		$objResponse->alert("Seleccione el vehículo al que desea enviar el mensaje.");
		return $objResponse;		
	 } 
	 else if (($msgl != "") && ($msgc > 0)) {
				$objResponse->alert("No se puede enviar mensajes libre y por clave al mismo tiempo.");		  
			} else {
				$idu = $aFormValues['idusuario'];
				$msgl = $aFormValues['mensajee'];
				$msgc = $aFormValues['tipom'];	
					if (($msgl != "") && ($msgc > 0)) {
						$objResponse->alert("No se puede enviar mensajes libre y por clave al mismo tiempo.");		  
					}
					else if (($msgl == "") && ($msgc == 0)) {
						$objResponse->alert("No hay mensaje para enviar seleccione una opción o en su caso inserte texto.");		  
					}else{		
						$socket = socket_create(AF_INET, SOCK_DGRAM, 0);
						$cere = socket_connect($socket, "10.0.2.8",'6668');//$ipcerebro
							if(($msgc > 0) && ($msgl == "")) {
			    				$package = "EMAIL:".$idu.";".$veh.",A1".$msgc;
								//$objResponse->alert($package);
								$consulta = "insert into auditabilidad (id_usuario,accion,detalle,id_aplicacion) ";
								$consulta .= "values ('$idu','0002','Envió de Mensaje por Clave',1)";
								mysql_query($consulta);								  
							}else if (($msgl != "") && ($msgc == 0)) {
			    				$package = "EMAIL:".$idu.";".$veh.",A2".$msgl;
								$consulta = "insert into auditabilidad (id_usuario,accion,detalle,id_aplicacion) ";
								$consulta .= "values ('$idu','3','Envió de Mensaje Libre',1)";
								mysql_query($consulta);
						  	}
					$cere2 = socket_send($socket, $package, strlen($package), 0);
					if($cere2){
						$objResponse->alert("Mensaje enviado");
				}
		    	socket_close($socket);
			}
	 	return $objResponse;
	 }  
}  
//consulta sitios de interes personalizados por empresa
function sitios_interes($aFormValues){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
    $firephp= FirePhp::getInstance(true);
	$ide = $aFormValues['id_emp'];
								//					0                  1                 2                  3            4            5            6				7
	$cons_sitios = "select s.nombre,s.latitud,s.longitud,s.contacto,s.tel1,s.tel2,t.imagen,t.descripcion from sepromex.sitios s ";
	$cons_sitios .= "left outer join sepromex.tipo_sitios t on (s.id_tipo = t.id_tipo) where s.id_empresa = $ide and s.activo=1 LIMIT 0, 999";
	$sto_int = mysql_query($cons_sitios); //consulta para llenar lista de sitios en funcion js
	$num = mysql_num_rows($sto_int);
	$firephp -> log($num,"Sitios:");
	$cont = 0;
	if($num != 0){ 
		while($row=mysql_fetch_array($sto_int)){
		    /*if($cont < 50 )
			{*/
		    //$firephp -> log($row,"arreglo:"); 
			$objResponse->call("crea_sitios",utf8_encode($row[0]),$row[1],$row[2],utf8_encode($row[3]),utf8_encode($row[4]),utf8_encode($row[5]),utf8_encode($row[6]),utf8_encode($row[7]));
			//}$cont++;			
		}
	}//else $objResponse->addAlert("No tiene sitios registrados");
	mysql_close($conec);
	return $objResponse;	
}
//crear mapas de sepromex
function crear_mapa_sepro($aFormValues){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	//foreach ($aFormValues['vehiculos'] as $veh);
	$veh=$aFormValues;
	if ($veh == '' ) {
		$objResponse->alert("Seleccione el vehículo.");
		return $objResponse;
	}
	else{
		$zoom = $aFormValues['zoom'];
		$sess =& patSession::singleton('egw', 'Native', $options );
		$idemp = $sess->get("Ide");	
		$cad_msj = "select id_empresa from c_mensajes where id_empresa = $idemp";
		$res_msj = mysql_query($cad_msj);
		if(mysql_num_rows($res_msj)){
			$id_emp = $idemp;
		}else $id_emp = 15;
		//$cad = "todo el tiempo es bueno";	
		$ayer=strtotime(date("Y-m-d")."-1 day");
		$query="SELECT id from id_pos where fechahora>'".date("Y-m-d H:i:s",$ayer)."' order by id limit 1";
		$ultimas=mysql_query($query);
		$ultima=mysql_fetch_array($ultimas);
		$max_pos='';
		if($ultima[0]>0){
			$max_pos="and p.id_pos>$ultima[0]";
		}
		$datosveh  = "select distinct(v.id_veh),(u.lat/3600/16),((u.long & 8388607)/3600/12*-1),u.mensaje,u.velocidad,u.fecha,
		v.tipoveh,u.t_mensaje,v.id_empresa,u.entradas,u.odometro,u.entradas_a,u.id_tipo,v.id_sistema,
		pm.descripcion,cm.mensaje from vehiculos v
		left outer join ultimapos u on (v.num_veh = u.num_veh)
		left outer join posiciones p on (v.num_veh = p.num_veh and p.fecha = u.fecha)
		left outer join postmens pm on (pm.t_mensaje = u.t_mensaje)
		left outer join c_mensajes cm on (cm.id_mensaje = u.entradas and cm.id_empresa = $id_emp)
		where v.num_veh = $veh $max_pos";
		
		$resveh = mysql_query($datosveh);
		//$objResponse->alert($datosveh);//
		$rowveh = mysql_fetch_array($resveh);
		$v = $rowveh[0];
		$lat = $rowveh[1];
		$lon = $rowveh[2];		
		$vel = $rowveh[4];
		$fe = $rowveh[5];
		$tipov = $rowveh[6];
		$t_msj = $rowveh[7];
		$empresa = $rowveh[8];
		$clv = $rowveh[9];
		$odo = $rowveh[10];
		$bat = $rowveh[11];
		$idtipo = $rowveh[12];
		$idsis = $rowveh[13];
		//$cruce = $rowveh[14];
		//$objResponse->alert($cruce); //añadido 29 de febrero
		$men   = $rowveh[15];
		if($idsis == 23 || $idsis == 26){
			if($bat<= 100 && $bat > 90){
				$bateria = "<img src='./img/carga1.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<=90  && $bat >75 ){
				$bateria = "<img src='./img/carga2.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<= 75 && $bat > 60){
				$bateria = "<img src='./img/carga3.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<= 60 && $bat > 48){
				$bateria = "<img src='./img/carga4.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<= 48 && $bat > 30){
				$bateria = "<img src='./img/carga5.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<= 30 && $bat >15){
				$bateria = "<img src='./img/carga6.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<= 15 && $bat >=1){
				$bateria = "<img src='./img/carga7.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat == 0){
				$bateria = "<img src='./img/carga8.png' width='10' height='20' title='$bat %'/>";
			}
			$cab_bat  = "<td>BATERIA</td>";
			$cuer_bat = "<td>$bateria</td>";
		}
		if( $idsis == 20 ){//$veh == 67948  || $veh == 66887
			$cabe = "<th>ODO</th>";
			$cuerpo = "<td>$odo</td>";
		}	
		if($t_msj == 2 || $t_msj == 1)
			$men = $rowveh[3];		
		if($men != ''){
			$img='<img src="./img/msg.png" border = "0" title="'.$men.'" width = "25" height="16" onclick = "alert(\''.$men.'\')" >';
		}
		else{
			$img = "&nbsp;";
		}
		//$objResponse->alert($cruce);
 	    if((($lat != "") || ($lon != "")) && (($lat != 0) || ($lon != 0))){		
			$calle=otro_server($lat,$lon);
			if($calle==''){//si no trae cruce entra al web service
				$calle = "Por el momento no se puede determinar la ubicacion del vehiculo. Disculpe las molestias";
			}
			
			//$calle .= " "/*.sitio_cercano($idemp,$lat,$lon)*/;
			
			$datos = "<div align='right' style='padding-right:10px'><table border='0' style='text-align:center;' bordercolor='#C6D9F1' width='597'";
			$datos .= "cellspacing = '0'><tr style='background:#002B5C' class='fuente_siete'>";
		  	$datos .= "<td width='50'>VEHÍCULO</td><td>FECHA / HORA</td><td>KM/H</td>$cab_bat $cabe<td>LATITUD</td>";
			$datos .= "<td style='padding-left:6px'>LONGITUD</td>";
			$datos .= "<td>UBICACIÓN</td><td>MSJ</td></tr><tr class='fuente_ocho' style='background:#C6D9F1;'>";
			$datos .= "<td>".$v."</td><td>".conv_fecha($fe)."</td><td>".$vel."</td>$cuer_bat $cuerpo<td>".number_format($lat,7,'.','');
			$datos .="</td><td style='padding-left:6px'>".number_format($lon,7,'.','')."</td><td>".htmlentities($calle)."</td>";
			$datos .="<td>".$img."</td></tr></table></div>";			  
		    $objResponse->assign('cuerpo_medio','innerHTML',$datos);	
			$objResponse->script("muestra_cuerpo()");			
			$lat = round($lat * 3600 * 16);
			$lon = round($lon * 3600 * 12 * -1);
			$func = "&lat=%s&lon=%s&tipov=%s&zoom=%s";
  			$func = sprintf($func, $lat, $lon, $tipov, $zoom);
			//$url = '<img src="http://160.16.18.8/MAPAPP/MapGenerate.aspx?height=460&width=596&color=0%s"/>';
			$url = '<img src="http://193.122.129.141:81/MAPAPP/MapGenerate.aspx?height=600&width=1024&color=0%s"/>';
			$url = sprintf($url, $func);
			$url .= "<div id='zoom'><div id='zoommas' onclick='mas_zoom()'>+</div><div id='zoommen' onclick='menos_zoom()'>-</div></div>";
  			$objResponse->assign('cont_mapa_sepro','innerHTML',$url);
			}
			else{//Sucede cuando no hay datos de ese vehiculo en la tabla ultimapos
			 	$objResponse->alert("No hay posición válida del vehículo seleccionado."); 
			}
			mysql_close($conec);
	 	return $objResponse;		
	}
}
//funcion para cambiar el nombre de los mensajes a TitleCase
function  title_case($cadena){ 
	$tamanio=strlen($cadena); 
    $i=0; $anterior= ""; $nueva= ""; //inicializa las variables
    $cadena=strtoupper($cadena); 
		while($i<$tamanio){
			$caracter=substr($cadena,$i,1); 
            if(ereg( "[A-Z]",$anterior)) 
            	$nueva.=strtolower($caracter); 
            else
				$nueva.=strtoupper($caracter); 
         $anterior=$caracter; 
         $i++; 
        } 
   return($nueva); 
}
function ver_geocercas($id_geo){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
								//				0				1					2				3			4					5			6					7
	$cad_geo = "select g.latitud,g.longitud,g.radioMts,g.tipo,p.latitud,p.longitud,p.orden,g.nombre
	from geo_time g	left outer join geo_puntos p on (g.num_geo = p.id_geo)
	where num_geo = $id_geo and g.activo=1 order by p.orden ASC";
	$res_geo = mysql_query($cad_geo);
	//$objResponse->alert(mysql_error());
	$num_geo = mysql_num_rows($res_geo);
	//$objResponse->alert($num_geo);
	if($num_geo == 1){
		$row = mysql_fetch_row($res_geo);
		$radio = $row[2];
		//$objResponse->alert("ENTRA");
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
	mysql_close($conec);
	return $objResponse;
}
function reg_config($idu,$sitio,$cad_geo){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$del_conf = "delete from configuracion where id_usr = $idu";
	$rep_del = mysql_query($del_conf);
	$sess =& patSession::singleton('egw', 'Native', $options );
	$sess->set('sit',"0");
	$sess->set('geo',"");
	if($sitio != 0 || $cad_geo != '-'){
		$tam = strlen($cad_geo);
		$cad_geo = substr($cad_geo,1,$tam-2); 
		$cad_conf = "insert into configuracion (id_usr,sitios,geocercas) values ('$idu','$sitio','$cad_geo')";
		$resp_conf = mysql_query($cad_conf);
			if($resp_conf != 0){
				$sess->set('sit',$sitio);
				$sess->set('geo',$cad_geo);
				$objResponse->alert("Se guardó la configuración");
			 }
			else $objResponse->alert("Falló el Envió. Intente Nuevamente ".mysql_error());
	}
	mysql_close($conec);
	return $objResponse;
}
function configuracion($sit,$geo){
	$objResponse = new xajaxResponse();
	if($sit !=0 || $geo != 0){
		if($sit == 1){
			$objResponse->call("config_sitios"); 
		}
		if($geo != ''){
			$cerca = explode(".",$geo);
			for($i=0; $i<count($cerca); $i++){
				$objResponse->call("ver_geo",$cerca[$i]);
			}
		}
	}
	return $objResponse;
}
function statusPanico(){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$sess->set('pan',0);
	return $objResponse;	
}
function alertas($idu){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	//$firephp= FirePhp::getInstance(true);
	$sess =& patSession::singleton('egw', 'Native', $options );
	$fecha  = $sess->get('eve');
	$evento = $sess->get('evf');
	$ban = $sess->get('ban');
	//$objResponse->alert($fecha);
	
	//cambia estado de la variable de session para poder iniciar con los panicos
	if($sess->get('pan')==0){
		$sess->set('pan',1);
	}	
	
	 $ayer=strtotime(date("Y-m-d")."- 1 day");
	 $cadMax="select max(id_pos) from posiciones where fecha>='".date("Y-m-d",$ayer)." 23:59:00' 
	and fecha<='".date("Y-m-d")." 00:00:00';";
	$fechaPos=date("Y-m-d");
	$fechaPos.=" 00:00:00";
	$tipos=mysql_query("select M.id_mensaje,M.id_empresa from c_mensajes M
						INNER JOIN usuarios U on M.id_empresa=U.id_empresa
						WHERE U.id_usuario=$idu 
						and U.activo=1
						and M.alarma in ('1','T')");
	$i=0;
	if(mysql_num_rows($tipos)==0){
		$tipos=mysql_query("select M.id_mensaje,M.id_empresa from c_mensajes M
						INNER JOIN usuarios U on M.id_empresa=U.id_empresa
						WHERE U.id_empresa=15 
						and M.alarma in ('1','T')");
	}
	while($m_tipos=mysql_fetch_array($tipos)){
		$t_tipos[$i]=$m_tipos[0];
		$t_empresa[$i]=$m_tipos[1];
		$i++;
	}
	$mensajes=join(',',$t_tipos);
	$empresa=join(',',$t_empresa);
	$cad_pos="select a.num_veh
				from alertas_leido a
				left outer join vehiculos vh on(a.num_veh = vh.num_veh)
				left outer join veh_usr v on (v.num_veh = a.num_veh)
				where a.fecha_pos >'$fechaPos' 
				and v.id_usuario=$idu
				and v.activo=1
				and a.atendido=0
				order by a.fecha_pos desc ";  //p.id_pos>
	$res_pos = mysql_query($cad_pos);
	
	$row_pos = mysql_num_rows($res_pos);
	
	$ban=1;
	//if($row_pos[0] == 0 && $ban == 0){ //no hay registros no puede dar click
	/*if($row_pos == 0 && $ban == 0){ //no hay registros no puede dar click
		$act = date('Y-m-d H:i:s');
		$objResponse->assign("num_msj1","innerHTML","<div style='border:solid 1px #d5a010;height:40px; left:2px;'>Sin alertas</div>");
		$sess->set('evf',$act);
		$objResponse->assign("num_msj","innerHTML","<span onclick='xajax_alertas(".number_format($idu, 0, '.', '').");'>Alertas</span>&nbsp;&nbsp;|&nbsp;&nbsp;<span onclick='c_noticia();xajax_mostrar_otros();'>Noticias</span>");
		//$objResponse->alert("entra en ==0 ==0");
	}
	*/
	
	/*
	if($row_pos > 0 && $ban == 0){ //hay registros no a dado click
		//$vistas=mysql_num_rows($segundo);
		$objResponse->assign("num_msj","innerHTML","<span title='Click para mostrar' 
			onclick='c_noticia();xajax_salida($idu);xajax_muestra_alerta($idu,1,".$row_pos.");xajax_alertas(".number_format($idu, 0, '.', '').");'>
			Usted tiene <u>".$row_pos."</u> alertas no leidas</span> <br> <span onclick='c_noticia();xajax_mostrar_otros();'>Noticias</span>");
			//$objResponse->alert("entra en >0 ==0");
		$objResponse->assign("num_msj1","innerHTML","");
		
	}*/
	if($row_pos == 0 && $ban == 1){ //no hay registros no puede dar click
		$act = date('Y-m-d H:i:s');
		$objResponse->assign("num_msj1","innerHTML","<div style='border:solid 1px #d5a010;height:40px; left:2px;'>Sin alertas</div>");
		$sess->set('evf',$act);
		$objResponse->assign("num_msj","innerHTML","<span onclick='xajax_alertas(".number_format($idu, 0, '.', '').");'>Alertas</span>&nbsp;&nbsp;|&nbsp;&nbsp;<span onclick='c_noticia();xajax_mostrar_otros();'>Noticias</span>");
		//$objResponse->alert("entra en ==0 ==1");
	}
	if($row_pos > 0 && $ban == 1){ // hay registros y dio click
		//$vistas=mysql_num_rows($segundo);
		$objResponse->assign("num_msj","innerHTML","<span title='Click para mostrar' 
			onclick='c_noticia();xajax_salida($idu);xajax_muestra_alerta($idu,1,".$row_pos.");xajax_alertas(".number_format($idu, 0, '.', '').");'>
			Usted tiene <u>".$row_pos."</u> alertas no leidas</span><br><span onclick='c_noticia();xajax_mostrar_otros();'>Noticias</span>");
		//$firephp -> log("Entre en hay registros y dio click","Entre:");
		//$objResponse->script('crear()');
		//$objResponse->alert("entra en >0 ==1");//si doy o no click entra aqui
		$objResponse->assign("num_msj1","innerHTML","");
		$objResponse->call('xajax_muestra_alerta',$idu,$ban,$row_pos);	
	}
	mysql_close($conec);
	return $objResponse;
}
function alertas_pendietnes(){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$fechaPos=date("Y-m-d");
	$fechaPos.=" 00:00:00";
	$cad_pos="select a.num_veh
			from alertas_leido a
			left outer join vehiculos vh on(a.num_veh = vh.num_veh)
			left outer join veh_usr v on (v.num_veh = a.num_veh)
			where a.fecha_pos >'$fechaPos' 
			and v.id_usuario=".$sess->get('Idu')."
			and v.activo=1
			and a.atendido=0
			order by a.fecha_pos desc ";  //p.id_pos>
	$res_pos = mysql_query($cad_pos);
	$row_pos = mysql_num_rows($res_pos);
	if($row_pos!=$sess->get('todas_alertas')){
		$nuevas=$row_pos-$sess->get('todas_alertas');
		//$objResponse->alert($sess->get('todas_alertas')."-->".$row_pos);
		$objResponse->script("notificacion($row_pos)");
		$sess->set('todas_alertas',$row_pos);
	}
	$objResponse->script("notificacion($row_pos)");
	//$objResponse->alert($sess->get('todas_alertas')."--".$row_pos);
	mysql_close($conec);
	return $objResponse;
}
function mostrar_vehiculos_act(){//se carga cada 30 segundos
	require("librerias/conexion.php");
	mysql_query("UPDATE alertas_leido SET atendido=1 WHERE lat>3000000");
	$objResponse = new xajaxResponse();
	/*
	$us=mysql_query("SELECT USER()");
	$ub=mysql_fetch_array($us);
	$objResponse->alert($ub[0]);
	*/
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu = $_SESSION["Idu"];
	$cons_veh = "SELECT v.ID_VEH, v.NUM_VEH,v.estatus,ev.publicapos,
				ev.descripcion,p.velocidad,v.id_sistema,
				p.ent1_st,p.ent2_st,p.ent3_st,p.ent4_st,v.id_empresa,p.entradas
				FROM veh_usr AS vu
				Inner join vehiculos AS v ON vu.NUM_VEH = v.NUM_VEH
				inner join estveh ev on (v.estatus = ev.estatus)
				left JOIN ultimapos AS p ON vu.num_veh=p.num_veh
				AND v.num_veh=p.num_veh
				WHERE vu.ID_USUARIO = $idu 
				and ev.publicapos=1
				and vu.activo=1
				group by v.num_veh 
				ORDER BY v.ID_VEH ASC";
	$resp_veh  = mysql_query($cons_veh); 
	$cont= "<table id='newspaper-a1' width='195px' style='padding:0px;margin:0px;'>
			<tr>
				<th style='font-size:14px;width:150px;'>Vehiculo</th>
				<th style='font-size:14px;' colspan='2'>Status</th>
			</tr>";
	$w_accesorio="";
	if(mysql_num_rows($resp_veh)>0){
		while($rows_veh = mysql_fetch_array($resp_veh)){
			//comprovaremos las velocidades configurables
			$img_motor="";
			if($rows_veh[6]==23 || $rows_veh[6]==26 || $rows_veh[6]==61){ //portman (23,26)  uminis (61)
				/*
					PORTMAN
					//entrada 1=Desconectado/conectado 
					//entrada 2=Puerta abierta
				*/
				$terminales=mysql_query("SELECT ent1_st from ultimapos where num_veh=".$rows_veh[1]);
				$img_motor="";
				$terminal=mysql_fetch_array($terminales);
				$puertas=mysql_query("SELECT ent2_st from ultimapos where num_veh=".$rows_veh[1]);
				$puerta=mysql_fetch_array($puertas);
				if($terminal[0]==1 && $puerta[0]==0){
					$img_motor="<img src='img_alertas/conectado.png' style='cursor:pointer;' width='15px' title='Terminal conectada Y puerta cerrada' 
					onclick='ubicacion(".$rows_veh[1].");'>";
				}
				if($terminal[0]==0 && $puerta[0]==1){
					$img_motor="<img src='img_alertas/desconectado.png' style='cursor:pointer;' width='15px' title='Terminal desconectada y puerta abierta' 
					onclick='ubicacion(".$rows_veh[1].");'>";
				}
				if($terminal[0]==1 && $puerta[0]==1){
					$img_motor="<img src='img_alertas/conectado_abierta.png' style='cursor:pointer;' width='15px' title='Terminal conectada Y puerta abierta' 
					onclick='ubicacion(".$rows_veh[1].");'>";
				}
				if($terminal[0]==0 && $puerta[0]==0){
					$img_motor="<img src='img_alertas/desconectado_abierta.png' style='cursor:pointer;' width='15px' title='Terminal desconectada y puerta cerrada' 
					onclick='ubicacion(".$rows_veh[1].");'>";
				}
			}else{
				/*
					buscar en accesorios del vehiculo
					cfg_entxveh and activo=1 //por equipo
					cfg_ent and estatus=1//por empresa
					cfg_entxtequipo //por tipo de equipo
				*/
				$w_accesorio="";
				$title_accesorio="";
				if($rows_veh[7]==1 || $rows_veh[8]==1 || $rows_veh[9]==1 || $rows_veh[10]==1){//entrada activada
					$activada=array();
					if($rows_veh[7]==1){
						array_push($activada,1);
					}
					if($rows_veh[8]==1){
						array_push($activada,2);
					}
					if($rows_veh[9]==1){
						array_push($activada,3);
					}
					if($rows_veh[10]==1){
						array_push($activada,4);
					}
					$ac_eq=mysql_query("SELECT * from cfg_entxveh where num_veh=".$rows_veh[1]." and estatus=1");
					//$objResponse->alert("SELECT * from cfg_entxveh where num_veh=".$rows_veh[1]." and estatus=1");
					
					if(mysql_num_rows($ac_eq)>0){//personalizados
						//buscamos los mensajes por clave 2 a 9
						$w_accesorio=1;
						$b_acc=mysql_fetch_array($ac_eq);
						for($a=0;$a<count($activada);$a++){
							$ini=$activada[$a]*2;
							$fin=$ini+2;
							for($i=$ini;$i<$fin;$i++){
								$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=".$rows_veh[11]." and 
								id_mensaje=".$b_acc[$i]);
								if(mysql_num_rows($d_men)>0){
									$desc=mysql_fetch_array($d_men);
									if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
										$title_accesorio.=$desc[0];
										$id_msj=$b_acc[$i];
									}else{
										if($b_acc[$i]!=0 && $i==$ini){
											$title_accesorio.=$desc[0];
										}
									}
									if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
										$title_accesorio.="/";
									}
								}else{
									$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=15 and 
									id_mensaje=".$b_acc[$i]);
									$desc=mysql_fetch_array($d_men);
									//$objResponse->alert($desc[0]);
									if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
										$title_accesorio.=$desc[0];
										$id_msj=$b_acc[$i];
									}else{
										if($b_acc[$i]!=0 && $i==$ini){
											$title_accesorio.=$desc[0];
										}
									}
									if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
										$title_accesorio.="/";
									}
									//$objResponse->alert($title_accesorio);
								}
							}
							$title_accesorio.=" ";
						}
					}else{
						$ac_emp=mysql_query("SELECT * from cfg_ent where id_empresa=".$rows_veh[11]." and estatus=1");
						if(mysql_num_rows($ac_emp)>0){
							//buscamos mensajes por clave2 a 9
							$w_accesorio=1;
							$b_acc=mysql_fetch_array($ac_emp);
							for($a=0;$a<count($activada);$a++){
								$ini=$activada[$a]*2;
								$fin=$ini+2;
								for($i=$ini;$i<$fin;$i++){
									$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=".$rows_veh[11]." and 
									id_mensaje=".$b_acc[$i]);
									if(mysql_num_rows($d_men)>0){
										$desc=mysql_fetch_array($d_men);
										if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
											$title_accesorio.=$desc[0];
											$id_msj=$b_acc[$i];
										}else{
											if($b_acc[$i]!=0 && $i==$ini){
												$title_accesorio.=$desc[0];
											}
										}
										if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
											$title_accesorio.="/";
										}
									}else{
										$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=15 and 
										id_mensaje=".$b_acc[$i]);
										$desc=mysql_fetch_array($d_men);
										if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
											$title_accesorio.=$desc[0];
											$id_msj=$b_acc[$i];
										}else{
											if($b_acc[$i]!=0 && $i==$ini){
												$title_accesorio.=$desc[0];
											}
										}
										if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
											$title_accesorio.="/";
										}
									}
								}
								$title_accesorio.=" ";
							}
						}else{
							$tipo_e=mysql_query("select tipo_equipo from sistemas where id_sistema=".$rows_veh[6]);
							$tipos=mysql_fetch_array($tipo_e);
							$ac_std=mysql_query("SELECT * from cfg_entxtequipo where tipo_equipo='".$tipos[0]."'");
							if(mysql_num_rows($ac_std)>0){
								//buscamos mensajes por clave2 a 9
								$w_accesorio=1;
								$b_acc=mysql_fetch_array($ac_std);
								for($a=0;$a<count($activada);$a++){
									$ini=($activada[$a]*2)-1;
									$fin=$ini+2;
									for($i=$ini;$i<$fin;$i++){
										$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=".$rows_veh[11]." and 
										id_mensaje=".$b_acc[$i]);
										if(mysql_num_rows($d_men)>0){
											$desc=mysql_fetch_array($d_men);
											if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
												$title_accesorio.=$desc[0];
												$id_msj=$b_acc[$i];
											}else{
												if($b_acc[$i]!=0 && $i==$ini){
													$title_accesorio.=$desc[0];
												}
											}
											if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
												$title_accesorio.="/";
											}
										}else{
											$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=15 and 
											id_mensaje=".$b_acc[$i]);
											$desc=mysql_fetch_array($d_men);
											if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
												$title_accesorio.=$desc[0];
												$id_msj=$b_acc[$i];
											}else{
												if($b_acc[$i]!=0 && $i==$ini){
													$title_accesorio.=$desc[0];
												}
											}
											if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
												$title_accesorio.="/";
											}
										}
									}
									$title_accesorio.=" ";
								}
							}
						}
					}
					//$objResponse->alert($title_accesorio);
					if($w_accesorio==1){
						if($title_accesorio==''){
							$info=mysql_query("select mensaje from c_mensajes where id_mensaje=".$id_msj." and id_empresa=15");
							$dat=mysql_fetch_array($info);
							$title_accesorio=$dat[0];
						}
						//$w_accesorio="<img src='img_alertas/w_accesorio.png' title='$title_accesorio' style='cursor:pointer;'  
						//onclick='alert(\"".trim($title_accesorio)."\")' height='15px'>";
					}
					//$objResponse->alert($title_accesorio);
					if(preg_match('/encendido/i',$title_accesorio)){
						$img_motor="<img src='img_alertas/encendido.png' style='cursor:pointer;' style='cursor:pointer;' width='15px' title='Motor encendido' onclick='ubicacion(".$rows_veh[1].");'>";
					}
					else{
						$img_motor="<img src='img_alertas/apagado.png' style='cursor:pointer;' style='cursor:pointer;' width='15px' title='Motor apagado' onclick='ubicacion(".$rows_veh[1].");'>";
					}
				}
				$w_accesorio="";
				if($img_motor==''){
					$sistemas_invalidos=array(10,14,16,17,18,20,22,25,27,28,30,31,32,33,34,35,43);
					if(!in_array($rows_veh[6],$sistemas_invalidos)){
						$motores=mysql_query("SELECT ignition_st from ultimapos where num_veh=".$rows_veh[1]);
						$img_motor="";
						$motor=mysql_fetch_array($motores);
						if($motor[0]==1){//encendido
							$img_motor="<img src='img_alertas/encendido.png' style='cursor:pointer;' width='15px' title='Motor encendido' onclick='ubicacion(".$rows_veh[1].");'>";
						}else{//apagado
							$img_motor="<img src='img_alertas/apagado.png' style='cursor:pointer;' width='15px' title='Motor apagado' onclick='ubicacion(".$rows_veh[1].");'>";
						}
					}else{//incluimos a los spider y x8
						
						if($rows_veh[5]>8){
							$img_motor="<img src='img_alertas/encendido.png' style='cursor:pointer;' width='15px' title='Motor encendido' onclick='ubicacion(".$rows_veh[1].");'>";
						}else{//apagado
							$img_motor="<img src='img_alertas/apagado.png' style='cursor:pointer;' width='15px' title='Motor apagado' onclick='ubicacion(".$rows_veh[1].");'>";
						}
					}
				}
			}
			$query2="SELECT * FROM config_vel AS C WHERE C.id_usuario = $idu AND C.num_veh = ".$rows_veh[1];
			$qvelocidad=mysql_query($query2);
			if(mysql_num_rows($qvelocidad)==0){//asignamos las velocidades "default"
				if($rows_veh[5]<=8){
					$vel="azul";
				}
				if($rows_veh[5]>8){
					if($rows_veh[5]<46){
						$vel="verde";
					}
					if($rows_veh[5]>=46){
						$vel="amarillo";
					}
					if($rows_veh[5]>=71){
						$vel="naranja";
					}
					if($rows_veh[5]>=101){
						$vel="rojo";
					}
				}
			}else{
				$vel_conf=mysql_fetch_array($qvelocidad);
				if($rows_veh[5]<=8){
					$vel="azul";
				}
				if($rows_veh[5]<=$vel_conf[2] && $rows_veh[5] >=9){
					$vel='verde';
				}
				if($rows_veh[5]<=$vel_conf[3] && $rows_veh[5]>$vel_conf[2]){
					$vel='amarillo';
				}
				if($rows_veh[5]<=$vel_conf[4] && $rows_veh[5]>$vel_conf[3]){
					$vel='naranja';
				}
				if($rows_veh[5]>=$vel_conf[5]){
					$vel='rojo';
				}
			}
			if($vel==''){
				$vel="azul";
			}
			$cont.= "<tr>
					<td style='font-size:12px;word-wrap:break-word;' >
						<a href='#' onclick='ubicacion(".$rows_veh[1].");'>".$rows_veh[0]."</a>
						
					</td>
					<td align='center' id='velocidad".$rows_veh[1]."'>
						$w_accesorio&nbsp;$img_motor&nbsp;<img src='img2/".$vel.".png' style='cursor:pointer;' width='20px' title='".$rows_veh[5]." km/h' onclick='ubicacion(".$rows_veh[1].");'>
					</td>";
			$si = strstr($sess->get("per"),"1");
			if($sess->get('sta') != 3 || !empty($si)){
				$cont.= "
					<td id='elpoleo2'>
						<img src='img2/satelite.png' title='Solicitar posición actual ".$rows_veh[0]."' width='13px' onclick='polear(".$rows_veh[1].");xajax_elpoleo2(".$rows_veh[1].");' style='cursor:pointer;'>
					</td>
				</tr>";
			}else{
				$cont.= "
					<td id='elpoleo2'>
					</td>
				</tr>";
			}				
		}
		$cont.= "</table>";
	}
	else{
		$rows_veh = mysql_fetch_array($resp_veh);
		$cont.=$rows_veh[4];
	}
	$objResponse->assign("vehiculos_act","innerHTML",$cont);
	mysql_close($conec);
	return $objResponse;
}
function elpoleo2($veh){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$hidden="<input type='hidden' id='veh_actual1' value='$veh'>";
	$objResponse->assign("veh_actual","innerHTML",$hidden);
	return $objResponse;
}
function vel_veh(){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	/*
	$us=mysql_query("SELECT USER()");
	$ub=mysql_fetch_array($us);
	$objResponse->alert($ub[0]);
	*/
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu=$sess->get("Idu");
	$cons_veh = "SELECT v.ID_VEH, v.NUM_VEH,v.estatus,ev.publicapos,
				ev.descripcion,p.velocidad,v.id_sistema,
				p.ent1_st,p.ent2_st,p.ent3_st,p.ent4_st,v.id_empresa,p.entradas
				FROM veh_usr AS vu
				Inner join vehiculos AS v ON vu.NUM_VEH = v.NUM_VEH
				inner join estveh ev on (v.estatus = ev.estatus)
				left JOIN ultimapos AS p ON vu.num_veh=p.num_veh
				AND v.num_veh=p.num_veh
				WHERE vu.ID_USUARIO = $idu 
				and ev.publicapos=1
				and vu.activo=1
				group by v.num_veh 
				ORDER BY v.ID_VEH ASC";
	$resp_veh  = mysql_query($cons_veh);
	while($rows_veh = mysql_fetch_row($resp_veh)){
		$query2="SELECT * FROM config_vel  AS C WHERE C.id_usuario = $idu AND C.num_veh = ".$rows_veh[1];
		$img_motor="";
		if($rows_veh[6]==23 || $rows_veh[6]==26){ //portman (23,26) 
			/*
				PORTMAN
				//entrada 1=Desconectado/conectado 
				//entrada 2=Puerta abierta
			*/
			$terminales=mysql_query("SELECT ent1_st from ultimapos where num_veh=".$rows_veh[1]);
			$img_motor="";
			$terminal=mysql_fetch_array($terminales);
			$puertas=mysql_query("SELECT ent2_st from ultimapos where num_veh=".$rows_veh[1]);
			$puerta=mysql_fetch_array($puertas);
			if($terminal[0]==1 && $puerta[0]==0){
				$img_motor="<img src='img_alertas/conectado.png' style='cursor:pointer;' width='15px' title='Terminal conectada Y puerta cerrada' 
				onclick='ubicacion(".$rows_veh[1].");'>";
			}
			if($terminal[0]==0 && $puerta[0]==1){
				$img_motor="<img src='img_alertas/desconectado.png' style='cursor:pointer;' width='15px' title='Terminal desconectada y puerta abierta' 
				onclick='ubicacion(".$rows_veh[1].");'>";
			}
			if($terminal[0]==1 && $puerta[0]==1){
				$img_motor="<img src='img_alertas/conectado_abierta.png' style='cursor:pointer;' width='15px' title='Terminal conectada Y puerta abierta' 
				onclick='ubicacion(".$rows_veh[1].");'>";
			}
			if($terminal[0]==0 && $puerta[0]==0){
				$img_motor="<img src='img_alertas/desconectado_abierta.png' style='cursor:pointer;' width='15px' title='Terminal desconectada y puerta cerrada' 
				onclick='ubicacion(".$rows_veh[1].");'>";
			}
		}
		else{
			/*
				buscamos accesorios
			*/
			$w_accesorio="";
			$title_accesorio="";
			if($rows_veh[7]==1 || $rows_veh[8]==1 || $rows_veh[9]==1 || $rows_veh[10]==1){//entrada activada
				$activada=array();
				if($rows_veh[7]==1){
					array_push($activada,1);
				}
				if($rows_veh[8]==1){
					array_push($activada,2);
				}
				if($rows_veh[9]==1){
					array_push($activada,3);
				}
				if($rows_veh[10]==1){
					array_push($activada,4);
				}
				$ac_eq=mysql_query("SELECT * from cfg_entxveh where num_veh=".$rows_veh[1]." and estatus=1");
				if(mysql_num_rows($ac_eq)>0){//personalizados
					//buscamos los mensajes por clave 2 a 9
					$w_accesorio=1;
					$b_acc=mysql_fetch_array($ac_eq);
					for($a=0;$a<count($activada);$a++){
						$ini=$activada[$a]*2;
						$fin=$ini+2;
						for($i=$ini;$i<$fin;$i++){
							$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=".$rows_veh[11]." and 
							id_mensaje=".$b_acc[$i]);
							if(mysql_num_rows($d_men)>0){
								$desc=mysql_fetch_array($d_men);
								if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
									$title_accesorio.=$desc[0];
									$id_msj=$b_acc[$i];
								}
								else{
									if($b_acc[$i]!=0 && $i==$ini){
										$title_accesorio.=$desc[0];
									}
								}
								if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
									$title_accesorio.="/";
								}
							}
							else{
								$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=15 and 
								id_mensaje=".$b_acc[$i]);
								$desc=mysql_fetch_array($d_men);
								//$objResponse->alert($desc[0]);
								if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
									$title_accesorio.=$desc[0];
									$id_msj=$b_acc[$i];
								}
								else{
									if($b_acc[$i]!=0 && $i==$ini){
										$title_accesorio.=$desc[0];
									}
								}
								if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
									$title_accesorio.="/";
								}
								//$objResponse->alert($title_accesorio);
							}
						}
						$title_accesorio.=" ";
					}
				}
				else{
					$ac_emp=mysql_query("SELECT * from cfg_ent where id_empresa=".$rows_veh[11]." and estatus=1");
					if(mysql_num_rows($ac_emp)>0){
						//buscamos mensajes por clave2 a 9
						$w_accesorio=1;
						$b_acc=mysql_fetch_array($ac_emp);
						for($a=0;$a<count($activada);$a++){
							$ini=$activada[$a]*2;
							$fin=$ini+2;
							for($i=$ini;$i<$fin;$i++){
								$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=".$rows_veh[11]." and 
								id_mensaje=".$b_acc[$i]);
								if(mysql_num_rows($d_men)>0){
									$desc=mysql_fetch_array($d_men);
									if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
										$title_accesorio.=$desc[0];
										$id_msj=$b_acc[$i];
									}
									else{
										if($b_acc[$i]!=0 && $i==$ini){
											$title_accesorio.=$desc[0];
										}
									}
									if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
										$title_accesorio.="/";
									}
								}
								else{
									$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=15 and 
									id_mensaje=".$b_acc[$i]);
									$desc=mysql_fetch_array($d_men);
									if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
										$title_accesorio.=$desc[0];
										$id_msj=$b_acc[$i];
									}
									else{
										if($b_acc[$i]!=0 && $i==$ini){
											$title_accesorio.=$desc[0];
										}
									}
									if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
										$title_accesorio.="/";
									}
								}
							}
							$title_accesorio.=" ";
						}
					}
					else{
						$tipo_e=mysql_query("select tipo_equipo from sistemas where id_sistema=".$rows_veh[6]);
						$tipos=mysql_fetch_array($tipo_e);
						$ac_std=mysql_query("SELECT * from cfg_entxtequipo where tipo_equipo='".$tipos[0]."'");
						if(mysql_num_rows($ac_std)>0){
							//buscamos mensajes por clave2 a 9
							$w_accesorio=1;
							$b_acc=mysql_fetch_array($ac_std);
							for($a=0;$a<count($activada);$a++){
								$ini=($activada[$a]*2)-1;
								$fin=$ini+2;
								for($i=$ini;$i<$fin;$i++){
									$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=".$rows_veh[11]." and 
									id_mensaje=".$b_acc[$i]);
									if(mysql_num_rows($d_men)>0){
										$desc=mysql_fetch_array($d_men);
										if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
											$title_accesorio.=$desc[0];
											$id_msj=$b_acc[$i];
										}
										else{
											if($b_acc[$i]!=0 && $i==$ini){
												$title_accesorio.=$desc[0];
											}
										}
										if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
											$title_accesorio.="/";
										}
									}
									else{
										$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=15 and 
										id_mensaje=".$b_acc[$i]);
										$desc=mysql_fetch_array($d_men);
										if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
											$title_accesorio.=$desc[0];
											$id_msj=$b_acc[$i];
										}
										else{
											if($b_acc[$i]!=0 && $i==$ini){
												$title_accesorio.=$desc[0];
											}
										}
										if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
											$title_accesorio.="/";
										}
									}
								}
								$title_accesorio.=" ";
							}
						}
					}
				}
				if($w_accesorio==1){
					//$objResponse->alert($title_accesorio." ".$rows_veh[0]." ".$id_msj);
					if($title_accesorio==''){
						$info=mysql_query("select mensaje from c_mensajes where id_mensaje=".$id_msj." and id_empresa=15");
						$dat=mysql_fetch_array($info);
						$title_accesorio=$dat[0];
					}
					//$w_accesorio="<img src='img_alertas/w_accesorio.png' title='$title_accesorio' style='cursor:pointer;'  
					//onclick='alert(\"$title_accesorio\")' height='15px'>";
				}
				if(preg_match('/encendido/i',$title_accesorio) ){
					$img_motor="<img src='img_alertas/encendido.png' style='cursor:pointer;' style='cursor:pointer;' width='15px' title='Motor encendido' onclick='ubicacion(".$rows_veh[1].");'>";
				}
				else{
					$img_motor="<img src='img_alertas/apagado.png' style='cursor:pointer;' style='cursor:pointer;' width='15px' title='Motor apagado' onclick='ubicacion(".$rows_veh[1].");'>";
				}
			}
			$w_accesorio='';
			//$objResponse->alert($img_motor);
			if($rows_veh[1]==68704){//tipsa_caja
				//$objResponse->alert($img_motor);
			}
			if($img_motor==''){
				$sistemas_invalidos=array(10,14,16,17,18,20,22,25,27,28,30,31,32,33,34,35,43);
				if(!in_array($rows_veh[6],$sistemas_invalidos)){
					$motores=mysql_query("SELECT ignition_st from ultimapos where num_veh=".$rows_veh[1]);
					$img_motor="";
					$motor=mysql_fetch_array($motores);
					if($motor[0]==1){//encendido
						$img_motor="<img src='img_alertas/encendido.png' style='cursor:pointer;' width='15px' title='Motor encendido' onclick='ubicacion(".$rows_veh[1].");'>";
					}
					else{//apagado
						$img_motor="<img src='img_alertas/apagado.png' style='cursor:pointer;' width='15px' title='Motor apagado' onclick='ubicacion(".$rows_veh[1].");'>";
					}
				}
				else{//incluimos a los spider y x8
					if($rows_veh[5]>8){
						$img_motor="<img src='img_alertas/encendido.png' style='cursor:pointer;' width='15px' title='Motor encendido' onclick='ubicacion(".$rows_veh[1].");'>";
					}
					else{//apagado
						$img_motor="<img src='img_alertas/apagado.png' style='cursor:pointer;' width='15px' title='Motor apagado' onclick='ubicacion(".$rows_veh[1].");'>";
					}
				}
			}
		}
		$qvelocidad=mysql_query($query2);
		if(mysql_num_rows($qvelocidad)==0){//asignamos las velocidades "default"
			if($rows_veh[5]<=8){
				$vel="azul";
			}
			if($rows_veh[5]>8){
				if($rows_veh[5]<46){
					$vel="verde";
				}
				if($rows_veh[5]>=46){
					$vel="amarillo";
				}
				if($rows_veh[5]>=71){
					$vel="naranja";
				}
				if($rows_veh[5]>=101){
					$vel="rojo";
				}
			}
		}
		else{
			$vel_conf=mysql_fetch_array($qvelocidad);
			if($rows_veh[5]<=8){
				$vel="azul";
				//$estado="Detenido";
			}
			if($rows_veh[5]<=$vel_conf[2] && $rows_veh[5] >=9){
				$vel='verde';
			}
			if($rows_veh[5]<=$vel_conf[3] && $rows_veh[5]>$vel_conf[2]){
				$vel='amarillo';
			}
			if($rows_veh[5]<=$vel_conf[4] && $rows_veh[5]>$vel_conf[3]){
				$vel='naranja';
			}
			if($rows_veh[5]>=$vel_conf[5]){
				$vel='rojo';
			}
			//$objResponse->alert($query2);
		}
		$campo="velocidad".$rows_veh[1];
		$cont="$w_accesorio&nbsp;$img_motor&nbsp;<img src='img2/".$vel.".png' style='cursor:pointer;' width='25px' title='".$rows_veh[5]." km/h' onclick='ubicacion(".$rows_veh[1].");'>";
		$objResponse->assign($campo,"innerHTML",$cont);
	}
	mysql_close($conec);
	return $objResponse;
}
function salida($idu){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();	
	$sess =& patSession::singleton('egw', 'Native', $options );
	$consulta = "insert into auditabilidad values (0,'$idu','".date("Y-m-d H:i:s")."',62,'Reviso alertas',
	13,".$sess->get('Ide').",'".get_real_ip()."')";
	mysql_query($consulta);
	//$cad_eve = "insert into eventos (id_usuario,num_veh,notas,tipo,ip) values ('$idu','0','Revisó Alertas','11','".get_real_ip()."')";
	//$res_eve = mysql_query($cad_eve);
	$sess->set('ban',1);
	//$objResponse->alert("Entra");
	mysql_close($conec);
	return $objResponse;
}
function muestra_alerta($idu,$num,$total){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	//$cadMax="SELECT max(id) FROM id_pos";//selecciona "ultima" posicion
	$ayer=strtotime(date("Y-m-d")."- 1 day");
	$cadMax="select max(id_pos) from posiciones where fecha>='".date("Y-m-d",$ayer)." 23:59:00' 
	and fecha<='".date("Y-m-d")." 00:00:00';";
	$queryMax=mysql_query($cadMax);
	$rowMax=mysql_fetch_row($queryMax);
	$fechaPos=date("Y-m-d");
	$fechaPos.=" 00:00:00";
		
	$tipos=mysql_query("select M.id_mensaje,M.id_empresa from c_mensajes M
						INNER JOIN usuarios U on M.id_empresa=U.id_empresa
						WHERE U.id_usuario=$idu
						and M.alarma in('1','T')
						group by M.id_mensaje");
	if(mysql_num_rows($tipos)==0){
	//if(mysql_num_rows($tipos)<=5){
		$tipos=mysql_query("select M.id_mensaje,M.id_empresa from c_mensajes M
						INNER JOIN usuarios U on M.id_empresa=U.id_empresa
						WHERE U.id_empresa=15
						and M.alarma in ('1','T')
						group by M.id_mensaje");
	}
	$i=0;
	while($m_tipos=mysql_fetch_array($tipos)){
		$t_tipos[$i]=$m_tipos[0];
		$t_empresa[$i]=$m_tipos[1];
		$i++;
	}
	$mensajes=join(',',$t_tipos);
	$empresa=join(',',$t_empresa);
	
	$cad_pos = "select a.id_pos,a.num_veh,vh.id_veh,(a.lat/3600/16),((a.lon & 8388607)/3600/12*-1),
				a.fecha_pos,vh.tipoveh,a.id_mensaje
				from alertas_leido a
				left outer join vehiculos vh on(a.num_veh = vh.num_veh)
				left outer join veh_usr v on (v.num_veh = a.num_veh)
				where a.fecha_pos >'$fechaPos'
				and v.id_usuario=$idu
				and v.activo=1
				and a.atendido=0
				order by a.fecha_pos desc"; 
	
	if($num == 1){  //no doy click
		$sess =& patSession::singleton('egw', 'Native', $options );
		$act = date('Y-m-d H:i:s');
		$sess->set('evf',$act);
		//$objResponse->assign("num_msj","innerHTML","");
	}
	$res_pos = mysql_query($cad_pos);
	$num_row = mysql_num_rows($res_pos);
		if($num_row>=2){
			$plural='s';
		}
		else{
			$plural='';
		}
		$dsn = "<div id='lateral'><table style='font-size:12px;marging:0px;padding:0px;width:100%;' id='newspaper-a1'>";
		$dsn .= "<tr>
			<th style='font-size:10px;' >Veh&iacute;culo$plural</th>
			<th style='font-size:10px;'>Hora del evento</th>
			<th style='font-size:10px;'>Tipo 
				<img src='img2/cerrar.png' title='Borrar todos' onclick='xajax_leer_todos();' width='10px'>
			</th>
		</tr>";
		$i=0;
		while($row = mysql_fetch_row($res_pos))
		{
			$tipos=mysql_query("select M.mensaje from c_mensajes M
						INNER JOIN usuarios U on M.id_empresa=U.id_empresa
						WHERE U.id_usuario=$idu and U.activo=1 and M.id_mensaje=".$row[7]);
			if(mysql_num_rows($tipos)==0){
			//if(mysql_num_rows($tipos)<=5){
				$tipos=mysql_query("select M.mensaje from c_mensajes M
						INNER JOIN usuarios U on M.id_empresa=U.id_empresa
						WHERE U.id_empresa=15 and M.id_mensaje=".$row[7]);
			}
			$b_tipo=mysql_fetch_array($tipos);
			$tipo=$b_tipo[0];
			if($i < $total)
			if($i < $total)
			{
    			$dsn .= "<tr>
				<td style='word-wrap:break-word;'>
					<span title='click para desplegar detalle'
					style='font-size:10px;cursor:pointer;font-weight:bold;text-decoration:underline;'
					onclick='MapaCord(".$row[3].", ".$row[4].", ".$row[6].");
					xajax_posicion_alarma(".$row[0].");' >".$row[2]."</span>
				</td>
				<td style='word-wrap:break-word;font-size:9px;'>".str_replace(date("Y-m-d "),'',$row[5])."</td>
				<td style='word-wrap:break-word;font-size:9px;'>$tipo</td></tr>";
			}
			else
			{
				$dsn .= "<tr>
				<td style='word-wrap:break-word;'>
					<span title='click para desplegar detalle' 
					style='font-size:10px;cursor:pointer;font-weight:bold;text-decoration:underline;'
					onclick='MapaCord(".$row[3].", ".$row[4].", ".$row[6].");xajax_posicion_alarma(".$row[0].");' >".$row[2]."</span>
				</td>
				<td style='word-wrap:break-word;font-size:9px;'>".str_replace(date("Y-m-d "),'',$row[5])."</td>
				<td style='word-wrap:break-word;font-size:9px;'>$tipo</td></tr>";
			}
			$i++;
		}
		$dsn .= "</table></div>";
		if($num==1){//ya di click en el mensaje de "tienes alertas"
			$objResponse->assign("num_msj1","innerHTML",$dsn);
			//$obtiene=$idu.",".$fecha.",".$num.",".$total;
			//$objResponse->alert($obtiene);
		}
	mysql_close($conec);
	return $objResponse;
}
function leer_todos(){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu=$sess->get('Idu');
	
	//$cadMax="SELECT max(id) FROM id_pos";//selecciona "ultima" posicion
	$ayer=strtotime(date("Y-m-d")."- 1 day");
	$cadMax="select max(id_pos) from posiciones where fecha>='".date("Y-m-d",$ayer)." 23:59:00' 
	and fecha<='".date("Y-m-d")." 00:00:00';";
	//$queryMax=mysql_query($cadMax);
	//$rowMax=mysql_fetch_row($queryMax);
	$fechaPos=date("Y-m-d");
	$fechaPos.=" 00:00:00";
	$tipos=mysql_query("select M.id_mensaje,M.id_empresa from c_mensajes M
						INNER JOIN usuarios U on M.id_empresa=U.id_empresa
						WHERE U.id_usuario=$idu and U.activo=1
						and M.alarma in ('1','T')");
	$i=0;
	if(mysql_num_rows($tipos)==0){
	//if(mysql_num_rows($tipos)<=5){
		$tipos=mysql_query("select M.id_mensaje,M.id_empresa from c_mensajes M
						INNER JOIN usuarios U on M.id_empresa=U.id_empresa
						WHERE U.id_empresa=15
						and M.alarma in ('1','T')
						group by M.id_mensaje");
	}
	while($m_tipos=mysql_fetch_array($tipos)){
		$t_tipos[$i]=$m_tipos[0];
		$t_empresa[$i]=$m_tipos[1];
		$i++;
	}
	$mensajes=join(',',$t_tipos);
	$empresa=join(',',$t_empresa);
	$cad_pos = "select a.id_pos
				from alertas_leido a
				left outer join vehiculos vh on(a.num_veh = vh.num_veh)
				left outer join veh_usr v on (v.num_veh = a.num_veh)
				where a.fecha_pos >'$fechaPos' 
				/*and a.id_pos>".$rowMax[0]." */
				and v.id_usuario=$idu
				and v.activo=1	
				and a.atendido=0				
				order by a.fecha_pos desc  "; 
	//$objResponse->alert($cad_pos);
	$mostrar=mysql_query($cad_pos);
	while($row=mysql_fetch_array($mostrar)){
		$insert="UPDATE alertas_leido SET id_usuario='$idu',atendido=1 where id_pos=".$row[0];
		mysql_query($insert);
	}
	$sess->set('todas_alertas',0);
	$consulta = "insert into auditabilidad values (0,'$idu','".date("Y-m-d H:i:s")."',60,'Leer todos los mensajes',
	13,$empresa,'".get_real_ip()."')";
	mysql_query($consulta);
	$objResponse->script("tiempo($idu,1,0)");
	mysql_close($conec);
	return $objResponse;
}
function mostrar_otros($siguiente){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu=$sess->get('Idu');
	if($siguiente==''){
		$limit="0,1";
	}else{
		$limit=$siguiente.",1";
	}
	if($idu==42630){
		//$fecha="2014-04-05";
		$fecha=date("Y-m-d");
	}
	else{
		$fecha=date("Y-m-d");
	}
	$query="SELECT * FROM noticias_egweb WHERE fecha_inicio<='".$fecha."' 
			AND fecha_fin>='".$fecha."'
			and activo=1
			ORDER BY fecha_inicio,idnoticias_egweb desc limit $limit";
	$rows=mysql_query($query);
	//$objResponse->alert($query);
	$t_noticias=mysql_num_rows($rows);
	if($t_noticias>0){
		$multiples=mysql_query("SELECT * FROM noticias_egweb WHERE fecha_inicio<='".$fecha."' 
			AND fecha_fin>='$fecha' 
			and activo=1
			ORDER BY idnoticias_egweb desc");
		$T_N=mysql_num_rows($multiples);
		if($T_N>=2){
			$cambia=$siguiente+1;
			if($cambia>($T_N-1)){
				$cambia=0;
			}
			$objResponse->script("cambiar_noticia($cambia)");
		}
		while($row=mysql_fetch_array($rows)){
			if($row[3]!=''){//tiene o no un link
				$links=explode(",",$row[3]);
				for($x=0;$x<count($links);$x++){
					if(strlen($links[$x])>30){
						$incompleta=substr($links[$x],0,24)."...";
					}
					else{
						$incompleta=$links[$x];
					}
					if(!preg_match('/http/',$links[$x])){
						$cadena='http://'.$links[$x];
						$cadena_resultante .= preg_replace("/((http|https|www)[^\s]+)/", '<a href="$1" target="_blank">'.$incompleta.'</a>',$cadena);
						$cadena_resultante .="<br>";
					}
					else{
						$cadena=$links[$x];
						$cadena_resultante .= preg_replace("/((http|https|www)[^\s]+)/", '<a href="$1" target="_blank">'.$incompleta.'</a>',$cadena);
						$cadena_resultante .="<br>";
					}
				}
				$link_resultante = $cadena_resultante;
			}
			else{
				$link_resultante='';
			}
			list($uno,$dos)=explode(",",$limit);
			if($uno==0){
				$atras="";
			}else{
				$atras="<img src='img2/atras.png' style='cursor:pointer;float:left;' height='15px' onclick='c_noticia();xajax_mostrar_otros(".($uno-1).")'>";
			}
			switch($row[7]){
				case 1:$tipo="<img src='img2/servicios.png' height='15px'> SERVICIOS";break;
				case 2:$tipo="<img src='img2/accidente.png' height='15px'>ACCIDENTE";break;
				case 3:$tipo="<img src='img2/trafico.png' height='15px'> TRAFICO";break;
				case 4:$tipo="<img src='img2/obras.png' height='15px'> OBRAS";break;
				case 5:$tipo="<img src='img2/bloqueo.png' height='15px'> BLOQUEO";break;
				case 6:$tipo="<img src='img2/seguridad.png' height='12px'>SEGURIDAD";break;
				case 7:$tipo="<img src='img2/noticias.png' height='15px'> NOTICIAS";break;
				case 8:$tipo="<img src='img2/otros_n.png' height='15px'> OTROS";break;
			}
			$dsn="
			<div id='lateral'>
				<table style='font-size:12px;marging:0px;padding:0px;width:170px;' id='newspaper-a1'>
				<tr>
					<th width='15px'>$atras</th>
					<th width='145px;' style='font-weight:bold;color:#FFF;'>".$tipo."</th>
					<th width='15px'>";
			$total_n=mysql_query("SELECT * FROM noticias_egweb WHERE fecha_inicio<='".$fecha."' 
				AND fecha_fin>='".$fecha."' and activo=1");
			if(mysql_num_rows($total_n)>($uno+1)){
				$next="<img src='img2/adelante.png' style='cursor:pointer; float:right;' height='15px' onclick='c_noticia();xajax_mostrar_otros(".($uno+1).")'>";
			}
			else{
				$next="";
			}
			$dsn.="	$next	
						</th>
					</tr>";
			$titulo_noticia=strtoupper(strtr(utf8_encode($row[1]),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"));
			$correos = preg_replace("/[^@\s]*@[^@\s]*\.[^@\s]*/", '<a href=mailto:$0">$0</a>', $row[2]);
			$twitter = preg_replace('/(?<=^|\s)@([a-z0-9_]+)/i','<a href="http://www.twitter.com/$1">@$1</a>',$row[2]);
			$dsn.="
				<tr>
					<th colspan='3' align='center'>".$titulo_noticia."</th>
				</tr>
				<tr>
					<td colspan='3' 
					style='word-wrap:break-word;text-align:justify; 
					max-width:175px;font-size:13px;'>".nl2br(utf8_encode($correos))." $link_resultante
					</td>
				</tr>";
			$dsn.="	</table></div>";
		}
	}
	else{
		$dsn="No hay noticias relevantes en estos momentos.";
	}
	//$cadMax="SELECT max(id) FROM id_pos";
	$ayer=strtotime(date("Y-m-d")."- 1 day");
	$cadMax="select max(id_pos) from posiciones where fecha>='".date("Y-m-d",$ayer)." 23:59:00' 
	and fecha<='".date("Y-m-d")." 00:00:00';";
	$queryMax=mysql_query($cadMax);
	$rowMax=mysql_fetch_row($queryMax);
	$fechaPos=date("Y-m-d");
	$fechaPos.=" 00:00:00";
	//$fechaPos="2012-09-06 00:00:00";
	$tipos=mysql_query("select M.id_mensaje,M.id_empresa from c_mensajes M
						INNER JOIN usuarios U on M.id_empresa=U.id_empresa
						WHERE U.id_usuario=$idu
						and M.alarma in ('1','T')
						group by M.id_mensaje");
	$i=0;
	if(mysql_num_rows($tipos)==0){
	//if(mysql_num_rows($tipos)<=5){
		$tipos=mysql_query("select M.id_mensaje,M.id_empresa from c_mensajes M
						INNER JOIN usuarios U on M.id_empresa=U.id_empresa
						WHERE U.id_empresa=15
						and M.alarma in ('1','T')
						group by M.id_mensaje");
	}
	while($m_tipos=mysql_fetch_array($tipos)){
		$t_tipos[$i]=$m_tipos[0];
		$t_empresa[$i]=$m_tipos[1];
		$i++;
	}
	$q_estatus=mysql_query("SELECT estatus from usuarios where id_usuario=$idu");
	$estatus=mysql_fetch_array($q_estatus);
	if($estatus[0]<20){
		$mensajes=join(',',$t_tipos);
		$empresa=join(',',$t_empresa);
		$cad_pos="select a.num_veh
				from alertas_leido a
				left outer join vehiculos vh on(a.num_veh = vh.num_veh)
				left outer join veh_usr v on (v.num_veh = a.num_veh)
				where a.fecha_pos >'$fechaPos' 
				/*and a.id_pos>".$rowMax[0]." */
				and v.id_usuario=$idu
				and v.activo=1		
				and a.atendido=0
				order by a.fecha_pos desc ";
		$total=mysql_query($cad_pos);
		if(mysql_num_rows($total)>0){
			//$t=mysql_fetch_array($total);
			$t=mysql_num_rows($total);
			
			//if($t[0]!=0){
			if($t!=0){
				$pendientes=" (".$t." nuevas)";
				//$pendientes=" (".$t[0]." nuevas)";
			}
			else{
				$pendientes="";
			}
		}
		else{
			$pendientes='';
		}
		$objResponse->assign("num_msj","innerHTML","<span onclick='c_noticia();xajax_salida(".number_format($idu, 0, '.', '').");xajax_alertas(".number_format($idu, 0, '.', '').");'>Alertas$pendientes</span>&nbsp;&nbsp;|&nbsp;&nbsp;<span onclick='c_noticia();xajax_mostrar_otros();'>Noticias</span>");
		$objResponse->assign("num_msj1","innerHTML",$dsn);
	}
	else{
		$objResponse->assign("num_msj","innerHTML","<span onclick='c_noticia();xajax_mostrar_otros();'>Noticias</span>");
		$objResponse->assign("num_msj1","innerHTML",$dsn);
	}
	mysql_close($conec);
	return $objResponse;
}
//Funcion para mostrar los crucees de calles de los panicos
function posicion_alarma($idp) { 
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();	
	//foreach ($aFormValues['vehiculos'] as $veh);
	$veh=$aFormValues;
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$idemp = $sess->get("Ide");
	$idu = $sess->get("Idu");
	//foreach ($aFormValues['vehiculos'] as $veh);
	$veh=$aFormValues;
	$cad_msj = "select id_empresa from c_mensajes where id_empresa = $idemp";
	$res_msj = mysql_query($cad_msj);
	if(mysql_num_rows($res_msj)){
		$id_emp = $idemp;
	}
	else $id_emp = 15;
	$datosveh  = "select v.id_veh,(p.lat/3600/16),((p.long & 8388607)/3600/12*-1),p.mensaje,p.velocidad,p.fecha,
	v.tipoveh,p.t_mensaje,v.id_empresa,p.entradas,p.odometro,p.entradas_a,p.id_tipo,v.id_sistema,
	p.num_veh as NUM_VEH,pm.descripcion,cm.mensaje 
	from vehiculos v 
	left outer join posiciones p on (v.num_veh = p.num_veh)
	left outer join postmens pm on (pm.t_mensaje = p.t_mensaje)
	left outer join c_mensajes cm on (cm.id_mensaje = p.entradas and cm.id_empresa = v.id_empresa)
	where p.id_pos = $idp";
	//$objResponse->alert($datosveh);
	$resveh = mysql_query($datosveh);
	$rowveh = mysql_fetch_array($resveh);
	$v = $rowveh[0];
	$lat = $rowveh[1];
	$lon = $rowveh[2];		
	$vel = $rowveh[4];
	$fe = $rowveh[5];
	$tipov = $rowveh[6];
	$t_msj = $rowveh[7];
	$empresa = $rowveh[8];
	$clv = $rowveh[9];
	$odo = $rowveh[10];
	$bat = $rowveh[11];
	$idtipo = $rowveh[12];
	$idsis = $rowveh[13];
	$men   = $rowveh[15];
	$num_veh=$rowveh['NUM_VEH'];
	$cruce = otro_server($lat,$lon);
	/*
	$conec=@mysql_connect("localhost","root","53g53pr0");
	*/
	$con = mysql_connect("10.0.1.3","egweb","53g53pr0") or die ("¡No hay conexión con el servidorrrr! <br />" . mysql_error());
	mysql_select_db("sepromex", $con) or die ("¡No se selecciono BD! <br />" . mysql_error() );
	mysql_query("UPDATE sepromex.alertas_leido set id_usuario=$idu,atendido=1 where id_pos=$idp",$conec);
	//$objResponse->alert(mysql_error());
	$sess->set('todas_alertas',($sess->get('todas_alertas')-1));
	if($lat != 0 && $lon != 0){
		if($idsis == 23 || $idsis == 26){
			if($bat<= 100 && $bat > 90){
				$bateria = "<img src='./img/carga1.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<=90  && $bat >75 ){
				$bateria = "<img src='./img/carga2.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<= 75 && $bat > 60){
				$bateria = "<img src='./img/carga3.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<= 60 && $bat > 48){
				$bateria = "<img src='./img/carga4.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<= 48 && $bat > 30){
				$bateria = "<img src='./img/carga5.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<= 30 && $bat >15){
				$bateria = "<img src='./img/carga6.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat	<= 15 && $bat >=1){
				$bateria = "<img src='./img/carga7.png' width='10' height='20' title='$bat %'/>";
			}
			if($bat == 0){
				$bateria = "<img src='./img/carga8.png' width='10' height='20' title='$bat %'/>";
			}
			$cab_bat  = "<td>BATERIA</td>";
			$cuer_bat = "<td>$bateria</td>";
		}
		if($veh == 67948  || $veh == 66887){
			$cabe = "<th>ODO</th>";
			$cuerpo = "<td>$odo</td>";
		}	
		if($t_msj == 2 || $t_msj == 1){
			$men = $rowveh[3];
		}
		if($men != ''){
				$img='<img src="./img/msg.png" border = "0" title="'.$men.'" width = "25" height="16" onclick = "alert(\''.$men.'\')" >';
		}
		else $img = " ";
		if($cruce==''){
			//$objResponse->alert(sitio_cercano(number_format($idu,0,'',''),$lat,$lon));
			//$cruce=sitio_cercano($id_emp,$lat,$lon);
		}
		
		$datos = "<div id='mostrar_veh1'>
		<div style='float:right;'><img onclick='ocultar_veh();' src='img2/cerrar.png' width='20px'></div>
		<table border='0' id='box-table-a1' width='765' cellspacing = '0' cellpadding='0'>
			<tr>
				<th>VEH&Iacute;CULO</th>
				<th>FECHA / HORA</th>
				<th>KM/H	</th>
				$cab_bat 
				$cabe
				<th>LATITUD</th>
				<th>LONGITUD</th>
				<th>UBICACI&Oacute;N</th>
				<th>MSJ</th>
			</tr>
			<tr>
				<td>".$v."</td>
				<td>".$fe."</td>
				<td>".$vel."</td>
				$cuer_bat 
				$cuerpo
				<td>".number_format($lat,7,'.','')."</td>
				<td>".number_format($lon,7,'.','')."</td>
				<td>".strtoupper($cruce)."</td>
				<td>".$img."</td>
			</tr>
		</table>
		</div>";			  
		$objResponse->assign('cuerpo_medio','innerHTML',$datos);
		$objResponse->script("muestra_cuerpo()");
	}
	else $objResponse->alert("Coordenadas no validas");
	mysql_close($conec);
	return $objResponse;		
}
function modo_live($idu){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$cad_veh = "select distinct(v.id_veh), v.num_veh from veh_usr as vu inner join vehiculos as v on
	vu.num_veh = v.num_veh inner join estveh ev on (v.estatus = ev.estatus) 
	where vu.id_usuario = $idu 
	AND ev.publicapos=1 and vu.activo=1 order by v.id_veh asc";
	$res_veh = mysql_query($cad_veh);
	$dsn_live = "<table id='newspaper-a1'  width='195px' style='padding:0px;margin:0px;'>";
	while($row = mysql_fetch_row($res_veh)){
		$dsn_live .= "<tr>
						<td>
							<input type='checkbox' name='mark_live' value='".$row[1]."' onclick='genera_arreglo();'/> ".utf8_encode($row[0])."
						</td>
					</tr>";
	}
	$dsn_live .="</table>";
	$objResponse->assign('m_live','innerHTML',$dsn_live);
	mysql_close($conec);
	return $objResponse;
}
function arreglo($arreglo){
	require("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$elementos="";
	for($i=0; $i<count($arreglo); $i++){
		$elementos .= $arreglo[$i].",";
	}
	//$objResponse->alert($arreglo);
	$elementos = substr($elementos, 0, strlen($elementos)-1);
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idemp = $sess->get("Ide");	
	
	$cad_msj = "select id_empresa from c_mensajes where id_empresa = $idemp";
	$res_msj = mysql_query($cad_msj);
	if(mysql_num_rows($res_msj)){
		$id_emp = $idemp;
	}else $id_emp = 15;	
	$qry  = "select distinct(v.id_veh),(u.lat/3600/16),((u.long & 8388607)/3600/12*-1),u.mensaje,u.velocidad,u.fecha,
	v.tipoveh,u.t_mensaje,v.id_empresa,u.entradas,u.odometro,u.entradas_a,u.id_tipo,v.id_sistema,
	pm.descripcion,cm.mensaje,v.num_veh,u.satelites,u.hdop
	from vehiculos v
	left outer join ultimapos u on v.num_veh = u.num_veh
	left outer join postmens pm on pm.t_mensaje = u.t_mensaje
	left outer join c_mensajes cm on cm.id_mensaje = u.entradas and cm.id_empresa = v.id_empresa
	where v.num_veh in ($elementos) 
	order by v.id_veh ASC";	
	$vehi = mysql_query($qry);
	$ban_bat = 0;
	$ban_odo = 0;
	$tab_odo="";
	$tab_bat="";
	$odo="";
	while($rowvehi = mysql_fetch_array($vehi)){
		if($rowvehi[13]==23 || $rowvehi[13]==26){ 
			$tab_bat = "<th>BAT</th>";
			$ban_bat = 1;
			break;
		}
	}	
	$vehi = mysql_query($qry);
	while($rowvehi = mysql_fetch_array($vehi)){
		if($rowvehi[13]==20 ){ //error del cerebro checar posteriormente
			$tab_odo = "<th>ODO</th>";
			$ban_odo = 1;
			break;
		}
	}			  		
	$vehi = mysql_query($qry);
	
	$datos = "
	<div id='mostrar_veh1'>
		<div style='float:right;'><img onclick='ocultar_veh();' src='img2/cerrar.png' width='20px'></div>
		<table border='0' style='width:775px;' id='box-table-a1'>
			<tr>
				<th>VEH&Iacute;CULO</th>
				<th>FECHA / HR</th>
				<th>KM/H</th>
				<th>TIPO</td>
				<th>UBICACI&Oacute;N</th>
				<th>LAT/LNG</th>
				<th>MSJ</th>
				$tab_odo
				$tab_bat
				<th>Satelites</th>
				<!--<th>HDOP</th>-->
			</tr>";	
	while($rowvehi = mysql_fetch_array($vehi)){
		$v = $rowvehi[0];
		$lat = $rowvehi[1];
		$lon = $rowvehi[2];		
		$vel = $rowvehi[4];
		$fe = $rowvehi[5];
		$tipov = $rowvehi[6];
		$t_msj = $rowvehi[7];
		$empresa = $rowvehi[8];
		$clv = $rowvehi[9];
		$idtipo = $rowvehi[12];
		$idsis = $rowvehi[13];
		$veh=$rowvehi[16];
		$zona=mysql_query("select gmt from veh_gmt where num_veh=$veh");
		if(mysql_num_rows($zona)==0){
			mysql_query("Insert into veh_gmt values($veh,'-5')");
			$dif="+0";
		}
		else{
			$d_z=mysql_fetch_array($zona);
			$dif=(5)+($d_z[0]);
			$fe=date("Y-m-d H:i:s",strtotime($rowvehi[5]." $dif hours"));
		}
		$calle = otro_server($lat,$lon);
		$tipo = $rowvehi[14];
		$men = $rowvehi[15];
		$cuer_bat="";
		$cab_bat="";
		$cabe="";
		$cuerpo="";
		if($ban_bat == 1){
			$cuer_bat = "<td>&nbsp;</td>";	
		}else $cuer_bat = "";
		if($ban_odo == 1){//$rowvehi[10] != '' && $rowvehi[10] != '1e+009' && $rowvehi[10] != '0'
			if($idsis==20){ //error del cerebro checar posteriormente
				$odo = "<td>".$rowvehi[10]."</td>";
			}else $odo = "<td>&nbsp;</td>";
		}
		if($ban_bat == 1){
			if($idsis == 23 || $idsis == 26){
			$bat = $rowvehi[11];
				if($bat<= 100 && $bat > 90){
					$bateria = "<img src='./img/carga1.png' width='10' height='20' title='$bat %'/>";
				}
				if($bat	<=90  && $bat >75 ){
					$bateria = "<img src='./img/carga2.png' width='10' height='20' title='$bat %'/>";
				}
				if($bat	<= 75 && $bat > 60){
					$bateria = "<img src='./img/carga3.png' width='10' height='20' title='$bat %'/>";
				}
				if($bat	<= 60 && $bat > 48){
					$bateria = "<img src='./img/carga4.png' width='10' height='20' title='$bat %'/>";
				}
				if($bat	<= 48 && $bat > 30){
					$bateria = "<img src='./img/carga5.png' width='10' height='20' title='$bat %'/>";
				}
				if($bat	<= 30 && $bat >15){
					$bateria = "<img src='./img/carga6.png' width='10' height='20' title='$bat %'/>";
				}
				if($bat	<= 15 && $bat >=1){
					$bateria = "<img src='./img/carga7.png' width='10' height='20' title='$bat %'/>";
				}
				if($bat == 0){
					$bateria = "<img src='./img/carga8.png' width='10' height='20' title='$bat %'/>";
				}
				$cuer_bat = "<td>$bateria</td>";
			}
		}
		if($t_msj==0 ){
			 $tipo = " ";
		}
		if($t_msj==3 && $men==''){
			/*
			$conec=@mysql_connect("localhost","root","53g53pr0");
			mysql_select_db("sepromex", $conec);
			*/
			$con = mysql_connect("10.0.1.3","egweb","53g53pr0") or die ("¡No hay conexión con el servidorr! <br />" . mysql_error());
			mysql_select_db("sepromex", $con) or die ("¡No se selecciono BD! <br />" . mysql_error() );
			$mensajes=mysql_query("select mensaje from c_mensajes where id_empresa=$empresa and id_mensaje=$clv");
			if(mysql_num_rows($mensajes)==0){
				$mensajes=mysql_query("select mensaje from c_mensajes where id_empresa=15 and id_mensaje=$clv");
			}
			$msj=mysql_fetch_array($mensajes);
			$men=$msj[0];
			mysql_close();
			//$objResponse->alert(mysql_error());
		}
		if($men != '' && $men != ' '){
			$img='<img src="./img/msg.png" border = "0" title="'.$men.'" width = "25" height="16" onclick = "alert(\''.$men.'\')" >';
		}
		else $img = "&nbsp;";
		$latlng  = '<img src="./img/lat_lng.png" border = "0" title="'.number_format($lat,7,'.','').' '.number_format($lon,6,'.','').'"'; 
		$latlng .= 'width = "20" height="20" onclick = "alert(\''.number_format($lat,7,'.','').' '.number_format($lon,6,'.','').'\')" >';
		if($calle!=''){
			$ubic ='<img src="./img/cruce.png" border = "0" title="'.htmlentities(strtoupper($calle)).'"';
			$ubic.=' width = "20" height="20" onclick = "alert(\''.htmlentities(strtoupper($calle)).'\')" >';
		}else $ubic = "&nbsp;";
		if($lat != 0 and $lon != 0){
			$datos .= "
			<tr>
				<td>
					<a href='javascript:void(null);' onclick='veh_seleccion(".$lat.",".$lon.")'>".$v."</a>
				</td>
				<td>".conv_fecha($fe)."</td>
				<td>".$vel."</td>
				<td>".htmlentities($tipo)."</td>
				<td align='center'>$ubic</td>
				<td align='center'>$latlng</td>
				<td>$img</td>
				$odo
				$cuer_bat
				<td align='center'>$rowvehi[17]</td>
				<!--<td align='center'>$rowvehi[18]</td>-->
			</tr>";
			$objResponse->call("MapaCordLive", $lat, $lon, $tipov, $v);		  
		}
		else{
			$datos .= "
			<tr>
				<td>".$v."</td>
				<td>".conv_fecha($fe)."</td>
				<td>".$vel."</td>
				<td>".htmlentities($tipo)."</td>
				<td></td>
				<td align='center'>$latlng</td>
				<td>$img</td>
				$odo
				$cuer_bat
				<td>$rowvehi[17]</td>
				<!--<td>$rowvehi[18]</td>-->
			</tr>";			  
		}		
	}
	$datos .="</table></div>";
	$objResponse->assign('cuerpo_medio','innerHTML',$datos);	
	$objResponse->script("muestra_cuerpo()");	
	mysql_close($conec);
	return $objResponse;
}
function cambioPass($formPass){
	require_once("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$psw0 = $formPass['psw0'];
	$psw1 = $formPass['psw1'];
	$psw2 = $formPass['psw2'];
	$idu = $formPass['usr'];
	if ($psw0==""){
		$objResponse->alert("Por favor ingrese la contraseña actual");
	} elseif ($psw1==""){
	    $objResponse->alert("Por favor ingrese una nueva contraseña");
	}elseif (strlen($psw1)<5){
	    $objResponse->alert("La contraseña debe tener al menos 5 caracteres");
	}else {
		if($psw2 === $psw1){
			$query="select id_usuario from usuarios where id_usuario=$idu and password='$psw0'";
			$result = mysql_query($query);
			if(mysql_num_rows($result)==1){
				$query1="update usuarios set password = '$psw1' where id_usuario = $idu";
				$result = mysql_query($query1);
				$consulta = "insert into auditabilidad values (0,'$idu','".date("Y-m-d H:i:s")."',59,'Cambio de password',
				13,$empresa,'".get_real_ip()."')";
				mysql_query($consulta);
				if($result){
					$objResponse->alert("Se realizó el cambio de contraseña");
					$objResponse->call("pass()");
				}else $objResponse->alert("Error, falló el cambio de contraseña. Intente de nuevo");
			}else $objResponse->alert("La contraseña actual no es correcta. Intente de nuevo".$psw0);
		}else $objResponse->alert("Las nueva contraseñas no coinciden. Intente de nuevo");
	}
	mysql_close($conec);
	return $objResponse;
}
function conv_fecha($f){
	$fecha = $f[8]."".$f[9]."/".$f[5]."".$f[6]."/".$f[2]."".$f[3]." ".$f[11]."".$f[12].":".$f[14]."".$f[15];
	return $fecha;
}
function color($n){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$sess->set('dis',$n);
	$objResponse->redirect("principal.php",1.0);
	return $objResponse;
}
//consulta los vehiculos, mnsdajes y tipo de sitios para llenar los diferentes select
$xajax->ProcessRequest();  
$xajax->printJavascript();
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>EGWEB 5.0</title>
	<link href="css/black.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="librerias/tabla/tabla.css" type="text/css" media="screen">
	<script type="text/javascript" src="librerias/tabla/ajax.js"></script>
	<script type="text/javascript" src="librerias/tabla/tabla.js"></script>
	<script type='text/javascript' src="librerias/funciones.js"></script>
	<!--DAVID-->
	<script type='text/javascript' src="librerias/func_recorridoCambios.js"></script>
	<script type="text/javascript" src="jQuery1.9/js/jquery-1.8.2.js"></script>
	<link rel="shortcut icon" href="img2/favicon.png" type="image/png">
	<!-- BOOTSTRAP -->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.bundle.min.js" integrity="sha384-VspmFJ2uqRrKr3en+IG0cIq1Cl/v/PHneDw6SQZYgrcr8ZZmZoQ3zhuGfMnSR/F2" crossorigin="anonymous"></script>
	<!-- BOOTSTRAP -->
	<link href="principal/css/ui-darkness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="principal/js/jquery-ui-1.10.3.custom.js"></script>
	<!--
	  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&;amp;language=es"></script>
	  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
	-->

	<!--	
	<script type="text/javascript"src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBd2fGQYsJMv6ZucPSPtsou25lmdBjWs4w" ></script>   <!--Mapa con Marca de Agua 
	<script type="text/javascript"src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEF3E6KJ0I25ueSeC2e5noNgJ6bj2yGkA" ></script>
	-->	
	<script type="text/javascript"src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbr1ZoDby1GW6nP7RAgokJLqWP_95d6SE" ></script>	
	<script type="text/javascript" src="librerias/func_principal.js"></script>
	<script src="js/script.js"></script>
	<script type="text/javascript">
			var a=jQuery.noConflict();
			var idleTime = 0;
			a(document).ready(function () {
				//Increment the idle time counter every minute.
				var idleInterval = setInterval("timerIncrement()", 60000); // 1 minute

				//Zero the idle timer on mouse movement.
				a(this).mousemove(function (e) {
					idleTime = 0;
				});
				a(this).keypress(function (e) {
					idleTime = 0;
				});
			});
			function pass(){
				jQuery("#d").dialog("close");
			}
			function timerIncrement() {
			    idleTime = idleTime + 1;
			    if (idleTime > 30) { // 30 minutes
					if(jQuery("#no_caduca").is(':checked')){
						idleTime=0;
					}
					else{
						xajax_matarSesion();
					}
			    }
			}

			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', 'UA-37226500-3']);
			  _gaq.push(['_trackPageview']);

			  (function() {
			    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			  })();


				function plegardesplegar(identificador){ 
					var menu = document.getElementById(identificador); 
					if(menu.className == 'visible'){ menu.className = 'invisible'; }
						else{ menu.className = 'visible'; } } 
			
			// Grabar 
			function setCookie(name, value, expires, path, domain, secure) 
			{ 
			document.cookie = name + "=" + escape(value) + ((expires == null) ? "" : "; expires=" + expires.toGMTString()) + ((path == null) ? "" : "; path=" + path) + ((domain == null) ? "" : "; domain=" + domain) +((secure == null) ? "" : "; secure"); 
			}
			
			// Leer 
			function getCookie(name)
			{ 
			var cname = name + "="; var dc = document.cookie; if (dc.length > 0) { begin = dc.indexOf(cname); if (begin != -1) { begin += cname.length; end = dc.indexOf(";", begin); if (end == -1) end = dc.length; return unescape(dc.substring(begin, end)); } } return null; 
			}
			
			//Borrar 
			function delCookie (name,path,domain) { 
			if (getCookie(name)) { 
			document.cookie = name + "=" + ((path == null) ? "" : "; path=" + path) + ((domain == null) ? "" : "; domain=" + domain) + "; expires=Thu, 01-Jan-70 00:00:01 GMT"; } 
			}
			
			var nC=jQuery.noConflict();
			nC(function() {
		        nC( "#dialog-confirm" ).dialog({
		           autoOpen: false,
		          //  height: 600,
		            width: 850,
					zIndex:30008,
		           // modal: true,
		            buttons: {
						"Mas Informacion":function(){
							//alert("Redireccion al PDF");
							window.open("Las_4_C.pdf");
						},
		                Cerrar: function() {
		                    nC( this ).dialog( "close" );
		                }
		            }
		        });
				nC( "#avisoImportante" ).dialog({
		           autoOpen: false,
		          //  height: 600,
		            width: 450,
					zIndex:3008,
		            modal: true,
		            buttons: {
						Cerrar: function() {
		                    nC( this ).dialog( "close" );
		                }
		            }
		        });
				nC("#dialog-ilsp").dialog({
		           autoOpen: false,
		            width:540,
					height:500,
					zIndex:3008,
		            modal: true,
		            buttons: {
						Cerrar: function() {
		                    nC( this ).dialog( "close" );
		                }
		            }
		        });
				nC("#dialog-femsa").dialog({
		           autoOpen: false,
		            width:540,
					height:500,
					zIndex:3008,
		            modal: true,
		            buttons: {
						Cerrar: function() {
		                    nC( this ).dialog( "close" );
		                }
		            }
		        });
				nC("#capacitacion").dialog({
		           autoOpen: false,
		            width:1000,
					height:460,
					zIndex:3008,
		            modal: true,
		            buttons: {
						Cerrar: function() {
		                    nC( this ).dialog( "close" );
		                }
		            }
		        });
				nC( "#dialog-herramientas" ).dialog({
		           autoOpen: false,
		            height: 630,
		            width: 860,
					zIndex:300008,
		            modal: true,
		            buttons: {
						Descargar:function(){
							window.open("Ayuda/Rutas.pdf");
						},
		                Cerrar: function() {
		                    nC( this ).dialog( "close" );
		                }
		            }
		        });
				nC( "#la_ruta" ).dialog({
		           autoOpen: false,
		            height: 295,
		            width: 305,
					modal:false,
					zIndex:300008,
					position: "left+5 top+10",
					//draggable: false,
		           // modal: true,
		            buttons: {
						Calcular:function(){
							clearWaypoints();
							mandar_ruta();
							xajax_auditabilidad(66);
						},
		                Cerrar: function() {
		                    nC( this ).dialog( "close" );
							nC( "#mis_puntos" ).dialog( "close" );
							nC( "#directionsPanel" ).dialog( "close" );
		                }
		            }
		        });
		        
		        nC("#form_sitios").dialog({
					autoOpen: false,
					height: 300,
		            width: 280,
					modal:true,
					position:"center",
					buttons: {
						Guardar:function(){
							xajax_guarda_sitio(nC("#lat").val(),nC("#lon").val(),nC("#nombre_sitio").val(),nC("#tipo_sitio").val(),nC("#contacto_sitio").val(),nC("#tel1").val(),nC("#tel2").val())
							
							nC( this ).dialog( "close" );
						},
		                Cerrar: function() {
		                    nC( this ).dialog( "close" );
		                }
		            }
					//zIndex:300008
					//position: "left+5 top+175"
				});
				nC("#mis_puntos").dialog({
					autoOpen: false,
					height: 240,
		            width: 305,
					modal:false,
					zIndex:300008,
					position: "left+5 top+175"
				});
				nC("#mis_puntos").css('overflow','hidden');
				nC( "#directionsPanel" ).dialog({
		           autoOpen: false,
		            height: 600,
		            width: 300,
					modal:false,
					zIndex:300008,
					position: "left+650 top+10",
		            buttons: {
		                Cerrar: function() {
		                    nC( this ).dialog( "close" );
		                },
						Descargar: function(){
							var ini=nC( ".r_int:first" ).text();
							var fin=nC( ".r_int:last" ).text();
							var ruta=nC( "#directionsPanel" ).text();
							xajax_dRuta(ruta,ini,fin);
							xajax_auditabilidad(67);
						}
		            }
		        });
		    });	
			
			function abreCampania(){
				var comprobar = getCookie("vezprimera"); 
				if (comprobar != null) { } 
				else {var expiration = new Date(); expiration.setTime(expiration.getTime() + 43200000); setCookie("vezprimera",1,expiration);  //86400000 milisegundos=24Hrs
				plegardesplegar('dialog-confirm'); 
					nC("#dialog-confirm").dialog("open");
				 } 
			}
			
			function abreDialogo(){
				nC("#dialog-confirm").dialog("open");
			}
			function borrarGalleta(){
				delCookie("vezprimera");
			}
			function info(){
				window.open("Las_4_C.pdf");
			}
			
			var j = jQuery.noConflict();

			j(document).ready(function(){
			if(j.browser.mozilla){
				j(".boton_gris").css({"padding":"2px 3px 8px 2px"});
				j(".boton_poleo3").css({"padding":"2px 3px 8px 2px"});
			}
			j("#cuerpo_medio").draggable({
				 containment: j('#cuerpo_head'),
				 scroll: false
			});
			j( "#r_inter" ).sortable();
		    j( "#r_inter" ).disableSelection();
			j('div#la_ruta').bind('dialogclose', function(event) {
				google.maps.event.clearListeners(map, 'click');
				j( "#mis_puntos" ).dialog( "close" );
				j( "#directionsPanel" ).dialog( "close" );
				reset();
				clearWaypoints()
			});
			});	
			function fijarColor(n){
				xajax_color(n);
			}
			/*
			function initPanicos(obj,idu,p){
				if(obj.checked == true){
					tiempo(idu,p,0);
				}
				else{
					xajax_statusPanico();
					window.clearInterval(time_pan);
				}
			}*/
			function abreMensajeImportante(){
				nC("#avisoImportante").dialog("open");
			}
			function tiempo_1(){	  
					setTimeout('tiempo_1()',30000);//milisegundos 
					makingQuery = true;
					xajax_vel_veh();
					
			}
			function ver_plugs(){
				for(i=0;i<navigator.plugins.length;i++){
					alert(navigator.plugins[i].name);
				}
				
			}
			function capacitacion(){
				jQuery("#capacitacion").dialog("open");
			}
			function no_caducar(){
				if(jQuery("#no_caduca").is(':checked')){
					xajax_caducar(1);
				}
				else{
					xajax_caducar(0);
				}
			}
		    
		
			//var directionDisplay;
			//var directionsService;
			var map;
			var origin = null;
			var destination = null;
			var inter = null;
			var waypoints = [];
			var markers = [];
			var markers_rutas = [];
			var directionsVisible = false;
			var currentId = 0;
			var uniqueId = function() {
				return ++currentId;
			}
			function del_punto(idp) {
				for (var i = 0; i < markers_rutas.length; i++) {
					if(markers_rutas[i].id==idp){
						markers_rutas[i].setMap(null);
					}
				}
			}
			function set_inicio(lat,lon){
				origin=new google.maps.LatLng(lat,lon);
				var latlng=new google.maps.LatLng(lat,lon);
				markers.push(new google.maps.Marker({
					position: latlng, 
					map: map,
					icon: "http://maps.google.com/mapfiles/marker" + String.fromCharCode(markers.length + 65) + ".png"
				})); 
			}
			function set_fin(lat,lon){
				destination =new google.maps.LatLng(lat,lon);
				waypoints.push({ location: destination, stopover: true });
				markers.push(new google.maps.Marker({
					position: destination, 
					map: map,
					icon: "http://maps.google.com/mapfiles/marker" + String.fromCharCode(markers.length + 65) + ".png"
				}));
			}
			function set_inter(lat,lon){
				destination =new google.maps.LatLng(lat,lon);
				waypoints.push({ location: destination, stopover: true });
				markers.push(new google.maps.Marker({
					position: destination, 
					map: map,
					icon: "http://maps.google.com/mapfiles/marker" + String.fromCharCode(markers.length + 65) + ".png"
				}));
			}
			function calcRoute() {
				var directionsService = new google.maps.DirectionsService();
				if (origin == null) {
					alert("No hay inicio");
					return;
				}
				if (destination == null) {
					alert("no hay fin");
					return;
				}
				var mode;
				//switch (document.getElementById("mode").value){
				switch ("driving"){
					case "bicycling":
					mode = google.maps.DirectionsTravelMode.BICYCLING;
					break;
					case "driving":
					mode = google.maps.DirectionsTravelMode.DRIVING;
					break;
					case "walking":
					mode = google.maps.DirectionsTravelMode.WALKING;
					break;
				}
				var request = {
					origin: origin,
					destination: destination,
					waypoints: waypoints,
					travelMode: mode,
					optimizeWaypoints: document.getElementById('optimize').checked,
					avoidHighways: document.getElementById('highways').checked,
					avoidTolls: document.getElementById('tolls').checked
				};
				directionsService.route(request, function(response, status) {
					if (status == google.maps.DirectionsStatus.OK) {
						directionsDisplay.setDirections(response);
					}
				});
				clearMarkers();
				directionsVisible = true;
				nC('#directionsPanel').dialog('open');
			}
			  
			function updateMode() {
				if (directionsVisible) {
					calcRoute();
				}
			}
			  
			function clearMarkers() {
				for (var i = 0; i < markers.length; i++) {
					markers[i].setMap(null);
				}
				for (var i = 0; i < markers_rutas.length; i++) {
					markers_rutas[i].setMap(null);
				}
			}
			  
			  function clearWaypoints() {
			    markers = [];
			    origin = null;
			    destination = null;
			    waypoints = [];
			    directionsVisible = false;
			  }
			  
			  function reset() {
				var rendererOptions = {
					draggable: true
				};
			    clearMarkers();
			    clearWaypoints();
			    directionsDisplay.setMap(null);
			    directionsDisplay.setPanel(null);
			    directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
			    directionsDisplay.setMap(map);
			    directionsDisplay.setPanel(document.getElementById("directionsPanel"));    
				nC("#fin_ruta").attr("disabled",false);
				nC("#inicio_ruta").attr("disabled",false);
				nC("#r_inicio").html('');
				nC("#r_inter").html('');
				nC("#r_fin").html('');
			  }
			 function clear_ruta(){
				nC("#inicio_ruta").val(0);
				nC("#inter_ruta").val(0);
				nC("#fin_ruta").val(0);
			  }
			function mostrar_inter(){
				if(nC("#intermedios").is(":checked")){
					nC("#los_intermedios").fadeIn('slow');
					if(nC("#fin_ruta").val()!='0,0' && nC("#inicio_ruta").val()!='0,0'){
						//waypoints.pop();
					}
				}
				else{
					nC("#los_intermedios").fadeOut('slow');
				}
			}

			  var cambia_noticia;
			function cambiar_noticia(siguiente){
				cambia_noticia=setTimeout(function(){xajax_mostrar_otros(siguiente);/*xajax_alertas_pendietnes();*/},30000);
			}
			function c_noticia(){
				clearTimeout(cambia_noticia);
			}
			function mandar_ruta(){
				var puntos_ruta = Array();
				var puntos=nC("[name=los_puntos]");
				if(puntos.length>=2){
					for(i=0;i<puntos.length;i++){
						puntos_ruta.push(puntos[i].value);
					}
					xajax_procesar_ruta(puntos_ruta);
				}
				else{
					alert("Se necesitan al menos 2 puntos (inicio y fin)");
				}
			}
			</script>
			<script>
			function cache_actualizado(){
				if(typeof alertas_todas == 'undefined'){
					alert("es necesario que borres el cache de tu navegador");
				}
			}
			window.onbeforeunload = confirmaSalida; 
			function confirmaSalida(){    
				if (nC("#no_caduca").is(':checked')){
					cerrar_ventanas();
					return "Se desmarcara la casilla de no caducar, quiere continuar?";  
				}
			}
	</script>
</head>
<body id="fondo" onunload="" onload="xajax_mostrar_vehiculos_act();tiempo_1();tiempo(<? echo (int) $idu;?>,1,1);crear_live(<? echo (int)$idu;?>);xajax_cont_dias();xajax_user_live();load();cache_actualizado();xajax_opciones();" style='min-width:1100px;'>
<!-- Estos divs son para el fondo-->
<center>
	<div id="fondo1">
		<div id="fondo2">
			<div id="fondo3">
				<?php include "menu2.php"; ?>
				<form id="form1"  name="form1" action="javascript:void(null);" onsubmit="return false;" >
				  	<div id="">
						<div id="logo" style='position:absolute;z-index:10;top:70px;left:50px;'>
								<img src='img2/logo1.png' onclick="xajax_opciones();">
						</div><!--Nos muestra el logo de la pagina "oficial"-->
					</div><br><br>
				    <div id="cuerpo_head">	
					    <div id="cont_autos_tabs">
							<div id="dhtmlgoodies_tabView1">
								<div class="dhtmlgoodies_aTab">
									<div id="vehiculos_act"></div>
								</div>
								<div class="dhtmlgoodies_aTab">
									<div id='m_live' style='text-align:left;'></div>
								</div>
								<div class="dhtmlgoodies_aTab" align="left">
									<div align="left" id='las_opciones'></div>
								</div>
							</div>
					    </div>
					    <script type="text/javascript">
							initTabs('dhtmlgoodies_tabView1',Array('Veh&iacute;culos ','Tiempo real ','Opciones '),0,225,225);
						</script>
					    <div id="cont_mapa"></div>
					    <div id="cont_mapa_sepro"></div>
						<div id="num_msj"></div>
						<div id="num_msj1"></div>
				    </div>
					<input type="hidden" name="idusuario" id="idusuario" value="<?php echo $idu; ?>" />
					<input type="hidden" name="mant" id="mant" value="0" />
					<input type="hidden" name="zoom" id="zoom" value="3000" />
					<input type="hidden" name="monitoreo" id="monitoreo" value="0" />
					<input type="hidden" value='<?php echo $ide?>' name="id_emp" id="id_emp"/> 
					<div id="cuerpo_medio"></div>
					<div id='mostrar_veh'>
						<table><tr></tr></table>
						<div id='veh_actual'>
							<input type='hidden' id='veh_actual1' value='<? echo $veh_actual;?>'>
						</div>
					</div><br>
					<font id="info_">
						Contactenos al Teléfono <a href='tel:38255200'>38255200</a> ext. 104 o envíe un email a <a href="mailto:monitoreo_gps@sepromex.com.mx">monitoreo_gps@sepromex.com.mx</a>
					</font>
				</form>	
				<div style=" display:none">
					<div id="capacitacion" title="Capacitaci&oacute;n" align="center">
						<img src="img2/cap/invitacion.jpg" width="900px">
					</div>
					<div id="d" style="margin-left:15px"></div>
					<div id="dialog-confirm" title="Sepromex Informa">
					<table>
						<tr><td><br/><br/><br/><br/><br/>
					 <!--<object type="application/x-shockwave-flash" data="piecemaker.swf" width="800" 

					height="450" > 
					    <param name="movie" value="piecemaker.swf" />
					    <param name="quality" value="high" />
					  </object>-->
					<!--[if !IE]> -->
					   <object type="application/x-shockwave-flash" data="piecemaker.swf" width="800" height="450">
					<!-- <![endif]-->
					<!--[if IE]>-->
					   <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0"  width="800" height="450">
					      <param name="movie" value="piecemaker.swf" />
						<param name="loop" value="true" />
					      <param name="menu" value="false" />
					   </object>
					<!-- <![endif]-->
					</td></tr>
						</table></div>
					<div id="avisoImportante" title="AVISO IMPORTANTE">
						<table>
							<tr><td>El d&iacute;a 25 de marzo nuestro proveedor de servicio de transmisi&oacute;n de datos realizar&aacute; una ventana de mantenimiento.</td></tr>
							<tr><td>La ventana de mantenimiento dar&aacute; inicio a las 00:00 hrs. del d&iacute;a lunes y terminar&aacute; a las 06:00 del mismo d&iacute;a, tiempo en el cual estar&iacute;amos teniendo intermitencia en el tr&aacute;fico de datos 
									</td></tr>
							<tr><td>Gracias por su comprensi&oacute;n.</td></tr>		
						</table>
					</div>
					<div id="g-geo-pol" style='z-index:100000;'></div>
					<div id="dialog-ilsp" title="Envio Posiciones WebService ILSP">
						<div id='listaVehILSP'></div>
						<div id='listaActivosILSP'></div>
					</div>
					<div id="dialog-femsa" title="Envio Posiciones WebService FEMSA">
						<div id='listaVehFEMSA'></div>
						<div id='listaActivosFEMSA'></div>
					</div>
					<div id='dialog-herramientas' title="Trazo de rutas">
						<iframe src="gal_rutas.php" width='830px' height="520px" scrolling="no" style='overflow-x:hidden;overflow-y:hidden;'></iframe>
					</div>
				</div>
				<div id="form_sitios" title="Guardar sitio" align="center"></div>
				<div id="directionsPanel" title="Ruta sugerida" style="background-color:#FFFFFF;"></div>
				<div id="la_ruta" title="Ruta"></div>
				<div id="el_iframe" title="iframe rutas"></div>
				<div id="mis_puntos" title="Puntos"><table><tr><div id='r_inter'></div></tr></table></div>
			</div>
		</div>
	</div>
	<style>
		.ui-dialog { z-index: 1000000 !important ;}
		.dialog_style { background: #000; }
		#info_ { color: #FFFFFF; }
		#info_ a { color: #FFFFFF; }
		#info_ a:hover { text-decoration: none; color:#b2b2b2; }
	</style>
</center>
<div id="e"></div>
</body>
</html>