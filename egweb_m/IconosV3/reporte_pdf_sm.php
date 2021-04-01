<?php 
//$cad=
   // require_once("dompdf/dompdf_config.inc.php");

     
	 
	// echo $html2;
    //echo $html;
  /*$dompdf = new DOMPDF();
    $dompdf->load_html($html2]);
	//ini_set("memory_limit","32M"); 
   $dompdf->render();
   $dompdf->stream("sample.pdf");*/
  
    require('html2pdf/html2pdf.class.php');
	    $html =$_POST['dsn'];
		$html2 =str_replace("width='850'","width='563'",$html);
    $html2pdf = new HTML2PDF('L','A4','fr');
    $html2pdf->WriteHTML($html2);
    $html2pdf->Output('Tiempos_sin_movimiento-'.date("Y-m-d H-i-s").'.pdf','D');
?>