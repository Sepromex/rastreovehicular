<?
$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Accion de impacto%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='3' align='right'>
			<input type='radio' id='enviar_correo_imp' onclick='xajax_mostrar_correo($folios[0],\"impact\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='3' align='right'>
				<input type='radio' id='enviar_correo_imp' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"impact\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='3' align='right'>
		<input type='radio' id='enviar_correo_imp' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"impact\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"impact\")'>";
$formu.="
<table id='rounded-corner'>
	$box
	<tr>
		<th width='320' colspan='2'  style='text-align:left'>Sensor de impacto</th>
		<th><div id='impact'></div>$btn_info</th>
	</tr>
	<tr>
		<td>Activar:<input type='radio' name='simpacto' id='impact1'/></td>
		<td colspan='2'>Desactivar:<input type='radio' name='simpacto' id='impact0' /></td>
	</tr>
	<tr>
		<td colspan='1'>Fuerza:</td>
		<td colspan='2'>
			<div id='slider'>
				<input class='bar' type='range' id='fuerza' value='0' max='16' min='1' onchange='rangeFP.value=value'/>
				<span class='highlight'></span>
				<output id='rangeFP'>0</output> 
			</div>
		</td>
	</tr>
	<tr>
		<td colspan='3'>
			<input type='button' class='guardar1' id='bosi' value='Obtener' onclick='xajax_auditabilidad(90,$veh);U1LITE(\"impact\",\"get\",\"\")'/>
			<input type='button' id='besi' class='guardar1' value='Guardar' onclick='xajax_auditabilidad(91,$veh);notifica_correo(\"imp\",$veh);U1LITE(\"impact\",\"set\",\"fuerza\");'/>
		</td>
	</tr>
</table><hr>";

/*
	agregamos el formulario para el aviso por correo del motor encendido
	Este formulario se validara desde el archivo alertas_otros.php
*/
$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Acciones del motor encendido/apagado%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='2' align='right'>
			<input type='radio' id='enviar_correo_mot' onclick='xajax_mostrar_correo($folios[0],\"e_motor\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='2' align='right'>
				<input type='radio' id='enviar_correo_mot' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"e_motor\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='2' align='right'>
		<input type='radio' id='enviar_correo_mot' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"e_motor\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"e_motor\")'>";
$formu.="
<table id='rounded-corner'>
	$box
	<tr>
		<th>Acciones del motor</th>
		<th><div id='motor'></div>$btn_info</th>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='checkbox' name='encendido' id='encendido'>Motor encendido
		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='checkbox' name='apagado' id='apagado'>Motor apagado
		</td>
	</tr>
	<tr>
		<td>
			<input type='button' onclick='xajax_auditabilidad(92,$veh);xajax_obten_motor(".$veh.")' value='Obtener' class='agregar1'>
		</td>
		<td>
			<input type='button' onclick='xajax_auditabilidad(93,$veh);notifica_correo(\"mot\",$veh);' value='Guardar' class='agregar1'>
		</td>
	</tr>
