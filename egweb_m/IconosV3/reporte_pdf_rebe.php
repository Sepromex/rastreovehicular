<?php 
if(!isset($_POST['con_pdf'])){
	echo "<script type='text/javascript'>alert('No hay datos para mostrar')</script>";
	echo "<script type='text/javascript'>window.parent.location='reportes_recorrido.php'</script>";
	exit();
	}
require('fpdf.php');
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
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',7);
require("librerias/conexion.php");
	$cons = str_replace("\'", "'", $_POST['con_pdf']);
	$consulta = mysql_query($cons); //resibe la consulta que crea el reporte
	$pdf->SetFont('Arial','',7);
	$color = 0;
	while($row = mysql_fetch_array($consulta)){
	if($row[2]==''){$row[2]= 0;}
	$color++;
		if($color%2==0)//cambia de color los campos del reporte
			$pdf->SetFillColor(255,255,255);
		else
			$pdf->SetFillColor(245,245,209);
		$pdf->Cell(28,5,$row[0],1,0,'C',true);
		$pdf->Cell(25,5,$row[8],1,0,'C',true);
		$pdf->Cell(23,5,$row[14],1,0,'C',true);
		$pdf->Cell(12,5,$row[2],1,0,'C',true);
		if($_POST['idsiste']==20 || $_POST['idsiste']==34 ){
			$pdf->Cell(10,5,$row[12],1,0,'C',true);
		}
		$mensaje = $row[15];
		if( $row[4] == 3 && $mensaje == "" )
		{
			$result = mysql_query("SELECT mensaje FROM c_mensajes where id_mensaje = $row[5] and id_empresa = 15 group by mensaje");
			$row_m = mysql_fetch_array($result);
			$mensaje = utf8_decode($row_m[0]);
		}
		//$pdf->Cell(30,5,$row[15],1,0,'C',true);
		$pdf->Cell(30,5,$mensaje,1,0,'C',true);
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
		$pdf->Cell(70,5,substr($row[10],0,50),1,0,'C',true);
		$pdf->Ln();
	}
$pdf->Output("recorrido_pdf.pdf","D");
?>