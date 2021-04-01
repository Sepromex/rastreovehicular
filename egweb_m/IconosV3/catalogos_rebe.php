<?php
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
		$est = $sess->get('sta');
		$prm = $sess->get('per');
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
//se registran variables
require("librerias/conexion.php");
require('../xajaxs/xajax_core/xajax.inc.php');
$xajax = new xajax(); 
$xajax->configure('javascript URI', '../xajaxs/');
$xajax->register(XAJAX_FUNCTION,"catalogo_sitios");
$xajax->register(XAJAX_FUNCTION,"Eliminar_sitio");
$xajax->register(XAJAX_FUNCTION,"Modificar_sitio");
$xajax->register(XAJAX_FUNCTION,"crear_categoria");
$xajax->register(XAJAX_FUNCTION,"guardarDatos");
$xajax->register(XAJAX_FUNCTION,"eliminar_geocerca");
$xajax->register(XAJAX_FUNCTION,"detallar_datos");
$xajax->register(XAJAX_FUNCTION,"alertas");
$xajax->register(XAJAX_FUNCTION,"desasignar");
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
	$cad_pos = "select count(*) as suma ";
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
		$objResponse->assign("num_msj","innerHTML","<a href='principal.php'title='Click para mostrar'>
							  Usted Tiene <u>".$row_pos[0]."</u> msj de Alerta</a> ");
	}
	if($row_pos[0] > 0 && $ban == 1){ // hay registros y dio click
	$objResponse->assign("num_msj","innerHTML","<a href='principal.php'title='Click para mostrar'>
						  Usted Tiene <u>".$row_pos[0]."</u> msj de Alerta</a> ");
	}
	
	if($row_pos[0] == 0 && $ban == 1){ //no hay registros ya dio click
		$objResponse->assign("num_msj","innerHTML","");
	}
return $objResponse;
}

