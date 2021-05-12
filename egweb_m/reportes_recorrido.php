<?php
include('otro_server.php');
include_once('../patError/patErrorManager.php');
include('ObtenUrl.php');
ini_set('memory_limit', '1024M');
patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
require_once('../FirePHPCore/FirePHP.class.php'); // Clase FirePhp para hace debug con Firebug 
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
	}else{ 
		header("Location: index.php?$web"); 
	}
};

if ($estses == ''){
	if($web == 1){	
		header("Location: indexApa.php?$web");	
	}else{
		header("Location: index.php?$web");	
	}
} 

$result = $sess->get( 'expire-test' );
if ((!patErrorManager::isError($result)) && ($_SESSION['Idu'])){
	$queryString = $sess->getQueryString();	
	$idu = $_SESSION["Idu"];
	$ide = $_SESSION["Ide"];
	$usn = $_SESSION["Usn"];
	$pol = $_SESSION["Pol"];
	$reg = $_SESSION['Registrado'];
	$nom = $_SESSION["nom"];
	$prm = $_SESSION['per'];
	$est = $_SESSION['sta'];
	$eve = $_SESSION['eve'];
	$dis = $_SESSION['dis'];
	$pan = $_SESSION['pan'];
	if (!$reg) {
	    $sess->set('Registrado',1);	
	}	
}else{
    $web = $sess->get("web"); 
	$sess->Destroy();
	if($web == 1 )
		header("Location: indexApa.php?$web");
	else header("Location: index.php?$web"); 
}          

