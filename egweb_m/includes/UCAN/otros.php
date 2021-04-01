<?
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
			<input type='button' onclick='xajax_auditabilidad(93,$veh);notifica_correo(\"ost\",$veh);' value='Guardar' class='agregar1'>
		</td>
		<input type='hidden' name='id_veh' id='id_veh' value='".$veh."' >
	</tr>
</table><hr>";
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"ost\")'>";
$formu.="
<table id='rounded-corner'>
	<tr>
		<th colspan='2'>DTC</th>
		<th><div id='dtc'></div>$btn_info</th>
	</tr>
	<tr>
		<td colspan='2'><div id='datos'></div></td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='button' value='Obtener' class='agregar1' onclick='xajax_auditabilidad(104,$veh);UCAN(\"dtc\",\"get\",\"\")'>
		</td>
	</tr>
</table><hr>";
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"dtc\")'>";
$formu.="
<table id='rounded-corner' >
	<tr>
		<th>Fallas</th>
		<th><div id='fallas'></div>$btn_info</th>
	</tr>
	<tr>
		<td>Reportar Fallas</td>
		<td>
			Activado:<input type='radio' id='fallas1' name='fallas' value='activo'><br>
			Desactivado:<input type='radio' id='fallas2' name='fallas' value='desactivado'>
		</td>
	</tr>
	<tr>
		<td>Intervalo</td>
		<td>
			<div id='slider'>
				<input class='bar' type='range' id='i_hora' value='1' max='24' min='1' onchange='rangevalue.value=value'/>
				<span class='highlight'></span>
				<output id='rangevalue'>1</output> 
			</div>
		</td>
	</tr>
	<tr>
		<td><input type='button' value='Obtener' class='agregar1' onclick='xajax_auditabilidad(105,$veh);UCAN(\"fallas\",\"get\",\"\")'></td>
		<td><input type='button' value='Guardar' class='guardar1' onclick='xajax_auditabilidad(106,$veh);UCAN(\"fallas\",\"set\",\"i_hora\")'></td>
	</tr>
</table><hr>";
$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Accion de impacto%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='2' align='right'>
			<input type='radio' id='enviar_correo_imp' onclick='xajax_mostrar_correo($folios[0],\"impact\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='2' align='right'>
				<input type='radio' id='enviar_correo_imp' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"impact\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='2' align='right'>
		<input type='radio' id='enviar_correo_imp' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"impact\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"impact\")'>";
$formu.="
<table id='rounded-corner'>
	$box
	<tr>
		<th width='320'  style='text-align:left'>Sensor de impacto</th>
		<th colspan='2'><div id='impact'></div>$btn_info</th>
	</tr>
	<tr>
		<td>Activar:<input type='radio' name='simpacto' id='impact1'/></td>
		<td>Desactivar:<input type='radio' name='simpacto' id='impact0' /></td>
	</tr>
	<tr>
		<td colspan='1'>Fuerza:</td>
		<td colspan='2'>
			<div id='slider'>
				<input class='bar' type='range' id='fuerza' value='0' max='16' min='1' onchange='rangeF.value=value'/>
				<span class='highlight'></span>
				<output id='rangeF'>0</output> 
			</div>
		</td>
	</tr>
	<tr>
		<td colspan='3'>
			<input type='button' class='agregar1' value='Obtener' onclick='xajax_auditabilidad(90,$veh);UCAN(\"impact\",\"get\",\"\")'/>
			<input type='button' class='guardar1' value='Guardar' onclick='xajax_auditabilidad(91,$veh);notifica_correo(\"imp\",$veh);UCAN(\"impact\",\"set\",\"fuerza\")'/>
		</td>
	</tr>
</table><hr>";
$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Accion de sobrecalentamiento%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='2' align='right'>
			<input type='radio' id='enviar_correo_sob' onclick='xajax_mostrar_correo($folios[0],\"sobre_c\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='2' align='right'>
				<input type='radio' id='enviar_correo_sob' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"sobre_c\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='2' align='right'>
		<input type='radio' id='enviar_correo_sob' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"sobre_c\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"sobre_c\")'>";
$formu.="
<table id='rounded-corner'>
	$box
	<tr>
		<th>Sobrecalentamiento</th>
		<th><div id='calentamiento'></div>$btn_info</th>
	</tr>
	<tr>
		<td>Activar:<input type='radio' name='sobrec' id='calentamiento1'/></td>
		<td colspan='2'>Desactivar:<input type='radio' name='sobrec' id='calentamiento0' /></td>
	</tr>
	<tr>
		<td colspan='1'>Temperatura:</td>
		<td colspan='2'>
			<div id='slider'>
				<input class='bar' type='range' id='s_temp' value='20' max='215' min='-40' onchange='range.value=value'/>
				<span class='highlight'></span>
				<output id='range'>20</output> 
			</div>
		</td>
	</tr>
	<tr>
		<td colspan='1'>Minutos:</td>
		<td colspan='2'>
			<input type='text' id='s_tiempo' size='4' value='1'
			onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var tiempo = document.getElementById(\"s_tiempo\");
			var s = tiempo.value;
			var max = 65000;
			if(s<1){alert(\"No puede ser menor a 1 minuto \");tiempo.value=1; tiempo.focus();}
			if(s>max){alert(\"No puede ser mayor a 65000 minutos. \"); tiempo.value=max; tiempo.focus();}
			'
			>
		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='button' value='Obtener' class='agregar1' onclick='xajax_auditabilidad(107,$veh);UCAN(\"calentamiento\",\"get\",\"\")'>
			<input type='button' value='Guardar' class='agregar1' onclick='xajax_auditabilidad(108,$veh);notifica_correo(\"sob\",$veh);UCAN(\"calentamiento\",\"set\",\"s_temp@s_tiempo\")'>
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
	<th colspan='3' align='center'><div id='pdsr'></div></th>
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
		<input type='button' class='guardar1' value='Obtener' onclick='xajax_auditabilidad(96,$veh);UCAN\"pdsr\",\"get\",\"\")'>
		<input type='button' class='guardar1' value='Guardar' onclick='xajax_auditabilidad(97,$veh);notifica_correo(\"pds\",$veh);
		UCAN(\"pdsr\",\"set\",\"pdsr_mode@pdsr_time@pdsr_distancia@pdsr_grados\");
		alert(\"Al modificar el tipo de reporte, se puede ver reflejado en tu estado de cuenta\");'>
		</td>
	</tr>
</table>";
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