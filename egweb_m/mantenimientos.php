<?
  //include('conn.php');
  //include('ObtenUrl.php');
  include('../adodb/adodb.inc.php');
  //require_once('../FirePHPCore/FirePHP.class.php'); // Clase FirePhp para hace debug con Firebug 
  include_once('../patError/patErrorManager.php');
  patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
  patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
  patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );
  include_once('../patSession/patSession.php');
  $sess =& patSession::singleton('egw', 'Native', $options );
  //$web = $sess->get("web");
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
//se registran variables
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
	$xajax->register(XAJAX_FUNCTION,"ver_datos");
	$xajax->register(XAJAX_FUNCTION,"config_folio");
	$xajax->register(XAJAX_FUNCTION,"nuevo_mtto");
	$xajax->register(XAJAX_FUNCTION,"add_mtto");
	$xajax->register(XAJAX_FUNCTION,"borrar_reg");
	$xajax->register(XAJAX_FUNCTION,"borrar_mmto");
	$xajax->register(XAJAX_FUNCTION,"mostrar_correos");
	$xajax->register(XAJAX_FUNCTION,"agrega_correo");
	$xajax->register(XAJAX_FUNCTION,"update_correos");
	//dialogs
	$xajax->register(XAJAX_FUNCTION,"preventivas");
	$xajax->register(XAJAX_FUNCTION,"correctivas");

