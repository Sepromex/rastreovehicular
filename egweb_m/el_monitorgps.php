<?
require("../phpmailer/class.phpmailer.php");
setlocale(LC_ALL, 'spanish-mexican');
function calles($lat,$lon,$veh,$ide){
	//$conec2 = @mysql_connect("10.0.0.2","usercruce","server");
	//$conec2 = @mysql_connect("localhost","root","admin");
	//$conec2 = @mysql_connect("localhost","usercruce","server");
	$conec2 = @mysql_connect("10.0.2.13","usercruce","server");
	if(!$conec2){
		echo mysql_error();
	}
	else{
		mysql_select_db("crucev2", $conec2);
	}
	$estados="SELECT nombre
	FROM municipios
	where Crosses(area,GeomFromText('POINT($lat $lon)'))";
	$est=mysql_query($estados,$conec2);
	$estado=mysql_fetch_array($est);
	$estado=htmlentities($estado[0]);
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
	$r=mysql_query($procedure,$conec2);
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
	$conec=mysql_connect("10.0.1.3","egweb","53g53pr0");
	if(!$conec){
		echo mysql_error();
	}
	else{
		mysql_select_db("sepromex", $conec);
	}
	$cad_sit = "select id_sitio,latitud,longitud,nombre from sitios where id_empresa = $ide and activo=1";
	$res_sit = mysql_query($cad_sit,$conec);
	$num = mysql_num_rows($res_sit);
	if($num > 0){
		$degtorad = 0.01745329; 
		$radtodeg = 57.29577951; 
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
	$calle=strtolower($calle);
	$municipio=strtolower($municipio);
	$cadena=ucwords($calle).",".ucwords($cercano).$estado;
	return utf8_encode($cadena);
}
function correo($veh,$titulo,$tipo,$idlog){
	$conec=mysql_connect("10.0.1.3","egweb","53g53pr0");
	if(!$conec){
		echo mysql_error();
	}
	else{
		mysql_select_db("sepromex", $conec);
	}
	$q_e=mysql_query("SELECT e.nombre,v.id_veh,u.t_mensaje,u.entradas,u.velocidad,e.id_empresa,
	(u.lat/3600/16),((u.long & 8388607)/3600/12*-1),u.fecha
	from empresas e 
	inner join vehiculos v on e.id_empresa=v.id_empresa
	inner join ultimapos u on v.num_veh=u.num_veh
	where v.num_veh=$veh",$conec);
	$datos=mysql_fetch_array($q_e);
	$empresa=$datos[0];
	$id_veh=$datos[1];
	$t_mensaje=$datos[2];
	$entrada=$datos[3];
	$vel=$datos[4];
	$id_empresa=$datos[5];
	$lat=$datos[6];
	$lon=$datos[7];
	$fecha=strtotime($datos[8]);
	
	$fechacorreo=utf8_encode(ucwords(strftime('%A %d de %B de %Y', strtotime(($datos[8])))));
	$horacorreo=date("H:i:s",strtotime(($datos[8])));
	
	$pos_tipo="Posici&oacute;n autom&aacute;tica";
	if($t_mensaje==3){
		$q_m=mysql_query("SELECT mensaje from c_mensajes where id_mensaje=$entrada and id_empresa=$id_empresa",$conec);
		if(mysql_num_rows($q_m)==0){
			$q_m=mysql_query("SELECT mensaje from c_mensajes where id_mensaje=$entrada and id_empresa=15",$conec);
			$p_tipo=mysql_fetch_array($q_m);
		}
		else{
			$p_tipo=mysql_fetch_array($q_m);
		}
		$pos_tipo=$p_tipo[0];
	}
	$calles=calles($lat,$lon,$veh,$id_empresa);
	
	switch($tipo){
		case 0:
		$mensaje="
		<!doctype>
			<html>
			<head>
				<style>
					body {font-family: 'Calibri', Candara, Segoe, Optima, Arial, sans-serif;font-size:12pt;}
				</style>
			</head>
			<body class='text'>
				<div align='left'><img src='http://200.39.13.94:81/beta_egweb/img/logo-sombra_correo.png'></div>
				<div style='clear:both'></div>
				<br>
				<br>
				Estimado cliente: <b>$empresa</b>.
				<br>
				<br>
				La unidad <b>$id_veh</b> presenta un desfase en su reporte, la &uacute;ltima posici&oacute;n de su veh&iacute;culo fue en: 
				<br>
				<b>$calles</b> con el mensaje <b>$pos_tipo</b> y velocidad <b>$vel</b> km/h el d&iacute;a <b>$fechacorreo</b> a las <b>$horacorreo</b><br>
				<a href='http://200.39.13.94:81/EGWeb/maps.php?q=$veh,".date("YmdHis",$fecha).",$lon,$lat'>Ver mapa</a>
				<br>
				<br>
				Le solicitamos se comunique a nuestro centro de monitoreo lo antes posible para confirmar si la unidad esta en resguardo o bien, si requiere se inicie un operativo de recuperaci&oacute;n. 
				<br>
				<br>
				Vias de atenci&oacute;n 24hrs 365 d&iacute;as:
				<br> 
				<br>
				Tel&eacute;fono en GDL: <a href='tel:38255200,104'>38 25 52 00</a> ext 104 y 105. 
				<br>
				Lada sin costo: <a href='tel:018004000477'>01 800 4000 477</a>
				<br>
				Celular, Whatsapp o Line: <a href='tel:3314810628'>(33)14 81 06 28</a>
				<br>
				Mail:<a href='mailto:monitoreo_gps@sepromex.com.mx'>monitoreo_gps@sepromex.com.mx</a>
				<br>
				Skype: <a href='skype:gpssepromex'>gpssepromex</a>
				<br>
				<br>
				Si desea configurar el intervalo en que llega este correo de click en el siguiente enlace:
				<a href='http://200.39.13.94:81/beta_egweb/notificaciones.php?num_veh=$veh&accion=tarde'>Notificar m&aacute;s tarde</a>
				<br>
				Si desea dejar de recibir estas notificaciones, de click en el siguiente enlace:
				<a href='http://200.39.13.94:81/beta_egweb/notificaciones.php?num_veh=$veh&accion=desactivar'>Desactivar notificaciones</a>
				<br>
				<br>
				Quedamos a la espera de sus comentarios.
				<br>
				Gracias!
				<br>
				<br>
				Para recuperar los detalles de este evento, puede obtener un reporte de recorrido entrando al sistema EGWEB.
			</body>
			</html>";
		break;
		case 1:
		$mensaje="
		<!doctype>
			<html>
			<head>
				<style>
					body {font-family: 'Calibri', Candara, Segoe, Optima, Arial, sans-serif;font-size:12pt;}
				</style>
			</head>
			<body class='text'>
				<div align='left'><img src='http://200.39.13.94:81/beta_egweb/img/logo-sombra_correo.png'></div>
				<div style='clear:both'></div>
				<br>
				<br>
				Estimado cliente: <b>$empresa</b>.
				<br>
				<br>
				La unidad <b>$id_veh</b> que presentaba un desfase en su reporte, actualmente reporta y nos indica posici&oacute;n en: 
				<br>
				<b>$calles</b> con el mensaje <b>$pos_tipo</b> y velocidad <b>$vel</b> km/h el d&iacute;a <b>$fechacorreo</b> a las <b>$horacorreo</b> <br>
				<a href='http://200.39.13.94:81/EGWeb/maps.php?q=$veh,".date("YmdHis",$fecha).",$lon,$lat'>Ver mapa</a>
				<br>
				Vias de atenci&oacute;n 24hrs 365 d&iacute;as:
				<br> 
				<br>
				Tel&eacute;fono en GDL: <a href='tel:38255200,104'>38 25 52 00</a> ext 104 y 105. 
				<br>
				Lada sin costo: <a href='tel:018004000477'>01 800 4000 477</a>
				<br>
				Celular, Whatsapp o Line: <a href='tel:3314810628'>(33)14 81 06 28</a>
				<br>
				Mail:<a href='mailto:monitoreo_gps@sepromex.com.mx'>monitoreo_gps@sepromex.com.mx</a>
				<br>
				Skype: <a href='skype:gpssepromex'>gpssepromex</a>
				<br>
				Quedamos a la espera de sus comentarios.
				<br>
				<br>
				Para recuperar los detalles de este evento, puede obtener un reporte de recorrido entrando al sistema EGWEB.
			</body>
			</html>";
		break;
	}

	$mail = new PHPMailer(true);
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->Port = 26;
	$mail->Host = "mail.sepromex.com.mx";
    $mail->Username = "notifica@sepromex.com.mx";
    $mail->Password = "6652273833a";
    $mail->Timeout=30;
    $mail->From = "notifica@sepromex.com.mx";
    $mail->FromName = "Notificaciones SEPROMEX";   
    $mail->IsHTML(true);
    $mail->Priority=1;
	$mail->Subject =$titulo." ".$id_veh;
	//$mail->SMTPDebug = 2;
	//AGREGAR CORREOS CORRECTOS
	
	$q_mail=mysql_query("SELECT correo from el_monitorgps where num_veh=$veh",$conec);
	$d_correos=mysql_fetch_array($q_mail);
	$correos=explode(";",$d_correos[0]);
	for($i=0;$i<count($correos);$i++){
		$mail->AddAddress($correos[$i]);
	}
	//$mail->AddBCC("jfletes@sepromex.com.mx");//correo de "reespaldos"
	$mail->Body =$mensaje;
	$intentos=0;
    $exito=$mail->Send();
    $intentos=1;		
	while ((!$exito) && ($intentos < 5)) {
		$exito = $mail->Send();
		$intentos=$intentos+1;	
	} 
    		
	if(!$exito){	
		mysql_quer("UPDATE el_monitorgpslog set procesado=0 where idlog=$idlog");  
		return "error";
	}
	else{
		if($idlog!=0){//si no estaba procesado
			mysql_query("UPDATE el_monitorgpslog set procesado=1 where idlog=$idlog",$conec);
			mysql_query("UPDATE el_monitorgps set alarmado=1,aviso='".date("Y-m-d H:i:s")."' where num_veh=$veh",$conec);
		}
		if($tipo==1){//se reestablecio la señal
			mysql_query("UPDATE el_monitorgps set alarmado=0,aviso='0000-00-00 00:00:00' where num_veh=$veh",$conec);
		}
		else{//aun no hay señal y se actualiza el campo aviso y alarmado en caso de ser necesario
			mysql_query("UPDATE el_monitorgps set alarmado=1,aviso='".date("Y-m-d H:i:s")."' where num_veh=$veh",$conec);
		}
		return "OK";
	}
}
function poleo($veh){
	$socket = socket_create(AF_INET, SOCK_DGRAM, 0);
	$conectado = socket_connect($socket, "10.0.2.8", '6668');		//$ipcerebro	
	if ($conectado) {
		$package = "POLL:42630;".$veh;
		socket_send($socket, $package, strlen($package), 0);	
		socket_close($socket);
		/*
		$consulta = "insert into auditabilidad values (0,'$idu','".date("Y-m-d H:i:s")."','4',
		'Solicitar Posicion (poleo)',13,$ide,'".get_real_ip()."')";
		mysql_query($consulta,$conec);
		*/
	}
}
$conec=mysql_connect("10.0.1.3","egweb","53g53pr0");
if(!$conec){
	echo mysql_error();
}
else{
	mysql_select_db("sepromex", $conec);
}
/*
	Inicia trabajo del monitorista
*/
//envio de correos pendientes
$query=mysql_query("select num_veh,evento,idlog from el_monitorgpslog where procesado=0 order by idlog desc limit 50",$conec);
if(mysql_num_rows($query)>0){
	while($row=mysql_fetch_array($query)){
		$titulo="";
		if($row[1]==0){
			$titulo="Desfase de posiciones";
		}
		else{
			$titulo="Posiciones reestablecidas";
		}
		correo($row[0],$titulo,$row[1],$row[2]);
	}
}
//comprobamos si hay desfase
$query2=mysql_query("select num_veh,aviso,avisarcadahr,horaini,horafin,minsinactividad from el_monitorgps 
where creacion<='".date("Y-m-d H:i:s")."'
and vence>='".date("Y-m-d H:i:s")."'
and activo=1
and notificar=1",$conec);
if(mysql_num_rows($query2)>0){//si hay reglas activas y en fecha
	while($row=mysql_fetch_array($query2)){
		//echo "auto evaluando ".$row[0]."... <br>";
		$ver=mysql_query("SELECT fecha from ultimapos where num_veh=".$row[0]." limit 1",$conec);
		$fecha=mysql_fetch_array($ver);
		$f_u=ceil(strtotime($fecha[0])/60);
		$f_a=ceil(strtotime(date("Y-m-d H:i:s"))/60);
		$f_aviso=ceil(strtotime($row[1])/60);
		list($d_ini,$h_ini)=explode(" ",$row[3]);
		list($d_fin,$h_fin)=explode(" ",$row[4]);
		if((ceil(strtotime($h_ini)/60)<=$f_a) && (ceil(strtotime($h_fin)/60)>=$f_a)){//si esta en el horario establecido
			//echo "esta dentro del horario<br>";
			if(($f_a-$f_u)>=60 && ($f_a-$f_u)<=65 ){//si lleva una hora sin reportar, poleamos
				poleo($row[0]);
				//echo "sen envia poleo <br>";
			}
			else{//si no reacciona con los poleos (5 poleos)
				if(($f_a-$f_u)>=120){//si el vehiculo llega a las 2 horas o mas sin reportar
					//echo "lleva mas de 120 min <br>";
					/*
						checo el ultimo log del vehiculo
					*/
					//echo $f_a-$f_u." minutos";//actual menos ultima pos
					$log=mysql_query("Select * from el_monitorgpslog where num_veh=".$row[0]."
										order by idlog desc limit 1",$conec);
					if(mysql_num_rows($log)==0){//si no hay logs insertamos el desconectado
						mysql_query("Insert into el_monitorgpslog values(0,'".date("Y-m-d H:i:s")."',$row[0],0,0)",$conec);
						//echo "sufrio desconexion<br>";
					}
					else{//si hay logs de evento
						$u_evento=mysql_fetch_array($log);
						$evento=$u_evento[3];
						//echo "ya hay logs<br>";
						if($evento==0){//si el ultimo evento es una perdida de señal
							//echo "evalua la desconexion<br>";
							//envio correos periodicos
							if(($f_a-$f_aviso)>=($row[2]*60)){
								//echo "avisa periodicamente<br>";
								correo($row[0],"Desfase de posiciones",0,0);
							}
						}
						else{
							//echo "esta desconectado nuevamente<br>";
							mysql_query("Insert into el_monitorgpslog values(0,'".date("Y-m-d H:i:s")."',$row[0],0,0)",$conec);
						}
					}	
				}
				else{//reconexion
					if(($f_a-$f_u)<=60){//si tiene una posicion "actual"
						//echo "esta en tiempo<br>";
						$log=mysql_query("Select * from el_monitorgpslog where num_veh=".$row[0]."
								order by idlog desc limit 1",$conec);//ultimo evento del log
						$u_evento=mysql_fetch_array($log);
						$evento=$u_evento[3];
						if($evento==0){//si el ultimo evento es una perdida de señal
							//echo "se recupera de la desconexion<br>";
							mysql_query("Insert into el_monitorgpslog values(0,'".date("Y-m-d H:i:s")."',$row[0],1,0)",$conec);
						}
					}
				}
			}
		}
		
	}	
}
//echo "funciona";//si no imprime esto hay algun error de sintaxis
?>