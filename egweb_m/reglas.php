<?
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
	require("librerias/SistemasConfigurables/Configsis_nuevo.php");
  	require('../xajaxs/xajax_core/xajax.inc.php');
	$xajax = new xajax(); 
	$xajax->configure('javascript URI', '../xajaxs/');
	$xajax->register(XAJAX_FUNCTION,"vehiculos");
	$xajax->register(XAJAX_FUNCTION,"mostrar_reglas");
	$xajax->register(XAJAX_FUNCTION,"actualizar");
	$xajax->register(XAJAX_FUNCTION,"borrar");
	
function vehiculos(){
$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	//$firephp= FirePhp::getInstance(true);
	$idu=$sess->get("Idu");
	$ide=$sess->get("Ide");
	$cont="";
	$query="select v.id_veh, v.num_veh,g.folio
			from veh_usr as vu
			inner join vehiculos v on vu.num_veh = v.num_veh
			inner join estveh ev on (v.estatus = ev.estatus)
			inner join gpscondicionalertadet g on vu.num_veh=g.num_veh
			inner join gpscondicionalerta ga on g.folio=ga.folio
			where vu.id_usuario = $idu 
			AND ev.publicapos=1
			AND ga.id_empresa= $ide
			group by v.id_veh 
			order by v.id_veh asc";
	$rows=mysql_query($query);
	if(mysql_num_rows($rows)>0){
	$cont.= "<table id='newspaper-a1' width='175px' style='padding:0px;margin:0px;' name='checador'>
				<tr>
					<th colspan='2' style='font-size:14px;width:150px;'>Vehiculo</th>
				</tr>";
				$i=0;
		while($row=mysql_fetch_array($rows)){
			$cont.="<tr>
						<td colspan='2'><input onclick='mostrar_reglas(".$row[1].");' type='radio' id='vehiculos' name='vehiculo[]' value='".$row[1]."'>".$row[0]."</td>
					</tr>
			";
			$i++;
		}
		$cont.="</table>";
	}
	else{
		$cont="Aun no cuenta con ninguna regla para sus veh&iacute;culos...";
	}
	$objResponse->assign("vehiculos_reglas","innerHTML",$cont);
return $objResponse;
}

function mostrar_reglas($veh){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$query="SELECT g.folio,g.descripcion,g.enviaremail,g.norepetirhasta,m.mensaje,ga.reg
	FROM gpscondicionalertadet ga
	INNER JOIN gpscondicionalerta g on ga.folio=g.folio
	INNER JOIN c_mensajes m on ga.id_msjxclave=m.id_mensaje
	WHERE m.id_empresa=15
	AND ga.num_veh=$veh";
	$rows=mysql_query($query);
	if(mysql_num_rows($rows)>0){
		$cont="
		<table id='newspaper-a1'>
			<tr>
				<th>Descripcion</th>
				<th>Correos</th>
				<th>Tiempo</th>
				<th><div id='actualizador'></div></th>
			</tr>
		";
		$f_actual='';
		while($row=mysql_fetch_array($rows)){
			if($row[0]!=$f_actual){
				$correos=str_replace(';',"<br>",$row[2]);
				$cont.="
				<tr>
					<td><textarea id='descripcion".$row[0]."'>".$row[1]."</textarea></td>
					<td><textarea id='correos".$row[0]."' cols='30' rows='3'>".str_ireplace("<br>","\r\n",$correos)."</textarea></td>
					<td><input type='text' size='1' id='tiempo".$row[0]."' value='".$row[3]."'/></td>
					<td>
						<input type='button' class='agregar1' onclick='actualizar(".$row[0].",".$veh.")' value='Actualizar' />
					</td>
				</tr>
				<tr>
					<th colspan='4'>Mensaje x Clave</th>
				</tr>";
				$f_actual=$row[0];
			}
			$cont.="
				
				<tr>
					<td colspan='3'>".$row[4]."</td>
					<td>
						<input type='button' class='cancelar1' onclick='borrar(".$row[0].",".$row[5].",".$veh.")' value='Borrar' />
					</td>
				</tr>
			";
		}
		$cont.="</table><hr>";
	}
	/*
		agregamos las reglas con geocercas
	*/
	$query="SELECT g.folio,g.descripcion,g.enviaremail,g.norepetirhasta,ga.reg,t.nombre,horaini,horafin,enlosdias
	FROM gpscondicionalertadet ga
	INNER JOIN gpscondicionalerta g on ga.folio=g.folio
	INNER JOIN geo_time t on t.num_geo=ga.num_geo 
	WHERE ga.num_veh=$veh";
	
	$rows=mysql_query($query);
	if(mysql_num_rows($rows)){
		$cont.="
		<table id='newspaper-a1'>
			<tr>
				<th>Descripcion</th>
				<th>Correos</th>
				<th>Tiempo</th>
				<th><div id='actualizador2'></div></th>
			</tr>
		";
		$f_actual='';
		while($row=mysql_fetch_array($rows)){
			if($row[0]!=$f_actual){
				$correos=str_replace(';',"<br>",$row[2]);
				$cont.="
				<tr>
					<td><textarea id='descripcion".$row[0]."'>".$row[1]."</textarea></td>
					<td><textarea id='correos".$row[0]."' cols='30' rows='3'>".str_ireplace("<br>","\r\n",$correos)."</textarea></td>
					<td><input type='text' size='1' id='tiempo".$row[0]."' value='".$row[3]."'/></td>
					<td>
						<input type='button' class='agregar1' onclick='actualizar(".$row[0].",".$veh.")' value='Actualizar' />
					</td>
				</tr>
				<tr>
					<th colspan='4'>Geocercas Asignadas</th>
				</tr>";
				$f_actual=$row[0];
			}
			if(preg_match('/S:/i',$row[8])){ //si esta el parametro por semana separamos las fechas y solo mostraremos la hora
				list($fechai,$horai)=explode(" ",$row[6]);
				list($fechaf,$horaf)=explode(" ",$row[7]);
				$horai.=" - ".$horaf;
			}
			if(preg_match('/M:/i',$row[8])){ //si esta el parametro por mes separamos las fechas y mostramos hora y fechas
				list($fechai,$horai)=explode(" ",$row[6]);
				list($fechaf,$horaf)=explode(" ",$row[7]);
				list($ai,$mi,$di)=explode("-",$fechai);
				list($af,$mf,$df)=explode("-",$fechaf);
				$horai.=" del ".$mi."/".$di." al ".$mf."/".$df;
			}
			if(preg_match('/T/i',$row[8])){
				$horai="Todo el tiempo";
			}
			
			$cont.="
				<tr>
					<td colspan='1'>".$row[5]."</td>
					<td colspan='2'>".$horai."</td>
					<td>
						<input type='button' class='cancelar1' onclick='borrar(".$row[0].",".$row[4].",".$veh.")' value='Borrar' />
					</td>
				</tr>
			";
		}
		$cont.="</table><hr>";
	}
	$objResponse->assign("contenido_reglas","innerHTML",$cont);
	return $objResponse;
}

