<?
	include_once('../patSession/patSession.php');
	$sess =& patSession::singleton('egw', 'Native', $options );	
	$result = $sess->get( 'expire-test' );
	require("librerias/conexion.php");
	require("librerias/SistemasConfigurables/Configsis_nuevo_geo.php");
  	require('../xajaxs/xajax_core/xajax.inc.php');
	$xajax = new xajax(); 
	$xajax->configure('javascript URI', '../xajaxs/');
	$xajax->register(XAJAX_FUNCTION,"vehiculos");
	$xajax->register(XAJAX_FUNCTION,"vehiculos_check");
	$xajax->register(XAJAX_FUNCTION,"ver_geocercas");
	$xajax->register(XAJAX_FUNCTION,"guardar_asignacion");
	$xajax->register(XAJAX_FUNCTION,"borrar");

function ver_geocercas($id_geo,$veh){	
	unset($todos_vehiculos);
	$todos_vehiculos=$veh;
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$ide=$sess->get("Ide");
	$sess->set('f_ini',$ini);
	$sess->set('f_fin','');
	$sess->set('max','');
	$sess->set('min','');
	$sess->set('activo','');
	$sess->set('sem','');
	$sess->set('mes','');
	$sess->set('dentro','');
	$sess->set('fuera','');
	$sess->set('desc','');
	$sess->set('mail','');
	$sess->set('dias','');
	$sess->set('folio','');
	$sess->set('V_guardados','');
	//$objResponse->alert(count($id_geo));
	for($i=0;$i<count($id_geo);$i++){
		$cad_geo = "select g.latitud,g.longitud,g.radioMts,g.tipo,p.latitud,p.longitud,p.orden,g.nombre";
		$cad_geo .= " from geo_time g	left outer join geo_puntos p on (g.num_geo = p.id_geo)";
		$cad_geo .= " where num_geo =". $id_geo;

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
			}
			$objResponse->call("mostrar_poligonal",$arregloLatitud,$arregloLongitud,$nombre);
		}
	}
	if(!empty($veh)){
		if(count($veh)>1){
			$ids = join(',',$veh);
			$dif_tipos=mysql_query("SELECT s.tipo_equipo from vehiculos v inner join sistemas s on v.id_sistema=s.id_sistema where num_veh IN ($ids) group by s.tipo_equipo");
			$diferentes_sis=mysql_num_rows($dif_tipos);
			//$objResponse->alert($ids);
			//$busq="";
			$busq="AND (GPS_DET.num_veh IN (".$ids.") OR GPS_DET.num_veh NOT IN (".$ids."))";
			//$busq="AND (GPS_DET.num_veh NOT IN (".$ids."))";
		}
		else{
			$ids=$veh;
			$dif_tipos=mysql_query("SELECT s.tipo_equipo from vehiculos v inner join sistemas s on v.id_sistema=s.id_sistema where num_veh IN ($ids) group by s.tipo_equipo");
			$diferentes_sis=mysql_num_rows($dif_tipos);
			//$objResponse->alert($ids);
			//$busq="";
			$busq="AND (GPS_DET.num_veh IN (".$ids.") OR GPS_DET.num_veh NOT IN (".$ids."))";
		}
	}
	else{
		$busq="";
	}
	for($i=0;$i<count($id_geo);$i++){
		$query_chec="SELECT GPS_DET.num_veh,GPS_DET.enlosdias,GPS_DET.horaini,GPS_DET.horafin,GPS_DET.vel_max,GPS_DET.vel_min,GPS.activo,
			GPS_DET.entrageo,GPS_DET.salegeo,GPS.descripcion,GPS.enviaremail,GPS.folio
			FROM gpscondicionalertadet AS GPS_DET
			INNER JOIN gpscondicionalerta AS GPS ON GPS_DET.folio=GPS.folio
			WHERE GPS.id_empresa=$ide 
			AND GPS_DET.num_geo=".$id_geo."
			AND GPS_DET.num_veh=".$veh." 
			AND (GPS_DET.horaini <= NOW() OR GPS_DET.horaini = '0000-00-00 00:00:00' 
				AND GPS_DET.horafin >= NOW() OR GPS_DET.horafin = '0000-00-00 00:00:00' )
			$busq";
			//$objResponse->alert($query_chec);
		$rows=mysql_query($query_chec);
		if(mysql_num_rows($rows)>0){
			while($row=mysql_fetch_array($rows)){
				if(in_array($row[0],$todos_vehiculos)){	
				}
				else{
					$todos_vehiculos[]=$row[0];
					$V_guardados[]=$row[0];
					$sess->set('V_guardados',$V_guardados);
				}
				$D_M_S=$row[1];
				/* procesamos la informacion del campo "enlosdias"	*/
				if($D_M_S=='T'){
					$semana=1;
					$mes=1;
					$dias="1,2,3,4,5,6,7";
				}
				else{
					list($M_S,$dias)=explode(':',$row[1]);
					if($M_S=='S'){
						$semana=1;
						$mes=0;
					}
					else{
						$semana=0;
						$mes=1;
					}
				}
				$ini=$row[2];
				$fin=$row[3];
				$max=$row[4];
				$min=$row[5];
				$activo=$row[6];
				$dentro=$row[7];
				$fuera=$row[8];
				$desc=$row[9];
				$mail=$row[10];
				if($row[11]!=''){
					if(in_array($row[11],$folio)){
					}
					else{
						$folio[]=$row[11];
					}
				}
				$sess->set('f_ini',$ini);
				$sess->set('f_fin',$fin);
				$sess->set('max',$max);
				$sess->set('min',$min);
				$sess->set('activo',$activo);
				$sess->set('sem',$semana);
				$sess->set('mes',$mes);
				$sess->set('dentro',$dentro);
				$sess->set('fuera',$fuera);
				$sess->set('desc',$desc);
				$sess->set('mail',$mail);
				$sess->set('dias',$dias);
				$sess->set('folio',$folio);
				
			}
		}
	}
	$cond="
	<div id='semana'>
	<table id='newspaper-a1' style='width:100;'>
		<tr>
			<th>Dias</th>
		</tr>
		<tr>
			<td>
				<input type='checkbox' id='dias' name='dias1' value='1' checked>Lunes</td>
		</tr>
		<tr>
			<td><input type='checkbox' id='dias' name='dias2' value='2' checked>Martes</td>
		</tr>
		<tr>
			<td><input type='checkbox' id='dias' name='dias3' value='3' checked>Miercoles</td>
		</tr>
		<tr>
			<td><input type='checkbox' id='dias' name='dias4' value='4' checked>Jueves</td>
		</tr>
		<tr>	
			<td><input type='checkbox' id='dias' name='dias5' value='5' checked>Viernes</td>
		</tr>
		<tr>	
			<td><input type='checkbox' id='dias' name='dias6' value='6' checked>Sabado</td>
		</tr>
		<tr>
			<td><input type='checkbox' id='dias' name='dias7' value='7' checked>Domingo</td>
		</tr>
	</table></div>";
	$cond.="
		<div id='semana_hora'>
			<table id='newspaper-a1'>
				<tr>
					<td>
						Hora de Inicio:<br>
						<input type='text' id='inicio' style='position: relative; z-index: 10;' readonly='readonly' size='15'/>
					</td>
				</tr>
				<tr>
					<td>
						Hora de Fin:<br>
						<input type='text' id='fin' style='position: relative; z-index: 10;' readonly='readonly' size='15'/>
					</td>
				</tr>
				<tr>
					<td>
						Velocidad:
					</td>
				</tr>
				<tr>
					<td>
						Maxima:<input type='text' size='3' id='max' onkeypress='return event.charCode >= 48 && event.charCode <= 57;'/>
						Minima: <input type='text' size='3' id='min' onkeypress='return event.charCode >= 48 && event.charCode <= 57;'/>
					</td>
				</tr>
			</table>
		</div>
	";
	for($i=0;$i<count($veh);$i++){
		if(in_array($veh,$todos_vehiculos)){
		}
		else{
			$todos_vehiculos[]=$veh;
		}
	}
	//$objResponse->alert($query_chec);							//************************alert query
	if(count($todos_vehiculos)>1){
		$plural="s";
	}
	else{
		$plural='';
	}
	$cond.="<div id='agr_veh'>
	<table id='newspaper-a1' width='160px'>
		<tr>
			<th>Veh&iacute;culo$plural</th>
		</tr>";
	$sess->set('todos_vehiculos',$todos_vehiculos);
	$T_V=$sess->get('todos_vehiculos');
	$T_G=$sess->get('V_guardados');
	for($w=0;$w<count($T_V);$w++){
		$query2="SELECT V.id_veh FROM vehiculos AS V
			WHERE V.num_veh=".$T_V;
		$rows=mysql_query($query2);
		$row=mysql_fetch_array($rows);
		$id_folio = join(',',$sess->get('folio'));
		$query_ver="SELECT GPS_DET.num_veh,GPS_DET.num_geo
			FROM gpscondicionalertadet AS GPS_DET
			WHERE GPS_DET.num_veh=".$T_V."
			AND GPS_DET.folio IN ($id_folio)";
		//$objResponse->alert($query_ver);	
		$qver=mysql_query($query_ver);
		if(mysql_num_rows($qver)>0){
			$xd=mysql_fetch_array($qver);
			$guardado="<img title='Eliminar de la base de datos' src='img2/delete.png' width='15px' style='float:right;cursor:pointer;' 
			onclick='borrar(".json_encode($folio).",".$T_V.",".$xd[1].")'>";
		}
		else{
			$guardado='';
		}
		$cond.="
			<tr>
				<td>".$row[0]." $guardado </td>
			</tr>
		";
	}
	//$objResponse->assign("contenido_geo","innerHTML",$query_chec);
	$cond.="</table></div>";
	$cond.="<div id='geo_boton'>
				<input type='button' value='Guardar' class='guardar1' onclick='asignar_geo(".json_encode($sess->get('folio')).");' >
				<input type='button' value='Cancelar' class='cancelar1' onclick='window.close();' >
			</div>";
	
	$cond.="
	<div id='geo_descripcion'>
		<table id='newspaper-a1' width='295px'>
			<tr>
				<th colspan='2'>Condiciones</th>
			</tr>
			<tr>
				<td> 
					<input type='radio' name='activo' id='activo1' checked>Activado
				</td>
				<td> 
					<input type='radio' name='activo' id='activo2'>Desactivado
				</td>
			</tr>
			<!--<tr>
				<td><input type='checkbox' id='dentro'>Al entrar Geocerca</td>
				<td><input type='checkbox' id='fuera'>Al salir Geocerca</td>
			</tr>-->
			<tr>
				<td colspan='2'>D&iacute;as:</td>
			</tr>
			<tr>
				<td>
					Por Semana:<input type='checkbox' id='sem' checked>
				</td>
				<td>
					Por Mes:<input type='checkbox' id='mes' checked>
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					Descripcion:<input type='text' id='descripcion' size='40'>
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					Correos:
				</td>
			</tr>
			<tr>
				<td colspan='2' align='center'>
					<textarea cols='31' rows='3' id='correos'></textarea>
				</td>
			</tr>
		</table>
	</div>";
	//$objResponse->alert($exis);
	$objResponse->assign("contenido_geo_existe","innerHTML",$exis);
	
	//$objResponse->alert();
	if($diferentes_sis==1){
		$objResponse->script("setTimeout('calendario(\"inicio\")',1000)");
		$objResponse->script("setTimeout('calendario(\"fin\")',1500)");
		$objResponse->script("mostrar_actuales(".json_encode($sess->get("todos_vehiculos")).",'".$sess->get("dias")."','".
		$sess->get("f_ini")."','".$sess->get("f_fin")."','".$sess->get("max")."','".$sess->get("min")."',".
		$sess->get("activo").",".$sess->get("dentro").",".$sess->get("fuera").",".$sess->get("sem").",".
		$sess->get("mes").",'".$sess->get("desc")."','".$sess->get("mail")."',".json_encode($sess->get("folio")).")");
		$objResponse->assign("contenido_geo_asignadas2","innerHTML",$cond);
		//$objResponse->assign("geo_boton","innerHTML",$query_chec);
	}
	else{
		$objResponse->assign("contenido_geo_asignadas2","innerHTML","No puede configurar diferentes sistemas al mismo tiempo");
	}
