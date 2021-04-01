<div id="conf_recorrido" style="position:absolute;top:20px;left:80px;width:1000px;">
		<ul id="nav1" class="drop1" >
			<li id="liga_rec" title='Reporte de recorrido' onclick="tipo(1,<?php echo (int)$ide; ?>,<?php echo (int)$idu; ?>);">
				<a href="javascript:void(null);" >Recorrido<img src='img2/recorrido.png' height='30'></a>
            </li>
			<li id='liga_ult' title='&Uacute;ltima posici&oacute;n' onclick="tipo(5,<?php echo (int)$ide; ?>,<?php echo (int)$idu; ?>);">
				<a href="javascript:void(null);" >&Uacute;ltima posici&oacute;n<img src='img2/final.png' height='30'></a>
			</li>
			<li id='tiempo_sin' title='Tiempo sin movimiento' onclick="tipo(2,<?php echo (int)$ide;?>,<?php echo (int)$idu; ?>);">
				<a href="javascript:void(null);" >Tiempo sin movimiento<img src='img2/tiempo.png' height='30'></a>
			</li>
		</ul>
	</div>  