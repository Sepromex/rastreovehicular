<?
include("librerias/conexion.php");
if (($gestor = fopen("egweb.csv", "r")) !== FALSE){
    while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
        $numero = count($datos);
		$insert="insert into catalogo_auditabilidad values($datos[0],$datos[1],'$datos[2]');";
		mysql_query($insert);
		echo mysql_error();
    }
    fclose($gestor);
}
echo "listo...";
?>