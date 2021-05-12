<div class="container-fluid">
	<nav class="navbar navbar-expand navbar-default">
	  <a class="navbar-brand text" href="#">
	  	Bienvenido <label><b><?php echo htmlentities($nom); ?></b></label>
	  </a>
	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav mr-auto">
		      <?  if($ide==277) { ?>
		      	<li><label><a>Envio </a></label>
					<ul style='background-color:rgba(0, 0, 0, 0.7);width:60px;'>
						<li onclick='abreILSP()'><label>ILSP</label></li>
						<li onclick='abreFEMSA()'><label>FEMSA</label></li>
					</ul>
				</li>
			  <? } ?>
		      <li class="nav-item active">
		        <a class="nav-link text" onclick="load();" style="cursor:pointer;" title="Refrescar mapa" href="#">Home</a>
		      </li>
		      <li class="nav-item dropdown">
		        <a class="nav-link text dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Crear
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <? $si = strstr($prm,"3");
					if(($est != 3) ||($est == 3 && !empty($si))){?> 
		          		<a class="dropdown-item" href="#" title="Crear sitio de interes" style="cursor:pointer;" onclick="sitiointeres(<?php echo $ide?>)">Crear Sitio</a>
		          <?php } ?>
		          <?php 
				  $si = strstr($prm,"2");
				  if(($est != 3) ||($est == 3 && !empty($si))){?> 
			          <a class="dropdown-item" href="#" onclick="xajax_rutas();">Ruta</a>
			          <a class="dropdown-item" href="#" onclick="ejecutar_geocercas(<?php echo $ide?>,<?php echo $idu?>);">Crear Cerca Circular</a>
			          <a class="dropdown-item" href="#" onclick="ejecutar_geo_pol(<?php echo $ide?>);">Crear Cerca Poligonal</a>
			      <?php } ?>   
		        </div>
		      </li>
		      <?php 
				$si = strstr($prm,"6");
				if(($est != 3) ||($est == 3 && !empty($si))){?>
			      <li class="nav-item">
			        <a class="nav-link text" href="#" onclick="abrir_cat('catalogos.php')" style="cursor:pointer;">Catálogos</a>
			      </li>
			    <?php } $si = strstr($prm,"5");
				if(($est != 3) ||($est == 3 && !empty($si))){?> 
			      <li class="nav-item active">
			        <a class="nav-link text" href="#" onclick="abrir_reportes('reportes_recorrido.php')" style="cursor:pointer;">Reportes</a>
			      </li>
			    <?php } ?>
		      <li class="nav-item dropdown">
		        <a class="nav-link text dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Configuraciones
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <?php $si = strstr($prm,"7");
				  if(($est != 3) ||($est == 3 && !empty($si))){?>
			          <a class="dropdown-item" href="#" onclick="config_vel();" style="cursor:pointer;">Velocidades en Pantalla</a>
			          <a class="dropdown-item" href="#" onclick="alertas_gen();" style="cursor:pointer;">Reglas de Vehiculos</a>
			          <a class="dropdown-item" href="#" onclick="alertas_geo_server();" style="cursor:pointer;">Asignacion de Geocercas</a>
			          <!--<a class="dropdown-item" href="#" onclick="mantenimientos();" style="cursor:pointer;">Mantenimientos</a>-->
			          <a class="dropdown-item" href="#" onclick="alertas_todas();" style="cursor:pointer;">Alertas Online</a>
			          <a class="dropdown-item" href="#" onclick="abrir_asignacion('Eventos.php')" style="cursor:pointer;">Asignacion de Salidas Digitales Online</a>
			          <a class="dropdown-item" href="#" onclick="alertas_geo();" style="cursor:pointer;">Asignacion de Geocercas Online</a>
			          <a class="dropdown-item" href="#" onclick="reg_geo();" style="cursor:pointer;">Reglas de Geocercas Online</a>
			      <?php } ?>
		        </div>
		      </li>
		      <li class="nav-item dropdown">
		        <a class="nav-link text dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Manuales
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item" title="Campa&ntilde;a 4C's" href="Las_4_C.pdf" target="_blanck">Campaña 4C's </a>
		          <a class="dropdown-item"  href="Ayuda/Manual_de_EGWEB_para_el_Usuario.pdf" target="_blank">Ayuda </a>
		        </div>
		      </li>
		      <li class="nav-item dropdown">
		        <a class="nav-link text dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Ayuda
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item"  href="https://www.youtube.com/watch?v=pKmaIsKc3XY" target="_blank">Creacion de Geocerca</a>
		          <a class="dropdown-item"  href="https://www.youtube.com/watch?v=aMBpZDskOa4" target="_blank">Asignar Correos</a>
		          <a class="dropdown-item"  href="https://www.youtube.com/watch?v=WLaL5_Sclc8" target="_blank">Crear usuario espejo</a>
		        </div>
		      </li>
		      <li id="d_egstation" class="nav-item dropdown">
		        <a class="nav-link text dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          EGStation
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item" href="<? echo $servidor; ?>descargas/EGRepeater_update.exe" target="_blanck" onclick="xajax_registra_descarga(3)">Actualización EGRepeater</a>
		          <a class="dropdown-item" href="<? echo $servidor; ?>descargas/EGStation_update.exe" target="_blanck" onclick="xajax_registra_descarga(1)">Actualización EGStation</a>
		          <a class="dropdown-item" href="<? echo $servidor; ?>descargas/EGStation.exe" target="_blanck" onclick="xajax_registra_descarga(2)">Instalación limpia</a>
		        </div>
		      </li>
		      <li class="nav-item active" id="imagen">
		        <a class="nav-link text" onclick="grande()" title='Mostrar mapa grande' ><img src="img2/expandir.png" width="18px" border="0" style="cursor:pointer;"/></a>
		      </li>
		    </ul>		    
		    <!--
		    <button class="btn btn-success" id="" onclick="mostrar('home','catalogos','reportes');">home</button>
		    <button class="btn btn-success" id="" onclick="mostrar('catalogos','home','reportes');">catalogos</button>
		    <button class="btn btn-success" id="" onclick="mostrar('reportes','catalogos','home');">reportes</button>
			-->
			<a class="nav-link text" href="javascript:void(null);" onclick="init()" style="cursor: pointer;">Cambiar Contraseña</a>
		    <a class="nav-link text" href="javascript:void(null);" onclick="xajax_matarSesion()" style="cursor: pointer;">Cerrar Sesión</a>
	  </div>
	</nav>
