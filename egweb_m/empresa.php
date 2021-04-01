<?php 
//ini_set('display_errors', 1);
include('ObtenUrl.php');
//$options="";
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
$xajax->register(XAJAX_FUNCTION,'matarSesion');
  
function matarSesion(){
	//$chequeo=0;
	$objResponse = new xajaxResponse();
	patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
	patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
	patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );
	include_once('../patSession/patSession.php');
	 $sess =& patSession::singleton('ham', 'Native', $options );
	$sess->destroy();
	$objResponse-> redirect("index.php");
	return $objResponse;
} 

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
	$dsn .= "<table border='0' id='newspaper-a1'>";
	//$dsn .= "<tr><td colspan='3'></td>";
    //$dsn .= "<td width='264' rowspan='8' align='center'>";
    //$dsn .= "&nbsp;</td>";
    //$dsn .= "</tr>";
   	$dsn .= "<tr>";
   	$dsn .= "<td width='160'>Razón Social:*</td>";
	$dsn .= "<td colspan='2'><input type='text' name='nombre' value='$row_emp[0]' size='43' /></td>";
   	$dsn .= "</tr>";
  	$dsn .= "<tr>";
	$dsn .= "<td>RFC:*</td>";
	$dsn .= "<td colspan='2'><input type='text' name='rfc' value='$row_emp[1]' size='43' /></td>";
   	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Representante:</td>";
	$dsn .= "<td colspan='2'><input type='text' name='rep' value='$row_emp[2]' size='43' /></td>";
   	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Dirección:*</td>";
	$dsn .= "<td colspan='2'><input type='text' name='dir' value='$row_emp[3]' size='43' /></td>";
   	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Colonia*:</td>";
	$dsn .= "<td colspan='2'><input type='text' name='col' value='$row_emp[4]' size='43' /></td>";
   	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Ciudad:*</td>";
	$dsn .= "<td colspan='2'><input type='text' name='cd' value='$row_emp[5]' size='43' /></td>";
	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Teléfono:*</td>";
	$dsn .= "<td colspan='2'><input type='text' name='tel' value='$row_emp[6]' size='43' /></td>";
   	$dsn .= "</tr>";
   	$dsn .= "<tr>";
	$dsn .= "<td>Fax:</td>";
	$dsn .= "<td colspan='2'><input type='text' name='fax' value='$row_emp[7]' size='43' /></td>";
	//$dsn .= "<td align='center'>&nbsp;</td>";
   	$dsn .= "</tr>";
	$dsn .= "<tr>";
	$dsn .= "<td colspan='3' align='center'>";
	$dsn .= "<input type='button' onclick='guardarEmpresa($ide)' value='Guardar' class='guardar1' >&nbsp";
	$dsn .= "<input type='button' onclick='xajax_cncEmpresa();' value='Cancelar' class='cancelar1'/>";
	$dsn .= "</td>";
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
	$objResponse->redirect("empresa.php",0);
	return $objResponse;
}

$xajax->processRequest();
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>Empresa</title>

<link href="css/black.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" language="javascript" src="librerias/jquery.js"></script>
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
		window.open('contacto.php?idc='+idc+'&tipo='+tipo,'contacto','width=400,height=380,left=100,top=200,scrollbars=NO');
	}
	if(idc==0 && tipo==0){
		window.open('contacto.php?idc='+idc+'&tipo='+tipo,'contacto','width=400,height=380,left=100,top=200,scrollbars=NO');
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
	objeto.innerHTML = '<input type="submit" name="log"  id="log" value="Guardar" class="agregar1"/>';
	document.getElementById('archivo').innerHTML='<input type="file" class="agregar1" name="imagen" accept="image/*" />';
}

function guardarArchivo(){
	xajax_updLogo(xajax.getFormValues("empresas"));
}
</script>
 <script type="text/javascript">
	var a=jQuery.noConflict();
