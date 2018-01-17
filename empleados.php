<?php

require_once 'Config.php';
require_once 'conexion.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

if(isset($_GET['empleados'])){
    listarEmpleados();
}elseif(isset($_GET['regEmpleados'])){
    $datos = file_get_contents('php://input');
    $datos2 = json_decode($datos);
    registrarEmpleados($datos2);
}

function listarEmpleados(){

    $empleados = array();
    $sth = DataBase::getInstance()->prepare("SELECT * FROM empleados");
    $sth->execute();

    $res = $sth->fetchAll();
    /*var_dump($sth);
    var_dump($res);*/

    foreach($res as $key => $value){

        $empleados[] = $value;
        //echo $value["nombre"];

    }

    echo json_encode($empleados);

}

function registrarEmpleados($datos){

    $correo = $datos->correo;
    $nombre = $datos->nombre;
    $nit = $datos->nit;
    $telefono = $datos->telefono;

    $sth = DataBase::getInstance()->prepare("INSERT INTO empleados (nombre, nit, telefono, correo) VALUES ('$nombre', '$nit', '$telefono', '$correo')");

    if($sth->execute()){
        echo "ok";
    }else{
        echo "false";
    }
}

?>