</div>
<script>
	nC.post('includes/ver_descargas.php','',function(response){
		console.log(response);
		if(response==1){
			nC("#d_egstation").show();
		}
		else{
			nC("#d_egstation").html('');
			nC("#d_egstation").hide();
		}
	});
</script>
<?php			
//$query=mysql_query("SELECT usuario_web from usuarios where id_usuario=".$idu);
//echo $query;
//$egstation=mysql_fetch_array($query);
//if($egstation[0]==0 && $egstation[0]!=null){
//comprobacion si el servidor esta en linea
function verifServ($serv) {
	$a = @get_headers("http://".$serv);
	if (is_array($a)) {
		$estado= '1';
	} else {
		$estado= '-1';
	}
	return $estado;
}
//$servidor="http://egweb.seprosat.com.mx/";
$servidor= "http://200.39.13.94:81/egweb/";//"http://www.sepromex.com.mx:81/egweb/";

//if(verifServ("www.seprosat.com.mx")){
//	$servidor="http://egweb.seprosat.com.mx/";
//}else{
//	$servidor="http://www.sepromex.com.mx:81/egweb/";
//}

?>

<script type='text/javascript'>
		function config_vel(){
			var config_vel=window.open("config_vel.php","CONFIG","location=NO,width=700,height=480,left=500,top=0,resizable=NO,scrollbars=yes");
			childwindows[childwindows.length]=config_vel;
			config_vel.focus();
		}
		function mantenimientos(){
			var mantenimientos=window.open("mantenimientos.php","MANTENIMIENTO","location=NO,width=1100,height=600,left=50,top=0,resizable=YES,scrollbars=YES");
			childwindows[childwindows.length]=mantenimientos;
			mantenimientos.focus();
		}
		function alertas_geo(){
			var alertas_geo=window.open("alertas_geo.php","GEO","location=NO,width=1100,height=770,left=50,top=0,resizable=YES,scrollbars=YES");
			childwindows[childwindows.length]=alertas_geo;
			alertas_geo.focus();
		}
		function truckid(){
			var truckid=window.open("truck_id.php","truckid","location=NO,width=1100,height=770,left=50,top=0,resizable=YES,scrollbars=YES");
			childwindows[childwindows.length]=truckid;
			truckid.focus();
		}
		function garmin(){
			var garmin=window.open("garmin.php","garmin","location=NO,width=1100,height=770,left=50,top=0,resizable=YES,scrollbars=YES");
			childwindows[childwindows.length]=garmin;
			garmin.focus();
		}
		function alertas_geo_server(){
			var alertas_geo_server=window.open("alertas_geo_server.php","GEOSERCER","location=NO,width=1100,height=770,left=50,top=0,resizable=YES,scrollbars=YES");
			childwindows[childwindows.length]=alertas_geo_server;
			alertas_geo_server.focus();
		}
		function reg_geo(){
			var reg_geo=window.open("reg_geo.php","REGLAGEO","location=NO,width=1100,height=770,left=50,top=0,resizable=YES,scrollbars=YES");
			childwindows[childwindows.length]=reg_geo;
			reg_geo.focus();
		}
		function alertas_error(){
			var alertas_error=window.open("alertas_error.php","ERROR","location=NO,width=700,height=480,left=500,top=0,resizable=YES,scrollbars=YES");
			childwindows[childwindows.length]=alertas_error;
			alertas_error.focus();
		}
		function otras_config(){
			var otras_config=window.open("otras_config.php","OTRAS","location=NO,width=700,height=480,left=500,top=0,resizable=YES,scrollbars=YES");
			childwindows[childwindows.length]=otras_config;
			otras_config.focus();
		}
		function alertas_todas(){
			var alertas_todas=window.open("alertas_todas.php","TODAS","location=NO,width=1200,height=650,left=50,scrollbars=yes,top=0,resizable=YES,scrollbars=YES");
			childwindows[childwindows.length]=alertas_todas;
			alertas_todas.focus();
		}
		function abrir_cat(pag){
			var abrir_cat=window.open(pag,"CATALOGOS","location=NO,width=1000,height=700,left=50,top=0,resizable=YES,scrollbars=yes");
			childwindows[childwindows.length]=abrir_cat;
			abrir_cat.focus();
		}
		function abrir_asignacion(pag){
			var abrir_asignacion=window.open(pag,"ASIGNACION","location=NO,width=650,height=530,left=50,top=0,resizable=YES,scrollbars=YES");
			childwindows[childwindows.length]=abrir_asignacion;
			abrir_asignacion.focus();
		}
		function abrir_reportes(pag){
			var abrir_reportes=window.open(pag,"REPORTES","location=NO,width=1200,height=750,left=50,top=0,resizable=YES,scrollbars=yes");
			childwindows[childwindows.length]=abrir_reportes;
			abrir_reportes.focus();
		}
		function abrir_reglas(pag){
			var abrir_reglas=window.open(pag,"Reglas B","location=NO,width=1000,height=450,left=50,top=0,resizable=YES,scrollbars=YES");
			childwindows[childwindows.length]=abrir_reglas;
			abrir_reglas.focus();
		}
		function reglas_veh(){
			var reglas_veh=window.open("reglas_veh.php","Reglas","location=NO,width=1000,height=650,left=50,top=0,resizable=YES,scrollbars=YES");
			childwindows[childwindows.length]=reglas_veh;
			reglas_veh.focus();
		}
		function mostrar_actualizar(folio,reg){
			var mostrar_actualizar=window.open("mostrar_actualizar.php?folio="+folio+"&reg="+reg,"Actualizar","location=NO,width=1050,height=750,left=50,top=0,resizable=YES,scrollbars=YES");
			 childwindows[childwindows.length]=mostrar_actualizar;
			 mostrar_actualizar.focus();
		}
		function mostrar_geo(geo,id){
			var mostrar_geo=window.open("mostrar_geo.php?geo="+geo,"Mostrar Geocerca","location=NO,width=760,height=425,left=50,top=0,resizable=YES,scrollbars=YES");
			 childwindows[childwindows.length]=mostrar_geo;
			 mostrar_geo.focus();
		}
		function alertas_gen(geo,id){
			var alertas_gen=window.open("alertas_gen.php","Mostrar Geocerca","location=NO,width=1100,height=595,left=50,top=0,resizable=YES,scrollbars=YES");
			 childwindows[childwindows.length]=alertas_gen;
			 alertas_gen.focus();
		}
	</script>