return $objResponse;
}
$xajax->processRequest();//procesa los datos de "xajax"
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra

$folio=$_GET['folio'];
$reg=$_GET['reg'];

$datos=mysql_query("SELECT num_geo,num_veh FROM gpscondicionalertadet where folio=$folio and reg=$reg");
$dato=mysql_fetch_array($datos);
?>

<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Modificaci&oacute;n de Reglas</title>
	<!--<link href="librerias/dsn.css" rel="stylesheet" type="text/css" />-->
	<link href="css/black.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="css/ui-darkness/jquery-ui-1.10.3.custom.css" rel="Stylesheet" />
	<style type="text/css">
	 #ui-datepicker-div{ font-size: 70%; }
	  /* css for timepicker */
	 .ui-timepicker-div .ui-widget-header{ margin-bottom: 8px; }
	 .ui-timepicker-div dl{ text-align: left; }
	 .ui-timepicker-div dl dt{ height: 25px; }
	 .ui-timepicker-div dl dd{ margin: -25px 10px 10px 65px; }
	 .ui-timepicker-div td { font-size: 70%; } 
	</style>
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" language="javascript" src="librerias/SistemasConfigurables/func_Equipos.js"></script>
	<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&;amp;language=es"></script>-->	
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>-->
	<script type="text/javascript"src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBd2fGQYsJMv6ZucPSPtsou25lmdBjWs4w" ></script>		
	<script src="js/admin_reg.js"></script>
	<script type="text/javascript" >