function auditabilidad($accion,$veh){
	//require_once("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$options="";
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
	//mysql_close($conec);
	return $objResponse;
}
function preventivas(){
	$objResponse = new xajaxResponse();
	$ver=mysql_query("select * from tipo_mantto where descripcion like '%Revi%' order by descripcion");
	$dat="";
	while($row=mysql_fetch_array($ver)){
		$dat.="
		<tr>
			<td><input type='checkbox' id='id_Prev' class='prev' onclick='jQuery(\"#p_preventivas\").dialog(\"open\");' name='prev$row[0]' value='$row[0]'>".utf8_decode($row[1])."</td>
		</tr>";
	}
	$tabla="
	<table id='newspaper-a1'>
		<tr>
			<th>Mantenimientos preventivos <input type='checkbox' id='all_prev' onclick='todos_prev()' style='float:right;'></th>
		</tr>
		$dat
	</table>";
	
	$objResponse->assign("preventivas","innerHTML",$tabla);
	return $objResponse;
}
function correctivas(){
	$objResponse = new xajaxResponse();
	$ver=mysql_query("select * from tipo_mantto where descripcion not like '%Revi%' order by descripcion");
	$dat="";
	while($row=mysql_fetch_array($ver)){
		$dat.="
		<tr>
			<td><input type='checkbox' id='id_Corr' class='corr' onclick='jQuery(\"#p_correctivas\").dialog(\"open\")' name='corr$row[0]' value='$row[0]'>".utf8_decode($row[1])."</td>
		</tr>";
	}
	$tabla="
	<table id='newspaper-a1'>
		<tr>
			<th>Mantenimientos correctivos <input type='checkbox' id='all_corr' onclick='todos_corr()' style='float:right;'></th>
		</tr>
		$dat
	</table>";
	$objResponse->assign("correctivas","innerHTML",$tabla);
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

function borrar_mmto($folio){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	mysql_query("UPDATE manttoveh_det set activo=0 where folio=$folio");//detalle
	mysql_query("UPDATE manttoveh set activo=0 where folio=$folio");//maestro
	$desactivar=mysql_query("select num_veh from manttoveh_det where folio=$folio limit 1");
	$vehs=mysql_fetch_array($desactivar);
	$veh=$vehs[0];
	//insertamos en auditabilidad
	auditabilidad(131,$veh);
	$objResponse-> redirect("mantenimientos.php");
	return $objResponse;
}
function borrar_reg($folio,$reg){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', '');
	mysql_query("UPDATE manttoveh_det set activo=0 where folio=$folio and reg=$reg");
	//insertamos en auditabilidad
	auditabilidad(132,$veh);
	auditabilidad(133,$veh);
	$objResponse->script("xajax_config_folio($folio)");
	return $objResponse;
}


function nuevo_mtto($T_veh,$descrip,$correos,$T_prev,$param_prev,$T_corr,$param_corr,$rep){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native','');
	$ide=$sess->get("Ide");
	/*
		insert en maestro
	*/
	$no_repetir=1440;//1 dia
	mysql_query("INSERT INTO manttoveh VALUES(0,'$correos',$no_repetir,'$descrip',1,$ide)");
	$folio=mysql_insert_id();
	$tipo_p='';
	$tipo_c='';
	if($param_prev!='0'){
		//descomponemos los parametros preventivos
		$p_prev=explode("@",$param_prev);
		switch(count($p_prev)){
			case 2://por km
				$tipo_p="k";
				$kms_p=$p_prev[1];
				$f_ini_p=0;
				$f_fin_p=0;
			break;
			case 3://por tiempo
				$tipo_p="t";
				$lapso=$p_prev[1];
				$tiempo=$p_prev[2];
				$f_ini_p=date("Y-m-d H:i:s");
				$f_fin_p=date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." + $tiempo $lapso "));
				$km_ini_p=0;
				$km_fin_p=0;
			break;
			case 5://ambos
				$tipo_p="A";
				$lapso=$p_prev[1];
				$tiempo=$p_prev[2];
				$f_ini_p=date("Y-m-d H:i:s");
				$f_fin_p=date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." + $tiempo $lapso "));
				$kms_p=$p_prev[4];
			break;
		}
	}
	if($param_corr!='0'){
		//descomponemos los parametros correctivos
		$p_corr=explode("@",$param_corr);
		//$objResponse->alert(count($p_corr)." corr");
		switch(count($p_corr)){
			case 2://por km
				$tipo_c="k";
				$kms_c=$p_corr[1];
				$f_ini_c="0000-00-00 00:00:00";
				$f_fin_c="0000-00-00 00:00:00";
			break;
			case 3://por tiempo
				$tipo_c="t";
				$lapso_c=$p_corr[1];
				$tiempo_c=$p_corr[2];
				$f_ini_c=date("Y-m-d H:i:s");
				$f_fin_c=date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." + $tiempo_c $lapso_c "));
				$km_ini_c=0;
				$km_fin_c=0;
			break;
			case 5://ambos
				$tipo_c="A";
				$lapso_c=$p_corr[1];
				$tiempo_c=$p_corr[2];
				$f_ini_c=date("Y-m-d H:i:s");
				$f_fin_c=date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." + $tiempo_c $lapso_c "));
				$kms_c=$p_corr[4];
			break;
		}
	}
	for($i=0;$i<count($T_veh);$i++){//vehiculos
		$ver_o=mysql_query("select odometro from ultimapos where num_veh=".$T_veh[$i]);//odometros de los equipos
		$odo=mysql_fetch_array($ver_o);
		if(count($T_prev)>0){//si hay preventivos
			for($j=0;$j<count($T_prev);$j++){//mantenimientos prev
				if($tipo_p=='k' || $tipo_p=='A'){
					$km_ini_p=floor($odo[0]);
					$km_fin_p=$km_ini_p+$kms_p;
				}
				mysql_query("INSERT INTO manttoveh_det VALUES($folio,0,$T_veh[$i],'$tipo_p',$T_prev[$j],'$f_ini_p',
				'$f_fin_p',$km_ini_p,$km_fin_p,0,1,$rep,0)");
				//$objResponse->alert(mysql_error());
				auditabilidad(127,$veh);
			}
		}
		
		if(count($T_corr)>0){//si hay correctivos
			for($k=0;$k<count($T_corr);$k++){//mantenimientos corr
				if($tipo_c=='k' || $tipo_c=='A'){
					$km_ini_c=floor($odo[0]);
					$km_fin_c=$km_ini_c+$kms_c;
				}
				mysql_query("INSERT INTO manttoveh_det VALUES($folio,0,$T_veh[$i],'$tipo_c',$T_corr[$k],'$f_ini_c',
				'$f_fin_c',$km_ini_c,$km_fin_c,0,1,$rep,0)");
				auditabilidad(128,$veh);
			}
		}
	}
	$objResponse-> redirect("mantenimientos.php");
	return $objResponse;
}

