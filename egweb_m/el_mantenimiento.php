<?
set_time_limit(0);
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

function interval_date($init,$finish)
{
    //formateamos las fechas a segundos tipo 1374998435
    $diferencia = strtotime($finish) - strtotime($init);
    if($diferencia > 2592000 && $diferencia < 31104000){
        $tiempo =  floor($diferencia/2592000) . " months";
    }else if($diferencia > 31104000){
    	if($diferencia % 31104000!=0){
	    	$tiempo =  floor($diferencia/2592000) . " months";
    	}
    	else{
	    	$tiempo =  floor($diferencia/31104000) . " years";
    	}
    }else{
        $tiempo = "Error". $init."/".$finish;
    }
    return $tiempo;
}

function correo($folio,$veh,$tipo){
	$conec=mysql_connect("10.0.1.3","egweb","53g53pr0");
	if(!$conec){
		echo mysql_error();
	}
	else{
		mysql_select_db("sepromex", $conec);
	}
	$ver=mysql_query("select fechaini,fechafin,kmini,kmfin,iterahechas 
						from manttoveh_det 
						where folio=$folio 
						and num_veh=$veh 
						limit 1",$conec);
	$datos=mysql_fetch_array($ver);
	$ver_o=mysql_query("SELECT odometro from ultimapos where num_veh=$veh",$conec);
	$odo=mysql_fetch_array($ver_o);
	switch($tipo){
		case 'A':
			$lapso=interval_date($datos[0],$datos[1]);
			$final=date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." + $lapso"));
			$lapso_odo=$datos[3]-$datos[2];
			$hechas=$datos[4]+1;
			mysql_query("UPDATE manttoveh_det set 
			fechaini='".date("Y-m-d H:i:s")."',
			fechafin='$final', 
			kmini=".floor($odo[0]).",
			kmfin=".(floor($odo[0])+$lapso_odo).",
			iterahechas=$hechas 
			where folio=$folio 
			and num_veh=$veh",$conec);
		break;
		case 't': 
			$lapso=interval_date($datos[0],$datos[1]);
			$final=date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s"),"+ $lapso"));
			mysql_query("UPDATE manttoveh_det set 
			fechaini='".date("Y-m-d H:i:s")."',
			fechafin='$final',
			iterahechas=$hechas
			where folio=$folio 
			and num_veh=$veh",$conec);
		break;
		case 'k': 
			$lapso_odo=$datos[3]-$datos[2];
			mysql_query("UPDATE manttoveh_det set  
			kmini=".floor($odo[0]).",
			kmfin=".(floor($odo[0])+$lapso_odo).",
			iterahechas=$hechas
			where folio=$folio 
			and num_veh=$veh",$conec);
		break;
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
	//preventivos
	$q_prev=mysql_query("select id_tmantto from manttoveh_det where folio=$folio and num_veh=$veh and activo=1");
	$preventivos="";
	$p=1;
	while($r_p=mysql_fetch_array($q_prev)){
		$ver=mysql_query("select descripcion from tipo_mantto where descripcion like '%Revi%' and id_tmantto=".$r_p[0]);
		if(mysql_num_rows($ver)>0){
			$desc=mysql_fetch_array($ver);
			if($p==1){
				$preventivos.="Mantenimientos Preventivos: <br><br>";
			}
			$preventivos.=$p.".- ".utf8_decode($desc[0]).".<br>";
			$p++;
		}
	}
	//correctivos
	$q_corr=mysql_query("select id_tmantto from manttoveh_det where folio=$folio and num_veh=$veh and activo=1");
	$correctivos="";
	$c=1;
	while($r_c=mysql_fetch_array($q_corr)){
		$ver=mysql_query("select descripcion from tipo_mantto where descripcion not like '%Revi%' and id_tmantto=".$r_c[0]);
		if(mysql_num_rows($ver)>0){
			$desc=mysql_fetch_array($ver);
			if($c==1){
				$correctivos.="Mantenimientos Correctivos: <br><br>";
			}
			$correctivos.=$c.".- ".utf8_decode($desc[0]).".<br>";
			$c++;
		}
	}
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
		La unidad <b>$id_veh</b> con &uacute;ltima posici&oacute;n en: 
		<br>
		<b>$calles</b> con el mensaje <b>$pos_tipo</b> y velocidad <b>$vel</b> km/h el d&iacute;a <b>$fechacorreo</b> a 
		las <b>$horacorreo</b> (<a href='http://200.39.13.94:81/EGWeb/maps.php?q=$veh,".date("YmdHis",$fecha).",$lon,$lat'>
		Ver mapa</a>)<br>
		Tiene programado los siguientes mantenimientos:
		<br>
		<br>
		".mysql_error()."
		$preventivos
		$correctivos
	</body>
	</html>";

	$mail = new PHPMailer(true);
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->Port = 26;
	$mail->Host = "mail.sepromex.com.mx"; //antes 160.16.18.59
    $mail->Username = "notifica@sepromex.com.mx";
    $mail->Password = "6652273833a";
    $mail->Timeout=30;
    $mail->From = "notifica@sepromex.com.mx";
    $mail->FromName = "Mantenimientos SEPROMEX";
    $mail->IsHTML(true);
    $mail->Priority=1;
	$mail->Subject ="Mantenimiento para el vehículo: ".$id_veh;
	//$mail->SMTPDebug = 2;
	//AGREGAR CORREOS CORRECTOS
	
	$q_mail=mysql_query("SELECT enviaremail from manttoveh where folio=$folio",$conec);
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
	return "OK";
}

$conec=mysql_connect("10.0.1.3","egweb","53g53pr0");
if(!$conec){
	echo mysql_error();
}
else{
	mysql_select_db("sepromex", $conec);
}

//proceso de mantenimientos
$datos= mysql_query("select * from manttoveh where activo=1");
while($row=mysql_fetch_array($datos)){
	$mantto=mysql_query("select distinct m.folio,d.num_veh
		from manttoveh m 
		inner join manttoveh_det d on d.folio=m.folio
		where m.folio=".$row[0]." 
		and d.activo=1
		and d.iteraciones>=d.iterahechas");
	echo "analizando folio: $row[0]<br>";
	while($row_det=mysql_fetch_array($mantto)){
		echo "vehiculo $row_det[1] :<br>";
		//validacion para x1 y U1
		$q_odos=mysql_query("SELECT u.odometro,v.id_sistema 
		from ultimapos u 
		inner join vehiculos v on u.num_veh=v.num_veh
		where u.num_veh=".$row_det[1]);
		$odos=mysql_fetch_array($q_odos);
		$x1=array('16','25','28','30','32','33');//kilometraje
		$u1=array('39','41','42','91');//por metros
		$odo=floor($odos[0]);
		$mas=mysql_query("select d.tipo,d.fechafin,d.kmfin,d.iteraciones,d.iterahechas
		from manttoveh_det d 
		where folio=".$row_det[0]."
		and num_veh=".$row_det[1]."
		limit 1");
		$datos=mysql_fetch_array($mas);
		$odo_fin=floor($datos[2]);
		if(in_array($odos[1],$u1)){
			$odo=floor($odos[0]/1000);
			$odo_fin=floor($datos[2]/1000);
		}
		if($datos[3]>=($datos[4]+1)){
			list($f_vence,$hora)=explode(" ",$datos[1]);
			switch($datos[0]){
				case 't'://por tiempo
					echo "&nbsp;&nbsp;&nbsp;&nbsp;Entra tiempo.<br>";
					if(date("Y-m-d") == $f_vence){//si el plazo se cumple
						correo($row_det[0],$row_det[1],'t');
						echo "&nbsp;&nbsp;&nbsp;&nbsp;Cumple tiempo.<br>";
					}
					else{
						echo "&nbsp;&nbsp;&nbsp;&nbsp;No cumple tiempo.<br>";
					}
				break;
				case 'k'://por km
					echo "&nbsp;&nbsp;&nbsp;&nbsp;Entra km.<br>";
					if($odo>=$datos[2]){//si se cumple el kilometraje 
						correo($row_det[0],$row_det[1],'k');
						echo "&nbsp;&nbsp;&nbsp;&nbsp;Cumple km.<br>";
					}
					else{
						echo "&nbsp;&nbsp;&nbsp;&nbsp;No cumple km.<br>";
					}
				break;
				case 'A':// por tiempo y/o km
					echo "&nbsp;&nbsp;&nbsp;&nbsp;Entra tiempo y/o km.<br>";
					if((date("Y-m-d") >= $f_vence) || ($odo>=$odo_fin)){//si el plazo o km se cumple
						correo($row_det[0],$row_det[1],'A');
						echo "&nbsp;&nbsp;&nbsp;&nbsp;Cumple tiempo o km.<br>";
					}
					else{
						echo "&nbsp;&nbsp;&nbsp;&nbsp;No cumple.<br>";
					}
				break;
			}
		}
	}
}
//echo "funciona";
?>