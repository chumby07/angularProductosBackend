<?php

require_once('conexion.php');
$conn = open_connection();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

if(isset($_GET['regEmpleado'])){
    $datos = file_get_contents('php://input');
    $datos2 = json_decode($datos);
    save($datos2);
}

function save($datos2){

    $nombre = $datos2->nombre;
    $nit = $datos2->nit;
    $telefono = $datos2->telefono;
    $correo = $datos2->correo;

    $query="INSERT INTO empleados(nombre,nit,telefono,correo) VALUES('$nombre','$nit','$telefono','$correo')";
    $result = mysql_query($query) or die(mysql_error());
}


?>