require_once("librerias/conexion.php");
require('../xajaxs/xajax_core/xajax.inc.php');
$xajax = new xajax();
if(preg_match('/seprosat/',curPageURL())){
	$xajax->configure('javascript URI', 'http://www.sepromex.com.mx:81/'.'xajaxs/');
}else{
	$xajax->configure('javascript URI', '../xajaxs/');
}
//$xajax->configure('debug',true); 
$xajax->register(XAJAX_FUNCTION,"estilo");
$xajax->register(XAJAX_FUNCTION,"recorrido");
$xajax->register(XAJAX_FUNCTION,"alertas");
$xajax->register(XAJAX_FUNCTION,"rep_tiemposm");
$xajax->register(XAJAX_FUNCTION,"ver_geocercas");
$xajax->register(XAJAX_FUNCTION,"mandar_geocercas");
$xajax->register(XAJAX_FUNCTION,'matarSesion');
$xajax->register(XAJAX_FUNCTION,'recorrido_masivo');
$xajax->register(XAJAX_FUNCTION,'rep_gas');
$xajax->register(XAJAX_FUNCTION,'rep_temp');
$xajax->register(XAJAX_FUNCTION,'add_img');
$xajax->register(XAJAX_FUNCTION,'add_msj');
$xajax->register(XAJAX_FUNCTION,'auditabilidad');
$xajax->register(XAJAX_FUNCTION,'gas_motor');
$xajax->register(XAJAX_FUNCTION,'ultima_pos_exportar');
$xajax->register(XAJAX_FUNCTION,'graficas_dia');
$xajax->register(XAJAX_FUNCTION,'rep_barras');
	
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
function ultima_pos_exportar($idu,$ide){
	$objResponse = new xajaxResponse();
	$iframe="<iframe src='exporta_ultimapos.php?idu=$idu&ide=$ide'></iframe>";
	$objResponse->assign("exportar_upos","innerHTML",$iframe);
	return $objResponse;
}
function auditabilidad($accion){
	$objResponse = new xajaxResponse();
	$options="";$sess =& patSession::singleton('egw', 'Native', $options );
	$idu = $sess->get("Idu");
	$aplicacion=13;
	$empresa=$sess->get("Ide");
	$query=mysql_query("SELECT detalle from sepromex.catalogo_auditabilidad where id_app=$aplicacion and accion=".$accion);
	$detalles=mysql_fetch_array($query);
	$detalle=$detalles[0];
	$consulta = "insert into sepromex.auditabilidad values (0,$idu,'".date("Y-m-d H:i:s")."',$accion,'$detalle',
	$aplicacion,$empresa,'".get_real_ip()."')";
	mysql_query($consulta);
	return $objResponse;
}
function matarSesion(){
	//$chequeo=0;
	$objResponse = new xajaxResponse();
	patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
	patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
	patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );
	include_once('../patSession/patSession.php');
	$options="";$sess =& patSession::singleton('egw', 'Native', $options );
	$sess->Destroy();
	$objResponse-> redirect("index.php");
	return $objResponse;
}
/**************************************************************************************Gasolina************************************************************************************/	
function rep_gas($formu,$veh){
	$objResponse = new xajaxResponse();
	$fecha_ini = $formu['fecha_ini4'];
	$fecha_fin=$formu['fecha_fin4'];
	$paginacion = "";
	$_vehiculo = "";
	$latIni;
	$latFin;
	$lonIni;
	$lonFin;
	$reg=0;
	list($veh,$entrada)=explode("@",$veh);
	if ($veh == ''){
		$objResponse = new xajaxResponse();
		$objResponse->alert("Seleccione el vehiculo para crear el recorrido");
		$objResponse->assign("cont_reporte","innerHTML","");
	 	return $objResponse;		
	}
	else{	
		$options=""; 
		$sess =& patSession::singleton('egw', 'Native', $options );
		$consulta = "insert into auditabilidad values (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."'
		,21,'Obtener reporte de gasolina',13,".$sess->get('Ide').",'".get_real_ip()."')";
		mysql_query($consulta);
		$datos_rec ="";	
		$i = 0;
		if(empty($fecha_ini)==0 && empty($fecha_fin)==0 && date($fecha_ini) < date($fecha_fin))
		{
			$cad_veh = "SELECT id_sistema,id_empresa from vehiculos where num_veh = $veh";
			$res_cad = mysql_query($cad_veh);
			$rowsist = mysql_fetch_array($res_cad);
		 	$cad_msj = "SELECT id_empresa from c_mensajes where id_empresa = $rowsist[1]";
			$res_msj = mysql_query($cad_msj);
			if(mysql_num_rows($res_msj))
			{
				$id_emp = $rowsist[1];
			}
			else {
				$id_emp = 15;
			}
			$datos_vehiculo=mysql_query("SELECT v.id_veh,v.tipoveh,v.id_sistema from vehiculos v where num_veh=$veh");
			$dat_veh=mysql_fetch_array($datos_vehiculo);
			$id_veh=$dat_veh[0];
			$_vehiculo = $id_veh;
			$tipo_veh=$dat_veh[1];
			$id_sistema=$dat_veh[2];
			$ayer=strtotime($fecha_ini."-1 day");
			$query="SELECT max(id_pos) from posiciones where fecha>='".date("Y-m-d",$ayer)." 23:59:00' 
					and fecha<='$fecha_ini';";
			$ultimas=mysql_query($query);
			$ultima=mysql_fetch_array($ultimas);
			$hoy_u=mysql_query("SELECT max(id) from id_pos where fechahora<'$fecha_ini'");
			$p1=mysql_fetch_array($hoy_u);
			$hoy_u2=mysql_query("SELECT max(id_pos) from posiciones");
			$p2=mysql_fetch_array($hoy_u2);
			$max_pos='';
			if($p1[0]>0)
			{
				$max_pos=" p.id_pos>$p1[0] and p.id_pos<$p2[0] and";
			} 
			$analoga=0;
			$avanzado=0;
			if(preg_match("/A/i",$entrada)){
				$no_entrada=substr($entrada,0,1);
				$datos_rec="SELECT p.id_pos,p.fecha,p.velocidad,
				(p.lat/3600/16),((p.long & 8388607)/3600/12*-1),p.id_tipo,t.ent".$no_entrada."val,p.entradas
				from pos_entanaloga t
				inner join posiciones p on p.id_pos=t.id_pos
				where $max_pos p.num_veh = '$veh' 				
				/*and p.entradas not in (192,249,248,288,293)*/
				and p.fecha between '$fecha_ini' and '$fecha_fin' ";
				$analoga=1;
				$operacion=mysql_query("SELECT avanzado from veh_analogcnf where num_veh=$veh and activo=1");
				if(mysql_num_rows($operacion)>0){
					$datos=mysql_fetch_array($operacion);
					list($arriba,$abajo)=explode("/",$datos[0]);
					$avanzado=1;
				}
			}
			else{
				$datos_rec="SELECT p.id_pos,p.fecha,p.velocidad,
				(p.lat/3600/16),((p.long & 8388607)/3600/12*-1),p.id_tipo,g.nivelporcen
				from pos_gas g 
				inner join posiciones p on p.id_pos=g.id_pos				
				where $max_pos p.num_veh = '$veh'  
				/*and p.entradas not in(192,249,288,293)*/
				and p.fecha between '$fecha_ini' and '$fecha_fin' ";
			}
		 }
		 else
		 {
			$objResponse->alert("Favor de dar un rango de fechas");
			return $objResponse; 
		 }
		if($reg == 0){ //si es la primera vez que entra
			$objResponse->assign("form_pdf","innerHTML","<textarea name='con_pdf' >$datos_rec</textarea>
			<input type='hidden' name='idsiste' value='$rowsist[0]'/>
			<input type='hidden' name='num_veh' value='$veh'/>
			<input type='hidden' name='tipo' value='gas'>");
		 	$objResponse->assign("form_xls","innerHTML","<textarea name='con_xls' >$datos_rec</textarea>
			<input type='hidden' name='idsistema' value='$rowsist[0]'/>
			<input type='hidden' name='num_veh' value='$veh'/>
			<input type='hidden' name='tipo' value='gas'>");
			$resp = mysql_query($datos_rec);
			$num_reg = mysql_num_rows($resp);
		}
		else{ 
			$num_reg = $reg;
		}
		$cadreco=$datos_rec;
		//$firephp-> log($total_paginas,'Total Paginas:');
		if($num_reg != 0)
		{
			$resp = mysql_query($datos_rec); //para la paginacion
			$dsn_reco = "<div style='overflow-x:auto;overflow-y:auto;width:1127px;height:200px;position:absolute;left:15px;'>
			<table id='box-table-a1' width='1127px'>";	
			$fechas_g=array();
			$d_f=0;
		 	while($row = mysql_fetch_array($resp))
			{
				if($d_f!=date("Y-m-d",strtotime($row[1]))){
					//$objResponse->alert($d_f."-----".date("Y-m-d",strtotime($row[1])));
					array_push($fechas_g,date("Y-m-d",strtotime($row[1])));
					$d_f=date("Y-m-d",strtotime($row[1]));
				}
				if((int)$row[3]!= 0 || (int)$row[4] != 0)
				{
					if($i == 0 && $reg == 0 )
					{
						$latIni = $row[3]; 
						$lonIni = $row[4]; 
					}
					$latFin = $row[3];
					$lonFin = $row[4];
				
					$objResponse->call("crea_recorrido", $row[3],$row[4],$tipo_veh,0);
					if($i%2!=0)
						$color = "#C6D9F1";
					else
						$color = "#FFFFFF";
		
					if($row[2]==''){$row[2]= 0;}
					if($analoga==1 && $avanzado==1){
						//$res=round(($row[6]*100)/$abajo);
						$v_max=5;//--->100%
						//$res=($row[6]/1000)-3.5;
						
						if(($row[6])>8500){
							$voltaje=8500;
						}
						else{
							if(($row[6])<0){
								$voltaje=0;
							}
							else{
								$voltaje=($row[6]);
							}
						}	
						$voltaje=($row[6]);//voltaje "real"
						
						//$res=abs(3.5-($voltaje/1000));
						//$res=2.2-($voltaje/1000);
						$res=($voltaje/1000);
						
						//$gasolina=100-$res;
						//$ajustado=$v_max-$res;
						
						//$gasolina=(($res*100)/$v_max)." v:".$row[6];
						$gasolina=($res*100)/8.5;
						//$gasolina=($row[6]*100)/2400;
						//$gasolina=100-(($res*100)/3.5);
						//$gasolina=$row[6];
						if($gasolina>0){
							$anterior=$gasolina;
						}
						else{
							$gasolina=$anterior;
						}
					}
					$dsn_reco .="
					<tr class='fuente_once'>
						<td width='70'>$row[0]</td>
						<td width='100' >
							<a style='font-weight:normal;color:#002BEC;' 
							onclick='verVehiculo($row[3],$row[4],$tipo_veh,0,\"fech$i\")'  
							href='javascript:void(null);' class='fech$i'>".conv_fecha($row[1])."
							</a>
							<input type='hidden' id='fech$i' value='$row[3]@$row[4]@$tipo_veh'>
						</td>
						<td width='150'>".$gasolina."</td>
						<td width='150'>".$voltaje." ent:$row[7]</td>
						<td width='50'>".htmlentities($row[2])."</td>";
					/*
						segunda conexion
					*/
					$calles=otro_server($row[3],$row[4]);
					if($calles=='error'){
						$calles=otro_server($row[3],$row[4]);
					}
					if($calles=='error'){
						$calles=otro_server($row[3],$row[4]);
					}
					if($calles=='error'){
						$calles=otro_server($row[3],$row[4]);
					}
					$dsn_reco .="
						<td width='330'>".$calles."</td>
					</tr>";
					$calle = "";
					$i++;
				}
			}
			if($reg == 0)//punto inicial
			{
				$objResponse->call("StartPoint", $latIni,$lonIni);
			}
			$objResponse->call("EndPoint", $latFin,$lonFin);
			if($geos==0)$objResponse->script("xajax_mandar_geocercas($veh)");
			if($num_reg) 
			{
				$paginacion = "<table id='box-table-a1' width='1127px'>";	
				$paginacion .= "
				<tr>
					<td colspan='1'>
						<div align='left' style='display:inline;'>
							<img style='cursor:pointer;' src='img2/pdf.png' border='0' width='20' height='20' onclick='form_pdf.submit();xajax_auditabilidad(71);' title='Exportar PDF'/>
							<img style='cursor:pointer;' src='img2/xls.png' border='0' width='20' height='20' onclick='form_xls.submit();xajax_auditabilidad(70);' title='Exportar XLS'/>
							<img style='cursor:pointer;' src='img_alertas/apagado.png' border='0' width='20' height='20' onclick='xajax_gas_motor(\"$fecha_ini\",\"$fecha_fin\",$veh)' title='ver otro'/>
						</div>
					</td>
					<td></td>
					<td colspan='2'>
						<div id='reproductor' align='center'></div>
					</td>
					<td colspan='2'></td>
				</tr>";
				$paginacion .= "
				<tr>
					<th width='70'>ID POS</th>
					<th width='100'>Fecha</th>
					<th width='150'>Gasolina(%)</th>
					<th width='150'>Voltaje</th>
					<th width='50'>Vel.Km</th>
					<th width='330'>Calles</th>
				</tr>";
			}
			
			$dsn_reco .= "</table></div>";
			mysql_close($con);
		
			$panelInfo .= "";
			$panelInfo .= "<table width='1127px' id='box-table-a1'>
				<tr>
					<td width='300px'><b>Vehículo:</b> ".htmlentities(strtoupper($_vehiculo))."</td>
					<td id='graficas'></td>
					<td align='right' style='padding-right:20px;' id='vel_rep'></td>
				</tr>";
			$panelInfo.=$paginacion;
			$imagen="<img src=\"sensor_gas.php?entrada=$no_entrada&ini=$fecha_ini&fin=$fecha_fin&veh=$veh\"/>";
			$objResponse->assign("cont_reporte","innerHTML",$imagen);
			
			$objResponse->assign("cont_reporte","innerHTML",$dsn_reco);
			$objResponse->assign("panelinfo","innerHTML",$panelInfo);			
			$objResponse->assign("panel","innerHTML",$dsn_bot);
			$objResponse->script("$('#cont_reporte').show();");
			//$objResponse->script("mostrarLinea(0);");
			//dddddd
			$objResponse->script("mostrarLinea_(0,$i);");
			$objResponse->script("inicial();");
			$dif_gr="";
			for($i=0;$i<count($fechas_g);$i++){
				list($y,$m,$dia)=explode("-",$fechas_g[$i]);
				$dif_gr.="<a style='cursor:pointer;' onclick='xajax_graficas_dia(\"$fechas_g[$i] 00:00:00\",$no_entrada,$veh)'>".
						$dia."</a>&nbsp;&nbsp;&nbsp;";
			}
			$objResponse->assign("graficas","innerHTML","Dia: ".$dif_gr);
		}
		else{
			$objResponse->alert("Reporte Gas...No hay registros para el rango de fechas que usted proporcionó");
			$objResponse->assign("cont_reporte","innerHTML","");
		}
		return $objResponse;  
    } 
	return $objResponse;
}
function graficas_dia($fecha_ini,$no_entrada,$veh){
	$objResponse = new xajaxResponse();
	$imagen="<img src=\"sensor_gas.php?entrada=$no_entrada&ini=$fecha_ini&veh=$veh\"/>";
	$objResponse->assign("img_grafica","innerHTML",$imagen);
	$objResponse->script('jQuery("#img_grafica").dialog("open");');
	return $objResponse;
}
function gas_motor($ini,$fin,$veh){
	$objResponse = new xajaxResponse();
	$ayer=mysql_query("SELECT max(id) from id_pos where fechahora<'$ini'");
	$pos_ayer=mysql_fetch_array($ayer);
	/*
		obtener datos "normales
	*/
	//$veh=287375638;//Moto 12H 402
	//$veh=287375633;//Mini 216 101
	//$veh=287375635;//Retro 416E 201
	$veh=287375640;//Exca 320C

	
	$id_inicio=$pos_ayer[0];
	$q="SELECT p.entradas,p.fecha 
	from posiciones p 
	where p.id_pos>$id_inicio 
	and p.entradas in(248,249) 
	and p.num_veh=$veh 
	and p.fecha between '$ini' and '$fin'
	order by p.id_pos";
	/*
		query para primer dato
	*/
	$q2="SELECT p.entradas,p.fecha 
	from posiciones p 
	where p.id_pos>$id_inicio 
	and p.entradas in(248,249) 
	and p.num_veh=$veh 
	and p.fecha between '$ini' and '$fin'
	order by p.id_pos ASC
	limit 1";
	$query=mysql_query($q);
	
	$query2=mysql_query($q2);
	$dat_ini=mysql_fetch_array($query2);
	$horai=$dat_ini[1];
	list($d,$h)=explode(" ",$ini);
	$inicio=strtotime($dat_ini[1])-strtotime($d." 00:00:00");//tiempo anterior
	if($dat_ini[0]==248){//se enciende el motor 
		$tiempo_apagado=$inicio;
		$ev1=$dat_ini[0];
	}
	else{
		$tiempo_encendido=$inicio;
		$ev1=$dat_ini[0];
	}
	//$objResponse->alert($q);
	/*
		contabilizo a partir del "siguiente" evento a partir del inicial
	*/
	//$objResponse->alert(mysql_num_rows($query));
	if(mysql_num_rows($query)>0){//si tengo mas eventos los agrego
		while($row=mysql_fetch_array($query)){
			$ant=strtotime($horai);
			$act=strtotime($row[1]);
			$dif=$act-$ant;
			//$objResponse->alert($dif." ->".$row[0]);
			if($row[0]==248){
				$tiempo_apagado=$tiempo_apagado+$dif;
			}
			else{
				$tiempo_encendido=$tiempo_encendido+$dif;
			}
			list($diai,$hi)=explode(" ",$horai); 
			list($diaf,$hf)=explode(" ",$row[1]); 
			$horai=$row[1];
			$ev1=$row[0];
		}
	}
	else{
		$query=mysql_query("SELECT fecha FROM ultimapos u where num_veh=$veh");
		$ultima=mysql_fetch_array($query);
		if($ev1==248){
			$ant=strtotime($horai);
			$act=strtotime($ultima[0]);
			$dif=$act-$ant;
			$tiempo_encendido=$tiempo_encendido+$dif;
		}
		else{
			$ant=strtotime($horai);
			$act=strtotime($ultima[0]);
			$dif=$act-$ant;
			$tiempo_apagado=$tiempo_apagado+$dif;
		}
	}
	if(strtotime($horai)!=strtotime($fin) && strtotime($fin)>=strtotime(date("Y-m-d H:i:s"))){
		$query=mysql_query("SELECT fecha FROM ultimapos u where num_veh=$veh");
		$ultima=mysql_fetch_array($query);
		if($ev1==248){//vehiculo encendido
			$ant=strtotime($horai);
			$act=strtotime($ultima[0]);
			$dif=$act-$ant;
			$tiempo_encendido=$tiempo_encendido+$dif;
		}
		else{
			$ant=strtotime($horai);
			$act=strtotime($ultima[0]);
			$dif=$act-$ant;
			$tiempo_apagado=$tiempo_apagado+$dif;
		}
	}
	$tiempo_e="El vehiculo esta encendido ($fin)";
	if($tiempo_encendido!=''){
		$horas_e = floor($tiempo_encendido/3600);
		$minutos_e = floor(($tiempo_encendido-($horas_e*3600))/60);
		$segundos_e = $tiempo_encendido-($horas_e*3600)-($minutos_e*60);
		if($segundos_e<10){
			$segundos_e="0".$segundos_e;
		}
		if($minutos_e<10){
			$minutos_e="0".$minutos_e;
		}
		$tiempo_e= $horas_e."h: ".$minutos_e."m: ".$segundos_e."s";                                         
	}
	$tiempo_a="El vehiculo esta apagado ($fin)";
	if($tiempo_apagado!=''){
		$horas_a = floor($tiempo_apagado/3600);
		$minutos_a = floor(($tiempo_apagado-($horas_a*3600))/60);
		$segundos_a = $tiempo_apagado-($horas_a*3600)-($minutos_a*60);
		if($segundos_a<10){
			$segundos_a="0".$segundos_a;
		}
		if($minutos_a<10){
			$minutos_a="0".$minutos_a;
		}
		$tiempo_a= $horas_a."h: ".$minutos_a."m: ".$segundos_a."s";
	}
	$tabla="
	<table width='100%' id='newspaper-a1'>
		<tr>
			<th>Evento </th>
			<th>Tiempo</th>
		</tr>
		<tr>
			<td>Apagado</td>
			<td>$tiempo_a</td>
		</tr>
		<tr>
			<td>Encendido</td>
			<td>$tiempo_e</td>
		</tr>
	</table>";
	$objResponse->assign("encendidos","innerHTML",$tabla);
	$objResponse->script('jQuery("#encendidos").dialog("open");');
	return $objResponse;
}
function rep_temp($formu,$veh){
	$objResponse = new xajaxResponse();
	$fecha_ini = $formu['fecha_ini3'];
	list($f,$h)=explode(" ",$fecha_ini);
	$fecha_fin=$f." 23:59:59";
	//busco la entrada en la que esta "instalado"
	$entradas=mysql_query("SELECT a.entrada from veh_accesorio a
	inner join cat_accesorios c on c.id_accesorio=a.id_accesorio
	where c.descripcion like '%temp%'
	and a.num_veh=$veh limit 1");
	$entrada=mysql_fetch_array($entradas);
	$no_entrada=substr($entrada[0], 0, 1);
	//$imagen="<img src=\"sensor_gas.php?num_veh=$vehi&ini=$fecha_i\"/>";
	//$firephp= FirePhp::getInstance(true);
	$paginacion = "";
	$_vehiculo = "";
	$latIni;
	$latFin;
	$lonIni;
	$lonFin;
	$reg=0;
	if ($veh == '')
	{
		$objResponse = new xajaxResponse();
		$objResponse->alert("Seleccione el vehiculo para crear el recorrido");
		$objResponse->assign("cont_reporte","innerHTML","");
	 	return $objResponse;		
	}else
	{	
		$options="";
		$sess =& patSession::singleton('egw', 'Native', $options );
		$consulta = "insert into auditabilidad values (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."'
		,21,'Obtener reporte de gasolina',13,".$sess->get('Ide').",'".get_real_ip()."')";
		mysql_query($consulta);
		
		$datos_rec ="";	
		$i = 0;
		if(empty($fecha_ini)==0 && empty($fecha_fin)==0 && date($fecha_ini) < date($fecha_fin))
		{
			$cad_veh = "SELECT id_sistema,id_empresa from vehiculos where num_veh = $veh";
			$res_cad = mysql_query($cad_veh);
			$rowsist = mysql_fetch_array($res_cad);
		 	$cad_msj = "SELECT id_empresa from c_mensajes where id_empresa = $rowsist[1]";
			$res_msj = mysql_query($cad_msj);
			if(mysql_num_rows($res_msj))
			{
				$id_emp = $rowsist[1];
			}
			else {
				$id_emp = 15;
			}
			$datos_vehiculo=mysql_query("SELECT v.id_veh,v.tipoveh,v.id_sistema from vehiculos v where num_veh=$veh");
			$dat_veh=mysql_fetch_array($datos_vehiculo);
			$id_veh=$dat_veh[0];
			$_vehiculo = $id_veh;
			$tipo_veh=$dat_veh[1];
			$id_sistema=$dat_veh[2];
			$ayer=strtotime($fecha_ini."-1 day");
			$query="SELECT max(id_pos) from posiciones where fecha>='".date("Y-m-d",$ayer)." 23:59:00' 
					and fecha<='$fecha_ini';";
			$ultimas=mysql_query($query);
			$ultima=mysql_fetch_array($ultimas);
			$hoy_u=mysql_query("SELECT max(id) from id_pos where fechahora<'$fecha_ini'");
			$p1=mysql_fetch_array($hoy_u);
			$hoy_u2=mysql_query("SELECT max(id_pos) from posiciones");
			$p2=mysql_fetch_array($hoy_u2);
			$max_pos='';
			if($p1[0]>0){
				$max_pos=" p.id_pos>$p1[0] and p.id_pos<$p2[0] and";
			}
			$datos_rec="SELECT p.id_pos,p.fecha,p.velocidad,
			(p.lat/3600/16),((p.long & 8388607)/3600/12*-1),p.id_tipo,t.ent".$no_entrada."val
			from pos_entanaloga t
			inner join posiciones p on p.id_pos=t.id_pos
			where $max_pos p.num_veh = '$veh' 
			and p.fecha between '$fecha_ini' and '$fecha_fin' ";
		 }
		 else
		 {
			$objResponse->alert("Favor de dar un rango de fechas");
			return $objResponse; 
		 }
		if($reg == 0){ //si es la primera vez que entra
			$objResponse->assign("form_pdf","innerHTML","<textarea name='con_pdf' >$datos_rec</textarea>
			<input type='hidden' name='idsiste' value='$rowsist[0]'/>
			<input type='hidden' name='num_veh' value='$veh'/>
			<input type='hidden' name='tipo' value='temp'>");
		 	$objResponse->assign("form_xls","innerHTML","<textarea name='con_xls' >$datos_rec</textarea>
			<input type='hidden' name='idsistema' value='$rowsist[0]'/>
			<input type='hidden' name='num_veh' value='$veh'/>
			<input type='hidden' name='tipo' value='temp'>");
			$resp = mysql_query($datos_rec); 
			$num_reg = mysql_num_rows($resp);
		}
		else{ 
			$num_reg = $reg;
		}
		$cadreco=$datos_rec;
		//$total_paginas = ceil($num_reg  / $limite);
		//$firephp-> log($total_paginas,'Total Paginas:');
		if($num_reg != 0)
		{
			$resp = mysql_query($datos_rec); //para la paginacion
			$dsn_reco = "<div style='overflow-x:auto;overflow-y:auto;width:1127px;height:200px;position:absolute;left:15px;'>
			<table id='box-table-a1' width='1127px'>";	
		 	while($row = mysql_fetch_array($resp))
			{
				if((int)$row[3]!= 0 || (int)$row[4] != 0)
				{
					if($i == 0 && $reg == 0 )
					{
						$latIni = $row[3]; 
						$lonIni = $row[4]; 
					}
					$latFin = $row[3];
					$lonFin = $row[4];
				
					$objResponse->call("crea_recorrido", $row[3],$row[4],$tipo_veh,0);
					if($i%2!=0)
						$color = "#C6D9F1";
					else
						$color = "#FFFFFF";
		
					if($row[2]==''){$row[2]= 0;}
		
					$dsn_reco .="
					<tr class='fuente_once'>
						<td width='70'>$row[0]</td>
						<td width='100' >
							<a style='font-weight:normal;color:#002BEC;' 
							onclick='verVehiculo($row[3],$row[4],$tipo_veh,0,\"fech$i\")'  
							href='javascript:void(null);' class='fech$i'>".conv_fecha($row[1])."
							</a>
							<input type='hidden' id='fech$i' value='$row[3]@$row[4]@$tipo_veh'>
						</td>
						<td width='150'>".$row[6]." °C</td>
						<td width='50'>".htmlentities($row[2])."</td>";
					/*
						segunda conexion
					*/
					$calles=otro_server($row[3],$row[4]);					
					if($calles=='error'){
						$calles=otro_server($row[3],$row[4]);
					}
					if($calles=='error'){
						$calles=otro_server($row[3],$row[4]);
					}
					if($calles=='error'){
						$calles=otro_server($row[3],$row[4]);
					}
					$dsn_reco .="
						<td width='330'>".$calles."</td>
					</tr>";
					$calle = "";
					$i++;
				}
			}
			if($reg == 0)//punto inicial
			{
				$objResponse->call("StartPoint", $latIni,$lonIni);
			}
			$objResponse->call("EndPoint", $latFin,$lonFin);
			if($geos==0)$objResponse->script("xajax_mandar_geocercas($veh)");
			if($num_reg) 
			{
				$paginacion = "<table id='box-table-a1' width='1127px'>";	
				$paginacion .= "
				<tr>
					<td colspan='1'>
						<div align='left' style='display:inline;'>
							<img style='cursor:pointer;' src='img2/pdf.png' border='0' width='20' height='20' onclick='form_pdf.submit();xajax_auditabilidad(73);' title='Exportar PDF'/>
							<img style='cursor:pointer;' src='img2/xls.png' border='0' width='20' height='20' onclick='form_xls.submit();xajax_auditabilidad(72);' title='Exportar XLS'/>
						</div>
					</td>
					<td colspan='3'>
						<div id='reproductor' align='center'></div>
					</td>
					<td></td>
				</tr>
				<tr>";
				$paginacion .= "
					<th width='70'>ID POS</th>
					<th width='100'>Fecha</th>
					<th width='150'>Temperatura(°C)</th>
					<th width='50'>Vel.Km</th>
					<th width='330'>Calles</th>
				</tr>";
			}
			
			$dsn_reco .= "</table></div>";
			mysql_close($con);
		
			$panelInfo .= "";
			$panelInfo .= "<table width='1127px' id='box-table-a1'>
				<tr>
					<td><b>Vehículo:</b> ".htmlentities(strtoupper($_vehiculo))."</td>
					<td></td>
					<td align='right' style='padding-right:20px;' id='vel_rep'></td>
				</tr>";
			$botones_dw="<div align='left' style='display:inline;'>
							<img style='cursor:pointer;' src='img2/pdf.png' border='0' width='20' height='20' onclick='form_pdf.submit();xajax_auditabilidad(73);' title='Exportar PDF'/>
							<img style='cursor:pointer;' src='img2/xls.png' border='0' width='20' height='20' onclick='form_xls.submit();xajax_auditabilidad(72);' title='Exportar XLS'/>
						</div>";
			$panelInfo.=$paginacion;
			
			$objResponse->assign("cont_reporte","innerHTML",$dsn_reco);
			$objResponse->assign("panelinfo","innerHTML",$panelInfo);			
			$objResponse->assign("panel","innerHTML",$dsn_bot);
			$objResponse->script("$('#cont_reporte').show();");
			$objResponse->script("mostrarLinea(0);");
			$objResponse->script("inicial();");
		}
		else{
			$objResponse->alert("Reporte Tem...No hay registros para el rango de fechas que usted proporcionó");
			$objResponse->assign("cont_reporte","innerHTML","");
		}
		return $objResponse;  
    } 
	return $objResponse;
}
function rep_barras($formu,$veh){
	$objResponse = new xajaxResponse();
	$fecha_ini = $formu['fecha_ini5'];
	$fecha_fin=$formu['fecha_fin5'];
	$paginacion = "";
	$_vehiculo = "";
	$latIni;
	$latFin;
	$lonIni;
	$lonFin;
	$reg=0;
	if ($veh == '')
	{
		$objResponse = new xajaxResponse();
		$objResponse->alert("Seleccione el vehiculo para crear el recorrido");
		$objResponse->assign("cont_reporte","innerHTML","");
	 	return $objResponse;		
	}else
	{	
		$options="";
		//$sess =& patSession::singleton('egw', 'Native', $options );
		//auditabilidad(134);
		
		$datos_rec ="";	
		$i = 0;
		if(empty($fecha_ini)==0 && empty($fecha_fin)==0 && date($fecha_ini) < date($fecha_fin))
		{
			$cad_veh = "SELECT id_sistema,id_empresa from vehiculos where num_veh = $veh";
			$res_cad = mysql_query($cad_veh);
			$rowsist = mysql_fetch_array($res_cad);
		 	$cad_msj = "SELECT id_empresa from c_mensajes where id_empresa = $rowsist[1]";
			$res_msj = mysql_query($cad_msj);
			if(mysql_num_rows($res_msj))
			{
				$id_emp = $rowsist[1];
			}
			else {
				$id_emp = 15;
			}
			$datos_vehiculo=mysql_query("SELECT v.id_veh,v.tipoveh,v.id_sistema from vehiculos v where num_veh=$veh");
			$dat_veh=mysql_fetch_array($datos_vehiculo);
			$id_veh=$dat_veh[0];
			$_vehiculo = $id_veh;
			$tipo_veh=$dat_veh[1];
			$id_sistema=$dat_veh[2];
			$ayer=strtotime($fecha_ini."-1 day");
			$query="SELECT max(id_pos) from posiciones where fecha>='".date("Y-m-d",$ayer)." 23:59:00' 
					and fecha<='$fecha_ini';";
			$ultimas=mysql_query($query);
			$ultima=mysql_fetch_array($ultimas);
			$hoy_u=mysql_query("SELECT max(id) from id_pos where fechahora<'$fecha_ini'");
			$p1=mysql_fetch_array($hoy_u);
			$hoy_u2=mysql_query("SELECT max(id_pos) from posiciones");
			$p2=mysql_fetch_array($hoy_u2);
			$max_pos='';
			if($p1[0]>0){
				$max_pos=" p.id_pos>$p1[0] and p.id_pos<$p2[0] and";
			}
			$datos_rec="SELECT p.id_pos,p.fecha,p.velocidad,
			(p.lat/3600/16),((p.long & 8388607)/3600/12*-1),p.id_tipo,t.cbarras
			from pos_cbarra t
			inner join posiciones p on p.id_pos=t.id_pos
			where $max_pos t.num_veh = '$veh' 
			and p.fecha between '$fecha_ini' and '$fecha_fin' ";
		 }
		 else
		 {
			$objResponse->alert("Favor de dar un rango de fechas");
			return $objResponse; 
		 }
		if($reg == 0){ //si es la primera vez que entra
			$objResponse->assign("form_pdf","innerHTML","<textarea name='con_pdf' >$datos_rec</textarea>
			<input type='hidden' name='idsiste' value='$rowsist[0]'/>
			<input type='hidden' name='num_veh' value='$veh'/>
			<input type='hidden' name='tipo' value='temp'>");
		 	$objResponse->assign("form_xls","innerHTML","<textarea name='con_xls' >$datos_rec</textarea>
			<input type='hidden' name='idsistema' value='$rowsist[0]'/>
			<input type='hidden' name='num_veh' value='$veh'/>
			<input type='hidden' name='tipo' value='temp'>");
			$resp = mysql_query($datos_rec);
			$num_reg = mysql_num_rows($resp);
		}
		else{ 
			$num_reg = $reg;
		}
		$cadreco=$datos_rec;
		if($num_reg != 0)
		{
			$resp = mysql_query($datos_rec); //para la paginacion
			$dsn_reco = "<div style='overflow-x:auto;overflow-y:auto;width:1127px;height:200px;position:absolute;left:15px;'>
			<table id='box-table-a1' width='1127px'>";	
		 	while($row = mysql_fetch_array($resp))
			{
				if((int)$row[3]!= 0 || (int)$row[4] != 0)
				{
					if($i == 0 && $reg == 0 )
					{
						$latIni = $row[3]; 
						$lonIni = $row[4]; 
					}
					$latFin = $row[3];
					$lonFin = $row[4];
				
					$objResponse->call("crea_recorrido", $row[3],$row[4],$tipo_veh,0);
					if($i%2!=0)
						$color = "#C6D9F1";
					else
						$color = "#FFFFFF";
		
					if($row[2]==''){$row[2]= 0;}
		
					$dsn_reco .="
					<tr class='fuente_once'>
						<td width='70'>$row[0]</td>
						<td width='100' >
							<a style='font-weight:normal;color:#002BEC;' 
							onclick='verVehiculo($row[3],$row[4],$tipo_veh,0,\"fech$i\")'  
							href='javascript:void(null);' class='fech$i'>".conv_fecha($row[1])."
							</a>
							<input type='hidden' id='fech$i' value='$row[3]@$row[4]@$tipo_veh'>
						</td>
						<td width='150'>".$row[6]." </td>
						<td width='50'>".htmlentities($row[2])."</td>";
					/*
						segunda conexion
					*/
					$calles=otro_server($row[3],$row[4]);
					if($calles=='error'){
						$calles=otro_server($row[3],$row[4]);
					}
					if($calles=='error'){
						$calles=otro_server($row[3],$row[4]);
					}
					if($calles=='error'){
						$calles=otro_server($row[3],$row[4]);
					}
					$dsn_reco .="
						<td width='330'>".$calles."</td>
					</tr>";
					$calle = "";
					$i++;
				}
			}
			if($reg == 0)//punto inicial
			{
				$objResponse->call("StartPoint", $latIni,$lonIni);
			}
			$objResponse->call("EndPoint", $latFin,$lonFin);
			if($geos==0)$objResponse->script("xajax_mandar_geocercas($veh)");
			if($num_reg) 
			{
				$paginacion = "<table id='box-table-a1' width='1127px'>";	
				$paginacion .= "
				<tr>
					<td colspan='1'>
						<div align='left' style='display:inline;'>
							<img style='cursor:pointer;' src='img2/pdf.png' border='0' width='20' height='20' onclick='form_pdf.submit();xajax_auditabilidad(73);' title='Exportar PDF'/>
							<img style='cursor:pointer;' src='img2/xls.png' border='0' width='20' height='20' onclick='form_xls.submit();xajax_auditabilidad(72);' title='Exportar XLS'/>
						</div>
					</td>
					<td colspan='3'>
						<div id='reproductor' align='center'></div>
					</td>
					<td></td>
				</tr>
				<tr>";
				$paginacion .= "
					<th width='70'>ID POS</th>
					<th width='100'>Fecha</th>
					<th width='150'>C&oacute;digo</th>
					<th width='50'>Vel.Km</th>
					<th width='330'>Calles</th>
				</tr>";
			}
			
			$dsn_reco .= "</table></div>";
			mysql_close($con);
		
			$panelInfo .= "";
			$panelInfo .= "<table width='1127px' id='box-table-a1'>
				<tr>
					<td><b>Vehículo:</b> ".htmlentities(strtoupper($_vehiculo))."</td>
					<td></td>
					<td align='right' style='padding-right:20px;' id='vel_rep'></td>
				</tr>";
			$botones_dw="<div align='left' style='display:inline;'>
							<img style='cursor:pointer;' src='img2/pdf.png' border='0' width='20' height='20' onclick='form_pdf.submit();xajax_auditabilidad(73);' title='Exportar PDF'/>
							<img style='cursor:pointer;' src='img2/xls.png' border='0' width='20' height='20' onclick='form_xls.submit();xajax_auditabilidad(72);' title='Exportar XLS'/>
						</div>";
			$panelInfo.=$paginacion;
			
			$objResponse->assign("cont_reporte","innerHTML",$dsn_reco);
			$objResponse->assign("panelinfo","innerHTML",$panelInfo);			
			$objResponse->assign("panel","innerHTML",$dsn_bot);
			$objResponse->script("$('#cont_reporte').show();");
			$objResponse->script("mostrarLinea(0);");
			$objResponse->script("inicial();");
		}
		else{
			$objResponse->alert("Reporte Barras...No hay registros para el rango de fechas que usted proporcionó");
			$objResponse->assign("cont_reporte","innerHTML","");
		}
		return $objResponse;  
    } 
	return $objResponse;
}
function add_msj($actuales,$all){
	$objResponse = new xajaxResponse();
	$checked='';
	if($all==1){
		$checked="checked='checked'";
	}
	$tabla="
	<table id='newspaper-a1'>
		<tr>
			<th><input type='checkbox' onclick='all_msj()' id='all_msj' $checked></th>
			<th>Mensajes por clave</th>
		</tr>
	";
	if(preg_match("/252;7/",$actuales)){
		$panicos="checked='checked'";
	}
	$tabla.="	
		<tr>
			<td><input type='checkbox' onclick='add_msj()' name='msj_recorrido' value='252;7' $panicos></td>
			<td>Panicos</td>
		</tr>";
	if(preg_match("/298/",$actuales)){
		$Sabotaje="checked='checked'";
	}
	$tabla.="	
		<tr>
			<td><input type='checkbox' onclick='add_msj()' name='msj_recorrido' value='298' $Sabotaje></td>
			<td>Sabotaje</td>
		</tr>";
	if(preg_match("/292;269/",$actuales)){
		$Exceso="checked='checked'";
	}
	$tabla.="	
		<tr>
			<td><input type='checkbox' onclick='add_msj()' name='msj_recorrido' value='292;269' $Exceso></td>
			<td>Exceso Velocidad</td>
		</tr>";
	if(preg_match("/335;336;337/",$actuales)){
		$Comandos="checked='checked'";
	}
	$tabla.="	
		<tr>
			<td><input type='checkbox' onclick='add_msj()' name='msj_recorrido' value='335;336;337' $Comandos></td>
			<td>Comandos Online</td>
		</tr>";
	if(preg_match("/248/",$actuales)){
		$encendido="checked='checked'";
	}
	$tabla.="	
		<tr>
			<td><input type='checkbox' onclick='add_msj()' name='msj_recorrido' value='248' $encendido></td>
			<td>Motor encendido</td>
		</tr>";
	if(preg_match("/249/",$actuales)){
		$Apagado="checked='checked'";
	}
	$tabla.="	
		<tr>
			<td><input type='checkbox' onclick='add_msj()' name='msj_recorrido' value='249' $Apagado></td>
			<td>Motor apagado</td>
		</tr>";
	if(preg_match("/218;192/",$actuales)){
		$voltaje="checked='checked'";
	}
	$tabla.="	
		<tr>
			<td><input type='checkbox' onclick='add_msj()' name='msj_recorrido' value='218;192' $voltaje></td>
			<td>Sin voltaje principal</td>
		</tr>";
	if(preg_match("/297/",$actuales)){
		$gas="checked='checked'";
	}
	$tabla.="	
		<tr>
			<td><input type='checkbox' onclick='add_msj()' name='msj_recorrido' value='297' $gas></td>
			<td>Sensor de Gasolina</td>
		</tr>";
	$tabla.="</table>";
	$objResponse->assign('los_mensajes','innerHTML',$tabla);   
	return $objResponse;
}
function add_img($actuales,$all){
	$objResponse = new xajaxResponse();
	$options="";$sess =& patSession::singleton('egw', 'Native', $options );
	$ide=$sess->get("Ide");
	$checked='';
	if($all==1){
		$checked="checked='checked'";
	}
	$tabla="
	<table id='newspaper-a1'>
		<tr>
			<th><input type='checkbox' onclick='all_img()' id='all_img' $checked></th>
			<th>Imagen</th>
			<th>Evento</th>
		</tr>
	";
	if(preg_match("/252;7/",$actuales)){
		$panicos="checked='checked'";
	}
	$tabla.="	
		<tr>
			<td><input type='checkbox' onclick='add_img()' name='img_recorrido' value='252;7' $panicos></td>
			<td><img src='img_alertas/panico.png' width='25px'></td>
			<td>Panicos</td>
		</tr>";
	if(preg_match("/298/",$actuales)){
		$Sabotaje="checked='checked'";
	}
	$tabla.="	
		<tr>
			<td><input type='checkbox' onclick='add_img()' name='img_recorrido' value='298' $Sabotaje></td>
			<td><img src='img_alertas/sabotaje.png' width='25px'></td>
			<td>Sabotaje</td>
		</tr>";
	if(preg_match("/292;269/",$actuales)){
		$Exceso="checked='checked'";
	}
	$tabla.="	
		<tr>
			<td><input type='checkbox' onclick='add_img()' name='img_recorrido' value='292;269' $Exceso></td>
			<td><img src='img_alertas/velocidad.png' width='25px'></td>
			<td>Exceso Velocidad</td>
		</tr>";
	if(preg_match("/335;336;337/",$actuales)){
		$Comandos="checked='checked'";
	}
	$tabla.="	
		<tr>
			<td><input type='checkbox' onclick='add_img()' name='img_recorrido' value='335;336;337' $Comandos></td>
			<td><img src='img_alertas/online.png' width='25px'></td>
			<td>Comandos Online</td>
		</tr>";
	if(preg_match("/248/",$actuales)){
		$encendido="checked='checked'";
	}
	$tabla.="	
		<tr>
			<td><input type='checkbox' onclick='add_img()' name='img_recorrido' value='248' $encendido></td>
			<td><img src='img_alertas/encendido.png' width='25px'></td>
			<td>Motor encendido</td>
		</tr>";
	if(preg_match("/249/",$actuales)){
		$Apagado="checked='checked'";
	}
	$tabla.="	
		<tr>
			<td><input type='checkbox' onclick='add_img()' name='img_recorrido' value='249' $Apagado></td>
			<td><img src='img_alertas/apagado.png' width='25px'></td>
			<td>Motor apagado</td>
		</tr>";
	if(preg_match("/218;192/",$actuales)){
		$voltaje="checked='checked'";
	}
	$tabla.="	
		<tr>
			<td><input type='checkbox' onclick='add_img()' name='img_recorrido' value='218;192' $voltaje></td>
			<td><img src='img_alertas/sin_bateria.png' width='25px'></td>
			<td>Sin voltaje principal</td>
		</tr>";
	$tabla.="</table>";
	$objResponse->assign('las_imagenes','innerHTML',$tabla);   
	return $objResponse;
}
/**************************************************************************************PINTANDO GEOCERCAS DE LOS VEHICULOS************************************************************************************/	
function ver_geocercas($id_geo){  //
	$objResponse = new xajaxResponse();
	//$objResponse->alert($id_geo);
	$cad_geo = "SELECT g.tipo";
	$cad_geo .= " from geo_time g";
	$cad_geo .= " where g.num_geo = $id_geo and activo=1";
	$res_geo = mysql_query($cad_geo);
	$num_geo = mysql_fetch_array($res_geo);
	//$objResponse->alert($id_geo);
	//$objResponse->alert($cad_geo);	
	$arregloLatitud=array(); 
	$arregloLongitud=array();
	if($num_geo[0]==0){
		$query="SELECT latitud,longitud,radioMts,nombre from geo_time where num_geo=$id_geo and activo=1";	
		$res_geo=mysql_query($query);
		$row = mysql_fetch_row($res_geo);
		$radio = $row[2];
		$objResponse->call("mostrar_circular_reporte",$row[0],$row[1],$radio,$row[3]);
		}
	if($num_geo[0]== 1 ){
		$query="SELECT p.latitud,p.longitud,g.nombre
		from geo_puntos p 
		inner join geo_time g on p.id_geo=g.num_geo
		where p.id_geo=$id_geo and g.activo=1 order by p.orden";	
		$res_geo=mysql_query($query);
		//$objResponse->alert($query);
		$num_geo=mysql_num_rows($res_geo);
		while($row = mysql_fetch_array($res_geo)){
			array_push($arregloLatitud,$row[0]);
			array_push($arregloLongitud,$row[1]);
			$nombre=$row[2];
		}
		$objResponse->call("mostrar_poligonal_reporte",$arregloLatitud,$arregloLongitud,$nombre);
	}
	return $objResponse;
}
function mandar_geocercas($num_veh){
	$objResponse = new xajaxResponse();
	//$objResponse->alert($num_veh);
	$cadGeos="SELECT num_geo from geo_veh where num_veh=$num_veh and activo=1";
	$queryGeos=mysql_query($cadGeos);
	while($rowGeos=mysql_fetch_row($queryGeos)){
		$objResponse->script("xajax_ver_geocercas($rowGeos[0]);");
		//$objResponse->alert($rowGeos[0]);
	}
	return $objResponse;
}
/*********************************************************************************************************************************************************************************************************************************/

 //Funcion para crear el formulario y los vehiculos dependiendo del tipo de reporte.
function estilo($a,$ide,$idu){
	$objResponse = new xajaxResponse();
	switch($a) 
	{
		case 1:
			$cad_veh = "SELECT DISTINCT(v.ID_VEH), v.NUM_VEH
								FROM veh_usr AS vu
								Inner Join vehiculos AS v ON vu.NUM_VEH = v.NUM_VEH
								inner join estveh ev on (v.estatus=ev.estatus)
								WHERE vu.ID_USUARIO = $idu 
								and ev.publicapos in(1)
								and vu.activo=1
								ORDER BY v.ID_VEH ASC";
			$res_veh = mysql_query($cad_veh);
			$dsn_veh ="<table id='newspaper-a1' style='width:165px'>
			<tr>
				<th>Vehículos</th>
			</tr>";
			while($rowv = mysql_fetch_row($res_veh))
				$dsn_veh .="<tr><td><input type='radio' name='vehiculos[]' value='".$rowv[1]."'>".htmlentities($rowv[0])."</td></tr>";  
			$dsn_veh .="</table>"; 
			$objResponse->assign('veh_checks','innerHTML',$dsn_veh);   
			
			$dsn .="
			<table width='330' border='0' cellpadding='0' cellspacing='1' id='box-table-a1'>
				<tr style='height:27px;'>
					<td width='170' style='padding-left:10px;'>Fecha inicio:</td>
					<td width='160'>
						<label>
							<input name='fecha_ini' id='fecha_ini' 
							style='position: relative; z-index: 10;' 
							size='15' value='".date("Y-m-d")." 00:00:00'/>
						</label>
					</td>
				</tr>
				<tr style='height:27px;'>
					<td style='padding-left:10px;'>Fecha fin:</td>
					<td>
						<label>
							<input name='fecha_fin' type='text' 
							style='position: relative; z-index: 10;' 
							id='fecha_fin' size='15' value='".date("Y-m-d H:i:s")."'/>
						</label>
					</td>
				</tr>
				<tr style='height:25px;'>
					<td style='padding-left:10px;'>Velocidad menor a:</td>
					<td>
						<label><input name='vel_men' type='text' id='vel_men' size='5' /></label>
					</td>
				</tr>
				<tr style='height:25px;'>
					<td style='padding-left:10px;'>Velocidad mayor a:</td>
					<td>
						<label><input name='vel_may' type='text' id='vel_may' size='5' /></label>
					</td>
				</tr>
				<tr style='height:25px;'>
					<td style='padding-left:10px;'>Todas las posiciones:</td>
					<td><input type='checkbox' name='pos_auto' id='pos_auto' checked='checked'/></td>
				</tr>
				<tr style='height:25px;'>
					<td style='padding-left:10px;'>Mensajes por clave:</td>
					<td><input type='checkbox' name='tipo_rep' id='tipo_rep' onclick='mostrar_msj();enviar_msj();'/></td>
					<input type='hidden' value='' id='id_mensajes' name='id_mensajes'>
					<input type='hidden' id='c_all_msj' value='0'>
				</tr>
				<tr style='height:25px;'>
					<td style='padding-left:10px;'>Posiciones obsoletas:</td>
					<td><input type='checkbox' name='pos_obs' id='pos_obs'/></td>
				</tr>
				<tr style='height:25px;'>
					<td style='padding-left:10px;'>Solicitudes de posiciones:</td>
					<td><input type='checkbox' name='sol_pos' id='sol_pos' /></td>
				</tr>
				<tr style='height:25px;'>
					<td style='padding-left:10px;'>Ver od&oacute;metro:</td>
					<td><input type='checkbox' name='odometro' id='odometro' checked='checked' /></td>
				</tr>
				<tr style='height:25px;'>
					<td style='padding-left:10px;'>Ver imagen evento</td>
					<td><input type='checkbox' name='imagenes' id='imagenes' onclick='mostrar_img();enviar_img()'/></td>
					<input type='hidden' value='' id='id_imagenes' name='id_imagenes'>
					<input type='hidden' id='c_all_img' value=''>
				</tr>
				<tr style='height:25px;'>
					<td style='padding-left:10px;'>Ver kilometraje acumulado</td>
					<td><input type='checkbox' name='acumulado' id='acumulado'/></td>
				</tr><!--
				<tr style='height:25px;'>
					<td style='padding-left:10px;'>Mensajes libres:</td>
					<td>
						<label>
						<input type='checkbox' name='msj_lib' id='msj_lib' checked='checked'/>
						</label>
					</td>
				</tr>
				<tr style='height:25px;'>
					<td style='padding-left:10px;'>Activación de entradas digitales:</td>
					<td><input type='checkbox' name='act_entra' id='act_entra' checked='checked' /></td>
				</tr>
				<tr style='height:25px;'>
					<td style='padding-left:10px;'>Exceso de velocidad:</td>
					<td><input type='checkbox' name='exceso_vel' id='exceso_vel' checked='checked' /></td>
				</tr>-->
				<tr style='height:25px;'>
					<td>&nbsp;</td>
					<td style='padding-left:9px;'>
						<input type='submit' class='agregar1' id='button' value='Obtener reporte' 
						onclick='getReport();' title='Obtener reporte'/>
					</td>
				</tr>
			</table>";
			$objResponse->assign('variables_reporte','innerHTML',$dsn);
			$objResponse->script("setTimeout('calendario(\"fecha_fin\")',1000);");
			$objResponse->script("setTimeout('calendario(\"fecha_ini\")',800);");
			break;
		case 2:
			$cad_veh = "SELECT v.ID_VEH, v.NUM_VEH
						FROM veh_usr AS vu
						Inner Join vehiculos AS v ON vu.NUM_VEH = v.NUM_VEH
						inner join estveh ev on (v.estatus = ev.estatus)
						WHERE vu.ID_USUARIO = $idu 
						and ev.publicapos=1
						and vu.activo=1
						ORDER BY v.ID_VEH ASC ";
			$res_veh = mysql_query($cad_veh);
			$dsn_veh ="";
			$dsn_veh .="
			<table id='newspaper-a1' style='width:165px;'>
				<tr>
					<th>Vehículos</th>
				</tr>
			";
			while($rowv = mysql_fetch_row($res_veh)){
				$dsn_veh .="
				<tr>
					<td>
						<input type='checkbox' value='".$rowv[1]."' id='reptsm' name='reptsm' />".htmlentities($rowv[0])."
					</td>
				</tr>";	
			}
			$dsn_veh .="</table>";
			$objResponse->assign('veh_checks','innerHTML',$dsn_veh); 
			
			$dsn1  ="<p>&nbsp;</p>
			<table width='330' style='position:absolute;top:0px;' id='box-table-a1'>
				<tr>
					<td width='170'>Fecha inicio:</td>
					<td width='160'>
						<label>
							<input name='fecha_ini2' 
							style='position:relative;z-index:10;' 
							type='text' id='fecha_ini2' size='15' value='".date("Y-m-d")." 00:00:00'/>
						</label>
					</td>
				</tr>
				<tr>
					<td>Fecha fin:</td>
					<td>
						<label>
						<input name='fecha_fin2' style='position: relative; z-index: 10;' 
						type='text' id='fecha_fin2' size='15' value='".date("Y-m-d H:i:s")."' />
						</label>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td></td>
				</tr>
				<tr>
					<td>Mayor a:</td>
					<td>
						<input type='text' name='mayor' id='mayor' size='4' />
					</td>
				</tr>
				<tr>
					<td>Menor a:</td>
					<td><input type='text' name='menor' id='menor' size='4' /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td></td>
				</tr>
				<tr>
					<td><input type='radio' name='tmp' id='tmp' value='hrs' /> Horas</td>
					<td><input type='radio' name='tmp' id='tmp' value='mnt' checked='checked' /> Minutos</td>
				</tr>
				<tr>
					<td>&nbsp;</td><td></td>
				</tr>
				<tr>
					<td colspan='2'><input type='submit' class='agregar1' id='button' value='Obtener reporte' 
					onclick='cont_checks();' title='Obtener reporte'/>
					</td>
				</tr>
			</table>";
			$objResponse->assign('variables_reporte','innerHTML',$dsn1);
			$objResponse->script("setTimeout('calendario(\"fecha_fin2\")',1000);");
			$objResponse->script("setTimeout('calendario(\"fecha_ini2\")',800);");
			break;
		case 3:
			$objResponse->assign('variables_reporte','innerHTML','');
			$objResponse->alert('Fuera de servicio por el momento');	
			break;
		case 4:
			$cad_veh = "SELECT v.ID_VEH, v.NUM_VEH,a.entrada
			FROM veh_usr AS vu
			Inner Join vehiculos AS v ON vu.NUM_VEH = v.NUM_VEH
			inner join estveh ev on v.estatus=ev.estatus
			inner join veh_accesorio a on v.num_veh=a.num_veh
			inner join cat_accesorios c on a.id_accesorio=c.id_accesorio
			WHERE vu.ID_USUARIO = $idu 
			and ev.publicapos=1
			and vu.activo=1
			and a.activo=1
			and c.descripcion like '%combustible%'
			ORDER BY v.ID_VEH ASC";
			$res_veh = mysql_query($cad_veh);
			
			$dsn_veh ="";
			$dsn_veh .="
			<table id='newspaper-a1' style='width:165px;'>
				<tr>
					<th>Vehículos</th>
				</tr>
			";
			while($rowv = mysql_fetch_row($res_veh)){
				$dsn_veh .="
				<tr>
					<td>
						<input type='radio' value='".$rowv[1]."@".$rowv[2]."' id='rep_gas' name='rep_gas' />".htmlentities($rowv[0])."
					</td>
				</tr>";	
			}
			$dsn_veh .="</table>";
			$objResponse->assign('veh_checks','innerHTML',$dsn_veh); 
			
			$dsn1  ="<p>&nbsp;</p>
			<table width='330' style='position:absolute;top:0px;' id='box-table-a1'>
				<tr>
					<td width='170'>Fecha inicio:</td><td width='160'>
					<label>
						<input name='fecha_ini4' 
						style='position:relative;z-index:10;' 
						type='text' id='fecha_ini4' size='15' 
						value='".date("Y-m-d")." 00:00:00'/>
					</label>
					</td>
				</tr>
				<tr>
					<td width='170'>Fecha fin:</td><td width='160'>
					<label>
						<input name='fecha_fin4' 
						style='position:relative;z-index:10;' 
						type='text' id='fecha_fin4' size='15' 
						value='".date("Y-m-d H:i:s")."'/>
					</label>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td><td></td>
				</tr>
				<tr>
					<td colspan='2'>
						<input type='submit' class='agregar1' id='button' value='Reporte Gasolina' 
						onclick='cont_checks_gas();' title='Obtener reporte de gasolina'/>
					</td>
				</tr>
			</table>";
			$objResponse->assign('variables_reporte','innerHTML',$dsn1);
			$objResponse->script("setTimeout('calendario(\"fecha_ini4\")',800);");
			$objResponse->script("setTimeout('calendario(\"fecha_fin4\")',1000);");
			
			break;
		case 5:	
			$options="";
			$sess =& patSession::singleton('egw', 'Native', $options );
			$consulta = "insert into auditabilidad values (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',22,'Ultima posicion',13,".$sess->get('Ide').")";
			mysql_query($consulta);
			$cad .= "SELECT DISTINCT(v.num_veh),v.id_veh,
					(u.lat/3600/16),
					((u.long & 8388607)/3600/12*-1),
					u.mensaje,u.velocidad,u.fecha,
					v.tipoveh,u.t_mensaje,v.id_empresa,
					u.entradas
					FROM vehiculos AS V
					INNER JOIN ultimapos AS u ON v.num_veh=u.num_veh
					INNER JOIN veh_usr AS vu ON v.num_veh=vu.num_veh
					INNER JOIN estveh ev on v.estatus = ev.estatus
					WHERE vu.id_usuario= $idu
					and vu.activo=1
					and ev.publicapos=1
					order by v.id_veh";
			$res_rep = mysql_query($cad);
			if($res_rep != 0){
				$datos  = "<div style='position:absolute;left:100px;top:0px;width:990px;height:600px;overflow:auto;z-index:100;'>
							<table border='0' style='text-align:center;width:965px;' id='box-table-a1' cellspacing = '0' cellpadding='0'>
								<tr>
									<th width='100'>Vehículo</th>
									<th width='100'>Fecha / Hora</th>
									<th width='20'>Vel.Km</th>
									<th width='80'>Latitud</th>
									<th width='80'>Longitud</th>
									<th width='260'>Ubicación</th>
									<th width='150'>Msj 
										<img src='img2/xls.png' height='20px' width='20px' style='cursor:pointer;float:right;'
										onclick='xajax_ultima_pos_exportar($idu,$ide)'  title='Descargar Ultima posicion'
										>
									</th>
								</tr>";
				$i=0;
				while($row = mysql_fetch_array($res_rep)){	
					if($i%2!=0) $color = "#C6D9F1"; else $color = "#FFFFFF";
					$clv = $row[10];
					$lat = $row[2];
					$lon = $row[3];
					if($row[8] == 2 || $row[8] == 1) $men = $row[4];
					if($row[8] == 3){
						$c_mensa = mysql_query("SELECT mensaje from c_mensajes where id_empresa = $row[9] and id_mensaje = '$clv'");
						$row1 = mysql_fetch_array($c_mensa);
						$men = $row1[0];
						if($men == ''){
							$c_mensa = mysql_query("SELECT mensaje from c_mensajes where id_empresa = 15 and id_mensaje = '$clv'");
							$row1 = mysql_fetch_array($c_mensa);
							$men = $row1[0];
						}
					}

					if ((($lat != "") || ($lon != "")) && (($lat != 0) || ($lon != 0))){
						$calle=otro_server($lat,$lon);
						if($calle==''){
							$calle=sitio_cercano($ide,$lat,$lon);
						}
						if($calle==''){
							$calle="No hay algún punto de referencia cercano (<a href='https://www.google.com.mx/maps/preview#!q=".$lat."%2C".$lon."' target='_blank'>Mapa</a>)";
						}
						if($calle[0]==','){
							$calle=substr($calle,1);
						}
					} else $calle = "Posible perdida de GPS";
					$datos.= "<tr class='fuente_once'><td width='100'>".utf8_encode($row[1])."</td><td width='100'>".conv_fecha($row[6])."</td><td width='20'>$row[5]</td><td width='80'>";
					$datos.= number_format($lat,6,'.','')."</td><td width='80'>".number_format($lon,6,'.','')."</td>";
					$datos.= "<td width='260' >".$calle."</td><td width='150'>".strtoupper(utf8_encode($men))."</td></tr>";
					$i++;
				}
				$datos .= "</table></div>";
				$objResponse->assign('cont_reporte','innerHTML',$datos);
				$objResponse->script("$('#cont_reporte').show();");
			}else{
				$objResponse->alert('No hay registros para mostrar');	
			} 
			break;
		case 6:
			$cad_veh = "SELECT distinct(v.ID_VEH), v.NUM_VEH
			FROM veh_usr AS vu
			Inner Join vehiculos AS v ON vu.NUM_VEH = v.NUM_VEH
			inner join estveh ev on v.estatus=ev.estatus
			inner join veh_accesorio a on v.num_veh=a.num_veh
			inner join cat_accesorios c on a.id_accesorio=c.id_accesorio
			WHERE vu.ID_USUARIO = $idu 
			and ev.publicapos=1
			and vu.activo=1
			and c.descripcion like '%temp%'
			ORDER BY v.ID_VEH ASC";
			$res_veh = mysql_query($cad_veh);
			
			$dsn_veh ="";
			$dsn_veh .="
			<table id='newspaper-a1' style='width:165px;'>
				<tr>
					<th>Vehículos</th>
				</tr>
			";
			while($rowv = mysql_fetch_row($res_veh)){
				$dsn_veh .="
				<tr>
					<td>
						<input type='radio' value='".$rowv[1]."' id='rep_temp' name='rep_temp' />".htmlentities($rowv[0])."
					</td>
				</tr>";	
			}
			$dsn_veh .="</table>";
			$objResponse->assign('veh_checks','innerHTML',$dsn_veh); 
			
			$dsn1  ="<p>&nbsp;</p>
			<table width='330' style='position:absolute;top:0px;' id='box-table-a1'>
				<tr>
					<td width='170'>Fecha:</td>
					<td width='160'>
						<label>
							<input name='fecha_ini3' 
							style='position:relative;z-index:10;'
							type='text' id='fecha_ini3' size='15' value='".date("Y-m-d")." 00:00:00'/>
						</label>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td><td></td>
				</tr>
				<tr>
					<td colspan='2'>
						<input type='submit' class='agregar1' 
						id='button' value='Reporte temperatura' 
						onclick='cont_checks_temp();' 
						title='Obtener reporte de tamperatura'/>
					</td>
				</tr>
			</table>";
			$objResponse->assign('variables_reporte','innerHTML',$dsn1);
			$objResponse->script("setTimeout('calendario(\"fecha_ini3\")',800);");
			break;
		case 7:
			$cad_veh = "SELECT distinct(v.ID_VEH), v.NUM_VEH
			FROM veh_usr AS vu
			Inner Join vehiculos AS v ON vu.NUM_VEH = v.NUM_VEH
			inner join estveh ev on v.estatus=ev.estatus
			inner join veh_accesorio a on v.num_veh=a.num_veh
			inner join cat_accesorios c on a.id_accesorio=c.id_accesorio
			WHERE vu.ID_USUARIO = $idu 
			and ev.publicapos=1
			and vu.activo=1
			and c.descripcion like '%barras%'
			ORDER BY v.ID_VEH ASC";
			$res_veh = mysql_query($cad_veh);
			
			$dsn_veh ="";
			$dsn_veh .="
			<table id='newspaper-a1' style='width:165px;'>
				<tr>
					<th>Vehículos</th>
				</tr>
			";
			while($rowv = mysql_fetch_row($res_veh)){
				$dsn_veh .="
				<tr>
					<td>
						<input type='radio' value='".$rowv[1]."' id='rep_barras' name='rep_barras' />".htmlentities($rowv[0])."
					</td>
				</tr>";	
			}
			$dsn_veh .="</table>";
			$objResponse->assign('veh_checks','innerHTML',$dsn_veh); 
			$dsn1  ="<p>&nbsp;</p>
			<table width='330' style='position:absolute;top:0px;' id='box-table-a1'>
				<tr>
					<td width='170'>Fecha Inicio:</td>
					<td width='160'>
						<label>
							<input name='fecha_ini5' 
							style='position:relative;z-index:10;'
							type='text' id='fecha_ini5' size='15' value='".date("Y-m-d")." 00:00:00'/>
						</label>
					</td>
				</tr>
				<tr>
					<td width='170'>Fecha Fin:</td>
					<td width='160'>
						<label>
							<input name='fecha_fin5' 
							style='position:relative;z-index:10;'
							type='text' id='fecha_fin5' size='15' value='".date("Y-m-d")." 23:59:59'/>
						</label>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td><td></td>
				</tr>
				<tr>
					<td colspan='2'>
						<input type='submit' class='agregar1' 
						id='button' value='Reporte C&oacute;digo de Barras' 
						onclick='cont_checks_barras();' 
						title='Obtener reporte de Codigo de barras'/>
					</td>
				</tr>
			</table>";
			$objResponse->assign('variables_reporte','innerHTML',$dsn1);
			$objResponse->script("setTimeout('calendario(\"fecha_ini5\")',800);");
			$objResponse->script("setTimeout('calendario(\"fecha_fin5\")',800);");
		break;
	}
	return $objResponse; 
} 
/**
 * TODO. ESTA FUNCION ARROJA UN ERROR FATAL
 */
function ultimo_encendido($id_pos,$ini,$veh){
	/*
		$id_pos;//ultimo idpos del dia anterior
		$ini;//fecha y hora del inicio del reporte
		obtenemos el id pos de 2 dias atras
	*/
	$query=mysql_query("SELECT max(id) from id_pos where id<$id_pos");
	$anterior=mysql_fetch_array($query);
	$m_248=mysql_query("SELECT max(id_pos) from posiciones where num_veh=$veh and id_pos>$anterior[0] 
	and fecha<'$ini' 
	and entradas=248");
	$m_249=mysql_query("SELECT max(id_pos) from posiciones where num_veh=$veh and id_pos>$anterior[0] 
	and fecha<'$ini'
	and entradas=249");
	if(mysql_num_rows($m_248)>0 || mysql_num_rows($m_249)>0){//si hay algun registro entramos
		
		if(mysql_num_rows($m_248)>0 && mysql_num_rows($m_249)>0){//si existen los 2 registros
			$dat_248=mysql_fetch_array($m_248);
			$dat_249=mysql_fetch_array($m_249);
			$fecha_248=mysql_query("SELECT fecha from posiciones where id_pos=".$dat_248[0]);
			$fecha_249=mysql_query("SELECT fecha from posiciones where id_pos=".$dat_249[0]);
			$f_248=mysql_fetch_array($fecha_248);
			$f_249=mysql_fetch_array($fecha_249);
			if($f_248[0]>$f_249[0]){
				$encendido="on";
			}
			else{
				$encendido="off";
			}
		}
		else{
			if(mysql_num_rows($m_248)>0){
				/*$dat_248=mysql_fetch_array($m_248);
				$fecha_248=mysql_query("SELECT fecha from posiciones where id_pos=".$dat_248[0]);
				$f_248=mysql_fetch_array($fecha_248);*/
				$encendido="on";
			}
			else{
				/*$dat_249=mysql_fetch_array($m_249);
				$fecha_249=mysql_query("SELECT fecha from posiciones where id_pos=".$dat_249[0]);
				$f_249=mysql_fetch_array($fecha_249);*/
				$encendido="off";
			}
		}
		return $encendido;
	}
	else{//si no encontre datos en las fechas dadas, volvemos a calcular hacia atras
		ultimo_encendido($anterior[0],$ini,$veh);
	}
}

/**************************************************************************************************************************************/
function recorrido($valorForm,$inicio,$limite,$pag,$reg,$geos){
	$paginacion = "";
	$_vehiculo = "";
	$latIni;
	$latFin;
	$lonIni;
	$lonFin;
	$objResponse = new xajaxResponse();    

	if (sizeof($valorForm['vehiculos']) < 1) {
		//$objResponse->script("console.error('ERROR. No se selecciono ningun vehiculo.')");
		$objResponse->alert("ERROR. No se selecciono ningun vehiculo.");
		return $objResponse;
	}

    foreach ($valorForm['vehiculos'] as $veh);

	if ($veh == ''){
		$objResponse->alert("Seleccione el vehiculo para crear el recorrido");
		$objResponse->assign("cont_reporte","innerHTML","");
		$objResponse->script("$('input[class*=\"desactivado\"]').removeAttr( 'disabled', 'disabled');");
		$objResponse->script("$('input[class*=\"desactivado\"]').removeClass('desactivado');");
		$objResponse->script("$('input[value*=\"Obtener reporte\"]').addClass('agregar1');");
	 	return $objResponse;
	} else {
		$options="";
		$sess =& patSession::singleton('egw', 'Native', $options );
		$fecha_ini = $valorForm['fecha_ini'];
		$fecha_fin = $valorForm['fecha_fin'];		
		$vel_men = $valorForm['vel_men'];				
		$vel_may = $valorForm['vel_may'];
		$pos_auto = $valorForm['pos_auto'];
		$mensajes = explode(";",$valorForm['id_mensajes']);
		$sol_pos = $valorForm['sol_pos'];
		$odometro = $valorForm['odometro'];
		$imagenes = $valorForm['id_imagenes'];
		$numero_usr = $valorForm['n_usr'];
		$id_usuario = $valorForm['id_usr'];			
		$id_empresa = $valorForm['id_emp'];
		$tipo_reporte = $valorForm['tipo_rep'];
		$pos_obs = $valorForm['pos_obs'];
		$acumular=$valorForm['acumulado'];
		
		$encendido="";
		$datos_rec ="";

		$datos = mysql_query("SELECT tpoleo from vehiculos where num_veh=$veh");
		//echo "||"."SELECT tpoleo from vehiculos where num_veh=$veh";
		$min_dia = 1440;
		list($fin,$hora)=explode(" ",$fecha_fin);
		list($inicio,$hora)=explode(" ",$fecha_ini);
		if($fin==$inicio){
			$t_dias=1;
		}
		else{
			$t_dias=date("j",strtotime($fin)-strtotime($inicio))+1;
		}
		$t_poleo=mysql_fetch_array($datos);
		if($t_dias>=2){
			$gestion=number_format(($t_dias*(number_format($min_dia/$t_poleo[0],0,'','')))*1.15,0,'','');
		}
		else{
			$gestion=number_format((number_format($min_dia/$t_poleo[0],0,'',''))*1.15,0,'','');
		}
		/*
		$server="160.16.18.8";
		$conec = mysql_connect($server,"supervisor","supervisor");
		mysql_select_db("sepromex",$conec);
		*/
		$server="10.0.1.3";
		$conec = mysql_connect($server,"egweb","53g53pr0")  or die ("¡No hay conexión con el servidor! <br />" . mysql_error());
		mysql_select_db("sepromex",$conec);
		$i = 0;
		if(!empty($fecha_ini) && !empty($fecha_fin) && date($fecha_ini) < date($fecha_fin)){
			$cad_veh = "SELECT id_sistema,id_empresa from vehiculos where num_veh = $veh";
			$res_cad = mysql_query($cad_veh);
			$rowsist = mysql_fetch_array($res_cad);
		 	$cad_msj = "SELECT distinct id_empresa from c_mensajes where id_empresa = $rowsist[1]";
		 	//echo "||".$cad_veh;
		 	//echo "||".$cad_msj;
		 	
			$res_msj = mysql_query($cad_msj);
			if(mysql_num_rows($res_msj))
			{
				$id_emp = $rowsist[1];
			}
			else {
				$id_emp = 15;
			}

			$datos_vehiculo=mysql_query("SELECT v.id_veh,v.tipoveh,v.id_sistema from vehiculos v where num_veh=$veh",$conec);
			//echo "||"."SELECT v.id_veh,v.tipoveh,v.id_sistema from vehiculos v where num_veh=$veh";
			$dat_veh=mysql_fetch_array($datos_vehiculo);
			$id_veh=$dat_veh[0];
			$tipo_veh=$dat_veh[1];
			$id_sistema=$dat_veh[2];
			$ayer=strtotime($fecha_ini."-1 day");			
			if($fecha_ini < "2015-03-28" ){
				//$objResponse->script('console.debug("fecha_ini < 2015-03-28");');
				//$query="SELECT max(id_pos) from posiciones20150328 where fecha>='".date("Y-m-d",$ayer)." 23:59:00' and fecha<='$fecha_ini';";
				//$ultimas=mysql_query($query);					
				//$ultima=mysql_fetch_array($ultimas);						
				$hoy_u=mysql_query("SELECT max(id) from id_pos20150328 where fechahora<'$fecha_ini' and fechahora >'2015-01-01 23:59:18'  ");
				$p1=mysql_fetch_array($hoy_u);				
				$hoy_u2=mysql_query("SELECT max(id_pos) from posiciones20150328");
				$p2=mysql_fetch_array($hoy_u2);						
				$max_pos='';			
				
				if($p1[0]>0){
					$max_pos=" p.id_pos BETWEEN $p1[0] and $p2[0] and";
				}
				$datos_rec="SELECT p.fecha,p.num_veh,p.velocidad,p.mensaje,p.t_mensaje,p.entradas,
				(p.lat/3600/16),((p.long & 8388607)/3600/12*-1),v.id_veh,v.tipoveh,p.id_pos,p.odometro,p.id_tipo,			
				pm.descripcion,cm.mensaje /*,v.id_sistema,".$sess->get('Idu').",$veh*/ 			 
				from posiciones20150328 p 
				left outer join vehiculos v on (p.num_veh = v.num_veh) 
				left outer join postmens pm on (pm.t_mensaje = p.t_mensaje)
				left outer join c_mensajes cm on (cm.id_mensaje = p.entradas and cm.id_empresa = $id_emp and p.t_mensaje=3) 								
				where $max_pos p.num_veh like '%$veh%' and p.fecha between '$fecha_ini' and '$fecha_fin' "; 				
			}	
			if($fecha_ini > "2015-03-28"){
				//$objResponse->script('console.debug("fecha_ini > 2017-01-28");');
				//$query="SELECT max(id_pos) as max_idpos from posiciones where fecha>='".date("Y-m-d",$ayer)." 23:59:00' and fecha<='$fecha_ini'";	
				//echo "||"."SELECT max(id_pos) as max_idpos from posiciones where fecha>='".date("Y-m-d",$ayer)." 23:59:00'  and fecha<='$fecha_ini'".""	
				//$ultimas=mysql_query($query);					
				//$ultima=mysql_fetch_array($ultimas);						
				$hoy_u=mysql_query("SELECT max(id) from id_pos where fechahora<'$fecha_ini' and fechahora >'2016-01-26 23:59:18'  ");
				//echo "||"."SELECT max(id) from id_pos where fechahora<'$fecha_ini' and fechahora >'2016-01-26 23:59:18'  "	
				$p1=mysql_fetch_array($hoy_u);	
				$hoy_u2=mysql_query("SELECT max(id_pos) from posiciones");
				//echo "||"."SELECT max(id_pos) from posiciones"	
				$p2=mysql_fetch_array($hoy_u2);	
				$max_pos='';
				if($p1[0]>0){
					$max_pos=" p.id_pos BETWEEN $p1[0] and $p2[0] and";
				}
				$datos_rec =
					"SELECT p.fecha,p.num_veh,p.VELOCIDAD,p.mensaje,p.t_mensaje,p.entradas,
					(p.lat/3600/16),((p.long & 8388607)/3600/12*-1),v.id_veh,v.tipoveh,p.id_pos,p.odometro,p.id_tipo,
					pm.descripcion,cm.mensaje,v.id_sistema,S.tipo_equipo/*,te.descripcion*/
					from sepromex.posiciones p
					left outer join sepromex.vehiculos v on (p.num_veh = v.num_veh)
					left outer join sepromex.sistemas S on (S.id_sistema = v.id_sistema)
					/*left outer join sepromex.tipo_equipo te on (te.id_tipo_equipo = S.tipo_equipo)*/
					left outer join sepromex.postmens pm on (pm.t_mensaje = p.t_mensaje)
					left outer join sepromex.c_mensajes cm on (cm.id_mensaje = p.entradas and cm.id_empresa =15 and p.t_mensaje=3)
					where $max_pos p.num_veh like '%$veh%' and p.fecha BETWEEN '$fecha_ini' and '$fecha_fin' ";
			}			

			$entradas="";
			if($pos_obs=='on' && $pos_auto=='on'){
				$datos_rec.=" and p.obsoleto in(0,1)";
			}
			else{
				if($pos_obs=='on'){
					$datos_rec.=" and p.obsoleto=1";
				}
			}
			if($pos_auto=='on' && $sol_pos=='on'){
				$datos_rec.=" and p.id_tipo in(1,2)";
			}
			else{
				if($sol_pos=='on'){
					if($valorForm['id_mensajes']!='' ){
						$datos_rec.=" and ((p.t_mensaje = 1 and id_tipo = 2) or (p.t_mensaje =3))";
					}
				}
				else{
					if($valorForm['id_mensajes']!='' && $pos_auto=='on' ){
						$datos_rec.=" and p.t_mensaje in(1,3)";
					}
					else{
						if($valorForm['id_mensajes']!=''){
							$datos_rec.=" and p.t_mensaje in(3)";
						}
					}
				}
			}
			if($valorForm['id_mensajes']==''){
				$datos_rec.="";
			}else{
				if($pos_obs=='on' || $pos_auto=='on'){
					$entradas='0,';
				}
				$datos_rec.=" and p.entradas in($entradas".join(",",$mensajes).")";
			}
			if($vel_men!='' || $vel_may!=''){
				if($vel_men!='' && $vel_may==0)
					$datos_rec .= "and p.velocidad <= '$vel_men' ";
					
				if($vel_men=='' &&  $vel_may!='')
					$datos_rec .= "and p.velocidad >= '$vel_may' ";
					
				if($vel_men!='' && $vel_may!=''){
					if($vel_men < $vel_may){
						$datos_rec .= "and p.velocidad NOT between '$vel_men' and '$vel_may' ";
					}else{
						$datos_rec .= "and p.velocidad between '$vel_may' and '$vel_men' ";					
					}
				}
			}
			$datos_rec .= " order by p.fecha,p.id_pos asc ";
		}else{
			$objResponse->alert("Favor de dar un rango de fechas");
			$objResponse->assign("cont_reporte","innerHTML",'');
			$objResponse->script("$('input[class*=\"desactivado\"]').removeAttr( 'disabled', 'disabled');");
			$objResponse->script("$('input[class*=\"desactivado\"]').removeClass('desactivado');");
			$objResponse->script("$('input[value*=\"Obtener reporte\"]').addClass('agregar1');");
			return $objResponse; 
		}	

		
		//echo "||".$datos_rec;
		//exit();

		$objResponse->assign("form_pdf","innerHTML","<textarea name='con_pdf' >$datos_rec</textarea>
		<input type='hidden' name='idsistema' value='$rowsist[0]'/>
		<input type='hidden' name='num_veh' value='$veh'/>
		<input type='hidden' name='tipo' value='recorrido'>");
		$objResponse->assign("form_xls","innerHTML","<textarea name='con_xls' >$datos_rec</textarea>
		<input type='hidden' name='idsistema' value='$rowsist[0]'/>
		<input type='hidden' name='num_veh' value='$veh'/>
		<input type='hidden' name='tipo' value='recorrido'>");
		
		$resp = mysql_query($datos_rec,$conec);
		
		$num_reg = mysql_num_rows($resp);
		//$objResponse->script('console.debug("Se encontraron '.$num_reg.' ubicaciones para el vehiculo en el intervalo seleccionado")');
		if($num_reg > 0){
			if($num_reg<720){
				$s = 0;
				if($odometro=='on'){
					$cabe = "<th width='80'>Odometro</th>";
					$s = 1;
				}		 		
				$dsn_reco="<div style='overflow-x:auto;overflow-y:auto;width:1127px;height:200px;position:absolute;left:15px;'><table id='box-table-a1' width='1127px'>";
				$n=0;
				$lat_actual=0;
				$lat_pasada=0;
				$lon_actual=0;
				$lon_pasada=0;
				$a_actual=0;
				$a_pasada=0;
				$dis_cum=0;
				$id_pos=0;
				$la_anterior=0;
				$lo_anterior=0;
				$odoanterior=0;
				$motorprendido = 'off' ;
				//exit("ssi");
				//$objResponse->script('console.debug("Procesando puntos de ubicacion...")');
			 	while($row = mysql_fetch_array($resp)){
					if($veh == $row[1]){
							if((int)$row[6]!= 0 || (int)$row[7] != 0){
								if($i == 0 && $reg == 0 ){
									$latIni = $row[6]; 
									$lonIni = $row[7]; 
									$tipo_veh=$row[9];
									
								}								
								$latFin = $row[6];
								$lonFin = $row[7];
								
								if($row[5]==248){
								  $motorprendido = 'on' ;
								}
								if($row[5]==249){
								  $motorprendido = 'off';
								}
								
								if($acumular=='on' && $motorprendido=='on'){
									$dis_cum = $dis_cum + ( $row[11] - $odoanterior );
									$la_anterior=$row[6];
									$lo_anterior=$row[7];							
								}
								$odoanterior=$row[11];	
								if($row[4]==3){
									$a_actual=$row[5];
									$lat_actual=number_format($row[6],3,'.','');
									$lon_actual=number_format($row[7],3,'.','');
									if(preg_match("/".$row[5]."/",$imagenes)){
										$tipo_alartma=mysql_query("SELECT mensaje from c_mensajes
										where id_mensaje=".$row[5]." 
										and id_empresa=15",$conec);
										//echo "||".$tipo_alartma;
										if(mysql_num_rows($tipo_alartma)>0){
											if(($lat_actual!=$lat_pasada && $lon_actual!=$lon_pasada) || $a_actual!=$a_pasada){
												$lat_pasada=number_format($row[6],3,'.','');
												$lon_pasada=number_format($row[7],3,'.','');
												$a_pasada=$row[5];
												$imagen_alarma="";
												$a_desc=mysql_fetch_array($tipo_alartma);
												if(preg_match("/apagado/i",$a_desc[0])){
													$imagen_alarma="apagado";
												}
												if(preg_match("/encendido/i",$a_desc[0])){
													$imagen_alarma="encendido";
												}
												if(preg_match("/panico/i",$a_desc[0])){
													$imagen_alarma="panico";
												}
												if(preg_match("/sabotaje/i",$a_desc[0])){
													$imagen_alarma="sabotaje";
												}
												if(preg_match("/bloqueador/i",$a_desc[0])){
													$imagen_alarma="sabotaje";
												}
												if(preg_match("/falla/i",$a_desc[0])){
													$imagen_alarma="falla_mecanica";
												}
												if(preg_match("/SIN VOLTAJE/i",$a_desc[0])){
													$imagen_alarma="sin_bateria";
												}
												if(preg_match("/RPT/i",$a_desc[0])){
													$imagen_alarma="online";
												}
												if(preg_match("/velocidad/i",$a_desc[0])){
													$imagen_alarma="velocidad";
												}
												//imagenes recorrido eventos
												$objResponse->call("alertas_recorrido",$row[6],$row[7],$imagen_alarma,$i);
											}
										}
									}
								}

								if($odometro=='on' ){
									$separa = substr( $row[16] ,0,1);
									if($separa=="U"){
										$cuerpo = "<td width='100' class='fech$i'>".number_format($row[11]/1000). Km."</td>";
									}else{
										$cuerpo = "<td width='100' class='fech$i'>".number_format($row[11]). Km."</td>";
									}
								}
								if($row[4]==0 )
									$row[13] = "Perdida de GPS";
								$objResponse->call("crea_recorrido2", $row[6],$row[7],$row[9],$pag,$i);
								if($row[2]==''){$row[2]= 0;}
								if(($row[4]==1 || $row[4]==3) && $row[12]==1){
									$rep_normal=mysql_query("SELECT descripcion from sepromex.postmens where t_mensaje=".$row[4],$conec);
									//echo "||".$rep_normal;
									$post_mens=mysql_fetch_array($rep_normal);
								}
								else{
									$rep_normal=mysql_query("SELECT descripcion from sepromex.postipo where id_tipo=".$row[12],$conec);
									//echo "||".$rep_normal;
									$post_mens=mysql_fetch_array($rep_normal);
								}
								$dsn_reco .="
								<tr class='fuente_once'>
									<td width='70' class='fech$i'>$row[10]&nbsp;&nbsp;&nbsp;</td>
									<td width='100' class='fech$i'>
										<a style='font-weight:normal;color:#002BEC;' 
										onclick='verVehiculo($row[6],$row[7],$row[9],0,\"fech$i\");pause($i);'  
										href='javascript:void(null);' class='fech$i'>".conv_fecha($row[0])."</a>
										<input type='hidden' id='fech$i' value='$row[6]@$row[7]@$row[9]'>
									</td>
									<td width='120' class='fech$i'>".htmlentities($post_mens[0])."</td>
									<td width='50' class='fech$i'>".htmlentities($row[2])."</td>";
								$mensaje = htmlentities($row[14]);
								
								if($row[5]==235 || $row[5]==236){
									$mensaje="";
								}
								$_vehiculo = $row[8];
								if( $row[4] == 3 && $mensaje == "" )
								{
									$result = mysql_query("SELECT mensaje 
									FROM c_mensajes where id_mensaje = $row[5] 
									and id_empresa = 15 group by mensaje",$conec);
									//echo "||"."SELECT mensaje FROM c_mensajes where id_mensaje = $row[5] and id_empresa = 15 group by mensaje";
									$row_m = mysql_fetch_array($result);
									$mensaje = utf8_decode($row_m[0]);
									if($row[5]==235 || $row[5]==236){
										$mensaje="";
									}
								}
								
								$calles=otro_server($row[6],$row[7]);						
								if($calles=='error')
								{
									$calles=otro_server($row[6],$row[7]);
								}
								if($calles=='error'){
									$calles=otro_server($row[6],$row[7]);
								}
								if($calles=='error'){
									$calles=otro_server($row[6],$row[7]);
								}
								if($dis_cum!=0 || $acumular=='on'){								
									$acum="<td width='100' class='fech$i'>".number_format($dis_cum/1000). Kms."</td>";		
								}

								$dsn_reco .="
									$cuerpo
									$acum
									<td width='200' class='fech$i'>".$mensaje." ".$row[3]."</td>
									<td width='330' class='fech$i'>".(($calles))."</td></tr>";
								$calle = "";
								$i++;
							}
					}
				}
				if($reg == 0){
					//bandera verde A
					$objResponse->call("StartPoint", $latIni,$lonIni);
				}
				//bandera roja B
				$objResponse->call("EndPoint", $latFin,$lonFin);
				if($geos==0)$objResponse->script("xajax_mandar_geocercas($veh)");
				if($num_reg){
					$extra="<td></td>";
					if($acumular=='on'){
						$extra.="<td></td>";
						$km_acum="<th width='100'>Acumulado</th>";
					}
					$paginacion = "<table id='box-table-a1' width='1127px' border='0'>";	
					$paginacion .= "
					<tr>
						<td colspan='3'>
							<div align='left' style='display:inline;'>
								<img style='cursor:pointer;' src='img2/pdf.png' border='0' width='20' height='20' onclick='form_pdf.submit();xajax_auditabilidad(69);' title='Exportar PDF'/>
								<img style='cursor:pointer;' src='img2/xls.png' border='0' width='20' height='20' onclick='form_xls.submit();xajax_auditabilidad(68);' title='Exportar XLS'/>
							</div>
						</td>
						<td colspan='1'></td>
						<td colspan='2'>
						<div id='reproductor' align='center'></div>
						</td>
						<td colspan='1'></td>
						$extra
					</tr>
					<tr>";
					$paginacion .= "
						<th width='50'>ID POS</th>
						<th width='110'>Fecha</th>
						<th width='80'>Evento</th>
						<th width='50'>Vel.Km</th>
						$cabe
						$km_acum
						<th width='200'>Mensaje</th>
						<th width='330'>Calles</th></tr>";
				}
				
				$dsn_reco .= "</table></div>";
				$panelInfo .= "";
				$panelInfo .= "<table width='1127px' id='box-table-a1'>
					<tr>
						<td><b>Vehículo:</b> ".htmlentities(strtoupper($_vehiculo))."</td>
						<td></td>
						<td align='right' style='padding-right:20px;' id='vel_rep'></td>
					</tr>";
				$botones_dw="<div align='left' style='display:inline;'>
								<img style='cursor:pointer;' src='img2/pdf.png' border='0' width='20' height='20' onclick='form_pdf.submit();xajax_auditabilidad(69);;' title='Exportar PDF'/>
								<img style='cursor:pointer;' src='img2/xls.png' border='0' width='20' height='20' onclick='form_xls.submit();xajax_auditabilidad(68);' title='Exportar XLS'/>
							</div>";
				$panelInfo.=$paginacion;
				/*
				$local=mysql_connect("160.16.18.8","supervisor",'supervisor');
				mysql_select_db("sepromex", $local);
				*/
				$server="10.0.1.3";
				$local = mysql_connect($server,"egweb","53g53pr0")  or die ("¡No hay conexión con el servidor! <br />" . mysql_error());
				mysql_select_db("sepromex",$local);
				mysql_query("UPDATE server_gestion set fin='".date("Y-m-d H:i:s")."' where id_query=$id_query",$local);
				$objResponse->assign("cont_reporte","innerHTML",$dsn_reco);
				$objResponse->assign("panelinfo","innerHTML",$panelInfo);			
				$objResponse->assign("panel","innerHTML",$dsn_bot);
				$objResponse->script("$('#cont_reporte').show();");
				$objResponse->script("mostrarLinea($pag);");
				$objResponse->script("inicial();");
			}
			else 
			{   // mas de 720 entradas (ubicaciones)
				$id=mysql_fetch_array($resp);
				$x=$id[10];
				$objResponse->script("tray($x,$num_reg)");				
				$sess->set('total_reg',0);
				$sess->set('encabezado',0);
				$sess->set('start_lat',0);
				$sess->set('start_lon',0);
				$sess->set('end_lat',0);
				$sess->set('end_lon',0);
				$sess->set("num_reg",0);
				$sess->set("dis_cum",0);
				$sess->set("geocercas",0);
				$objResponse->assign("cont_reporte","innerHTML","Iniciando proceso multi reporte mas de 720 posiciones");
			}
		} else {
			$objResponse->alert("Reporte Recorrido...No hay registros para el rango de fechas que usted proporcionó");
			$objResponse->assign("cont_reporte","innerHTML","");
		}
		$objResponse->script("$('input[class*=\"desactivado\"]').removeAttr( 'disabled', 'disabled');");
		$objResponse->script("$('input[class*=\"desactivado\"]').removeClass('desactivado');");
		$objResponse->script("$('input[value*=\"Obtener reporte\"]').addClass('agregar1');");
		return $objResponse;  
    }

    return $objResponse;
}
function recorrido_masivo($valorForm,$id_pos,$total){
	$dsn_reco="";
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$consulta = "INSERT into auditabilidad values (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',21,
	'Obtener reporte de recorrido',13,".$sess->get('Ide').",'".get_real_ip()."')";
	mysql_query($consulta);
	$fecha_ini = $valorForm['fecha_ini'];
	$fecha_fin = $valorForm['fecha_fin'];		
	$vel_may = $valorForm['vel_may'];
	$vel_men = $valorForm['vel_men'];				
	$numero_usr = $valorForm['n_usr'];
	$id_usuario = $valorForm['id_usr'];			
	$id_empresa = $valorForm['id_emp'];
	$pos_obs = $valorForm['pos_obs'];
	$pos_auto = $valorForm['pos_auto'];
	$sol_pos = $valorForm['sol_pos'];
	$odometro = $valorForm['odometro'];
	$imagenes = $valorForm['id_imagenes'];
	$tipo_reporte = $valorForm['tipo_rep'];
	$acumular=$valorForm['acumulado'];
	$encendido="";
	$mensajes = explode(";",$valorForm['id_mensajes']);
	$datos_rec ="";												
	$i = 0;
	foreach ($valorForm['vehiculos'] as $veh);
	$cad_veh = "SELECT id_sistema,id_empresa from vehiculos where num_veh = $veh";
	$res_cad = mysql_query($cad_veh);
	$rowsist = mysql_fetch_array($res_cad);
	$cad_msj = "SELECT id_empresa from c_mensajes where id_empresa = $rowsist[1]";
	$res_msj = mysql_query($cad_msj);
	if(mysql_num_rows($res_msj)){
		$id_emp = $rowsist[1];
	}
	else{
		$id_emp = 15;
	}
	require_once("librerias/conexion.php");	

	
	$d_hoy=explode(" ",$fecha_fin);
	if(date("Y-m-d")==$d_hoy[0]){
		$hoy_u2=mysql_query("SELECT max(id_pos) from posiciones");
		$p2=mysql_fetch_array($hoy_u2);
	}
	else{
		$dia_m=strtotime($fecha_fin."+ 1 day");
		if(date("Y-m-d")!=date("Y-m-d",$dia_m)){
			$manana=mysql_query("SELECT max(id) from id_pos where fechahora<='".date("Y-m-d H:i:s",$dia_m)."'",$conec);
			//$objResponse->alert("SELECT max(id) from id_pos where fechahora<='".date("Y-m-d H:i:s",$dia_m)."'");
		}
		else{
			$manana=mysql_query("SELECT max(id_pos) from posiciones",$conec);
		}
		$p2=mysql_fetch_array($manana);
	}
	$hoy_u=mysql_query("SELECT max(id) from id_pos where fechahora<'$fecha_ini'",$conec);
	$p1=mysql_fetch_array($hoy_u);
	if($id_pos==0 || $id_pos=='')
	{
		$id_pos=$p1[0];
	}
	$max_pos=" p.id_pos>$id_pos and";
	if($p1[0]>0)
	{
		/*  esto hay que cambiarlo, para que se adapte a lo "nuevo que hicieron" */
		$max_pos=" p.id_pos>$p1[0] and p.id_pos<$p2[0] and";//esta condicion hay que cambiarla*/
	}	
	//cm.mensaje,v.id_sistema,S.TIPO_EQUIPO,te.descripcion/*,,".$sess->get('Idu').",$veh*/
	$datos_rec =
	"SELECT p.fecha,p.NUM_VEH,p.velocidad,p.MENSAJE,p.t_mensaje,p.entradas,
	(p.lat/3600/16),((p.long & 8388607)/3600/12*-1),v.id_veh,v.tipoveh,p.id_pos,p.odometro,p.id_tipo,
	cm.mensaje,v.id_sistema,S.TIPO_EQUIPO/*,te.descripcion*/
	from sepromex.posiciones p
	left outer join sepromex.vehiculos v on (p.num_veh = v.num_veh)
	left outer join sepromex.sistemas S on (S.id_sistema = v.id_sistema)
	/*left outer join sepromex.tipo_equipo te on (te.id_tipo_equipo = S.tipo_equipo)*/
	left outer join sepromex.postmens pm on (pm.t_mensaje = p.t_mensaje)
	left outer join sepromex.c_mensajes cm on (cm.id_mensaje = p.entradas and cm.id_empresa =15 and p.t_mensaje=3)
	where $max_pos  p.num_veh like '%$veh%' and p.fecha between '$fecha_ini' and '$fecha_fin' ";

	/*
	$datos_rec="SELECT p.fecha,p.num_veh,p.velocidad,p.mensaje,p.t_mensaje,p.entradas,
	(p.lat/3600/16),((p.long & 8388607)/3600/12*-1),v.id_veh,v.tipoveh,p.id_pos,p.odometro,p.id_tipo,
	cm.mensaje
	from posiciones p 
	left outer join vehiculos v on (p.num_veh = v.num_veh) 
	left outer join c_mensajes cm on (cm.id_mensaje = p.entradas and cm.id_empresa = $id_emp and p.t_mensaje=3) 
	where p.num_veh = '$veh' and p.fecha between '$fecha_ini' and '$fecha_fin'
	and p.id_pos>$id_pos and p.id_pos<".$p2[0];*/


	$entradas="";
	if($pos_obs=='on' && $pos_auto=='on'){
		$datos_rec.=" and p.obsoleto in(0,1)";
	}
	else{
		if($pos_obs=='on'){
			$datos_rec.=" and p.obsoleto=1";
		}
	}
	if($pos_auto=='on' && $sol_pos=='on'){
		$datos_rec.=" and p.id_tipo in(1,2)";
	}
	else{
		if($sol_pos=='on'){
			if($valorForm['id_mensajes']!='' ){
				$datos_rec.=" and ((p.t_mensaje = 1 and id_tipo = 2)or(p.t_mensaje =3))";
			}
		}
		else{
			if($valorForm['id_mensajes']!='' && $pos_auto=='on' ){
				$datos_rec.=" and p.t_mensaje in(1,3)";
			}
			else{
				if($valorForm['id_mensajes']!=''){
					$datos_rec.=" and p.t_mensaje in(3)";
				}
			}
		}
	}
	if($valorForm['id_mensajes']==''){
		$datos_rec.="";
	}
	else{
		if($pos_obs=='on' || $pos_auto=='on'){
			$entradas='0,';
		}
		//puede o no puede estar en lo siguiente
		$datos_rec.=" and p.entradas in($entradas".join(",",$mensajes).")";
	}
	if($vel_men!='' || $vel_may!=''){
		if($vel_men!='' && $vel_may==0)
			$datos_rec .= "and p.velocidad <= '$vel_men' ";
			
		if($vel_men=='' &&  $vel_may!='')
			$datos_rec .= "and p.velocidad >= '$vel_may' ";
			
		if($vel_men!='' && $vel_may!='')
		{
			if($vel_men < $vel_may)
			{
				$datos_rec .= "and p.velocidad NOT between '$vel_men' and '$vel_may' ";
			}
			else
				$datos_rec .= "and p.velocidad between '$vel_may' and '$vel_men' ";					
		}
	}
	$datos_rec .= " order by p.id_pos,p.fecha asc ";	
	
	//echo $datos_rec." limit 400"."<br><br><br>";
	//exit();
	
	if($sess->get("num_reg") == 0){ //si es la primera vez que entra
		$objResponse->assign("form_pdf","innerHTML","<textarea name='con_pdf' >$datos_rec</textarea>
		<input type='hidden' name='idsistema' value='$rowsist[0]'/>
		<input type='hidden' name='num_veh' value='$veh'/>
		<input type='hidden' name='tipo' value='recorrido'>");
		$objResponse->assign("form_xls","innerHTML","<textarea name='con_xls' >$datos_rec</textarea>
		<input type='hidden' name='idsistema' value='$rowsist[0]'/>
		<input type='hidden' name='num_veh' value='$veh'/>
		<input type='hidden' name='tipo' value='recorrido'>");
		$resp = mysql_query($datos_rec." limit 400");
		//$resp = mysql_query($datos_rec);
		$num_reg = mysql_num_rows($resp);
		$sess->set("num_reg",$num_reg);
			
	}else{
		$num_reg = $sess->get("num_reg");
		$resp = mysql_query($datos_rec." limit 700");
		//$resp = mysql_query($datos_rec);
	}
		
	$s = 0;
	
	if($rowsist[0]==20 || $rowsist[0]== 34 || $odometro=='on')
	{
		$cabe = "<th width='100'>Odometro</th>";
		$s = 1;
	}
	$dsn_reco="";
	
	
	if($sess->get('encabezado')==0)
	{
	$dsn_reco .= "
		<div style='overflow-x:auto;overflow-y:auto;width:1127px;height:200px;position:absolute;left:15px;' id='multitabla'>
		<table id='box-table-a1' width='1127px'>";	
	}
	$dsn_reco .= "<table id='box-table-a1' width='1127px'>";
	
	$n=0;
	//$motorprendido=ultimo_encendido($id_pos,$fecha_ini,$veh);
	$la_anterior=0;
	$lo_anterior=0;
	$odo_anterior=0;
	
	while($row= mysql_fetch_array($resp))
	{
		if($veh == $row[1]){ //ddd
			if((int)$row[6]!= 0 || (int)$row[7] != 0)
			{
				if($sess->get('encabezado')==0){
					$latIni = $row[6]; 
					$lonIni = $row[7]; 
					$tipo_veh=$row[9];
					$sess->set("start_lat",$latIni);
					$sess->set("start_lon",$lonIni);
					$sess->set("incremental",$i);
				}
				$i=$sess->get("incremental");
				$latFin = $row[6];
				$lonFin = $row[7];
				$sess->set("end_lat",$latFin);
				$sess->set("end_lon",$lonFin);
				
				if($row[5]==248){
				  $motorprendido = 'on' ;
				}
				if($row[5]==249){
				  $motorprendido = 'off';
				}
				
				if($acumular=='on' && $motorprendido=='on')
				{
					//$objResponse->alert("la anterior: ".$la_anterior." Lo anterior: ".$lo_anterior." la actual: ".$row[6]." lo actual: ".$row[7]);										
					$dis_cum= $sess->get("dis_cum")+($row[11]-$odoanterior);			
					$sess->set("dis_cum",$dis_cum);							
					/*if($la_anterior!=0 && $lo_anterior!=0)
					{
						$dis_cum=$sess->get("dis_cum")+acumular($la_anterior, $lo_anterior, $row[6], $row[7]);				
						$sess->set("dis_cum",$dis_cum);

					}*/
					$la_anterior=$row[6];
					$lo_anterior=$row[7];				
				}
				$odo_anterior=$row[11];
				if($row[4]==3){		
					$a_actual=$row[5];
					$lat_actual=number_format($row[6],3,'.','');
					$lon_actual=number_format($row[7],3,'.','');
					if(preg_match("/".$row[5]."/",$imagenes))
					{
						//$objResponse->alert($row[5]."->".$imagenes);
						$tipo_alartma=mysql_query("SELECT mensaje from c_mensajes
						where id_mensaje=".$row[5]." 
						and id_empresa=15");
						if(mysql_num_rows($tipo_alartma)>0)
						{
							//buscamos el tipo de alarma que es
							if($lat_actual!=$lat_pasada && $lon_actual!=$lon_pasada )
							{
								$lat_pasada=number_format($row[6],3,'.','');
								$lon_pasada=number_format($row[7],3,'.','');
								$a_pasada=$row[5];
								$imagen_alarma="";
								$a_desc=mysql_fetch_array($tipo_alartma);	
								//$objResponse->alert($row[5]."==".$imagenes);
								if(preg_match("/apagado/i",$a_desc[0])){
									$imagen_alarma="apagado";
								}
								if(preg_match("/encendido/i",$a_desc[0])){
									$imagen_alarma="encendido";
								}
								if(preg_match("/panico/i",$a_desc[0])){
									$imagen_alarma="panico";
								}
								if(preg_match("/sabotaje/i",$a_desc[0])){
									$imagen_alarma="sabotaje";
								}
								if(preg_match("/bloqueador/i",$a_desc[0])){
									$imagen_alarma="sabotaje";
								}
								if(preg_match("/falla/i",$a_desc[0])){
									$imagen_alarma="falla_mecanica";
								}
								if(preg_match("/SIN VOLTAJE/i",$a_desc[0])){
									$imagen_alarma="sin_bateria";
								}
								if(preg_match("/RPT/i",$a_desc[0])){
									$imagen_alarma="online";
								}
								if(preg_match("/velocidad/i",$a_desc[0])){
									$imagen_alarma="velocidad";
								}
								//funcion para las marcas de alertas
								$objResponse->call("alertas_recorrido",$row[6],$row[7],$imagen_alarma,$i);
							}
						}
					}
				}
				if($rowsist[0]==20 || $rowsist[0]== 34 || $odometro=='on' ){
					$separa = substr( $row[10] ,0,0);
					$objResponse->script('console.log("'.$separa.'")');
					if($separa=="U"){
						//$cuerpo = "<td width='100'>"./*number_format($row[11],0,'',','*/$row[11]/1000.0."</td>";
						$cuerpo = "<td width='100'>".number_format($row[11]/1000,2,'.',',')."</td>";
					}

					else
					{
						$cuerpo = "<td width='100'>".number_format($row[11],2,'.',',')."$separa </td>";					
					}							
					
				}
				if($row[4]==0 ){
					$row[13] = "Perdida de GPS";
				}
				$objResponse->call("crea_recorrido", $row[6],$row[7],$row[9],$pag);

				if($row[2]==''){$row[2]= 0;}
				if(($row[4]==1 || $row[4]==3) && $row[12]==1){//reporte normal periodico y mensajes por clave
					$rep_normal=mysql_query("SELECT descripcion from sepromex.postmens where t_mensaje=".$row[4]);
					$post_mens=mysql_fetch_array($rep_normal);
				}
				else{
					$rep_normal=mysql_query("SELECT descripcion from sepromex.postipo where id_tipo=".$row[12]);
					$post_mens=mysql_fetch_array($rep_normal);
				}
				
				$dsn_reco .="<tr class='fuente_once'><td width='70'>$row[10]&nbsp;&nbsp;&nbsp;</td><td width='100' >
				<a style='font-weight:normal;color:#002BEC;' onclick='verVehiculo($row[6],$row[7],$row[9],0,\"fech$i\");pause($i);'  
				href='javascript:void(null);' class='fech$i'";
				$dsn_reco .=">".conv_fecha($row[0])."</a><input type='hidden' id='fech$i' value='$row[6]@$row[7]@$row[9]'></td>";
				$dsn_reco .="<td width='150'>".htmlentities($post_mens[0])."</td>";
				$dsn_reco .="<td width='50'>".htmlentities($row[2]);
				$mensaje = htmlentities($row[13]);
				//$mensaje = htmlentities($row[14]);
				
				if($row[5]==235 || $row[5]==236){
					$mensaje="";
				}
				$_vehiculo = $row[8];
				if( $row[4] == 3 && $mensaje == "" )
				{
					$result = mysql_query("SELECT mensaje FROM c_mensajes where id_mensaje = $row[5] and id_empresa = 15 group by mensaje");
					$row_m = mysql_fetch_array($result);
					$mensaje = utf8_decode($row_m[0]);
					if($row[5]==235 || $row[5]==236){
						$mensaje="";
					}
				}

				$mensaje = htmlentities($row[14]);
				$_vehiculo = $row[8];
				if( $row[4] == 3 && $mensaje == "" )
				{
					$result = mysql_query("SELECT mensaje FROM c_mensajes where id_mensaje = $row[5] and id_empresa = 15 group by mensaje");
					$row_m = mysql_fetch_array($result);
					$mensaje = utf8_decode($row_m[0]);
				}
				/*
					segunda conexion
				*/
				$calles=otro_server($row[6],$row[7]);
				if($calles=='error'){
					$calles=otro_server($row[6],$row[7]);
				}
				if($calles=='error'){
					$calles=otro_server($row[6],$row[7]);
				}
				if($calles=='error'){
					$calles=otro_server($row[6],$row[7]);
				}
				if($sess->get("dis_cum")!=0 || $acumular=='on'){
					$acum="<td>".$sess->get("dis_cum")." Km</td>";
				}
				$dsn_reco .="
					$cuerpo
					$acum
					<td width='200'>".$mensaje." ".$row[3]."</td>
					<td width='330'>".$calles."</td></tr>";
				$calle = "";
				$i++;
				$sess->set("incremental",$i);
				$x=$row[10];
				//meter fecha ini a session
			}
			$contar=$sess->get('total_reg');
			$contar++;
			$sess->set('total_reg',$contar);
		} //ddd
	}

	if($sess->get("geocercas")==0)
	{
		$objResponse->script("xajax_mandar_geocercas($veh)");
		$sess->set("geocercas",1);
	}
	
	if($num_reg) 
	{
		if($sess->get('encabezado')==0)
		{
			$extra="<td></td>";
			if($acumular=='on'){
				$extra.="<td></td>";
				$km_acum="<th width='50'>Acumulado</th>";
			}
			$paginacion = "<table id='box-table-a1' width='1127px'>";	
			$paginacion .= "
			<tr>
				<td colspan='3'>
					<div align='left' style='display:inline;'>
						<img style='cursor:pointer;' src='img2/pdf.png' border='0' width='20' height='20' onclick='form_pdf.submit();xajax_auditabilidad(69);' title='Exportar PDF'/>
						<img style='cursor:pointer;' src='img2/xls.png' border='0' width='20' height='20' onclick='form_xls.submit();xajax_auditabilidad(68);' title='Exportar XLS'/>
					</div>
				</td>
				<td colspan='2'>
				<div id='reproductor' align='center'></div>
				</td>
				<td colspan='1'>
				</td>
				$extra
			</tr>
			<tr>";
			$paginacion .= "
			<th width='60'>ID POS</th>
			<th width='110'>Fecha</th>
			<th width='80'>Evento</th>
			<th width='50'>Vel.Km</th>
			$cabe
			$km_acum
			<th width='200'>Mensaje</th>
			<th width='330'>Calles</th></tr>";
		}
	}
	if($sess->get('encabezado')==1){
		$dsn_reco .= "</table></div>";
	}
	if($sess->get('encabezado')==0){
		$panelInfo .= "<table width='1127px' id='box-table-a1'>
		<tr>
			<td><b>Vehículo:</b> ".htmlentities(strtoupper($_vehiculo))."</td>
			<td></td>
			<td align='right' style='padding-right:20px;' id='vel_rep'></td>
		</tr>";
		$botones_dw="<div align='left' style='display:inline;'>
						<img style='cursor:pointer;' src='img2/pdf.png' border='0' width='20' height='20' onclick='form_pdf.submit();xajax_auditabilidad(69);' title='Exportar PDF'/>
						<img style='cursor:pointer;' src='img2/xls.png' border='0' width='20' height='20' onclick='form_xls.submit();xajax_auditabilidad(68);' title='Exportar XLS'/>
					</div>";
		$panelInfo.=$paginacion;
		$objResponse->assign("panelinfo","innerHTML",$panelInfo);
		$objResponse->assign("cont_reporte","innerHTML",$dsn_reco);
		$objResponse->script("$('#cont_reporte').show();");
	}
	else{
		$objResponse->append("multitabla","innerHTML",$dsn_reco);
	}
	
	$objResponse->script("mostrarLinea(1);");
	if($sess->get('encabezado')==0){
		$objResponse->script("inicial();");
	}
	if($total>$sess->get('total_reg')){
		$sess->set("encabezado",1);
		$objResponse->script("tray($x,$total)");
	}
	else{
		$objResponse->call("StartPoint", $sess->get('start_lat'),$sess->get('start_lon'));
		$objResponse->call("EndPoint", $sess->get('end_lat'),$sess->get('end_lon'));
	}
	$objResponse->script("$('input[class*=\"desactivado\"]').removeAttr( 'disabled', 'disabled');");
	$objResponse->script("$('input[class*=\"desactivado\"]').removeClass('desactivado');");
	$objResponse->script("$('input[value*=\"Obtener reporte\"]').addClass('agregar1');");
	return $objResponse;   
}
function sitio_cercano($ide,$lat,$lon){
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );	
	$cad_sit = "SELECT id_sitio,latitud,longitud,nombre from sitios where id_empresa=".$sess->get("Ide")." and activo=1";
	$res_sit = mysql_query($cad_sit);
	$num = mysql_num_rows($res_sit);
	if($res_sit){
	//if($num > 0){
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
			if($km < 10000){
				$ver[$i]= " a ".(int)$km." Mts de ".$row[3]." ";
			}
			$i++;
		}
		$cercano=min($ver);
		$resp=$cercano;
		return $resp;
	}else return NULL; 
}
/*
function otro_server($lat,$lon){
	//$conec2 = @mysql_connect("localhost","root","53g53pr0");
	//$conec2 = @mysql_connect("160.16.18.20:3305","usercruce","server");	
	//160.16.18.2
	//$conec2 = @mysql_connect("160.16.18.2:3306","usercruce","server");
	//$conec2 = @mysql_connect("172.16.18.225:3306","usercruce","server");
	$conec2 = @mysql_connect("sepromex.cloudapp.net:3306","usercruce","server");
	if(!$conec2){
		$error=mysql_error()."error conec2";
		return $error;
	}
	else{
	mysql_select_db("crucev2", $conec2);
	
	//	obtenemos el estado/municipio del vehiculo
	$estados="SELECT nombre
	FROM `municipios`
	where Crosses(area,GeomFromText('POINT($lat $lon)')) limit 1";
	$est=mysql_query($estados);
	$estado=mysql_fetch_array($est);
	$estado=htmlspecialchars($estado[0]);
	list($mun,$est)=explode("(",$estado);
	$estadoy=str_replace("(","",$est);
	$esta=str_replace(")","",$estadoy);
	$w=strtolower($mun);
	$y=strtolower($esta);
	$estado=ucwords($w)." (".ucwords($y).")";


	$procedure="SELECT
      cast(e.idesquina as char(20)) AS ID,
      ca.nombre as NOM,
      (GLength(LineString((PointFromWKB( POINT($lat, $lon))), (PointFromWKB(POINT(X(e.Coordenadas),Y(e.Coordenadas) ) ))))) * 100 AS DIST
    FROM esquinas e
      inner join calles_esquinas ce on e.idesquina=ce.idesquina
      inner join calles ca on ce.idcalle=ca.idcalle
    where MBRContains(GeomFromText(
                    concat('Polygon((',
                                      $lat+0.01001,' ',$lon-0.01001,', ',
                                      $lat+0.01001,' ',$lon+0.01001,', ',
                                      $lat-0.01001,' ',$lon-0.01001,', ',
                                      $lat-0.01001,' ',$lon+0.01001,', ',
                                      $lat+0.01001,' ',$lon-0.01001,'))')),coordenadas)
    ORDER BY DIST ASC limit 4;";
	//$call="CALL crucecalles($lat,$lon,false)";
	$r=mysql_query($procedure);
	$calle="";
	$distancia=99999;
	$dist=0;
	while($calles=mysql_fetch_array($r)){
		if($calles['DIST']<=$distancia){		
			if($dist<=1){
				if($calle!=''){
					if($calles['NOM'][0]=="I" || ($calles['NOM'][0].$calles['NOM'][1]=='Hi'))
					{
						$calle.=' e ';
					}
					else{
						$calle.=' y ';
					}
				}
				$calle.=$calles['NOM'];
				$dist++;
			}
			$distancia=$calles['DIST'];
		}
	}



	//		Calculamos el sitio cercano a nuestro vehiculo
	

	include("librerias/conexion.php");

	$options="";$sess =& patSession::singleton('egw', 'Native', $options );
	$ide=$sess->get("Ide");
	$cercano="";
	$cad_sit = "SELECT id_sitio,latitud,longitud,nombre from sitios where id_empresa = $ide and activo=1";

	$res_sit = mysql_query($cad_sit);
	$num = mysql_num_rows($res_sit);
	if($num > 0){

		$degtorad = 0.01745329; 
		$radtodeg = 57.29577951; 
		//$resp = "Aprox. a ";
		$distancia=1000;
		while($row = mysql_fetch_array($res_sit)){
			$dlong = ($lon - $row[2]); 
			$dvalue = (sin($lat * $degtorad) * sin($row[1] * $degtorad)) + (cos($lat * $degtorad) * cos($row[1] * $degtorad) * cos($dlong * $degtorad)); 
			$dd = acos($dvalue) * $radtodeg; 
			$km = ($dd * 111.302)*1000;
			$km = number_format($km,1,'.','');
			if($distancia>$km){
				$cercano= " a ".(int)$km." Mts de ".$row[3]." ,";
				$distancia=$km;
			}
		}
	}
	
	
	//return $calle."<br>".mysql_error()."<br>".nl2br($procedure);
	//return utf8_encode($calle).",".$estado;
	return ucwords($calle).",".ucwords($cercano).$estado;
	}
	mysql_close($conec2);
}
*/
/**
 * TODO Funcion con ERRORES, des-habilitada temporalmente.
**/
function otro_server_actual($lat,$lon){
	// Esta conexion no funciona
	//$conec2 = @mysql_connect("160.16.18.8","supevisor","supevisor");	
	//$conec2 = @mysql_connect("sepromex.cloudapp.net:3306","usercruce","server");
	//$server="10.0.0.2";
	//$conec2 = @mysql_connect("localhost","root","admin");
	$conec2 = @mysql_connect("10.0.2.13","usercruce","server");
	//$conec2 = @mysql_connect("localhost","usercruce","server");
	//$conec2 = mysql_connect($server,"usercruce","server");
	
	if(!$conec2){
		$error=mysql_error()."error";
		return $error;
	} else {
		mysql_select_db("crucev2", $conec2);
		/*
			obtenemos el estado/municipio del vehiculo
		*/
		$estados="SELECT nombre
		FROM `municipios`
		where Crosses(area,GeomFromText('POINT($lat $lon)')) ";
		$est=mysql_query($estados);
		$estado=mysql_fetch_array($est);
		$estado=htmlentities($estado[0]);
		list($mun,$est)=explode("(",$estado);
		$estadoy=str_replace("(","",$est);
		$esta=str_replace(")","",$estadoy);
		$w=strtolower($mun);
		$y=strtolower($esta);
		$estado=ucwords($w)." (".ucwords($y).")";
		/*
			obtenemos el municipio
		*/
		/*
		
		$municipios="SELECT nombre
			FROM `municipios`
			where MBRContains(area,GeomFromText('POINT($lat $lon)'))
			limit 1;";
		$mun=mysql_query($municipios);
		$municipio=mysql_fetch_array($mun);
		$municipio=utf8_decode($municipio[0])." ,";
		*/
		/*
			procedure nos proporciona el cruce de las calles
		*/
		$procedure="SELECT
	      cast(e.idesquina as char(20)) AS ID,
	      ca.nombre as NOM,
	      (GLength(LineString((PointFromWKB( POINT($lat, $lon))), (PointFromWKB(POINT(X(e.Coordenadas),Y(e.Coordenadas) ) ))))) * 100 AS DIST
	    FROM esquinas e
	      inner join calles_esquinas ce on e.idesquina=ce.idesquina
	      inner join calles ca on ce.idcalle=ca.idcalle
	    where MBRContains(GeomFromText(
	                    concat('Polygon((',
	                                      $lat+0.01001,' ',$lon-0.01001,', ',
	                                      $lat+0.01001,' ',$lon+0.01001,', ',
	                                      $lat-0.01001,' ',$lon-0.01001,', ',
	                                      $lat-0.01001,' ',$lon+0.01001,', ',
	                                      $lat+0.01001,' ',$lon-0.01001,'))')),coordenadas)
	    ORDER BY DIST ASC limit 4;";
		//$call="CALL crucecalles($lat,$lon,false)";
		$r=mysql_query($procedure);
		$calle="";
		$distancia=99999;
		$dist=0;
		while($calles=mysql_fetch_array($r)){
			if($calles['DIST']<=$distancia){		
				if($dist<=1){
					if($calle!=''){
						if($calles['NOM'][0]=="I" || ($calles['NOM'][0].$calles['NOM'][1]=='Hi'))
						{
							$calle.=' e ';
						}
						else{
							$calle.=' y ';
						}
					}
					$calle.=$calles['NOM'];
					$dist++;
				}
				$distancia=$calles['DIST'];
			}
		}
		
		/*
			Calculamos el sitio cercano a nuestro vehiculo
		*/
		//include("librerias/conexion.php");
		//$conec=@mysql_connect("160.16.18.8","supevisor","supevisor");
		//$conec=@mysql_connect("160.16.18.8","dev","S0ftware");
		//mysql_select_db("sepromex", $conec);
		//$options="";$sess =& patSession::singleton('egw', 'Native', $options );
			$server="10.0.1.3";
		$conec = mysql_connect($server,"egweb","53g53pr0")  or die ("¡No hay conexión con el servidor! <br />" . mysql_error());
		mysql_select_db("sepromex", $conec);
		$ide=$sess->get("Ide");
		$cad_sit = "SELECT id_sitio,latitud,longitud,nombre from sitios where id_empresa = $ide and activo=1";
		$res_sit = mysql_query($cad_sit);

		$num = mysql_num_rows($res_sit);
		$cercano="";
		$municipio="";
		if($num > 0){
			$degtorad = 0.01745329; 
			$radtodeg = 57.29577951; 
			//$resp = "Aprox. a ";
			$distancia=1000;//distancia a calcular entre los sitios mas cercanos
			while($row = mysql_fetch_array($res_sit)){
				$dlong = ($lon - $row[2]); 
				$dvalue = (sin($lat * $degtorad) * sin($row[1] * $degtorad)) + (cos($lat * $degtorad) * cos($row[1] * $degtorad) * cos($dlong * $degtorad)); 
				$dd = acos($dvalue) * $radtodeg; 
				$km = ($dd * 111.302)*1000;
				$km = number_format($km,1,'.','');
				if($distancia>$km){
					$cercano= " a ".(int)$km." Mts de ".$row[3]." ,";
					$distancia=$km;
				}
			}
		}
		
		//return $calle."<br>".mysql_error()."<br>".nl2br($procedure);
		return utf8_encode($calle).",".$cercano.$municipio." ".$estado;
	}
	mysql_close($conec2);	
}
function conv_fecha($f){
	$fecha = $f[8]."".$f[9]."/".$f[5]."".$f[6]."/".$f[2]."".$f[3]." ".$f[11]."".$f[12].":".$f[14]."".$f[15].":".$f[17]."".$f[18];
	return $fecha;
}
function acumular($lat1, $long1, $lat2, $long2){
	$earth = 6371; //km change accordingly
	//$earth = 3960; //miles
	
	//Point 1 cords
	$lat1 = deg2rad($lat1);
	$long1= deg2rad($long1);
	
	//Point 2 cords
	$lat2 = deg2rad($lat2);
	$long2= deg2rad($long2);
	
	//Haversine Formula
	$dlong=$long2-$long1;
	$dlat=$lat2-$lat1;
	
	$sinlat=sin($dlat/2);
	$sinlong=sin($dlong/2);
	
	$a=($sinlat*$sinlat)+cos($lat1)*cos($lat2)*($sinlong*$sinlong);
	
	$c=2*asin(min(1,sqrt($a)));
	
	//$d=round($earth*$c);
	$d=number_format($earth*$c,3,'.',',');
	
	return $d;
}
function rep_tiemposm($formu,$vehi){
	//$firephp= FirePhp::getInstance(true);
	$objResponse = new xajaxResponse();
	$fecha_i = $formu['fecha_ini2'];
	$fecha_f = $formu['fecha_fin2'];
	$mayor  = $formu['mayor'];
	$menor  = $formu['menor'];
	$tabla = 0;
	$dsn='';
	$hoy_u=mysql_query("SELECT max(id) from id_pos where fechahora<'$fecha_i'");
	$p1=mysql_fetch_array($hoy_u);
	//$objResponse->alert($vehi);
	if(count($vehi) == 0)
		$objResponse->alert("Seleccione por lo menos un vehículo");
	else//si selecciono almenos un vehiculo
	{
		if(date($fecha_i) < date($fecha_f))
	    {
			$options="";
			$sess =& patSession::singleton('egw', 'Native', $options );
			$consulta = "insert into auditabilidad values (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',23,
			'Tiempo sin movimineto',13,".$sess->get('Ide').",'".get_real_ip()."')";
			mysql_query($consulta,$conec);
			$dsn   = "<div style='position:absolute;top:10px;width:1127px;height:280px;overflow:auto;left:0px;z-index:10;'>
			<table border='0' width='1127px' id='box-table-a1'>";
			$dsn  .= "<tr>";
			$dsn  .= "<th width='200'>Fecha inicio</th>
			<th width='200'>Fecha fin</th>
			<th width='100'>Total s/m</th><th width='350'>Ubicación</th>
			<th>
				<a href='javascript:void(null)' onclick='form2_pdf.submit();xajax_auditabilidad(75);' title='Exportar PDF' >
				<img src='img2/pdf.png' border='0' width='20' height='20'/></a>
				<a href='javascript:void(null)' onclick='form2_xls.submit();xajax_auditabilidad(74);' title='Exportar XLS' >
				<img src='img2/xls.png' border='0' width='20' height='20'/></a>
			</th>
			</tr>";
			$actual='';
			for($k=0; $k<count($vehi); $k++)
			{
				
				$cad_pos="SELECT p.id_pos, p.num_veh, p.fecha, 
				(p.lat/3600/16),((p.long & 8388607)/3600/12*-1), 
				p.velocidad,v.id_veh,v.tipoveh
				FROM posiciones p
				left outer join vehiculos v on(v.num_veh = p.num_veh)
				where p.id_pos>$p1[0]
				AND  p.num_veh=".$vehi[$k]." 
				and p.fecha between '".$fecha_i."' and '".$fecha_f."'
				order by p.id_pos,p.num_veh,p.fecha asc";
				$n_row=0;
				require_once("librerias/conexion.php");//incluimos nuevamente la conexion debido al llamado de otro_servido por que interrumpe la conexion actual
				$res_pos = mysql_query($cad_pos);
				$i=0;
				$ii=0;
				$iii=0;
				if(mysql_num_rows($res_pos)>0){
					while($row = mysql_fetch_array($res_pos))
					{ 		
						if($i==0)
						{
							$dsn.= "<tr class='fuente_diez'><th colspan='5'>Vehículo $row[6]</th></tr>";
							$lat_cen = $row[3];
							$lon_cen = $row[4];
							$fecha_tmp = $row[2];
						}else
						{ 
							$resp = distDosPuntos($lat_cen,$lon_cen,$row[3],$row[4]);
							if((float)$resp <= 75) //menor 75
								$ii++;
							else //mayor 75
								$ii = 0;					
						}
						if($ii == 1)
						{ //inicia contador de registros < 75
							$fecha_ini = $fecha_tmp;
							$iii = 1;
						}
						if($ii == 0)
						{//reset contador < 75
							if($iii==1)
								$iii = 2;						
							$fecha_fin = $fecha_tmp;
						}
						/*if($n_row == ($i+1))
						{
							if($iii==1)
								$iii = 2;
							$fecha_fin = $row[2];
						}*/
						if($iii == 2 )
						{
							$tabla = 1;
							$j++;
							$tiempo = $formu['tmp'];
							if($tiempo=='hrs')
							{
								$difHrs = getFechadiferencia($fecha_fin, $fecha_ini, 'h');
								if((int)$difHrs > 0)
								{
									if($mayor == '' && $menor == '')
									{ //todo
										$dsn  .= "
										<tr class='fuente_diez'>
											<td width='200'>
												<a href='javascript:void(null);' onclick='muestra_posicion($lat_cen,$lon_cen,$row[7]);'>"
												.conv_fecha($fecha_ini)."</a>
											</td>
											<td width='200'>".conv_fecha($fecha_fin)."</td>
											<td width='100'>".(int)$difHrs." Hrs</td>
											<td width='350' colspan='2'>".otro_server($row[3],$row[4])."</td>
										</tr>";
									}
									if($menor == '' && $mayor != '' && $mayor <= (int)$difHrs)
									{ //todo
										$dsn  .= "
										<tr class='fuente_diez'>
											<td width='200'>
												<a href='javascript:void(null);' onclick='muestra_posicion($lat_cen,$lon_cen,$row[7]);'>"
												.conv_fecha($fecha_ini)."</a>
											</td>
											<td width='200'>".conv_fecha($fecha_fin)."</td>
											<td width='100'>".(int)$difHrs." Hrs</td>
											<td width='350' colspan='2'>".otro_server($row[3],$row[4])."</td>
										</tr>";
									}
									if($mayor == '' && $menor != '' && $menor >= (int)$difHrs)
									{ //todo
										$dsn  .= "
										<tr class='fuente_diez'>
											<td width='200'>
												<a href='javascript:void(null);' onclick='muestra_posicion($lat_cen,$lon_cen,$row[7]);'>".
												conv_fecha($fecha_ini)."</a>
											</td>
											<td width='200'>".conv_fecha($fecha_fin)."</td>
											<td width='100'>".(int)$difHrs." Hrs</td>
											<td width='350' colspan='2'>".otro_server($row[3],$row[4])."</td>
										</tr>";
									}
									if($mayor <= (int)$difHrs && $menor >= (int)$difHrs && $mayor != '' && $menor != '')
									{ //todo
										$dsn  .= "
										<tr class='fuente_diez'>
											<td width='200'>
												<a href='javascript:void(null);' onclick='muestra_posicion($lat_cen,$lon_cen,$row[7]);'>".
												conv_fecha($fecha_ini)."</a>
											</td>
											<td width='200'>".conv_fecha($fecha_fin)."</td>
											<td width='100'>".(int)$difHrs." Hrs</td>
											<td width='350' colspan='2'>".otro_server($row[3],$row[4])."</td>
										</tr>";
									}
								}
							}
							if($tiempo=='mnt')
							{
								$difMin = getFechadiferencia($fecha_fin, $fecha_ini, 'm');
								if((int)$difMin > 0)
								{
									if($mayor == '' && $menor == '')
									{ //todo
										$dsn  .= "
										<tr class='fuente_diez'>
											<td width='200'>
												<a href='javascript:void(null);' onclick='muestra_posicion($lat_cen,$lon_cen,$row[7]);'>".
												conv_fecha($fecha_ini)."</a>
											</td>
											<td width='200'>".conv_fecha($fecha_fin)."</td>
											<td width='100'>".(int)$difMin." Min</td>
											<td width='350' colspan='2'>".otro_server($row[3],$row[4])."</td>
										</tr>";
									}
									if($menor == '' && $mayor != '' && $mayor < (int)$difMin)
									{ //todo
										$dsn  .= "
										<tr class='fuente_diez'>
											<td width='200'>
												<a href='javascript:void(null);' onclick='muestra_posicion($lat_cen,$lon_cen,$row[7]);'>".
												conv_fecha($fecha_ini)."</a>
											</td>
											<td width='200'>".conv_fecha($fecha_fin)."</td>
											<td width='100'>".(int)$difMin." Min</td>
											<td width='350' colspan='2'>".otro_server($row[3],$row[4])."</td>
										</tr>";
									}
									if($mayor == '' && $menor != '' && $menor > (int)$difMin)
									{ //todo
										$dsn  .= "
										<tr class='fuente_diez'>
											<td width='200'>
												<a href='javascript:void(null);' onclick='muestra_posicion($lat_cen,$lon_cen,$row[7]);'>".
												conv_fecha($fecha_ini)."</a>
											</td>
											<td width='200'>".conv_fecha($fecha_fin)."</td>
											<td width='100'>".(int)$difMin." Min</td>
											<td width='350' colspan='2'>".otro_server($row[3],$row[4])."</td>
										</tr>";
									}
									if($mayor < (int)$difMin && $menor > (int)$difMin && $mayor != '' && $menor != '')
									{ //todo
										$dsn  .= "
										<tr class='fuente_diez'>
											<td width='200'>
												<a href='javascript:void(null);' onclick='muestra_posicion($lat_cen,$lon_cen,$row[7]);'>".
												conv_fecha($fecha_ini)."</a>
											</td>
											<td width='200'>".conv_fecha($fecha_fin)."</td>
											<td width='100'>".(int)$difMin." Min</td>
											<td width='350' colspan='2'>".otro_server($row[3],$row[4])."</td>
										</tr>";
									}
								}
							}
							$iii = 0;
						}
						$fecha_tmp = $row[2];
						$lat_cen = $row[3];
						$lon_cen = $row[4];
						$veh_tmp = $row[1];
						$i++;
					}
				}
				else{
					//require_once("librerias/conexion.php");//incluimos nuevamente la conexion debido al llamado de otro_servido por que interrumpe la conexion actual
					/*
					$conec=@mysql_connect("160.16.18.8","supevisor","supevisor");
					mysql_select_db("sepromex", $conec);
					*/
					$server="10.0.1.3";
					$conec = mysql_connect($server,"egweb","53g53pr0")  or die ("¡No hay conexión con el servidor! <br />" . mysql_error());					
					mysql_select_db("sepromex", $conec);
					$datos=mysql_query("SELECT id_veh from vehiculos where num_veh=".$vehi[$k],$conec); 
					//$objResponse->alert(mysql_error());
					$dat=mysql_fetch_array($datos);
					$dsn.= "
					<tr class='fuente_diez'><th colspan='5'>Vehículo ".$dat[0]."</th></tr>
					<tr class='fuente_diez'>
						<td width='200'>$fecha_i</td>
						<td width='200'>$fecha_f</td>
						<td width='100'>N/A</td>
						<td width='350' colspan='2'>No hay datos del vehiculo el dia seleccionado</td>
					</tr>";
				}
			}
			$dsn .= "</table></div>";
			if($tabla == 0)
			{
				$objResponse->alert("No se encontraron registros, seleccione otro vehículo");
				$objResponse->assign("cont_reporte","innerHTML","");
			}
			else
			{
				$botones_dw_tiempo="<a href='javascript:void(null)' onclick='form2_pdf.submit()' title='Exportar PDF' >
				<img src='img2/pdf.png' border='0' width='20' height='20'/></a>
				<a href='javascript:void(null)' onclick='form2_xls.submit()' title='Exportar XLS' >
				<img src='img2/xls.png' border='0' width='20' height='20'/></a>";
				$objResponse->script("$('#cont_reporte').show();");
				$objResponse->assign("cont_reporte","innerHTML",$dsn);
				//$objResponse->assign("cont_reporte","innerHTML",$dsn);
				$dsn=str_replace($botones_dw_tiempo,'',$dsn);
				$objResponse->assign("form2_pdf","innerHTML","<textarea name='dsn' >$dsn</textarea>
				<input type='hidden' name='idsistema' />");
				$objResponse->assign("form2_xls","innerHTML","<textarea name='dsn' >$dsn</textarea>
				<input type='hidden' name='idsistema' />");
				$objResponse->assign("panel","innerHTML",$dsn_bot);
			}
	    }//del if si las fechas son correctas
	    else $objResponse->alert("Error en parametros de fecha, intente nuevamente".$fecha_i."-".$fecha_f);
	}//cierre del else si se ha seleccionado algun vehiculo
	return $objResponse; 
}		
function distDosPuntos($lat_cen,$lon_cen,$lat,$lon){
		$degtorad = 0.01745329; 
		$radtodeg = 57.29577951; 
		$dlong = ($lon_cen - $lon); 
 		$dvalue = (sin($lat_cen * $degtorad) * sin($lat * $degtorad)) + (cos($lat_cen * $degtorad) * cos($lat * $degtorad) * cos($dlong * $degtorad));
  		$dd = acos($dvalue) * $radtodeg; 
  		$km = ($dd * 111.302)*1000;
		$km = number_format($km,1,'.','');
		return $km;
}
function getFechadiferencia($fecha_ant, $fecha_act, $unit){ 
   $diferencia = null; 
   $dateFromElements = explode(' ', $fecha_ant); 
   $dateToElements = explode(' ', $fecha_act); 
   $dateFromDateElements = explode('-', $dateFromElements[0]); 
   $dateFromTimeElements = explode(':', $dateFromElements[1]); 
   $dateToDateElements = explode('-', $dateToElements[0]); 
   $dateToTimeElements = explode(':', $dateToElements[1]); 
   //return $dateFromDateElements[1].'--'.$dateFromDateElements[2].'--'.$dateFromDateElements[0];
   $date1 = mktime($dateFromTimeElements[0], $dateFromTimeElements[1], $dateFromTimeElements[2], $dateFromDateElements[1], $dateFromDateElements[2], $dateFromDateElements[0]); 
   $date2 = mktime($dateToTimeElements[0], $dateToTimeElements[1], $dateToTimeElements[2], $dateToDateElements[1], $dateToDateElements[2], $dateToDateElements[0]); 
	$caden = $dateFromTimeElements[0]." ".$dateFromTimeElements[1]." ".$dateFromTimeElements[2]." ".$dateFromDateElements[1]." ".$dateFromDateElements[2]." ".$dateFromDateElements[0];
   if( $date1 < $date2 ){ 
       return  null; 
   } 

   $diff = $date1 - $date2; 
   $days = 0; 
   $hours = 0; 
   $minutes = 0; 
   $seconds = 0; 
   if ($diff % 86400 <= 0){  // there are 86,400 seconds in a day  
       $days = $diff / 86400; 
   } 

   if($diff % 86400 > 0){ 
       $rest = ($diff % 86400); 
       $days = ($diff - $rest) / 86400; 
       if( $rest % 3600 > 0 ){ 
           $rest1 = ($rest % 3600); 
           $hours = ($rest - $rest1) / 3600; 
           if( $rest1 % 60 > 0 ){ 
               $rest2 = ($rest1 % 60); 
               $minutes = ($rest1 - $rest2) / 60; 
               $seconds = $rest2; 
           } 
           else{ 
               $minutes = $rest1 / 60; 
           } 
       } 
       else{ 
           $hours = $rest / 3600; 
       } 
   } 
   switch($unit){ 
       case 'd': 
       case 'D': 
           $partialDays = 0; 
           $partialDays += ($seconds / 86400); 
           $partialDays += ($minutes / 1440); 
           $partialDays += ($hours / 24); 
           $diferencia = $days + $partialDays; 
           break; 
       case 'h': 
       case 'H': 
           $partialHours = 0; 
           $partialHours += ($seconds / 3600); 
           $partialHours += ($minutes / 60); 
           $diferencia = $hours + ($days * 24) + $partialHours; 
           break; 
       case 'm': 
       case 'M': 
           $partialMinutes = 0; 
           $partialMinutes += ($seconds / 60); 
           $diferencia = $minutes + ($days * 1440) + ($hours * 60) + $partialMinutes; 
           break; 
       case 's': 
       case 'S': 
           $diferencia = $seconds + ($days * 86400) + ($hours * 3600) + ($minutes * 60); 
           break; 
       case 'a': 
       case 'A': 
           $diferencia = array ("days" => $days,"hours" => $hours,"minutes" => $minutes,"seconds" => $seconds ); 
           break; 
   } 
   return $diferencia;
}
$xajax->ProcessRequest(); 
$xajax->printJavascript();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>Reporte de recorrido</title>
<link href="css/black.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="librerias/tabla/tabla.css" type="text/css" media="screen">
<script type="text/javascript" src="librerias/tabla/ajax.js"></script>
<script type="text/javascript" src="librerias/tabla/tabla.js"></script>
<!--<script type='text/javascript' src="librerias/funciones_rebe.js"></script>  -->
<script type='text/javascript' src="librerias/funciones_egweb.js"></script>
<script type="text/javascript" src="librerias/func_principal.js"></script>
<link type="text/css" href="css/ui-darkness/jquery-ui-1.10.3.custom.css" rel="Stylesheet" />
<style type="text/css">
	 #ui-datepicker-div{ font-size: 70%; }
	  /* css for timepicker */
	 .ui-timepicker-div .ui-widget-header{ margin-bottom: 8px; }
	 .ui-timepicker-div dl{ text-align: left; }
	 .ui-timepicker-div dl dt{ height: 25px; }
	 .ui-timepicker-div dl dd{ margin: -25px 10px 10px 65px; }
	 .ui-timepicker-div td { font-size: 70%; } 
	 .ui-dialog { z-index: 30000 !important ;}
</style>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
<script language="JavaScript">
function calendario(id){
	jQuery("#"+id).datetimepicker({
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
<script type='text/javascript' src="librerias/func_recorridoCambios.js"></script>
<script type='text/javascript' src="js/reporte_animado.js"></script>
 <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>-->
<script type="text/javascript"src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2ZgtqdFwl6hQomaR295YK0A1XVjcVXl0" ></script>
<script type="text/javascript">
idleTime = 0;
$(document).ready(function () {
    //Increment the idle time counter every minute.
    //var idleInterval = setInterval("opener.timerIncrement()", 60000); // 1 minute

    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        opener.idleTime = 0;
    });
    $(this).keypress(function (e) {
        opener.idleTime = 0;
    });
	jQuery( "#las_imagenes" ).dialog({
	   autoOpen: false,
		height: 400,
		width: 250,
		modal: true
	});
	jQuery( "#los_mensajes" ).dialog({
	   autoOpen: false,
		height: 400,
		width: 250,
		modal: true
	});
	//jQuery( "#encendidos" ).css('z-index','30000');
	jQuery( "#encendidos" ).dialog({
	   autoOpen: false,
		height: 150,
		width: 450,
		zIndex: 30000,
		modal: false
	});
	jQuery( "#img_grafica" ).dialog({
	   autoOpen: false,
		height: 400,
		width: 950,
		zIndex: 30000,
		modal: false
	});
})
</script>
<style>
.ui-dialog { z-index: 1000000 !important ;}
.dialog_style {
background: #000;
}
</style>
</head>
<body id="fondo" style='width:1190px;height:750px;overflow-x:hidden;' onload="tipo(1,<?php echo (int)$sess->get("Ide");?>,<?php echo (int)$idu ?>);load();" >
<div id="fondo1" style='width:1190px;height:100%;'>
	<div id="fondo2" style='width:1190px;height:100%;'>
		<div id="fondo3" style='width:1190px;height:100%;'>
		<center>
	<form id="myform" name="myform" action="javascript:void(null);" onsubmit="return false;" >  		
	<div id="cuerpoSuphead">
		<div id="logo"><img src='img2/logo1.png' style='position:absolute;left:25px;z-index:10;'></div><!--Nos muestra el logo de la pagina "oficial"-->
	</div>
	<?
		include("includes/menu_recorrido.php");
	?>
	<div id="warming"></div>
	<div id="exportar_upos" style='display:none;'></div>
            
	<div id="cont_autos2" style="top:120px;">
		<div id="veh_checks" style="height:306px;"></div>
		<div id='variables_reporte'></div>
	</div>
	<script type="text/javascript">
	//initTabs('dhtmlgoodies_tabView1',Array('Vehículos','Variables'),0,350,350);
	</script>
	<div id="cont_mapita" style="top:140px;height:306px;"></div>
	<div id='panel' style="top:0px;"></div>
	<div id="cont_reporte" style="top:536px;width:1150px;"></div>
	<div id="panelinfo" style="top:450px;"></div>
  	<input type="hidden" value='<?php echo $idu?>' name="n_usr" id="n_usr"/> <!-- numero de usuario-->
    <input type="hidden" value='<?php echo $usn?>' name="id_usr" id="id_usr"/> <!-- username ejemplo //siloz-->
    <input type="hidden" value='<?php echo $ide?>' name="id_emp" id="id_emp"/> <!-- numero de empresa-->
</div>
</form>
<div id='las_imagenes' align='center'></div>
<div id='los_mensajes' align='center'></div>
<div id='img_grafica' align='center'></div>
<div id='encendidos' align='center' title="Tiempos del motor encendido y apagado" style='z-index:30000;'></div>
<form name="form_xls" id="form_xls" method="post" target='_blank' action="reporte_xls.php?idem=<?php echo $ide?>" style="visibility:hidden"></form>
<form name="form_pdf" id="form_pdf" method="post" target='_blank' action="reporte_pdf.php?idem=<?php echo $ide?>" style="visibility:hidden"></form>
<form name="form2_xls" id="form2_xls" method="post" action="reporte_sm.php" style="visibility:hidden"></form>
<form name="form2_pdf" id="form2_pdf" method="post" action="reporte_pdf_sm.php" style="visibility:hidden"></form>
		</center>
		</div>
	</div>
</div>
</body>

</html>