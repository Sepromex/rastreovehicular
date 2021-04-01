<div id="conf_recorrido" style="position:absolute;top:87px;left:20px;width:100%;">
	<ul id="nav1" class="drop1" >
		<li id="liga_rec" title='Reporte de recorrido' onclick="tipo(1,<?php echo (int)$ide; ?>,<?php echo (int)$idu; ?>);">
			<a href="javascript:void(null);" >Reporte de recorrido</a>
		</li>
		<li id='liga_ult' title='&Uacute;ltima posici&oacute;n' onclick="tipo(5,<?php echo (int)$ide; ?>,<?php echo (int)$idu; ?>);">
			<a href="javascript:void(null);" >&Uacute;ltima posici&oacute;n</a>
		</li>
		<li id='tiempo_sin' title='Tiempo sin movimiento' onclick="tipo(2,<?php echo (int)$ide;?>,<?php echo (int)$idu; ?>);">
			<a href="javascript:void(null);" >Tiempo sin movimiento</a>
		</li>
		<li id='dist_acum' title='Distancias Acumuladas' onclick="tipo(2,<?php echo (int)$ide;?>,<?php echo (int)$idu; ?>);">
			<a href="javascript:void(null);" >Distancias Acumuladas</a>
		</li>
	
		<?
			$sensor=mysql_query("SELECT v.ID_VEH, v.NUM_VEH
				FROM veh_usr AS vu
				Inner Join vehiculos AS v ON vu.NUM_VEH = v.NUM_VEH
				inner join estveh ev on v.estatus=ev.estatus
				inner join veh_accesorio a on v.num_veh=a.num_veh
				inner join cat_accesorios c on a.id_accesorio=c.id_accesorio
				WHERE vu.ID_USUARIO = $idu and ev.publicapos=1
				and vu.activo=1
				and c.descripcion like '%combustible%'
				ORDER BY v.ID_VEH ASC");
			if(mysql_num_rows($sensor)>0){
		?>
		<li id='sensor_gas' title='Sensor de combustible' onclick="tipo(4,<?php echo (int)$ide;?>,<?php echo (int)$idu; ?>);">
			<a href="#" >Reporte de Gasolina</a>
		</li>
		<?
			}
		?>
		<?
			$sensor=mysql_query("SELECT v.ID_VEH, v.NUM_VEH
				FROM veh_usr AS vu
				Inner Join vehiculos AS v ON vu.NUM_VEH = v.NUM_VEH
				inner join estveh ev on v.estatus=ev.estatus
				inner join veh_accesorio a on v.num_veh=a.num_veh
				inner join cat_accesorios c on a.id_accesorio=c.id_accesorio
				WHERE vu.ID_USUARIO = $idu and ev.publicapos=1
				and vu.activo=1
				and c.descripcion like '%temp%'
				ORDER BY v.ID_VEH ASC");
			if(mysql_num_rows($sensor)>0){
		?>
		<li id='sensor_temp' title='Sensor de temperatura' onclick="tipo(6,<?php echo (int)$ide;?>,<?php echo (int)$idu; ?>);">
			<a href="#" >Reporte de temperatura</a>
		</li>
		<?
			}
		?>
	</ul>
</div>  