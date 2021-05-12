<?php 

function otro_server($lat,$lon){
	$conec2 = mysql_connect("10.0.2.13","usercruce","server") or die ("¡No hay conexión con el servidor! <br />" . mysql_error());
	if(!$conec2){
		$error = mysql_error()."error conec2";
		return $error;
	}else{
		mysql_select_db("crucev2", $conec2) or die ("¡No se selecciono BD! <br />" . mysql_error() );	

		$estados = "SELECT nombre FROM municipios WHERE Crosses(area,GeomFromText('POINT($lat $lon)')) LIMIT 1";
		//echo $estados;		exit();
		$est = mysql_query($estados);
		$estad = mysql_fetch_array($est);
		$estado = $estad[0];
		list($mun,$est) = explode("(",$estado);
		$estadoy = str_replace("(","",$est);
		$esta = str_replace(")","",$estadoy);
		$w = strtolower($mun);
		$y = strtolower($esta);
		$estado = ucwords($w)." (".ucwords($y).")";
		$procedure = "SELECT cast(e.idesquina AS char(20)) AS ID, ca.nombre as NOM, (GLength(LineString((PointFromWKB( POINT($lat, $lon))), 
					  (PointFromWKB(POINT(X(e.Coordenadas),Y(e.Coordenadas) ) ))))) * 100 AS DIST FROM esquinas e
					  INNER JOIN calles_esquinas ce ON e.idesquina=ce.idesquina INNER JOIN calles ca ON ce.idcalle=ca.idcalle
	    			  WHERE MBRContains(GeomFromText(
	                    concat('Polygon((',
	                                      $lat+0.01001,' ',$lon-0.01001,', ',
	                                      $lat+0.01001,' ',$lon+0.01001,', ',
	                                      $lat-0.01001,' ',$lon-0.01001,', ',
	                                      $lat-0.01001,' ',$lon+0.01001,', ',
	                                      $lat+0.01001,' ',$lon-0.01001,'))')),coordenadas) ORDER BY DIST ASC limit 4";
	    //echo $procedure;		exit();
		$r = mysql_query($procedure);
		$calle = "";
		$distancia = 99999;
		$dist = 0;
		while( $calles = mysql_fetch_array($r) ){
			if($calles['DIST'] <= $distancia){
				if($dist <= 1){
					if($calle != ''){
						if($calles['NOM'][0] == "I" || ($calles['NOM'][0].$calles['NOM'][1] == 'Hi')){
							$calle .= ' e ';
						}else{
							$calle .= ' y ';
						}
					}
					$calle .= $calles['NOM'];
					$dist++;
				}			
				$distancia = $calles['DIST'];
			}
		}

		include("librerias/conexion.php");
		include_once('../patError/patErrorManager.php');
		include_once('../patSession/patSession.php');
		
		$options = "";
		$sess =& patSession::singleton('egw', 'Native', $options );
		$ide = $sess->get("Ide");
		$cercano = "";
		$cad_sit = "SELECT id_sitio, latitud, longitud, nombre FROM sitios WHERE id_empresa = $ide AND activo = 1";
		$res_sit = mysql_query($cad_sit);
		$num = mysql_num_rows($res_sit);
		if($num > 0){
			$degtorad = 0.01745329;
			$radtodeg = 57.29577951;
			$distancia = 1000;
			while($row = mysql_fetch_array($res_sit)){
				$dlong = ($lon - $row[2]); 
				$dvalue = (sin($lat * $degtorad) * sin($row[1] * $degtorad)) + (cos($lat * $degtorad) * cos($row[1] * $degtorad) * cos($dlong * $degtorad)); 
				$dd = acos($dvalue) * $radtodeg; 
				$km = ($dd * 111.302)*1000;
				$km = number_format($km,1,'.','');
				if($distancia > $km){
					$cercano = " a ".(int)$km." Mts de ".$row[3]." ,";
					$distancia = $km;
				}
			}
		}
		

		//$cercano = "";
		$calle = strtolower($calle);
		$cadena = ucwords($calle).",".ucwords($cercano).$estado;
		return nl2br($cadena);
	}
	mysql_close($conec2);
}

