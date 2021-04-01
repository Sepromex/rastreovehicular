<?
include('ObtenUrl.php');
include('../adodb/adodb.inc.php');
require_once('../FirePHPCore/FirePHP.class.php');
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
if((!patErrorManager::isError($result)) && ($sess->get('Idu'))){
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
}else{
    $web = $sess->get("web"); 
	$sess->Destroy();
	if($web == 1 )
		header("Location: indexApa.php?$web");
	else header("Location: index.php?$web");      	      	
}

require("librerias/conexion.php");
require('../xajaxs/xajax_core/xajax.inc.php');
$xajax = new xajax(); 

if(preg_match('/seprosat/',curPageURL())){
	$xajax->configure('javascript URI', 'http://www.sepromex.com.mx:81/'.'xajaxs/');
}else{
	$xajax->configure('javascript URI', '../xajaxs/');
}

$xajax->register(XAJAX_FUNCTION,"velocidades");
$xajax->register(XAJAX_FUNCTION,"mostrar_config");
$xajax->register(XAJAX_FUNCTION,"borrar");
	
function borrar($veh){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	mysql_query("DELETE FROM config_vel where num_veh=$veh AND id_usuario=".$sess->get('Idu'));
	$objResponse->script("xajax_velocidades()");
	return $objResponse;
}
function velocidades(){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idemp = $sess->get("Ide");
	$idu=$sess->get("Idu");
	$query="SELECT v.ID_VEH, v.NUM_VEH,v.estatus,ev.publicapos,ev.descripcion FROM veh_usr AS vu INNER JOIN vehiculos AS v ON vu.NUM_VEH = v.NUM_VEH
			INNER JOIN estveh ev ON v.estatus = ev.estatus WHERE vu.ID_USUARIO = $idu AND ev.publicapos = 1 AND vu.activo = 1 ORDER BY v.ID_VEH ASC";
	$rows=mysql_query($query);
	$cont= "<table id='newspaper-a1' width='175px' style='padding:0px;margin:0px;' name='checador'>
			<tr>
				<th colspan='2'><input type='checkbox' id='todos' name='todos' onClick='check_All(this);' /> Seleccionar Todos</th>
			</tr>
			<tr>
				<th colspan='2' style='font-size:14px;width:150px;'>Vehiculo</th>
			</tr>";
			$i=0;
	while($row=mysql_fetch_array($rows)){
		$ver=mysql_query("SELECT * FROM config_vel where id_usuario=$idu AND num_veh=".$row[1]);
		if(mysql_num_rows($ver)==1){
			$configurado="<img src='img/ico_delete.png' width='15px' style='float:right;' title='Borrar Configuracion' onclick='xajax_borrar(".$row[1].")' alt='Borrar configuraci&oacute;n'>";
		}else{
			$configurado="";
		}
		$cont.="<tr>
					<td colspan='2'><input onclick='mostrar($i,".$row[1].");' type='checkbox' id='$i' name='vehiculo[]' value='".$row[1]."'>".$row[0]."$configurado</td>
				</tr>";
		$i++;
	}
	$cont.= "</table>";	
	$objResponse->assign("vehiculos_config","innerHTML",$cont);
	return $objResponse;
}
function mostrar_config($veh_T){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$firephp= FirePhp::getInstance(true);
	$idemp = $sess->get("Ide");
	$idu=$sess->get("Idu");
	$total=count($veh_T);
	if($total>=1){
		if($total==1){
			$veh=$veh_T[0];
		}else{
			$veh=$veh_T[$total-1];
		}
		$hidden=$veh_T;
		$query1="SELECT * FROM config_vel WHERE num_veh=$veh";
		$rows=mysql_query($query1);
		if(mysql_num_rows($rows)==0 && $total>=1){
			$cont="Esta es la configuracion 'Default' para los veh&iacute;culos.<br>
						<input type='hidden' name='vehiculo[]' value='$veh'>
						<input type='hidden' name='usuario' value='$idu'>
					<table id='newspaper-a1'>
						<tr>
							<th></th>
							<th colspan='2'>Velocidad Tope</th>
							<!--<th>Avisar por correo</th>-->
						</tr>
						<tr>
							<td><img src='img2/azul.png' width='30px'></td>
							<td colspan='2'> Veh&iacute;culo detenido</td>
							<!--<td align='center'><input type='radio' name='avisar' title='Enviara un correo \nal revasar la velocidad de \n 45 km/h' value='".$veh."|vel1"."'></td>-->
						</tr>
						<tr>
							<td><img src='img2/verde.png' width='30px'>Minima</td>
							<td><input type='text' value='9' maxlength='3' size='3'  readonly='readonly'> km/h - </td>
							<td><input type='text' maxlength='3' id='minima' onkeypress='return event.charCode >= 48 && event.charCode <= 57' size='3' value='45' name='vel1'></td>
							<!--<td align='center'><input type='radio' name='avisar' title='Enviara un correo \nal revasar la velocidad de \n 45 km/h' value='".$veh."|vel1"."'></td>-->
						</tr>
						<tr>
							<td><img src='img2/amarillo.png' width='30px'>Normal</td>
							<td><input type='text' value='46' maxlength='3' size='3' id='normalR' readonly='readonly'> km/h -</td>
							<td><input type='text' maxlength='3' id='normalE' onkeypress='return event.charCode >= 48 && event.charCode <= 57' size='3' value='70' name='vel2'></td>
							<!--<td align='center'><input type='radio' name='avisar' title='Enviara un correo \nal revasar la velocidad de \n 70 km/h'  value='".$veh."|vel2"."'></td>-->
						</tr>
						<tr>
							<td><img src='img2/naranja.png' width='30px'>Regular</td>
							<td><input type='text' value='71' maxlength='3'size='3' id='regularR' readonly='readonly'> km/h - </td>
							<td><input type='text' maxlength='3' id='regularE' onkeypress='return event.charCode >= 48 && event.charCode <= 57' size='3' value='99' name='vel3'></td>
							<!--<td align='center'><input type='radio' name='avisar' title='Enviara un correo \nal revasar la velocidad de \n 99 km/h'  value='".$veh."|vel3"."'></td>-->
						</tr>
						<tr>
							<td><img src='img2/rojo.png' width='30px'>M&aacute;xima</td>
							<td>Mayor a </td>
							<td><input type='text' id='maximaE' maxlength='3' onkeypress='return event.charCode >= 48 && event.charCode <= 57' size='3' value='100' name='vel4'></td>
							<!--<td align='center'><input type='radio' name='avisar' title='Enviara un correo \nal revasar la velocidad de \n 100 km/h'  value='".$veh."|vel4"."'></td>-->
						</tr>";
		}else{
			$rowV=mysql_fetch_array($rows);
			$cont="Su veh&iacute;culo tiene la siguiente configuraci&oacute;n de velocidad asignada.<br>
					<table id='newspaper-a1'>
						<input type='hidden' name='vehiculo[]' value='$veh'>
						<input type='hidden' name='usuario' value='$idu'>
						<tr>
							<th></th>
							<th colspan='2'>Velocidad Tope</th>
							<!--<th>Avisar por correo</th>-->
						</tr>
						<tr>
							<td><img src='img2/azul.png' width='30px'></td>
							<td colspan='2'> Veh&iacute;culo detenido</td>
							<!--<td align='center'><input type='radio' name='avisar' title='Enviara un correo \nal revasar la velocidad de \n 45 km/h' value='".$veh."|vel1"."'></td>-->
						</tr>
						<tr>
							<td><img src='img2/verde.png' width='30px'>Minima</td>
							<td><input type='text' value='9' maxlength='3' size='3'  readonly='readonly'> km/h - </td>
							<td><input type='text' maxlength='3' id='minima' onkeypress='return event.charCode >= 48 && event.charCode <= 57' size='3' value='".$rowV[2]."' name='vel1'></td>
						<!--	<td align='center'><input type='radio' name='avisar' title='Enviara un correo \nal revasar la velocidad de \n ".$rowV[2]." km/h' value='".$veh."|vel1"."'></td>-->
						</tr>
						<tr>
							<td><img src='img2/amarillo.png' width='30px'>Normal</td>
							<td><input type='text' value='".($rowV[2]+1)."' maxlength='3' size='3' id='normalR' readonly='readonly'> km/h - </td>
							<td><input type='text' maxlength='3' id='normalE' onkeypress='return event.charCode >= 48 && event.charCode <= 57' size='3' value='".$rowV[3]."' name='vel2'></td>
						<!--	<td align='center'><input type='radio' name='avisar' title='Enviara un correo \nal revasar la velocidad de \n ".$rowV[3]." km/h'  value='".$veh."|vel2"."'></td>-->
						</tr>
						<tr>
							<td><img src='img2/naranja.png' width='30px'>Regular</td>
							<td><input type='text' value='".($rowV[3]+1)."' maxlength='3'size='3' id='regularR' readonly='readonly'> km/h - </td>
							<td><input type='text' maxlength='3' id='regularE' onkeypress='return event.charCode >= 48 && event.charCode <= 57' size='3' value='".$rowV[4]."' name='vel3'></td>
						<!--	<td align='center'><input type='radio' name='avisar' title='Enviara un correo \nal revasar la velocidad de \n ".$rowV[4]." km/h'  value='".$veh."|vel3"."'></td>-->
						</tr>
						<tr>
							<td><img src='img2/rojo.png' width='30px'>M&aacute;xima</td>
							<td>Mayor a </td>
							<td><input type='text' id='maximaE' maxlength='3' onkeypress='return event.charCode >= 48 && event.charCode <= 57' size='3' value='".$rowV[5]."' name='vel4'></td>
						<!--	<td align='center'><input type='radio' name='avisar' title='Enviara un correo \nal revasar la velocidad de \n ".$rowV[5]." km/h'  value='".$veh."|vel4"."'></td>-->
						</tr>";
		}
		$cont.="<tr>
					<td colspan='3'><input type='submit' value='Guardar' class='guardar1'></td>
					<!--<td></td>-->
				</tr>
				</table>";
		$objResponse->assign("contenido","innerHTML",$cont);
	}
	else{
		$objResponse->assign("contenido","innerHTML",'');
	}
	if($veh_T==0){
		$objResponse->assign("contenido","innerHTML",'');
	}
	return $objResponse;
}

