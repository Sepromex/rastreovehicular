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
	$reg = $sess->get('Registrado');
	$nom = $sess->get('nom');
	$prm = $sess->get('per');
	$est = $sess->get('sta');
	$eve = $sess->get("eve");
	if(!$reg)
		$sess->set('Registrado',1);
}else{
  	$sess->Destroy();
  	header("Location: index.php");
}

require("librerias/conexion.php");
require('../xajaxs/xajax_core/xajax.inc.php');

$xajax = new xajax();
if(preg_match('/seprosat/',curPageURL())){
	$xajax->configure('javascript URI', 'http://www.sepromex.com.mx:81/'.'xajaxs/');
}else{
	$xajax->configure('javascript URI', '../xajaxs/');
}

$xajax->register(XAJAX_FUNCTION,"alertas");

function alertas($idu,$fecha){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$evento = $sess->get('evf');
	$ban = $sess->get('ban');	
	$cad_pos = "select count(*) as suma ";
	$cad_pos .= " from veh_usr v ";
	$cad_pos .= " left outer join posiciones p on (v.num_veh = p.num_veh)";
	$cad_pos .= " where v.id_usuario = $idu";
	$cad_pos .= " and p.fecha >'".$evento."' and p.entradas = 252";
	$res_pos = mysql_query($cad_pos);
	$row_pos = mysql_fetch_row($res_pos);
	sleep(3);
	if($row_pos[0] == 0 && $ban == 0){
		$objResponse->assign("num_msj","innerHTML","");
	}
	if($row_pos[0] > 0 && $ban == 0){
		$objResponse->assign("num_msj","innerHTML","<a href='principal.php'title='Click para mostrar'>
							  Usted Tiene <u>".$row_pos[0]."</u> msj de Alerta</a> ");
	}
	if($row_pos[0] > 0 && $ban == 1){
	$objResponse->assign("num_msj","innerHTML","<a href='principal.php'title='Click para mostrar'>
						  Usted Tiene <u>".$row_pos[0]."</u> msj de Alerta</a> ");
	}	
	if($row_pos[0] == 0 && $ban == 1){
		$objResponse->assign("num_msj","innerHTML","");
	}
	return $objResponse;
}

$xajax->processRequest();
$idee=$ide;
$qgeoce1="Select nombre,num_geo from geo_time where id_empresa='$ide'";
$qgresult=mysql_query($qgeoce1);
$query1 = "SELECT v.ID_VEH, v.NUM_VEH FROM veh_usr AS vu Inner Join vehiculos AS v ON ";
$query1 .= "vu.NUM_VEH = v.NUM_VEH WHERE vu.ID_USUARIO = $idu ORDER BY v.ID_VEH ASC";
$result1 = mysql_query($query1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>EGWEB 3.0</title>
	<link href="librerias/dsn.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="librerias/func_principal.js"></script>
	<script language="JavaScript" type="text/javascript">
		
	function seleccionar_geos(){ 
	    form = document.forms["frmasiggeo"];
		form.imgcancelargeos.style.visibility="visible"; 
	    for (i=0;i<form.elements.length;i++){   
	       if(form.elements[i].name == "geos[]")form.elements[i].checked=1;   
	    }   
	} 
	function seleccionar_veh(){
	   var Form=document.frmasiggeo;
	   Form.imgcancelarveh.style.visibility="visible";
	    var long=Form.elements['vehiculos1[]'].length;
		for(i=0;i<long;i++){
		   if(Form.elements['vehiculos1[]'].options[i].selected==false){
			  Form.elements['vehiculos1[]'].options[i].selected=true;
		   }
		}
	}
	function deselec_veh(){
	   var Form=document.frmasiggeo;
	    Form.imgcancelarveh.style.visibility="hidden"; 
	    var long=Form.elements['vehiculos1[]'].length;
		for(i=0;i<long;i++){
		   if(Form.elements['vehiculos1[]'].options[i].selected==true){
			  Form.elements['vehiculos1[]'].options[i].selected=false;
		   }
		}
	}
	function deselec_geos(){
	    form = document.forms["frmasiggeo"];
		form.imgcancelargeos.style.visibility="hidden"; 
	    for (i=0;i<form.elements.length;i++){   
	       if(form.elements[i].name == "geos[]")form.elements[i].checked=0;   
	    }   
	}
	function validar(){
	   	i=0; n=0;
	    var pepez=0;
		var pepez2=0; 
		var fechaini;
		var fechafin;
		var valfec1=true;
		var valfec2=true;
	    var Form=document.frmasiggeo;
		if (Form.elements['vehiculos1[]'].selectedIndex==-1){
	         alert("Debe seleccionar un vehículo");
	         return (false);
	    }
		for(i=0; ele=document.frmasiggeo.elements[i]; i++){ 
	        if (ele.type=='checkbox') 
	        if (ele.checked)
			{pepez=1;break;}
		} 
	    if (pepez!=1){
		   alert('Debe seleccionar una Geocerca');
		   return (false);
		}
		Form.txtasig.value=1;
		Form.submit();
		Form.elements['vehiculos1[]'].selectedIndex==0;
		for(i=0; ele=document.frmasiggeo.elements[i]; i++){ 
	        if (ele.type=='checkbox') 
	        if (ele.checked){ 
				ele.checked=0;}
		} 
	}
	function ayuda(){
	    window.open("Ayuda/Ayuda.php","ayuda","width=400,height=350,left=500,top=200");
	    //*/*/
	}
	function tiempo(idu){
		setTimeout('tiempo('+idu+')',50000);
		document.getElementById('num_msj').innerHTML='<img src="img/loader.gif" width="15px" height="15px" />';
		xajax_alertas(idu);
	}
	</script>
<?php $xajax->printJavascript(); ?>
</head>
<center>
	<body id="fondo" onload="tiempo(<?php echo (int)$idu ?>);" >
	  	<div id="fondo_principal">
	    	<div id="cuerpo" width="225" height="156">
		  	    <div id="psw_session" class="fuente_cinco">
		        	<a href="<?php echo $_SERVER['PHP_SELF']."?Logout=true&".$queryString; ?>">Cerrar Sesi&oacute;n</a>        
			    </div>
	        	<div id="num_msj" class="fuente_once"></div>
		        <div id="msg_bvnd" class="fuente">
		            <strong>Bienvenido</strong> <label class="fuente_dos"><?php echo htmlentities($nom); ?></label>
		        </div>
				<div id="menu">
		    	    <ul id="lista_menu">
		           		<li><a href="javascript:void(null);" onclick="ayuda();">Ayuda</a></li>
		            	<li><a href="descargas.php">Descargas</a></li>
		        		<li id="current"><a href="Eventos.php">Eventos</a></li>
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
		                <li><a href="empresa.php">Mi Empresa</a></li>
		                <li><a href="principal.php">Localización</a></li>
		            </ul>
		        </div>
				<div id="tituloveh">VEHICULOS</div>  
				<div id="impgeocer">ASIGNAR GEOCERCA</div>
				<form name="frmasiggeo" method="post" action="asignar_geo.php">
					<?php 
						$basig=$_POST['txtasig'];
						if($basig==1){
						   $dentro  = $_POST['panico']; 
						   $ingreso = $_POST['sale'];
						   $salida  = $_POST['entra'];
						   if($dentro =='')
						   		$dentro=0;
						   if($ingreso =='')
						   		$ingreso=0;
						   if($salida =='')
							    $salida = 0;
						   $fecha   = date('Y-m-d H:i:s');
						   $queryg="INSERT into geo_veh(num_veh,num_geo,dentro,ingreso,salida,fecha,id_usuario) values ";
								for($i=0;$i<sizeof($_POST["vehiculos1"]); $i++){
					                 $arrayvh[$i]=$_POST["vehiculos1"][$i];
						             $vehiculo=$arrayvh[$i];
									 for($ii=0;$ii<sizeof($_POST["geos"]);$ii++){   
				   	                    $arraychx[$ii]=$_POST['geos'][$ii];
									     $geoc = $arraychx[$ii];  
										 $queryg .= "('$vehiculo','$geoc','$dentro','$ingreso','$salida','$fecha','$idu'),";
				                     }
					  			}
							$queryg .="**";
							$queryg = str_replace(",**", ";", $queryg);
							$resp=mysql_query($queryg);
							if($resp!=0){
							   	echo "<script type='text/javascript'>alert('Geocerca Asignada')</script>";
							}
							else{
							    echo "<script type='text/javascript'>alert('Error en la asignación')</script>";
							}			
						}
					?>
			       	<div id="vehiygeoc">
						<div id="espgeocer">
						<?php
						    $pos=0; $pos1=1;
						   	while($fila=mysql_fetch_array($qgresult)){
					             $nomg=$fila['nombre']; 
								 $numg=$fila['num_geo'];
							     echo '<input type="checkbox" name="geos[]" value='.$numg.' />'.$nomg.'<br />';
							}	         
						 ?>
						</div>
						<div id="cont_autos3">
						    <select multiple name="vehiculos1[]" size="30" class="vehiculos" title="Presione CTRL+Click para seleccionar varios elementos">
					            <?php while($registro=mysql_fetch_row($result1)){  
					            		$registro[0]=htmlentities($registro[0]); 
					            		echo "<option value='".$registro[1]."'>".$registro[0]."</option>"; 
					            } ?> 
						    </select>
				        </div>
					    <input type="button" name="asiggeo" id="asiggeo" value="Asignar Geocerca" class="boton_poleo2" onClick="javascript:validar();" />
					    <div id="bot_asig">
						   <label>
						   		<img src="Iconos1/cancel1.jpg" name="imgcancelarveh" title="Cancelar" width="24" height="21" onClick="deselec_veh();" style="visibility:hidden">
				           		<img src="Iconos1/apply.png" title="Selecciona todos los vehículos" name="imgveh" width="17" height="16" onClick="seleccionar_veh();">Todos los Vehículos 
				           	</label>
					        <label>
						    	<br><img src="Iconos1/cancel1.jpg" name="imgcancelargeos" width="25" title="Cancelar" height="22" onClick="deselec_geos();" style="visibility:hidden">
				             	<img src="Iconos1/apply.png" title="Selecciona todas las Geocercas" name="imggeo" width="17" height="16" onClick="seleccionar_geos();">Todas las geocercas<br /><br>
					        </label>
				            <input type="checkbox" name='panico' id="panico" value="2" checked="checked"/> Aviso de Pánico a Monitoreo<br />
				            <input type="checkbox" name='sale' id="sale" value="1" checked="checked" /> Avisar al Salir<br />
				            <input type="checkbox" name='entra' id="entra" value="1" checked="checked" /> Avisar al Entrar<br />
					    </div>
			       	 </div> 
					 <input type="hidden" name="txtasig" value="0"/> 
			 	</form>
		  		<div id="contacto" class="fuente_cinco">Contactenos al Teléfono 38255200 ext. 117 o envíe un email a <u>aclientes@sepromex.com.mx</u></div>
		  	</div>
	  	</div>
	</body>
</center>
</html>
