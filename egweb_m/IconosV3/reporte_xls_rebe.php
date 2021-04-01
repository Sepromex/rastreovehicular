<?php 
if(!isset($_POST['con_xls'])){
	echo "<script type='text/javascript'>alert('No hay datos para mostrar')</script>";
	echo "<script type='text/javascript'>window.parent.location='reportes_recorrido.php'</script>";
	exit();
	}
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_xls_rebe.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	$consulta = str_replace("\'", "'", $_POST['con_xls']); // reemplaza algunos caracteres no deseables
	require("librerias/conexion.php");
			$resp = mysql_query($consulta); //resibe la consulta que crea el reporte
		 	$dsn_reco = "<table border = '0' class='fuente_tres' width='800px'>";
		 	$dsn_reco .= "<tr style='background:#204A7F;color:#FFFFFF;text-align:center;' >";
		 	if($_POST['idsistema']==20 || $_POST['idsistema']==34 ){
				$dsn_reco .= "<td colspan='9'>REPORTE DE RECORRIDO</td></tr>";
			}else{
				$dsn_reco .= "<td colspan='8'>REPORTE DE RECORRIDO</td></tr>";
			}
			$dsn_reco .= "<tr style='background:#204A7F;color:#FFFFFF;text-align:center;'>";
		 	$dsn_reco .= "<td>FECHA</td><td>VEHICULO</td><td>EVENTO</td><td>VEL KM/H </td>";
			if($_POST['idsistema']==20 || $_POST['idsistema']==34 ){
				$dsn_reco .= "<td>ODO</td>";
			}
			$dsn_reco .= "<td>MENSAJE</td><td>LATITUD</td>";
		 	$dsn_reco .= "<td>LONGITUD</td><td>CALLES</td></tr>";
			//apartir de aqui se realiza la conversion para los distintos tipos de mensajes y requisitos que se piden en el reporte
		 	while($row = mysql_fetch_array($resp)){
			if($row[2]==''){$row[2]= 0;}
	 		$dsn_reco .="<tr><td>".$row[0]."</td><td>".$row[8]."</td><td>".$row[14]."</td><td>".$row[2]."</td>";
			if($_POST['idsistema']==20 || $_POST['idsistema']==34 ){
				$dsn_reco .="<td>".$row[12]."</td>";
			}
			$mensaje = $row[15];
			if( $row[4] == 3 && $mensaje == "" )
			{
				$result = mysql_query("SELECT mensaje FROM c_mensajes where id_mensaje = $row[5] and id_empresa = 15 group by mensaje");
				$row_m = mysql_fetch_array($result);
				$mensaje = utf8_decode($row_m[0]);
			}
			if($row[10]=='')//si no trae cruce entra al web service
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
					}
	 		$dsn_reco .="<td>".$mensaje."</td><td>".$row[6]."</td><td>".$row[7]."</td><td>".$row[10]."</td></tr>";
		 	}
		$dsn_reco .= "<table>";
   	mysql_close($con); //cierra la conexion a la base de datos 
echo $dsn_reco; // crea el reporte de excel
?>