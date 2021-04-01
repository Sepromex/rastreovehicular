<?php 
  include_once('../patError/patErrorManager.php');
  patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
  patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
  patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );
  include_once('../patSession/patSession.php');
  $sess =& patSession::singleton('egw', 'Native', $options );
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
  if ((!patErrorManager::isError($result)) && ($sess->get('Idu'))) {
		$queryString = $sess->getQueryString();	
		$idu = $sess->get("Idu");
		$ide = $sess->get("Ide");
    	$usn = $sess->get("Usn");
		$pol = $sess->get("Pol");
		$reg = $sess->get('Registrado');
		$nom = $sess->get('nom');
		$prm = $sess->get('per');
		$est = $sess->get('sta');
		$eve = $sess->get('eve');
		$dis = $sess->get('dis');
		$pan = $sess->get('pan');
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
require("librerias/conexion.php");
require('../xajaxs/xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI', '../xajaxs/');
$xajax->register(XAJAX_FUNCTION,"alertas");
$xajax->register(XAJAX_FUNCTION,"delCont");
$xajax->register(XAJAX_FUNCTION,"modEmpresa");
$xajax->register(XAJAX_FUNCTION,"updEmpresa");
$xajax->register(XAJAX_FUNCTION,"cncEmpresa");
$xajax->register(XAJAX_FUNCTION,"updLogo");

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

function delCont($idCont){
	$objResponse = new xajaxResponse();
	$cad_cont = "delete from contactos where id_contacto = $idCont";
	$res_cont = mysql_query($cad_cont);
	if($res_cont != 0){
		$objResponse->alert("Se eliminó el contacto");
		$objResponse->redirect("empresa.php",1.0);
	}else{
		$objResponse->alert("Falló la solicitud, intente nuevamente");
	}
	return $objResponse;
}

function modEmpresa($ide){
	$objResponse = new xajaxResponse();
	$cad_emp = "select nombre,rfc,rep,direccion,colonia,ciudad,tel_ppal,fax from empresas where id_empresa = $ide";
	$res_emp = mysql_query($cad_emp);
	$row_emp = mysql_fetch_row($res_emp);
	$dsn = "<form name='empresas' id='empresas' action='javascrip:void(null);' method='post'>";
	$dsn .= "<table width='804' border='0'>";
	$dsn .= "<tr><td colspan='3'></td>";
    $dsn .= "<td width='264' rowspan='8' align='center'>";
    $dsn .= "&nbsp;</td>";
    $dsn .= "</tr>";
   	$dsn .= "<tr>";
   	$dsn .= "<td width='160'>Razón Social:*</td>";
	$dsn .= "<td colspan='2'><input type='text' name='nombre' value='$row_emp[0]' size='55' /></td>";
   	$dsn .= "</tr>";
  	$dsn .= "<tr>";
	$dsn .= "<td>RFC:*</td>";
	$dsn .= "<td colspan='2'><input type='text' name='rfc' value='$row_emp[1]' size='55' /></td>";
   	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Representante:</td>";
	$dsn .= "<td colspan='2'><input type='text' name='rep' value='$row_emp[2]' size='55' /></td>";
   	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Dirección:*</td>";
	$dsn .= "<td colspan='2'><input type='text' name='dir' value='$row_emp[3]' size='55' /></td>";
   	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Colonia*:</td>";
	$dsn .= "<td colspan='2'><input type='text' name='col' value='$row_emp[4]' size='55' /></td>";
   	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Ciudad:*</td>";
	$dsn .= "<td colspan='2'><input type='text' name='cd' value='$row_emp[5]' size='55' /></td>";
	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Teléfono:*</td>";
	$dsn .= "<td colspan='2'><input type='text' name='tel' value='$row_emp[6]' size='55' /></td>";
   	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Fax:</td>";
	$dsn .= "<td colspan='2'><input type='text' name='fax' value='$row_emp[7]' size='55' /></td>";
	$dsn .= "<td align='center'>&nbsp;</td>";
   	$dsn .= "</tr>";
	$dsn .= "<tr>";
	$dsn .= "<td></td><td  colspan='2'>";
	$dsn .= "<input type='button' onclick='guardarEmpresa($ide)' value='Guardar' class='boton_reporte' >&nbsp";
	$dsn .= "<input type='button' onclick='xajax_cncEmpresa();' value='Cancelar' class='boton_reporte'/>";
	$dsn .= "</td><td></td>";
   	$dsn .= "</tr>";
  	$dsn .= "</table>";
	$dsn .= "</form>";
	$objResponse->assign("emp","innerHTML",$dsn);
	return $objResponse;
}

function updEmpresa($formEmp,$ide){
	$objResponse = new xajaxResponse();
	$nombre =  	$formEmp['nombre'];
	$rfc 	=	$formEmp['rfc'];
	$rep 	= 	$formEmp['rep'];
	$dir 	=	$formEmp['dir'];
	$col 	= 	$formEmp['col'];
	$cd 	=	$formEmp['cd'];
	$tel 	= 	$formEmp['tel'];
	$fax 	= 	$formEmp['fax'];
	if($nombre=='' || $rfc=='' || $dir=='' || $col=='' || $cd=='' || $tel==''){
		$objResponse->alert("Revise los campos marcados con *");
		return $objResponse;
	}
	else{
		$cad_emp  = "update empresas set ";
		$cad_emp .= "nombre='$nombre',rfc='$rfc',rep='$rep',direccion='$dir',colonia='$col',ciudad='$cd',tel_ppal='$tel',fax='$fax'";
		$cad_emp .= " where id_empresa = $ide";
		$res_emp = mysql_query($cad_emp);
		if($res_emp){
			$objResponse->alert("Se actualizaron los datos");
			$objResponse->redirect("empresa.php",1.0);
		}
		else{
			$objResponse->alert("Falló el envio, intente nuevamente");
		}
		return $objResponse;
	}
}

function cncEmpresa(){
	$objResponse = new xajaxResponse();
	$objResponse->redirect("empresa.php",1.0);
	return $objResponse;
}

$xajax->processRequest();
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>Empresa</title>
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
<script language="JavaScript" type="text/javascript">
function ayuda(){
    window.open("Ayuda/Ayuda.php","ayuda","width=400,height=350,left=500,top=200");
}
function tiempo(idu,p){
	if(p==1){
		setTimeout('tiempo('+idu+','+p+')',50000);
		document.getElementById('num_msj').innerHTML='<img src="img/loader.gif" width="15px" height="15px" />';
		xajax_alertas(idu);
	}
}

function modContacto(idc,tipo){
	if(idc!=0 && tipo==1){
		window.open('contacto.php?idc='+idc+'&tipo='+tipo,'contacto','width=330,height=250,left=300,top=200');
	}
	if(idc==0 && tipo==0){
		window.open('contacto.php?idc='+idc+'&tipo='+tipo,'contacto','width=330,height=320,left=300,top=200');
	}
}

function guardarEmpresa(ide){
	if(confirm("¿Está usted seguro de hacer modificaciones a los datos actuales?"))
		xajax_updEmpresa(xajax.getFormValues("empresas"),ide);
	else
		xajax_cncEmpresa();
}

function eliCont(idc){
	if(confirm("¿Está usted seguro de eliminar este contacto?"))
		xajax_delCont(idc);
}

function crearFile(obj){
	var objeto = obj.parentNode;
	objeto.innerHTML = '<input type="submit" name="log"  id="log" value="Guardar" class="boton_reporte"/>';
	document.getElementById('archivo').innerHTML='<input type="file" name="imagen" />';
}

function guardarArchivo(){
	xajax_updLogo(xajax.getFormValues("empresas"));
}
</script>
<?php 
	$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
</head>
<?php 
if($_POST['log']=="Guardar"){
	if($_FILES['imagen']['name'] != ''){
		$load = copy($_FILES['imagen']['tmp_name'], "Logo/".$ide."_".$_FILES['imagen']['name']);
		if($load){
			$imagen = "Logo/".$ide."_".$_FILES['imagen']['name'];
			mysql_query("update empresas set logo='$imagen' where id_empresa = $ide");
		}
	}
}
?>
<body id="fondo" onload="tiempo(<?php echo (int)$idu ?>,<?php echo $pan ?>);">
<center>
  	    <div id="fondo_principal">
    	<div id="cuerpo2" width="225" height="156">
  	    <div id="psw_session" class="fuente_cinco">
             <a href="<?php echo $_SERVER['PHP_SELF']."?Logout=true&".$queryString; ?>">Cerrar Sesi&oacute;n</a></div>
        <div id="msg_bvnd" class="fuente">
            Bienvenido, <label class="fuente_dos"><?php echo htmlentities($nom); ?></label>
        </div>
        <div id="num_msj" class="fuente_once"></div>
		   <div id="menu">
    	<ul id="lista_menu">
            <li><a href="javascript:void(null);" onclick="ayuda();">Ayuda</a></li>
            <!--<li><a href="descargas.php">Descargas</a></li>-->
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
            <li><a href="catalogos.php">Cátalogo</a></li>
            <?php }?>
            <li id="current"><a href="empresa.php">Mi Empresa</a></li>
            <li><a href="principal.php">Localización</a></li>
        </ul>
    </div>
	    <div id="emp" class="fuente">
        <form name='empresas' id='empresas' action='empresa.php' method='post' enctype="multipart/form-data" > 
         <?php $cad_emp = "select nombre,rfc,rep,direccion,colonia,ciudad,tel_ppal,fax,logo from empresas where id_empresa = $ide";
		 	   $res_emp = mysql_query($cad_emp);
			   $row_emp = mysql_fetch_row($res_emp);
		 ?>
             <table width="804" border='0'>
               <tr><td colspan="3"></td>
            	   <td width="264" rowspan="10" align="center">
                   		<img src="<?php echo $row_emp[8] ?>" alt="logo" width="130" height="132" />
            	   </td>
          	   </tr>
               <tr>
               <td width="160">Razón Social:</td>
               	<td colspan="2">
              		<?php echo $row_emp[0] ?>
               	</td>
          	   </tr>
               <tr>
               	<td>RFC:</td>
               	<td colspan="2">
               	<?php echo $row_emp[1] ?>
               	</td>
               </tr>
               <tr>
                <td>Representante: </td>
            	<td colspan="2">
              	<?php echo $row_emp[2] ?>
              	</td>
          	   </tr>
               <tr>
                <td>Dirección:</td>
            	<td colspan="2">
              	<?php echo $row_emp[3] ?>
              	</td>
          	   </tr>
               <tr>
                <td>Colonia:</td>
            	<td colspan="2">
              	<?php echo $row_emp[4] ?>
                </td>
          	   </tr>
               <tr>
                <td>Ciudad:</td>
            	<td colspan="2">	
              	<?php echo $row_emp[5] ?>
              	</td>
          		</tr>
               <tr>
                <td>Teléfono:</td>
            	<td colspan="2">
              	<?php echo $row_emp[6] ?>
              	</td>
          	   </tr>
               <tr>
                <td>Fax:</td>
                <td colspan="2">
              	<?php echo $row_emp[7] ?>
              	</td>
			   <tr>
				<td  align="right" height="10" id='archivo' colspan="4"></td>
			   </tr>
                 <tr>
            	<td align="" >
                <?php if($est!=3){ ?>
                <a href="javascript:void(null);" style="text-decoration:none;" onclick="xajax_modEmpresa(<?php echo $ide; ?>)" title='Actualizar datos de empresa'>
                <!--<img src="img/kedit.png" width="20" height="20" border="0" />-->
				<input type="button" class="boton_reporte" name="actualizar" id="actualizar" onclick="xajax_modEmpresa(<?php echo $ide; ?>)" value="Actualizar datos"/>
                </a>
                <?php }?>
                </td>
				<td colspan="2"></td>
				<td align="center">
				<input type="button" class="boton_reporte" name="logo"  id="logo" onClick="crearFile(this);" value="Subir Archivo" />
				</td>
          	   </tr>
          </table>
   </form>
  </div>
  <div id="emp1">
    <?php 
	$cad_con = "SELECT nombre, puesto, telefonos, correo, horario, id_contacto FROM contactos where id_empresa='$ide' order by prioridad asc";
	$res_con = mysql_query($cad_con);
	?>
	  <table width="802" border="0">
        <tr>
          <td colspan="5" align="right">
          <?php if($est!=3){ ?>
          	<a href="javascript:void(null);" onclick="modContacto(0,0)">
            <img src="img/agregar1.png"  title="Agregar Contacto" width="20" height="20" border="0" title="Agregar contacto"/>
            </a>
          <?php }?>
          </td>
          <td>CONTACTOS</td>
        </tr>
        <tr style="background:#002B5C" class="fuente_cinco">
          <td width="209">Nombre</td>
          <td width="121">Puesto</td>
          <td width="185">Tel&eacute;fono</td>
          <td width="101">Correo</td>
          <td width="78">24 hrs</td>
          <td width="94"></td>
        </tr>
        <?php 
		while($rowCon = mysql_fetch_row($res_con)){
		  echo "<tr>";
		  echo "<td width='209' height='27'>".$rowCon[0]."</td>";
          echo "<td width='121'>".$rowCon[1]."</td>";
          echo "<td width='185'>".$rowCon[2]."</td>";
          echo "<td width='101'>".$rowCon[3]."</td>";
          echo "<td width='78'>".$rowCon[4]."</td>";
          echo "<td width='94'>";
		  if($est != 3){
			  echo "<a href='javascript:void(null);' onclick='modContacto($rowCon[5],1);' title='Editar contacto'>";
			  echo "<img src='img/kedit.png' width='20' height='20' border='0'></a>";
			  echo "<a href='javascript:void(null);' onclick='eliCont($rowCon[5]);' title='Eliminar contacto'>";
			  echo "<img src='img/ico_delete.png' width='20' height='20' border='0'></a></td>";
		  }
		  echo "</tr>";
		}
		?>
      </table>
  </div>
  <div id="contacto">Contactenos al Teléfono 38255200 ext. 117 o envíe un email a <u>aclientes@sepromex.com.mx</u>  </div>
  </div>
  </div>
</center>  
</body>
</html>
