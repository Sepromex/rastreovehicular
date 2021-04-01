<script>
/* ESTE ARCHIVO NO EXISTE
nC.post('includes/ver_garmin.php','',function(response){
	if(response==1){
		nC("#garmin").show();
	}
	else{
		nC("#garmin").hide();
	}
});
*/
</script>
<div id="conf" >
	<ul id="nav1" class="drop1" >
		<?  if($ide==277) { ?>
			<li><label>Envio </a></label>
				<ul style='background-color:rgba(0, 0, 0, 0.7);width:60px;'>
					<li onclick='abreILSP()'><label>ILSP</label></li>
					<li onclick='abreFEMSA()'><label>FEMSA</label></li>
				</ul>
			</li>
		<? } ?>
		<li onclick="load();" style="cursor:pointer;" title="Refrescar mapa">
			<label>
			Home
			</label>
		</li>
		<?
		$si = strstr($prm,"3");
		if(($est != 3) ||($est == 3 && !empty($si))){?> 
			<li title="Crear sitio de interes" style="cursor:pointer;" onclick="sitiointeres(<?php echo $ide?>)">
				<label>
				Crear sitio
				</label>
			</li>
			<?php 
		}?>
		<?php 
		$si = strstr($prm,"2");
		if(($est != 3) ||($est == 3 && !empty($si))){?> 
		<li><label>
			Crear geocercas 
			</label>
			<ul align='center' style='background-color:rgba(0, 0, 0, 0.7);width:105px;'>
				<li><label onclick="xajax_rutas();">
					Ruta
					</label>
				</li>
				<li onclick="ejecutar_geocercas(<?php echo $ide?>,<?php echo $idu?>);">
					<label >
					Cerca circular
					</label>
				</li>
				<li onclick="ejecutar_geo_pol(<?php echo $ide?>);">
					<label >
					Cerca poligonal
					</label>
				</li>
			</ul>
		</li>
		<?php 
		}
		$si = strstr($prm,"6");
		if(($est != 3) ||($est == 3 && !empty($si))){?> 
		<li onclick="abrir_cat('catalogos.php')" style="cursor:pointer;">
			<label>
			Cat&aacute;logos
			</label>
		</li>
		<?
		}
		$si = strstr($prm,"5");
		if(($est != 3) ||($est == 3 && !empty($si))){?> 
		<!--   <li onclick="abrir_reportes('reportes_recorrido.php')" style="cursor:pointer;"><label> -->
		<li onclick="abrir_reportes('reportes_recorrido.php')" style="cursor:pointer;"><label> 
			Reportes
			</label>
		</li>
		<?
		}
		
		$si = strstr($prm,"7");
		if(($est != 3) ||($est == 3 && !empty($si))){?> 
		<li>
			<label>Configuraciones</label>
			<ul align='center' style='background-color:rgba(0, 0, 0, 0.7);width:108px;' >
				<li onclick="config_vel();" style="cursor:pointer;">
					<label>
					Velocidades en pantalla
					</label>
				</li>
				<li onclick="alertas_gen();" style="cursor:pointer;">
					<label>
					Reglas de veh&iacute;culos
					</label>
				</li>
				<li style="cursor:pointer;" onclick='alertas_geo_server();'>
					<label>
					Asignacion de geocercas
					</label>
				</li>
				<li style="cursor:pointer;" onclick='mantenimientos();'>
					<label>
					Mantenimientos
					</label>
				</li>
			</ul>
		</li>
		<li>
			<label>Configuraciones online</label>
			<ul align='center' style='background-color:rgba(0, 0, 0, 0.7);width:144px;'>
				<li style="cursor:pointer;" onclick='alertas_todas();'>
					<label>
					Alertas
					</label>
					<!--<ul align='center' style='background-color:rgba(0, 0, 0, 0.7);'>
						<li style="cursor:pointer;" onclick='alertas_vel();'>
							<label>
							Velocidad
							</label>
						</li>
						<li style="cursor:pointer;" onclick='alertas_accesorios();'>
							<label>
							Accesorios
							</label>
						</li>
						<li style="cursor:pointer;" onclick='alertas_otros();'>
							<label>
							Otras
							</label>
						</li>
					</ul>-->
				</li>
				<li onclick="abrir_asignacion('Eventos.php')" style="cursor:pointer;">
					<label>
					Asignacion de salidas digitales
					</label>
				</li>
				<li style="cursor:pointer;" onclick='alertas_geo();'>
					<label>
					Asignacion de geocercas
					</label>
				</li>
				<!--<li style="cursor:pointer;" onclick='otras_config();'>
					<label>
					Otras configuraciones
					</label>
				</li>-->
				<!--<li style="cursor:pointer;" onclick='espia();'>
					<label>
					Modo espia
					</label>
				</li>-->
				<li style="cursor:pointer;" onclick='reg_geo();'>
					<label>
					Reglas en geocercas
					</label>
				</li>
				<!--
				<li style="cursor:pointer;" onclick='truckid();'>
					<label>
					TruckID
					</label>
				</li>
				<li style="cursor:pointer;" onclick='garmin();' id='garmin' style='display:none;'>
					<label>
					GARMIN
					</label>
				</li>-->
			</ul>
		</li>
		<?
		}
		?>
		<li title="Campa&ntilde;a 4C's"><a href="Las_4_C.pdf" target="_blanck" ><img src="images/letra_i.png"  width="18px" height="18px"/></a></li>
		<li onclick="ayuda();" title="Ayuda"><label><img src="img2/help.png" height='18px' style="cursor:pointer;" /></label></li>
		<li title='Mostrar mapa grande' id="imagen">
			<label  onclick="grande()">
				<img src="img2/expandir.png" width="18px" border="0"  />
			</label>
		</li>
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
				/*
				if(verifServ("www.seprosat.com.mx")){
					$servidor="http://egweb.seprosat.com.mx/";
				}
				else{
					$servidor="http://www.sepromex.com.mx:81/egweb/";
				}
				*/
				?>
				<li id="d_egstation">
					<label>EGStation</label>
					<ul style='background-color:rgba(0, 0, 0, 0.7);'>
						<li>
							<label>
								<a href="<? echo $servidor; ?>descargas/EGRepeater_update.exe" target="_blanck" onclick="xajax_registra_descarga(3)">Actualización EGRepeater</a>
								<!--<a href="http://www.sepromex.com.mx:81/egweb/descargas/EGRepeater_update.exe" target="_blanck" onclick="xajax_registra_descarga(3)">Actualización EGRepeater</a>-->
							</label>
						</li>
						<li>
							<label>
								<a href="<? echo $servidor; ?>descargas/EGStation_update.exe" target="_blanck" onclick="xajax_registra_descarga(1)">Actualización EGStation</a>
								<!--<a href="http://www.sepromex.com.mx:81/egweb/descargas/EGStation_update.exe" target="_blanck" onclick="xajax_registra_descarga(1)">Actualización EGStation</a>-->
							</label>
						</li>
						<li>
							<label>
								<a href="<? echo $servidor; ?>descargas/EGStation.exe" target="_blanck" onclick="xajax_registra_descarga(2)">Instalación limpia</a>
								<!--<a href="http://www.sepromex.com.mx:81/egweb/descargas/EGStation.exe" target="_blanck" onclick="xajax_registra_descarga(2)">Instalación limpia</a>-->
							</label>
						</li>
					</ul>
				</li>
				
				<?
			//}
		?>
	</ul>
	</div>
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