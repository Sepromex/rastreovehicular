<div id="menu_catalogo" align='center'>
	<ul id="nav1" class="drop1" >
		<li id="coches" class="current" title='Veh&iacute;culos' onclick="c_tipo(1,<?php echo (int)$idu?>,<?php echo $est?>);">
			<a href="javascript:void(null);" >Veh&iacute;culos</a>
		</li>
		<li id="sitInt" title='Sitios de inter&eacute;s' onclick="c_tipo(2,<?php echo $ide?>,<?php echo $est?>);">
			<a href="javascript:void(null);" >Sitios de inter&eacute;s</a>
		</li>
		<li id="geoCer"title='Geocercas' onclick="c_tipo(3,<?php echo $ide?>,<?php echo $est?>);">
			<a href="javascript:void(null);" >Geocercas</a>
		</li>
		<!-- PARTE CORRESPONDIENTE A USUARIOS -->
		<li id="usuarios" title='Usuarios' onclick="c_tipo(4,<?php echo $ide?>,<?php echo $est?>);">
			<a href="javascript:void(null);" >Usuarios</a>
		</li>
		<?
		$si = strstr($prm,"8");
		if(($est != 3) ||($est == 3 && !empty($si))){?>
			<li id="empresa" title='Mi empresa' onclick="c_tipo(5,<?php echo $ide?>,<?php echo $est?>);">
				<a href="javascript:void(null);" >Mi empresa</a>
			</li>
		<?
			}
		?>
		<li id="correos" title='Mis correos' onclick="c_tipo(6,<?php echo $ide?>,<?php echo $est?>);">
			<a href="#" >Mis correos</a>
		</li>
	</ul>
</div>