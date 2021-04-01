<?
//include("/librerias/conexion.php");
include("conexion.php");

function otro_server($lat,$lon,$ide){//calcula el cruce de las calles
	//$conec2 = @mysql_connect("localhost","usercruce","server");
	$conec2 = @mysql_connect("10.0.2.13","usercruce","server");
	//$conec2 = @mysql_connect("localhost","root","admin");
	//$conec2 = @mysql_connect("localhost:3306","usercruce","server");
	if(!$conec2){
		//$error=mysql_error()."error conec2";
		return $error;
	}
	else{
	mysql_select_db("crucev2", $conec2);
	/*
		obtenemos el estado/municipio del vehiculo
	*/
	$estados="SELECT nombre
	FROM `municipios`
	where Crosses(area,GeomFromText('POINT($lat $lon)')) limit 1";
	$est=mysql_query($estados,$conec2);
	$estado=mysql_fetch_array($est);
	$estado=$estado[0];
	
	list($mun,$est)=explode("(",$estado);
	$estadoy=str_replace("(","",$est);
	$esta=str_replace(")","",$estadoy);
	$w=strtolower($mun);
	$y=strtolower($esta);
	$estado=ucwords($w)." (".ucwords($y).")";
	
	/*
		procedure
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
	/*
		Calculamos el sitio cercano a nuestro vehiculo
	*/
	$cercano="";
	$cad_sit = "select id_sitio,latitud,longitud,nombre from sitios where id_empresa = $ide and activo=1";
	$res_sit = mysql_query($cad_sit,$con);
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
	$calle=strtolower($calle);
	//$municipio=strtolower($municipio);
	//$estado=strtolower($estado);
	$cadena=ucwords($calle).",".ucwords($cercano).$estado;
	//return ucwords($calle).",".ucwords($municipio)." ".ucwords($estado);
	return $cadena;
	}
	//mysql_close($conec2);
}