function add_mtto($folio,$T_veh){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	//obtengo el primer vehiculo de los ya capturado
	$query=mysql_query("select num_veh from manttoveh_det where folio=$folio limit 1");
	$vehs=mysql_fetch_array($query);
	$veh=$vehs[0];
	//procesamos los datos de la regla para mostrarlos en pantalla
	for($i=0;$i<count($T_veh);$i++){
		$q_odos=mysql_query("select odometro from ultimapos where num_veh=".$T_veh[$i]);
		$odos=mysql_fetch_array($q_odos);
		$odo=floor($odos[0]);
		$query_b=mysql_query("select * from manttoveh_det  where folio=$folio and num_veh=$veh");
		while($row=mysql_fetch_array($query_b)){
			$ver=mysql_query("SELECT * from manttoveh_det where folio=$folio and num_veh=".$T_veh[$i]." and id_tmantto=".$row[4]);
			if(mysql_num_rows($ver)>0){
				$dif_odo=$row[8]-$row[7];
				$f_odo=$odo+$dif_odo;
				$dif_fechas=interval_date($row[5],$row[6]);
				if(preg_match('/meses/i', $dif_fechas )){
					$dif_fechas=str_replace("meses", "months", $dif_fechas);
				}
				else{
					$dif_fechas=str_replace("años", "years", $dif_fechas);
				}
				$f_fin=date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." + $dif_fechas"));
				mysql_query("UPDATE manttoveh_det set 
				activo=1,
				iterahechas=0,
				kmini=$odo,
				kmfin=$f_odo,
				fechaini='".date("Y-m-d H:i:s")."',
				fechafin='".$f_fin."'
				where folio=$folio 
				and num_veh=".$T_veh[$i]);
			}
			else{
				$dif_odo=$row[8]-$row[7];
				$f_odo=$odo+$dif_odo;
				$dif_fechas=interval_date($row[5],$row[6]);
				if(preg_match('/meses/i', $dif_fechas)){
					$dif_fechas=str_replace("meses", "months", $dif_fechas);
				}
				else{
					$dif_fechas=str_replace("años", "years", $dif_fechas);
				}
				$f_fin=date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." + $dif_fechas"));
				mysql_query("INSERT INTO manttoveh_det VALUES($folio,0,".$T_veh[$i].",'".$row[3]."',".$row[4].",
				'".date("Y-m-d H:i:s")."','".$f_fin."',".$odo.",".$f_odo.",0,1,".$row[11].",0)");
			}
		}
		auditabilidad(129,$veh);
		auditabilidad(130,$veh);
	}
	
	//insertamos en auditabilidad
	
	$objResponse-> redirect("mantenimientos.php");
	return $objResponse;
}
function vehiculos(){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$idu=$sess->get("Idu");
	$query="select distinct(v.id_veh),v.num_veh,v.id_sistema
			from veh_usr as vu
			inner join vehiculos v on vu.num_veh = v.num_veh
			inner join estveh ev on (v.estatus = ev.estatus)
			inner join sistemas S ON v.id_sistema=S.id_sistema
			where vu.id_usuario = $idu 
			AND ev.publicapos=1
			AND vu.activo=1
			and S.tipo_equipo not in
			('A1','SPIDER','CTRACKER','GALAXY','PDT','PORTMAN','SUNTECH','X8','P1')
			order by v.id_veh asc";
	$rows=mysql_query($query);
	$cont= "<table id='newspaper-a1' width='175px' style='padding:0px;margin:0px;' name='checador'>
			<tr>
				<th colspan='1' style='font-size:14px;width:150px;'>Vehiculo</th>
				<th><input type='checkbox' id='all_veh' onclick='check_All_veh()'></th>
			</tr>";
			$i=0;
	$int="";
	while($row=mysql_fetch_array($rows)){
		if(mysql_num_rows($rows)==1){
			$int=1;
		}
		$cont.="<tr>
					<td colspan='2'>
						<input type='checkbox' class='Classveh' onclick='contar$int()' 
						id='idVeh' name='Veh".$i."' value='".$row[1]."'>"
					.$row[0]."
					</td>
				</tr>
		";
		$i++;
	}
	$cont.= "</table>";	
	$objResponse->assign("vehiculos_config_gen","innerHTML",$cont);
return $objResponse;
}

