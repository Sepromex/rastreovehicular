<?php

$tiempo = 0;

for ($x = 0; $x < 500; $x++)
{
//variable que almacena los segundos totales
$tiempo+= 1;
//Para cada iteración 1 segundo
sleep(1);

echo "". $x + 1 ."<br>";

}
echo "tiempo completado: $tiempo segundos";


?>