function actualizar($folio,$desc,$correos,$tiempo,$veh){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$correos=str_replace("\n",";",trim($correos));
	$query="UPDATE gpscondicionalerta SET descripcion='$desc',enviaremail='$correos',norepetirhasta=$tiempo
	WHERE folio=$folio";
	mysql_query($query);
	if(!mysql_error()){
		$objResponse->assign("actualizador","innerHTML","Modificado<img src='img2/apply.png' width='15px' />");
	}
	else{
		$objResponse->assign("actualizador","innerHTML",mysql_error());
	}
	$objResponse->script("setTimeout('mostrar_reglas($veh)', 1000);");
	return $objResponse;
}

function borrar($folio,$reg,$veh){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$query='DELETE FROM gpscondicionalertadet WHERE folio='.$folio." AND reg=$reg";
	mysql_query($query);
	/*
	$query="DELETE FROM gpscondicionalerta WHERE folio=".$folio;
	mysql_query($query);
	*/
	if(!mysql_error()){
		$objResponse->assign("actualizador","innerHTML","<img src='img2/cancel.png' width='15px' />Eliminado");
	}
	else{
		$objResponse->assign("actualizador","innerHTML",mysql_error());
	}
	$objResponse->script("setTimeout('mostrar_reglas($veh)', 1000);");
	return $objResponse;
}

$xajax->processRequest();//procesa los datos de "xajax"
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Asignacion de reglas</title>
	<link href="css/black.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="javascript" src="librerias/SistemasConfigurables/func_Equipos.js"></script>
	<script type="text/javascript" src="jQuery1.9/js/jquery-1.8.2.js"></script>
	<script language="JavaScript">
	function mostrar_reglas(numVeh){
		xajax_mostrar_reglas(numVeh);
	}
	function actualizar(folio,veh){
		//alert(folio);
		var desc=$("#descripcion"+folio).val();
		var correos=$("#correos"+folio).val();
		var tiempo=$("#tiempo"+folio).val();
		xajax_actualizar(folio,desc,correos,tiempo,veh);
	}
	function borrar(folio,reg,veh){
		xajax_borrar(folio,reg,veh);
	}
	</script>
</head>
<body id="fondo1" onload="xajax_vehiculos();" style="width:200px;" >
<div id="fondo1" >
	<div id="fondo2">
		<div id="fondo3">
			<center>
			<form id="form1"  name="form1" action="g_config.php" method="post">
				<div id='vehiculos_reglas'></div>
				<div id='contenido_reglas'><? if(isset($_GET['bien'])){ echo "Se guardaron sus configuraciones correctamente";}?></div>
			</form>
			</center>
		</div>
	</div>
</div>
</body>
</html>