function ver_datos($id_geo,$veh,$tipo){	
	unset($todos_vehiculos);
	$todos_vehiculos=$veh;
	$objResponse = new xajaxResponse();
	$options="";
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
	//$objResponse->alert($veh);
	
	$cond="";
	$query=mysql_query("SELECT m.folio,m.descripcion
	FROM manttoveh m 
	where m.activo=1
	order by m.descripcion");
	//$objResponse->alert(mysql_error());
	if(mysql_num_rows($query)>0){
		$cond.="
			<div id='geo_datos' style='height:185px;'>
				<table id='newspaper-a1' style='width:180px;'>
					<tr>
						<th colspan='3'>Mis Mantenimientos</th>
					</tr>
		";
		while($row=mysql_fetch_array($query)){
			if($folioX==$row[0]){
				$checked='checked';
			}
			else{
				$checked='';
			}
			$cond.="
				<tr>
					<td width='1px' style='padding-right:0px;'>
						<input type='radio' name='config' onclick='xajax_config_folio(".$row[0].")' ".$checked.">
					</td>
					<td style='padding-right:0px;'>".$row[1]."</td>
					<td style='padding:0px;'><img src='img/ico_delete.png' width='15px' 
						title='Borrar configuracion' onclick='xajax_borrar_mmto(".$row[0].")'
						style='cursor:pointer;'>
					</td>
				</tr>
			";
		}
		$cond.="	
			</table>
		</div>";
	}
	else{
		$cond.="
			<div id='geo_datos'>
				<table id='newspaper-a1' style='width:200px;'>
					<tr>
						<th colspan='2'>Mis Mantenimientos</th>
					</tr>
					<tr>
						<td colspan='2'>Aun no tiene ning&uacute;n mantenimiento programado</td>
					</tr>
				</table>
			</div>
			";
	}
	$cond.="
		<div id='semana_hora_gen' style='left:210px;width:150px;height:185px;'>
			<table id='newspaper-a1'>
				<tr>
					<th>
						Mantenimientos
					</th>
				</tr>
				<tr>
					<td>
						<a href='#' onclick='jQuery(\"#preventivas\").dialog( \"open\" );jQuery(\"#p_preventivas\").dialog(\"open\")'>Preventivos</a>
					</td>
				</tr>
				<tr>
					<td>
						<a href='#' onclick='jQuery(\"#correctivas\").dialog( \"open\" );jQuery(\"#p_correctivas\").dialog(\"open\")'>Correctivos</a>
					</td>
				</tr>
				<tr>
					<td>
						Repetir mantenimiento:
					</td>
				</tr>
				<tr>
					<td>
						<select id='repeticiones' onchange='ver_veces()'>
							<option value='1'>Una sola vez</option>
							<option value='2'>Definir veces</option>
							<option value='3'>De por vida</option>
						</select>
					</td>
				</tr>
				<tr id='ver_veces' style='display:none;'>
					<td>
						<input type='number' id='num_rep' step='5' value='5' max='50' min='5' style='width:50px;'>
					</td>
				</tr>
			</table>
		</div>
	";
	for($i=0;$i<count($veh);$i++){
		if(in_array($veh[$i],$todos_vehiculos)){
		}
		else{
			$todos_vehiculos[]=$veh[$i];
		}
	}
	
	if(count($todos_vehiculos)>1){
		$plural="s";
	}
	else{
		$plural='';
	}
	$cond.="
	<div id='agr_veh' style='height:185px;'>
	<table id='newspaper-a1' width='160px'>
		<tr>
			<th>Veh&iacute;culo$plural</th>
		</tr>";
	$sess->set('todos_vehiculos',$todos_vehiculos);
	$T_V=$sess->get('todos_vehiculos');
	$T_G=$sess->get('V_guardados');
	for($w=0;$w<count($T_V);$w++){
		$query2="SELECT V.id_veh FROM vehiculos AS V
			WHERE V.num_veh=".$T_V[$w];
		$rows=mysql_query($query2);
		$row=mysql_fetch_array($rows);
		$id_folio = join(',',$sess->get('folio'));
		
		$query_ver="SELECT GPS_DET.num_veh,GPS_DET.num_geo
			FROM gpscondicionalertadet AS GPS_DET
			WHERE GPS_DET.num_veh=".$T_V[$w]."
			AND GPS_DET.folio IN ($id_folio)";
		//$objResponse->alert($query_ver);	
		
		$qver=mysql_query($query_ver);
		$guardado='';
		if(mysql_num_rows($qver)>0){
			$xd=mysql_fetch_array($qver);
			$guardado="<img title='Regla Asignada' src='img2/delete.png' width='15px' style='float:right;cursor:pointer;' 
			onclick='borrar(".json_encode($folio).",".$T_V[$w].",".$xd[1].")'>";
		}
		$cond.="
			<tr>
				<td>".$row[0]." $guardado </td>
			</tr>
		";
	}
	//$objResponse->assign("contenido_geo","innerHTML",$query_chec);
	$cond.="</table>
	</div>	
	<div id='geo_descripcion' style='height:185px;overflow-x:hidden;width:250px;left:545px;'>
		<table id='newspaper-a1' width='220px'>
			<input type='hidden' id='server' name='gestion'>
			<input type='hidden' id='sem' name='periodo'>
			<tr>
				<td colspan='2'>
					Descripcion:<br><input type='text' id='descripcion' size='40'>
				</td>
			</tr>
			<tr>
				<td colspan='2' id='checar_correos'>
					<input type='radio' id='enviar_correos' onclick='xajax_mostrar_correos(0)' />Correos
				</td>
			</tr>
			<tr>
				<td colspan='2' align='left' id='mostrar_correos'></td>
			</tr>
		</table>
	</div>
	<div id='gen_boton' align='left'>
		<input type='button' value='Crear Nuevo Mantenimiento' class='guardar1' onclick='nuevo_mtto()' >
	</div>";
	$objResponse->script("setTimeout('calendario(\"inicio\")',100)");
	$objResponse->script("setTimeout('calendario(\"fin\")',500)");
	$objResponse->assign("contenido_gen_asignadas","innerHTML",$cond);
	//$objResponse->assign("geo_boton","innerHTML",$query_chec);
return $objResponse;
}
function mostrar_correos($folio){
	
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$correos="
	<table id='newspaper-a1'>
		<tr>
			<th colspan='2'>Correos</th>
			<th>Nombre</th>
		</tr>";
	$query=mysql_query("SELECT * FROM correos_empresa where id_empresa=".$sess->get("Ide")." and activo=1 order by nombre");
	while($row=mysql_fetch_array($query)){
		if($folio!=0){
		$comp=mysql_query("SELECT enviaremail,folio from gpscondicionalerta where id_empresa=".$sess->get("Ide")." and activo=1 AND folio=$folio");
		$actuales=mysql_fetch_array($comp);
		if(strstr($actuales[0],$row[3])){
			$checked='checked';
		}
		else{
			$checked='';
		}
		$correos.="
			<tr>
				<td><input type='checkbox' name='id_correo' id='id_correo' onclick='agrega_correo(".$row[1].");
				update_correos(".$actuales[1].",".$row[1].");' 
				value='".$row[1]."' $checked></td>
				<td>".$row[3]."</td>
				<td>".$row[2]."</td>
			</tr>
		";
		}
		else{
			$correos.="
			<tr>
				<td><input type='checkbox' name='id_correo' id='id_correo' onclick='agrega_correo(".$row[1].")' value='".$row[1]."'></td>
				<td>".$row[3]."</td>
				<td>".$row[2]."</td>
			</tr>
		";
		}
	}
	$correos.="</table>";
	$objResponse->assign("mostrar_correos_dialog","innerHTML",$correos);
	$objResponse->script("mostrar_dialog()");
	return $objResponse;
}
function update_correos($folio,$T_correo){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$correos='';
	for($i=0;$i<count($T_correo);$i++){
		$query=mysql_query("SELECT correo from correos_empresa where id_correo=".$T_correo[$i]." AND id_empresa=".$sess->get("Ide"));
		$add=mysql_fetch_array($query);
		if($correos!=''){
			$correos.=";";
		}
		$correos.=$add[0];
	}
	mysql_query("UPDATE gpscondicionalerta SET enviaremail='$correos' where folio=$folio");
	//$objResponse->alert("UPDATE gpscondicionalerta SET enviaremail='$correos' where folio=$folio");
	return $objResponse;
}
function agrega_correo($T_correo){
	$objResponse = new xajaxResponse();
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
			$mostrar.="<br />";
		}
		$correos.=$add[0];
		$mostrar.=$add[0];
	}
	$mostrar.="<input type='hidden' id='correos' value='$correos'>";
	$objResponse->assign("mostrar_correos","innerHTML",$mostrar);
	return $objResponse;
}

