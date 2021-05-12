<?php 
  include('ObtenUrl.php');
  include_once('../patError/patErrorManager.php');
  patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
  patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
  patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );
  include_once('../patSession/patSession.php');
  $sess =& patSession::singleton('egw', 'Native', $options );
  $estses = $sess->getState();
  if (isset($_GET["Logout"])){
    $web = $sess->get("web");
	$sess->Destroy();
	if($web == 1)
		header("Location: indexApa.php?$web");
	else header("Location: index.php?$web");
  }
  if ($estses == empty_referer) {
    if($web == 1)
		header("Location: indexApa.php?$web");
	else header("Location: index.php?$web");
  } 
  $result = $sess->get( 'expire-test' );
  if ((!patErrorManager::isError($result)) && ($sess->get('Idu'))) {
		$queryString = $sess->getQueryString();	
		$idu = $sess->get("Idu");
		$ide = $sess->get("Ide");
    	$usn = $sess->get("Usn");
		$pol = $sess->get("Pol");
		$reg = $sess->get('Registrado');
		$nom = $sess->get('nom');
		$prm = $sess->get('per');
		$est = $sess->get('sta');
		$eve = $sess->get('eve');
		$dis = $sess->get('dis');
		$pan = $sess->get('pan');
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
require('../xajaxs/xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI', '../xajaxs/');
$xajax->register(XAJAX_FUNCTION,"alertas");
$xajax->register(XAJAX_FUNCTION,"eliminaUsr");
$xajax->register(XAJAX_FUNCTION,"crearInterUsr");
$xajax->register(XAJAX_FUNCTION,"generaUsr");
$xajax->register(XAJAX_FUNCTION,"crearInterUsrMod");
$xajax->register(XAJAX_FUNCTION,"modificaUsr");
$xajax->register(XAJAX_FUNCTION,'matarSesion');
  
function matarSesion(){
	//$chequeo=0;
	$objResponse = new xajaxResponse();
	patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
	patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
	patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );
	include_once('../patSession/patSession.php');
	 $sess =& patSession::singleton('ham', 'Native', $options );
	$sess->destroy();
	$objResponse-> redirect("index.php");
	return $objResponse;
} 