</table><hr>";
/*
	GASOLINA
*/
$query=mysql_query("SELECT * FROM veh_accesorio AS V_A
		INNER JOIN cat_accesorios AS C_A ON V_A.id_accesorio=C_A.id_accesorio
		WHERE V_A.num_veh='".$veh."'
		AND C_A.descripcion like '%combustible%' and V_A.activo=1");
if(mysql_num_rows($query)!=0){
$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Sensor de Gasolina%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='2' align='right'>
			<input type='radio' id='enviar_correo_gas' onclick='xajax_mostrar_correo($folios[0],\"gas\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='2' align='right'>
				<input type='radio' id='enviar_correo_gas' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"gas\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='2' align='right'>
		<input type='radio' id='enviar_correo_gas' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"gas\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"gas\")'>";
$formu.="
<table id='rounded-corner'>
	$box
	<tr>
		<th><input type='radio' name='gasolina' id='gas1' checked>Sensor de Gasolina</th>
		<th><div id='gas'></div>$btn_info</th>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='radio' name='gasolina' value='1'>
			Avisar cuando el nivel baje mas de:<input $style type='number' max='100' min='5' value='10'>%</td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='radio' name='gasolina' value='2'>
			Avisar cuando suba el nivel <input $style type='number' max='100' min='5' value='15'>% 
			y el tanque este a un <input $style type='number' max='100' min='5' value='50'>% o mayor
		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='radio' name='gasolina' value='3'>
			Avisar cuando suba el nivel mayor a:<input $style type='number' max='100' min='5' value='90'>% 
			y el tanque esta a un <input $style type='number' max='100' min='5' value='20'>% o mayor
		</td>
	</tr>
	<tr>
		<td>
			<input type='button' onclick='xajax_auditabilidad(125,$veh);xajax_obten_gasolina(".$veh.")' value='Obtener' class='agregar1'>
		</td>
		<td>
			<input type='button' onclick='xajax_auditabilidad(126,$veh);notifica_correo(\"gas\",$veh);' value='Guardar' class='agregar1'>
		</td>
		<input type='hidden' name='id_veh' id='id_veh' value='".$veh."' >
	</tr>
</table><hr>";
}
/*
	Agregamos una validacion para ver si el vehiculo cuenta con el sensor de TOMA DE FUERZA (gruas)
*/
$query=mysql_query("SELECT * FROM veh_accesorio AS V_A
		INNER JOIN cat_accesorios AS C_A ON V_A.id_accesorio=C_A.id_accesorio
		WHERE V_A.num_veh='".$veh."'
		AND C_A.descripcion like '%toma de fuerza%' and V_A.activo=1");
if(mysql_num_rows($query)!=0){
	$box='';
	$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
	and activo=1 and descripcion like '%Modulo de toma de fuerza%'";
	$res=mysql_query($correos);
	if(mysql_num_rows($res)>0){
		if(mysql_num_rows($res)==1){
			$folios=mysql_fetch_array($res);
			$box="
			<tr>
				<th colspan='2' align='right'>
				<input type='radio' id='enviar_correo_fza' onclick='xajax_mostrar_correo($folios[0],\"t_fuerza\")'>Notificar por correo
				</th>
			</tr>";
		}
		if(mysql_num_rows($res)>1){		
			$box="
			<tr>
				<th colspan='2' align='right'>
					<input type='radio' id='enviar_correo_fza' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"t_fuerza\")'>Notificar por correo
				</th>
			</tr>";		
		}
	}
	else{
		$box="
		<tr>
			<th colspan='2' align='right'>
			<input type='radio' id='enviar_correo_fza' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"t_fuerza\")'>Notificar por correo</th>
		</tr>";
	}
	$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"t_fuerza\")'>";
	$formu.="
	<table id='rounded-corner'>
		$box
		<tr>
			<th>Toma de Fuerza</th>
			<th><div id='toma'></div>$btn_info</th>
		</tr>
		<tr>
			<td colspan='2'>
				<input type='checkbox' name='encendido1' id='encendido1'>Sensor activado
			</td>
		</tr>
		<tr>
			<td colspan='2'>
				<input type='checkbox' name='apagado1' id='apagado1'>Sensor apagado
			</td>
		</tr>
		<tr>
			<td>
				<input type='button' onclick='xajax_auditabilidad(94,$veh);xajax_obten_fuerza(".$veh.")' value='Obtener' class='agregar1'>
			</td>
			<td>
				<input type='button' onclick='xajax_auditabilidad(95,$veh);notifica_correo(\"fza\",$veh);' value='Guardar' class='agregar1'>
			</td>
		</tr>
	</table><hr>";
}
$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Cambio PDSR%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='3' align='right'>
			<input type='radio' id='enviar_correo_pdsr' onclick='xajax_mostrar_correo($folios[0],\"pdsr\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='3' align='right'>
				<input type='radio' id='enviar_correo_pdsr' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"pdsr\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='3' align='right'>
		<input type='radio' id='enviar_correo_pdsr' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"pdsr\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"pdsr\")'>";
$formu.="
<table id='rounded-corner'>
	$box
	<tr>
		<th colspan='1'><input type='radio' id='pdsr1' checked>Configuraciones de tipo de reporte</th>
		<th colspan='1' align='center'></th>
		<th colspan='1' align='center'><div id='pdsr'></div>$btn_info</th>
	</tr>
	<tr>
		<td>Modo</td>
		<td colspan='2'>
			<select id='pdsr_mode' onchange='pdsr()'>
				<option value='1'>Tiempo</option>
				<option value='2'>Distancia</option>
				<option value='8'>Rumbo</option>
				<option value='9'>Tiempo o rumbo</option>
				<option value='10'>Distancia o rumbo</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Tiempo</td>
		<td colspan='2'><input type='text' id='pdsr_time' >(minutos)</td>
	</tr>
	<tr>
		<td>Distancia</td>
		<td colspan='2'><input type='text' id='pdsr_distancia' disabled>(metros)</td>
	</tr>
	<tr>
		<td>Cambio de rumbo</td>
		<td colspan='2'><input type='text' id='pdsr_grados' disabled>°(grados)</td>
	</tr>
	<tr>
		<td id='los_botones' colspan='3'>
		<input type='button' class='guardar1' value='Obtener' onclick='xajax_auditabilidad(96,$veh);U1LITE(\"pdsr\",\"get\",\"\")'>
		<input type='button' class='guardar1' value='Guardar' onclick='xajax_auditabilidad(97,$veh);notifica_correo(\"pds\",$veh);
		U1LITE(\"pdsr\",\"set\",\"pdsr_mode@pdsr_time@pdsr_distancia@pdsr_grados\");
		alert(\"Al modificar el tipo de reporte, se puede ver reflejado en tu estado de cuenta\");'>
		</td>
	</tr>
</table><hr>
";

$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Sabotajes%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='2' align='right'>
			<input type='radio' id='enviar_correo_sab' onclick='xajax_mostrar_correo($folios[0],\"sab\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='2' align='right'>
				<input type='radio' id='enviar_correo_sab' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"sab\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='2' align='right'>
		<input type='radio' id='enviar_correo_sab' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"sab\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"sab\")'>";
$formu.="
<table id='rounded-corner'>
	$box
	<tr>
		<th colspan='1'><input type='radio' name='sabo' id='sabo1' checked>Sabotajes</th>
		<th colspan='1' align='center'><div id='sab'></div>$btn_info</th>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='checkbox' id='sabotaje'>Sabotaje de antena
		</td>
		<tr>
		<td colspan='2'>
			<input type='checkbox' id='voltaje'>Falla de voltaje en la alimentacion principal
		</td>
	</tr>
	</tr>
	<tr>
		<td id='los_botones' colspan='2'>
		<input type='button' class='guardar1' value='Obtener' onclick='xajax_auditabilidad(96,$veh);xajax_obten_sabotaje(".$veh.");'>
		<input type='button' class='guardar1' value='Guardar' onclick='xajax_auditabilidad(97,$veh);notifica_correo(\"sab\",$veh);'>
		</td>
	</tr>
</table><hr>
";
?>