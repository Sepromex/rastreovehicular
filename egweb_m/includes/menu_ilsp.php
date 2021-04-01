<?php
	$cons_Tsitios = "select id_tipo,descripcion from tipo_sitios where id_empresa = $ide or id_empresa = 15";
	$resp_Tsitios = mysql_query($cons_Tsitios);
	$opc="'"; 
	while($row_Tsitios = mysql_fetch_row($resp_Tsitios)){
		$opc .="<option value=".$row_Tsitios[0].">".htmlentities($row_Tsitios[1])."</option>";			
	}
	$opc.="'";
?>
<div id="conf" >
	<ul id="nav1" class="drop1" >
		<li onclick="load();" style="cursor:pointer;" title="Refrescar mapa">
			<label>
			Home
			</label>
		</li>
		<?
		$si = strstr($prm,"3");
		if(($est != 3) ||($est == 3 && !empty($si))){?> 
			<li title="Crear sitio de interes" style="cursor:pointer;" onclick="sitiointeres(<?php echo $ide?>,<?php echo $opc?>)">
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
			<ul id='geocerca' align='center' style='background-color:rgba(0, 0, 0, 0.7);width:105px;'>
				<!--<li><label onclick="ejecutar_geo_lineal(<?php echo $ide?>);">
					Lineal
					</label>
				</li>-->
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
		<?php }?>
		
		<?php 
		$si = strstr($prm,"1");
		if(($est != 3) ||($est == 3 && !empty($si))){?>
		<!--<li  style="cursor:pointer;" id='elpoleo'>
			<label  onclick="polear(<? echo $veh_actual;?>);">
				Solicitar posici&oacute;n
			</label>
		</li>-->
		<?php }?>
		<?
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
			</ul>
		</li>
		<li>
			<label>Configuraciones online</label>
			<ul align='center' style='background-color:rgba(0, 0, 0, 0.7);width:144px;'>
				<li>
					<label>
					Alertas
					</label>
					<ul align='center' style='background-color:rgba(0, 0, 0, 0.7);'>
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
					</ul>
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
		<?
			$query=mysql_query("SELECT usuario_web from usuarios where id_usuario=".$idu);
			//echo $query;
			$egstation=mysql_fetch_array($query);
			if($egstation[0]==0){
				?>
				<li>
					<label>EGStation</label>
					<ul style='background-color:rgba(0, 0, 0, 0.7);'>
						<li>
							<label>
								<a href="../descargas/EGStation_update.exe" target="_blanck">Actualización</a>
							</label>
						</li>
						<li>
							<label>
								<a href="../descargas/EGStation_full.exe" target="_blanck">Instalación limpia</a>
							</label>
						</li>
					</ul>
				</li>
				<?
			}
		?>
		<?  if($ide==277) { ?>
			<li><label><a href="javascript:void(null)" onclick='abreILSP()'>Envio ILSP</a></label></li>
		<? } ?>
	</ul>
	</div>
	<script type='text/javascript'>
		
		function config_vel(){
			var config_vel=window.open("config_vel.php","CONFIG","location=NO,width=700,height=480,left=500,top=0,resizable=NO");
			childwindows[childwindows.length]=config_vel;
		}
		function alertas_vel(){
			var alertas_vel=window.open("alertas_vel.php","VELOCIDAD","location=NO,width=700,height=480,left=500,top=0,resizable=NO");
			childwindows[childwindows.length]=alertas_vel;
		}
		function alertas_movs(){
			var alertas_movs=window.open("alertas_movs.php","MOVS","location=NO,width=700,height=480,left=500,top=0,resizable=NO");
			childwindows[childwindows.length]=alertas_movs;
		}
		function alertas_accesorios(){
			var alertas_accesorios=window.open("alertas_acc.php","ACCESORIO","location=NO,width=700,height=480,left=500,top=0,resizable=NO");
			childwindows[childwindows.length]=alertas_accesorios;
		}
		function alertas_otros(){
			var alertas_otros=window.open("alertas_otros.php","OTROS","location=NO,width=700,height=480,left=500,top=0,resizable=NO");
			childwindows[childwindows.length]=alertas_otros;
		}
		function alertas_geo(){
			var alertas_geo=window.open("alertas_geo.php","GEO","location=NO,width=1100,height=770,left=50,top=0,resizable=NO,scrollbars=YES");
			childwindows[childwindows.length]=alertas_geo;
		}
		function alertas_geo_server(){
			var alertas_geo_server=window.open("alertas_geo_server.php","GEOSERCER","location=NO,width=1100,height=770,left=50,top=0,resizable=NO,scrollbars=YES");
			childwindows[childwindows.length]=alertas_geo_server;
		}
		function alertas_error(){
			var alertas_error=window.open("alertas_error.php","ERROR","location=NO,width=700,height=480,left=500,top=0,resizable=NO");
			childwindows[childwindows.length]=alertas_error;
		}
		function abrir_cat(pag){
			var abrir_cat=window.open(pag,"CATALOGOS","location=NO,width=1000,height=700,left=50,top=0,resizable=NO");
			childwindows[childwindows.length]=abrir_cat;
		}
		function abrir_asignacion(pag){
			var abrir_asignacion=window.open(pag,"ASIGNACION","location=NO,width=650,height=480,left=50,top=0,resizable=NO");
			childwindows[childwindows.length]=abrir_asignacion;
		}
		function abrir_reportes(pag){
			var abrir_reportes=window.open(pag,"REPORTES","location=NO,width=1200,height=750,left=50,top=0,resizable=NO");
			childwindows[childwindows.length]=abrir_reportes;
		}
		function abrir_reglas(pag){
			var abrir_reglas=window.open(pag,"Reglas B","location=NO,width=1000,height=450,left=50,top=0,resizable=NO");
			childwindows[childwindows.length]=abrir_reglas;
		}
		function reglas_veh(){
			var reglas_veh=window.open("reglas_veh.php","Reglas","location=NO,width=1000,height=650,left=50,top=0,resizable=NO");
			childwindows[childwindows.length]=reglas_veh;
		}
		function mostrar_actualizar(folio,reg){
			var mostrar_actualizar=window.open("mostrar_actualizar.php?folio="+folio+"&reg="+reg,"Actualizar","location=NO,width=1050,height=750,left=50,top=0,resizable=NO");
			 childwindows[childwindows.length]=mostrar_actualizar;
		}
		function mostrar_geo(geo,id){
			var mostrar_geo=window.open("mostrar_geo.php?geo="+geo,"Mostrar Geocerca","location=NO,width=760,height=425,left=50,top=0,resizable=NO");
			 childwindows[childwindows.length]=mostrar_geo;
		}
		function alertas_gen(geo,id){
			var alertas_gen=window.open("alertas_gen.php","Mostrar Geocerca","location=NO,width=1100,height=595,left=50,top=0,resizable=NO");
			 childwindows[childwindows.length]=alertas_gen;
		}
	</script>