idleTime = 0;
a(document).ready(function () {
    //Increment the idle time counter every minute.
    var idleInterval = setInterval("timerIncrement()", 60000); // 1 minute

    //Zero the idle timer on mouse movement.
    a(this).mousemove(function (e) {
        idleTime = 0;
    });
    a(this).keypress(function (e) {
        idleTime = 0;
    });
})
function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime > 29) { // 30 minutes
       xajax_matarSesion();
    }
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
<div id="fondo1">
	<div id="fondo2">
		<div id="fondo3">
    	<div id="cuerpo2" width="225" height="156">
  	    <div id="cuerpoSuphead">
			<div id="logo"><img src='img2/logo1.png'></div><!--Nos muestra el logo de la pagina "oficial"-->
    		<div id="psw_session" >
			Bienvenido <label ><b><?php echo htmlentities($nom); ?></b></label>&nbsp;&nbsp;
			<? 
				if(preg_match('/^principal/',curPageName())){
				?>
                <a href="javascript:void(null);" onclick="init()"> Cambiar Contraseña </a>
                |
				<?
				}
				?>
				<a href="<?php echo $_SERVER['PHP_SELF']."?Logout=true&".$queryString; ?>"> Cerrar Sesi&oacute;n </a>
			</div>
    
    	</div>
        <div id="num_msj" class="fuente_once"></div>
		<div id="cuerpo_head" >
        	<div id="menu">
            	<?php include("includes/menu.php");?>
        	</div>
  		</div>
        <div id="emp">
            <form name='empresas' id='empresas' action='empresa.php' method='post' enctype="multipart/form-data" > 
             <?php $cad_emp = "select nombre,rfc,rep,direccion,colonia,ciudad,tel_ppal,fax,logo from empresas where id_empresa = $ide";
                   $res_emp = mysql_query($cad_emp);
                   $row_emp = mysql_fetch_row($res_emp);
             ?>
                 <table border='0' id="newspaper-a1">
                   <tr><td colspan="3" style="height:0;"></td>
                       <td rowspan="10" style="none;" align="center">
                            <img src="<?php echo $row_emp[8] ?>" alt="logo" width="130" height="132" />
                            <br />
                       </td>
                   </tr>
                   <tr>
                   		<td width="160">Razón Social:</td>
                    	<td><?php echo $row_emp[0] ?></td>
                   </tr>
                   <tr>
                    	<td>RFC:</td>
                    	<td><?php echo $row_emp[1] ?></td>
                   </tr>
                   <tr>
                    	<td>Representante: </td>
                    	<td><?php echo $row_emp[2] ?></td>
                   </tr>
                   <tr>
                    	<td>Dirección:</td>
                    	<td><?php echo $row_emp[3] ?></td>
                   </tr>
                   <tr>
                    	<td>Colonia:</td>
                    	<td><?php echo $row_emp[4] ?></td>
                   </tr>
                   <tr>
                    	<td>Ciudad:</td>
                    	<td><?php echo $row_emp[5] ?></td>
                   </tr>
                   <tr>
                    	<td>Teléfono:</td>
                    	<td><?php echo $row_emp[6] ?></td>
                   </tr>
                   <tr>
                    	<td>Fax:</td>
                    	<td><?php echo $row_emp[7] ?></td>
                   <tr>
                   <tr>
						<td  align="right" height="20" id='archivo' colspan="4"></td>
			   	   </tr>
                   <tr>
                    	<td colspan="2">
                   			<?php if($est!=3){ ?>
                    		<a href="javascript:void(null);" style="text-decoration:none;" onclick="xajax_modEmpresa(<?php echo $ide; ?>)" title='Actualizar datos de empresa'>
                    		<!--<img src="img/kedit.png" width="20" height="20" border="0" />-->
                    		<input type="button" class="agregar1" name="actualizar" id="actualizar" onclick="xajax_modEmpresa(<?php echo $ide; ?>)" value="Actualizar datos"/>
                    		</a>
                    		<?php }?>
                    		</td>
                    	<td align="center" colspan="2">
                             <input type="button" class="agregar1" name="logo"  id="logoimg" onClick="crearFile(this);" value="Subir Archivo" />
                    	</td>
                   </tr>
              </table>
            </form>
        </div>
        <div style="clear:both;"></div>
        <div id="emp1">
			<?php 
            $cad_con = "SELECT nombre, puesto, telefonos, correo, horario, id_contacto FROM contactos where id_empresa='$ide' order by prioridad asc";
            $res_con = mysql_query($cad_con);
            ?>
              <table id="newspaper-a1">
                <tr>
                  <td colspan="5" align="right">
                  <?php if($est!=3){ ?>
                    <a href="javascript:void(null);" onclick="modContacto(0,0)">
                    <img src="img/agregar1.png" width="20" height="20" border="0" title="Agregar contacto"/>
                    </a>
                  <?php }?>
                  </td>
                  <td>CONTACTOS</td>
                </tr>
                <tr>
                  <th width="209">Nombre</th>
                  <th width="121">Puesto</th>
                  <th width="185">Tel&eacute;fono</th>
                  <th width="101">Correo</th>
                  <th width="78">24 hrs</th>
                  <th width="94"></th>
                </tr>
                <?php 
                while($rowCon = mysql_fetch_row($res_con)){
                  echo "<tr>";
                  echo "<td width='209' height='27'>".$rowCon[0]."</td>";
                  echo "<td width='121'>".utf8_encode($rowCon[1])."</td>";//agregamos utf8_encode para que salgan tanto "Ñ" como acentos
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
        <!-- aqui el contenido central-->
        <!--<div id="cuerpo_medio">
		</div>-->
      	<div style="clear:both;"></div>
		<div id="cuerpo_button">	
            <div id="contacto_ind">
                Contactenos al Teléfono 38255200 ext. 206 o envíe un email a 
                <a href="mailto:aclientes@sepromex.com.mx">aclientes@sepromex.com.mx</a>
            </div>
		</div>
        </div><!-- div cuerpo 2-->
        </div>
	</div>
</div>
</center>  
</body>
</html>
