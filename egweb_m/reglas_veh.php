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
	$xajax->configure('javascript URI', '../xajaxs/');
	$xajax->register(XAJAX_FUNCTION,"vehiculos");
	$xajax->register(XAJAX_FUNCTION,"vehiculos_check");
	$xajax->register(XAJAX_FUNCTION,"ver_geocercas");
	$xajax->register(XAJAX_FUNCTION,"guardar_asignacion");
	$xajax->register(XAJAX_FUNCTION,"borrar");
	$xajax->register(XAJAX_FUNCTION,"findResponseStatus");
	$xajax->register(XAJAX_FUNCTION,"borrar_regla");

function findResponseStatus($idsistema,$idRequest,$veh){
	$objResponse = new xajaxResponse();
	$sistemas=mysql_query("SELECT veh_x1 FROM vehiculos v where v.num_veh=$veh AND v.id_sistema=$idsistema");
	$sistema=mysql_fetch_array($sistemas);
	if(preg_match("/axps/i",$sistema[0])){
		$equipoGps = CONFIGSIS::getObjectFromSistem(43);
	}
	else{
		$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	}
	//$objResponse->alert($idRequest);
	$result = $equipoGps->getStatusResponseGEO($idRequest);
	//$objResponse->alert($result);
	if( $result == "CONECTADO" ){
		$objResponse->script($equipoGps->activaConfigGEO($veh));
	}else if ( $result == "DESCONECTADO" ) {
		$objResponse->script("cancelTimerNotConectedGEO($veh)");
	}else $objResponse->script("setUpTimerOnlineGEO($veh,'".$idRequest."')");
	return $objResponse;		
}
function vehiculos(){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$idu=$sess->get("Idu");
	$query="select v.id_veh,v.num_veh,s.tipo_equipo
			from veh_usr as vu
			inner join vehiculos v on vu.num_veh = v.num_veh
			inner join estveh ev on (v.estatus = ev.estatus)
			inner join sistemas S ON v.id_sistema=S.id_sistema
			where vu.id_usuario = $idu 
			AND ev.publicapos=1
			order by S.tipo_equipo,v.id_veh asc";
	$rows=mysql_query($query);
	if(mysql_num_rows($rows)>0){
		$cont= "<table id='newspaper-a1' width='175px' style='padding:0px;margin:0px;' name='checador'>
				<tr>
					<th colspan='2' style='font-size:14px;width:150px;'>Vehiculo</th>
				</tr>";
				$i=0;
		$tipo_sis='';
		while($row=mysql_fetch_array($rows)){
			if($tipo_sis!=$row[2]){
				$descrip=mysql_query("SELECT tipo_equipo from sistemas where tipo_equipo='".$row[2]."'");
				$desc=mysql_fetch_array($descrip);
				$cont.="<tr><th colspan='2'>".$desc[0]."</th></tr>";
				$tipo_sis=$row[2];
			}
			$cont.="<tr>
						<td colspan='2'><input type='checkbox' onclick='contar()' id='idVeh' name='Veh".$i."' value='".$row[1]."'>"
						.$row[0]."
						</td>
					</tr>
			";
			$i++;
		}
		$cont.= "</table>";	
	}
	else{
		$cont="Aun no cuenta con ninguna regla para sus veh&iacute;culos...";
	}
	$objResponse->assign("vehiculos_config_geo","innerHTML",$cont);
return $objResponse;
}
function borrar($folio,$vehiculo,$geo){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$idu=$sess->get("Idu");
	if(count($folio)==1){//verificamos cuantos folios diferentes tenemos
		//si solo tenemos 1 borramos directamente
		mysql_query("DELETE FROM gpscondicionalertadet WHERE folio=".$folio[0]." AND num_veh=$vehiculo AND num_geo=$geo");
		$qborrar=mysql_query("SELECT * FROM gpscondicionalertadet WHERE folio=".$folio[0]);
		if(mysql_num_rows($qborrar)==0){//si despues de borrar no hay ningun vehiculo, borramos el folio de la tabla gpscondicionalerta
			mysql_query("DELETE FROM gpscondicionalerta WHERE folio=".$folio[0]);
			/*		
			ALTER TABLE
			$ultimo=mysql_query("SELECT MAX(folio) FROM gpscondicionalerta");
			$ultimo=mysql_fetch_array($ultimo);
			$q="ALTER TABLE gpscondicionalerta auto_increment=".$ultimo[0];
			mysql_query($q);*/
		}
		
	}
	if(count($folio)>1){
		for($i=0;$i<count($folio);$i++){
			$query=mysql_query("SELECT * FROM gpscondicionalertadet WHERE folio=".$folio[$i]." AND num_veh=$vehiculo AND num_geo=$geo");
			if(mysql_num_rows($query)==1){
				mysql_query("DELETE FROM gpscondicionalertadet WHERE folio=".$folio[$i]." AND num_veh=$vehiculo AND num_geo=$geo");
			}
			$qborrar=mysql_query("SELECT * FROM gpscondicionalertadet WHERE folio=".$folio[$i]);
			if(mysql_num_rows($qborrar)==0){//si despues de borrar no hay ningun vehiculo, borramos el folio de la tabla gpscondicionalerta
				mysql_query("DELETE FROM gpscondicionalerta WHERE folio=".$folio[$i]);
				/*
				$ultimo=mysql_query("SELECT MAX(folio) FROM gpscondicionalerta");
				$ultimo=mysql_fetch_array($ultimo);
				mysql_query("ALTER TABLE gpscondicionalerta auto_increment=".$ultimo[0]);
				*/
			}
		}
	}
	//$objResponse->alert($q);
	if(mysql_error()){
		$objResponse->alert(mysql_error());
	}
	else{
		$objResponse->script("contar()");
	}
	return $objResponse;
}
function guardar_asignacion($T_dias,$T_geo,$T_veh,$inicio,$fin,$minima,$maxima,$descrip,$correos,$dentro,$fuera,$semana,$mes,$activo,$folio){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$ide=$sess->get("Ide");
	
	//si selecciono semana y mes la letra "T"
	$total_dias=count($T_dias);
	if($semana==1 && $mes==1){
		$dias="T";
	}
	else{
		if($semana==1){
			$dias="S:";
		}
		if($mes==1){
			$dias="M:";
		}
		if($semana==0 && $mes==0){
			$semana=1;
			$mes=0;
			$dias="S:";
		}
		for($i=0;$i<$total_dias;$i++){
			$dias.=$T_dias[$i];
			if($i<$total_dias-1){
				$dias.=",";
			}
		}
	}
	//revisamos la lista de correos
	if(preg_match("/,/",$correos)){//estan separados por ","
		$lista_correos=str_replace(",",";",trim($correos));
	}
	else{
		$lista=explode("\n",$correos);
		for($i=0;$i<count($lista);$i++){
			$lista_correos=trim($lista[$i]);
			if($i<(count($lista)-1)){
				$lista_correos.=";";
			}
		}
	}
	if($minima=='' || $minima==0){
		$minima='-1';
	} 
	if($maxima=='' || $maxima==0 ){
		$maxima='-1';
	}
	$cumple="0";//cumple con "todas" las reglas puestas
	$activar_salida=0;//en la tabla activar salida
	$fecha_actual=date("Y-m-d H:i:s");
	$mensaje_clave=0;
	if($inicio==''){
		$inicio='0000-00-00 00:00:00';	
	}
	if($fin==''){
		$fin='0000-00-00 00:00:00';
	}
	if($fin!='0000-00-00 00:00:00' || $inicio!='0000-00-00 00:00:00'){
		$no_repetir=0;											//****************************tiempo entre las notificaciones	
	}
	else{
		$no_repetir=0;
	}
	if($folio==0){//si no hay ningun folio agregamos "nuevo"
		//insert para sacar el numero de folio
		$query="INSERT INTO gpscondicionalerta values(0,'$descrip',$cumple,$ide,'$fecha_actual',
				'$lista_correos',$activar_salida,$mensaje_clave,$no_repetir,$activo,-1,0,0,0,-1);";
		// ---> id_folio
		mysql_query($query);
		
		$folio=mysql_insert_id();//devuelve el id insertado en la consulta anterior
		//este query sera en base a los vehiculos
		$total_veh=count($T_veh);
		$total_geo=count($T_geo);
		for($i=0;$i<$total_veh;$i++){
			//asignamos las geocercas del vehiculo
			if($total_geo!=0){
				for($j=0;$j<$total_geo;$j++){
					$query="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",".$T_veh[$i].",$mensaje_clave,$minima,$maxima,".$T_geo[$j].",
							$dentro,$fuera,'$inicio','$fin',$no_repetir,0,1,$activo,'$dias','$fecha_actual','-1',0,0,0);";
					mysql_query($query);
				}
			}
			else{
				$query="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",".$T_veh[$i].",$mensaje_clave,$minima,$maxima,'0',
						$dentro,$fuera,'$inicio','$fin',$no_repetir,0,1,$activo,'$dias','$fecha_actual','-1',0,0,0);";
				mysql_query($query);
				//$objResponse->alert(mysql_error());
			}
		}
	}
	else{//si se mando uno o mas folios
		for($i=0;$i<count($folio);$i++){
			//borramos los folios existentes
			mysql_query("DELETE FROM gpscondicionalertadet WHERE folio=".$folio[$i]);
			mysql_query("DELETE FROM gpscondicionalerta WHERE folio=".$folio[$i]);
		}
		//agregamos el nuevo folio
		//insert para sacar el numero de folio
		$query="INSERT INTO gpscondicionalerta values(0,'$descrip',$cumple,$ide,'$fecha_actual',
				'$lista_correos',$activar_salida,$mensaje_clave,$no_repetir,$activo,-1,0,0,0,-1);";
		// ---> id_folio
		mysql_query($query);
		$folio=mysql_insert_id();//devuelve el id insertado en la consulta anterior
		//este query sera en base a los vehiculos
		$total_veh=count($T_veh);
		$total_geo=count($T_geo);
		for($i=0;$i<$total_veh;$i++){
			//asignamos las geocercas del vehiculo
			for($j=0;$j<$total_geo;$j++){
				$query="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",".$T_veh[$i].",$mensaje_clave,$minima,$maxima,".$T_geo[$j].",
						$dentro,$fuera,'$inicio','$fin',$no_repetir,0,1,$activo,'$dias','$fecha_actual','-1',0,0,0);";
						mysql_query($query);
			}
		}
	}
	//asignaremos el comando al equipo que se pueda mandar dicho comando
	$total_veh=count($T_veh);
	$configurables=array(
		'comando CAN'=>'U1CAN',
		'comando LITE'=>'U1LITE',
		'comando PRO'=>'U1PRO'
		);
	for($i=0;$i<$total_veh;$i++){
		//query para verificar el nombre del equipo
		$query="SELECT TE.descripcion
			FROM tipo_equipo AS TE 
			INNER JOIN sistemas AS S ON TE.id_tipo_equipo=S.tipo_equipo
			INNER JOIN vehiculos AS V ON S.id_sistema=V.id_sistema
			WHERE V.num_veh=".$T_veh[$i];
		$rows=mysql_query($query);
		
		$row=mysql_fetch_array($rows);
		$config=array_search(strtoupper($row[0]),$configurables);//verificamos si el equipo es configurable
		if($config!=''){//si esta en la lista de los configurables entramos
		//creamos un socket para enviar el dato al equipo
			
			/*$socket = socket_create(AF_INET, SOCK_DGRAM, 0);
			//$conectado = socket_connect($socket, '10.0.2.8', 6668);	
			$conectado = socket_connect($socket, '160.16.18.129', 6668);				
			if ($conectado) {
				$package = "368888,$idRequest,$index,;M";
				socket_send($socket, $package, strlen($package), 0);		
				socket_close($socket);
			}
			*/
			//$objResponse->alert("Entra para : ".$T_veh[$i]." Tipo: ".$row[0]);
		}
	}
	
	if(!mysql_error()){
		$objResponse-> redirect("reglas_veh.php?guardado");
	}
	else{
		$objResponse->alert(mysql_error());
	}
	return $objResponse;
}

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
		$cad_geo .= " where num_geo =". $id_geo[$i];

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
		$ids = join(',',$veh);
		$dif_tipos=mysql_query("SELECT s.tipo_equipo from vehiculos v inner join sistemas s on v.id_sistema=s.id_sistema where num_veh IN ($ids) group by s.tipo_equipo");
		//$objResponse->alert();
		$diferentes_sis=mysql_num_rows($dif_tipos);
		//$busq="";
		$busq="AND (GPS_DET.num_veh IN (".$ids.") OR GPS_DET.num_veh NOT IN (".$ids."))";
		//$busq="AND (GPS_DET.num_veh NOT IN (".$ids."))";
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
			AND GPS_DET.num_geo=".$id_geo[$i]."
			AND (GPS_DET.horaini <= NOW() OR GPS_DET.horaini = '0000-00-00 00:00:00' 
				AND GPS_DET.horafin >= NOW() OR GPS_DET.horafin = '0000-00-00 00:00:00' )
			$busq";
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
				$ini=str_replace('0000-00-00 ','',$row[2]);
				$fin=str_replace('0000-00-00 ','',$row[3]);
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
		if(in_array($veh[$i],$todos_vehiculos)){
		}
		else{
			$todos_vehiculos[]=$veh[$i];
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
		if(mysql_num_rows($qver)>0){
			$xd=mysql_fetch_array($qver);
			$guardado="<img title='Guardado en la base de datos' src='img2/delete.png' width='15px' style='float:right;cursor:pointer;' 
			onclick='borrar(".json_encode($folio).",".$T_V[$w].",".$xd[1].")'>";
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
	/*
		Si ya tiene "reglas" establecidas
	*/
	$query="SELECT a.descripcion,a.enviaremail,a.norepetirhasta,a.activo,v.id_veh,g.folio,g.reg,g.vel_min,g.vel_max,m.mensaje,geo.nombre,
		g.entrageo,g.salegeo
		FROM gpscondicionalertadet g
		inner join gpscondicionalerta a on g.folio=a.folio
		left join vehiculos v on g.num_veh=v.num_veh
		left join c_mensajes m on g.id_msjxclave=id_mensaje
		and m.id_empresa=a.id_empresa
		left join geo_time as geo on g.num_geo=geo.num_geo
		where a.id_empresa= $ide 
		AND g.num_veh IN (".$ids.")
		AND geo.nombre!=''
		order by g.reg ASC";
	$exi=mysql_query($query);
	if(mysql_num_rows($exi)>0){
		$reg.="
			<div id='geo' style='width:750px;'>
				<span style='cursor:pointer;' onclick='ver(\"geo\",\"Con\")'>Reglas Con Geocercas</span><br>
			</div>
			<table id='newspaper-a1' class='geo' style='display:none;width:750px' >
				<tr>
					<th width='120px;'>Regla</th>
					<th width='120px;'>Correos</th>
					<th>Activo</th>
					<th>Veh&iacute;culo</th>
					<th>Geocerca</th>
					<th width='60px;' ></th>
				</tr>
			
		";
		while($row=mysql_fetch_array($exi)){
		//si hay mensaje por clave y esta "vacio" un segundo query para sacar su descripcion de la empresa 15
			$reg.="
				<tr id='".$row[5]."-".$row[6]."'>
					<td>".$row[0]."</td>
					<td>".$row[1]."</td>
					<td>".$row[3]."</td>
					<td>".$row[4]."</td>
					<td>".$row[10]."</td>
					<td>
						<img src='img2/asig_geo.png' style='cursor:pointer;padding:5px;' width='15px' height='15px' onclick='window.opener.mostrar_actualizar(".$row[5].",".$row[6].");'/>
						<img src='img/ico_delete.png' style='cursor:pointer;padding:5px;' width='15px' height='15px' onclick='xajax_borrar_regla(".$row[5].",".$row[6].");'/>
					</td>
				</tr>
			";
		
		}
		$reg.="</table>";
	}
	else{
		$reg='';
	}
	$query="SELECT a.descripcion,a.enviaremail,a.norepetirhasta,a.activo,v.id_veh,g.folio,g.reg,g.vel_min,g.vel_max,m.mensaje,
		g.entrageo,g.salegeo,g.id_msjxclave
		FROM gpscondicionalertadet g
		inner join gpscondicionalerta a on g.folio=a.folio
		left join vehiculos v on g.num_veh=v.num_veh
		left join c_mensajes m on g.id_msjxclave=m.id_mensaje
		and m.id_empresa=a.id_empresa
		where a.id_empresa= $ide 
		AND g.num_veh IN (".$ids.")
		AND g.num_geo=0
		order by g.reg ASC";
	$exi=mysql_query($query);
	if(mysql_num_rows($exi)>0){
		$reg.="
			<div id='nogeo' style='width:750px;'>
				<span style='cursor:pointer;' onclick='ver(\"nogeo\",\"Sin\")'>Reglas Sin Geocercas</span><br>
			</div>
			<table id='newspaper-a1' class='nogeo' style='display:none;width:750px'>
				<tr>
					<th width='120px;'>Regla</th>
					<th width='120px;'>Correos</th>
					<th>Activo</th>
					<th>Veh&iacute;culo</th>
					<th>Mensajes</th>
					<th width='60px;'></th>
				</tr>
			
		";
		while($row=mysql_fetch_array($exi)){
		//si hay mensaje por clave y esta "vacio" un segundo query para sacar su descripcion de la empresa 15
			$reg.="
				<tr id='".$row[5]."-".$row[6]."'>
					<td>".$row[0]."</td>
					<td>".$row[1]."</td>
					<td>".$row[3]."</td>
					<td>".$row[4]."</td>";
					if($row[9]!=''){
						$reg.="
							<td>".$row[9]."</td>";
					}
					else{
						$mensajes=mysql_query("SELECT mensaje FROM c_mensajes where id_empresa=15 AND id_mensaje=".$row[12]);
						$mensaje=mysql_fetch_array($mensajes);
						$reg.="
							<td>".$mensaje[0]."</td>";
					}
			$reg.="
					<td>
						<img src='img2/asig_geo.png' style='cursor:pointer;padding:5px;' width='15px' height='15px' onclick='window.opener.mostrar_actualizar(".$row[5].",".$row[6].");'/>
						<img src='img/ico_delete.png' style='cursor:pointer;padding:5px;' width='15px' height='15px' onclick='xajax_borrar_regla(".$row[5].",".$row[6].");'/>
					</td>
				</tr>
			";
		
		}
		$reg.="</table>";
	}
	else{
		$reg='';
	}
	//$objResponse->alert($exis);
	$objResponse->assign("contenido_geo_existe","innerHTML",$exis);
	$objResponse->assign("contenido_reg_existe","innerHTML",$reg);
	
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

function borrar_regla($folio,$reg){
	$objResponse = new xajaxResponse();
	//$objResponse->alert("entra".$folio."-".$reg);
	$ver_geo=mysql_query("SELECT num_geo,num_veh FROM gpscondicionalertadet where folio=$folio and reg=$reg");
	$ver=mysql_fetch_array($ver_geo);
	if($ver[0]!=0){//significa que si tiene geocercas asignadas, por lo que tenemos que eliminarla del equipo
		//buscamos el sistema del vehiculo, el indice de la geocerca y generamos el comando
		$sistema=mysql_query("SELECT id_sistema FROM vehiculos where num_veh=".$ver[1]);
		$idsistemas=mysql_fetch_array($sistema);
		$idsistema=$idsistemas[0];
		$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
		$query=mysql_query("SELECT index_equipo FROM geo_equipo where num_veh=".$ver[1]." AND num_geo=".$ver[0]);
		$index=mysql_fetch_array($query);
		//formamos el comando a enviar al equipo
		$cmd="SETGEO:".$ver[1].";%s;".$sess->get("Idu").";".$index[0].";0";
		//buscamos el tipo de geocerca
		mysql_query("insert into notificaweb(id,num_veh,cmd,solicito,id_usuario,origen,respuesta) values(0,".$vehiculo.",'$cmd','".date("Y-m-d G:i:s")."',".$sess->get("Idu").",'EGW','')");		
		$idRequest=mysql_insert_id();
		$cmd = sprintf($cmd,$idRequest);
		$objResponse->script($equipoGps->sendCMDtoEGServer($cmd));
		/*
				Borramos el dato en la relacion entre el equipo y la base de datos
		*/
		mysql_query("DELETE FROM geo_equipo where num_veh=".$ver[1]." AND num_geo=".$ver[0]);
	}
	mysql_query("DELETE FROM gpscondicionalertadet WHERE folio=$folio AND reg=$reg");
	$objResponse->script("oculta_regla(".$folio.",".$reg.")");
	return $objResponse;
}
$xajax->processRequest();//procesa los datos de "xajax"
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Asignaci&oacute;n de Reglas</title>
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
	<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>-->
	<script type="text/javascript"src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbr1ZoDby1GW6nP7RAgokJLqWP_95d6SE" ></script>
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
<body id="fondo1" onload="xajax_vehiculos();" style='overflow:hidden;height:620px;'>
<!--<div id="logo"></div><!--Nos muestra el logo de la pagina "oficial"-->
<!-- Estos divs son para el fondo-->
<div id="fondo1" >
<div id="fondo2">
<div id="fondo3">
<center>
<form id="form1"  name="form1" action="g_config.php" method="post">
	<div id='vehiculos_config_geo'></div>
	<div id='geocercas_config'> 
		<table id='newspaper-a1' width='175px' style='padding:0px;margin:0px;'>
			<tr>
				<th>Geocercas.</th>
			</tr>
		<? 
			$query="SELECT g.num_geo,g.nombre,g.tipo,g.latitud,g.longitud,t.descripcion
					FROM geo_time g
					INNER JOIN tipo_geocerca t on g.tipo=t.tipo
					WHERE g.id_empresa = $ide 
					ORDER BY g.nombre";
			$rows=mysql_query($query);
			while($row=mysql_fetch_array($rows)){
			?>
				<tr>
					<td>
						<input type="checkbox" name="ejec" id="ejec" onclick="contar()" value="<? echo $row[0];?>">
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
		function ver(tabla,con){
			$("."+tabla).show();
			$("#"+tabla).html("<span style='cursor:pointer;' onclick='ocultar(\""+tabla+"\",\""+con+"\")'>Reglas "+con+" Geocercas</span><br>");
		}
		function ocultar(tabla,con){
			$("."+tabla).hide();
			$("#"+tabla).html("<span style='cursor:pointer;' onclick='ver(\""+tabla+"\",\""+con+"\");'>Reglas "+con+" Geocercas</span><br>");
		}
		
		function oculta_regla(folio,reg){
			var ocultar=folio+'-'+reg;
			$("#"+ocultar).hide();
		}
	</script>
</form>
</center>
</div>
</div>
</div>
</body>
</html>