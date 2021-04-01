<?php
  include_once('../patError/patErrorManager.php');
  patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
  patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
  patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );
  include_once('../patSession/patSession.php');
  $sess =& patSession::singleton('egw', 'Native', $options );
  $estses = $sess->getState();
  if (isset($_GET["Logout"])){
	$sess->Destroy();
    header("Location: index.php");
  }
  if ($estses == empty_referer) {
  	header("Location: index.php");
  } 
  $result = $sess->get( 'expire-test' );
  if ((!patErrorManager::isError($result)) && ($sess->get('Idu'))) {
		$queryString = $sess->getQueryString();	
		$idu = $sess->get("Idu");
		$ide = $sess->get("Ide");
    	$usn = $sess->get("Usn");
		$pol = $sess->get("Pol");
		$reg = $sess->get("Registrado");
		$nom = $sess->get("nom");
		$prm = $sess->get('per');
		$est = $sess->get("sta");
		$eve = $sess->get("eve");
		$dis = $sess->get('dis');
		$pan = $sess->get('pan');
		if(!$reg)
			$sess->set('Registrado',1);
	}
	else{
      	$sess->Destroy();
      	header("Location: index.php");
}          
//se registran variables
require("librerias/conexion.php");
require('../xajaxs/xajax_core/xajax.inc.php');
$xajax = new xajax(); 
$xajax->configure('javascript URI', '../xajaxs/');
$xajax->register(XAJAX_FUNCTION,"alertas");

function alertas($idu){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$evento = $sess->get('evf');
	$ban = $sess->get('ban');	
	$cad_pos = "select count(*) as suma ";
	$cad_pos .= " from veh_usr v ";
	$cad_pos .= " left outer join mon_alarmas p on (v.num_veh = p.num_veh)";
	$cad_pos .= " where v.id_usuario = $idu";
	$cad_pos .= " and p.fecha >'".$evento."' and p.entradas = 252";
	$res_pos = mysql_query($cad_pos);
	$row_pos = mysql_fetch_row($res_pos);
	sleep(3);
	if($row_pos[0] == 0 && $ban == 0){ //no hay registros no puede dar click
		$objResponse->assign("num_msj","innerHTML","");
	}
	if($row_pos[0] > 0 && $ban == 0){ //hay registros no a dado click
		$objResponse->assign("num_msj","innerHTML","<a href='principal.php'title='Click para mostrar'>
							  Usted Tiene <u>".$row_pos[0]."</u> msj de Alerta</a> ");
	}
	if($row_pos[0] > 0 && $ban == 1){ // hay registros y dio click
	$objResponse->assign("num_msj","innerHTML","<a href='principal.php'title='Click para mostrar'>
						  Usted Tiene <u>".$row_pos[0]."</u> msj de Alerta</a> ");
	}
	
	if($row_pos[0] == 0 && $ban == 1){ //no hay registros ya dio click
		$objResponse->assign("num_msj","innerHTML","");
	}
return $objResponse;
}

$xajax->processRequest(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>EGWEB 3.0</title>
 <?php if($dis == 1){ ?>
	<link href="librerias/dsn.css" rel="stylesheet" type="text/css" />
    <?php }
	if($dis == 2){
	?>
    <link href="librerias/dsn1.css" rel="stylesheet" type="text/css" />
    <?php } 
	if($dis == 3){
	?>
    <link href="librerias/dsn2.css" rel="stylesheet" type="text/css" />
    <?php }?>
<script type="text/javascript" >
function tiempo(idu,p){
	if(p==1){
		setTimeout('tiempo('+idu+','+p+')',50000);
		document.getElementById('num_msj').innerHTML='<img src="img/loader.gif" width="15px" height="15px" />';
		xajax_alertas(idu);
	}
}
function ayuda(){
    window.open("Ayuda/Ayuda.php","ayuda","width=400,height=350,left=500,top=200");
}
</script>
<?php 
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
</head>
<center>
<body id="fondo" onload="tiempo(<?php echo (int)$idu ?>,<?php echo $pan?>);">
  	<div id="fondo_principal">
  	<div id="cuerpo2">
  		<div id="psw_session" class="fuente_cinco">
        <a href="<?php echo $_SERVER['PHP_SELF']."?Logout=true&".$queryString; ?>">Cerrar Sesi&oacute;n</a>
    </div>
    <div id="msg_bvnd" class="fuente">
    Bienvenido, <label class="fuente_dos"><?php echo htmlentities($nom); ?></label>
    </div>
    <div id="num_msj" class="fuente_once"></div>
    <div id="menu">
    	<ul id="lista_menu">
            <li><a href="javascript:void(null);" onclick="ayuda();">Ayuda</a></li>
            <li id="current"><a href="descargas.php">Descargas</a></li>
            <li><a href="Eventos.php">Eventos</a></li>
            <?php 
            $si = strstr($prm,"5");
            if(($est != 3) ||($est == 3 && !empty($si))){?>
            <li><a href="recorrido_nuevo.php">Reportes</a></li>
            <?php }?>
            <li><a href="usuarios.php">Usuarios</a></li>
            <?php 
            $si = strstr($prm,"6");
            if(($est != 3) ||($est == 3 && !empty($si))){?>
            <li><a href="catalogos.php">Catálogo</a></li>
            <?php }?>
            <li><a href="empresa.php">Mi Empresa</a></li>
            <li><a href="principal.php">Localización</a></li>
        </ul>
    </div>
	<div id='descEgs'>
		<a href='http://www.sepromex.com.mx:81/egs.exe' title='Descargar'>Descarga EGStation</a><br/><br/>
		<a href='http://www.sepromex.com.mx:81/egs.exe' title='Descargar'>
		<img src='img/egs.jpg' width='160px' height='110px' border='0' /></a>
		<p align='justify'>Esta aplicación ha sido desarrollada para 
		   supervisar la operación general de vehículos 
		   de transporte local, foráneo e internacional. 
		</p>
	</div>
	<div id='descMapas'>
		<a href='http://www.sepromex.com.mx:81/mapas.exe' title='Descargar'>Descarga Mapas</a><br/><br/>
		<a href='http://www.sepromex.com.mx:81/mapas.exe' title='Descargar'>
		<img src='img/mapas.jpg' width='160px' height='110px' border='0' /></a>
		<p align='justify'>
		Complemento del EGStation, el cual utiliza 
		estos mapas para lograr ser funcional al 100%. 
		</p>
	</div>
	<div id="contacto">Contactenos al Teléfono 38255200 ext. 117 o envíe un email a <u>aclientes@sepromex.com.mx</u></div>
  </div>
</div> 
</body>
</center>
</html>