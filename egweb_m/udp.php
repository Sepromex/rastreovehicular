<?php
$protocolo = 'icmp';
$obtener_prot = getprotobyname($protocolo);
if ($obtener_prot === FALSE) {
    echo 'Protocolo Inválido';
} else {
    echo 'Protocolo #' . $obtener_prot;
}
?>