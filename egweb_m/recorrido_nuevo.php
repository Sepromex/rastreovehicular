<?php
  include_once('../patError/patErrorManager.php');
  include('ObtenUrl.php');
  patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
  patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
  require_once('../FirePHPCore/FirePHP.class.php'); // Clase FirePhp para hace debug con Firebug 
  patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );
  include_once('../patSession/patSession.php');
  $sess =& patSession::singleton('egw', 'Native', $options );
  $estses = $sess->getState();
  
  if (isset($_GET["Logout"])) {
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
	$nom = $sess->get("nom");
	$prm = $sess->get('per');
	$est = $sess->get('sta');
	$eve = $sess->get('eve');
	$dis = $sess->get('dis');
	$pan = $sess->get('pan');
	if (!$reg) {
	    $sess->set('Registrado',1);	
	}	
  }	else {
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
	//$xajax->configure('debug',true); 
	$xajax->register(XAJAX_FUNCTION,"estilo");
	$xajax->register(XAJAX_FUNCTION,"recorrido");
	$xajax->register(XAJAX_FUNCTION,"alertas");
	$xajax->register(XAJAX_FUNCTION,"rep_tiemposm");
	
	$xajax->register(XAJAX_FUNCTION,"ver_geocercas");
	$xajax->register(XAJAX_FUNCTION,"mandar_geocercas");
	$xajax->register(XAJAX_FUNCTION,'matarSesion');
  
function matarSesion(){
	//$chequeo=0;
	$objResponse = new xajaxResponse();
	patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
	patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
	patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );
	include_once('../patSession/patSession.php');
	 $sess =& patSession::singleton('ham', 'Native', $options );
	$sess->Destroy();
	$objResponse-> redirect("index.php");
	return $objResponse;
} 
/**************************************************************************************PINTANDO GEOCERCAS DE LOS VEHICULOS************************************************************************************/	
function ver_geocercas($id_geo){  //
	$objResponse = new xajaxResponse();
	//$objResponse->alert($id_geo);
	$cad_geo = "select g.tipo";
	$cad_geo .= " from geo_time g";
	$cad_geo .= " where g.num_geo = $id_geo";
	$res_geo = mysql_query($cad_geo);
	$num_geo = mysql_fetch_array($res_geo);
	//$objResponse->alert($id_geo);
	//$objResponse->alert($cad_geo);	
	$arregloLatitud=array(); 
	$arregloLongitud=array();
	if($num_geo[0]==0){
		$query="SELECT latitud,longitud,radioMts,nombre from geo_time where num_geo=$id_geo";	
		$res_geo=mysql_query($query);
		$row = mysql_fetch_row($res_geo);
		$radio = $row[2];
		$objResponse->call("mostrar_circular_reporte",$row[0],$row[1],$radio,$row[3]);
		}
	if($num_geo[0]== 1 ){
		$query="SELECT p.latitud,p.longitud,g.nombre
		from geo_puntos p 
		inner join geo_time g on p.num_geo=g.num_geo
		where p.num_geo=$id_geo order by p.orden";	
		$res_geo=mysql_query($query);
		//$objResponse->alert($query);
		$num_geo=mysql_num_rows($res_geo);
		while($row = mysql_fetch_array($res_geo)){
			array_push($arregloLatitud,$row[0]);
			array_push($arregloLongitud,$row[1]);
			$nombre=$row[3];
		}
		$objResponse->call("mostrar_poligonal_reporte",$arregloLatitud,$arregloLongitud,$nombre);
	}
return $objResponse;
}
  
function mandar_geocercas($num_veh){
	$objResponse = new xajaxResponse();
	//$objResponse->alert($num_veh);
	$cadGeos="select num_geo from geo_veh where num_veh=$num_veh";
	$queryGeos=mysql_query($cadGeos);
	while($rowGeos=mysql_fetch_row($queryGeos)){
		$objResponse->script("xajax_ver_geocercas($rowGeos[0]);");
		//$objResponse->alert($rowGeos[0]);
	}
	return $objResponse;
}
/*********************************************************************************************************************************************************************************************************************************/
	
 //Funcion para crear el formulario y los vehiculos dependiendo del tipo de reporte.