function detallar_datos($veh,$est)
{
	$objResponse = new xajaxResponse();
	$cad_detalle = "select num_veh,id_veh,economico,placas,color,modelo,detalle from vehiculos where num_veh = $veh";
	$resp_detalle = mysql_query($cad_detalle);
	$cad_geo = "select t.nombre,v.num_geo from geo_veh v inner join geo_time t on(t.num_geo = v.num_geo) where v.num_veh = $veh";
	$resp_geo = mysql_query($cad_geo);
	if($resp_detalle != 0)
	{
		$row_veh = mysql_fetch_array($resp_detalle);
		$cad_dsn = "<table border='0' class='fuente' width='580'>";
		$cad_dsn .= "<tr style='background:#204A7F' class='fuente_siete' ><td colspan='3'>Datos del Vehículo</td></tr>";
		$cad_dsn .= "<tr><td width='100'>Número:</td><td colspan='2'>".htmlentities($row_veh[0])."</td></tr>";
		$cad_dsn .= "<tr><td>Identificación:</td><td colspan='2'>".htmlentities($row_veh[1])."</td></tr>";
		$cad_dsn .= "<tr><td>Económico</td><td colspan='2'>".htmlentities($row_veh[2])."</td></tr>";
		$cad_dsn .= "<tr><td>Placas</td><td colspan='2' id='placas'>".htmlentities($row_veh[3])."</td></tr>";
		//$cad_dsn .= "<tr><td>Color:</td><td colspan='2'>".htmlentities($row_veh[4])."</td></tr>";
		$cad_dsn .= "<tr><td>Modelo:</td><td colspan='2' id='modelo'>".htmlentities($row_veh[5])."</td></tr>";
		$cad_dsn .= "<tr><td>Detalle:</td><td colspan='2' id='detalle'>".htmlentities($row_veh[6])."</td></tr>";
		$cad_dsn .= "<tr><td colspan='3' id=\"botones\"><input type='button' class='boton_reporte' value='Actualizar' onclick=\"actualizar($veh);\"/></td></tr>";
		if(mysql_num_rows($resp_geo) > 0){
			$cad_dsn .= "<tr style='background:#204A7F' class='fuente_siete' ><td colspan='3'>Geocercas Asignadas</td></tr>";
			while($row_geo = mysql_fetch_row($resp_geo)){
				$cad_dsn .="<tr><td colspan='2'>".htmlentities(strtoupper($row_geo[0]))."</td>";
				$cad_dsn .="<td width='20' align='right'>";
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

function guardarDatos($datos,$numveh)
{
	$objResponse = new xajaxResponse();
	$modelo = $datos[0];
	$placas = $datos[1];
	$detalle = $datos[2];
	if($numveh != "" && $numveh != null)
	{
		$update = "update vehiculos set modelo='$modelo',placas='$placas',detalle='$detalle' where num_veh=$numveh";
		$result = mysql_query($update);
		if($result)
		{
			$objResponse->alert("Datos actualizados");
			$objResponse->call("datos_vehiculo",$numveh,1);
		}else $objResponse->alert("Error...".mysql_error());
	}
	return $objResponse;	
}

function desasignar($idv,$idg){
	$objResponse = new xajaxResponse();
	$cad_des = "delete from geo_veh where num_geo = $idg and num_veh = $idv";
	$res_des = mysql_query($cad_des);
		if($res_des != 0){
			$objResponse->alert("Se desasignó la geocerca");
			$objResponse->call('xajax_detallar_datos',$idv);
		}
		else{
			$objResponse->alert("Error en el proceso, intente nuevamente");
		}
  	return $objResponse;
}

function catalogo_sitios($n,$ide,$est){
	$objResponse = new xajaxResponse();
	switch($n){
		case 1: //$idu = $ide;
				$cad_veh = "select v.id_veh, v.num_veh from veh_usr as vu inner join vehiculos as v on vu.num_veh = v.num_veh ";
				$cad_veh .= "where vu.id_usuario = $ide order by v.id_veh asc";
				$resp_veh = mysql_query($cad_veh);
				if($resp_veh != 0 ){
					$cad_cont_veh = "<select multiple name='vehiculos' size='30' class='vehiculos' 
									onchange='datos_vehiculo(this.value,$est)' title='Seleccione solo un vehículo'>";
					$cont = 0;
					$numveh = 0;
					while($row = mysql_fetch_array($resp_veh))
					{
						if($cont == 0)
						{
							$cad_cont_veh .= "<option value='$row[1]' selected=true>".utf8_encode($row[0])."</option>";	
							$numveh = $row[1];
						}
						else $cad_cont_veh .= "<option value='$row[1]'>".utf8_encode($row[0])."</option>";	
						$cont++;
					}
				$cad_cont_veh .= "</select>";
				$objResponse->assign('cont_autos','innerHTML',$cad_cont_veh);
				$objResponse->call('datos_vehiculo',$numveh);
				}
				else $objResponse->alert('No se encontraron vehículos para este usuario');
		break;
		case 2: if($est != 3){
					$crea_cat="<table border='0' class='fuente' align='left'>";
					$crea_cat.="<tr><td><input type='button' class='boton_reporte' value='Crear Categoria' ";
					$crea_cat .= " onclick='xajax_crear_categoria(0,$ide)'/></td></tr>";
					$crea_cat .= "<tr><td><input type='button' class='boton_reporte' value='Importar Sitios' ";
					$crea_cat .= " onclick='xajax_crear_categoria(1,$ide)'/></td></tr>";
					$crea_cat .= "</table>";
					$objResponse->assign('categ_sitios','innerHTML',$crea_cat);
				}
				else $objResponse->assign('categ_sitios','innerHTML','');
				$cad_sitios = "select s.nombre,s.latitud,s.longitud,s.contacto,s.tel1,s.tel2,t.descripcion,s.id_sitio from sitios s ";
				$cad_sitios .= "left outer join tipo_sitios t on (t.id_tipo = s.id_tipo) where s.id_empresa = ".$ide." order by s.nombre asc";
				$resp_sitios = mysql_query($cad_sitios);
				mysql_close($conec);
				if(mysql_num_rows($resp_sitios) != 0 ){
				    $tabla_sitios = "<div style='position:absolute;top:0px;'>";
	 				$tabla_sitios .= "<table width='845' border='0'>";
      				$tabla_sitios .= "<tr style='background:#002B5C' class='fuente_siete'>";
					$tabla_sitios .= "<td width='130px'>Nombre</td><td  width='120px'>Tipo</td><td width='120px'>Lat</td><td width='120px'>Long</td><td width='115px'>Contacto</td><td width='100px'>Tel</td>";
      				$tabla_sitios .= "<td width='100px'>Tel</td><td width='20px'>Mod</td><td width='20px'>Elim</td></tr></table></div>";
					$tabla_sitios .="<div style='position:absolute;top:20px;width:865px;height:200px;overflow:auto;'><table width='845' border='0'>";
					while($fila = mysql_fetch_array($resp_sitios)){
						$tabla_sitios .="<tr class='fuente_ocho' style='background:#C6D9F1'><td width='130px'>$fila[0]</td><td width='120px'>".htmlentities($fila[6])."</td>";
						$tabla_sitios .="<td width='120px'>".number_format($fila[1],6,'.','')."</td>";
      					$tabla_sitios .="<td width='120px'>".number_format($fila[2],6,'.','')."</td><td width='115px'>$fila[3]</td><td width='100px'>$fila[4]</td><td width='100px'>$fila[5]</td>";
						if($est != 3){
							$tabla_sitios .="<td width='20px'><img src='img/ico_edita.png' width='15px' height='15px' ";
							$tabla_sitios .="border='0' title='Modificar sitio' onclick='nueva_ventana($ide,$fila[7])' /></td>";
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
		case 3: $cad_sitios = "select num_geo,nombre,IF(tipo = 1,'POLIGONAL','CIRCULAR') AS tipo_geo,tipo from geo_time where id_empresa = $ide";
				$resp_sitios = mysql_query($cad_sitios);
				mysql_close($conec);
				if(mysql_num_rows($resp_sitios) != 0 )
				{
					$tabla_sitios ="<div style='position:absolute;left:200px;top:0px;width:500px;'>";
					$tabla_sitios .= "<table width='500' border='0'>";
      				$tabla_sitios .= "<tr style='background:#204A7F' class='fuente_siete'>";
					$tabla_sitios .= "<td width='335'>Nombre</td><td width='120'>Tipo</td><td width='45'>Eliminar</td></tr></table></div>";
					$tabla_sitios .="<div style='position:absolute;left:200px;top:20px;width:520px;height:210px;overflow:auto;'><table width='500' border='0'>";
					while($fila = mysql_fetch_array($resp_sitios))
					{
						$tabla_sitios .="<tr class='fuente_ocho' style='background:#C6D9F1'><td width='335'>".htmlentities($fila[1])."</td><td width='120'>$fila[2]</td>";
						if($est!=3)
						{	
							$tabla_sitios .="<td width='45'><img src='img/ico_delete.png' style='cursor:pointer;' width='15px' height='15px' ";
							$tabla_sitios .="border='0' title='Eliminar geocerca' onclick='exe_eliminar_geo($fila[0],$ide,$fila[3])'/></td></tr>";
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
		}
		return $objResponse;
}

function Eliminar_sitio($id_sitio,$ide){
	$objResponse = new xajaxResponse();
	$crea_cat="<table border='0' class='fuente'>";
	$crea_cat.="<tr><td><input type='button' class='boton_reporte' value='Crear Categoria' ";
	$crea_cat .= " onclick='xajax_crear_categoria(0,$ide)'/></td></tr>";
	$crea_cat .= "<tr><td><input type='button' class='boton_reporte' value='Importar Sitios' ";
	$crea_cat .= " onclick='xajax_crear_categoria(1,$ide)'/></td></tr>";
	$crea_cat .= "</table>";
	$objResponse->assign('categ_sitios','innerHTML',$crea_cat);	
	$cad_elimina="Delete from sitios where id_sitio = ".$id_sitio ." and id_empresa = ".$ide;
	$resp = mysql_query($cad_elimina);
	if($resp!=0){
			$objResponse->alert('Se eliminó el sitio seleccionado');
			$cad_sitios = "select s.nombre,s.latitud,s.longitud,s.contacto,s.tel1,s.tel2,t.descripcion,s.id_sitio from sitios s ";
			$cad_sitios .= "left outer join tipo_sitios t on (t.id_tipo = s.id_tipo) where s.id_empresa = ".$ide;
			$resp_sitios = mysql_query($cad_sitios);
			mysql_close($conec);
				if(mysql_num_rows($resp_sitios) != 0 ){
					$tabla_sitios = "<table width='865' border='0'>";
      				$tabla_sitios .= "<tr style='background:#204A7F' class='fuente_siete'>";
					$tabla_sitios .= "<td>Nombre</td><td>Tipo</td><td>Lat</td><td>Long</td><td>Contacto</td><td>Tel</td>";
      				$tabla_sitios .= "<td>Tel</td><td>Modificar</td><td>Eliminar</td></tr>";
					while($fila = mysql_fetch_array($resp_sitios)){
						$tabla_sitios .="<tr class='fuente_ocho' style='background:#C6D9F1'><td>$fila[0]</td><td>".htmlentities($fila[6])."</td>";
						$tabla_sitios .="<td>".number_format($fila[1],6,'.','')."</td>";
      					$tabla_sitios .="<td>".number_format($fila[2],6,'.','')."</td><td>$fila[3]</td><td>$fila[4]</td><td>$fila[5]</td>";
						$tabla_sitios .="<td><img src='img/ico_edita.png' width='20' height='20' ";
						$tabla_sitios .="border='0' title='Modificar Sitio' onclick='nueva_ventana($ide,$fila[7])' /></td>";
						$tabla_sitios .="<td><img src='img/ico_delete.png' width='20' height='20' ";
						$tabla_sitios .="border='0' title='Eliminar Sitio' onclick='exe_eliminar($fila[7],$ide)'/></td></tr>";
					}
					$tabla_sitios .= "</table>";
					$objResponse->assign('sitios_interes','innerHTML',$tabla_sitios);
				}
				else{
					$objResponse->alert('No se encontraron sitios de interes para su empresa');
					$objResponse->assign('sitios_interes','innerHTML','');
					}
	}else $objResponse->alert('No se puede eliminar el sitio');
  return $objResponse;
}

function eliminar_geocerca($id_geo,$ide,$tipo){
	$objResponse = new xajaxResponse();
		$cad_elimina="Delete from geo_time where num_geo = $id_geo and id_empresa = $ide";
		$resp = mysql_query($cad_elimina);
		if($resp!=0){
			$cad_asig = "delete from geo_veh where num_geo = $id_geo";
			mysql_query($cad_asig);//elimina las a signaciones de esa geocerca
			if($tipo == 0){
				$objResponse->alert('Se Eliminó la Geocerca Seleccionada');
			}
					
			if($tipo == 1){
				$cad_puntos = "Delete from geo_puntos where id_geo = $id_geo";
				$resp_pts = mysql_query($cad_puntos);
				if($resp_pts!=0){
					$objResponse->alert('Se eliminó la Geocerca Seleccionada');
				}
				else
					$objResponse->alert('No se eliminaron los vertices de la geocerca');
			}
		}else
			$objResponse->alert('No se Eliminó la Geocerca Seleccionada');
		$cad_sitios = "select num_geo,nombre,IF(tipo = 1,'POLIGONAL','CIRCULAR') AS tipo_geo,tipo from geo_time where id_empresa = $ide";
		$resp_sitios = mysql_query($cad_sitios);
		if(mysql_num_rows($resp_sitios) != 0 ){
			$tabla_sitios = "<table width='500' border='0'>";
      		$tabla_sitios .= "<tr style='background:#204A7F' class='fuente_siete'>";
			$tabla_sitios .= "<td>Nombre</td><td>Tipo</td><td>Eliminar</td></tr>";
			while($fila = mysql_fetch_array($resp_sitios)){
				$tabla_sitios .="<tr class='fuente_ocho' style='background:#C6D9F1'><td>".htmlentities($fila[1])."</td><td>$fila[2]</td>";
				$tabla_sitios .="<td><img src='img/ico_delete.png' width='20' height='20' ";
				$tabla_sitios .="border='0' title='Eliminar Sitio' onclick='exe_eliminar_geo($fila[0],$ide,$fila[3])'/></td></tr>";
			}
			$tabla_sitios .= "</table>";
			$objResponse->assign('sitios_interes','innerHTML',$tabla_sitios);
		}
		else{  
			$objResponse->alert('No se Encontraron Geocercas para su empresa');
			$objResponse->assign('sitios_interes','innerHTML','');
			}
	mysql_close($conec);
  return $objResponse;
}

function crear_categoria($n,$ide){
	$objResponse = new xajaxResponse();
		$cad_cate = "<div align='left'><table border='0' class='fuente'>";
		if($n==0){
    		$cad_cate .="<tr bgcolor='#204A7F' class='fuente_siete'><td colspan='2' >Crear Nueva Categoria:</td></tr>";
    		$cad_cate .="<tr><td>Nombre:</td><td><input type='text' name='nombre' /></td></tr>";
    		$cad_cate .="<tr><td>Imagen:</td><td><input type='file' name='imagen'  /></td></tr>";
    		$cad_cate .="<tr><td>&nbsp;</td><td><input type='submit' name='enviar' id='button' value='Enviar' class='boton_x'/>";
			$cad_cate .= " <input type='button' name='cancelar' value='Cancelar' class='boton_x' onclick='xajax_catalogo_sitios(2,$ide)'/></td></tr>";
		}
		if($n==1){
    		
            $cad_cate .= "<tr bgcolor='#204A7F'  class='fuente_siete'><td>Importar Sitios de Interes:</td></tr>";
			$cad_cate .= "<tr><td>Seleccione archivo de excel<td></tr>";
			$cad_cate .= "<tr><td>Nota: Solo archivos .xls, no soporta .xlsx <td></tr>";
		    $cad_cate .= "<tr><td><input type='file' name='imp_excel' id='imp_excel' size='5'/><td></tr>";
			$cad_cate .= "<tr><td><input type='submit' name='procesa' value='Procesa' id='procesa' class='boton_x'/>";
			$cad_cate .= " <input type='button' name='cancelar' value='Cancelar' class='boton_x' onclick='xajax_catalogo_sitios(2,$ide)'/></td></tr>";
		}
    	$cad_cate .= "</table></div>";

	$objResponse ->assign('importa_cat','innerHTML','');
	$objResponse ->assign('categ_sitios','innerHTML',$cad_cate);
	return $objResponse;
}

$xajax->processRequest(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>EGWEB 4.0</title>
 <?php if($dis == 1){ ?>
	<link href="librerias/dsn.css" rel="stylesheet" type="text/css" />
    <?php }
	if($dis == 2){
	?>
    <link href="librerias/dsn1.css" rel="stylesheet" type="text/css" />
    <?php } 
	if($dis == 3){
	?>
    <link href="librerias/dsn2.css" rel="stylesheet" type="text/css" />
    <?php }?>
	<script type='text/javascript' src="librerias/jquery.js"></script>
	<script type="text/javascript" src="librerias/func_catalogos.js"></script>
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
	<script type="text/javascript" >
function tiempo(idu,p){
	if(p==1){
		setTimeout('tiempo('+idu+','+p+')',50000);
		document.getElementById('num_msj').innerHTML='<img src="img/loader.gif" width="15px" height="15px" />';
		xajax_alertas(idu);
	}
}
</script>
<?php 
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
</head>
<center>
<body id="fondo" onload="tiempo(<?php echo (int)$idu ?>,<?php echo $pan ?>);c_tipo(1,<?php echo (int)$idu?>,<?php echo $est?>);">
  	<div id="fondo_principal">
  	<div id="cuerpo2">
    <form action="procesar_imp.php" method="post" name="importar" enctype="multipart/form-data">
  		<div id="psw_session" class="fuente_cinco">
        <a href="<?php echo $_SERVER['PHP_SELF']."?Logout=true&".$queryString; ?>">Cerrar Sesi&oacute;n</a>
    </div>
    <div id="msg_bvnd" class="fuente">
    Bienvenido, <label class="fuente_dos"><?php echo htmlentities($nom); ?></label>
    </div>
    <div id="num_msj" class="fuente_once"></div>
    <div id="menu">
    	<ul id="lista_menu">
            <li><a href="javascript:void(null);" onclick="ayuda();">Ayuda</a></li>
            <!--<li><a href="descargas.php">Descargas</a></li>-->
        	<li><a href="Eventos.php">Eventos</a></li>
            <?php 
			$si = strstr($prm,"5");
			if(($est != 3) ||($est == 3 && !empty($si))){?>
            <li><a href="recorrido_nuevo.php">Reportes</a></li>
            <?php }?>
            <li><a href="usuarios.php">Usuarios</a></li>
            <?php 
			$si = strstr($prm,"6");
			if(($est != 3) ||($est == 3 && !empty($si))){?>
            <li id="current"><a href="catalogos.php">Catálogo</a></li>
            <?php } if($est!=3){?>
            <li><a href="empresa.php">Mi Empresa</a></li>
			<?php } ?>
            <li><a href="principal.php">Localización</a></li>
        </ul>
    </div>
    <div id="menu_catalogo">
    	<ul id="cat_menu">
           	<li id="coches"><a href="javascript:void(null);" onclick="c_tipo(1,<?php echo (int)$idu?>,<?php echo $est?>);">Vehículos</a></li>
            <li id="sitInt"><a href="javascript:void(null);" onclick="c_tipo(2,<?php echo $ide?>,<?php echo $est?>);">Sitios de Interés</a></li>
            <li id="geoCer"><a href="javascript:void(null);" onclick="c_tipo(3,<?php echo $ide?>,<?php echo $est?>);">Geocercas</a></li>
        </ul>
    </div>
    <div id="importa_cat" style="visibility:hidden"></div>
    <div id='cont_autos' style="visibility:hidden"></div>
    <div  id="detalle_veh" style="visibility:hidden"></div>
    <div id="categ_sitios" style="visibility:hidden"></div>
    <div id="sitios_interes" style="visibility:hidden"></div>
	<div id="contacto">Contactenos al Teléfono 38255200 ext. 117 o envíe un email a <u>aclientes@sepromex.com.mx</u></div>
    </form>
  </div>
</div> 
</body>
</center>
</html>