if(!isset($_POST['con_pdf'])){
	echo "<script type='text/javascript'>alert('No hay datos para mostrar');close()</script>";
	exit();
}

require_once('fpdf.php');
require_once("librerias/conexion.php");
$cons = str_replace("\'", "'", $_POST['con_pdf']);

//mysql_select_db("sepromex", $conec);
//recibe la consulta que crea el reporte ,$conec
$consulta = mysql_query($cons); 
/*
echo "<br><br>".$cons;
exit();
*/
switch($_POST['tipo']){
	case "recorrido":
		class PDF extends FPDF{
			function Header(){ //Funcion para crear el encabezado de la pagina de reporte3
				$this->SetFont('Arial','B',7);
				$this->Cell(55);
				$this->Cell(80,10,'REPORTE DE RECORRIDO POR UNIDAD',0,0,'C');
				$this->Ln();
				$this->SetFillColor(0,42,92);
				$this->SetTextColor(255,255,255);
				$this->Cell(28,5,"FECHA",1,0,'C',true);
				$this->Cell(25,5,"VEHÍCULO",1,0,'C',true);
				$this->Cell(23,5,"EVENTO",1,0,'C',true);
				$this->Cell(12,5,"VEL KM/H",1,0,'C',true);
				if($_POST['idsiste']==20 || $_POST['idsiste']==34 ){
					$this->Cell(10,5,"ODOM",1,0,'C',true);
				}
				$this->Cell(30,5,"MENSAJE",1,0,'C',true);
				$this->Cell(70,5,"CALLES",1,0,'C',true);
				$this->Ln();
			}
			function Footer(){ //Funcion para crear el pie de pagina
				$this->SetXY(195,-10);
				$this->SetFont('Arial','',6);
				$this->Cell(7,5,$this->PageNo().'/{nb}',0,0,'C');
				$this->SetXY(10,-5);
				$this->SetFont('Arial','',4);
				$this->Cell(7,5,'POWERED BY SEPROMEX',0,0,'C');
			}
		}
		//Creación del objeto de la clase heredada
		$pdf = new PDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Arial','',7);
		$pdf->SetFont('Arial','',7);
		$color = 0;

		while( $row = mysql_fetch_array($consulta) ){
			$veh = $row[1];
			if($row[2] == ''){ $row[2] = 0; }

			$color++;
			if($color%2 == 0){
				$pdf->SetFillColor(255,255,255);
			}else{
				$pdf->SetFillColor(245,245,209);
			}

			$pdf->Cell(28,5,$row[0],1,0,'C',true);
			$pdf->Cell(25,5,$row[8],1,0,'C',true);
			$pdf->Cell(23,5,$row[14],1,0,'C',true);
			$pdf->Cell(12,5,$row[2],1,0,'C',true);

			if( $_POST['idsiste'] == 20 || $_POST['idsiste'] == 34 ){
				$pdf->Cell(10,5,$row[12],1,0,'C',true);
			}

			$mensaje = $row[15];
			if( $row[4] == 3 && $mensaje == ""){
				$result = mysql_query("SELECT mensaje FROM c_mensajes WHERE id_mensaje = $row[5] AND id_empresa = 15 GROUP BY mensaje");
				$row_m = mysql_fetch_array($result);
				$mensaje = utf8_decode($row_m[0]);
			}
			
			$pdf->Cell(30,5,$mensaje,1,0,'C',true);
			$calle = otro_server($row[6],$row[7]);
			if($calle[0] == ','){
				$calle = substr($calle,1);
			}

			$pdf->Cell(70,5,wordwrap($calle,50, "\n"),1,0,'C',true);
			$pdf->Ln();	
		}
	break;
	case "gas":
		class PDF extends FPDF{
			function Header(){ //Funcion para crear el encabezado de la pagina de reporte3
				$this->SetFont('Arial','B',7);
				$this->Cell(55);
				$this->Cell(80,10,'REPORTE DE GASOLINA POR UNIDAD',0,0,'C');
				$this->Ln();
				$this->SetFillColor(0,42,92);
				$this->SetTextColor(255,255,255);
				$this->Cell(28,5,"FECHA",1,0,'C',true);
				$this->Cell(12,5,"VEL KM/H",1,0,'C',true);
				$this->Cell(20,5,"LATITUD",1,0,'C',true);
				$this->Cell(20,5,"LONGITUD",1,0,'C',true);
				$this->Cell(30,5,"NIVEL GASOLINA",1,0,'C',true);
				$this->Cell(70,5,"CALLES",1,0,'C',true);
				$this->Ln();
			}
			function Footer(){ //Funcion para crear el pie de pagina
				$this->SetXY(195,-10);
				$this->SetFont('Arial','',6);
				$this->Cell(7,5,$this->PageNo().'/{nb}',0,0,'C');
				$this->SetXY(10,-5);
				$this->SetFont('Arial','',4);
				$this->Cell(7,5,'POWERED BY SEPROMEX',0,0,'C');
			}
		}
		//Creación del objeto de la clase heredada
		$pdf=new PDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Arial','',7);
		$color = 0;
		while($row = mysql_fetch_array($consulta)){
			$color++;
			if($color%2 == 0)//cambia de color los campos del reporte
				$pdf->SetFillColor(255,255,255);
			else
				$pdf->SetFillColor(245,245,209);

			$pdf->Cell(28,5,$row[1],1,0,'C',true);
			$pdf->Cell(12,5,$row[2],1,0,'C',true);
			$pdf->Cell(20,5,$row[3],1,0,'C',true);
			$pdf->Cell(20,5,$row[4],1,0,'C',true);
			$pdf->Cell(30,5,$row[6]."%",1,0,'C',true);

			$calle = otro_server($row[3],$row[4]);
			$pdf->Cell(70,5,wordwrap($calle,50, "\n"),1,0,'C',true);
			$pdf->Ln();	
		}
	break;
	case "temp":
		class PDF extends FPDF{
			function Header(){ //Funcion para crear el encabezado de la pagina de reporte3
				$this->SetFont('Arial','B',7);
				$this->Cell(55);
				$this->Cell(80,10,'REPORTE DE TEMPERATURA POR UNIDAD',0,0,'C');
				$this->Ln();
				$this->SetFillColor(0,42,92);
				$this->SetTextColor(255,255,255);
				$this->Cell(28,5,"FECHA",1,0,'C',true);
				$this->Cell(12,5,"VEL KM/H",1,0,'C',true);
				$this->Cell(20,5,"LATITUD",1,0,'C',true);
				$this->Cell(20,5,"LONGITUD",1,0,'C',true);
				$this->Cell(30,5,"TEMPERATURA",1,0,'C',true);
				$this->Cell(70,5,"CALLES",1,0,'C',true);
				$this->Ln();
			}
			function Footer(){ //Funcion para crear el pie de pagina
				$this->SetXY(195,-10);
				$this->SetFont('Arial','',6);
				$this->Cell(7,5,$this->PageNo().'/{nb}',0,0,'C');
				$this->SetXY(10,-5);
				$this->SetFont('Arial','',4);
				$this->Cell(7,5,'POWERED BY SEPROMEX',0,0,'C');
			}
		}
		//Creación del objeto de la clase heredada
		$pdf = new PDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Arial','',7);
		$color = 0;
		while($row = mysql_fetch_array($consulta)){
			$color++;
			if($color%2 == 0)//cambia de color los campos del reporte
				$pdf->SetFillColor(255,255,255);
			else
				$pdf->SetFillColor(245,245,209);

			$pdf->Cell(28,5,$row[1],1,0,'C',true);
			$pdf->Cell(12,5,$row[2],1,0,'C',true);
			$pdf->Cell(20,5,$row[3],1,0,'C',true);
			$pdf->Cell(20,5,$row[4],1,0,'C',true);
			$pdf->Cell(30,5,$row[6]." °C",1,0,'C',true);

			$calle = otro_server($row[3],$row[4]);
			$pdf->Cell(70,5,wordwrap($calle,50, "\n"),1,0,'C',true);
			$pdf->Ln();	
		}
	break;
}

$query = mysql_query("select id_veh from vehiculos where num_veh=".$_POST['num_veh']);
$dat_veh = mysql_fetch_array($query);
$reporte = $dat_veh[0]."-".date("Y-m-d H-i-s");
$pdf->Output($reporte.".pdf","D");
?>