function estilo($a,$ide,$idu)
{
		$objResponse = new xajaxResponse();
		switch($a)
		{
			case 1:
				$cad_veh = "SELECT v.ID_VEH, v.NUM_VEH
									FROM veh_usr AS vu
									Inner Join vehiculos AS v ON vu.NUM_VEH = v.NUM_VEH
									inner join estveh ev on (v.estatus=ev.estatus)
									WHERE vu.ID_USUARIO = $idu and ev.publicapos=1
									ORDER BY v.ID_VEH ASC ";
				$res_veh = mysql_query($cad_veh);
				$dsn_veh ="<select  multiple='multiple' name='vehiculos' class='select2' title='Seleccione Un vehiculo'>";
				while($rowv = mysql_fetch_row($res_veh))
					$dsn_veh .="<option value='".$rowv[1]."'>".htmlentities($rowv[0])."</option>";  
				$dsn_veh .="</select>"; 
				$objResponse->assign('veh_checks','innerHTML',$dsn_veh);   
				
				$dsn .="<table width='330' border='0' cellpadding='0' cellspacing='1' id='box-table-a1'>";
				//$dsn .="<tr><td width='170'></td><td>&nbsp;</td></tr>";
				$dsn .="<tr><td width='170'>Fecha Inicio:</td><td width='160'><label>";
				$dsn .="<input name='fecha_ini' id='fecha_ini' style='position: relative; z-index: 10;' size='15' value='".date("Y-m-d")." 00:00:00'/>";
				//$dsn .=" <a href='calendario(\"\")'><img src='./img/cal.gif' border='0' /></a>";
				$dsn .="</label></td></tr><tr><td>Fecha Fin:</td><td><label>";
				$dsn .="<input name='fecha_fin' type='text' style='position: relative; z-index: 10;' id='fecha_fin' size='15' value='".date("Y-m-d H:i:s")."'/>";
				//$dsn .=" <a href='javascript:fecha2()'><img src='./img/cal.gif' border='0' /></a>";
				$dsn .="</label></td></tr><tr><td>Velocidad Menor a:</td><td><label>";
				$dsn .="<input name='vel_men' type='text' id='vel_men' size='5' /></label></td></tr><tr>";
				$dsn .="<td>Velocidad Mayor a:</td><td><label>";
				$dsn .="<input name='vel_may' type='text' id='vel_may' size='5' /></label></td>";
				$dsn .="</tr><tr><td>Posiciones Automáticas:</td>";
				$dsn .="<td><input type='checkbox' name='pos_aut' id='pos_Aut' checked='checked'/></td>";
				$dsn .="</tr><tr><td>No mostrar Posiciones Obsoletas:</td>";
				$dsn .="<td><input type='checkbox' name='pos_obs' id='pos_obs' checked='checked'/></td>";
				$dsn .="</tr><tr><td>Solicitudes de Posiciones:</td><td><input type='checkbox' name='sol_pos' id='sol_pos' checked='checked' /></td>";
				$dsn .="</tr><tr><td>Mensajes por Clave:</td><td><input type='checkbox' name='msj_cla' id='msj_cla' checked='checked'/></td>";
				$dsn .="</tr><tr><td>Mensajes Libres:</td><td><label><input type='checkbox' name='msj_lib' id='msj_lib' checked='checked'/>";
				$dsn .="</label></td></tr><tr><td>Activación de Entradas Digitales:</td><td>";
				$dsn .="<input type='checkbox' name='act_entra' id='act_entra' checked='checked' /></td></tr><tr>";
				$dsn .="<td>Exceso de Velocidad:</td><td><input type='checkbox' name='exceso_vel' id='exceso_vel' checked='checked' /></td></tr>";
				//$dsn .="<tr><td>Color recorrido:</td><td ><div id=\"customWidget\"></div></td></tr>";
				$dsn .="<tr><td colspan='2'><input type='submit' class='agregar1' id='button' value='Obtener Reporte' ";
				$dsn .="onclick='getReport();' title='Obtener Reporte'/></td></tr>";
				/*$dsn .="<tr><td colspan='2'>Nota: Para evitar inconsistencia, se recomienda obtener este reporte ";
				$dsn .="en periodos menores a tres dias o dependiendo del tiempo de reporte de su vehículo.</td></tr>*/
				$dsn.="</table>";
				$objResponse->assign('variables_reporte','innerHTML',$dsn);
				$objResponse->script("setTimeout('calendario(\"fecha_fin\")',1000);");
				$objResponse->script("setTimeout('calendario(\"fecha_ini\")',800);");
				break;
			case 2:
				$cad_veh = "SELECT v.ID_VEH, v.NUM_VEH
									FROM veh_usr AS vu
									Inner Join vehiculos AS v ON vu.NUM_VEH = v.NUM_VEH
									inner join estveh ev on (v.estatus = ev.estatus)
									WHERE vu.ID_USUARIO = $idu and ev.publicapos=1
									ORDER BY v.ID_VEH ASC ";
				$res_veh = mysql_query($cad_veh);
				$dsn_veh ="";
				$dsn_veh .="
				<table id='newspaper-a1'>
					<tr>
						<th>Veh&iacute;culos</th>
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
				
				$dsn1  ="<p>&nbsp;</p>";
				$dsn1 .="<table width='330' border='0' cellpadding='0' cellspacing='1' id='box-table-a1'>";
				$dsn1 .="<tr><td width='170'>Fecha Inicio:</td><td width='160'><label>";
				$dsn1 .="<input name='fecha_ini2' style='position:relative;z-index:10;' type='text' id='fecha_ini2' size='15' value='".date("Y-m-d")." 00:00:00'/>";
				//$dsn1 .=" ";
				$dsn1 .="</label></td></tr><tr><td>Fecha Fin:</td><td><label>";
				$dsn1 .="<input name='fecha_fin2' style='position: relative; z-index: 10;' type='text' id='fecha_fin2' size='15' />";
				//$dsn1 .=" <a href='calendario(\"fecha_fin\")'><img src='./img/cal.gif' border='0' /></a>";
				$dsn1 .="</label></td></tr>";
				$dsn1 .="<tr><td>&nbsp;</td><td></td></tr>";
				$dsn1 .="<tr><td>Mayor a:</td><td><input type='text' name='mayor' id='mayor' size='4' /></td></tr>";
				$dsn1 .="<tr><td>Menor a:</td><td><input type='text' name='menor' id='menor' size='4' /></td></tr>";
				$dsn1 .="<tr><td>&nbsp;</td><td></td></tr>";
				$dsn1 .="<tr><td><input type='radio' name='tmp' id='tmp' value='hrs' /> Horas</td>";
				$dsn1 .="<td><input type='radio' name='tmp' id='tmp' value='mnt' checked='checked' /> Minutos</td></tr>";
				$dsn1 .="<tr><td>&nbsp;</td><td></td></tr>";
				$dsn1 .="<tr><td colspan='2'><input type='submit' class='agregar1' id='button' value='Obtener Reporte' ";
				$dsn1 .=" onclick='cont_checks();' title='Obtener Reporte'/></td></tr></table>";
				
				$objResponse->assign('variables_reporte','innerHTML',$dsn1);
				$objResponse->script("setTimeout('calendario(\"fecha_fin2\")',1000);");
				$objResponse->script("setTimeout('calendario(\"fecha_ini2\")',800);");
				break;
			case 3:
				$objResponse->assign('variables_reporte','innerHTML','');
				$objResponse->alert('Fuera de servicio por el momento');	
				break;
			case 4:
				$objResponse->assign('variables_reporte','innerHTML','');
				$objResponse->alert('Fuera de servicio por el momento');	
				break;
			case 5:	
				$cad .= "SELECT DISTINCT(v.num_veh),v.id_veh,
						(u.lat/3600/16),
						((u.long & 8388607)/3600/12*-1),
						u.mensaje,u.velocidad,u.fecha,
						v.tipoveh,u.t_mensaje,v.id_empresa,
						u.entradas,cv.cruce
						FROM vehiculos AS V
						LEFT OUTER JOIN ultimapos AS u ON v.num_veh=u.num_veh
						LEFT OUTER JOIN veh_usr AS vu ON v.num_veh=vu.num_veh
						LEFT OUTER JOIN posiciones AS p ON v.num_veh=p.num_veh
						AND p.fecha=u.fecha
						LEFT OUTER JOIN cruce_pos AS cc ON p.id_pos=cc.id_pos
						LEFT OUTER JOIN cruce_veh AS cv ON cc.id_cruce=cv.id_cruce
						WHERE vu.id_usuario= $idu";
				$res_rep = mysql_query($cad);
				//$objResponse->alert($cad);
				if($res_rep != 0)
				{
					$datos  = "<div style='position:absolute;left:100px;top:0px;width:890px;height:400px;overflow:auto;z-index:100;'>";
					$datos .= "<table border='0' style='text-align:center;width:865px;' id='box-table-a1'";
					$datos .= "cellspacing = '0' cellpadding='0'><tr>";
					$datos .= "<th width='100'>VEHÍCULO</th><th width='100'>FECHA / HORA</th><th width='20'>VEL.Km</th><th width='80'>LATITUD</th><th width='80'>LONGITUD</th>";
					$datos .= "<th width='260'>UBICACIÓN</th><th width='150'>MSJ</th></tr>";
					$i=0;
					
					while($row = mysql_fetch_array($res_rep))
					{
						//$datos .="<tr><td>".strtoupper(utf8_encode($row[1]))."</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
						
						if($i%2!=0)
							$color = "#C6D9F1";
						else	
							$color = "#FFFFFF";
						$clv = $row[10];
						$lat = $row[2];
						$lon = $row[3];
						if($row[8] == 2 || $row[8] == 1)
							$men = $row[4];
						if($row[8] == 3)
						{
							$c_mensa = mysql_query("select mensaje from c_mensajes where id_empresa = '$ide' and id_mensaje = '$clv'");
							$row1 = mysql_fetch_array($c_mensa);
							$men = $row1[0];
							if($men == '')
							{
								$c_mensa = mysql_query("select mensaje from c_mensajes where id_empresa = 15 and id_mensaje = '$clv'");
								$row1 = mysql_fetch_array($c_mensa);
								$men = $row1[0];
							}
						}
						if ((($lat != "") || ($lon != "")) && (($lat != 0) || ($lon != 0)))
						{
							if($row[11]=='')
							{
								try
								{
									$calle = "";
									$client = new SoapClient("http://160.16.18.8/Scalles/Txtcalles.asmx?wsdl", array('encoding'=>'ISO-8859-1',
									'soap_version' => SOAP_1_1,'style' => SOAP_DOCUMENT,'use' => SOAP_LITERAL,'trace' => 1));
									$la = new SoapVar($lat, XSD_DOUBLE, "double", "http://www.w3.org/2001/XMLSchema");
									$lo = new SoapVar($lon,  XSD_DOUBLE, "double", "http://www.w3.org/2001/XMLSchema");
									$c = new SoapVar(1, XSD_INTEGER, "integer", "http://www.w3.org/2001/XMLSchema");
									try
									{
										$resultadoc = $client->Pcalle(array("lt" => $la,"lg" => $lo, "cb" => $c));
										$calle = $resultadoc->PcalleResult;
										//$calle= "si hay";
									}catch (Exception $e) {
										$error = "";
										$calle=$e->getMessage();
									}
									$resultadop = $client->Pcercano(array("lt" => $la,"lg" => $lo, "cb" => $c)); 
									$poblado = $resultadop->PcercanoResult;
								}catch (Exception $e) {
									$poblado = "No se puede determinar la ubicacion del vehiculo";						
								}
								if ($calle)
									$calle = $poblado.", calle: ".$calle;
								else 
									$calle = $poblado;							 			 
							}else $calle = $row[11];
						} else $calle = "Posible perdida de GPS";
						$datos.= "<tr class='fuente_once'><td width='100'>".utf8_encode($row[1])."</td><td width='100'>".conv_fecha($row[6])."</td><td width='20'>$row[5]</td><td width='80'>";
						$datos.= number_format($lat,6,'.','')."</td><td width='80'>".number_format($lon,6,'.','')."</td>";
						$datos.= "<td width='260' >".strtoupper(utf8_encode($calle))."</td><td width='150'>".strtoupper(utf8_encode($men))."</td></tr>";
						$i++;
					}
					$datos .= "</table></div>";
					$objResponse->assign('cont_reporte','innerHTML',$datos);
				}else $objResponse->alert('No hay registros para mostrar');
				break;
		}
		return $objResponse; 
} 