$accion=$_GET['accion'];
switch($accion){
	case 'folios'://ver los folios de la empresa
		$l_folio="";
		if($_GET['limit']) //si mando un limit, agrego a la consulta lo siguiente
		{
			$l_folio=" and m.folio>".$_GET['limit'];
		}
		$query=mysql_query("SELECT * FROM gpscondicionalerta m
		where m.id_empresa=".$_GET['empresa']." and m.activo=1 $l_folio");
		$correos=mysql_query("SELECT * from correos_empresa where id_empresa=".$_GET['empresa']." and activo=1",$con);
		$i=0;
		if(mysql_num_rows($correos)>0){
			while($row=mysql_fetch_array($correos)){
				if($i==0){
					$cadena.=$row[0]."|";
				}
				$cadena.=$row[2].":".$row[3];//muestro en pantalla el resultado
				if($i<mysql_num_rows($correos)-1){
					$cadena.=";";
				}
				$i++;
			}
			echo $cadena.'%';
		}
		else{
			echo $_GET['empresa']."|N/A%";
		}
		$i=0;
		while($row=mysql_fetch_array($query)){
			echo $row[0]."|".utf8_decode($row[1])."|".$row[2]."|".$row[3]."|".$row[4]."|".$row[5]."|".$row[6]."|".$row[7]."|".
			$row[8]."|".$row[9]."|".$row[10]."|".$row[11]."|".$row[12]."|".$row[13]."|".$row[14];//muestro en pantalla el resultado
			if($i<mysql_num_rows($query)-1){
				echo '%';
			}
			$i++;
		}
	break;
	case 'actualiza'://actualiza los correos del folio seleccionado
	
		$update="UPDATE gpscondicionalerta set enviaremail='".$_GET['mail']."' where folio=".$_GET['folio'];
		//mysql_query($update);
		if(!mysql_error()){
			echo "UPDATE%".$_GET['folio']."%OK";//respondo que se hizo bien el proceso
		}
		else{
			echo "UPDATE%".$_GET['folio']."%ERROR";//respondo que se hizo mal el proceso
		}
		echo $update;
	break;
	case 'regla_c'://inserto la nuevo "regla"
		$desc=trim(addslashes(str_replace("_",' ',$_GET['descripcion'])));
		$veh=$_GET['vehiculo'];
		$dias=$_GET['dias'];
		$ini=date("Y-m-d ").$_GET['hora_inicio'];
		$fin=date("Y-m-d ").$_GET['hora_fin'];
		$min=$_GET['velmin'];
		$max=$_GET['velmax'];
		$entra=$_GET['entra'];
		$geocercas=$_GET['geocercas'];
		$cam_rep=$_GET['tipo'];
		$par_rep=$_GET['PDSR'];
		
		$insert="INSERT INTO gpscondicionalerta values(0,'".$desc."',0,".$_GET['empresa'].",'".
		date("Y-m-d H:i:s")."','".$_GET['correos']."',0,0,1,1,-1,0,0,0,-1);";
		mysql_query($insert,$con);
		$folio=mysql_insert_id();
		//echo $insert."<br><br><br>";
		//$folio=999;
		/*
			insertamos en detalle
		*/
		$activo=1;
		$duracion=5;
		$vehiculos=explode(";",$veh);
		for($i=0;$i<count($vehiculos);$i++){
			$insert_detalle="INSERT INTO gpscondicionalertadet values(
			$folio,0,".$_GET['empresa'].",".$vehiculos[$i].",0,$min,$max,0,0,0,'$ini','$fin',$duracion,0,0,$activo,'$dias',
			'".date("Y-m-d H:i:s")."',-1,0,0,0
			)";
			mysql_query($insert_detalle,$con);
			//echo $insert_detalle."<br><br>";
		}
		
		if(!mysql_error()){
			echo "INSERT%".$folio."%OK";//respondo que se realizo bien el proceso y retorno el folio capturado
		}
		else{
			echo "INSERT%N/A%ERROR";//envio el error de que no se inserto la REGLA
		}
		//echo $insert;
	break;
	case 'insertar_c':
		list($nombre,$correo)=explode(":",$_GET['mail']);
		$ver=mysql_query("select * from correos_empresa where id_empresa=".$_GET['empresa']." AND correo like '$correo'",$con);
		if(mysql_num_rows($ver)==0){
			$nombre=str_replace("_"," ",$nombre);
			$insert_c="INSERT INTO correos_empresa values(".$_GET['empresa'].",0,'$nombre','$correo',1)";
			mysql_query($insert_c,$con);
		}
		else{
			mysql_query("UPDATE correos_empresa set activo=1,nombre='$nombre' 
			where id_empresa=".$_GET['empresa']." and correo='$correo'",$con);
		}
		if(!mysql_error()){
			echo "PETICION CONCEDIDA";
		}
		else{
			echo "ERROR ".mysql_error();
		}
	break;
	case 'geocercas_c': //consulto las geocercas Circulares
		$geocercas=mysql_query("SELECT * from geo_time where tipo=0 and id_empresa=".$_GET['empresa']." 
		and id_usuario=".$_GET['Usuario']." and activo=1",$con);
		$i=0;
		$cadena="";
		while($row=mysql_fetch_array($geocercas)){
			$cadena.=$row[0].";".$row[5].";".$row[1].";".$row[2].";".$row[3];
			if($i<mysql_num_rows($geocercas)-1){
				$cadena.="%";
			}
			$i++;
		}
		echo $cadena;
	break;
	case 'insertar_g': //inserto una nueva geocerca Circulares
		$id_us=mysql_query("select id_usuario from usuarios where username='".$_GET['Usuario']."' 
		and id_empresa=".$_GET['empresa'],$con);
		$ids=mysql_fetch_array($id_us);
		$idu=$ids[0];
		if($idu!=''){
			$lat=$_GET['Latitud'];
			$lon=$_GET['longitud'];
			$radio=number_format($_GET['Radio'],0,'','');
			$nombre=str_replace("_"," ",$_GET['Nombre']);
			mysql_query("INSERT INTO geo_time values(0,$lat,$lon,$radio,0,'$nombre','$idu',0,".$_GET['empresa'].",1)",$con);
			if(!mysql_error()){
				echo mysql_insert_id();
			}
			else{
				echo "ERROR%".mysql_error();
			}
		}
		else{
			echo "ERROR%El usuario no existe en esa empresa";
		}
	break;
	case 'gpsdetalle':
		$detalles=mysql_query("select * from gpscondicionalertadet where folio=".$_GET['folio'],$con);
		$i=0;
		$cadena="";
		while($row=mysql_fetch_array($detalles)){
			$cadena.=$row[1].":".$row[3].":".$row[4].":".$row[5].":".$row[6].":".$row[7].":".$row[8].":".$row[9].":".$row[10].":".$row[11];
			$cadena.=$row[12].":".$row[15].":".$row[16].":".$row[18].":".$row[19].":".$row[20];
			if($i<mysql_num_rows($detalles)-1){
				$cadena.=";";
			}
			$i++;
		}
		echo $cadena;
	break;
	case 'geocercas_d':
		mysql_query("UPDATE geo_time set activo=0 where num_geo=".$_GET['folio'],$con);
		if(!mysql_error()){
			echo "OK";
		}
		else{
			echo "ERROR";
		}
	break;
	case 'geocercas_u';
		mysql_query("UPDATE geo_time set nombre='".$_GET['Nombre']."',radiomts=".$_GET['Radio']." 
		where num_geo=".$_GET['folio'],$con);
		if(!mysql_error()){
			echo "OK";
		}
		else{
			echo "ERROR";
		}
	break;
	case 'borrar':
		$borrar="UPDATE gpscondicionalerta SET activo=0 WHERE folio=".$_GET['folio'];
		//mysql_query($borrar);
		if(!mysql_error()){
			echo "BORRAR%".$_GET['folio']."%OK";//respondo que se realizo bien el proceso y retorno el folio "borrado"
		}
		else{
			echo "BORRAR%N/A%ERROR";//envio el error de que no se borro la REGLA
		}
		echo $borrar;
	break;
	case 'detalle':
		$folio=$_GET['Folio'];
		$ver=mysql_query("SELECT * from gpscondgeocompleja where folio_entgeo=$folio",$con);
		$cadena="";
		if(mysql_num_rows($ver)>0){
			//reglas complicadas con mas tablas
			
		}
		else{
			$query=mysql_query("SELECT * from gpscondicionalertadet where folio=$folio and activo=1",$con);
			while($row=mysql_fetch_array($query)){
				$cadena.="%".$row[1].";".$row[3].";".$row[4].";".$row[5].";".$row[6].";".$row[7].";".$row[8].";".$row[9].";";
				$cadena.=$row[10].";".$row[11].";".$row[12].";".$row[13].";".$row[14].";".$row[15].";".$row[16].";";
				$cadena.=$row[18].";".$row[19].";".$row[20].";";
			}
			echo $folio.$cadena;
		}
	break;
	/*
		Comienza parte "mobil"
	*/
	case 'login':  //Control de acceso al sistema 
		$user=$_GET['usuario'];
		$pass=$_GET['password'];
		$ver_usuario=mysql_query("SELECT * from sepromex.usuarios where username='$user'",$con);
		if(mysql_num_rows($ver_usuario)>0){
			$ver_pass=mysql_query("SELECT * from sepromex.usuarios where username='$user' and password='$pass'",$con);
			if(mysql_num_rows($ver_pass)>0){
				$fechas=mysql_query("SELECT * from sepromex.usuarios where username='$user' and password='$pass' 
				and f_termino >'".date("Y-m-d H:i:s")."'",$con);
				if(mysql_num_rows($fechas)>0){
					echo "OK";
				}else{
					echo "Usuario caducado";
				}
			}
			else{
				echo "Password invalido";
			}
		}else{
			echo " Usuario No reconocido";
		}
	break;
	case 'poleog': //Poleo de Vehiculos 
		//id_veh, fecha de ultima posición, latitud, longitud,ubicacion
		$user=$_GET['id_usuario'];
		$b_idu=mysql_query("SELECT id_usuario,id_empresa from usuarios where username='$user'",$con);
		$ids=mysql_fetch_array($b_idu);
		$idu=$ids[0];
		$ide=$ids[1];
		$q_v="SELECT distinct(v.num_veh),v.id_veh,u.velocidad,(u.lat/3600/16),((u.long & 8388607)/3600/12*-1),u.fecha
		from vehiculos v
		inner join ultimapos u on v.num_veh=u.num_veh
		left outer join veh_usr vu on vu.num_veh=v.num_veh
		where vu.id_usuario=$idu
		and vu.activo=1
		group by v.num_veh";
		$vehiculos=mysql_query($q_v,$con);
		if(mysql_num_rows($vehiculos)>0){
			$calle="";
			while($row=mysql_fetch_array($vehiculos)){
				$calle=otro_server($row[3],$row[4],$ide);
				//echo $row[0]."|".$row[1]."|".$row[2]."|".$row[3]."|".$row[4]."|".$row[5]."|".$calle.'%';
				echo $row[0]."|".$row[1]."|".$row[2]."|".$row[3]."|".$row[4]."|".$row[5].'%';
			}
		}
	break;
	case 'panicos': //Envio de Panicos pendietes del usuarios
		$user=$_GET['usuario'];
		$b_idu=mysql_query("SELECT id_usuario,id_empresa from usuarios where username='$user'",$con);
		$ids=mysql_fetch_array($b_idu);
		$idu=$ids[0];
		$ide=$ids[1];
		$query=mysql_query("SELECT distinct(v.num_veh),v.id_veh,u.velocidad,(a.lat/3600/16),((a.lon & 8388607)/3600/12*-1),a.fecha_pos,
		a.id_pos
		from vehiculos v
		inner join veh_usr vu on vu.num_veh=v.num_veh
		inner join alertas_leido a on a.num_veh=v.num_veh 
		where vu.id_usuario=$idu
		and vu.activo=1
		and id_mensaje=252
		and a.fecha_pos>='".date("Y-m-d")."'
		and a.atendido=0
		group by v.num_veh
		limit 10");
		if(mysql_num_rows($query)>0){
			while($row=mysql_fetch_array($query)){
				echo $row[6]."|".$row[1]."|".$row[3]."|".$row[4]."|".$row[5]."%";
			}
		}
		else{
			echo "No hay panicos";
		}
	break;
	case 'panicosr':
		$id_pos=$_GET['idpos'];
		mysql_query("update alertas_leido set atendido=1 where id_pos=$id_pos");
		if(!mysql_error()){
			echo "OK";
		}
		else{
			echo mysql_error();
		}
	break;
}
?>