function alertas($idu){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$evento = $sess->get('evf');
	$ban = $sess->get('ban');	
	$cad_pos =  "select count(*) as suma ";
	$cad_pos .= " from veh_usr v ";
	$cad_pos .= " left outer join mon_alarmas p on (v.num_veh = p.num_veh)";
	$cad_pos .= " where v.id_usuario = $idu";
	$cad_pos .= " and p.fecha >'".$evento."' and p.entradas = 252";
	$res_pos = mysql_query($cad_pos);
	$row_pos = mysql_fetch_row($res_pos);
	sleep(3);
	if($row_pos[0] == 0 && $ban == 0){ //no hay registros no puede dar click
		$objResponse->assign("num_msj","innerHTML","");
	}
	if($row_pos[0] > 0 && $ban == 0){ //hay registros no a dado click
		$objResponse->assign("num_msj","innerHTML","<a href='principal.php' style='color:#fdb930;' title='Click para mostrar'>
							  Usted Tiene <u>".$row_pos[0]."</u> msj de Alerta</a> ");
	}
	if($row_pos[0] > 0 && $ban == 1){ // hay registros y dio click
	$objResponse->assign("num_msj","innerHTML","<a href='principal.php' style='color:#fdb930;' title='Click para mostrar'>
						  Usted Tiene <u>".$row_pos[0]."</u> msj de Alerta</a> ");
	}
	
	if($row_pos[0] == 0 && $ban == 1){ //no hay registros ya dio click
		$objResponse->assign("num_msj","innerHTML","");
	}
return $objResponse;
}


function eliminaUsr($idu){
	$objResponse = new xajaxResponse();
	//$cad_usr = "update usuarios set estatus='0' where id_usuario = $idu";
	$cad_usr = "delete from usuarios where id_usuario = $idu";
	$res_usr = mysql_query($cad_usr);
	if($res_usr){
		$cad_asg="delete from veh_usr where id_usuario=$idu";
	 	mysql_query($cad_asg);
		$objResponse->alert("Se eliminó el usuario seleccionado");
		$objResponse->redirect("usuarios.php",1);
	}else $objResponse->alert("Falló la solicitud, intente nuevamente");
	return $objResponse;
}

function crearInterUsr($idup,$ide){
	$objResponse = new xajaxResponse();
	$dsn = "<div id='det_usuario1'><form id='frmusuario' action='javascript:void(null);' method='post' name='frmusuario'>";
	$dsn .= "<div id='usuario2'>DATOS GENERALES";
	$dsn .= "<table id='rounded-corner' style='width:250px'>";
	$dsn .= "<tr><td>Usuario</td><td><input type='text' size='15' name='usuario' maxlength='10' /></td></tr>";
	$dsn .= "<tr><td>Contraseña</td><td><input type='password' size='15' name='passw' maxlength='32'/></td></tr>";
	$dsn .= "<tr><td>Fecha Inicio</td><td><input type='text' size='15' name='fecha_ini' readonly='readonly' value='".date('Y-m-d')." 00:00:00'/>";
	$dsn .= " <img onclick='fecha();' src='img/cal.gif' name='fechaini'/></td></tr>";
	$dsn .= "<tr><td>Fecha Fin</td><td><input type='text' size='15' name='fecha_fin' readonly='readonly' value='".date('Y-m-d')." 23:59:59'/>";
	$dsn .= " <img onclick='fecha2();' src='img/cal.gif' name='fechafin'/></td></tr>";
	$dsn .= "<input type='hidden' name='empresa' value='$ide' /></table>";
	$dsn .= "</div>";
	$dsn .= "<div id='usuario6'>FUNCIONES";
	$dsn .= "<table id='rounded-corner' style='width:230px' >";
	$dsn .= "<tr><td width='29'><input type='checkbox' value='1' name='perm0'/></td>";
	$dsn .= "<td width='166'>Solicitud de Posición</td></tr>";
	$dsn .= "<tr><td><input type='checkbox' value='2' name='perm1'/></td>";
	$dsn .= "<td>Creación de Geocercas</td></tr>";
	$dsn .= "<tr><td><input type='checkbox' value='3' name='perm2'/></td>";
	$dsn .= "<td>Creación de Sitios de Interés </td></tr>";
	$dsn .= "<tr><td><input type='checkbox' value='4' name='perm3'/>";
	$dsn .= "</td><td>Envío de mensajes</td></tr>";
	$dsn .= "<tr><td><input type='checkbox' value='5' name='perm4'/></td>";
	$dsn .= "<td>Acceso a reportes</td></tr>";
	$dsn .= "<tr><td><input type='checkbox' value='6' name='perm5'/></td>";
	$dsn .= "<td>Acceso a catálogos </td></tr>";
	$dsn .= "<tr><td colspan='2'>";
	$dsn .= "<input type='image' height='20' width='20' src='img/filesaveas.png' onclick='guardar_usuario();' title='Guardar datos de usuario'/>";
	$dsn .= "</td></tr>";
	$dsn .= "</table>";
	$dsn .= "</div>";
	$dsn .= "<div id='usuario5'>ASIGNAR VEHICULOS";
	$dsn .= "<select class='select' title='CTRL+Clic para seleccionar varios vehículos' name='vehiculos' multiple='multiple'>";
	$cad_veh = "SELECT v.NUM_VEH, v.ID_VEH FROM veh_usr AS vu Inner Join vehiculos AS v ON ";
   	$cad_veh .= "vu.NUM_VEH = v.NUM_VEH WHERE vu.ID_USUARIO = $idup ORDER BY v.ID_VEH ASC";
   	$res_veh = mysql_query($cad_veh);
	while($row = mysql_fetch_array($res_veh)){
		$dsn .= "<option value='$row[0]'>".utf8_encode($row[1])."</option>";
	}
	$dsn .= "</select>";
	$dsn .= "</div>";
	$dsn .= "</form></div>";
	//$objResponse->assign("det_usuario","innerHTML",);
	$objResponse->assign('det_usuario','innerHTML',$dsn);
	//$objResponse->alert($dsn);
	return $objResponse;
}

function crearInterUsrMod($idup,$idu,$ide){
	$objResponse = new xajaxResponse();
		$cad_usr = "select username,password,f_inicio,f_termino,permisos from usuarios where id_usuario = $idu";
		$res_usr = mysql_query($cad_usr);
		$rusr = mysql_fetch_row($res_usr);
		$dsn = "<div id='det_usuario1'><form id='frmusuario' action='javascript:void(null);' method='post' name='frmusuario'>";
		$dsn .= "<div id='usuario2'>DATOS GENERALES";
		$dsn .= "<table id='rounded-corner' style='width:250px'>";
		$dsn .= "<tr><td>Usuario</td><td><input type='text' size='15' name='usuario' maxlength='10' value='$rusr[0]'/></td></tr>";
		$dsn .= "<tr><td>Contraseña</td><td><input type='password' size='15' name='passw' maxlength='32' value='$rusr[1]' /></td></tr>";
		$dsn .= "<tr><td>Fecha Inicio</td><td><input type='text' size='15' name='fecha_ini' readonly='readonly' value='$rusr[2]'/>";
		$dsn .= " <img onclick='fecha();' src='img/cal.gif' name='fechaini'/></td></tr>";
		$dsn .= "<tr><td>Fecha Fin</td><td><input type='text' size='15' name='fecha_fin' readonly='readonly' value='$rusr[3]'/>";
		$dsn .= " <img onclick='fecha2();' src='img/cal.gif' name='fechafin'/></td></tr>";
		$dsn .= "<input type='hidden' name='empresa' value='$ide' /><input type='hidden' name='idusuario' value='$idu' /></table>";
		$dsn .= "</div>";
		$dsn .= "<div id='usuario6'>FUNCIONES";
		$dsn .= "<table id='rounded-corner' style='width:230px' >";
		$per = strstr($rusr[4],"1");
			if(!empty($per)) 		
				$dsn .= "<tr><td width='29'><input type='checkbox' value='1' name='perm0' checked='checked'/></td>";
			else
				$dsn .= "<tr><td width='29'><input type='checkbox' value='1' name='perm0'/></td>";
		$dsn .= "<td width='166'>Solicitud de Posición</td></tr>";
		$per = strstr($rusr[4],"2");
			if(!empty($per)) 		
				$dsn .= "<tr><td><input type='checkbox' value='2' name='perm1' checked='checked'/></td>";
			else
				$dsn .= "<tr><td><input type='checkbox' value='2' name='perm1'/></td>";
		$dsn .= "<td>Creación de Geocercas</td></tr>";
		$per = strstr($rusr[4],"3");
			if(!empty($per)) 
				$dsn .= "<tr><td><input type='checkbox' value='3' name='perm2' checked='checked'/></td>";
			else
				$dsn .= "<tr><td><input type='checkbox' value='3' name='perm2'/></td>";
		$dsn .= "<td>Creación de Sitios de Interés </td></tr>";
		$per = strstr($rusr[4],"4");
			if(!empty($per)) 
				$dsn .= "<tr><td><input type='checkbox' value='4' name='perm3' checked='checked'/>";
			else
				$dsn .= "<tr><td><input type='checkbox' value='4' name='perm3'/>";		
		$dsn .= "</td><td>Envío de mensajes</td></tr>";
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
		$dsn .= "<tr><td colspan='2'>";
		$dsn .= "<input type='image' height='20px' width='20px' src='img/filesaveas.png' onclick='modificar_usuario();' ";
		$dsn .= "title='Guardar Actualización'/>";
		$dsn .= "<input type='image' height='20px' width='20px' src='img/cancel.png' onclick='cancelarModUsr();' title='Cancelar Actualización' />";
		$dsn .= "</td></tr>";
		$dsn .= "</table>";
		$dsn .= "</div>";
		$dsn .= "<div id='usuario5'>ASIGNAR VEHICULOS";
		$dsn .= "<select class='select' title='CTRL+Clic para seleccionar varios vehículos' name='vehiculos' multiple='multiple'>";
		$cad_veh = "SELECT v.NUM_VEH, v.ID_VEH FROM veh_usr AS vu Inner Join vehiculos AS v ON ";
   		$cad_veh .= "vu.NUM_VEH = v.NUM_VEH WHERE vu.ID_USUARIO = $idup ORDER BY v.ID_VEH ASC";
   		$res_veh = mysql_query($cad_veh);
		while($row = mysql_fetch_array($res_veh)){
			$cad_vusr = "select num_veh from veh_usr where num_veh = ".$row[0]." and id_usuario = ".$idu;
			$res_vusr = mysql_query($cad_vusr);
			$num = mysql_num_rows($res_vusr);
			if($num==1)
				$dsn .= "<option value='$row[0]' selected='selected' >".htmlentities($row[1])."</option>";
			else
				$dsn .= "<option value='$row[0]' >".htmlentities($row[1])."</option>";
		}
		$dsn .= "</select>";
		$dsn .= "</div>";
		$dsn .= "</form></div>";
		$objResponse->assign('det_usuario','innerHTML',$dsn);
	return $objResponse;
}

function generaUsr($formUsr){
	$objResponse = new xajaxResponse();
	require("librerias/conexion.php");
	$empresa    = $formUsr['empresa'];
	$usrNvo    = $formUsr['usuario'];
	$pass      = $formUsr['passw'];
	$fecha_ini = $formUsr['fecha_ini'];
	$fecha_fin = $formUsr['fecha_fin'];
	$fecha_act = date("Y-m-d H:i:s");
	$permisos  = $formUsr['perm0']."".$formUsr['perm1']."".$formUsr['perm2']."".$formUsr['perm3']."".$formUsr['perm4']."".$formUsr['perm5'];
	$vehiculos  = $formUsr['vehiculos'];
	if($usrNvo == ''){
		$objResponse->alert("Inserte el nombre del usuario");
	}else if($pass == ''){
				$objResponse->alert("Inserte la contraseña para el nuevo usuario");
			}else if(count($vehiculos)==0){
							$objResponse->alert("Seleccione minimo un vehículo");
						}else if(!stringValido($usrNvo) || !stringValido($pass)){
								$objResponse->alert("Inserte usuario y contraseña validos");						
							}else if((date($fecha_ini) < date($fecha_fin)) && (date($fecha_act) < date($fecha_fin)) ){
								$cad_che = "select username from usuarios where username = '$usrNvo'";
								$res_che = mysql_query($cad_che);
								$rownum = mysql_num_rows($res_che);
								if($rownum == 0){
									$cad_qry  ="insert into usuarios(id_empresa,username,password,estatus,f_inicio,f_termino,statusmxc,poleo_web,";
									$cad_qry .="permisos) values('$empresa','$usrNvo','$pass',3,'$fecha_ini','$fecha_fin','0','1','$permisos')";
									$res_qry = mysql_query($cad_qry);
										if($res_qry){
											$idNvo = mysql_insert_id($conec);
											$cad_asg = "insert into veh_usr values ";
												for($i=0; $i<count($vehiculos); $i++){
													$cad_asg .= "('$empresa','$idNvo','$vehiculos[$i]','0','0','$fecha_ini','$fecha_fin'),";
												}
											$cad_asig = substr($cad_asg,0,strlen($cad_asg)-1);
											mysql_query($cad_asig);
											$objResponse->alert("Se creó el usuario correctamente");
											$objResponse->redirect("usuarios.php",1);
										} else $objResponse->alert("Fallo el envio, intente nuevamente");
								}else $objResponse->alert("El nombre del usuario ya está registrado, favor de intentar con otro");
							} else $objResponse->alert("La fecha final debe ser mayor a la fecha inicial y a la actual");
return $objResponse;
}

function modificaUsr($formUsr){
	$objResponse = new xajaxResponse();
	require("librerias/conexion.php");
	$empresa    = $formUsr['empresa'];
	$idusuario  = $formUsr['idusuario'];
	$usrNvo    = $formUsr['usuario'];
	$pass      = $formUsr['passw'];
	$fecha_ini = $formUsr['fecha_ini'];
	$fecha_fin = $formUsr['fecha_fin'];
	$fecha_act = date("Y-m-d H:i:s");
	$permisos  = $formUsr['perm0']."".$formUsr['perm1']."".$formUsr['perm2']."".$formUsr['perm3']."".$formUsr['perm4']."".$formUsr['perm5'];
	$vehiculos  = $formUsr['vehiculos'];
	if($usrNvo == ''){
		$objResponse->alert("Inserte el nombre del usuario");
	}else if($pass == ''){
				$objResponse->alert("Inserte la contraseña para el nuevo usuario");
			}else if($permisos == ''){
					$objResponse->alert("Seleccione minimo una función");
				  }else if(count($vehiculos)==0){
							$objResponse->alert("Seleccione minimo un vehículo");
						}else if(!stringValido($usrNvo) || !stringValido($pass)){
								$objResponse->alert("Inserte usuario y contraseña validos");						
							}else if((date($fecha_ini) < date($fecha_fin)) && (date($fecha_act) < date($fecha_fin)) ){
								$numrow = true;
								$cad_che = "select username from usuarios where id_usuario <> '$idusuario'";
								$res_che = mysql_query($cad_che);
								while($rowche = mysql_fetch_row($res_che)){
									if($rowche[0] == $usrNvo){
										$numrow = false;
										break;
									}
								}
								if($numrow){
									$cad_qry  ="update usuarios set id_empresa='$empresa',username='$usrNvo',password='$pass',estatus='3',";
									$cad_qry .="f_inicio='$fecha_ini',f_termino='$fecha_fin',statusmxc='0',poleo_web='1',permisos='$permisos'";
									$cad_qry .=" where id_usuario = $idusuario";
									$res_qry = mysql_query($cad_qry);
										if($res_qry){
											$cad_des="delete from veh_usr where id_usuario='$idusuario'";
											mysql_query($cad_des);
											$cad_asg = "insert into veh_usr values ";
											for($i=0; $i<count($vehiculos); $i++){
												$cad_asg .= "('$empresa','$idusuario','$vehiculos[$i]','0','0','$fecha_ini','$fecha_fin'),";
											}
										$cad_asig = substr($cad_asg,0,strlen($cad_asg)-1);
										mysql_query($cad_asig);
										$objResponse->alert("Se modficó el usuario correctamente");
										$objResponse->redirect("usuarios.php",1);
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
$xajax->processRequest();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>EGWEB 4.0</title>

<link href="css/black.css" rel="stylesheet" type="text/css" />
   
<script type="text/javascript" language="javascript" src="librerias/jquery.js"></script>	
<script type="text/javascript" src="librerias/func_principal.js"></script>
<script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar3.js"></script>
<script language="JavaScript">
function tiempo(idu,p){
	if(p==1){
		setTimeout('tiempo('+idu+','+p+')',50000);
		document.getElementById('num_msj').innerHTML='<img src="img/loader.gif" width="15px" height="15px" />';
		xajax_alertas(idu);
	}
}
function ayuda(){
    window.open("Ayuda/Ayuda.php","ayuda","width=400,height=350,left=500,top=200");
}

function window_veh(id){
   window.open('vehiculos.php?idu='+id,'vehiculos','width=280,height=250,left=300,top=200,scrollbars=no');
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
}

function sust_cancel(obj,idupadre,ide){
	var ident = obj.parentNode;
	ident.innerHTML='<input type="image" width="20" height="20" title="Agregar usuario" src="img/agregar1.png" onclick="sust_agregar(this,'+idupadre+','+ide+');"/>';
	document.getElementById('det_usuario').innerHTML = "";
}
function fecha(){ //Cuadro de texto, fecha de inicio
		 var cal2 = new calendar3(document.forms["frmusuario"].elements["fecha_ini"]);
		 cal2.year_scroll = true;
		 cal2.time_comp = true; 	 	 
		 document.forms['frmusuario'].elements['fecha_ini'].value = "";
		 javascript:cal2.popup();
}
function fecha2(){ //Cuadro de texto fecha final
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

</script>
<script type="text/javascript">
idleTime = 0;
$(document).ready(function () {
    //Increment the idle time counter every minute.
    var idleInterval = setInterval("timerIncrement()", 60000); // 1 minute

    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
})
function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime > 29) { // 30 minutes
       xajax_matarSesion();
    }
}
</script>
<?php 
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
</head>
<body id="fondo" onLoad="tiempo(<?php echo (int)$idu ?>,<?php echo $pan ?>);">
<center>
<div id="fondo1">
<div id="fondo2">
<div id="fondo3">
	<div id="cuerpo2">
  		 <div id="cuerpoSuphead">
			<div id="logo"><img src='img2/logo1.png'></div><!--Nos muestra el logo de la pagina "oficial"-->
                <div id="psw_session" >
                Bienvenido <label ><b><?php echo htmlentities($nom); ?></b></label>&nbsp;&nbsp;
                <? 
				if(preg_match('/^principal/',curPageName())){
				?>
                <a href="javascript:void(null);" onclick="init()"> Cambiar Contraseña </a>
                |
				<?
				}
				?>
				<a href="<?php echo $_SERVER['PHP_SELF']."?Logout=true&".$queryString; ?>"> Cerrar Sesi&oacute;n </a>
                </div>
    		</div>
        <div id="num_msj" class="fuente_once"></div>
		<div id="cuerpo_head" >
			<div id="menu">
				<?php include("includes/menu.php");?>
			</div>
		</div>	
		
	<div id="emp2_U">
	<?php 
	if($est != 3){
		$cad_usr = "select id_usuario, username, f_inicio, f_termino from usuarios where id_empresa = $ide and estatus = 3";
	}else{
		$cad_usr = "select id_usuario, username, f_inicio, f_termino from usuarios where id_usuario = $idu";
	}
	$res_usr = mysql_query($cad_usr);
	?>
	<table width='765' border='0' cellspacing='0' id='newspaper-a1' style='margin-top:0px;'>
	<tr>
    <th colspan='4'>&nbsp;</th>
    <th id='acciones'>
    <?php 
	if($est != 3){?>
    	<input type="image" width="20" height="20" title="Crear usuario" 
    	src="img/agregar1.png" onclick="sust_agregar(this,<?php echo (int)$idu;?>,<?php echo (int)$ide;?>);"/>
    <?php }?>
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
		echo "<td width='50'><a href='javascript:window_veh(".(int)$rowusr[0].");' style='color:#fdb930;' title='Ver vehículos asignados'>Mostrar</a></td>";
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
	}
	?>
	</table>
	</div>
	<div id="det_usuario"></div>
	<div id="cuerpo_button">
		<div id="contacto_ind">Contactenos al Teléfono 38255200 ext. 206 o envíe un email a 
			<a href="mailto:aclientes@sepromex.com.mx">aclientes@sepromex.com.mx</a>
		</div>
	</div>
  </div>
  </div>
</div>
</div>
</center>
</body>
</html>