//funcion para crear recorrido en el mapa y sacar el reporte
function recorrido($valorForm,$inicio,$limite,$pag,$reg,$geos)
{
	$firephp= FirePhp::getInstance(true);
	$paginacion = "";
	$_vehiculo = "";
	$latIni;
	$latFin;
	$lonIni;
	$lonFin;
	//
	foreach ($valorForm['vehiculos'] as $veh);	
	if ($veh == '')
	{
		$objResponse = new xajaxResponse();
		$objResponse->alert("Seleccione el vehiculo para crear el recorrido");
		$objResponse->assign("cont_reporte","innerHTML","");
	 	return $objResponse;		
	}else
	{	
		$firephp->log("Inicio: ".$inicio." Limite: ".$limite." Pagina: ".$pag." Reg: ".$reg,"Info:");
		$objResponse = new xajaxResponse();
		//$objResponse->alert("Inicio:$inicio\nLimite:$limite\nPagina:$pag\nReg:$reg");
		$fecha_ini = $valorForm['fecha_ini'];
		$fecha_fin = $valorForm['fecha_fin'];		
		$vel_may = $valorForm['vel_may'];
		$vel_men = $valorForm['vel_men'];			
		$pos_aut = $valorForm['pos_aut'];
		$sol_pos = $valorForm['sol_pos'];			
		$men_cla = $valorForm['msj_cla'];
		$men_lib = $valorForm['msj_lib'];			
		$act_ent = $valorForm['act_entra'];	
        $exceso_vel = $valorForm['exceso_vel']; 	
		$numero_usr = $valorForm['n_usr'];
		$id_usuario = $valorForm['id_usr'];			
		$id_empresa = $valorForm['id_emp'];
		$pos_obs = $valorForm['pos_obs'];
		$datos_rec ="";								$i = 0;
		if(empty($fecha_ini)==0 && empty($fecha_fin)==0 && date($fecha_ini) < date($fecha_fin))
		{
			$cad_veh = "select id_sistema from vehiculos where num_veh = $veh";
			$firephp-> log($cad_veh,'Vehiculos:');
			$res_cad = mysql_query($cad_veh);
			$rowsist = mysql_fetch_row($res_cad);
		 	$cad_msj = "select id_empresa from c_mensajes where id_empresa = $id_empresa";
			$firephp-> log($cad_msj,'Cmensajes:');
			$res_msj = mysql_query($cad_msj);
			if(mysql_num_rows($res_msj))
				$id_emp = $id_empresa;
			else $id_emp = 15;
		 	$datos_rec="select p.fecha,p.num_veh,p.velocidad,p.mensaje,p.t_mensaje,p.entradas,";
			$datos_rec.="(p.lat/3600/16),((p.long & 8388607)/3600/12*-1),v.id_veh,v.tipoveh,cv.cruce,p.id_pos,p.odometro,p.id_tipo,";
			$datos_rec.="pm.descripcion,cm.mensaje,v.id_sistema from posiciones p left outer join vehiculos v on (p.num_veh = v.num_veh) ";
			$datos_rec.="left outer join cruce_pos cc on (cc.id_pos = p.id_pos) ";
			$datos_rec.="left outer join cruce_veh cv on (cc.id_cruce = cv.id_cruce) ";
			$datos_rec.="left outer join postmens pm on (pm.t_mensaje = p.t_mensaje) ";
			$datos_rec.="left outer join c_mensajes cm on (cm.id_mensaje = p.entradas and cm.id_empresa = $id_emp and p.t_mensaje=3) ";
			$datos_rec.="where p.num_veh = '$veh' and p.fecha between '$fecha_ini' and '$fecha_fin'";
			if( $pos_aut == 'on' || $sol_pos== 'on')
			{
	         	$tipo = '';
		 	 	$b = 0;
			 	if($pos_aut == 'on')
				{
			 		$tipo.= "1";
					$b=1;
			 	}
			 	if($sol_pos == 'on')
				{
					if($b==1)
						$tipo .= ",";
			 		$tipo.= "2";
			 	}
			 	$datos_rec .= " and (p.id_tipo in ($tipo)";
				
				if($men_cla != 'on' and $men_lib != 'on'  and $act_ent != 'on' and $exceso_vel != 'on' )
					$datos_rec .= ")";					
		  	}
		  	if($men_cla == 'on' || $men_lib == 'on' || $act_ent == 'on' || $exceso_vel == 'on')
			{	 
		  	 	$tipo = '';
		 	 	$b = 0;
					
				if($pos_aut != 'on' && $sol_pos!= 'on')
					$datos_rec .= " and (";
				else $datos_rec .= " or ";
					
			 	if($men_cla== 'on')
				{
			 		$tipo.= "3";
					$b=1;	
			 	}
			 	if($men_lib== 'on')
				{
			 		if($b==1)
						$tipo .= ",";
			 		$tipo.= "2";
					$b=1;
			 	}
				if($act_ent== 'on')
				{
			 		if($b==1)
						$tipo .= ",";
			 		$tipo.= "6";
			 	}
				if($exceso_vel == 'on')
				{
			 		if($b==1)
						$tipo .= ",";
			 		$tipo.= "7,8";
			 	}
			 		//$datos_rec .= " p.t_mensaje in (1,$tipo)) ";
					$datos_rec .= " p.t_mensaje in ($tipo)) ";
		  	}
			if($vel_men!='' || $vel_may!='')
			{
				if($vel_men!='' && $vel_may==0)
					$datos_rec .= "and p.velocidad <= '$vel_men' ";
					
				if($vel_men=='' &&  $vel_may!='')
					$datos_rec .= "and p.velocidad >= '$vel_may' ";
					
				if($vel_men!='' && $vel_may!='')
				{
					if($vel_men < $vel_may)
					{//validacion de rango de velocidades
				        $objResponse->alert("Datos erroneos en campos de velocidad");
				        return $objResponse;
					}
					else
						$datos_rec .= "and p.velocidad between '$vel_may' and '$vel_men' ";					
				}
			}
			if($pos_obs=='on')  $datos_rec .= " and p.obsoleto = 0 order by p.fecha asc ";	
			else $datos_rec.=" order by p.fecha asc ";
			//$objResponse->alert($datos_rec);
		 }
		 else
		 {
			$objResponse->alert("Favor de dar un rango de fechas");
			return $objResponse; 
		 }
		//$firephp-> log($datos_rec,'Recorrida:');
		if($reg == 0)
		{ //si es la primera vez que entra
			$objResponse->assign("form_pdf","innerHTML","<textarea name='con_pdf' >$datos_rec</textarea>
			<input type='hidden' name='idsiste' value='$rowsist[0]'/>");
		 	$objResponse->assign("form_xls","innerHTML","<textarea name='con_xls' >$datos_rec</textarea>
			<input type='hidden' name='idsistema' value='$rowsist[0]'/>");
			$resp = mysql_query($datos_rec);
			//$objResponse->alert($datos_rec);
			$firephp-> log($datos_rec,'Recorrida:');
			$num_reg = mysql_num_rows($resp);
		}else $num_reg = $reg;
		$cadreco=$datos_rec;
		$total_paginas = ceil($num_reg  / $limite);
		//$firephp-> log($total_paginas,'Total Paginas:');
		if($num_reg != 0)
		{
			$datos_rec .= "limit $inicio,$limite"; //para la paginacion
			$resp = mysql_query($datos_rec); //para la paginacion
			//$objResponse->alert($datos_rec);
			$firephp-> log($datos_rec,'Recorrida:');
			//$rrow = mysql_fetch_array($resp);
			$s = 0;
		 	if($rowsist[0]==20 || $rowsist[0]== 34 )
			{
				$cabe = "<td>ODO</td>";
				$s = 1;
		 	}
			//tabla que muestra el recorrido "primera" pantalla en reportes
		 	//$dsn_reco = "<div style='absolute:position;top:0px;left:15px;width:765px;'><br/><table border = '0' class='fuente_diez' id='newspaper-a1' width='765' cellspacing='0' cellpaddiig='0'>";
			$dsn_reco = "<div style='overflow:auto;height:150px;'><table id='box-table-a1' width='765px'>";
			$dsn_reco .= "<tr>";
		 	$dsn_reco .= "<th width='70'>ID POS</th><th width='100'>FECHA</th><th width='150'>EVENTO</th><th width='50'>VEL.Km</th>$cabe<th width='200'>MENSAJE</th>";
			$dsn_reco .= "<th width='330'>CALLES</th></tr>";
		 	$n=0;
			//$objResponse->alert($cadreco);
		 	while($row = mysql_fetch_array($resp))
			{
				//$firephp-> log($row[15],'MAMAZo:');
				if((int)$row[6]!= 0 || (int)$row[7] != 0)
				{
					if($i == 0 && $reg == 0 )
					{
						$latIni = $row[6]; 
						$lonIni = $row[7]; 
					}
					$latFin = $row[6];
					$lonFin = $row[7];
					
					if($rowsist[0]==20 || $rowsist[0]== 34 )
						$cuerpo = "<td>$row[12]</td>";
				
					if($row[4]==0 )
						$row[14] = "PERDIDA DE GPS";
					if($row[15]=="")
						$row[15] = $row[3];
					$objResponse->call("crea_recorrido", $row[6],$row[7],$row[9],$pag);
					if($i%2!=0)
						$color = "#C6D9F1";
					else
						$color = "#FFFFFF";
		
					if($row[2]==''){$row[2]= 0;}
		
					$dsn_reco .="<tr class='fuente_once'><td>$row[11]&nbsp;&nbsp;&nbsp;</td><td width='100' ><a style='font-weight:normal;color:#002BEC;' id='fech$i' href='javascript:void(null);' ";
					$dsn_reco .="onclick='verVehiculo($row[6],$row[7],$row[9],0,\"fech$i\");'>".conv_fecha($row[0])."</a></td>";
					$dsn_reco .="<td width='150'>".htmlentities($row[14])."</td>";
					$dsn_reco .="<td width='50'>".htmlentities($row[2]);
					$mensaje = htmlentities($row[15]);
					$_vehiculo = $row[8];
					if( $row[4] == 3 && $mensaje == "" )
					{
						$result = mysql_query("SELECT mensaje FROM c_mensajes where id_mensaje = $row[5] and id_empresa = 15 group by mensaje");
						$row_m = mysql_fetch_array($result);
						$mensaje = utf8_decode($row_m[0]);
					}
					/*if($row[10]=='')//si no trae cruce entra al web service
					{
						try//se conecta al webservice para sacar los cruces de calles.
						{ 
							$client = new SoapClient("http://160.16.18.8/Scalles/Txtcalles.asmx?wsdl", array('encoding'=>'ISO-8859-1',
								'soap_version' => SOAP_1_1,'style' => SOAP_DOCUMENT,'use' => SOAP_LITERAL,'trace' => 1));
							$la = new SoapVar($row[6], XSD_DOUBLE, "double", "http://www.w3.org/2001/XMLSchema");
							$lo = new SoapVar($row[7],  XSD_DOUBLE, "double", "http://www.w3.org/2001/XMLSchema");
							$c = new SoapVar(1, XSD_INTEGER, "integer", "http://www.w3.org/2001/XMLSchema");
							try
							{
								$resultadoc = $client->Pcalle(array("lt" => $la,"lg" => $lo, "cb" => $c));
								$calle = $resultadoc->PcalleResult;
							}catch (Exception $e){
								$error = "";			
							}
							$resultadop = $client->Pcercano(array("lt" => $la,"lg" => $lo, "cb" => $c)); 
							$poblado = $resultadop->PcercanoResult;
						}
						catch (Exception $e) {
							$poblado = "Por el momento no se puede determinar la ubicacion del vehiculo. Disculpe las molestias";						
						}
						if ($calle)
							$calle = $poblado." calle: ".$calle;
						else 
							$calle = $poblado;							 			 
					$row[10] = $calle;
					}*/
					if($row[10]==''){//si no hay bada en el campo cruce
						$calle=sitio_cercano($id_emp,$row[6],$row[7]);
						//$calle=punto_mas_cercano($row[6],$row[7],$id_emp);
					}
					else{
						$calle=$row[10];
					}
					$dsn_reco .="</td>$cuerpo<td width='200'>".$mensaje."</td><td width='330'>".$calle."</td></tr>";
					$calle = "";
					$i++;
				}
			}
			if($reg == 0)//punto inicial
			{
				//$objResponse->alert($latIni.":".$lonIni);
				$objResponse->call("StartPoint", $latIni,$lonIni);
			}
			$objResponse->call("EndPoint", $latFin,$lonFin);
			$firephp->log($geos);
			if($geos==0)$objResponse->script("xajax_mandar_geocercas($veh)");
			if($num_reg) 
			{
				$paginacion = "<table id='box-table-a1' width='765px'><tr><td><center>";
				//$dsn_reco .= "<tr><td colspan='6'>";
				//$dsn_reco .= "<center>";
				for ($j=1; $j<=$total_paginas; $j++)
				{ 
					if ($pag == $j) 
						$paginacion .= "<b style='padding-right:5px;padding-left:5px;'>".$pag."</b>"; 
					else
						if($j==1)
							$paginacion .= "<b style='padding-right:5px;padding-left:5px;cursor:pointer;' onclick='trayecto(0,$limite,$j,$num_reg,1);'>".$j."</b> "; 						
						else $paginacion .= "<b style='padding-right:5px;padding-left:5px;cursor:pointer;' onclick='trayecto($inicio-1,$limite,$j,$num_reg,1);'>".$j."</b> "; 
					$inicio = $j * $limite;
				}
				$paginacion .= "</center>";
				$paginacion .= "</td></tr>";	
			}
			$dsn_reco .= "</table></div>";
			$dsn_bot .= "<img style='cursor:pointer;' src='img2/pdf.png' border='0' width='50' height='50' onclick='form_pdf.submit()' title='Exportar PDF'/>";
			$dsn_bot .= "<img style='cursor:pointer;' src='img2/xls.png' border='0' width='50' height='50' onclick='form_xls.submit()' title='Exportar XLS'/>";
			//$dsn_bot .= " <a href='javascript:void(null)' onclick='grande(this);' title='Mostrar Reporte Grande'>";
			//$dsn_bot .= "<img src='img/rmas.png' width='20px' hight='20px' border='0'></a>";
			mysql_close($con);
		
			$panelInfo .= "";
			$panelInfo .= "<table width='765px' id='box-table-a1'><tr><td><b>Vehiculo:</b> ".htmlentities(strtoupper($_vehiculo))."</td><td></td><td align='right' style='padding-right:20px;'><b>Paginas:</b> $total_paginas</td></tr>";
			$panelInfo.=$paginacion."";
			
			$objResponse->assign("cont_reporte","innerHTML",$dsn_reco);
			$objResponse->assign("panelinfo","innerHTML",$panelInfo);			
			//$objResponse->assign("paginacionDiv","innerHTML",$paginacion);
			$objResponse->assign("panel","innerHTML",$dsn_bot);
			$objResponse->script("mostrarLinea($pag);");
		}else
		{
			$objResponse->alert("No hay registros para el rango de fechas que usted proporcionó");
			$objResponse->assign("cont_reporte","innerHTML","");
		}
		return $objResponse;  
    } 
}
function sitio_cercano($ide,$lat,$lon){
	$sess =& patSession::singleton('egw', 'Native', $options );	
	$cad_sit = "select id_sitio,latitud,longitud,nombre from sitios where id_empresa=".$sess->get("Ide");
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
function conv_fecha($f){
	$fecha = $f[8]."".$f[9]."/".$f[5]."".$f[6]."/".$f[2]."".$f[3]." ".$f[11]."".$f[12].":".$f[14]."".$f[15].":".$f[17]."".$f[18];
return $fecha;
}

function rep_tiemposm($formu,$vehi)
{
	//$firephp= FirePhp::getInstance(true);
	$objResponse = new xajaxResponse();
	$fecha_i = $formu['fecha_ini2'];
	$fecha_f = $formu['fecha_fin2'];
	$mayor  = $formu['mayor'];
	$menor  = $formu['menor'];
	$tabla = 0;
	if(count($vehi) == 0)
		$objResponse->alert("Seleccione por lo menos un vehículo");
	else//si selecciono almenos un vehiculo
	{
		if(date($fecha_i) < date($fecha_f))
	    {
			$dsn   = "<div style='position:absolute;top:10px;width:1000px;height:200px;overflow:auto;left:10px;z-index:10;'><table border='0' width='765px' id='box-table-a1'>";
			$dsn  .= "<tr>";
			$dsn  .= "<th width='200'>FECHA INICIO</th><th width='200'>FECHA FIN</th><th width='100'>TOTAL S/M</th><th width='350'>UBICACIÓN</th></tr>";
			for($k=0; $k<count($vehi); $k++)
			{
				$cad_pos = "SELECT p.id_pos, p.num_veh, p.fecha, (p.lat/3600/16),((p.long & 8388607)/3600/12*-1), p.velocidad,v.id_veh,cv.cruce,v.tipoveh";
				$cad_pos .= " FROM posiciones p";
				$cad_pos .= " left outer join vehiculos v on(v.num_veh = p.num_veh)";
				$cad_pos .= " left outer join cruce_pos cc on (cc.id_pos = p.id_pos)";
				$cad_pos .= " left outer join cruce_veh cv on (cc.id_cruce = cv.id_cruce)";
				$cad_pos .= " where p.num_veh in (".$vehi[$k].") and";
				$cad_pos .= " p.fecha between '".$fecha_i."' and '".$fecha_f."'";
				$cad_pos .= " order by p.num_veh,p.fecha asc";
				$i = 0;
				$ii = 0;
				$iii = 0;
				$j = 0;
				//$firephp->log($cad_pos,"query");
				$res_pos = mysql_query($cad_pos);
				$n_row = mysql_num_rows($res_pos);
				while($row = mysql_fetch_array($res_pos))
				{ 
					if($j%2==0)
						$color = "#C6D9F1";
					else
						$color = "#FFFFFF";					
					if($i==0)
					{
						$dsn  .= "<tr class='fuente_diez'><th colspan='4'>$row[6]</th>";
						$dsn  .= "</tr>";
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
					if($n_row == ($i+1))
					{
						if($iii==1)
							$iii = 2;
						$fecha_fin = $row[2];
					}
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
									$dsn  .= "<tr class='fuente_diez'>";
									$dsn  .= "<td width='200'><a href='javascript:void(null);' onclick='muestra_posicion($lat_cen,$lon_cen,$row[8]);'>";
									$dsn  .= conv_fecha($fecha_ini)."</a></td>";
									$dsn  .= "<td width='200'>".conv_fecha($fecha_fin)."</td><td width='100'>".(int)$difHrs." Hrs</td><td width='350'>".htmlentities($row[7])."</td></tr>";
								}
								if($menor == '' && $mayor != '' && $mayor <= (int)$difHrs)
								{ //todo
									$dsn  .= "<tr class='fuente_diez'>";
									$dsn  .= "<td width='200'><a href='javascript:void(null);' onclick='muestra_posicion($lat_cen,$lon_cen,$row[8]);'>";
									$dsn  .= conv_fecha($fecha_ini)."</a></td>";
									$dsn  .= "<td width='200'>".conv_fecha($fecha_fin)."</td><td width='100'>".(int)$difHrs." Hrs</td><td width='350'>".htmlentities($row[7])."</td></tr>";
								}
								if($mayor == '' && $menor != '' && $menor >= (int)$difHrs)
								{ //todo
									$dsn  .= "<tr class='fuente_diez'>";
									$dsn  .= "<td width='200'><a href='javascript:void(null);' onclick='muestra_posicion($lat_cen,$lon_cen,$row[8]);'>";
									$dsn  .= conv_fecha($fecha_ini)."</a></td>";
									$dsn  .= "<td width='200'>".conv_fecha($fecha_fin)."</td><td width='100'>".(int)$difHrs." Hrs</td><td width='350'>".htmlentities($row[7])."</td></tr>";
								}
								if($mayor <= (int)$difHrs && $menor >= (int)$difHrs && $mayor != '' && $menor != '')
								{ //todo
									$dsn  .= "<tr class='fuente_diez'>";
									$dsn  .= "<td width='200'><a href='javascript:void(null);' onclick='muestra_posicion($lat_cen,$lon_cen,$row[8]);'>";
									$dsn  .= conv_fecha($fecha_ini)."</a></td>";
									$dsn  .= "<td width='200'>".conv_fecha($fecha_fin)."</td><td width='100'>".(int)$difHrs." Hrs</td><td width='350'>".htmlentities($row[7])."</td></tr>";
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
									$dsn  .= "<tr class='fuente_diez'>";
									$dsn  .= "<td width='200'><a href='javascript:void(null);' onclick='muestra_posicion($lat_cen,$lon_cen,$row[8]);'>";
									$dsn  .= conv_fecha($fecha_ini)."</a></td>";
									$dsn  .= "<td width='200'>".conv_fecha($fecha_fin)."</td><td width='100'>".(int)$difMin." Min</td><td width='350'>".htmlentities($row[7])."</td></tr>";
								}
								if($menor == '' && $mayor != '' && $mayor < (int)$difMin)
								{ //todo
									$dsn  .= "<tr class='fuente_diez'>";
									$dsn  .= "<td width='200'><a href='javascript:void(null);' onclick='muestra_posicion($lat_cen,$lon_cen,$row[8]);'>";
									$dsn  .= conv_fecha($fecha_ini)."</a></td>";
									$dsn  .= "<td width='200'>".conv_fecha($fecha_fin)."</td><td width='100'>".(int)$difMin." Min</td><td width='350'>".htmlentities($row[7])."</td></tr>";
								}
								if($mayor == '' && $menor != '' && $menor > (int)$difMin)
								{ //todo
									$dsn  .= "<tr class='fuente_diez'>";
									$dsn  .= "<td width='200'><a href='javascript:void(null);' onclick='muestra_posicion($lat_cen,$lon_cen,$row[8]);'>";
									$dsn  .= conv_fecha($fecha_ini)."</a></td>";
									$dsn  .= "<td width='200'>".conv_fecha($fecha_fin)."</td><td width='100'>".(int)$difMin." Min</td><td width='350'>".htmlentities($row[7])."</td></tr>";
								}
								if($mayor < (int)$difMin && $menor > (int)$difMin && $mayor != '' && $menor != '')
								{ //todo
									$dsn  .= "<tr class='fuente_diez'>";
									$dsn  .= "<td width='200'><a href='javascript:void(null);' onclick='muestra_posicion($lat_cen,$lon_cen,$row[8]);'>";
									$dsn  .= conv_fecha($fecha_ini)."</a></td>";
									$dsn  .= "<td width='200'>".conv_fecha($fecha_fin)."</td><td width='100'>".(int)$difMin." Min</td><td width='350'>".htmlentities($row[7])."</td></tr>";
								}
							}
						}
						$iii = 0;
					}
					$fecha_tmp = $row[2];
					$lat_cen = $row[3];
					$lon_cen = $row[4];
					$veh_tmp = $row[1];
					$cruce_tmp = $row[7];
					$i++;
				}
			}
			$dsn .= "</table></div>";
			if($tabla == 0)
			{
				$objResponse->alert("No se encontraron registros, Seleccione otro vehículo");
				$objResponse->assign("cont_reporte","innerHTML","");
			}
			else
			{
				$objResponse->assign("cont_reporte","innerHTML",$dsn);
				$objResponse->assign("cont_reporte","innerHTML",$dsn);
				$objResponse->assign("form2_pdf","innerHTML","<textarea name='dsn' >$dsn</textarea>
			<input type='hidden' name='idsistema' />");
				
			$dsn_bot .= " <a href='javascript:void(null)' onclick='form2_pdf.submit()' title='Exportar PDF' >";
			$dsn_bot .= "<img src='img2/pdf.png' border='0' width='50' height='50'/></a>";
				$objResponse->assign("form2_xls","innerHTML","<textarea name='dsn' >$dsn</textarea>
			<input type='hidden' name='idsistema' />");
			$dsn_bot .= " <a href='javascript:void(null)' onclick='form2_xls.submit()' title='Exportar XLS' >";
			$dsn_bot .= "<img src='img2/xls.png' border='0' width='50' height='50'/></a>";
				//$dsn_bot .= " <a href='javascript:void(null)' onclick='grandesm(this,1);' title='Mostrar Reporte Grande'>";
				//$dsn_bot .= "<img src='img/rmas.png' width='20px' hight='20px' border='0' ></a>";
				$objResponse->assign("panel","innerHTML",$dsn_bot);
			}
	    }//del if si las fechas son correctas
	    else $objResponse->alert("Error en parametros de fecha, Intente nuevamente".$fecha_i."-".$fecha_f);
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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>Reporte de Recorrido</title>
 
<link href="css/black.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="librerias/tabla/tabla.css" type="text/css" media="screen">
<!--<link rel="stylesheet" href="librerias/colorpicker.css" type="text/css" />
<link rel="stylesheet" media="screen" type="text/css" href="librerias/layout.css" />-->
<script type="text/javascript" src="librerias/tabla/ajax.js"></script>
<script type="text/javascript" src="librerias/tabla/tabla.js"></script>
<!-- <script type='text/javascript' src="librerias/funciones_rebe.js"></script> -->
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
</style>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
<script language="JavaScript">
function calendario(id){
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
<script type='text/javascript' src="librerias/func_recorridoCambios.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&;amp;language=es"></script>
<script type="text/javascript">
//idleTime = 0;
/*$(document).ready(function () {
    //Increment the idle time counter every minute.
  //  var idleInterval = setInterval("opener.timerIncrement()", 60000); // 1 minute

    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        opener.idleTime = 0;
    });
    $(this).keypress(function (e) {
        opener.idleTime = 0;
    });
})*/
</script>
<!--<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAAvvCDspsox0cIcm7N5XsVFhS6tFE1rR0LV4ryqT8iCO2IKV5WVRQulNHiecDW7ym88gDAMrEGrAt4UQ"
      type="text/javascript"></script>-->
<!--<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAzr2EBOXUKnm_jVnk0OJI7xSosDVG8KKPE1-m51RBrvYughuyMxQ-i1QfUnH94QxWIa6N4U6MouMmBA"
      type="text/javascript"></script>-->
	  
<?php //genera el java script necesario para la aplicacin.
//echo GetKey(); //imprime el API Key de google adecuado
$xajax->printJavascript();
 ?>
</head>
<body id="fondo1" style='width:1050px;height:100%;overflow-x:auto;' onload="tipo(1,<?php echo (int)$sess->get("Ide");?>,<?php echo (int)$idu ?>);load();" >
<div id="fondo1" style='width:1050px;height:100%;'>
	<div id="fondo2" style='width:1050px;height:100%;'>
		<div id="fondo3" style='width:1050px;height:100%;'>
		<center>
	<form id="myform" name="myform" action="javascript:void(null);" onsubmit="return false;" >  		
	<div id="cuerpoSuphead" style='width:1050px;height:100%;'>
		<div id="logo"><img src='img2/logo1.png'></div><!--Nos muestra el logo de la pagina "oficial"-->
	</div>
	<div id="conf_recorrido">
		<ul id="nav1" class="drop1" >
			<li id="liga_rec" title='Reporte de Recorrido' onclick="tipo(1,<?php echo (int)$ide; ?>,<?php echo (int)$idu; ?>);">
				<a href="javascript:void(null);" ><img src='img2/recorrido.png' height='30'></a>
            </li>
			<li id='liga_ult' title='&Uacute;ltima Posici&oacute;n' onclick="tipo(5,<?php echo (int)$ide; ?>,<?php echo (int)$idu; ?>);">
				<a href="javascript:void(null);" > <img src='img2/final.png' height='30'></a>
			</li>
			<li id='tiempo_sin' title='Tiempo sin Movimiento' onclick="tipo(2,<?php echo (int)$ide;?>,<?php echo (int)$idu; ?>);">
				<a href="javascript:void(null);" ><img src='img2/tiempo.png' height='30'></a>
			</li>
		</ul>
	</div>  
	<div id="warming"></div>
            
	<div id="cont_autos2">
		<!--<div id="dhtmlgoodies_tabView1">
			<div class="dhtmlgoodies_aTab" >
				<div id="veh_checks"></div>
			</div>
			<div class="dhtmlgoodies_aTab">
				<div id='variables_reporte'></div>
			</div>
		</div>-->
		<div id="veh_checks"></div>
		<div id='variables_reporte'></div>
	</div>
	<script type="text/javascript">
	//initTabs('dhtmlgoodies_tabView1',Array('Vehículos','Variables'),0,350,350);
	</script>
	<div id="cont_mapita"></div>
	<div id='panel'></div>
	<div id="cont_reporte"></div>
	<div id="panelinfo"></div>
  	<input type="hidden" value='<?php echo $idu?>' name="n_usr" id="n_usr"/> <!-- numero de usuario-->
    <input type="hidden" value='<?php echo $usn?>' name="id_usr" id="id_usr"/> <!-- username ejemplo //siloz-->
    <input type="hidden" value='<?php echo $ide?>' name="id_emp" id="id_emp"/> <!-- numero de empresa-->
</div>	
</form>
<form name="form_xls" id="form_xls" method="post" action="reporte_xls.php?idem=<?php echo $ide?>" style="visibility:hidden"></form>
<form name="form_pdf" id="form_pdf" method="post" action="reporte_pdf.php?idem=<?php echo $ide?>" style="visibility:hidden"></form>
<form name="form2_xls" id="form2_xls" method="post" action="reporte_sm.php" style="visibility:hidden"></form>
<form name="form2_pdf" id="form2_pdf" method="post" action="reporte_pdf_sm.php" style="visibility:hidden"></form>
		</center>
		</div>
	</div>
</div>
</body>
</html>