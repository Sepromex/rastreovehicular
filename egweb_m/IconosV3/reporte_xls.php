<?php 
include('otro_server.php');
/*
function otro_server($lat,$lon){
	$conec2 = @mysql_connect("10.0.0.2","usercruce","server");
	if(!$conec2){
		$error=mysql_error()."error conec2";
		return $error;
	}
	else{
	mysql_select_db("crucev2", $conec2);
	$estados="SELECT nombre
	FROM `municipios`
	where Crosses(area,GeomFromText('POINT($lat $lon)'))";
	$est=mysql_query($estados);
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
	
	//return $calle."<br>".mysql_error()."<br>".nl2br($procedure);
	return utf8_encode($calle).",".$estado;
	}
	mysql_close($conec2);
}
*/
if(!isset($_POST['con_xls'])){
	echo "<script type='text/javascript'>alert('No hay datos para mostrar');close()</script>";
	//echo "<script type='text/javascript'>window.parent.location='reportes_recorrido.php'</script>";
	//echo "<script type='text/javascript'>'</script>";
	exit();
	}
	switch($_POST['tipo']){
		case "recorrido":
			$consulta = str_replace("\'", "'", $_POST['con_xls']); // reemplaza algunos caracteres no deseables
			require_once("librerias/conexion.php");
			$resp = mysql_query($consulta,$conec); //resibe la consulta que crea el reporte
			echo mysql_error();
			$cabecera = "<table border = '0' class='fuente_tres' width='800px'>";
			$cabecera .= "<tr style='background:#204A7F;color:#FFFFFF;text-align:center;' >";
			if($_POST['idsistema']==20 || $_POST['idsistema']==34 ){
				$cabecera .= "<th colspan='9'>REPORTE DE RECORRIDO</th></tr>";
			}else{
				$cabecera .= "<th colspan='8'>REPORTE DE RECORRIDO</th></tr>";
			}
			$cabecera .= "
			<tr style='background:#204A7F;color:#FFFFFF;text-align:center;'>
				<td>FECHA</td>
				<td>VEHICULO</td>
				<td>EVENTO</td>
				<td>VEL KM/H </td>";
			if($_POST['idsistema']==20 || $_POST['idsistema']==34 ){
				$cabecera .= "<td>ODO</td>";
			}
			$cabecera .= "
				<td>MENSAJE</td>
				<td>LATITUD</td>
				<td>LONGITUD</td>
				<td>CALLES</td>
			</tr>";
			
			//$cabecera .="<tr><td>Registros: ".mysql_num_rows($resp)."</td></tr>";
			//apartir de aqui se realiza la conversion para los distintos tipos de mensajes y requisitos que se piden en el reporte
			while($row = mysql_fetch_array($resp)){
					$num_veh=$row[1];
					if($row[2]==''){$row[2]= 0;}
					$dsn_reco .="
					<tr>
						<td>".$row[0]."</td>
						<td>".$row[8]."</td>
						<td>".$row[13]."</td>
						<td>".$row[2]."</td>";
					if($_POST['idsistema']==20 || $_POST['idsistema']==34 ){
						$dsn_reco .="<td>".$row[12]."</td>";
					}
					$mensaje = $row[15];
					if( $row[4] == 3 && $mensaje == "" )
					{
						$result = mysql_query("SELECT mensaje FROM c_mensajes where id_mensaje = $row[5] and id_empresa = 15 group by mensaje",$conec);
						$row_m = mysql_fetch_array($result);
						$mensaje = utf8_decode($row_m[0]);
					}
					$calle=otro_server($row[6],$row[7]);
					if($calle==''){
						$calle=otro_server($row[6],$row[7]);
					}
					if($calle==''){
						$calle=otro_server($row[6],$row[7]);
					}
					if($calle==''){
						$calle=otro_server($row[6],$row[7]);
					}
					if($calle==''){
						$calle=otro_server($row[6],$row[7]);
					}
					if($calle==''){
						$calle=otro_server($row[6],$row[7]);
					}
					if($calle==''){
						$calle=otro_server($row[6],$row[7]);
					}
					if($calle==''){
						$calle=otro_server($row[6],$row[7]);
					}
					if($calle[0]==','){
						$calle=substr($calle,1);
					}
					$dsn_reco .="
						<td>".$mensaje."</td>
						<td>".$row[6]."</td>
						<td>".$row[7]."</td>
						<td>".$calle."</td>
					</tr>";
				}
		break;
		case 'temp':
			$consulta = str_replace("\'", "'", $_POST['con_xls']); // reemplaza algunos caracteres no deseables
			require_once("librerias/conexion.php");
			$resp = mysql_query($consulta,$conec); //resibe la consulta que crea el reporte
			echo mysql_error();
			$cabecera = "<table border = '0' class='fuente_tres' width='800px'>";
			$cabecera .= "<tr style='background:#204A7F;color:#FFFFFF;text-align:center;' >";
			if($_POST['idsistema']==20 || $_POST['idsistema']==34 ){
				$cabecera .= "<th colspan='9'>REPORTE DE RECORRIDO</th></tr>";
			}else{
				$cabecera .= "<th colspan='8'>REPORTE DE RECORRIDO</th></tr>";
			}
			$cabecera .= "
			<tr style='background:#204A7F;color:#FFFFFF;text-align:center;'>
				<td>FECHA</td>
				<td>VEL KM/H </td>
				<td>LATITUD</td>
				<td>LONGITUD</td>
				<td>TEMPERATURA</td>
				<td>CALLES</td>
			</tr>";
			
			//$cabecera .="<tr><td>Registros: ".mysql_num_rows($resp)."</td></tr>";
			//apartir de aqui se realiza la conversion para los distintos tipos de mensajes y requisitos que se piden en el reporte
			while($row = mysql_fetch_array($resp)){
					$dsn_reco .="
					<tr>
						<td>".$row[1]."</td>
						<td>".$row[2]."</td>
						<td>".$row[3]."</td>
						<td>".$row[4]."</td>";
					
					
					$calle=otro_server($row[3],$row[4]);
					if($calle==''){
						$calle=otro_server($row[3],$row[4]);
					}
					if($calle==''){
						$calle=otro_server($row[3],$row[4]);
					}
					if($calle==''){
						$calle=otro_server($row[3],$row[4]);
					}
					if($calle==''){
						$calle=otro_server($row[3],$row[4]);
					}
					if($calle==''){
						$calle=otro_server($row[3],$row[4]);
					}
					if($calle==''){
						$calle=otro_server($row[3],$row[4]);
					}
					if($calle==''){
						$calle=otro_server($row[3],$row[4]);
					}
					$dsn_reco .="
						<td>".$row[6]." °C</td>
						<td>".$calle."</td>
					</tr>";
				}
		break;
		case 'gas':
			$consulta = str_replace("\'", "'", $_POST['con_xls']); // reemplaza algunos caracteres no deseables
			require_once("librerias/conexion.php");
			$resp = mysql_query($consulta,$conec); //resibe la consulta que crea el reporte
			echo mysql_error();
			$cabecera = "<table border = '0' class='fuente_tres' width='800px'>";
			$cabecera .= "<tr style='background:#204A7F;color:#FFFFFF;text-align:center;' >";
			if($_POST['idsistema']==20 || $_POST['idsistema']==34 ){
				$cabecera .= "<th colspan='9'>REPORTE DE RECORRIDO</th></tr>";
			}else{
				$cabecera .= "<th colspan='8'>REPORTE DE RECORRIDO</th></tr>";
			}
			$cabecera .= "
			<tr style='background:#204A7F;color:#FFFFFF;text-align:center;'>
				<td>FECHA</td>
				<td>VEL KM/H </td>
				<td>LATITUD</td>
				<td>LONGITUD</td>
				<td>NIVEL GASOLINA</td>
				<td>CALLES</td>
			</tr>";
			
			//$cabecera .="<tr><td>Registros: ".mysql_num_rows($resp)."</td></tr>";
			//apartir de aqui se realiza la conversion para los distintos tipos de mensajes y requisitos que se piden en el reporte
			while($row = mysql_fetch_array($resp)){
					$dsn_reco .="
					<tr>
						<td>".$row[1]."</td>
						<td>".$row[2]."</td>
						<td>".$row[3]."</td>
						<td>".$row[4]."</td>";
					
					
					$calle=otro_server($row[3],$row[4]);
					if($calle==''){
						$calle=otro_server($row[3],$row[4]);
					}
					if($calle==''){
						$calle=otro_server($row[3],$row[4]);
					}
					if($calle==''){
						$calle=otro_server($row[3],$row[4]);
					}
					if($calle==''){
						$calle=otro_server($row[3],$row[4]);
					}
					if($calle==''){
						$calle=otro_server($row[3],$row[4]);
					}
					if($calle==''){
						$calle=otro_server($row[3],$row[4]);
					}
					if($calle==''){
						$calle=otro_server($row[3],$row[4]);
					}
					$dsn_reco .="
						<td>".$row[6]." %</td>
						<td>".utf8_decode($calle)."</td>
					</tr>";
				}
		break;
	}
	$dsn_reco .= "</table>";
require_once("librerias/conexion.php");
$query=mysql_query("select id_veh from vehiculos where num_veh=".$_POST['num_veh'],$conec);
$dat_veh=mysql_fetch_array($query);
$reporte=$dat_veh[0]."-".date("Y-m-d H:i:s");
//mysql_close($con); //cierra la conexion a la base de datos 

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$reporte.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
echo $cabecera.$dsn_reco; // crea el reporte de excel
echo "<script type='text/javascript'>close()</script>";
?>