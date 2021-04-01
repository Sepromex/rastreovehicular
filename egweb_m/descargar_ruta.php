<?
$file=$_GET['archivo']; //file location
header('Content-Type: application/txt');
header('Content-Disposition: attachment; filename="'.basename($file).'"');
header('Content-Length: ' . filesize($file));
readfile($file);
?>