function interval_date($init,$finish)
{
    //formateamos las fechas a segundos tipo 1374998435
    $diferencia = strtotime($finish) - strtotime($init);
 
    if($diferencia > 2592000 && $diferencia < 31104000){
        $tiempo =  floor($diferencia/2592000) . " meses";
    }else if($diferencia > 31104000){
    	if($diferencia % 31104000!=0){
	    	$tiempo =  floor($diferencia/2592000) . " meses";
    	}
    	else{
	    	$tiempo =  floor($diferencia/31104000) . " años";
    	}
    }else{
        $tiempo = "Error";
    }
    return $tiempo;
}
function config_folio($folio){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$reglas="
		<table id='newspaper-a1' width='745px;'>
			<tr>
				<th>Veh&iacute;culos</th>
				<th>Mantenimiento</th>
				<th>Tipo</th>
				<th>Periodo</th>
				<th>Kilometraje</th>
				<th>Repeticiones</th>
				<th></th>
			</tr>
		";
	
	$query=mysql_query("select * from manttoveh_det where folio=$folio and activo=1");
	if(mysql_num_rows($query)>0){
		$repeticiones="";
		while($row=mysql_fetch_array($query)){
			if($row[11]>=1){
				$repeticiones="$row[12]/$row[11]";
			}
			else{
				$repeticiones="SIEMPRE";
			}
			$tipos=mysql_query("SELECT descripcion from tipo_mantto where id_tmantto=".$row[4]);
			$tipo=mysql_fetch_array($tipos);
			$vehiculos=mysql_query("Select id_veh from vehiculos where num_veh=".$row[2]);
			$vehiculo=mysql_fetch_array($vehiculos);
			$tipo_m="Correctivo";
			if(preg_match('/rev/i', $tipo[0])){
				$tipo_m="Preventivo";
			}
			$tiempo="N/A";
			if($row[5]!='0000-00-00 00:00:00'){
				$tiempo=interval_date($row[5],$row[6]);
			}
			$kms="N/A";
			if($row[8]!=0){
				$kms=$row[8]-$row[7];
			}
			$reglas.="
			<tr>
				<td>$vehiculo[0]</td>
				<td>".utf8_decode($tipo[0])."</td>
				<td>$tipo_m</td>
				<td>$tiempo</td>
				<td>$kms</td>
				<td>$repeticiones</td>
				<td>
					<img src='img2/delete.png' width='15px' style='float:right;cursor:pointer;' 
					onclick='xajax_borrar_reg($folio,$row[1])'>
				</td>
			</tr>
			";
			$veh=$row[2];
		}
	}
	else{
		$reglas.="
		<tr>
			<td colspan='7' align='center'> No hay veh&iacute;culos activos en este mantenimiento</td>
		</tr>";
	}
	$prev=array();
	$corr=array();
	//procesamos los datos de la regla para mostrarlos en pantalla
	$query_b=mysql_query("select m.id_tmantto,t.descripcion,m.fechaini,m.fechafin,m.kmini,m.kmfin,
	d.enviaremail,m.iteraciones,d.descripcion
	from manttoveh_det m
	inner join tipo_mantto t on t.id_tmantto=m.id_tmantto
	inner join manttoveh d on d.folio=m.folio
	where m.folio=$folio
	and m.num_veh=$veh");
	//$objResponse->alert($veh." -".$folio);
	while($row_b=mysql_fetch_array($query_b)){
		//llenar los array
		if(preg_match('/rev/i',$row_b[1])){
			if(!in_array($row_b[0], $prev)){
				array_push($prev,$row_b[0]);
			}
			$ini_p=$row_b[2];
			$fin_p=$row_b[3];
			$k_ini_p=$row_b[4];
			$k_fin_p=$row_b[5];
		}
		else{
			if(!in_array($row_b[0], $corr)){
				array_push($corr,$row_b[0]);
			}
			$ini_c=$row_b[2];
			$fin_c=$row_b[3];
			$k_ini_c=$row_b[4];
			$k_fin_c=$row_b[5];
		}
		$emails=$row_b[6];
		$itera=$row_b[7];
		$desc=$row_b[8];
	}
	$km_p=$k_fin_p-$k_ini_p;
	$km_c=$k_fin_c-$k_ini_c;
	$tiempo_c=str_replace(" ","@",interval_date($ini_c,$fin_c));
	$tiempo_p=str_replace(" ","@",interval_date($ini_p,$fin_p));
	$correo=str_replace(";",'\n',$emails);
	$objResponse->script("mostrar_actuales_config('".$km_p."','".$km_c."','".$correo."','".$tiempo_c."','".$tiempo_p."','".
	implode("@",$prev)."','".implode("@",$corr)."','".$folio."','".$itera."','".$desc."')"); 
	
	$objResponse->assign("reglas","innerHTML",$reglas);
	return $objResponse;
}

$xajax->processRequest();//procesa los datos de "xajax"
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Mantenimientos programados</title>
	<!--<link href="librerias/dsn.css" rel="stylesheet" type="text/css" />-->
	<link href="css/black.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<link href="principal/css/ui-darkness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="principal/js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" language="javascript" src="librerias/SistemasConfigurables/func_Equipos.js"></script>
	<script src="js/reg_mtto.js"></script>
	<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
	<style type="text/css">
	 #ui-datepicker-div{ font-size: 70%; }
	  /* css for timepicker */
	 .ui-timepicker-div .ui-widget-header{ margin-bottom: 8px; }
	 .ui-timepicker-div dl{ text-align: left; }
	 .ui-timepicker-div dl dt{ height: 25px; }
	 .ui-timepicker-div dl dd{ margin: -25px 10px 10px 65px; }
	 .ui-timepicker-div td { font-size: 70%; } 
	</style>	
	<script type="text/javascript" >
	function calendario(id){
		jQuery("#"+id).timepicker({
			closeText: 'Cerrar',
			currentText: 'Hoy',
			timeFormat: 'hh:mm',
		});
	}
	function check_All_veh() {
		var j = jQuery.noConflict();
		if(j("#all_veh").is(':checked')){
			j(".Classveh").prop('checked', true);
			contar();
		}
		else{
			j(".Classveh").removeAttr('checked');
			contar();
		}
	}
	function todos_prev(){
		var j = jQuery.noConflict();
		if($("#all_prev").is(':checked')){
			j(".prev").prop('checked', true);
		}
		else{
			j(".prev").prop('checked', false);
		}
	}
	function todos_corr(){
		var j = jQuery.noConflict();
		if(j("#all_corr").is(':checked')){
			j(".corr").prop('checked', true);
		}
		else{
			j(".corrr").prop('checked', false);
		}
	}
	</script>
</head>
<body id="fondo1" onload="xajax_vehiculos();xajax_ver_datos(0,0,0);xajax_preventivas();xajax_correctivas()" style="overflow:hidden;width:1100px;background:url(img2/main-bkg-00.png) transparent repeat;" >
<!--<div id="logo"></div><!--Nos muestra el logo de la pagina "oficial"-->
<!-- Estos divs son para el fondo-->
<div id="fondo1" style="overflow:hidden;width:1050px;">
<div id="fondo2" style="overflow:hidden;width:1050px;">
<div id="fondo3" style="overflow:hidden;width:1050px;">
<center>
<div id="cuerpo2" width="225" height="156">
            <div id="cuerpoSuphead" style="width:1100px;">
			<div id="logo"><img src='img2/logo1.png'></div><!--Nos muestra el logo de la pagina "oficial"-->
    		</div>
<form id="form1"  name="form1" action="#" method="post">
 <div id="cuerpo_head" style='top:80px;width:1050px;height:500px;' >
	<div id='vehiculos_config_gen'></div>
	<div id='mostrar_correos_dialog' style='display:none;' align="center"></div>
	<div id='reglas' style='position:absolute;top:280px;left:220px;width:750px;overflow-y:auto;overflow-x:hidden;height:145px;'></div>
	<div id='contenido_gen_asignadas'></div>
	<div id='preventivas' style="display:none;" title="Mantenimientos Preventivos"></div>
	<div id='correctivas' style="display:none;" title="Mantenimientos Correctivos"></div>
	<div id='p_preventivas' style="display:none;" title="Parametros para Preventivos">
		<table id="newspaper-a1" style="width:280px;">
			<tr>
				<th>Par&aacute;metros</th>
			</tr>
			<tr>
				<td>
					<input type="checkbox" name="prev" id='r_t_p' checked="checked" onclick="opc_p()">Tiempo
					<input type="checkbox" name="prev" id='r_k_p' onclick="opc_p()">Kilometros
				</td>
			</tr>
			<tr id="tiempo">
				<td>Lapso en tiempo:
					<select id="lapso_prev">
						<option value="months" selected="selected">Meses</option>
						<option value="years">Años</option>
					</select>
					<input type="number" value="6" id="Lapso_prev" style="width:50px;" size="3" step="10">
				</td>
			</tr>
			<tr id="km" style="display:none;">
				<td>Lapso en kilometros:<input type="number" id="km_prev" style="width:80px;" max="100000" min="1000" step="100" value="100000">
				</td>
			</tr>
		</table>
	</div>
	<div id='p_correctivas' style="display:none;" title="Par&aacute;metros para Correctivos">
		<table id="newspaper-a1">
			<tr>
				<th>Par&aacute;metros</th>
			</tr>
			<tr>
				<td>
					<input type="checkbox" name="corr" id="r_t_c" checked="checked" onclick="opc_c()">Tiempo
					<input type="checkbox" name="corr" id="r_k_c" onclick="opc_c()">Kilometros
				</td>
			</tr>
			<tr id="tiempo_c">
				<td>Lapso en tiempo:
					<select id="lapso_corr">
						<option value="months" selected="selected">Meses</option>
						<option value="years">Años</option>
					</select>
					<input type="number" value="6" id="Lapso_corr" style="width:50px;" size="3" step="10">
				</td>
			</tr>
			<tr id="km_c" style="display:none;">
				<td>Lapso en kilometros:<input type="number" id="km_corr" style="width:80px;" max="100000" min="1000" step="100" value="100000">
				</td>
			</tr>
		</table>
	</div>
</div>
<div id='borrado_cmd' style='position:absolute;top:100px;left:220px;width:250px;height:50px;'></div>
</form>
</div>
</center>
</div>
</div>
</div>

</body>
</html>