function calendario(id){
	//alert("entra");
	jQuery("#"+id).datetimepicker({
		yearRange: '1900:2050',
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
		//changeMonth: true,
		//changeYear: true,
		timeFormat: 'hh:mm:ss',
		dateFormat: "yy-mm-dd"
	});
}

</script>
</head>
<body id="fondo1" onload="xajax_ver_geocercas(<? echo $dato[0];?>,<? echo $dato[1];?>);" style='overflow:hidden;height:620px;'>
<!--<div id="logo"></div><!--Nos muestra el logo de la pagina "oficial"-->
<!-- Estos divs son para el fondo-->
<div id="fondo1" >
<div id="fondo2">
<div id="fondo3">
<center>
<form id="form1"  name="form1" action="g_config.php" method="post">
	<div id='vehiculos_config_geo'></div>
	<div id='geocercas_config' style='top:0px;max-height:750px;'> 
		<table id='newspaper-a1' width='175px' style='padding:0px;margin:0px;'>
			<tr>
				<th>Geocercas.</th>
			</tr>
		<? 
			$query="SELECT g.num_geo,g.nombre,g.tipo,g.latitud,g.longitud,t.descripcion
					FROM geo_time g
					INNER JOIN tipo_geocerca t on g.tipo=t.tipo
					WHERE g.id_empresa = ".$sess->get("Ide")." 
					ORDER BY g.nombre";
			$rows=mysql_query($query);
			while($row=mysql_fetch_array($rows)){
			?>
				<tr>
					<td>
						<input type="checkbox" name="ejec" id="ejec" onclick="contar()" 
						<? 
							if($dato[0]==$row[0]){
								echo "checked=checked";
							}
						?>
						value="<? echo $row[0];?>" >
						<?
							if($row[2]==1){
								$cad_punto = "select latitud, longitud from geo_puntos where id_geo = ".$row[0];
								$punt = mysql_query($cad_punto);
								$rowPunt = mysql_fetch_array($punt);
							}
							else{
								$cad_punto = "select latitud, longitud from geo_time where num_geo = ".$row[0];
								$punt = mysql_query($cad_punto);
								$rowPunt = mysql_fetch_array($punt);
							}
						?>
						<span style='cursor:pointer;' title='click para ver la hubicacion de la geocerca <? echo $row[5];?>' onclick="window.opener.mostrar_geo(<? echo $row[0]; ?>,this);"><? echo $row[1];?></span>
					</td>
				</tr>
			<?
			}		
		?>
		</table>
	</div>
	<div id='contenido_geo_asignadas2'>
		<? 
		if(isset($_GET['guardado'])){
			echo "Se asignaron correctamente sus geocercas a sus vehiculos";
		}?>
	</div>
	<div id="contenido_geo_existe"></div>
	<div id="contenido_reg_existe"></div>
	
	<script type='text/javascript'>
	
	</script>
</form>
</center>
</div>
</div>
</div>
</body>
</html>