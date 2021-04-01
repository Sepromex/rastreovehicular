<?php

define('SITIO_DE_INTERES', 145);
define('GEOCERCA_POLIGONAL', 146);
define('GEOCERCA_CIRCULAR', 147);
define('ASIGNACION_GEOCERCA', 148);

class EGReplicador{
	$catalogo;
	$arrayDatos;
	
	function __construct($tipoCatalogo){
		$this->catalogo = $tipoCatalogo;
	}
	
	function imprimeCatalogo(){
		switch($this->catalogo){
			case SITIO_DE_INTERES:
				echo "SITIO DE INTERES";
				break;
			case GEOCERCA_POLIGONAL:
				echo "GEOCERCA POLIGONAL";
				break;
			case GEOCERCA_CIRCULAR:
				echo "GEOCERCA CIRCULAR";
				break;
			case ASIGNACION_GEOCERCA:
				echo "ASIGNACION GEOCERCA";
				break;		
		}		
	}
}
/*
class DatoEG{
	$tipoDato;
	$valor;
	
	function __construct($tipoDato,$valor){
		$this->tipoDato = $tipoDato;
		$this->valor = $valor;		
	}
	
	function getTipoDato(){
		return $this->tipoDato;
	}
	
	function getValor(){
		return $this->valor;
	}	
}*/

?>