$xajax->processRequest();
$xajax->printJavascript();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Configuraci&oacute;n de velocidades</title>
	<link href="css/black.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="jQuery1.9/js/jquery-1.8.2.js"></script>
	<script language="JavaScript">
		var Z=[];
		function check_All(bx){
			var cbs = document.getElementsByTagName('input');
			for(var i=0; i < cbs.length; i++) {
				if(cbs[i].type == 'checkbox') {
					cbs[i].checked = bx.checked;
				}
			}
			var checados=document.getElementById('todos');
			if(checados.checked==true){
				var Z=document.getElementsByName('vehiculo[]');
				xajax_mostrar_config(Z);
			}else{
				xajax_mostrar_config(0);
			}
		}
		var contador=0;
		var veh=[];
		function mostrar(X,id){
			sel=document.getElementById(X)
			if(sel.checked==true){
				veh.push(id);
			}else{
				var index = veh.indexOf(id);
				veh.splice(index, 1);
			}
			xajax_mostrar_config(veh);
		}
		$(document).ready(function () {
			$('#minima').live("blur", function(){
		        var parentLI = $(this).closest("LI");
		        var cost = parseFloat($('#minima').val());
				if(cost<10){
					alert("La velocidad debe de ser mayor 10 Km/h.");
					$('#minima').val(10);
					cost=10;
					$('#minima').focus();
					$('#normalR').val(cost+1);
					$('#normalE').val(cost+20);
					$('#regularR').val(cost+21);
					$('#regularE').val(cost+40);
					$('#maximaE').val(cost+41);
				}
				else{
					$('#normalR').val(cost+1);
					$('#normalE').val(cost+20);
					$('#regularR').val(cost+21);
					$('#regularE').val(cost+40);
					$('#maximaE').val(cost+41);
				}
		    });
			$('#normalE').live("blur", function(){
		        var parentLI = $(this).closest("LI");
		        var cost = parseFloat($('#normalE').val());
				if(cost<= (parseFloat($('#minima').val())+1)){
					alert("La velocidad no puede ser menor a la anterior");
					$('#normalE').val(parseFloat($('#minima').val())+20);
					$('#normalE').focus();
				}
				else{
					$('#regularR').val(cost+1);
					$('#regularE').val(cost+20);
					$('#maximaE').val(cost+21);
				}
		    });
			$('#regularE').live("blur", function(){
		        var parentLI = $(this).closest("LI");
		        var cost = parseFloat($('#regularE').val());
				if(cost<= (parseFloat($('#normalE').val())+1)){
					alert("La velocidad no puede ser menor a la anterior");
					$('#regularE').val(parseFloat($('#normalE').val())+20);
					$('#regularE').focus();
				}
				else{
					$('#maximaE').val(cost+1);
				}
		    });
			$('#maximaE').live("blur", function(){
		        var parentLI = $(this).closest("LI");
		        var cost = parseFloat($('#maximaE').val());
				if(cost<= (parseFloat($('#regularE').val()))){
					alert("La velocidad no puede ser menor a la anterior");
					$('#maximaE').val(parseFloat($('#regularE').val())+1);
					$('#maximaE').focus();
				}
				else{
					$('#maximaE').val(cost+1);
				}
		    });
		});
	</script>
</head>
<body id="fondo1" onload="xajax_velocidades();" style="width:700px;overflow:hidden;height:440px;" >
	<div id="fondo1" style="width:700px;height:440px;">
		<div id="fondo2" style="width:700px;height:440px;">
			<div id="fondo3" style="width:700px;height:440px;">
				<center>
					<div id="cuerpo2" width="700px" height="156">
						<div id="cuerpoSuphead" style="width:200px;">
							<div id="logo"><img src='img2/logo1.png'></div>
						</div>
					<form id="form1"  name="form1" action="g_config.php" method="post">
						<div id="cuerpo_head"style='top:80px;width:700px;height:300px;'>
							<div id='vehiculos_config'></div>
							<div id='contenido'><? if(isset($_GET['bien'])){ echo "Se guardaron sus configuraciones correctamente";}?></div>
						</div>
					</form>
					</div>
				</center>
			</div>
		</div>
	</div>
</body>